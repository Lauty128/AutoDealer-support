<?php

namespace App\Controller;

//--> Dependencies
use Bcrypt\Bcrypt;

//--> Models
use App\Model\Marca;


class MarcasController{

    /**
     * Devuele listado de las Marcas
     *
     * @return array|null
     **/
    public function get()
    {
        $response = Marca::getAll();

        echo json_encode($response);
        exit();
    }

    /**
     * Crear una nuevoa marca
     *
     * @return array|null
     **/
    public function create()
    {
        global $data;
        
        // Crear cliente
        $response = Marca::create($data);
        Marca::clearCache();

        echo json_encode($response);
        exit();
    }

    /**
     * Actualizar datos de una marca
     *
     * @return array|null
     **/
    public function update()
    {
        global $data;

        if(!isset($data['id']))
            utilGenerateErrorMessage(500, 'No se indico ningun id por los parametros de la URL');

        $data = utilArrayAvoidElement($data, $data['id']);
        $id = $data['id'];

        // Actualizar cliente
        $response = Marca::update($id, $data);
        Marca::clearCache();

        echo json_encode($response);
        exit();
    }

    /**
     * Eliminar un cliente especifico con sus datos
     *
     * @return array|null
     **/
    public function delete()
    {
        global $data;

        // Si no se envio un ID por el body se devuelve mensaje de error
        if(!isset($data['id']))
            utilGenerateErrorMessage(500, 'No se indico ningun id por los parametros de la URL');

        // Eliminar cliente
        $response = Marca::delete($data['id']);
        Marca::clearCache();
    
        echo json_encode($response);
        exit();
    }
    
}