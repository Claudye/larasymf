<?php

namespace Simplecode\Cookies;

use Simplecode\Cookies\CookieManager;
use Simplecode\Cookies\CookieMetaData;
use Simplecode\Cookies\CookieMetadataResolver;
use Simplecode\Encryption\Encryption;

/**
 * le sac des cookies
 */
class CookieBag
{

    /**
     * Le cookieManager
     *
     * @var CookieManager
     */
    protected $cookiemanager;

    /**
     * Le CookieMetadataResolver
     *
     * @var CookieMetadataResolver
     */
    protected $metadataResolver;
    /**
     * Les paramètres
     * 
     * @var array
     */
    protected $parameters = [];

    /**
     *
     * @param array $cookies
     */
    public function __construct(array  $cookies = [])
    {
        $this->parameters = $cookies == [] ? $_COOKIE : $cookies;
        $this->cookiemanager = new CookieManager;
        $this->metadataResolver = new CookieMetadataResolver;
        $this->refresh();
    }

    /**
     * Tous les cookies existants
     *
     * @return array
     */
    public function all():array
    {
        $cookies = [];
        foreach ($this->parameters as $name => $encypt) {
            $cookies [$name] = $this->get($name);
        }
        return $cookies;
    }

    /**
     * Vérifie si un cookie existe
     * @var bool
     */
    public function has(string $name):bool
    {
        return array_key_exists($name, $this->parameters);
    }

    /**
     * Obtient le contenu du cookie
     *
     * @param string $name
     * @return string|null
     */
    public function get(string $name): ?string
    {
        if ($this->has($name)) {
            return $this->withEncryption($this->parameters[$name]);
        }
        return null;
    }


    /**
     * Supprime un cookie
     *
     * @param string $name
     * @return bool
     */
    public function remove(string $name): bool
    {
        if ($this->has($name)) {
            $this->cookiemanager->destroy($name);
            $this->metadataResolver->delete($name);
            return true;
        }
        return false;
    }
    /**
     * Renvoie un cookie avec les métadonnées
     *
     * @param string $cookie
     * @return CookieMetaData|null
     */
    public function getCookie(string $cookie): ?CookieMetaData
    {
        try {
            return new CookieMetaData($cookie);
        } catch (\Throwable $th) {
            throw $th;
        }
        return null;
    }

    /**
     * Rafraichir les informations de cookie
     *
     * @return void
     */
    public function refresh()
    {
        $dir = $this->metadataResolver->getDir();
        $cookies = scandir($dir);

        foreach ($cookies as $name) {
            if (!in_array($name, array(".", ".."))) {
                if (!$this->has($name)) {
                    $this->metadataResolver->delete($name);
                }
            }
        }
    }

    /**
     * Renomme un cookie
     *
     * @param string $old ancien nom
     * @param string $new nouveau nom
     * @return bool|null
     */
    public function rename(string $old, string $new)
    {
        if (null != $cookie = $this->getCookie($old)) {
            $done = $this->cookiemanager
                ->name($new)
                ->content($cookie->getContent())
                ->expires($cookie->getExpires())
                ->path($cookie->getPath())
                ->domain($cookie->getDomain())
                ->secured($cookie->getSecure())
                ->httponly($cookie->getHttponly())
                ->write();

            if ($done) {
                $this->remove($old);
            }
            return $done;
        }
        return null;
    }

    /**
     * Vérfie si la donnéé était cryptée et renvoie la version décryptée
     * Sinon la renvoie le contenu du cookie
     *
     * @param string $cyphertext
     * @return string
     */
    private function withEncryption(string $cyphertext){
        if (false !== $decript = Encryption::decrypt($cyphertext)) {
          return $this->preventXSS($decript);
        }

        return $this->preventXSS($cyphertext);
    }

    /**
     * Prévenir les attaques xss
     *
     * @param string $contentt
     * @return string
     */
    private function preventXSS(string $contentt){
        return htmlspecialchars($contentt);
    }
}
