<?php

require_once __DIR__ . "/../Config/Connection.php";
require_once __DIR__ . "/../utils/ResponseMethods.php";
require_once __DIR__ . "/../middleware/CreateToken.php";

class LoginModel implements JsonSerializable{

    private $conn;
    private $user;
    private $pwd;

    public function __construct($user = '', $pwd = ''){
        
        $this -> conn = (new Connection()) -> connect(); 
        if(!$this -> conn){ throw new Exception("Error al conectar con el servidor.", 500);}
        if($user == ''){throw new Exception("Usuario no encontrado.", 401);}
        if($pwd == ''){throw new Exception("Contraseña incorrecta.",401);}    
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
        
        $stmt = $this -> conn -> prepare($sql);
        $stmt -> execute(['user' => $this -> user]);
        $result = $stmt -> fetch();
        if(!$result){throw new Exception("Credenciales inválidas", 401);}
        if(!password_verify($this -> pwd, $result['pwd'])){throw new Exception("Credenciales inválidas.", 401);}

        $createToken = CreateToken::getInstance();
        $createToken -> createToken($result);

        return [
            "user" => [
                "user" => $result['id'],
                "role" => $result['role'],
                "area" => $result['area']
            ]
        ];
    }

    
    public function jsonSerialize(): mixed{
        return get_object_vars($this);
    }
}