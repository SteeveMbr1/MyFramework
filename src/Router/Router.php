<?php

namespace MyFramework\Router;

use MyFramework\Router\Route;
use MyFramework\Http\Request;
use MyFramework\Http\Response;

class Router
{
    /**
     * 
     * @var Route[][]
     */
    protected array $routes;

    /**
     * 
     * @param string $method 
     * @param string $path 
     * @param callable|array|string $action 
     * @param null|string $name 
     * @return void 
     */
    protected function add(string $method, string $path, callable|array|string $action, ?string $name = null): void
    {
        $name = $name ?? ($method . '.' . $path);
        $this->routes[$method][] = new Route($path, $action, $name);
    }

    /**
     * 
     * @param string $path 
     * @param callable|array $action 
     * @param null|string $name 
     * @return Router 
     */
    public function get(string $path, callable|array $action, ?string $name = null): self
    {
        $this->add('GET', $path, $action, $name);
        return $this;
    }

    /**
     * 
     * @param string $path 
     * @param callable|array $action 
     * @param null|string $name 
     * @return Router 
     */
    public function post(string $path, callable|array $action, ?string $name = null): self
    {
        $this->add('POST', $path, $action, $name);
        return $this;
    }

    /**
     * 
     * @param string $method 
     * @param string $uri 
     * @return null|Route 
     */
    protected function match(string $method, string $uri): ?Route
    {
        foreach ($this->routes[$method] as $route) {
            if ($route->isMatch($uri))
                return $route;
        }
        return null;
    }

    /**
     * 
     * @param Request $request 
     * @param Response $response 
     * @return Response 
     */
    public function handle(Request &$request): Response
    {
        $method = $request->getMethod();
        $uri = $request->getURI();

        $route = $this->match($method, $uri);
        if (!$route)
            return (new Response())->setStatusCode(404)
                ->setBody("<body><h1>Page not found :(</h1></body>");

        return $route->execute($request);
    }

    /**
     * Return the route named `$name`
     * @param string $name
     * @return Route or Null if not found
     */
    public function getRoute(string $name)
    {
        foreach ($this->routes as $routes) {
            foreach ($routes as $route) {
                if ($name == $route->getName())
                    return $route;
            }
        }
        return null;
    }


    /**
     * Generate the url for the route named `$name`
     * @param $name, the route name
     * @param $args, the argument needed by the method controller
     * @return string, the url
     */
    public function path(string $name, array $args = [])
    {
        // TODO :
    }
}
