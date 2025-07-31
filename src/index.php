<?php

use App\Controllers\NotFoundController;
use App\DI\Container;
use App\Log\FileLogger;
use App\Log\Interface\LoggerInterface;
use App\Routes\Api;
use App\Routes\Routes;

require __DIR__ . '/../vendor/autoload.php';


$route_found = false;

$uri = parse_url($_SERVER['REQUEST_URI'] , PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

$uri = rtrim($uri , '/');

$container = new Container;
$container->bind(LoggerInterface::class , FileLogger::class);

$api = new Api;

$routes = $api->register(); 
  
$routes = $routes->getRoutes();
  
foreach ($routes as $route) {  
    $path = rtrim($route['path'] , '/');
 
    if ($path === $uri && $route['method'] === $method) {
        call_user_func([$route['action'][0] , $route['action'][1]]);
        $route_found = true;
        break;
    }
}   

$notFoundController = new NotFoundController;
 
if(!$route_found) {
    call_user_func([new NotFoundController(), 'index']);
}