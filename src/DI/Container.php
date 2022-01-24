<?php

/**
 * Le container 
 */

namespace Simplecode\DI;

use Simplecode\DI\Interfaces\ContainerInterface;
use Simplecode\DI\Interfaces\ParametersInterface;

/**
 * Container d'objet, closure, callable
 * Container d'information
 * @author Claude Fassinou <dev.claudy@gmail.com>
 * @license 
 * @copyright 2021 Ladiscode
 * 
 */
class Container implements ContainerInterface
{

    /**
     * Parameters
     *
     * @var ContainerParameter
     */
    protected $parameters;


    /**
     * Resolver
     * @var Resolver
     */
    protected $resolver;
    
    /**
     * 
     * @param ParametersInterface|null $parametersInterface
     * 
     * @param Resolver $resolver
     * 
     * 
     */
    public function __construct(?ParametersInterface $parametersInterface = null, Resolver $resolver = null)
    {
        $this->parameters = null == $parametersInterface ? new ContainerParameter : $parametersInterface;
        $this->resolver = null == $resolver ? new Resolver : $resolver;
    }

    /**
     * 
     * 
     * @inheritDoc
     */
    public function get(string $id)
    {
        try {

            if (!$this->has($id)) {
                $this->parameters->set($id);
                $alias =  $this->parameters->get($id);
                //dd($alias);
                return $this->resolve($alias);
            }
            $alias = $this->parameters->get($id);
            
            return $this->resolve($alias);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * 
     * 
     * @inheritDoc
     */
    public function has(string $id): bool
    {
        return $this->parameters->has($id);
    }

    /**
     * 
     * Renvoie normalement un objet
     *
     * @param string $alias
     * @return object
     */
    public function resolve($alias)
    {
        if (is_string($alias)) {
            try {
                return $this->resolver->resolve($alias);
            } catch (\Throwable $th) {
                throw $th;
            }
        } 
        
        return  $alias;
    }

    /**
     * 
     * Configure un ensemble d'information
     *
     * @param array $configs
     * @return void
     */
    public function configure(array $configs){
        foreach ($configs as $key => $value) {
           $this->parameters->set($key,$value);
        }
    }
}
