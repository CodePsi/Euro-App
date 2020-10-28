<?php

namespace Euro\Framework\Controller;

use PHPUnit\Framework\TestCase;

class ControllerResolverTest extends TestCase
{

    public function testGetController()
    {
        $test = new ControllerResolver();
        var_dump($test -> getController("UserController::test"));
    }
}
