<?php

namespace MyFramework\Router;

class Router
{

    //TODO: 
    protected static array $routes;

    /**
     * 
     * @param string $method 
     * @param string $path 
     * @param string|array $target 
     * @param (null|array)|null $args 
     * @param string $name 
     * @return mixed 
     */
    public static function add(string $method, string $path, callable|string|array $target, ?array $args = null, ?string $name = null): static
    {
        $name = $name ?? ($method . $path);
        self::$routes[$method][$name] = compact('method', 'name', 'path', 'target', 'args');
        return new static;
    }

    public static function dumpRoutes()
    {
        print_r(self::$routes);
    }

    public static function getNamed(string $name): array|null
    {
        foreach (self::$routes as $routes) {
            if (array_key_exists($name, $routes))
                return $routes[$name];
        }
        return null;
    }

    public static function generate(string $name, ?array $args = null): string|null
    {
        if (($route = static::getNamed($name)) == null) {
            return null;
        }
        $path = $route['path'];
        if ($args != null)
            foreach ($args as $key => $value) {
                $path = str_replace("{{$key}}", $value, $path);
            }
        return $path;
    }

    public static function match(string $request): array|null
    {
        //TODO
    }
}
