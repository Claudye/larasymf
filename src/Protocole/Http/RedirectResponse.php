<?php
namespace Simplecode\Protocole\Http;

use Symfony\Component\HttpFoundation\RedirectResponse as SfRedirectResponse;

class RedirectResponse extends SfRedirectResponse{
    public function with(string $var_name, $value){
        _SESSION()->set('_with',[$var_name=>$value]);
        return $this ;
    }
}