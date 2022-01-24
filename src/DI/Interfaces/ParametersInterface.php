<?php
namespace Simplecode\DI\Interfaces;

/**
 * Interface de tous les parameters
 */
interface ParametersInterface{

    /**
     *Retourne une valeur
     *
     * @param string $id
     * @return mixed
     */
    public function get(string $id);

    /**
     * Vérifie la présence d'une valeur
     *
     * @param string $id
     * @return boolean
     */
    public function has(string $id):bool;

    /**
     * Stock une valeur
     *
     * @param string $name
     * @param  $value
     */
    public function set(string $name, $value);

    /**
     * Retire une valeur
     *
     * @param string $name
     * @return void
     */
    public function remove(string $name);

    /**
     * Stocke une information arbitraire sur le container
     *
     * @param string $name
     * @param mixed $value
     * @return void
     */
    public function stock(string $name, $value);

    /**
     * Retourne une information enregistrée
     *
     * @param string $name
     * @return mixed
     */
    public function getStock(string $name);

    /**
     * Return parameter number
     *
     * @return integer
     */
    public function count():int;
}