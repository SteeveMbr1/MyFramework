<?php

namespace MyFramework\Http;

class Request
{

    protected static ?array $vars = null;

    public function __construct()
    {
        self::init();
    }

    public static function init(): void
    {
        if (!self::$vars)
            self::$vars = array_merge($_SERVER, $_REQUEST, $_COOKIE);
    }

    public function __get(string $name)
    {
        return self::get($name);
    }

    public static function get(string $name)
    {
        self::init();
        if (isset(self::$vars[$name]))
            return self::$vars[$name];
        return null;
    }

    public function getCookie(string $name = null)
    {
        if ($name && isset($_COOKIE[$name])) {
            return $_COOKIE[$name];
        }
        return null;
    }
}
