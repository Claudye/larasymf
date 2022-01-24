<?php
namespace Simplecode\Middleware;

use Simplecode\Protocole\Http\Request;
use Simplecode\Protocole\Http\Response;
use Simplecode\Contracts\RequestMiddleware;
use Simplecode\Middleware\RequestMiddleware as MiddlewareRequestMiddleware;
use Symfony\Component\HttpFoundation\RedirectResponse;

class RouteMiddleware implements RequestMiddleware{
    public function handle(Request $request)
    {   
        $middlewares =  array_values($request->route()->getMiddlewares());

        $middlewares = array_merge($middlewares, [
            MiddlewareRequestMiddleware::class
        ]);

        for ($i=0; $i < count($middlewares); $i++) { 
            $middleware =  new $middlewares[$i];

            $next= $middleware->handle($request);
            if (is_a($next, Response::class)||is_a($next, RedirectResponse::class)) {
               return $next;
            }

        }

        return $next ?? $this;
    }
    public function setNext(?RequestMiddleware $requestMiddleware): RequestMiddleware
    {
        return $requestMiddleware;
       
    }
}