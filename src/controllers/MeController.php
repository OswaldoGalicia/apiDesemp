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
            $jwt = $_COOKIE['session'] ?? null;
            $handdleMe = HandleToken::handleSessionToken($jwt);
            ResponseMethods::printJSON("OK", $handdleMe);
        }catch(Exception $e){
            ResponseMethods::printError(500);
        }
    }
}