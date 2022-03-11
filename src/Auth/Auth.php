<?php

namespace Simplecode\Auth;

use App\Models\User;
use Simplecode\Facades\Session;

class Auth extends Authenticate
{

    public const AUTHSSID = '_auth';

    /**
     * Vérifie si un utilisateur est authentifié
     *
     * @return boolean
     */
    public function isConnected()
    {
        return is_object($this->auth());
    }

    /**
     * Return this
     *
     * @return Auth
     */
    public function authentificate()
    {
        return $this;
    }

    /**
     * Return les informations 
     * de l'utilisateur actuellement connecté
     *
     * @return User|null
     */
    public function auth()
    {   
         if (Session::has(Auth::AUTHSSID)) {
            return User::find(Session::get(Auth::AUTHSSID));
        }
    }

  

    public function disconnect()
    {
        $this->session->remove(Auth::AUTHSSID);
        return;
    }

    /**
     * Connecte un utilisateur
     *
     * @param array $info
     * @return User|NULL
     */
    public function connect(array $info){
       
        $this->userinfo=$info;

        /**
         * L'identifiant
         */
        $id= array_key_exists($this->identify,$this->userinfo) ? $this->userinfo[$this->identify] : $this->identify;
        $password= array_key_exists($this->password,$this->userinfo) ? $this->userinfo[$this->password] : $this->password;
        /**
         * Connection à la base de donné
         */
        $user=User::where($this->identify,$id)->first();
        if (null !=$user) {
            if (isset($user->{$this->identify}) && isset($user->{$this->password})) {
                if ($this->verifyPassword($password,$user->{$this->password})) {
                    $this->auth = $user;
                }
                
            }
        }
        
        return $this->auth;
    }

}
