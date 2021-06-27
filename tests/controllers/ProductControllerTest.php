<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Controller\ProductController;

//todo put in a separate file
define('APP_PATH', realpath(__DIR__ . '/../../app'));
$config = require APP_PATH . '/config/app.php';
require APP_PATH . '/startup/services.php';

class ProductControllerTest extends TestCase
{
    public function testProducts()
    {
        $products = [
            ['title' => uniqid('test '), 'price' => rand(0, 10000) / 100],
            ['title' => uniqid('test_'), 'price' => rand(0, 10000) / 100],
            ['title' => uniqid('test.'), 'price' => rand(0, 10000) / 100]
        ];
        $addedProducts = [];
        foreach ($products as $product) {
            $controller = new ProductController($product);
            $addedProduct = $controller->addProductAction();
            $this->assertSame($addedProduct, ['id' => $addedProduct['id']] + $product);
            $addedProducts[] = $addedProduct;
        }

        $controller = new ProductController([]);
        $products = $controller->getProductsAction();
        $this->assertNotEmpty($products);
        $this->assertSame(array_reverse($addedProducts), $products);

        foreach ($products as $product) {
            $controller = new ProductController(['productId' => $product['id']]);
            $controller->deleteProductAction();
        }
        $products = $controller->getProductsAction();
        $this->assertNotSame(array_reverse($addedProducts), $products);
    }

    //todo add more tests
}