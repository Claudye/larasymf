<?php

/**
 * Fichier important pour que le container fonctionne
 */
namespace Simplecode\DI;

use Simplecode\DI\Exceptions\NotFoundException;
use Simplecode\DI\Parameters\Parameters;
use Simplecode\DI\Interfaces\ParametersInterface;
use Simplecode\DI\Parameters\NamespaceParameters;
use Simplecode\DI\Parameters\ObjectParameters;
use Simplecode\DI\Parameters\StockParameters;

/**
 * @author Fassinou Claude <dev.claudy@gmail.com>
 * Clase de base pour les paramètres
 * Au cas ou une méthode ne néccessite pas de réecriture
 */
class ContainerParameter extends Parameters{

   /**
    * parameters [name] = [parameter=>parameterClass]
    */
     
    /**
     * NamespaceParameters
     *
     * @var NamespaceParameters
     */
    protected $namespaceParameter;

    /**
     * ObjectParameters
     *
     * @var ObjectParameters
     */
    protected $objectParameter;
    
    /**
     * StockParameters
     *
     * @var StockParameters
     */
    protected $stockParameter;


    public function __construct()
    {
        $this->namespaceParameter = new NamespaceParameters;
        $this->objectParameter = new ObjectParameters;

        $this->stockParameter = new StockParameters;
    }
     /**
     * @inheritDoc
     *
     * @param string $name
     * @return mixed
     */
    public function get(string $name)
    {
        
        if ($this->has($name)) {
           $whatGet= $this->exists($name)->get($name);
          return $whatGet;
        }
      
        
    }

    /**
     * On configure une information sur le container
     *
     * @param string $name
     * @param mixed $value
     * @return void
     */
    public function set(string $name, $value =null){
        
        if ($value ==null) {
            if (class_exists($name)) {
                $this->parameters[$name] = NamespaceParameters::class;
                $this->namespaceParameter->set($name, $name);
                //dump($this->namespaceParameter);
            }else{
                throw new NotFoundException("Impossible ! La class $name n'existe pas", 1);
            }
        }else{

            /**
             * Si la valeur à enregidtrer est une closure
             */
            if (is_object($value)) {
                $this->parameters[$name] = ObjectParameters::class;
                $this->objectParameter->set($name, $value);
            }
            /**
             * Sinon
             */
            else{
                if (class_exists($value)) {
                    $this->parameters[$name] = NamespaceParameters::class;
                    $this->namespaceParameter->set($name, $value);
                }else{
                    
                throw new NotFoundException("Impossible ! La class $name n'existe pas", 1);
                }
            }
            
        }
    }

    /**
     * On vérifie si l'information demandée existe sur une 
     * Des classes de paramètres et renvoie cette class
     *
     * @param string $name
     * @return ParametersInterface
     */
    private function exists(string $name):ParametersInterface{
       
        if ($this->has($name)) {
           
            $parametersClass = new $this->parameters[$name];
            return $this->instanceOfParameter($parametersClass);
        }
        
    }
    
    /**
     * Renvoie un parameter
     * @return ParametersInterface
     */
    private function instanceOfParameter(object $object):ParametersInterface{
        if (is_a($object, NamespaceParameters::class)) {
            return $this->namespaceParameter;
        }elseif (is_a($object,ObjectParameters::class)) {
            return $this->objectParameter;
        }
    }


}