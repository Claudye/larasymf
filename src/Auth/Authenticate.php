<?php
namespace Simplecode\Auth;
/**
 * @author Claude Fassinou <dev.claudy@gmail.com>
 * 
 * @license MIT
 * 
 * @copyright 2022 Larasymf
 */
abstract class Authenticate{

    /**
     * Identifier
     *
     * @var string
     */
    protected $identify = 'email';

    /**
     * Password
     *
     * @var string
     */
    protected $password ='password';


    protected $userinfo =[];

    /**
     * L'utilisateur paser
     *
     * @var \App\Models\User|null
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