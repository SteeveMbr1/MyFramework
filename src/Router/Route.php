<?php

namespace MyFramework\Router;

use Closure;
use MyFramework\Http\Request;
use MyFramework\Http\Response;

class Route
{

    protected array $flags = [
        0  => '.+',
        'c' => '.+',
        'd' => '\d+',
        'w' => '\w+',
    ];

    protected array $args;

    public function __construct(
        protected string $path,
        protected closure|array $action,
        protected ?string $name = null
    ) {
    }


    /**
     * Get the value of path
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set the value of path
     */
    public function setPath($path): self
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get the value of action
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Set the value of action
     */
    public function setAction($action): self
    {
        $this->action = $action;

        return $this;
    }

    /**
     * Get the value of name
     *
     * @return ?string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @param ?string $name
     *
     * @return self
     */
    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Try if the $path match with the given $uri
     * eg. `$path = /posts/{id:n}-{slug:c}` will match with `$uri = /post/22-Hello-World`.
     * 
     * If no flag have been specified, the `c` flag will be use as default, and it will catch every characters.
     * eg. `$path = /tags/{tag}` will match with `$uri = /tags/i-am-a-tag`
     * @param string $uri 
     * @return bool `true` if matched, otherwise `false`
     */
    public function isMatch(string $uri): bool
    {
        $pattern = $this->generate_pattern();
        if ($result = preg_match($pattern, $uri, $matches))
            $this->args = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
        return (bool)$result;
    }


    private function generate_pattern(): string
    {
        $path = $this->path;
        if (preg_match_all('#{(\w*):?(\w*)}#', $path, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $match) {
                [$search, $name, $flag] = $match;
                $flag = $flag ? $this->flags[$flag] : $this->flags[0];
                $replace = "(?<$name>$flag)";
                $path = str_replace($search, $replace, $path);
            }
        }
        return "#^$path$#";
    }

    public function __toString()
    {
        return "|{$this->name} \t| {$this->path} \t| " . print_r($this->action, true) . " \t|";
    }


    public function execute(Request $request): Response
    {
        [$controller, $method] = $this->action;

        if (is_string($controller))
            $controller = new $controller();

        $body =  call_user_func_array([$controller, $method], ['request' => $request, $this->args]);

        return new Response($body);
    }
}
