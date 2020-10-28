<?php


namespace Euro\Framework\Reflection;


class Annotation
{
    private $annotationName;
    private $annotationArguments;
    private $annotationTarget;

    /**
     * Annotation constructor.
     * @param $annotationName
     * @param $annotationArguments
     * @param $annotationTarget
     */
    public function __construct($annotationName, $annotationArguments, $annotationTarget)
    {
        $this->annotationName = $annotationName;
        $this->annotationArguments = $annotationArguments;
        $this->annotationTarget = $annotationTarget;
    }

    /**
     * @return string
     */
    public function getAnnotationName()
    {
        return $this->annotationName;
    }

    /**
     * @return array
     */
    public function getAnnotationArguments()
    {
        return $this->annotationArguments;
    }

    /**
     * @return object
     */
    public function getAnnotationTarget()
    {
        return $this->annotationTarget;
    }




}