<?php

namespace Simplecode\Protocole\Http;

use Components\Models\User;
use Simplecode\Auth\Auth;
use Simplecode\Session\Session;
use Simplecode\Protocole\Routing\Route;
use Simplecode\Protocole\Http\Clients\Files;
use Simplecode\Protocole\Http\Clients\Input;
use Simplecode\Protocole\Http\Clients\Query;
use Simplecode\Protocole\Http\Clients\Cookies;
use Simplecode\Protocole\Http\Clients\ParametersTrait;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;

/**
 * User request class
 * 
 * @author Clude Fassinou <dev.claudy@gmail.com>
 * @license MIT
 * @version 1.0.0
 * @copyright 2021 Simplecode
 */
class Request extends HttpFoundationRequest
{
    use ParametersTrait;

    /**
     * Cookies
     *
     * @var Cookies
     */
    public $cookies;
   
    /**
     * Query
     *
     * @var Query
     */
    public $query ;

    public function __construct()
    {
        parent::__construct(
            $_GET,$_POST,[],$_COOKIE,$_FILES,$_SERVER,null
        );
        $this->session =  new Session;
    }

    /**
     * Files
     *
     * @var Files
     */
    public $files ;

    /**
     * Route
     *
     * @var Route
     */
    protected $route;

    /**
     * Session
     * @var Session
     */
    protected $session ;
    
    /**
     * Capture la requete 
     * Renvoie la requete
     *
     * @return self
     */
    public static function capture()
    {
        return new self;
    }

   
    public function setRoute(Route $route){
        $this->route = $route ;
        return $this;
    }
    /**
     * Retourne matched
     *
     * @return Route
     */
    public function route(){
        return $this->route ;
    }
    /**
     * Return user making request
     *
     * @return \Components\Models\User
     */
    public function user(){
        //refresh user each reques
        return auth();
    }
    /**
     * Gets the request "intended" method.
     *
     * @return string
     */
    public function getMethod()
    {
        return strtoupper(parent::getMethod());
    }
    /**
     * @inheritDoc
     */
    public function ip(){
        return $this->getClientIp();
    }
}
