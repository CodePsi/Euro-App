<?php


namespace Euro\Route;


class NavigationGuards implements NavigationGuardsInterface
{
    public $routes;
    /**
     * @var \Closure
    */
    public $beforeEachAction;
    public $afterEachAction;

    public function __construct($routes)
    {
        $this->routes = $routes;
    }

    public function beforeEach(Route $to)
    {
        return $this -> beforeEachAction -> call($this, $to);
    }

    public function afterEach(\Closure $action)
    {
        // TODO: Implement afterEach() method.
    }
}