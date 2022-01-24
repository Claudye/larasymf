<?php
namespace Simplecode\Cookies;

class CookieMetadataResolver
{
    /**
     * Dossier où les informations seront stockés
     */
    protected $dir = '';

    
    public function __construct()
    {
        $this->dir = __DIR__ . '/data/';
       
    }

    /**
     * Crée les informations d'un cookie
     * Et les stocker
     *
     * @param string $name le nom du cookie
     * @param string $value la valeur à enregistrer
     * @param integer $expires_or_options
     * @param string $path le chemin où le cookie sera disponible
     * @param string $domain le domaine où le cookie sera disponible
     * @param boolean $secure 
     * @param boolean $httponly
     * @param string|null $created_at
     * @return bool
     */
    public function create(string $name,$value = "",$expires_or_options = 0,$path = "",$domain = "",$secure = false,$httponly = false, string $created_at =null) {
        if (!is_dir($this->dir)) {
            mkdir( __DIR__ . '/data', 0777, true );
            $this->dir = __DIR__ . '/data/';
        }

        $filename = $this->dir.$name;

        $data = [
            'created_at' => $created_at ?? date('Y-m-d H:i:s'),
            'name'=>$name,
            'content' => $value,
            'expires' => $expires_or_options,
            'path' => $path,
            'domain' => $domain,
            'secure' => $secure,
            'httponly'=>$httponly
        ];
        $filecontent = serialize($data);
        
        $done =file_put_contents($filename,$filecontent);
        return intval($done) !==0;
  
    }

    /**
     * Retourne les informations d'un cookie
     *
     * @param string $name le nom du cookie
     * @return array
     */
    public function getInfo(string $name):array{

        if ($this->has($name)) {
            $filename=$this->dir.$name;
            $filecontent = file_get_contents($filename);
            return unserialize($filecontent);
        }

        return array();
        
    }

    /**
     * Supprime les informations d'un cookie
     *
     * @param string $name le nom du cookie
     * @return boolean
     */
    public function delete(string $name):bool{
        if ($this->has($name)) {
           unlink($this->dir.$name);
           return true;
        }
        return false;
    }

    /**
     * Si les informations par rapport à un cookie existe
     *
     * @param string $name le nom du cookie
     * @return boolean
     */
    public function has(string $name){
        return file_exists($this->dir.$name);
    }

    /**
     * Renvoie dossier où les informations seront stockés
     */ 
    public function getDir()
    {
        return $this->dir;
    }
}
