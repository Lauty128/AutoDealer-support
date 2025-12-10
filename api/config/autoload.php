<?php

//---> Configuraciones y utilidades
//include $_SERVER['DOCUMENT_ROOT'] . "/api/config/header.php";
include $_SERVER['DOCUMENT_ROOT'] . "/api/config/config.php";
include $_SERVER['DOCUMENT_ROOT'] . "/api/includes/utils.php";

//---> Conexion con la base de datos
include $_SERVER['DOCUMENT_ROOT'] . '/api/includes/database.php';

//---> Controladores
include $_SERVER['DOCUMENT_ROOT'] . '/api/controllers/clientes.controller.php';
include $_SERVER['DOCUMENT_ROOT'] . '/api/controllers/concesionarios.controller.php';
include $_SERVER['DOCUMENT_ROOT'] . '/api/controllers/marcas.controller.php';
include $_SERVER['DOCUMENT_ROOT'] . '/api/controllers/facturas.controller.php';

//---> Modelos
include $_SERVER['DOCUMENT_ROOT'] . '/api/models/clientes.model.php';
include $_SERVER['DOCUMENT_ROOT'] . '/api/models/concesionarios.model.php';
include $_SERVER['DOCUMENT_ROOT'] . '/api/models/ubicaciones.model.php';
include $_SERVER['DOCUMENT_ROOT'] . '/api/models/marcas.model.php';
include $_SERVER['DOCUMENT_ROOT'] . '/api/models/facturas.model.php';


//---> Importar modelos dinamicamente

# Verificar el archivo al cual se esta accediendo
// $script_url = $_SERVER["SCRIPT_FILENAME"];
// $model_include = 'categorias.php';

// if(str_contains($script_url, 'api/')){
//     $aScript_url = explode('api/', $script_url); 
//     $model_include = str_replace('.php', '.model.php', $aScript_url[1]);
// }

# Solo importar el que se necesita o categoria.model.php 
// include("models/".$model_include);