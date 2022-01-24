<?php
namespace Simplecode\Facades;

use Simplecode\Protocole\Routing\Router;

class Route extends AbstractFacade{
    public static function __callStatic($name, $arguments)
    {      static::$instance = new Router();
        return static::call($name,$arguments);
    }
}