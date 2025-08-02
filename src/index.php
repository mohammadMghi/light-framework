<?php

use App\ContainerProvider;
use App\Controllers\NotFoundController;
use App\DI\Container;
use App\Http\Request;
use App\Http\RequestInterface;
use App\Log\FileLogger;
use App\Log\Interface\LoggerInterface;
use App\MiddlewareCaller;
use App\RouteHandler;
use App\Routes\Api; 

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/MiddlewaresConfig.php';

$route_found = false;

$request = Request::capture();

$uri = $request->uri();
$method = $request->method();

$uri = rtrim($uri , '/');

$containerPorvider = ContainerProvider::register();

$api = new Api;

$routes = $api->register(); 
  
$routes = $routes->getRoutes(); 
  
RouteHandler::handle($containerPorvider,$uri,$routes,$general_middlewares,$method);