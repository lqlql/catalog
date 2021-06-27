<?php
declare(strict_types=1);

namespace Repository;

use Libs\DI;
use Model\CartModel;
use Model\ProductModel;
use Model\UserModel;

class CartRepository extends AbstractRepository
{
    public const UNIQUE_PRODUCT_MAX = 3;
    public const SAME_PRODUCT_MAX = 10;

    /**
     * @return int|null
     */
    public static function getUserCart(UserModel $user): ?CartModel
    {
        $sql = "select 
                    c.*
                from 
                    carts c
                where 
                    userId = :userId";
        /** @var \Pdo $pdo */
        $pdo = DI::service('mysql')->getConnection('read');
        $sth = $pdo->prepare($sql);
        $sth->execute(['userId' => $user->getId()]);
        $rows = $sth->fetchAll();
        $cart = new CartModel(['userId' => $user->getId()]);
        foreach ($rows as $row) {
            $cart->addProduct((int)$row['productId'], (int)$row['count']);
        }
        return $cart;
    }

    public static function removeProductFromCart(CartModel $cart, ProductModel $product): ?CartModel
    {
        $productCount = $cart->getProducts()[$product->getId()]['count'] ?? null;
        if (null === $productCount) {
            return $cart;
        }

    }

    public static function addProductToCart(CartModel $cart, ProductModel $product): CartModel
    {
        $sql = 'insert into carts
                    (userId, productId, count)
                values
                    (:userId, :productId, :count)
                on duplicate key update count = :count';
        /** @var \PDO $pdo */
        $pdo = DI::service('mysql')->getConnection('write');
        $sth = $pdo->prepare($sql);
        $sth->execute([
            'userId' => $cart->getUserId(),
            'productId' => $product->getId(),
            'count' => 1
        ]);
        $cart->addProduct($product->getId(), 1);
        return $cart;
    }

    public static function updateProductCountsInCart(CartModel $cart, ProductModel $product, int $count): CartModel
    {
        $sql = 'update carts set count = :count where userId = :userId and productId = :productId';
        /** @var \PDO $pdo */
        $pdo = DI::service('mysql')->getConnection('write');
        $sth = $pdo->prepare($sql);
        $sth->execute([
            'userId' => $cart->getUserId(),
            'productId' => $product->getId(),
            'count' => $count
        ]);
        $cart->addProduct($product->getId(), $count);
        return $cart;
    }

    /**
     * @param UserModel $user
     * delete product from all carts
     */
    public static function deleteProductFromAllCarts(ProductModel $product): void
    {
        $sql = "delete from carts where productId = :productId";
        /** @var \PDO $pdo */
        $pdo = DI::service('mysql')->getConnection('write');
        $sth = $pdo->prepare($sql);
        $sth->execute([
            'productId' => $product->getId()
        ]);
    }

    /**
     * @param UserModel $user
     * @param ProductModel $product
     */
    public static function deleteProductFromUserCart(CartModel $cart, ProductModel $product): void
    {
        $sql = "delete from carts where productId = :productId and userId = :userId";
        /** @var \PDO $pdo */
        $pdo = DI::service('mysql')->getConnection('write');
        $sth = $pdo->prepare($sql);
        $sth->execute([
            'userId' => $cart->getUserId(),
            'productId' => $product->getId()
        ]);
        $cart->removeProduct($product->getId());
    }

    public static function clearUserCart(UserModel $user): void
    {
        $sql = "delete from carts where userId = :userId";
        /** @var \PDO $pdo */
        $pdo = DI::service('mysql')->getConnection('write');
        $sth = $pdo->prepare($sql);
        $sth->execute([
            'userId' => $user->getId(),
        ]);
    }
}