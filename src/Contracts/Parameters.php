<?php
namespace Simplecode\Contracts;
/**
 * @author Claude Fassinou <dev.claudy@gmail.com>
 * Interface pour les sacs de paramètres
 * @license MIT
 */
interface Parameters{
    /**
     * Ajoute un paramètre aux paramètres
     *
     * @param string $name
     * @param mixed $value
     * @return void
     */
    public function set(string $name, $value);
    /**
     *Retourne un paramètre selon le nom
     *
     * @param string $name
     * @return mixed
     */    
    public function get(string $name);
    /**
     * Vérifie si un paramètre existe
     *
     * @param string $name
     * @return boolean
     */
    public function has(string $name):bool;

   /**
    *  Return all parameters
    *
    * @param array $keys
    * @return array
    */
    public function all(array $keys = []):array ;

    public function put(array $parameters);

    public function remove(string $key);
}