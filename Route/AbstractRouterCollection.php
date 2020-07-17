<?php


namespace Euro\Route;


abstract class AbstractRouterCollection implements RouterCollectionInterface
{
    /**
     * @var array
     */
    public $routes = [];

    public function add($element): void
    {
        array_push($this->routes, $element);
    }

    function addAll($elements): void
    {
        $this->routes = array_merge($this->routes, $elements);
    }

    function contains($element): bool
    {
        return in_array($element, $this->routes);
    }

    function get($index)
    {
        return $this->routes[$index];
    }

    function indexOf($element)
    {
        return array_keys($this->routes, $element)[0];
    }

    function remove($element)
    {
        unset($this->routes[$this->indexOf($element)]);
    }

    function size(): int
    {
        return count($this->routes);
    }

    /**
     * @return array
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }


}