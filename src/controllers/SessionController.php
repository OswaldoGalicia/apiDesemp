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
            if($data == null){return ResponseMethods::printError(400);}

            if(!isset($data['user']) || !isset($data['pwd'])){
                return ResponseMethods::printError(400);
            }
            $user = $data['user'];
            $pwd = $data['pwd'];
            $loginService = LoginService::getInstance();
            $res = $loginService -> loginService($user, $pwd);
            ResponseMethods::printJSON("OK", $res);
            
        }catch(Exception $e){

        }
    }

    public function logoutController(){
        try{

            if(isset($_COOKIE['session'])){
                $response = HandleToken::unsetSessionToken();
                if(isset($response['error'])){
                    ResponseMethods::printError(500, $response['error']);
                }
                ResponseMethods::printJSON("OK");
            }else{
                ResponseMethods::printError(400, "Session not set");
            }
        }catch (Exception $e) {
            ResponseMethods::printError(500);
        }
    }
}

