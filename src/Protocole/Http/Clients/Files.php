<?php
namespace Simplecode\Protocole\Http\Clients;

use Simplecode\Protocole\Http\Parameters;

class Files extends Parameters{
    public function __construct()
    {   
        $this->parameters = $_FILES;
         $this->init();
    }

    /**
     * Initiate upload
     *
     * @return File
     */
    private function init(){
        foreach ($this->parameters as $name => $file) {
            
            $this->parameters [$name] =  new File($file);
        }
    }
/**
 * Retourne le fichier téléchargé
 *
 * @param string $name
 * @return File|null
 */
    public function get(string $name, $default=null)
    {
        return parent::get($name, $default);
    }
}