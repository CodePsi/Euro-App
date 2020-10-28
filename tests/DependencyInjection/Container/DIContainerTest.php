<?php

namespace Euro\tests\DependencyInjection\Container;

use Euro\DependencyInjection\Container\DIContainer;
use Euro\DependencyInjection\Container\ServiceInjectionContainer;
use PHPUnit\Framework\TestCase;

class DIContainerTest extends TestCase
{

    public function testInitiateCoreContainer()
    {
        self::assertNotNull(DIContainer::initiateCoreContainer(ServiceInjectionContainer::class));
    }
}
