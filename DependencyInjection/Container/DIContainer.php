<?php


namespace Euro\DependencyInjection\Container;


use Euro\Framework\Reflection\ReflectionClassWrapper;

class DIContainer
{
    private static $container = null;

    public static function getContainerInstance(string $container) {
        if (self::$container === null)
            return self::initiateCoreContainer($container);

        return self::$container;
    }

    public static function initiateCoreContainer(string $container) {
        return self::$container = self::initiateContainer($container);
    }

    private static function initiateContainer(string $container) {
        if (class_exists($container)) {
            $reflectionClass = ReflectionClassWrapper::initiateClass($container);
            if (ReflectionClassWrapper::hasReflectionClassTheInterface($reflectionClass, Container::class)) {
                return $reflectionClass -> newInstanceWithoutConstructor();
            }
        }

        return null;
    }
}
