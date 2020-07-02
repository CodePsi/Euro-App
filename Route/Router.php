<?php


namespace Euro\Route;


use Closure;
use Euro\Json\JSON;
use Euro\Render\Render;

class Router
{
    /*
     *
     * @var \Euro\Route\RouterCollectionInterface
     */
    public $routes;

    /*
     * @var \Euro\Route\Router
     * */
    private static $instance;

    private function __construct()
    {
        $this->routes = new SimpleRouterCollection();
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
        $this->routes -> add(self::createRoute('GET', self::convertUriWithParametersToRegex($uri), $action));
    }

    public function post(string $uri, Closure $action) {
        $this->routes -> add(self::createRoute('POST', self::convertUriWithParametersToRegex($uri), $action));
    }

    public function put(string $uri, Closure $action) {
        $this->routes -> add(self::createRoute('PUT', self::convertUriWithParametersToRegex($uri), $action));
    }

    public function patch(string $uri, Closure $action) {
        $this->routes -> add(self::createRoute('PATCH', self::convertUriWithParametersToRegex($uri), $action));
    }

    public function delete(string $uri, Closure $action) {
        $this->routes -> add(self::createRoute('DELETE', self::convertUriWithParametersToRegex($uri), $action));
    }

    public function createRoute($method, $uri, $action): Route {
        $route = new Route($method, $uri, $action);
        $route -> setRouter($this);
        return $route;
    }

    public function runPath($uri) {
        $urlSplit = explode('?', $uri);
        $args = '';
        $onlyUri = $urlSplit[0];
//        if (self::has($url, self::$middlewareRoutes)) {
//            $status = self::$middlewareRoutes[$url] -> call(new Route());
//            if ($status !== true) {
//                $decodedStatus = json_decode($status);
//                header("location: /euro_new/errorPage?message=" . $decodedStatus -> message . "&responseCode=" . $_SERVER['REDIRECT_STATUS']);
//                return;
//            }
//
//        }
//        echo $url;
        JSON::initializeQueryParams($urlSplit[1]);


//        $matches = null;
//        $success = ;

        $routes = self::$instance -> routes -> getRoutesByUri($onlyUri);
        foreach ($routes as $route) {
            if (isset($route)) {
                if ($_SERVER['REQUEST_METHOD'] === $route->getMethod()) {
                    Render::render($route->getAction()->call($route, ...$route->getParameters()));
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