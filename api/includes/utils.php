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