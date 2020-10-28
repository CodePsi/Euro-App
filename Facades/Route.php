<?php


namespace Euro\Facades;


use Closure;
use Euro\Route\Router;

class Route
{
    public static function setRoute($url, Closure $action) {
        return Router::createRouter() -> setRoute($url, $action);
    }

    public static function get(string $url, Closure $action) {
        return Router::createRouter() -> get($url, $action);
    }

    public static function post(string $url, Closure $action) {
        return Router::createRouter() -> post($url, $action);
    }

    public static function put(string $url, Closure $action) {
        return Router::createRouter() -> put($url, $action);
    }

    public static function patch(string $url, Closure $action) {
        return Router::createRouter() -> patch($url, $action);
    }

    public static function delete(string $url, Closure $action) {
        return Router::createRouter() -> delete($url, $action);
    }

    public static function beforeEach(\Closure $action) {
        Router::createRouter() -> beforeEach($action);
    }
}