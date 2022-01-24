<?php

namespace Simplecode\Cookies;


use Exception;
use Simplecode\Cookies\CookieMetadataResolver;
use Simplecode\Encryption\Encryption;

/**
 * Fluent class pour créer un cookie
 */
class CookieManager
{

    /**
     * Les informations su un cookie
     * @var metadataResolver
     */
    protected $metadataResolver;
    /** Nom du cookie
     * @var string
     */
    protected $name = '';

    /**
     * Contenu du cookie
     * @var string
     */
    protected $content = '';

    /**
     * Date d'expiration
     * @var int
     */
    protected $expires = 0;

    /**
     * Le chemin où le cookie sera valable
     * @var string
     */
    protected $path = "/";

    /**
     * Le domaine ou sera enregistré le cookie
     */
    protected $domain = "";

    /**
     * Connection sécurisée
     * @var bool
     */
    protected $secure = false;

    /**
     * Uniquement pour http
     */
    protected $httponly = false;

    /**
     * Tpken
     * @var string
     */
    protected $token = '';

   
    public function __construct()
    {
        $this->metadataResolver = new CookieMetadataResolver;
      
    }

    /**
     * Accepte le nom du cooki
     *
     * @param string $name
     * @return CookieManager
     */
    public function name(string $name): CookieManager
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Accepte le contenu du cookie
     *
     * @param string $content
     * @return CookieManager
     */
    public function content(string $content): CookieManager
    {
        $this->content = Encryption::encrypt($content);
        return $this;
    }

    /**
     * Accepete la date d'expiration
     *
     * @param integer $expires
     * @return CookieManager
     */
    public function expires(int $timesamps = 0): CookieManager
    {
        $this->expires = $timesamps;
        return $this;
    }

    /**
     * Accepte l'url où le cookie enregistré sera valable
     *
     * @param string $path
     * @return CookieManager
     */
    public function path(string $path = "/"): CookieManager
    {
        $this->path = $path;
        return $this;
    }

    /**
     * Accepte le domaine auquel associé le cookie 
     *
     * @param string $domain
     * @return CookieManager
     */
    public function domain(string $domain = ""): CookieManager
    {
        $this->domain = $domain;
        return $this;
    }

    /**
     * Sécurise le cookie
     * Enregistre si le domaine est sécurisé
     * @param bool $secure
     *
     * @return CookieManager
     */
    public function secured(bool $secure = true): CookieManager
    {
        $this->secure = $secure;
        return $this;
    }

    /**
     * Rendre httponly à vrai
     * @param bool $httponly
     *
     * @return CookieManager
     */
    public function httpOnly(bool $httponly = true): CookieManager
    {

        $this->httponly = $httponly;
        return $this;
    }

    /**
     * Enregistre le cookie
     *
     * @return bool
     */
    public function write()
    {
        if ($this->name == '') {
            throw new Exception("Le nom du cookie n'est pas mentionné ou ne peut être vide", 1);
        }

        if ($this->content == '') {
            throw new Exception("Le contenu du cookie ne doit pas être vide", 1);
        }
        /*
        $vars = get_object_vars($this);

        foreach ($vars as $name => $value) {
            echo $name .'==>'. $value;
            echo '<br>';
        }*/

        $sucess = setcookie(
            $this->name,
            $this->content,
            $this->expires,
            $this->path,
            $this->domain,
            $this->secure,
            $this->httponly
        );

        if ($sucess) {
            try {
                $this->metadataResolver->create(
                    $this->name,
                    $this->content,
                    $this->expires,
                    $this->path,
                    $this->domain,
                    $this->secure,
                    $this->httponly
                );
            } catch (\Throwable $th) {
                die($th);
            }
        }
        return $sucess;
    }

    /**
     * Détruie un cookie
     *
     * @param string $name
     * @return void
     */
    public function destroy(string $name)
    {
        setcookie($name, "", -3600);
    }
}
