<?php

 /**
 * Devolver mensaje para consulta fallida
 **/
function utilBadConnectionMessage($data){
    global $url;

    if(gettype($data) === 'NULL'){
        $response = [
            'message' => 'Ocurrio un error durante la consulta',
            'status' => 500,
            'url' => $url
        ];

        http_response_code(500);
        echo json_encode($response);
        exit();
    }
}

 /**
 * Devolver mensaje para api inexistente
 **/
function utilNotFoundMessage(){
    global $url;

    $response = [
        'message' => 'No existe la API indicada',
        'state' => 404,        
        'url' => $url,
    ];
    
    http_response_code(404);
    echo json_encode($response);
    exit();
}

 /**
 * Devolver mensaje para api inexistente
 **/
function utilGenerateErrorMessage($state, $message){
    global $url;

    $response = [
        'message' => $message,
        'state' => $state,        
        'url' => $url,
    ];
    
    http_response_code($state);
    echo json_encode($response);
    exit();
}

function generarCodigo($longitud) {
    $caracteres_permitidos = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    return substr(str_shuffle($caracteres_permitidos), 0, $longitud);
}

function createTable($table, $data){
    $sql = "INSERT `$table` (";

    foreach ($data as $key => $value) {
        $sql .= "$key, ";        
    }

    $sql .= "created_at";
    $sql .= ") VALUES (";

    foreach ($data as $key => $value) {
        if(gettype($value) == 'string'){
            $sql .= "'$value', ";
        } else {
            $sql .= "$value, ";
        }
    }

    $sql .= "NOW()";
    $sql .= ")";

    return $sql;
}

function createTableWithoutDate($table, $data){
    $sql = "INSERT `$table` (";

    foreach ($data as $key => $value) {
        $sql .= "$key, ";        
    }

    $sql = substr($sql, 0, strlen($sql) - 2);
    $sql .= ") VALUES (";

    foreach ($data as $key => $value) {
        if(gettype($value) == 'string'){
            $sql .= "'$value', ";
        } else {
            $sql .= "$value, ";
        }
    }

    $sql = substr($sql, 0, strlen($sql) - 2);
    $sql .= ")";

    return $sql;
}

function updateTable($table, $id, $data){
    $sql = "UPDATE `$table` SET ";

    foreach ($data as $key => $value) {
        if(gettype($value) == 'string'){
            $sql .= "`$key` = '$value', ";
        } else {
            $sql .= "`$key` = $value, ";
        }
    }

    $sql .= "`updated_at` = NOW() ";
    $sql .= " WHERE id = '$id'";

    return $sql;
}

function updateTableWithoutDate($table, $id, $data){
    $sql = "UPDATE `$table` SET ";

    foreach ($data as $key => $value) {
        if(gettype($value) == 'string'){
            $sql .= "`$key` = '$value', ";
        } else {
            $sql .= "`$key` = $value, ";
        }
    }

    $sql = substr($sql, 0, strlen($sql) - 2);
    $sql .= " WHERE id = '$id'";

    return $sql;
}

function utilExecuteController($class, $method){
    call_user_func([$class, $method]);
}

function utilArrayAvoidElement($data, $xKey){
    $res = [];
    
    if(isset($data)){
        foreach ($data as $key => $value) {
            if($key != $xKey)
                $res[$key] = $value;
        }
    }

    return $res;
}

function utilGetRequest(...$keys){
    $res = [];

    foreach ($keys as $key => $value) {
        $res[$key] = $value;
    }

    return $res;
}

function writeLog($message, $logDir = 'logs') {
    // Asegurarse de que el directorio de logs exista
    if (!is_dir($logDir)) {
        mkdir($logDir, 0777, true);
    }

    // Nombre del archivo de log basado en la fecha actual
    $filename = $logDir . '/log-' . date('Y-m-d') . '.txt';

    // Formato del mensaje: [hora] mensaje
    $formattedMessage = '[' . date('H:i:s') . '] ' . $message . PHP_EOL;

    // Escribir el mensaje al final del archivo
    file_put_contents($filename, $formattedMessage, FILE_APPEND);
}

/** 
 * Detectar si el numero es vacio o cero
 * 
 * @param mixed $xint
 * @return bool
*/
function int_vacio(mixed $xint): bool
{
    if ($xint == null || $xint == 0)
        return true;
    else
        return false;
}

/** 
 * Detectar si el texto es vacio
 * 
 * @param mixed $xstr
 * @return bool
*/
function str_vacio(mixed $xstr): bool
{
    if ($xstr == null || $xstr == '')
        return true;
    else
        return false;
}

/** 
 * Formatear un decimal para imprimirlo
 * 
 * @param float $xfloat Numero a formatear
 * @param int $xdecimals Cantidad de decimales
 * @param int $xseparator1 Separador de decimales
 * @param int $xseparator2 Separador de miles
 * @return string
*/
function formatFloat(float $xfloat, int $xdecimals = 0, string $xseparator1 = ',', string $xseparator2 = '.'): string
{
    return number_format($xfloat, $xdecimals, $xseparator1, $xseparator2);
}

/** 
 * Formatear una fecha con el formato indicado
 * 
 * @param string $xfecha Fecha a formatear
 * @param string $xformat Formato de fecha de salida 
 * @param string $xvacio Lo que se imprime si la fecha no es vacia
 * @return string
*/
function formatFecha(string $xfecha, string $xformat = 'd/m/Y', string $xvacio = '-'): string
{
    if (str_vacio($xfecha)) {
        return $xvacio;
    } else {
        $timestamp = strtotime($xfecha);
        return date($xformat, $timestamp);
    }
}

/** 
 * Obtener un valor STR de los parametros o null
*/
function getParameter(string $xkey): string 
{
    $value = '';
    if (isset($_GET[$xkey]))
        $value = $_GET[$xkey];

    return $value;
}

/** 
 * Obtener un valor INT de los parametros o 0
*/
function getParameterInt(string $xkey): int
{
    $value = 0;
    if (isset($_GET[$xkey]))
        $value = intval($_GET[$xkey]);

    return $value;
}

/** 
 * Obtener un valor FLOAT de los parametros o 0
*/
function getParameterFloat(string $xkey): float 
{
    $value = 0;
    if (isset($_GET[$xkey]))
        $value = floatval($_GET[$xkey]);

    return $value;
}

/** 
 * Obtener un valor STR de los parametros o null
*/
function getBody(string $xkey, $xdefault = ''): string|null 
{
    $value = $xdefault;
    if (isset($_POST[$xkey]))
        $value = $_POST[$xkey];

    return $value;
}

/** 
 * Obtener un valor INT de los parametros o 0
*/
function getBodyInt(string $xkey, $xdefault = 0): int
{
    $value = $xdefault;
    if (isset($_POST[$xkey]))
        $value = intval($_POST[$xkey]);

    return $value;
}

/** 
 * Obtener un valor FLOAT de los parametros o 0
*/
function getBodyFloat(string $xkey, $xdefault = 0): float 
{
    $value = $xdefault;
    if (isset($_POST[$xkey]))
        $value = floatval($_POST[$xkey]);

    return $value;
}