<?php 

class Libro implements JsonSerializable{
    private $id;
    private $name;
    private $autor;

    public function __construct($id, $name, $autor){
        $this -> id = $id;
        $this -> name = $name;
        $this -> autor = $autor;
    }

    public function getId(){
        return $this -> id;
    }

    public function getName(){
        return $this -> name;
    }

    public function getAutor(){
        return $this -> autor;
    }

    public function jsonSerialize(): mixed {
        return get_object_vars($this);
    }
}