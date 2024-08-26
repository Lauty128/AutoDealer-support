<?php

// Configurar header
include "config/header.php";

// Preparar mensaje
$host = $_SERVER["HTTP_HOST"];
$response = [
    'message' => 'Listado de endpoints disponibles',
    'api' => [
        [
            'name' => 'Categorias',
            'url' => 'https://'.$host.'/api/categorias.php',
            'methods' => [
                [
                    'url' => 'api/categorias.php/get',
                    'method' => 'GET',
                    'description' => 'Listado de todas las categorias'
                ],
                [
                    'url' => 'api/categorias.php/get-one',
                    'method' => 'GET',
                    'description' => 'Informacion sobre una categoria'
                ]
            ]
        ],
        [
            'name' => 'Pedidos',
            'url' => 'https://'.$host.'/api/pedidos.php',
            'metodos' => [
                [
                    'url' => 'api/pedidos.php/get',
                    'method' => 'GET',
                    'description' => 'Listado de todos los pedidos'
                ],
                [
                    'url' => 'api/pedidos.php/get-pendientes',
                    'method' => 'GET',
                    'description' => 'Listado de todos los pedidos pendientes'
                ],
                [
                    'url' => 'api/pedidos.php/get-one',
                    'method' => 'GET',
                    'description' => 'Informacion sobre una categoria'
                ]
            ]
        ]
    ]
];

// Imprimir mensaje
echo json_encode($response);
exit();