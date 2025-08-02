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
    
    public function bind(string $abstract, $concrete) {
        $this->bindings[$abstract] = $concrete;
    }

     public function make(string $class) {
        if (isset($this->bindings[$class])) {
            $concrete = $this->bindings[$class];

            if (is_callable($concrete)) {
                return $concrete();   
            }

            $class = $concrete;
        }

        return $this->resolve($class);
    }

    protected function resolve(string $class) {
        if (isset($this->bindings[$class])) {
            $concrete = $this->bindings[$class];

            if (is_callable($concrete)) {
                return $concrete($this);
            }

            $class = $concrete;
        }

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

            if (isset($this->bindings[$depClass])) {
                $concrete = $this->bindings[$depClass];

                if (is_callable($concrete)) {
                    $dependencies[] = $concrete($this);
                    continue;
                }

                $depClass = $concrete;
            }

            $dependencies[] = $this->resolve($depClass);
        }

        return $reflector->newInstanceArgs($dependencies);
    }
}
