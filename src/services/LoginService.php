<?php

require_once __DIR__ . '/../models/LoginModel.php';

class LoginService{
    private static $instance = null;

    public static function getInstance(){
        if(self::$instance == null){
            self::$instance = new Self();
        }
        return self::$instance;
    }

    //Aqui es donde se elige a donde ir con los datos que manda en controller

    public function loginService($username, $pwd){
        $loginModel = new LoginModel($username, $pwd);
        return $loginModel -> handleLogin();
        
    }
}