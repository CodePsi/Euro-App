<?php


namespace Euro\Framework\Reflection;


use ReflectionClass;
use ReflectionException;

class ReflectionClassWrapper
{

    /**
     * Initiate new class and return ReflectionClass instance or null in case of absence
     *
     * @param $className
     * @return ReflectionClass|object
     */
    public static function initiateClass($className) {
        try {
            return new ReflectionClass($className);
        } catch (ReflectionException $e) {
            echo $e;
        }

        return null;
    }

    public static function getObjectOfClass($className): object {
        return self::initiateClass($className) -> newInstanceWithoutConstructor();
    }

    public static function hasReflectionClassTheInterface(ReflectionClass $class, string $interface): bool {
        return in_array($interface, $class -> getInterfaceNames());
    }

}