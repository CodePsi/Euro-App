<?php


namespace Euro\ApplicationContext\Entity;


class Entity
{
    private $class;
    private $type;

    /**
     * Entity constructor.
     * @param $class
     * @param $type
     */
    public function __construct($class, $type)
    {
        $this->class = $class;
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @param mixed $class
     */
    public function setClass($class): void
    {
        $this->class = $class;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type): void
    {
        $this->type = $type;
    }

}