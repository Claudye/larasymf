<?php
namespace Simplecode\DI;

use ReflectionClass;
use ReflectionMethod;
use Simplecode\DI\Exceptions\NotFoundException;
/**
 * Instanciateur de class en utilisant la réflection de class
 * @author Claude Fassinou <dev.claudy@gmail.com>
 * 
 */
class BuilderReflector{

    /**
     * ReflectionClass
     *
     * @var ReflectionClass
     */
    protected $reflector;

    /**
     * Le namespace ou l'objet à reflecter
     *
     * @var mixed
     */
    protected $objectOrClass;

    /**
     * Instancie le BuilderReflector
     *
     * @param string|object $objectOrClass
     */
    public function __construct($objectOrClass)
    {

        try {
            $this->objectOrClass=$objectOrClass;
            $this->reflector= (new \ReflectionClass($objectOrClass));
        } catch (\ReflectionException $e) {
            throw new NotFoundException(
                $e->getMessage(), $e->getCode()
            );
        }
    }


    /**
     * Si la classe est instanciable
     *
     * @return boolean
     */
    public function canBeInstantiable(){
        return $this->reflector->isInstantiable();
    }

   /**
    * Le constructeur de la class à reflecter
    *
    * @return ReflectionMethod|null
    */
    public function getConstructor():?ReflectionMethod{
        return $this->reflector->getConstructor();
    }

    /**
     * L'intance de la class réflétée
     *
     * @return object
     */
    public function getInstance():object{
       return $this->reflector->newInstance();
    }

    /**
     * Renvoie une class avec ses argument
     *
     * @param array $args
     * @return object
     */
    public function getInstanceWithArgs(array $args):object{
        return $this->reflector->newInstanceArgs($args);
    }

    /**
     * Renvoie une instance ReflectionMethod
     *
     * @param string $name
     * @return ReflectionMethod
     */
    public function getMethod(string $name):ReflectionMethod{
        return $this->reflector->getMethod($name);
    }
}