<?php 

namespace App\Controllers;

use App\DI\Container;
use App\Log\FileLogger;
use App\Log\Interface\LoggerInterface;

class NotFoundController 
{
    function index() {
        $container = Container::getInstance();
        $logger = $container->make(LoggerInterface::class);
        echo "Page not found!Ops";
    }
}
