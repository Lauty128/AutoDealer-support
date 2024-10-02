<?php

// Configurar header
include "config/header.php";

// Preparar mensaje
$host = $_SERVER["HTTP_HOST"];
$response = [
    'message' => 'Listado de endpoints disponibles',
    'api' => [
        [
            'name' => 'Clientes',
            'url' => 'https://'.$host.'/api/clientes.php',
            'methods' => [
                [
                    'url' => 'api/clientes.php/get',
                    'method' => 'GET',
                    'description' => 'Listado de todos los clientes'
                ],
                [
                    'url' => 'api/clientes.php/get-one',
                    'method' => 'GET',
                    'description' => 'Informacion sobre un cliente'
                ],
                [
                    'url' => 'api/clientes.php/delete',
                    'method' => 'POST',
                    'description' => 'Remover un cliente del sistems'
                ],
                [
                    'url' => 'api/clientes.php/create',
                    'method' => 'POST',
                    'description' => 'Crear un nuevo cliente'
                ],
                [
                    'url' => 'api/clientes.php/update',
                    'method' => 'POST',
                    'description' => 'Actualizar datos del cliente'
                ]
            ]
        ],
        [
            'name' => 'Ubicaciones',
            'url' => 'https://'.$host.'/api/ubicaciones.php',
            'metodos' => [
                [
                    'url' => 'api/ubicaciones.php/get-one',
                    'method' => 'GET',
                    'description' => 'Obtener los datos de una ubicación almacenada el sistema'
                ],
                [
                    'url' => 'api/ubicaciones.php/create',
                    'method' => 'POST',
                    'description' => 'Almacenar una nueva ubicación en el sistema'
                ]
            ]
        ]
    ]
];

// Imprimir mensaje
echo json_encode($response);
exit();