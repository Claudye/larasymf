<?php

namespace Simplecode\Protocole\Routing;

use Exception;

class ControllerResolver
{

    protected $controller;
    /**
     * Resolve controller
     *
     * @param Closure|array|string $controller
     */
    public function __construct($controller)
    {
        $this->trustController($controller);
    }

    private function trustController($controller)
    {
        //Après il faut bien vérifier les choses
        
        if (is_array($controller)) {
            if (class_exists($controller[0])) {
                $this->controller= $controller;
                
            }elseif (file_exists($file=joinPath(config('app.function_controller'),$controller[0].'.php'))) {
                
               require_once($file);
               if (!function_exists($controller[1])) {
                  throw new Exception(vsprintf("The function %s you call from %s as controller is not defined",array_reverse($controller)), 1);
               }else {
                $this->controller= $function_name = $controller[1];
               }
              
            }else {
                throw new Exception(sprintf("Controller %s is not defined or is not matched with %s controller",$file,'Simplecode'), 1);
                
            }
        } elseif (is_callable($controller)) {
            $this->controller=$controller;
        } else {
            throw new Exception(sprintf("Le controlleur passé à la route %s doit être une closure ou un tableau", $this->router->getRoute()->getName()), 1);
        }
    }

    public function getController(){
        return $this->controller;
    }
}
