<?php
//----> Header
include $_SERVER['DOCUMENT_ROOT'] . "/api/config/header.php";

//----> Autoload
require __DIR__ . '/vendor/autoload.php'; # Composer
require 'config/autoload.php'; # Local

//----> Dependencies

//----> Models
use App\Model\Ubicaciones;

//----> Config 
# Obtener url
$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$aUrl = explode('/', $url);
$endpoint = $aUrl[count($aUrl) - 1]; # Acceder a ultima posicion

# Obtener datos de la peticion
$request = file_get_contents('php://input');


//----> Endpoints
if($endpoint == 'get-one'){
    if(!isset($_GET['id']))
        utilGenerateErrorMessage(500, 'No se indico ningun id por los parametros de la URL');

    # Obtener usuario por id
    $id = $_GET['id'];
    $response = Ubicaciones::getById($id);
    
    # Si $categorias es null se ejecuta un mensaje de error y se corta el codigo
    utilBadConnectionMessage($response);

    echo json_encode($response);
    exit();
}

else if($endpoint == 'create' && $_SERVER["REQUEST_METHOD"] == "POST"){
    $data = json_decode($request, true);

    $response = Ubicaciones::create($data);

    echo json_encode($response);
    exit();
}

// else if($endpoint == 'get-one'){
    
// }

# Si llega hasta aqui es porque no existe la API
utilNotFoundMessage();