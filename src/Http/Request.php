<?php

namespace MyFramework\Http;

class Request
{

    protected ?array $vars = null;

    public function __construct()
    {
        $this->vars = array_merge($_SERVER, $_REQUEST, $_COOKIE);
    }

    public function get(string $name): mixed
    {
        if (isset($this->vars[$name]))
            return $this->vars[$name];
        return null;
    }

    public function set(string $name, mixed $value): self
    {
        $this->vars[$name] = $value;
        return $this;
    }

    public function getCookie(string $name = null)
    {
        if ($name && isset($_COOKIE[$name])) {
            return $_COOKIE[$name];
        }
        return null;
    }

    public function getMethod(): string
    {
        return $this->get('REQUEST_METHOD');
    }

    public function getURI(): string
    {
        return $this->get('REQUEST_URI');
    }
}
