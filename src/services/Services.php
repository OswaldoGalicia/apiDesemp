<?php

require_once __DIR__ . "/../models/Model.php";

class Service{
    private static $instance = null;

    public static function getInstance(){
        if(self::$instance == null){
            self::$instance = new Self();
        }
        return self::$instance;
    }


    public function getBooks(){
        $libros = array();
        //logica para extraer libros de la bd
        array_push($libros, new Libro(1, "Teoria de cuerdas", "Os galicia") );
        return $libros;
    }
}