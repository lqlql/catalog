<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

//todo put in a separate file
define('APP_PATH', realpath(__DIR__ . '/../../app'));
$config = require APP_PATH . '/config/app.php';
require APP_PATH . '/startup/services.php';

class RoutingTest extends TestCase
{
    public function testRoutes()
    {
        $routes = require APP_PATH . '/config/routes.php';
        foreach ($routes as $route) {
            $controller = 'Controller\\' . $route['controller'];
            $this->assertTrue(class_exists($controller));
            $this->assertTrue(method_exists($controller, $route['action']));
        }
    }
}