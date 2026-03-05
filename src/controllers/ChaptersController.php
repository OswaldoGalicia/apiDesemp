<?php 

require_once __DIR__ . "/../utils/ResponseMethods.php";
require_once __DIR__ . "/../middleware/HandleToken.php";
require_once __DIR__ . "/../services/ChaptersService.php";

class ChaptersController{

    private static $instance;
    
    public static function getInstance(){
        if(self::$instance == null){
            self::$instance = new Self();
        }
        return self::$instance;
    }

    public function __construct(){

    }

    public function getChapters(){
        try{
            if(empty($_COOKIE['session'])){throw new Exception("No se detecto una sesión.",400);}
            $cookie = $_COOKIE['session'];  
            $sessionData = HandleToken::handleSessionToken($cookie);
            $chaptersServiceInstance = new ChaptersService($sessionData);
            $result = $chaptersServiceInstance -> chaptersService();
            return ResponseMethods::printJSON("OK", $result);
        }catch(Exception $e){
            return ResponseMethods::printError($e -> getCode(), $e->getMessage());
        }
    }

}