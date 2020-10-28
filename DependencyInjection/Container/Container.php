<?php


namespace Euro\DependencyInjection\Container;


interface Container
{
    function add($class);
    function get($class);
    function has($class): bool;
    function qualifier(string $class, string $qualifier);
}