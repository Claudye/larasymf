<?php
namespace Simplecode\Middleware;

use Simplecode\Contracts\RequestMiddleware;
use Simplecode\Protocole\Http\Request;

class SecurityMiddleware implements RequestMiddleware{
    public function handle(Request $request)
    {
        $token = new TokenMiddleware;
        $next = $token->handle($request);
        return $next ;

    }

    public function setNext(?RequestMiddleware $requestMiddleware): RequestMiddleware
    {
        return $requestMiddleware;
    }
}