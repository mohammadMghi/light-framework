<?php 

namespace App\Routes;

use App\Controllers\NotFoundController;
use App\Controllers\WellcomeController;

class Api
{
    public function register()
    {
        $routes = new Routes; 

        $routes->GET('/' ,[new NotFoundController() , 'index']);
        $routes->GET('/home/hello', [new WellcomeController() , 'index']);

        return $routes;
    }
}
