<?php

namespace App\DI;

use Exception;
use ReflectionClass;
use ReflectionNamedType;

class Container {
    protected array $bindings = [];
    protected static ?Container $instance = null;

    public static function getInstance(): Container {
        if (self::$instance === null) {
            self::$instance = new Container();
        }
        return self::$instance;
    }
    
    public function bind(string $abstract, string $concrete) {
        $this->bindings[$abstract] = $concrete;
    }

    public function make(string $class) {
        return $this->resolve($class);
    }

    protected function resolve(string $class) {
        $reflector = new ReflectionClass($class);

        if (! $reflector->isInstantiable()) {
            throw new Exception("Class [$class] is not instantiable.");
        }

        $constructor = $reflector->getConstructor();

        if (! $constructor) {
            return new $class;
        }

        $params = $constructor->getParameters();
        $dependencies = [];

        foreach ($params as $param) {
            $type = $param->getType();

            if (! $type || $type->isBuiltin()) {
                throw new Exception("Cannot resolve dependency [{$param->name}]");
            }

            $depClass = $type->getName();
 
            $depClass = $this->bindings[$depClass] ?? $depClass;

            $dependencies[] = $this->resolve($depClass);
        }

        return $reflector->newInstanceArgs($dependencies);
    }
}
