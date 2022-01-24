<?php
namespace Simplecode\Protocole\Http\Clients;

use Exception;

class File
{

    protected $name = '';

    protected $type = '';

    protected $tmp_name = '';

    protected $size;

    protected $extension = '';

    protected $dest_path = '';


    public function __construct(array $files)
    {
        $this->setStoragePath();
        $this->createFactory($files);

    }
    /**
     * Initialise 
     *
     * @param array $files les files uploadés
     * @return $this
     */
    public function createFactory(array $files)
    {
        $file = isset($files) ? $files : $_FILES;
        
            if ($file['error'] == UPLOAD_ERR_OK) {
                               /**
                 * nom du fichier
                 */
                $filename = basename($file["name"]);


                $this->name = $filename;

                // type du fichier
                $this->type = $file['type'];

                // fichier temporai
                $this->tmp_name = $file['tmp_name'];

                // Taile
                $this->size = $file['size'];
                // extension
                $this->extension = $this->getExtension($filename);

            }
        

        return $this;
    }

    private function getExtension(string $fileName)
    {

        $fileNameCmps = explode(".", $fileName);
        return strtolower(end($fileNameCmps));
    }

    private function setStoragePath(string $storage = '')
    {
        if ('' != $storage) {
            $this->dest_path = $storage;
        } else {
            $storage_path = config('app.storage_path');
            if (!is_dir($storage_path)) {
                throw new Exception("$storage_path n'est pas un chemin valide", 1);
            }
            $this->dest_path = rtrim($storage_path, '/') . '/';
            
        }
    }

    /**
     * Get the value of dest_path
     * @return string
     */
    public function getDest_path()
    {
        return $this->dest_path;
    }

    /**
     * Enregistre un fichier de formulaire
     *
     * @param string $path
     * @return $this
     */
    public function upload(string $path)
    {
        $this->name=trim($path, '/').'/'.$this->name;
        if (!is_dir($dir=$this->getDest_path().trim($path, '/'))) {
          mkdir($dir);
        }
        
        if ('' != $path) {
            
            $dest = $this->getDest_path() .$this->name;
            if (move_uploaded_file($this->tmp_name, $dest)) {
                return $this;
            }
        } else {
            if (move_uploaded_file($this->tmp_name, $this->getDest_path())) {

                return $this;
            }
        }
        return  $this->name;
    }

    public function __toString()
    {
        return $this->name;
    }

    /**
     *Le fichier temporaire
     *
     * @return string
     */
    public function filename(){
        return $this->name;
    }

    /**
     * Check if file exist
     *
     * @return boolean
     */
    public function exist(){
        return $this->tmp_name !='';
    }
}
