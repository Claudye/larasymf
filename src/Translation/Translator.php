<?php
namespace Simplecode\Translation;

use Exception;
use Simplecode\Facades\Session;

class Translator{
    protected  $DIR ;

    protected $lang ;

    protected $translated = [];

    protected $accepts = [];

    public function __construct(){
        $this->DIR = config('app.translation');
        $this->init();

    }

    public function init(){
        $this->lang = Session::has('_lang') ? Session::get('_lang') : config('app.lang') ;
        $all = scandir($this->DIR) != false ? scandir($this->DIR) : [];
        $all= array_diff($all,['.','..']);
        $this->accepts = array_map(function($current){
            if (false!=strpos($current,".php")) {
                return substr($current, 0, -4);
            }
        },$all);
        $this->accepts=array_values($this->accepts);
        $lang = $this->lang;
        if (in_array($lang,$this->accepts)) {
            if (is_file($file= joinPath($this->DIR,$lang.'.php'))) {
            
                $langues = require $file;
    
                if (!is_array($langues)) {
                   throw new Exception(sprintf("The lang file %s must return an array",$file), 1);
                   
                }
            }else {
               
                $langues = require joinPath($this->DIR,config('app.lang') . '.php');
    
                if (!is_array($langues)) {
                   throw new Exception(sprintf("The lang file %s must return an array",$file), 1);
                   
                }
            }
    
            $this->translated = $langues;
        }
    }

    public function has(string $key){
        return array_key_exists($key, $this->translated);
    }

    public function get(string $key){
        if ($this->has($key)) {
            return $this->translated [$key];
        }

        throw new Exception("Tanslation key $key does'nt existe", 1);
        
    }

    public static function translate(string $key){
        return (new self)->get($key);
    }

    private function acceptLang(string $lang){
        return in_array($lang,$this->accepts);
    }
    public static function accept(string $lang){
        return (new self)->acceptLang($lang);
    }

    public static function accepts(){
        return (new self)->accepts;
    }
}