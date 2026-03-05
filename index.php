<?php

require_once __DIR__ . "/src/utils/GetEnv.php";
require_once __DIR__ . "/src/utils/ResponseMethods.php";

// header("Access-Control-Allow-Origin: *");
// header("Content-Type: application/json; charset=UTF-8");
// header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

$res = GetEnv::getDbEnv();


$serverUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$requestMethod = $_SERVER['REQUEST_METHOD'];

$action = '';
$controller = '';

//rutas permitidas por la api
//lo que tienen comentario al final es por que hace falta implementar lógica
$routes = [
    'GET' => [
        '/api/me' => ['MeController','getMeData'],
        '/api/logout' => ['SessionController','logoutController'],
        '/api/getBooks' => ['BooksController','getBooks'],
        '/api/getChapters' => ['ChaptersController', 'getChapters'],
        '/api/getArticles' => [],//
        '/api/getCongress' => [],//
        '/api/getThesis' => [],//
        '/api/getProyects' => [],//
        '/api/getUsers' => [],//
        '/api/getResearchers' => [],//
        ''
    ],
    'POST' => [
        '/api/login' => ['SessionController', 'loginController'],
        '/api/createBook' => [],
        '/api/createChapter' => [],
        '/api/createArticle' => [],
        '/api/createCongress' => [],
        '/api/createThesis' => [],
        '/api/createProyects' => [],
        '/api/createUser' => [],
        '/api/createSpecialUser' => [],
    ] 
];

if(isset($routes[$requestMethod][$serverUri])){
    [$controller, $action] = $routes[$requestMethod][$serverUri];
    require_once __DIR__ . '/src/controllers/'. $controller .'.php';
    $class = $controller::getInstance();
    $class -> $action();
}else{
    ResponseMethods::printError(400,"La direccion no es válida.");
}

