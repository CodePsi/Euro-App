<?php


namespace Euro\Framework\Annotations\Processing;


use Euro\Framework\Reflection\ReflectionAnnotations;

class AnnotationProcessor
{
    public static function process(string $class) {
        $reflectionAnnotations = new ReflectionAnnotations($class);
        $annotations = $reflectionAnnotations->getAllAnnotations();

        $s = namespace;
        echo $s;
    }
}