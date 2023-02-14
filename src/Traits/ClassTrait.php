<?php

namespace MyFramework\Traits;

trait ClassTrait
{
    public static function namespace(): string
    {
        return substr_replace(static::class, '', strrpos(static::class, '\\'));
    }

    public static function class(): string
    {
        return str_replace(static::namespace() . '\\', '', static::class);
    }
}
