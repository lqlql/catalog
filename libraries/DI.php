<?php

namespace Libs;

use \DI\Container;

class DI extends Container
{
    private static $container = null;
    private static $services = [];

    public static function init(Container $container): void
    {
        self::$container = $container;
    }

    public static function service($name)
    {
        return self::$services[$name] ?? (self::$services[$name] = self::$container->get($name));
    }
}