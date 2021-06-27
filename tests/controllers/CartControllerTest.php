<?php
declare(strict_types=1);

use Controller\ProductController;
use Model\UserModel;
use PHPUnit\Framework\TestCase;
use Controller\CartController;
use Repository\CartRepository;


//todo put in a separate file
define('APP_PATH', realpath(__DIR__ . '/../../app'));
$config = require APP_PATH . '/config/app.php';
require APP_PATH . '/startup/services.php';

class CartControllerTest extends TestCase
{
    private const TEST_USER_ID = 1;

    public function testCart()
    {
        $user = new UserModel(['id' => static::TEST_USER_ID]);
        CartRepository::clearUserCart($user);
        $controller = new CartController([]);
        $cart = $controller->getCartAction();
        $this->assertEmpty($cart['products']);

        $controller = new ProductController(['title' => uniqid('test '), 'price' => rand(0, 10000) / 100]);
        $addedProduct = $controller->addProductAction();

        $controller = new CartController(['productId' => $addedProduct['id']]);
        $controller->addProductToCartAction();
        $controller->addProductToCartAction();
        $cart = $controller->getCartAction();
        $this->assertSame($cart['products'][0]['id'], $addedProduct['id']);
        $this->assertSame($cart['products'][0]['count'], 2);
        $this->assertSame($cart['price'], $addedProduct['price'] * 2);

        $controller->removeProductFromCartAction();
        $controller->removeProductFromCartAction();
        $cart = $controller->getCartAction();
        $this->assertEmpty($cart['products']);

        $controller = new ProductController(['productId' => $addedProduct['id']]);
        $controller->deleteProductAction();
    }

    //todo add more tests
}