<?php
namespace Simplecode\InputType\Types;


class Email extends AbstractTypage{
    /**
     *Email input
     *
     * @var string
     */
    protected $input ;
    /**
     * Email type
     *
     * @var string
     */
    protected $type = __CLASS__;

    /**
     * Set email
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
        return FALSE!== filter_var($this->input,FILTER_VALIDATE_EMAIL);
    }
    
}