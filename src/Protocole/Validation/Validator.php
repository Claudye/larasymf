<?php 
namespace Simplecode\Protocole\Validation;

use Simplecode\Database\DB;

class Validator{
    /**
     * Method
     *
     * @var string
     */
    protected $method='';

    protected  $option = [];

    /**
     * Value
     *
     * @var mixed
     */
    protected $value;
    /**
     * Check if value is not empty
     *
     * @param mixed $value
     * @return bool
     */
    public function notEmpty($value){
        return !empty($value);
    }

    public function min($value, int $min){
        return strlen($value)>= $min;
    }
    public function max($value, int $max){
        return strlen($value)<= $max;
    }
    /**
     * Check if value is string
     *
     * @param string $value
     * @return bool
     */
    public function string($value){
        return is_string($value);
    }
    public function done(){
        $method = $this->method ;
        $args = array_merge([$this->value],$this->option[$method]);
        return $this->{$method}(...$args);
    }
    /**
     * Valide email
     *
     * @param  $value
     * @return bool
     */
    public function email($value){
        return FALSE!== filter_var($value,FILTER_VALIDATE_EMAIL);
    }

    public function valide($value){
        $this->value = $value ;

        return $this;
    }

    public function with(string $method, array $option = []){
        $this->method = $method ;
        $this->option[$method] = $option ;
        return $this;
    }
    /**
     * Check value
     *
     * @param  $string
     * @return bool
     */
    public function required($string=null){
        return isset($string) && $this->notEmpty($string);
    }
    /**
     * Check if a value existe
     *
     * @param mixed $value
     * @param string $filed
     * @param string $on
     * @return bool
     */
    public function unique($value,string $on, string $filed){
        return !DB::table($on)->where($filed,$value)->exists();
    }
}