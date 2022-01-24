<?php
namespace Simplecode\InputType\Types;
/** 
 * Username type
 * @inheritDoc
 */
class Username extends AbstractTypage{
    /**
     *Text input
     *
     * @var string
     */
    protected $input ;

    protected $type = __CLASS__;

    public function __construct($value, bool $thow_exception=false)
    {
        $this->throw_exception = $thow_exception ;
        $this->set($value);
    }
    public function isValid(): bool
    {
        return preg_match('/^[a-zA-Z]+[0-9a-zA-Z\._]+$/i',$this->input);
    }
    
}