<?php


namespace Euro\Framework\Controller;


use ReflectionClass;

class ControllerResolver
{

    public function getController($controller) {
        if (!is_string($controller)) {
            $normalizedData = explode('::', $controller);
            $controllerClass = $normalizedData[0];
            if (class_exists($controllerClass)) {
//            $controllerReflectionClass = new ReflectionClass($controllerClass);
//            return $controllerReflectionClass -> newInstanceWithoutConstructor();
                $class = new $controllerClass();
                if (in_array($normalizedData[1], get_class_methods($class)))
                    call_user_func($class, $normalizedData[1]);
            }
        }

    }

}