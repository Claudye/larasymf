<?php
namespace Simplecode\Protocole\Routing;

use Exception;
use Simplecode\Protocole\Http\Request;

class Router{
    /**
     * Liste de toutes les routes
     *
     * @var Route[]
     */
    protected $routes = [];

    /**
     * La route qui correspond à la requete
     *
     * @var Route
     */
    protected $route ;

    /**
     * Les arguments
     *
     * @var array
     */
    protected $arguments = [];
    
    /**
     * Capture la route corresopnd à l'url de la requete
     *
     * @param Request $request
     * @return void
     */
    public function routeSetter(Request $request){
       $this->set();
        foreach ($this->routes as $key => $route) {
            $pattern = "@^" . preg_replace('/\\\{[a-zA-Z0-9]+\\\}/', '([a-zA-Z0-9\-\_]+)', preg_quote($route->getPath())) . "(\?.*)?$@";
            preg_match_all('/\{[a-zA-Z0-9]+\}/',$route->getPath(), $m);
            
           
            if (preg_match($pattern, $request->getPathInfo(), $matches) && in_array($request->getMethod(), $route->getMethods())) {
                
                array_shift($matches);
                $this->arguments = $matches ;
                $this->route = $route ;

                $this->route->setParameter(
                    $this->map_parameters($m, $matches)
                );
                if ($this->route->getName()=='') {
                   $this->route->name("$key");
                }
                break;
            }else {
                $this->route = new Route('/not-found',function (){
                    abort('Page Not Found',404);
                });
            }
        }
    }

    /**
     * Retourne la route qui correspond à la requete
     *
     * @return  Route
     */ 
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * Get les arguments
     *
     * @return  array
     */ 
    public function getArguments()
    {
        return $this->arguments;
    }

    /**
     * Get GET route by name
     *
     * @param string $name
     * @param array $requirement_values
     * @return string
     */
    public function get(string $name, array $requirement_values =[] ){
        $this->set();
        //filtre 
        $requirement = array_keys($requirement_values);
        $routes =$this->routes;
        /**
         * Check route call by name
         */
        foreach ($routes as $route) {
            if ($route->getName()==$name) {
                if ($route->hasParameter()) {
                    $dff_params = array_diff($route->getRequirements(),$requirement);
                    if ($dff_params !=[]) {
                        throw new Exception(vsprintf("Route $name require parameters %s", $dff_params ), 1);
                    }
                    foreach ($requirement as $key => $param) {
                        $p [] = '{'.$param.'}';
                    }
                    return str_replace($p, array_values($requirement_values),$route->getPath());
                }
                return $route->getPath() ;
            }
        }
        throw new Exception("Route $name doesn't exist", 1);
        
    }

    private function set(){
         /**
         * Routes listes
         */
        require joinPath(config('app.routes'),'routes.php');
       
        require __DIR__. "/../../App/routes.php";
     
        $this->routes = RouteCollection::routes();
      
        $this->routes =  array_map(function(Route $route){
            if (preg_match_all('/{([^}]+)}/', $route->getPath(), $matches)) {
                array_shift($matches);
                if ([]!=$matches) {
                    $route->setRequirements($matches[0]);
                }else {
                    $route->setRequirements([]);
                }
            }else {
                $route->setRequirements([]);
            }
            return $route ;
        },$this->routes);
    }

    private function map_parameters(array $params, array $arguments =[]){
        $mparams = [];

        foreach ($params as $key => $hug) {
           
           $hug = array_map(function($val){
                return str_replace(['{','}'],['',''],$val);
           },$hug);

           $mparams=array_combine($hug,$arguments);
        }

        return $mparams;
    }
}