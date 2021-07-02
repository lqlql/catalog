<?php

return [
    'application' => [
        'env' => 'development'
    ],
    'database' => [
        'mysql' => [
            'connections' => [
                'read' => [
                    'nodes' => [
                        ['host' => 'mysql', 'port' => '3306'],
                    ],
                    'username' => 'root',
                    'password' => 'root',
                    'dbname' => 'catalog',
                    'charset' => 'utf8mb4',
                ],
                'write' => [
                    'nodes' => [
                        ['host' => 'mysql', 'port' => '3306'],
                    ],
                    'username' => 'root',
                    'password' => 'root',
                    'dbname' => 'catalog',
                    'charset' => 'utf8mb4',
                ],
            ],
        ],
    ],
];