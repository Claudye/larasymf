<?php
namespace Simplecode\Facades;

use Exception;
use Simplecode\Cookies\CookieBag;
use Simplecode\Cookies\CookieManager;
use Simplecode\Cookies\CookieMetaData;


/**
 * @author Fassinou Claude <dev.claudy@gmail.com>
 * 
 * @license MIT
 * 
 * @copyright 2021 Simplecodecode | Claude Fassinou
 * Façade pour gérer les cookies
 * 
 * @method bool rename(string $old, string $new)  Renomme un cookie $old ancien nom  $new nouveau nom
 */
class Cookies{
    

    /**
     * Créer un cookie
     * 
     * @param string $name le nom du cookie
     * 
     * @return CookieManager
     */
    public static function create(string $name):CookieManager{
        return (new CookieManager)->name($name);
    }

    /**
     * Retourne un cookie et ses informations
     *
     * @param string $cookiename
     * @return CookieMetaData
     */
    public static function get(string $cookiename):CookieMetaData{
        return (new CookieBag)->getCookie($cookiename);
    } 

    /**
     * Le cookiebag
     *
     * @return CookieBag
     */
    protected static function bagger():CookieBag{
        return new CookieBag;
    }

    /**
     * Appel une méthode sur CookieBag
     *
     * @param string $method
     * @param array $arguments
     * @return mixed
     */
    public static function __callStatic($method, $arguments)
    {
        if (!method_exists(__CLASS__,$method)) {
            if (method_exists(static::bagger(),$method)) {
                return static::bagger()->{$method}(...$arguments);
            }
            return ;
        }
        
        throw new Exception("Appel d'une function non définie ".__CLASS__."::$method()", 1);
        
    }
}