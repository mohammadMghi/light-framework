<?php 

namespace App\Middlewares;

class AdminMiddleware
{
    public function handle()
    {
        echo "</br>";
        echo "Admin middleware";
        echo "</br>";
    }
}