<?php
//----> Header
include $_SERVER['DOCUMENT_ROOT'] . "/api/config/header.php";

//----> Autoload
require __DIR__ . '/vendor/autoload.php'; # Composer
require 'config/autoload.php'; # Local

//----> Controllers
use App\Controller\ConcesionariosController;
use App\Model\Concesionario;

//----> Ejecucion de API
# Obtener url
$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$aUrl = explode('/', $url);
$endpoint = $aUrl[count($aUrl) - 1]; # Acceder a ultima posicion

# Obtener datos de la peticion
$request = file_get_contents('php://input');
// Solo usar si los datos son enviados en formato JSON
$data = json_decode($request, true);

//----> Endpoints
# Obtener listado de todos los concesionarios
if($endpoint == 'get'){
    $controller = new ConcesionariosController();
    utilExecuteController($controller, 'getAll');
}
# Obtener datos de un concesionario
else if($endpoint == 'get-one'){
    $controller = new ConcesionariosController();
    utilExecuteController($controller, 'getOne');
}
# Crear un concesionario nuevo
else if($endpoint == 'create' && $_SERVER["REQUEST_METHOD"] == "POST"){
    $controller = new ConcesionariosController();
    utilExecuteController($controller, 'create');
}
# Actualizar datos de un concesionario
else if($endpoint == 'update' && $_SERVER["REQUEST_METHOD"] == "POST"){
    $controller = new ConcesionariosController();
    utilExecuteController($controller, 'update');
}
# Eliminar concesionario junto a sus concesionarios
else if($endpoint == 'delete' && $_SERVER["REQUEST_METHOD"] == "POST"){
    $controller = new ConcesionariosController();
    utilExecuteController($controller, 'delete');
}

# Si llega hasta aqui es porque no existe la API
utilNotFoundMessage();
    
