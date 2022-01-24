<?php

namespace Simplecode\Auth;
use Simplecode\Auth\Auth;
use Simplecode\Facades\Session;

class Login
{

    /**
     * Connecte un utilisateur
     * @param array $info
     * @return AuthStdClass|null
     */
    public static function login(array $info = [])
    {
        $auth = new Auth;
        $auth =$auth->connect($info);
        if (null != $auth) {
          Session::set(Auth::AUTHSSID,$auth->id);
        }
        return $auth;
    }


}
