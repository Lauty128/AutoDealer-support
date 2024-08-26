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