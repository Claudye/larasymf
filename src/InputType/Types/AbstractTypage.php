<?php
namespace Simplecode\InputType\Types;

use Exception;
/**
 * Abstract type class
 * @author Claude Fassinou <dev.claudy@gmail.com>
 * @license 
 * @copyright 2021 Inputtype
 */
abstract class AbstractTypage{
    /**
     * Input value
     *
     * @var [type]
     */
    protected $input ;

    /**
     * The type
     *
     * @var string
     */
    protected $type ;

    /**
     * Exception throw status
     *
     * @var boolean
     */
    protected $throw_exception = false;
    /**
     * Construct the type
     *
     * @param mixed $input
     * @param boolean $throw_exception
     */
    public function __construct($input, bool $throw_exception=false)
    {
        $this->throw_exception = $throw_exception ;
        $this->set($input);
    }
    /**
     * Check if $input match wiyh this type
     *
     * @return boolean
     */
    public abstract function isValid():bool;

    /**
     * 
     * Set the input to this type
     * @param mixed $value
     * @return void
     */
    public function set($value){
        $this->input = $value ;
        if (!$this->isValid()) {
            $this->throw();
        }
    }
    /**
     * Get this input
     *
     * @return mixed
     */
    public function get(){
        return $this->input;
    }

    /**
     * Get this type as input
     *
     * @return string
     */
    public function __toString()
    {
        return $this->get() ;
    }

    /**
     * Thrown an exception if this input don't match with this type
     *
     * @return void
     */
    protected function throw(){
        if ($this->throw_exception) {
            throw new Exception(sprintf("This value %s not match with %s type",$this->input,$this->type), 1); 
         }
    }
}