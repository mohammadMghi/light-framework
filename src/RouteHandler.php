<?php 

namespace App;

use App\Controllers\NotFoundController;
use App\DI\Container;

class RouteHandler
{
    public static function handle(Container $containerPorvider,$uri,$routes,$general_middlewares,$method)
    {
        foreach ($routes as $route) {  
            $path = rtrim($route['path'] , '/');
            MiddlewareCaller::call((array)$general_middlewares,$containerPorvider);
            if ($path === $uri && $route['method'] === $method) {
                if($route['middleware'] != null)
                {
                    call_user_func(new $route['middleware'] , 'handle');
                }
                $controller = $containerPorvider->make($route['action'][0]);
                $method =  $route['action'][1];
                call_user_func([$controller, $method]);
                $route_found = true;
                break;
            }
        }   
        

        $notFoundController = $containerPorvider->make(NotFoundController::class);
        
        if(!$route_found) {
            call_user_func([$containerPorvider->make(NotFoundController::class), 'index']);
        }
    }
}