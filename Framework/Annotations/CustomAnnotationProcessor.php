<?php


namespace Euro\Framework\Annotations;


abstract class CustomAnnotationProcessor
{
    public function __set($name, $value)
    {
        echo 'Here ' . $name . " with " . $value;
    }
}