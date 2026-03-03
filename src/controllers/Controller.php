<?php

require_once __DIR__ . "/../services/Services.php";
require_once __DIR__ . '/../utils/ResponseMethods.php';

class Controller{

    private $requestMethod;
    private $Service;

    private static $instance = null;

    public static function getInstance(){
        if(self::$instance == null){
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function __construct(){
        $this -> Service = Service::getInstance();
    }

    public function processRequest(){

        if($this -> requestMethod === 'GET'){
            $this -> getCase();
        }else if($this -> requestMethod === 'POST'){
            $this -> postCase();
        } else {
            ResponseMethods::printError(400);
        }
    }


    private function getCase(){
        $this -> getData();
    }

    private function postCase(){
        
    }

    private function getData(){
        try{
            $data = $this -> Service -> getBooks();
            if(gettype($data) !== 'array' && is_array($data)) ResponseMethods::printError(400);
            if(sizeof($data) == 0) ResponseMethods::printError(400);
            ResponseMethods::printJSON("OK", $data);
        }catch(Exception $e){
            ResponseMethods::printError(500);
        }
    }

}

