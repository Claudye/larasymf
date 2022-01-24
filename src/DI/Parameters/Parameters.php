<?php
/**
 * Fichier de base pour toutes les classes de paramètrages
 * 
 * Parameters class
 * 
 * Enregistre des valeurs sur la class
 */
namespace Simplecode\DI\Parameters;

use Simplecode\DI\Exceptions\NotFoundException;
use Simplecode\DI\Interfaces\ParametersInterface;

/** Gestion des paramères
 * Ajout de paramètre
 * Suppresssion etc.
 * @author Claude Fassinou <dev.claudy@gmail.com>
 * 
 * @copyright 2021 Ladiscode
 * @license MIT
 */
class Parameters implements ParametersInterface
{

    /**
     * Le sac des paramètres
     *
     * @var array
     */
    protected $parameters = [];


    /**
     * @inheritDoc
     *
     * @param string $name
     * @return mixed
     */
    public function get(string $name)
    {
        if ($this->has($name)) {
            return $this->parameters[$name];
        }
    }

    /**
     * @inheritDoc
     *
     * @param string $name
     * @return boolean
     */
    public function has(string $name): bool
    {
        return array_key_exists($name, $this->parameters);
    }

    /**
     * Stocke un paramètre
     *
     * @param string $name
     * @param  $value
     * @return void
     */
    public function set(string $name, $value)
    {
        $this->parameters[$name] = $value;
    }

    /**
     * @inheritDoc
     */
    public function remove(string $name)
    {
        if ($this->has($name)) unset($this->parameters[$name]);
    }

    /**
     * @inheritDoc
     */
    public function stock(string $name, $value)
    {
        $this->parameters[$name] = $value;
    }
    /**
     * Retourne une valeur stackquée
     *
     * @param string $name
     * @return mixed
     */
    public function getStock(string $name)
    {
        if ($this->has($name)) {
            return $this->parameters[$name];
        }
        throw new NotFoundException("Vous n'avez pas stocké le $name sur le container", 1);
        
    }

    public function count(): int
    {
        return count($this->parameters);
    }
}
