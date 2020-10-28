<?php

namespace Euro\tests\Framework\Reflection;

use Euro\Framework\Reflection\ReflectionAnnotations;
use Euro\UsualClass;
use PHPUnit\Framework\TestCase;

class ReflectionAnnotationsTest extends TestCase
{

    public function testGetAllAnnotations()
    {
        $reflectionAnnotation = new ReflectionAnnotations(UsualClass::class);
        var_dump($reflectionAnnotation -> getAllAnnotations());
    }
}
