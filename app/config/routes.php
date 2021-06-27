<?php

return [
    'catalog' => [
        'controller' => 'ProductController',
        'action' => 'getProductsAction',
        'method' => 'GET',
        'description' => 'get products'
    ],
    'catalog/add/product' => [
        'controller' => 'ProductController',
        'action' => 'addProductAction',
        'method' => 'POST',
    ],
    'catalog/delete/product' => [
        'controller' => 'ProductController',
        'action' => 'deleteProductAction',
        'method' => 'DELETE',
    ],
    'catalog/update/product' => [
        'controller' => 'ProductController',
        'action' => 'updateProductAction',
        'method' => 'PUT'
    ],
    'cart' => [
        'controller' => 'CartController',
        'action' => 'getCartAction',
        'method' => 'GET'
    ],
    'cart/add/product' => [
        'controller' => 'CartController',
        'action' => 'addProductToCartAction',
        'method' => 'POST'
    ],
    'cart/remove/product' => [
        'controller' => 'CartController',
        'action' => 'removeProductFromCartAction',
        'method' => 'DELETE'
    ],
];
