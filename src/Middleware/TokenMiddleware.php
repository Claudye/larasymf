<?php
namespace Simplecode\Middleware;

use Simplecode\Protocole\Http\Request;
use Simplecode\Contracts\RequestMiddleware;
use Simplecode\Facades\Session;
use Simplecode\Session\Token;

/**
 * Token middleware
 */
class TokenMiddleware implements RequestMiddleware{
    /** 
     * Request
     * @var  Request
     */
    protected $request ;
    
    /**
     *  Check token porperty
     *
     * @param Request $request
     * @return Request
     */
    public function handle(Request $request){
        
        if ($request->getMethod()==="POST") {
            $token = new Token(Session::getId()); 
           if (!$request->input()->has('_token') || $request->input()->get('_token')==null) {
                abort('Not acceptable',406);
           }
           if (!$token->tokenMatched($request->get('_token'))) {
            abort('Not acceptable',406);
           }
        }
        
        return $request;
    }
    
    /**
     * Seet a nex middleware
     *
     * @param RequestMiddleware|null $requestMiddleware
     * @return RequestMiddleware
     */
    public function setNext(?RequestMiddleware $requestMiddleware): RequestMiddleware
    {
        if ($requestMiddleware) {
            $requestMiddleware->handle($this->request);
        }
        return $this;
    }

    /**
     * Set the value of request
     *
     * @return  self
     */ 
    public function setRequest(Request $request)
    {
        $this->request = $request;

        return $this;
    }
}