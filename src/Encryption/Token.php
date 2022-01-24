<?php
namespace Simplecode\Encryption;


class Token{

    /**
     * path
     * @var string
     */
    protected $path;
    /**
     * @var string
     */
    protected $token;

    public function __construct(string $filename)
    {
       $this->setPath($filename);
    }

    /**
     * Le byte
     * @var int
     */
    protected $byte =32;

    public function generate(){
        $key = openssl_random_pseudo_bytes($this->byte);
         $this->token =bin2hex($key);
    }

    public function regenerate(){
        $key = openssl_random_pseudo_bytes($this->byte);
        $this->token =bin2hex($key);
    }
    /**
     * Get the value of token
     *
     * @return  string
     */ 
    public function getToken():string
    {

        if (false !== $token=$this->hasToken()) {
            return $token;
        }
        return $this->token;
    }

    public function storeToken(){
        $filename =$this->getPath();
        $token = json_encode(['token'=>$this->getToken()]);
        $done=\file_put_contents($filename,$token);

        return $done !==false;
    }

    /**
     * Set path
     *
     * @param  string  $path  path
     *
     * @return  self
     */ 
    public function setPath(string $path)
    {
    
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return  string
     */ 
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Retourne le token s'il existe
     *
     * @return string|false
     */
    public function hasToken(){
        if (file_exists($filename=$this->getPath())) {
            $token_encode = file_get_contents($filename);
            $token_array = json_decode($token_encode,true);
            if (array_key_exists('token',$token_array)) {
               return $token_array['token'];
            }
            return false;
        }

        return false;
    }

    /**
     * Retourne la chaine de token
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getToken();
    }
}