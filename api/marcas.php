<?php

//----> Autoload
require __DIR__ . '/vendor/autoload.php'; # Composer
require 'config/autoload.php'; # Local

//----> Controllers
use App\Controller\MarcasController;

//----> Config 
# Obtener url
$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$aUrl = explode('/', $url);
$endpoint = $aUrl[count($aUrl) - 1]; # Acceder a ultima posicion

# Obtener datos de la peticion
$request = file_get_contents('php://input');
$data = json_decode($request, true);

//----> Endpoints
# Obtener listado de marcas
if($endpoint == 'get'){
    $controller = new MarcasController();
    utilExecuteController($controller, 'get');
}
# Crear una marca nueva
else if($endpoint == 'create' && $_SERVER["REQUEST_METHOD"] == "POST"){
    $controller = new MarcasController();
    utilExecuteController($controller, 'create');
}
# Actualizar datos de una marca
else if($endpoint == 'update' && $_SERVER["REQUEST_METHOD"] == "POST"){
    $controller = new MarcasController();
    utilExecuteController($controller, 'update');
}
# Eliminar marca junto a sus vhiculos
else if($endpoint == 'delete' && $_SERVER["REQUEST_METHOD"] == "POST"){
    $controller = new MarcasController();
    utilExecuteController($controller, 'delete');
}

# Si llega hasta aqui es porque no existe la API
utilNotFoundMessage();
    
