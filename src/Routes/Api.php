<?php 

namespace App\Routes;

use App\Controllers\NotFoundController;
use App\Controllers\WellcomeController;
use App\Middlewares\AuthMiddleware;

class Api
{
    public function register()
    {
        $routes = new Routes; 

        $routes->GET('/' ,[NotFoundController::class , 'index']);
        $routes->GET('/home/hello', [WellcomeController::class , 'index'] ,AuthMiddleware::class);

        return $routes;
    }
}
