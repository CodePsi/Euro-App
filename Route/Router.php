<?php


namespace Euro\Route;


use Closure;
use Euro\Response\JSON;
use Euro\Render\Render;
use Euro\Response\ResponseDataReceiver;

class Router
{
    /**
     * @var \Euro\Route\RouterCollectionInterface
     */
    public $routes;

    /**
     * @var \Euro\Route\NavigationGuardsInterface
     */
    public $navigationGuards;

    /**
     * @var \Euro\Route\Router
     * */
    private static $instance;

    private function __construct()
    {
        $this->routes = new SimpleRouterCollection();
        $this->navigationGuards = new NavigationGuards($this->routes);
    }

    /**
     * @return Router
     */
    public static function createRouter()
    {
        if (!isset(self::$instance)) self::$instance = new Router();
        return self::$instance;
    }

    public function setRoute($uri, Closure $action) {
//        $this->routes -> add(self::createRoute('GET', self::convertUriWithParametersToRegex($uri), $action));
        $this->get($uri, $action);
    }

    public function get(string $uri, Closure $action) {
        $this->routes -> add(self::createRoute('GET', $uri, $action));
    }

    public function post(string $uri, Closure $action) {
        $this->routes -> add(self::createRoute('POST', $uri, $action));
    }

    public function put(string $uri, Closure $action) {
        $this->routes -> add(self::createRoute('PUT', $uri, $action));
    }

    public function patch(string $uri, Closure $action) {
        $this->routes -> add(self::createRoute('PATCH', $uri, $action));
    }

    public function delete(string $uri, Closure $action) {
        $this->routes -> add(self::createRoute('DELETE', $uri, $action));
    }

    public function beforeEach(Closure $action) {
        $this->navigationGuards -> beforeEachAction = $action;
    }

    public function createRoute($method, $uri, $action): Route {
        $route = new Route($method, $uri, $action);
        $route -> setRegexUri(self::convertUriWithParametersToRegex($uri));
        $route -> setRouter($this);
        return $route;
    }

    public function runPath($uri) {
        $urlSplit = explode('?', $uri);
        $args = '';
        $onlyUri = $urlSplit[0];

        ResponseDataReceiver::initializeQueryParams($urlSplit[1]);



        $routes = self::$instance -> routes -> getRoutesByUri($onlyUri);
        foreach ($routes as $route) {
            if (isset($route) && $route instanceof Route) {
                if ($_SERVER['REQUEST_METHOD'] === $route->getMethod()) {
                    if (isset($this->navigationGuards -> beforeEachAction))
                        Render::render($this->navigationGuards -> beforeEach($route));
                    else
                        Render::render($route -> call());
                    break;
                }
            } else {
                $route = $this->routes->getRouteByUri("/euro_new/errorPage");
                $route->getAction()->call($this);
                break;
            }
        }
    }

    public function convertUriWithParametersToRegex($uri) {
        $result = preg_replace_callback('/([^{]*)({([^}]*)})?/', function ($m) {
            $res = preg_quote($m[1] ?? '', '/');
            if (!empty($m[2])) {
                $name = substr($m[2], 1, -1);

                $res .= '(?<' . $name . '>[^\/]*)';
            }
            return $res;
        }, $uri);
//        echo 'TT: ' . $result . ': ';
        $result = "/^$result\/?$/";
        return $result;
    }

    /**
     * @return mixed
     */
    public static function getInstance()
    {
        return self::$instance;
    }


}