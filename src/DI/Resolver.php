<?php

/**
 * Fichier de résolution de l'injection de dépense
 */

namespace Simplecode\DI;

use ReflectionFunction;
use ReflectionNamedType;
use ReflectionParameter;

/**
 * @author Claude Fassinou <dev.claudy@gmail.com>
 * @license 
 * 
 * @copyright 2021 Ladiscode
 */
class Resolver
{
    /**
     * Arguments
     *
     * @var array
     */
    protected $arguments = [];
    /**
     * 
     *
     * @var BuilderReflector
     */
    private $reflector;


    /**
     * Résolution de l'injection de dépense 
     *
     * @param string  $alias
     * @return object
     */
    public function resolve(string $alias, array $args = [])
    {
        //Si l'alias est un object on le renvoie aussitôt
        if (is_object($alias)) {
            return $alias;
        }
        //Si c'est une chaine de caractère (namespace)
        if (is_string($alias)) {
            $this->reflector = new BuilderReflector($alias);

            /**
             * Si le constructor est sans argument
             */
            if ($this->reflector->canBeInstantiable()) {
                if ($this->reflector->getConstructor() == null) {
                    return $this->reflector->getInstance();
                }
                /**
                 * WithContructor
                 */
                else {
                    return $this->withContructor($args);
                }
            }
        }
    }


    /**
     * Renvoie une instance de class avec contructeur
     *
     * @return object
     */
    private function withContructor(array $args = [])
    {

        /**
         * @var array
         */
        $parameters = $this->reflector->getConstructor()->getParameters();
        /**
         * Si le contructeur n'a aucun argument
         */
        if ($parameters == []) {
            return $this->reflector->getInstanceWithArgs(array());
        } else {

            $arguments = $this->getMethodArgs($parameters, $args);

            if ($args == []) {
                $fullArgs = $arguments;
            } else {
                $fullArgs = $args;
            }
            return $this->reflector->getInstanceWithArgs($fullArgs);
        }
    }

    public function resolveMethod(object $object, string $method, array $arguments = [])
    {
        $this->reflector = new BuilderReflector($object);
        $method = $this->reflector->getMethod($method);

        return $method->invokeArgs($object,
                $this->getMethodArgs($method->getParameters(), $arguments)
            );
    }

    /**
     * Prepare argument for method
     *
     * @param ReflectionParameter[] $parameters
     * @param array $arguments
     * @return array
     */
    private function getMethodArgs(array $parameters, array $args = []): array
    {
        foreach ($parameters as  $parameter) {
            if (!$parameter->hasType()) {
                
                $this->setDefaultArgs($parameter);
            }
            /**
             * Si l'argument a un type
             */
            else {
                
                $pos = $parameter->getPosition();

                /**
                 * @var ReflectionNamedType|ReflectionUnionType|null
                 */
                $classType = $parameter->getType();
                if ($classType != null) {
                    //Lorsque le paramètre n'est pas un type natif
                    if (!$classType->isBuiltin()) {
                        $class_name = $classType->getName();
                        $container = new Container;
                        $typeget = $container->get($class_name);
                        $this->arguments[$pos] = $typeget;
                    } else {
                        /**
                         * Lorsque le paramètre  a une valeur par défaut
                         */
                        if ($parameter->isDefaultValueAvailable()) {
                            $pos = $parameter->getPosition();
                            $this->arguments[$pos] = $parameter->getDefaultValue();
                            if ($args !=[]) {
                                $this->arguments [$pos] = array_shift($args);
                            }
                            
                        }else {
                           
                            //Lorsque des arguments sont envoyés
                            if ($args != []) {
                                $this->arguments[$pos] = array_shift($args);
                            }
                            
                        }
                        
                    }
                }
            }
        }
        return $this->arguments;
    }

    private function setDefaultArgs(ReflectionParameter $parameter){
        if ($parameter->isDefaultValueAvailable()) {
            $pos = $parameter->getPosition();
            $this->arguments[$pos] = $parameter->getDefaultValue();
        }
    }

    public function resolveFunction(string $function_name,array $args=[]){
        $funcReflector = new ReflectionFunction($function_name);
        $this->getMethodArgs(
            $funcReflector->getParameters()
        ,$args);
       return  $funcReflector->invokeArgs($this->arguments);
    }
}
