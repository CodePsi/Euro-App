<?php


namespace Euro\Route;


class SimpleRouterCollection extends AbstractRouterCollection implements RouterCollectionInterface
{
    public function getRoutesByUri($uri): array {
        $routes = [];
        foreach ($this->routes as $route) {

            if (preg_match($route -> getUri(), $uri, $matches)) {
                $this->setParametersToRoute($route, $matches);
                array_push($routes, $route);
            }
        }

        return $routes;
    }

    public function setParametersToRoute(&$route, $regexMatchedParameters) {
        $resultingArray = [];
        for ($i = 1; $i < count($regexMatchedParameters); $i += 2) {
            $array = array_slice($regexMatchedParameters, $i, 1, true);
            $resultingArray = array_merge($resultingArray, $array);
        }

        foreach ($resultingArray as $parameter => $value) {
            array_push($route -> parameterNames, $parameter);
            array_push($route -> parameters, $value);
        }
    }
}