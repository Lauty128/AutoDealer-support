<?php

//----> Autoload
require __DIR__ . '/vendor/autoload.php'; # Composer
require 'config/autoload.php'; # Local

//----> Controllers
use App\Controller\ClientesController;

//----> Config 
# Obtener url
$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$aUrl = explode('/', $url);
$endpoint = $aUrl[count($aUrl) - 1]; # Acceder a ultima posicion

# Obtener datos de la peticion
$request = file_get_contents('php://input');
$data = json_decode($request, true);

//----> Endpoints
# Obtener listado de clientes
if($endpoint == 'get'){
    $controller = new ClientesController();
    utilExecuteController($controller, 'get');
}
# Obtener datos de un cliente
else if($endpoint == 'get-one'){
    $controller = new ClientesController();
    utilExecuteController($controller, 'getOne');
}
# Crear un cliente nuevo
else if($endpoint == 'create' && $_SERVER["REQUEST_METHOD"] == "POST"){
    $controller = new ClientesController();
    utilExecuteController($controller, 'create');
}
# Actualizar datos de un cliente
else if($endpoint == 'update' && $_SERVER["REQUEST_METHOD"] == "POST"){
    $controller = new ClientesController();
    utilExecuteController($controller, 'update');
}
# Eliminar cliente junto a sus concesionarios
else if($endpoint == 'delete' && $_SERVER["REQUEST_METHOD"] == "POST"){
    $controller = new ClientesController();
    utilExecuteController($controller, 'delete');
}

# Si llega hasta aqui es porque no existe la API
utilNotFoundMessage();
    
