<?php
namespace Simplecode\Protocole\Routing;

use Simplecode\Protocole\Routing\RouteParameter;

class Route{
    /**
     * Route parameter
     *
     * @var RouteParameter
     */
    protected $parameter;
    /**
     * Le chemin associer à la route
     *
     * @var string
     */
    protected $path ='/';

    /**
     * Le controlleur associée à la route
     *
     * @var Closure|array
     */
    protected $controller;
    
    /**
     * Le nom de la route
     *
     * @var string
     */
    protected $name ='';

    /**
     * Les options
     *
     * @var array
     */
    protected $options = [] ;

    /**
     * Les méthodes acceptés par la route
     *
     * @var array
     */
    protected $methods = ['GET'] ;

    /**
     * Middleware apply to this route
     * @var Middleware[]
     */
    protected $middleware = [];

    /**
     * Route requirement
     *
     * @var array
     */
    protected $requirements = [];

    public function __construct(
        string $path ='/',
        $controller,
        array $options = []
    )
    {
        $this->path = $path;
        $this->controller = $controller;
        $this->options = $options;
    }

    /**
     * Retourne le chemin associé à la route
     *
     * @return string
     */
    public function getPath(){
        return $this->path ;
    }


    public function getMethods():array{
        return $this->methods;
    }

    /**
     * Ajoute les méthodes acceptés par la route
     *
     * @param  array  $methods  Les méthodes acceptés par la route
     *
     * @return  self
     */ 
    public function setMethods(array $methods=['GET'])
    {
        $this->methods = $methods;

        return $this;
    }

    /**
     * Retourne le controlleur associée à la route
     *
     * @return  Closure|array
     */ 
    public function getController()
    {
        return $this->controller;
    }

    /**
     * Get le nom de la route
     *
     * @return  string
     */ 
    public function getName()
    {
        return $this->name;
    }
    
    public function name(string $name ='')
    {
       $this->name = $name ;

       return $this;
    }
    /**
     * Set middleware to a route
     *
     * @param Middleware[] $middlewares
     * @return $this
     */
    public function middleware(array $middlewares){
        $this->middleware = array_merge($this->middleware, $middlewares);
        return $this;
    }
    /**
     * Return Middleware[]
     *
     * @return Middleware[]
     */
    public function getMiddlewares(){
        return $this->middleware;
    }

    public function setRequirements(array $requirements = []){
        $this->requirements = $requirements;
    }

    public function getRequirements(){
        return $this->requirements;
    }

    /**
     * Check if route has parameter
     *
     * @return boolean
     */
    public function hasParameter(){
        return $this->requirements != [];
    }
    /**
     * Return parameter with thei argument
     *
     * @return RouteParameter
     */
    public function parameters(){
        return $this->parameter;
    }

    /**
     * Set parameter on the route
     *
     * @param array $params
     * @return $this
     */
    public function setParameter(array $params){
        $this->parameter = new RouteParameter($params);
        return $this ;
    }
}