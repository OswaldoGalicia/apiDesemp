<?php

require_once __DIR__ . "/../models/ChaptersModel.php";

class ChaptersService{

    private $userData;

    public function __construct($userData){
        $this -> userData = $userData;
    }

    public function chaptersService(){
        $chapterModel = new ChaptersModel($this -> userData); 
        switch($this -> userData['user']['role']){
            case 'user':
                    throw new Exception("El rol no tiene permitido ver este contenido.", 401);
                break;

            case 'researcher':
                return $chapterModel -> getChaptersResearcher();
                break;

            case 'leadership':
                return $chapterModel -> getChaptersLeadership();
                break;

            case 'admin':
                return $chapterModel -> getChaptersAdmin();
                break;

            default:
                throw new Exception("No se encuentra este proceso.", 404);
                break;
        }
    }
}