<?php 

namespace App\Routes;

use App\Controllers\NotFoundController;
use App\Controllers\WellcomeController;

class Api
{
    public function register()
    {
        $routes = new Routes; 

        $routes->GET('/' ,[NotFoundController::class , 'index']);
        $routes->GET('/home/hello', [WellcomeController::class , 'index']);

        return $routes;
    }
}
