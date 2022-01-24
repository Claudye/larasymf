<?php

/**
 *
 */
namespace Simplecode\DI;

use Simplecode\DI\Resolver;
use Simplecode\DI\Container;
use Simplecode\DI\Interfaces\ParametersInterface;
use Simplecode\DI\Parameters\AliasContainer;
use Simplecode\DI\Parameters\ArgumentResolver;

/**
 * Le container d'injection d'indépendance
 *  ContainerBuilder 
 *  @copyright (©) 2021 Ladiscode
 */
class ContainerBuilder extends Container{
    
    /**
     * Container des alias
     *
     * @var AliasContainer
     */
    protected $aliasResolver;

    /** 
     * Container d'argument
     * ArgumentResolver
     *
     * @var ArgumentResolver
     */
    protected $argumentResolver;

    public function __construct(?ParametersInterface $parametersInterface = null, Resolver $resolver = null)
    {
        $this->aliasResolver = new  AliasContainer;
        $this->argumentResolver = new  ArgumentResolver;
        parent::__construct($parametersInterface,$resolver);
    }

    /**
     * Ajoute une donnée (objet, string ...) au container
     * @param string $abstract
     * @param  $contract
     * @return $this
     */
    public function register(string $abstract, $contract){
        /**
         * Pemet de voir l'enregidtrement est possible
         */
        $this->parameters->set($abstract, $contract);

    
        /**
         * On enregistre dans alias
         */
        $this->aliasResolver->set($abstract, $contract);

        return $this;
    }
    /**
     * Ajoute des arguments au container d'argument
     *
     * @param string $abstract
     * @param array $arguments
     * @return void
     */
    public function setArguments(string $abstract,array $arguments){
        $this->argumentResolver->set($abstract,$arguments);
    }

    /**
     * Résout une dépendance
     * Injecte une donnée
     *
     * @param string $id identifiant pour charger une donnée
     * @return mixed
     */
    public function resolver(string $id){
        //On obtient les arguments à travers un id passé
        $arguments =$this->argumentResolver->get($id);
        
        //On obtient le namespace/object ...
        $alias = $this->aliasResolver->get($id);
        
        if (is_string($alias)) {
            try {
                //Résolution
                return $this->resolver->resolve($alias,$arguments);
            } catch (\Throwable $th) {
                throw $th;
            }
        } 
        
        return  $alias;
        
    }

    /**
     * @inheritDoc
     */
    public function get(string $id)
    {
        if ($this->aliasResolver->has($id)) {
            return $this->resolver($id);
        }else{
            return parent::get($id);
        }
        
    }

    /**
     * Renvoie le resultat d'une méthode d'un objet
     *
     * @param object|string $objectOrString
     * @param string $name
     * @param array $args
     * @return mixed
     */
    public function call($objectOrString, string $name, array $args = []){
        if (is_object($objectOrString)) {
            $object = $objectOrString;
        }elseif(is_string($objectOrString)) {
            $object = $this->get($objectOrString);
        }
        
        return $this->resolver->resolveMethod($object,$name,$args);
    }
    public function callFunction(string $function_name, array $args =[]){
        return $this->resolver->resolveFunction($function_name,$args);
    }
}