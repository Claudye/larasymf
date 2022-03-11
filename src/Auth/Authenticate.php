<?php
namespace Simplecode\Auth;
abstract class Authenticate{

    /**
     * Identifant
     *
     * @var string
     */
    protected $identify = 'email';

    /**
     * Passeword
     *
     * @var string
     */
    protected $password ='password';


    protected $userinfo =[];

    /**
     * L'utilisateur paser
     *
     * @var \Components\Models\User|null
     */
    protected $auth;

    public function __construct(array $userinfo = [])
    {

        $this->userinfo =$userinfo;

        $this->auth = null;
    }

    public static function hash($password,$algo =PASSWORD_DEFAULT){
        return password_hash($password, $algo);
    }

    /**
     * Checks if the given password matches with
     * database password
     *
     * @param string|int $password
     * @param string $hash
     * @return boolean
     */
    public function verifyPassword($password,string $hash){
       return  password_verify($password,$hash);
    }
    
}