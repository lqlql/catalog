<?php
declare(strict_types=1);

namespace Repository;

use Libs\DI;
use Model\ProductModel;


class ProductRepository extends AbstractRepository
{
    private const DEFAULT_LIMIT = 3;
    private const DELETED_PRODUCT = 1;

    /**
     * @param int $id
     * @return ProductModel|null
     */
    public static function getById(int $id): ?ProductModel
    {
        $sql = "select 
                    p.*
                from 
                    products p
                where 
                    productId = :productId
                limit 1";
        /** @var \Pdo $pdo */
        $pdo = DI::service('mysql')->getConnection('read');
        $sth = $pdo->prepare($sql);
        $sth->execute(['productId' => $id]);
        $row = $sth->fetch();
        return $row ? new ProductModel($row) : null;
    }

    /**
     * @param array $ids
     * @return array
     */
    public static function getByIds(array $ids): array
    {
        $result = [];
        foreach ($ids as $key => $id) {
            $ids[$key] = (int)$id;
        }
        $sql = "select 
                    p.*
                from 
                    products p
                where 
                    productId in ('" . implode("','", $ids) . "')";
        /** @var \Pdo $pdo */
        $pdo = DI::service('mysql')->getConnection('read');
        $sth = $pdo->query($sql);
        $rows = $sth->fetchAll();
        foreach ($rows as $row) {
            $result[(int)$row['productId']] = new ProductModel($row);
        }
        return $result;
    }

    /**
     * @param array $params
     * @return array
     */
    public static function getAll(array $params = []): array
    {
        $insertData = [
            'isDeleted' => static::DELETED_PRODUCT,
        ];
        ($params['lastId'] ?? null) && $insertData['lastId'] = (int)$params['lastId'];
        $limit = $params['limit'] ?? static::DEFAULT_LIMIT;

        $where = ' where isDeleted != :isDeleted ';
        ($insertData['lastId'] ?? null) && $where .= ' and p.productId < :lastId '; //pagination by id

        $result = [];
        $sql = "select 
                    p.*
                from 
                    products p
                " . $where . "
                order by p.productId desc
                limit " . (int)$limit;
        /** @var \Pdo $pdo */
        $pdo = DI::service('mysql')->getConnection('read');
        $sth = $pdo->prepare($sql);
        $sth->execute($insertData);
        $rows = $sth->fetchAll();
        foreach ($rows as $row) {
            $result[] = new ProductModel($row);
        }
        return $result;
    }

    /**
     * @param array $params
     * @return ProductModel|null
     */
    public static function addNewProduct(array $params): ?ProductModel
    {
        $insertData = [
            'title' => (string)$params['title'],
            'price' => (int)$params['price'],
            'isDeleted' => 0,
        ];
        $sql = 'insert into products 
                  (title, price, createdDt, updatedDt, isDeleted)
                values 
                  (:title, :price, unix_timestamp(), unix_timestamp(), isDeleted)
                on duplicate key update 
                    updatedDt = unix_timestamp(), price = :price, isDeleted = 0';
        /** @var \PDO $pdo */
        $pdo = DI::service('mysql')->getConnection('write');
        $sth = $pdo->prepare($sql);
        $sth->execute($insertData);
        if (!$insertData['productId'] = (int)$pdo->lastInsertId()) {
            return null;
        }
        return new ProductModel($insertData);
    }

    /**
     * @param ProductModel $product
     * @return ProductModel
     */
    public static function saveProduct(ProductModel $product): ProductModel
    {
        $insertData = [
            'title' => $product->getTitle(),
            'price' => $product->getPrice(),
            'isDeleted' => $product->getIsDeleted(),
            'productId' => $product->getId(),
        ];
        /** @var \PDO $pdo */
        $pdo = DI::service('mysql')->getConnection('write');
        $sql = 'update products set
                    title = :title, price = :price, updatedDt = unix_timestamp(), isDeleted = :isDeleted
                where productId = :productId';
        $sth = $pdo->prepare($sql);
        $sth->execute($insertData);
        return $product;
    }
}