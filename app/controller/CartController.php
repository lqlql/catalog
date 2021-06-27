<?php
declare(strict_types=1);

namespace Controller;

use Libs\Util\Price;
use Model\CartModel;
use Repository\CartRepository;
use Repository\ProductRepository;

class CartController extends AbstractController
{
    /**
     * @return array
     */
    public function getCartAction(): array
    {
        //@todo check auth
        $user = $this->user;
        $cart = CartRepository::getUserCart($user);
        return static::prepareCart($cart);
    }

    /**
     * @return array
     * create cart by adding product or increase product counter
     */
    public function addProductToCartAction(): array
    {
        //@todo check auth
        $user = $this->user;
        $productId = $this->params['productId'] ?? null;
        if (!$productId || !$product = ProductRepository::getById((int)$productId)) {
            throw new \InvalidArgumentException('product.not.found');
        }
        $cart = CartRepository::getUserCart($user);
        //validation cart size
        $uniqueProductsCount = count($cart->getProducts());
        $sameProductCount = $cart->getProducts()[$product->getId()]['count'] ?? 0;
        if (0 === $sameProductCount) {
            if ($uniqueProductsCount >= CartRepository::UNIQUE_PRODUCT_MAX) {
                throw new \InvalidArgumentException('products.in.cart.limit');
            }
            CartRepository::addProductToCart($cart, $product);
        } else {
            if ($sameProductCount >= CartRepository::SAME_PRODUCT_MAX) {
                throw new \InvalidArgumentException('product.count.limit');
            }
            CartRepository::updateProductCountsInCart($cart, $product, ++$sameProductCount);
        }
        return static::prepareCart($cart);
    }

    /**
     * @return array
     * decrease product counter or remove from cart
     */
    public function removeProductFromCartAction(): array
    {
        //@todo check auth
        $user = $this->user;
        $productId = $this->params['productId'] ?? null;
        if (!$productId || !$product = ProductRepository::getById((int)$productId)) {
            throw new \InvalidArgumentException('product.not.found');
        }
        $cart = CartRepository::getUserCart($user);
        $sameProductCount = $cart->getProducts()[$product->getId()]['count'] ?? 0;
        if ($sameProductCount > 1) {
            CartRepository::updateProductCountsInCart($cart, $product, --$sameProductCount);
        }
        if (1 === $sameProductCount) {
            CartRepository::deleteProductFromUserCart($cart, $product);
        }
        return static::prepareCart($cart);
    }

    /**
     * @param CartModel $cart
     * @return array
     */
    private static function prepareCart(?CartModel $cart): array
    {
        $result = [
            'products' => [],
            'price' => 0,
        ];
        if (!$cart) {
            return $result;
        }
        $products = [];
        $productsIds = array_keys($cart->getProducts());
        $productsIds && $products = ProductRepository::getByIds($productsIds);
        foreach ($products as $product) {
            $productCount = $cart->getProducts()[$product->getId()]['count'];
            $result['products'][] = [
                'id' => $product->getId(),
                'title' => $product->getTitle(),
                'price' => Price::toFloat($product->getPrice()),
                'count' => $productCount,
            ];
            $result['price'] += $productCount * $product->getPrice();
        }
        $result['price'] = Price::toFloat($result['price']);
        return $result;
    }

}