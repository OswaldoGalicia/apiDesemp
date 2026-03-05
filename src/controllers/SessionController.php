<?php

require_once __DIR__ . '/../utils/ResponseMethods.php';
require_once __DIR__ . '/../services/LoginService.php';
require_once __DIR__ . '/../middleware/HandleToken.php';

class SessionController {

    private static $instance = null;

    public static function getInstance(){
        if(self::$instance == null){
            self::$instance = new Self();
        }
        return self::$instance;
    }

    public function loginController(){
        try{
            $data = json_decode(file_get_contents("php://input"), true);
            if($data == null){throw new Exception("Datos incorrectos", 400);}

            if(!isset($data['user']) || !isset($data['pwd'])){
                throw new Exception("Datos incorrectos", 400);
            }
            $user = $data['user'];
            $pwd = $data['pwd'];
            $loginService = LoginService::getInstance();
            $res = $loginService -> loginService($user, $pwd);
            return ResponseMethods::printJSON("OK", $res);
            
        }catch(Exception $e){
            return ResponseMethods::printError($e -> getCode(), $e -> getMessage());
        }
    }

    public function logoutController(){
        try{
            if(!isset($_COOKIE['session'])){
                throw new Exception("Sesión no encontrada", 404);
            }
            HandleToken::unsetSessionToken();
            
            ResponseMethods::printJSON("OK");
        }catch (Exception $e) {
            return ResponseMethods::printError($e -> getCode(), $e -> getMessage());
        }
    }
}

