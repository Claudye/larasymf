<?php
namespace Simplecode\Configuration;

use Exception;;

class ConfigFluent{

    /**
     * Le dossier de configuration
     *
     * @var string
     */
    protected $config_dir = '';

    /**
     * Config array
     *
     * @var array
     */
    protected $config = [];

    public function __construct(string $dir ='')
    {
        $this->config_dir = $dir;
        $this->set();
    }
    
    /**
     * Retourne une valeur de configuration
     *
     * @param string $name
     * @return mixed
     */
    public function get(string $name)
    {
        if ($this->has($name)) {
         
            return $this->config[$name];
          
        }else {
            
            return $this->getItem($name);
        }
        
    }


    /**
     * Enregistre retire les valeurs des fichiers
     *  de configuration
     *
     * @return void
     */
    public function set()
    {
        $directory = $this->config_dir;

        if (!is_dir($directory)) {
            throw new Exception("$directory n'est pas un chemin correcte", 1);
            
        }
        $config = scandir($directory);
        
        if (false!==$config) {
            if (is_dir($this->config_dir)) {

                $config=array_diff(scandir($directory), array('..', '.'));
                
                foreach ($config as $position => $filename) {
                
                    $info = pathinfo($filename);
                    
                    $file_name =  basename($filename, '.' . $info['extension']);
                    
                    $this->config[$file_name]=require $this->config_dir.'/'.$filename;
                }

            }
            
        }
        
    }

    /**
     * Vérifie si une clé est présente
     *
     * @param string $name
     * @return boolean
     */
    public  function has(string $name):bool{
       
        return array_key_exists($name,$this->config);
    }
    /**
     * Toute le tableau des valeurs de configuration
     *
     * @return array
     */
    public  function all():array{
       return $this->config;
    }


    private function getItem(string $name){
        $items = explode('.',$name);


        if (count($items)>1) {
           $config = $this->config;
            $a=0;
            while ($a <=count($items) && array_key_exists($items[$a],$config) ) {
               
                //Emplie les valeurs de config 
                //Exemple first $configValue
                //Search in first $configValue
               
                $config =$config [$items[$a]];

                $end = count($items) -1;
               
             
                if ($end ==$a) {
                    
                   break;
                }
               
                $a++;
              
                if (!array_key_exists($items[$a],$config)) {
                   throw new Exception(sprintf("La clé %s n'existe pas sur la configuration %s",$items[$a],$items[0]), 1);
                   break;
                }
            }
            
          return $config;
        }
        return false;
    }
}