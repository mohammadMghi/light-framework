<?php 

namespace App\Controllers;

use App\DI\Container;
use App\Http\Request;
use App\Http\RequestInterface;
use App\Log\FileLogger;
use App\Log\Interface\LoggerInterface;

class NotFoundController 
{
    protected Request $request;
    public function __construct(Request $request)
    { 
        $this->request = $request;
    }
    function index() {
        echo $this->request->method();
        $container = Container::getInstance();
        $logger = $container->make(FileLogger::class);
        echo "Page not found!Ops";
    }
}
