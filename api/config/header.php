<?php

// Configuracion de CORS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    // This error solution ocurred when trying to send a autentication header
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Authorization");
    header("Access-Control-Allow-Credentials: true");
    header("Content-Length: 0");
    header("Content-Type: text/plain");
    exit();
}

// Specify domains from which requests are allowed
header("Access-Control-Allow-Origin: *");
// Specify which request methods are allowed
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
// Indicar devolucion de JSON
header( "Content-type: application/json" );