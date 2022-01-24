<?php
return [
    /**
     * Identifier to select user from database
     * That mean a email colmun exist in a users table
     */
    "identifier"=>"email",

    /** Columne that will be used for password
     * Password
     */
    "password" => "password",

    /**
     * A login url
     */
    "login"=>'/login',

    /**
     * A  register url
     */
    "register"=>'/register',

    /**
     * Url that will be user for log out user
     */

    "logout"=>'/logout',

    /**
     * Remember token column
     */
    "remember_token"=>'remember_token',
    /**
     * Url form home when user is connect
     */
    'home'=>'/dashboard'
];