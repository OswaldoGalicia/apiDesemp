<?php 

require_once __DIR__ . "/../utils/ResponseMethods.php";

class Connection{
    private $user;
    private $pwd;
    private $dbc;
    private $opt;

    public function __construct(){
        $this -> user = getenv('DB_USER');
        $host = getenv('DB_HOST');
        $this -> pwd = getenv('DB_PWD');
        $db = getenv('DB_NAME');
        $charset = getenv('DB_CHARSET'); 
        $this -> dbc = "mysql:host=$host;dbname=$db;charset=$charset";
        $this -> opt =[
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
        }
        public function connect(){
            try{
                $conn = new PDO($this -> dbc, $this -> user, $this -> pwd, $this -> opt);
            }catch(PDOException $e){
                throw new Exception("Error en la conexion con el servidor. (80)", 500);
            }
            return $conn;
        }
}