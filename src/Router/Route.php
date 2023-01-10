<?php

namespace MyFramework\Router;

class Route
{

    //TODO: 
    protected static array $routes;

    /**
     * 
     * @param string $method 
     * @param string $path 
     * @param string|array $callable 
     * @param (null|array)|null $args 
     * @param string $name 
     * @return mixed 
     */
    public static function add(string $method, string $path, callable|string|array $callable, ?array $args = null, string $name = '')
    {
        $name = $name ?: ($method . $path);
        echo $name . "\n";
        self::$routes[$method][$name] = [$callable, $args];
    }

    public static function dumpRoutes()
    {
        print_r(self::$routes);
    }
}
