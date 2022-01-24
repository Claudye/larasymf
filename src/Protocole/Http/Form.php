<?php
namespace Simplecode\Protocole\Http;

use Simplecode\Protocole\Validation\Validator;

class Form extends Request{
     /**
     * Validator
     *
     * @var Validator
     */
    protected $validator ;
    
    public function __construct()
    {
        $this->validator = new Validator;
    }
    /**
     * Valid value with method
     *
     * @param string $method
     * @param mixed $value
     * @return boolean
     */
    public function isValid(string $method, $value, array $options=[]){
        $this->validator->valide($value)->with($method, $options);
        return $this->validator->done();
    }
}