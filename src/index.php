<?php

use App\Controllers\NotFoundController;
use App\DI\Container;
use App\Http\Request;
use App\Http\RequestInterface;
use App\Log\FileLogger;
use App\Log\Interface\LoggerInterface;
use App\Routes\Api; 

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/MiddlewaresConfig.php';

$route_found = false;

$request = Request::capture();

$uri = $request->uri();
$method = $request->method();

$uri = rtrim($uri , '/');

$container = new Container;
$container->bind(LoggerInterface::class , FileLogger::class);
$container->bind(Request::class, function() {
    return Request::capture();
});

$api = new Api;

$routes = $api->register(); 
  
$routes = $routes->getRoutes(); 
  
foreach ($routes as $route) {  
    $path = rtrim($route['path'] , '/');
  
    callMiddleware((array)$general_middlewares);
    if ($path === $uri && $route['method'] === $method) {
        if($route['middleware'] != null)
        {
            call_user_func(new $route['middleware'] , 'handle');
        }
        $controller = $container->make($route['action'][0]);
        $method =  $route['action'][1];
        call_user_func([$controller, $method]);
        $route_found = true;
        break;
    }
}   

function callMiddleware($general_middlewares)
{  
    foreach ($general_middlewares as $middleware)
    {
       call_user_func([new $middleware[0] , $middleware[1]]);
    }
}

$notFoundController = $container->make(NotFoundController::class);
 
if(!$route_found) {
    call_user_func([$container->make(NotFoundController::class), 'index']);
}