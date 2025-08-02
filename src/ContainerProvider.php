<?php 

namespace App;

use App\DI\Container;
use App\Http\Request;
use App\Log\FileLogger;
use App\Log\Interface\LoggerInterface;

class ContainerProvider
{
    public static function register(): Container
    {
        $container = new Container;
        $container->bind(LoggerInterface::class , FileLogger::class);
        $container->bind(Request::class, function() {
            return Request::capture();
        });
        return $container;
    }
}