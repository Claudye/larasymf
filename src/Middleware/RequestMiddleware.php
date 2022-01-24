<?php
namespace Simplecode\Middleware;

use Simplecode\Protocole\Http\Request;
use Simplecode\Contracts\RequestMiddleware as ContractsRequestMiddleware;
use Simplecode\Facades\Session;

class RequestMiddleware implements ContractsRequestMiddleware{
    
    public function handle(Request $request)
    {
        if ($request->getMethod()=='POST') {
            Session::set('_formEvent',true);
        }
       
    }

    public function setNext(?ContractsRequestMiddleware $requestMiddleware): ContractsRequestMiddleware
    {
        return $requestMiddleware;
    }
}