<?php

require_once __DIR__ . "/../utils/ResponseMethods.php";
require_once __DIR__ . "/../middleware/HandleToken.php";
require_once __DIR__ . "/../services/ArticlesService.php";

class ArticlesController{
    
    private static $instance;

    public static function getInstance(){
        if(self::$instance == null){
            self::$instance = new Self();
        }
        return self::$instance;
    }

    public function getArticles(){
        try{
            //verificamos sesion
            if(empty($_COOKIE['session'])){throw new Exception("No se encontró una sesión activa.", 400);}
            $cookie = $_COOKIE['session'];
            //pasamos session a cookie para verificar usuario 
            $response = HandleToken::handleSessionToken($cookie);
            //pasamos sesion a service
            $articlesService = new ArticlesService($response);
            $result = $articlesService -> articlesService();
            //regresamos el resultado de service
            ResponseMethods::printJSON("Ok", $result);
        }catch(Exception $e){
            ResponseMethods::printError($e ->getCode(), $e -> getMessage());
        }
    }
}