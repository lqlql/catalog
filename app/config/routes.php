<?php

return [
    'api/catalog' => [
        'controller' => 'ProductController',
        'action' => 'getProductsAction',
        'method' => 'GET',
        'description' => 'get products'
    ],
    'api/catalog/add/product' => [
        'controller' => 'ProductController',
        'action' => 'addProductAction',
        'method' => 'POST',
    ],
    'api/catalog/delete/product' => [
        'controller' => 'ProductController',
        'action' => 'deleteProductAction',
        'method' => 'DELETE',
    ],
    'api/catalog/update/product' => [
        'controller' => 'ProductController',
        'action' => 'updateProductAction',
        'method' => 'PUT'
    ],
    'api/cart' => [
        'controller' => 'CartController',
        'action' => 'getCartAction',
        'method' => 'GET'
    ],
    'api/cart/add/product' => [
        'controller' => 'CartController',
        'action' => 'addProductToCartAction',
        'method' => 'POST'
    ],
    'api/cart/remove/product' => [
        'controller' => 'CartController',
        'action' => 'removeProductFromCartAction',
        'method' => 'DELETE'
    ],
];
