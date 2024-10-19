<?php

//---> Configuraciones y utilidades
include "config/header.php";
include "config/config.php";
include "includes/utils.php";

//---> Conexion con la base de datos
include 'includes/database.php';

//---> Controladores
include 'controllers/clientes.controller.php';
include 'controllers/concesionarios.controller.php';

//---> Modelos
include 'models/clientes.model.php';
include 'models/concesionarios.model.php';
include 'models/ubicaciones.model.php';


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