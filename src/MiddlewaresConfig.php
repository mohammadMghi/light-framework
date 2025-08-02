<?php

use App\Middlewares\AdminMiddleware;
use App\Middlewares\AuthMiddleware;

$general_middlewares = [
    [AuthMiddleware::class]
];

$request_middlewares = [
    [AdminMiddleware::class]
];