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

class createToken{
    
    private $secret;
    private $expirationTime;
    private $path;
    private $secure;
    private $httponly;
    private $samesite;
    private $domain;

    public function __construct(){
        $this -> secret = getenv('JWT_SECRET');
        $this -> expirationTime = 60 * 60;
        $this -> path = '/';
        //$this -> domain = getenv('API_DOMAIN');
        $this -> secure = false;
        $this -> httponly = true;
        $this -> samesite ='Lax';
    }
    private static $instance = null;

    public static function getInstance(){
        if(self::$instance == null){
            self::$instance = new Self();
        }
        return self::$instance;
    }

    public function createToken($data){
        try{

            $payload = [
                'user' => $data['id'],
                'role' => $data['role'],
                'area' => $data['area'],
                'iat' => time(),
                'exp' => time() + $this -> expirationTime
                ];         

                $jwt = JWT::encode($payload, $this -> secret, 'HS256');

                setcookie("session", $jwt, [
                    'expires' => time() + $this -> expirationTime,
                    'path' => $this -> path,
                    //'domain' => $this -> domain,
                    'secure' => $this -> secure,
                    'httponly' => $this -> httponly,
                    'samesite' => $this -> samesite
                ]);

                return $jwt;
        } catch (Exception $e){
            return null;
        }
    }
}