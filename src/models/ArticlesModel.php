<?php

require_once __DIR__ . "/../Config/Connection.php";

class ArticlesModel{

    private $conn;
    private $userId;
    private $userRole;
    private $userArea;
    
    public function __construct($userData){
        $this -> conn = (new Connection()) -> connect();
        $this -> userId = $userData['user']['user'];
        $this -> userRole = $userData['user']['role'];
        $this -> userArea = $userData['user']['area'];
    }

    public function getArticlesResearcher(){
        $sql = "SELECT 
                    a.idArticulo,
                    a.tituloArticulo,
                    a.nombreRevista,
                    a.autoresArticulo,
                    a.propositoAutor,
                    a.resumen,
                    a.estadoArticulo,
                    a.fechaArticulo,
                    a.casaEditorial,
                    a.sectorArticulo,
                    a.areaConocimiento,
                    a.tipoArticulo,
                    a.RangoPaginas,
                    a.indiceRegistro,
                    a.issn,
                    p.firstName,
                    p.lastName
                FROM articulos a
                INNER JOIN user_profile p
                ON  p.userId = a.userId 
                WHERE a.userId = :userId";
        $stmt = $this -> conn -> prepare( $sql );
        $stmt -> execute(['userId' => $this -> userId]);
        $result = $stmt -> fetchAll();
        if(empty($result)){throw new Exception("No se encontraron Capitulos de libros del usuario", 404);}
        return $result;
    }

    public function getArticlesLeadership(){
        $sql = "SELECT 
                    a.idArticulo,
                    a.tituloArticulo,
                    a.nombreRevista,
                    a.autoresArticulo,
                    a.propositoAutor,
                    a.resumen,
                    a.estadoArticulo,
                    a.fechaArticulo,
                    a.casaEditorial,
                    a.sectorArticulo,
                    a.areaConocimiento,
                    a.tipoArticulo,
                    a.RangoPaginas,
                    a.indiceRegistro,
                    a.issn,
                    p.firstName,
                    p.lastName
                FROM articulos a
                INNER JOIN user_profile p
                ON  p.userId = a.userId
                WHERE p.area = :area
        ";
        $stmt = $this -> conn -> prepare($sql);
        $stmt -> execute(['area' => $this -> userArea]);
        $result = $stmt -> fetchall();
        if(empty($result)){throw new Exception("No se encontraron Capitulos de libros del usuario", 400);}
        return $result; 
    }

    public function getArticlesAdmin(){
        $sql = "SELECT 
                    a.idArticulo,
                    a.tituloArticulo,
                    a.nombreRevista,
                    a.autoresArticulo,
                    a.propositoAutor,
                    a.resumen,
                    a.estadoArticulo,
                    a.fechaArticulo,
                    a.casaEditorial,
                    a.sectorArticulo,
                    a.areaConocimiento,
                    a.tipoArticulo,
                    a.RangoPaginas,
                    a.indiceRegistro,
                    a.issn,
                    p.firstName,
                    p.lastName
                FROM articulos a
                INNER JOIN user_profile p
                ON  p.userId = a.userId
        ";
        $stmt = $this -> conn -> prepare($sql);
        $stmt -> execute();
        $result = $stmt -> fetchall();
        if(empty($result)){throw new Exception("No se encontraron Capitulos de libros del usuario");}
        return $result;
    }
}