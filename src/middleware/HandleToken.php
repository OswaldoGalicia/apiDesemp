<?php

require_once __DIR__ . "/../../libs/jwtFirebase/JWTExceptionWithPayloadInterface.php";
require_once __DIR__ . "/../../libs/jwtFirebase/JWT.php";
require_once __DIR__ . "/../../libs/jwtFirebase/Key.php";
require_once __DIR__ . "/../../libs/jwtFirebase/SignatureInvalidException.php";
require_once __DIR__ . "/../../libs/jwtFirebase/BeforeValidException.php";
require_once __DIR__ . "/../../libs/jwtFirebase/ExpiredException.php";
require_once __DIR__ . "/../../libs/jwtFirebase/CachedKeySet.php";
require_once __DIR__ . "/../../libs/jwtFirebase/JWK.php";

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class HandleToken {

    public static function handleSessionToken($jwt){
        try{
            $secret = getenv('JWT_SECRET');
            $decoded = JWT::decode($jwt, new Key($secret, 'HS256'));
            $userId = $decoded -> user;
            $role = $decoded -> role;
            $area = $decoded -> area;
            return [$userId, $role, $area];
        } catch (Exception $e) {
            ResponseMethods::printError(404);
        }
    }

    public static function unsetSessionToken(){
        try{
            setcookie("session","", [
                'expires' => time() - 3600,
                'path' => "/",
                //'domain' => $this -> domain,
                'secure' => false,
                'httponly' => true,
                'samesite' => "None"
                ]);
                return ['OK'];
        } catch (Exception $e){
            return ['error' => 'Error (2)'];
        }
    }
}