<?php


namespace Euro\Route;


class RouteConfigBuilder
{
    private $resultConfig = [];
    private $controller = [];
    private $parameters = [];

    private function __construct() {}

    public static function instance() {
        return new RouteConfigBuilder();
    }

    public function setController(string $controllerMethod) {
        $this->controller['@controller'] = $controllerMethod;
        return $this;
    }

    public function setParameter(string $parameterName, $parameterValue) {
        $this->parameters[$parameterName] = $parameterValue;
        return $this;
    }

    public function getConfig() {
        return array_merge($this->controller, $this->parameters);
    }

}