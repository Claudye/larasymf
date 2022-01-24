<?php
namespace Simplecode\Protocole\Http\Clients;

use Simplecode\Protocole\Http\Parameters;

class Headers extends Parameters{
    /**
     * Initialise les entetes de requetes
     */
    public function __construct()
    {
        $this->parameters = $_SERVER;
    }
}