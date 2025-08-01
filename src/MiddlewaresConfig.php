<?php

use App\Middlewares\AuthMiddleware;

$general_middlewares = [
    [AuthMiddleware::class , 'handle']
];