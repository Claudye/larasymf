<?php
namespace Simplecode\Protocole\Routing;

use Simplecode\Protocole\Routing\Route;

class RouteCollection{
    /**
     * Routes defined
     *
     * @var Route[]
     */
    protected static $routes = [];

    protected static $middleware= [];
    public static function add(Route $route){
        static::$routes[] = $route;
        return $route;
    }

    public static function routes(){
        return static::$routes;
    }
}