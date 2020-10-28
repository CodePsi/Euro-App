<?php


namespace Euro\DependencyInjection;


use Euro\DependencyInjection\Container\AutoAliases;
use Euro\Framework\Reflection\ReflectionClassWrapper;

class Service implements Container\Autowired, AutoAliases
{
    private $class;
    private $alias = '';
    private $autowired = false;
    private $object;

    /**
     * Service constructor.
     * @param $class string
     */
    public function __construct(string $class)
    {
        $this->class = $class;
        $this->object = ReflectionClassWrapper::getObjectOfClass($class);
    }


    function autowired()
    {
        $this->autowired = true;
        return $this;
    }


    function alias($alias)
    {
        // TODO: Implement alias() method.
        return $this;
    }

    function autoAlias()
    {
        $className = explode('\\', $this->class);
        $parts = preg_split('/(?=[A-Z])/', $className[count($className) - 1], -1, PREG_SPLIT_NO_EMPTY);
        $tempAlias = '';
        for ($i = 0; $i < count($parts); $i++) {
            if ($i != count($parts) - 1)
                $tempAlias .= strtolower($parts[$i]) . '_';
            else
                $tempAlias .= strtolower($parts[$i]);
        }

        $this->alias = $tempAlias;
        return $this;
    }

    /**
     * @return string
     */
    public function getAlias(): string
    {
        return $this->alias;
    }

    /**
     * @return bool
     */
    public function isAutowired(): bool
    {
        return $this->autowired;
    }

    /**
     * @return object
     */
    public function getObject(): object
    {
        return $this->object;
    }
}