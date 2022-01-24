<?php
namespace Simplecode\Protocole\Http;

use Simplecode\Facades\Session;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

/**
 * Class de la réponse
 */
class Response extends HttpFoundationResponse{

    /**
     * Set json response
     *
     * @param array $data
     * @return $this
     */
    public function json(array $data = []){
        $this->headers->set('Content-Type', 'application/json');
        $this->setContent(json_encode($data));
        return $this;
    }

    public function terminate(){
      if (Session::has('_error')) {
        Session::remove('_error');
      }
      if (Session::has('_alert')) {
        Session::remove('_alert');
      }
    }
    
  
    public function with(string $var_name, $value){
      _SESSION()->set('_with',[$var_name=>$value]);
      return $this ;
  }
}