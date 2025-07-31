<?php 

namespace App\Routes;

use App\Controllers\NotFoundController;

class Routes
{
    protected $routes = [];
    protected function addRoute($path, $method, $action)
    {
        $this->routes[] = [
            'path' => $path,
            'method' => $method,
            'action' => $action
        ]; 
    }
    
    public function POST($path , $action)
    {
        $this->addRoute($path , 'POST' , $action);
    }

    public function GET($path , $action)
    {
        $this->addRoute($path , 'GET' , $action);
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }
}



 
 