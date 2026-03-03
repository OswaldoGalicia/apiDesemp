<?php

require_once __DIR__ . '/../utils/ResponseMethods.php';


class BooksController {

    private static $instance = null;

    public static function getInstance(){
        if(self::$instance == null){
            self::$instance = new Self();
        }
        return self::$instance;
    }

    public function getBooks(){
        echo "Phillip - Cámara";
        
    }
}