<?php 

namespace App\Http;

interface RequestInterface
{
   public static function capture() : self;
   
   public function input(string $key, $default = null);

   public function all();

   public function method();

   public function isMethod(string $method);

   public function header(string $key, $default = null);

   public function file(string $key);

   public function uri();
}