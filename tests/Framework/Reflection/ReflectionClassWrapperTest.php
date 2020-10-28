<?php

namespace Euro\tests\Framework\Reflection;

use Euro\DependencyInjection\Container\Container;
use Euro\DependencyInjection\Container\ServiceInjectionContainer;
use Euro\Framework\Handler;
use Euro\Framework\Reflection\ReflectionClassWrapper;
use PHPUnit\Framework\TestCase;

class ReflectionClassWrapperTest extends TestCase
{

    public function testHasReflectionClassTheInterface()
    {
        self::assertTrue(true);
        self::assertFalse(ReflectionClassWrapper::hasReflectionClassTheInterface(
            ReflectionClassWrapper::initiateClass(
                ServiceInjectionContainer::class),
            Handler::class));
        self::assertTrue(ReflectionClassWrapper::hasReflectionClassTheInterface(
            ReflectionClassWrapper::initiateClass(
                ServiceInjectionContainer::class),
            Container::class));
    }
}
