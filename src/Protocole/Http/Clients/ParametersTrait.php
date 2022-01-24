<?php
namespace Simplecode\Protocole\Http\Clients;

use Simplecode\Session\Session;
use Symfony\Component\HttpFoundation\InputBag;

trait ParametersTrait{
    /**
     * Get input value
     *
     * @return InputBag
     */
    function input():InputBag{
        return new InputBag($_POST) ;
    }
    /**
     * Get query string parameters
     *
     * @return InputBag
     */
    function query():InputBag{
        return  new InputBag($_GET) ;
    }


    /**
     * Check parameter value
     *
     * @param string $key
     * @return boolean
     */
    function has(string $key){
        return $this->attributes->has($key);
    }
   /**
    * Retourn filles uploaded
    *
    * @return Files
    */
    public function file(){
        return new Files ;
    }

    public function cookie(){
        return $this->cookies;
    }

    public function session():Session{
        return $this->session;
    }

    public function set(string $name, $value){
        $this->attributes->set($name,$value);
    }
    public function all(){
        return array_merge(
            $this->attributes->all(),
            $this->query->all(),
            $this->request->all()
        );
    }
}