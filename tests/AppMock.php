<?php

class AppMock
{
    static $app;

    public static function instance()
    {
        return static::$app ?? static::$app = Mockery::mock(new static);
    }
}

if (!function_exists('app')) {
    function app() {
        return AppMock::instance();
    }
}
