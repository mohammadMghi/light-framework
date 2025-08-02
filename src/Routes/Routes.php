<?php 

namespace App\Routes;

use App\Controllers\NotFoundController;

class Routes
{
    protected $routes = [];
    protected function addRoute($path, $method, $action, $middleware = null)
    {
        $this->routes[] = [
            'path' => $path,
            'method' => $method,
            'action' => $action,
            'middleware' => $middleware
        ]; 
    }
    
    public function POST($path , $action, $middleware = null)
    {
        $this->addRoute($path , 'POST' , $action, $middleware);
    }

    public function GET($path , $action, $middleware = null)
    {
        $this->addRoute($path , 'GET' , $action , $middleware);
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }
}



 
 