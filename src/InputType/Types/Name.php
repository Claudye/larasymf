<?php
namespace Simplecode\InputType\Types;
/**
 * Basic user name type
 * @inheritDoc
 */
class Name extends AbstractTypage{
    /**
     *Text input
     *
     * @var string
     */
    protected $input ;

    /**
     * Name
     *
     * @var string
     */
    protected $type = __CLASS__;

    /**
     * Construct name type
     *
     * @param string $value
     * @param boolean $thow_exception
     */
    public function __construct($value, bool $thow_exception=false)
    {
        $this->throw_exception = $thow_exception ;
        $this->set($value);
    }
    public function isValid(): bool
    {
        return preg_match('/^[^0-9]{2,}/',$this->input);
    }
    
}