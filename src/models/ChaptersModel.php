<?php

require_once __DIR__ . "/../Config/Connection.php"; 

class ChaptersModel implements JsonSerializable{

    // private static $instance;
    private $conn;
    private $userId;
    private $userRole;
    private $userArea;
    // public static function getInstance(){
    //     if(self::$instance == null){
    //         self::$instance = new Self();
    //     }
    //     return self::$instance;
    // }

    public function __construct($userData){
        $this -> conn = (new Connection())->connect();
        $this -> userId = $userData['user']['user'];
        $this -> userRole = $userData['user']['role'];
        $this -> userArea = $userData['user']['area'];
    }

    public function getChaptersResearcher(){
        $sql = "SELECT * FROM chap_book WHERE userId = :userId";
        $stmt = $this -> conn -> prepare($sql);
        $stmt -> execute(['userId' => $this -> userId]);
        $result = $stmt -> fetchall();
        if(empty($result)){throw new Exception("No se encontraron Capitulos de libros del usuario",404);}
        return $result;
    }

    public function getChaptersLeadership(){
        $sql = "SELECT 
                    ch.idLibro,
                    ch.userId,
                    ch.tituloCapitulo,
                    ch.resumen,
                    ch.autores,
                    ch.posicionAutor,
                    ch.paginas,
                    ch.sectorEstrategico,
                    ch.areaConocimiento,
                    ch.tituloLibro,
                    ch.edicion,
                    ch.casaEditorial,
                    ch.fechaPublicacion,
                    ch.isbn,
                    ch.editorial,
                    ch.fechaAdicion,
                    ch.evidencia,
                    pr.firstName,
                    pr.lastName,
                    pr.area
                FROM chap_book ch 
                INNER JOIN user_profile pr
                ON ch.userId = pr.userId
                WHERE pr.area = 'ISC'";
        $stmt = $this -> conn -> prepare($sql);
        $stmt -> execute();
        $result = $stmt -> fetchAll();
        if(empty($result)){throw new Exception("No se encontraron capitulos de libros.", 404);}
        return $result;
    }

    public function getChaptersAdmin(){
        $sql = "SELECT 
                    ch.idLibro,
                    ch.userId,
                    ch.tituloCapitulo,
                    ch.resumen,
                    ch.autores,
                    ch.posicionAutor,
                    ch.paginas,
                    ch.sectorEstrategico,
                    ch.areaConocimiento,
                    ch.tituloLibro,
                    ch.edicion,
                    ch.casaEditorial,
                    ch.fechaPublicacion,
                    ch.isbn,
                    ch.editorial,
                    ch.fechaAdicion,
                    ch.evidencia,
                    pr.firstName,
                    pr.lastName,
                    pr.area
                FROM chap_book ch 
                INNER JOIN user_profile pr
                ON ch.userId = pr.userId
                ";
        $stmt = $this -> conn -> prepare($sql);
        $stmt -> execute();
        $result = $stmt -> fetchAll();
        if(empty($result)){throw new Exception("No se encontraron capitulos de libros.", 404);}
        return $result;
    }

    public function jsonSerialize(): mixed{
        return get_object_vars($this);
    }

}