<?php

require_once __DIR__ . "/../utils/ResponseMethods.php";
require_once __DIR__ . '/../middleware/HandleToken.php';

class MeController {

    private static $instance;

    public static function getInstance(){
        if(self::$instance == null){
            self::$instance = new Self();
        }
        return self::$instance;
    }

    public function getMeData(){
        try{
            if(empty($_COOKIE['session'])){throw new Exception("No se encontró la sesión.", 404);}
            $jwt = $_COOKIE['session'];
            $handdleMe = HandleToken::handleSessionToken($jwt);
            return ResponseMethods::printJSON("OK", $handdleMe);
        }catch(Exception $e){
            return ResponseMethods::printError($e -> getCode(), $e -> getMessage());
        }
    }
}