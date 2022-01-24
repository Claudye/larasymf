<?php
namespace Simplecode\Facades;

use Simplecode\Auth\Auth as AuthAuth;

/**
 * @method static void disconnect() Déconnecte l'utilisateur
 * @method static stdClass auth() return  un utilisateur authentifié
 * @method static bool verifyPassword($password,string $hash)  Verify password
 */
class Auth{
    protected static $instance;

    public static function __callStatic($name, $arguments)
    {
        $session= static::getInstance();
        return $session->{$name}(...$arguments);
    }
    /**
     * Undocumented function
     *
     * @return SessionFluent
     */
    private static function getInstance(){
        static::$instance= new AuthAuth( );
        return static::$instance;
    }

}