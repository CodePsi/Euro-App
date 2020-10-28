<?php


namespace Euro\DependencyInjection\Container;


use Euro\DependencyInjection\Service;
use Euro\Framework\Reflection\ReflectionClassWrapper;

class ServiceInjectionContainer implements Container
{
    private $services = [];

    function add($class)
    {
        return $services[$class] = new Service($class);
    }

    //No need for this for now
    function qualifier(string $class, string $qualifier)
    {
        // TODO: Implement qualifier() method.
    }

    function get($class)
    {
        return $this->services[$class] -> getObject();
    }

    function has($class): bool
    {
        return array_key_exists($class, $this->services);
    }
}