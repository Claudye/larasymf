<?php
namespace Simplecode\Facades;

use Simplecode\Protocole\Http\Response as HttpResponse;
    /**
     * @method static HttpResponse json(array $json=[]) Set json content
     */
 class Response extends AbstractFacade{
     public static function __callStatic($name, $arguments)
     {      static::$instance = new HttpResponse();
         return static::call($name,$arguments);
     }
 }