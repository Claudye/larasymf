<?php

namespace Simplecode\Protocole\Http;

use Simplecode\Contracts\Parameters as ContractsParameters;
use Simplecode\Protocole\Http\Clients\Files;

/**
 * Class de paramétrage
 */
class Parameters implements ContractsParameters
{
    /**
     * Les paramètres
     *
     * @var array
     */
    protected $parameters = [];

    /**
     * @inheritDoc
     */
    public function set(string $name, $value)
    {
        $this->parameters[$name] = $value;
    }
    /**
     * @inheritDoc
     */
    public function get(string $name)
    {
        if ($this->has($name)) {
           return $this->parameters [$name];
        }
        return NULL;
    }
    /**
     * @inheritDoc
     */
    public function has(string $name): bool
    {
        return array_key_exists($name, $this->parameters);
    }

    public function all(array $keys =[]): array
    {    $filtres =[];
        if ($keys !=[]) {
           foreach ($keys as $key) {
               $filtres[$key] = $this->get($key);
           }
           return $filtres ;
        }
        return $this->parameters ;
    }

    public function put(array $parameters)
    {
        $this->parameters= array_merge($this->parameters, $parameters);
    }
    
    public function remove(string $key)
    {
        if ($this->has($key)) {
           unset($this->parameters[$key]);
           return true;
        }
        return false;
    }
    
}
