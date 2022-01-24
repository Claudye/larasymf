<?php
namespace Simplecode\Protocole\Http\Clients;

use Simplecode\Cookies\CookieBag;
use Simplecode\Protocole\Http\Parameters;

class Cookies extends Parameters{

    /**
     * CookieBag
     *
     * @var CookieBag
     */
    protected $cookieBag ;
    public function __construct()
    {
        $this->init();
    }

    private function init(){
        $this->cookieBag = new CookieBag();
    }

    /**
     * Set a cookie
     *
     * @param string $name
     * @param  CookieMetaData $value
     * @return void
     */
    public function set(string $name, $value)
    {
        parent::set($name,$value);
    }

    /**
     * Get cookie with metadata
     *
     * @param string $name
     * @return CookieMetaData|null
     */
    public function get(string $name)
    {
        return $this->cookieBag->getCookie($name);
    }

    public function getWithouMeta(string $name){
        return $this->cookieBag->get($name);
    }
    /**
     * CookieBag
     *
     * @return CookieBag
     */
    public function cookie(){
        return $this->cookieBag;
    }
    
    public function
     remove(string $key)
     {
        return $this->cookieBag->remove($key);
     }
}