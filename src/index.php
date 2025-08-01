<?php

use App\Controllers\NotFoundController;
use App\DI\Container;
use App\Http\Request;
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

$api = new Api;

$routes = $api->register(); 
  
$routes = $routes->getRoutes();
  
foreach ($routes as $route) {  
    $path = rtrim($route['path'] , '/');
  
    middlewareCaller((array)$general_middlewares);
    if ($path === $uri && $route['method'] === $method) {
        call_user_func([new $route['action'][0] , $route['action'][1]]);
        $route_found = true;
        break;
    }
}   

function middlewareCaller($general_middlewares)
{  
    foreach ($general_middlewares as $middleware)
    {
       call_user_func([new $middleware[0] , $middleware[1]]);
    }
}

$notFoundController = new NotFoundController;
 
if(!$route_found) {
    call_user_func([new NotFoundController(), 'index']);
}