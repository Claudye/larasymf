<?php
class AuthSession{
    public function addAuth(int $id){
        $_SESSION['_auth']= $id;
    }
   
}