<?php
namespace Components\Http\Middleware;

use Simplecode\Protocole\Http\Request;
use Simplecode\Middleware\RouteMiddleware;

class WebMiddleware extends RouteMiddleware{
    public function handle(Request $request)
    {
       return $this;
    }

}