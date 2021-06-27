<?php
declare(strict_types=1);

namespace Controller;

use InvalidArgumentException;
use Repository\CartRepository;
use Repository\ProductRepository;
use Libs\Util\Price;

class ProductController extends AbstractController
{
    /**
     * @return array
     */
    public function getProductsAction(): array
    {
        $result = [];
        $params = [
            'lastId' => $this->params['lastId'] ?? null,
        ];
        $products = ProductRepository::getAll($params);
        foreach ($products as $product) {
            $result[] = [
                'id' => $product->getId(),
                'title' => $product->getTitle(),
                'price' => Price::toFloat($product->getPrice()),
            ];
        }
        return $result;
    }

    /**
     * @return array
     */
    public function addProductAction(): array
    {
        //todo add checking auth and role
        $params = $this->params;
        foreach ($params as $key => $val) {
            if (!in_array($key, ['title', 'price'])) {
                throw new InvalidArgumentException('wrong.params');
            }
        }
        $params['price'] = Price::toInt((float)$params['price']);
        $product = ProductRepository::addNewProduct($params);
        if (!$product) {
            return [];
        }
        return [
            'id' => $product->getId(),
            'title' => $product->getTitle(),
            'price' => Price::toFloat($product->getPrice()),
        ];
    }

    /**
     * @return array
     */
    public function updateProductAction(): array
    {
        //todo add checking auth and role
        $productId = $this->params['productId'] ?? null;
        if (!$productId || !$product = ProductRepository::getById((int)$productId)) {
            throw new InvalidArgumentException('product.not.found');
        }
        foreach ($this->params as $idx => $item) {
            switch ($idx) {
                case 'title':
                    $product->setTitle((string)$item);
                    break;
                case 'price':
                    $product->setPrice(Price::toInt((float)$item));
                    break;
            }
        }
        ProductRepository::saveProduct($product);
        return [
            'id' => $product->getId(),
            'title' => $product->getTitle(),
            'price' => Price::toFloat($product->getPrice()),
        ];
    }

    /**
     * @return array
     */
    public function deleteProductAction(): array
    {
        //todo add checking auth and role
        $productId = $this->params['productId'] ?? null;
        if (!$productId || !$product = ProductRepository::getById((int)$productId)) {
            throw new InvalidArgumentException('product.not.found');
        }
        $product->setIsDeleted(1);
        ProductRepository::saveProduct($product);
        CartRepository::deleteProductFromAllCarts($product);
        return [];
    }

}