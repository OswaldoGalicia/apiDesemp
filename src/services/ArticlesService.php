<?php 
require_once __DIR__ . "/../models/ArticlesModel.php";

class ArticlesService{

    private $userData;

    public function __construct($userData){
        $this -> userData = $userData;
    }

    public function articlesService(){
        $articlesModel = new ArticlesModel($this -> userData);
        switch ($this -> userData['user']['role']){
            case 'guest':
                    throw new Exception("El rol no tiene permitido ver este contenido", 401);
                    break;
            case 'researcher':
                return $articlesModel -> getArticlesResearcher();
                break;
            case 'leadership':
                return $articlesModel -> getArticlesLeadership();
                break;
            case 'admin':
                return $articlesModel -> getArticlesAdmin();
                break;
            default:
                throw new Exception("No se encuentra este proceso.",401);
                break;
        }
    }
}