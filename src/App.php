<?php

namespace Simplecode;

use Closure;
use Exception;
use Simplecode\Database\DB;
use Simplecode\DI\Mediator;
use Simplecode\Facades\Session;
use Simplecode\Protocole\Http\Request;
use Simplecode\Translation\Translator;
use Simplecode\Protocole\Http\Response;
use Simplecode\Protocole\Routing\Router;
use Simplecode\Protocole\Routing\ControllerResolver;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

/** @author Claude Fassinou <dev.claudy@gmail.com>
 * L'application
 */
class App
{
    /**
     * Le médiator de message
     *
     * @var \Simplecode\DI\Mediator
     */
    protected $container; 
    /**
     *La requete de l'utilisateur
     *
     * @var Request
     */
    protected $request;

    /**
     * Le router
     *
     * @var Router
     */
    protected $router;

    /**
     * Execute the application
     * Return a response
     *
     * @param Request $request
     * @param Router $router
     * @return Response
     */
    public static function run(Request $request, Router $router)
    {
        //App instance
        $app = new static;

        
        Session::start();
		date_default_timezone_set('UTC');
       $app->setLang($request);
        $app->container = Mediator::mediator() ;
        //Boot DB connection
        DB::boot();
        $app->request = $request;
        $app->router = $router;

        $app->router->routeSetter($app->request);
        
        $app->request->setRoute($app->router->getRoute());
        
        $app->runMiddlewares();
        
        $controller = $app->getController();
        if ($controller instanceof Closure) {
            $response = $controller($router->getArguments());
        }elseif (is_string($controller)) {
            //Container call controller
          $response =$app->container->callFunction($controller,$router->getArguments());
        }else{
            $response = $app->container->call($controller[0],$controller[1],$router->getArguments());
        }
        //Check if $response is an instance of Response
        if (is_a($response, Response::class) || is_a($response,HttpFoundationResponse::class)) {
            if ($request->getMethod()=='GET') {
                Session::setPreviousUrl($request->getPathInfo());
            }
            
            return $response;
        } else {
            throw new Exception(sprintf("La réponse du controlleur doit être une instance de %s", Response::class), 1);
        }
    }

    /**
     * Return a controller match with the request
     * @return Closure|array
     *
     */
    private function getController()
    {
        
       $controller_resolver = new ControllerResolver(
           $this->router->getRoute()->getController());
       return $controller_resolver->getController();
    }

    private function runMiddlewares(){
        $routeMiddleware = new \Simplecode\Middleware\RouteMiddleware;
        $next =$routeMiddleware->handle($this->request);
        if ($next instanceof Response || $next instanceof RedirectResponse) {
            $next->send();
            
        }
        $securityMiddleware = new \Simplecode\Middleware\SecurityMiddleware;
        $next= $securityMiddleware->handle($this->request);

        //return send request
        if ($next instanceof Response || $next instanceof RedirectResponse) {
            $next->send();
        }
    }

    private function setLang(Request $request){
     
        if ($request->input()->has('_lang')) {
          
            if (Translator::accept($lang=$request->input()->get('_lang'))) {
                Session::set('_lang',$lang);
            }
            header("Refresh:0");
            exit;
        }
        $langs = array_intersect($request->getLanguages(),langues());
       
        $broswerLang = array_shift($langs)?? config('app.lang');
        if (!Session::has('_lang')) {
            if(!Translator::accept($broswerLang)) {
                Session::set('_lang',config('app.lang'));
                //dp($request);
            }else {
                Session::set('_lang',$broswerLang);

            }
        }
    }
}
