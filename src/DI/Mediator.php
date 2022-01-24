<?php
/**
 * Pour plus de performance cette class ne doit être instancié qu'une seule fois
 * Dans tous le projet
 */
namespace Simplecode\DI;

use Simplecode\DI\ContainerBuilder;
/**
 * Pour plus de performance cette class ne doit être instancié qu'une seule fois
 * Dans tous le projet
 * Class disctutant avec l'extérieur pour le staockage et la distribution
 * 
 * @author Claude Fassinou <dev.claudy@gmail.com>
 * 
 * @license MIT
 * 
 * @copyright 2021 Ladiscode
 */

class Mediator extends ContainerBuilder
{
    /**
     * L'instance du médiator
     *
     * @var self
     */
    private static $instance =null;

    /**
     * Les message clés
     */
    public const MESSAGE= [
        'controller'=>'message_controller',
        'request'=>'message_request',
        'middleware'=>'middleware_bag'
    ];

    /**
     *  Le stockages informartions arbitraire
     *
     * @var array
     */
    private static $stockage = [];
    /**
     * Méthode qui crée l'unique instance de la classe
     * si elle n'existe pas encore puis la retourne.
     *
     * @return Mediator
     */
    public static function mediator()
    {

        if (is_null(self::$instance)) {
            self::$instance = new Mediator();
        }

        return self::$instance;
    }

    /**
     * Reçoit une donnée réutilisable plus tard
     *
     * @param string $name
     * @param  $value
     * @return void
     */
    public function receive(string $name,$value){
       
        $this->parameters->stock($name,$value);
    }

    /**
     * Renvoie la valeur reçue de façon arbitraire
     *
     * @param string $name
     * @return mixed
     */
    public function give(string $name){
        self::$stockage[$name]=$this->parameters->getStock($name);
        return $this->parameters->getStock($name);
       
    }

}
