<?php
declare(strict_types=1);

use Libs\DI;
use PHPUnit\Framework\TestCase;

class RoutingTest extends TestCase
{
    public function testRoutes()
    {
        $routes = DI::service("routes");
        foreach ($routes as $route) {
            $controller = 'Controller\\' . $route['controller'];
            $this->assertTrue(class_exists($controller));
            $this->assertTrue(method_exists($controller, $route['action']));
        }
    }
}