<?php 

namespace App;

use App\DI\Container;

class MiddlewareCaller
{
    public static function call($middlewares ,Container $container)
    {
        foreach ($middlewares as $middleware)
        {
        $middleware = $container->make($middleware[0]);
        call_user_func([$middleware , 'handle']);
        }
    }
}

