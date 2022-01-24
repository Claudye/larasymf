<?php
namespace Simplecode\DI\Exceptions;

use Exception;
use Simplecode\DI\Interfaces\NotFoundExceptionInterface;
/**
 *  Lève une exception
 */
class NotFoundException extends Exception implements NotFoundExceptionInterface{
   
    public function eMessage(){
        return $this->getMessage();
    }

    public function throw(){
        echo "<strong>".$this->getMessage() .'</strong><br>';
        echo "Erreur attrapée dans le fichier ".$this->getFile() .'<br>';
        echo "à la ligne <strong>".$this->getLine() .'</strong><br>';
        echo "La trace du code ".$this->getTraceAsString() .'<br>';
    }
}