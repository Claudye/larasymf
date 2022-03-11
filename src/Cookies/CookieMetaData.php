<?php
namespace Simplecode\Cookies;

use Simplecode\Cookies\CookieBag;
use Simplecode\Cookies\CookieMetadataResolver;


class CookieMetaData{

    /**
     * Nom du cookie
     * @var string
     */
    protected $cookie =null;

    /**
     * Le metadata
     *
     * @var CookieMetadataResolver
     */
    protected $metadataResolver ;

      /**
     * Le sac des cookies
     *
     * @var CookieBag
     */
    protected $cookieBag ;

    /**
     * Le nom du cookie sur lequel on souhaite prendre des informations
     *
     * @param string $cookiename
     */
    public function __construct(string $cookiename)
    {
        $this->metadataResolver = new CookieMetadataResolver;
        $this->cookieBag= new CookieBag;
        $this->prepare($cookiename);
    }

    /**
     * prepare le cookie dont on chercher à connaitre les informations
     *
     * @param string $name
     * @return void
     */
    private function prepare(string $name){
        if ($this->metadataResolver->has($name) && $this->cookieBag->has($name)) {
           $this->cookie  = $name;
        }
    }

    /**
     * Le contenu du cookie
     *
     * @return string|null
     */
    public function getContent():?string{
        if ($this->cookie !=null) {
           return $this->cookieBag->get($this->cookie);
        }
        return null;
    }
    
    /**
     * La date d'expiration
     *
     * @return mixed
     */
    public function getExpires(){
        if ($this->cookie !=null) {
            $info =$this->metadataResolver->getInfo($this->cookie);
            return $info['expires'];
         }
         return null;
    }

    /**
     * L'url pour laquelle le cookie est valable
     *
     * @return string|null
     */
    public function getPath():?string{
        if ($this->cookie !=null) {
            $info =$this->metadataResolver->getInfo($this->cookie);
            return $info['path'];
         }
         return null;
    }

    /**
     * Le domaine au nom duquel le cookie est enregistré
     *
     * @return string|null
     */
    public function getDomain():?string{
        if ($this->cookie !=null) {
            $info =$this->metadataResolver->getInfo($this->cookie);
            return $info['domain'];
         }
         return null;
         
    }

    /**
     * Statut de sécurité pour  https
     *
     * @return boolean
     */
    public function getSecure():?bool{
        if ($this->cookie !=null) {
            $info =$this->metadataResolver->getInfo($this->cookie);
            return $info['secure'];
         }
         return null;
    }

    /**
     * Le statut de http
     *
     * @return boolean
     */
    public function getHttponly():bool{
        if ($this->cookie !=null) {
            $info =$this->metadataResolver->getInfo($this->cookie);
            return $info['httponly'];
         }
         return null;
    }

    /**
     * la date où le cookie est stocké
     *
     * @return string!null
     */
    public function createdDate():?string{
        if ($this->cookie !=null) {
            $info =$this->metadataResolver->getInfo($this->cookie);
            return $info['created_at'];
         }
         return null;
    }

    /**
     * Renvoie le contenu du cookie
     *
     * @return string
     */
    public function __toString()
    {
        if ($this->cookie !=null &&  null !=$this->cookieBag->get($this->cookie)) {
            return $this->cookieBag->get($this->cookie);
         }
         return '';
    }

    /**
     * Renvoie à laquelle le cookie expire
     *
     * @return string|null
     */
    public function getDateExpires(){
        if ($this->cookie !=null) {
            return date("Y-m-d H:m:s", $this->getExpires());
         }
         return null;
    }
    /**
     * Check if cookie exist
     *
     * @return bool
     */
    public function exist(){
        return $this->cookie != null ;
    }
    /**
     * Supprime le cookie
     *
     * @return bool
     */
    public function delete(){
        return $this->cookieBag->remove($this->cookie);
    }
}