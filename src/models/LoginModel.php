<?php

require_once __DIR__ . "/../Config/Connection.php";
require_once __DIR__ . "/../utils/ResponseMethods.php";
require_once __DIR__ . "/../middleware/CreateToken.php";

class LoginModel implements JsonSerializable{

    private $conn;
    private $user;
    private $pwd;

    public function __construct($user = '', $pwd = ''){
        try{
            $this -> conn = (new Connection()) -> connect(); 
        } catch(PDOException $e){
            return ResponseMethods::printError(500);
        }
        if($user == ''){ResponseMethods::printError(401);}
        if($pwd == ''){ResponseMethods::printError(401);}    
        $this -> user = $user;
        $this -> pwd = $pwd;
    }


    public function handleLogin(){
        $sql = "SELECT 
                    u.id,
                    u.username,
                    r.role,
                    p.area,
                    u.pwd 
                FROM users u 
                INNER JOIN user_roles r 
                ON u.id = r.userId 
                INNER JOIN user_profile p
                ON u.id = p.userId
                WHERE username = :user";
        try{
            $stmt = $this -> conn -> prepare($sql);
            $stmt -> execute(['user' => $this -> user]);
            $result = $stmt -> fetch();
            if(!$result){return ResponseMethods::printError(401, "Credenciales inválidas");}
            if(!password_verify($this -> pwd, $result['pwd'])){return ResponseMethods::printError(401, "Credenciales inválidas. (1)");}

            $createToken = CreateToken::getInstance();
            $createToken -> createToken($result);

            return [
                "user" => [
                    "user" => $result['id'],
                    "role" => $result['role'],
                    "area" => $result['area']
                ]
            ];
        } catch (PDOException $e) {
            ResponseMethods::printError(500, $e);
        }
    }

    
    public function jsonSerialize(): mixed{
        return get_object_vars($this);
    }
}