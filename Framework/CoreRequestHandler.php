<?php


namespace Euro\Framework;


use Euro\Framework\Controller\ControllerResolver;

class CoreRequestHandler implements Handler
{
    private $controllerResolver;
    public function __construct(ControllerResolver $controllerResolver)
    {
        $this->controllerResolver = $controllerResolver;
    }

    function handle(): void
    {

    }
}