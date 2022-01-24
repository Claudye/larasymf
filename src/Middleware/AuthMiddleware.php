<?php
namespace Simplecode\Middleware;

use Simplecode\Facades\Session;
use Simplecode\Protocole\Http\Request;
use Simplecode\Contracts\RequestMiddleware;

class AuthMiddleware implements RequestMiddleware{
    public function handle(Request $request)
    {
        if ($request->user()==null) {
            Session::set('_redirect',$request->getPathInfo());
          return  redirect(config('auth.login'));
        }
        
        return $this;
    }

    public function setNext(?RequestMiddleware $requestMiddleware): RequestMiddleware
    {
        return $requestMiddleware;
    }
}