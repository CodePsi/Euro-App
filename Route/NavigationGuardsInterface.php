<?php


namespace Euro\Route;


interface NavigationGuardsInterface
{
    public function beforeEach(Route $to);
    public function afterEach(\Closure $action);
}