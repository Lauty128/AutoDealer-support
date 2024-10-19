<?php

namespace App\Controller;

//--> Dependencies
use Bcrypt\Bcrypt;

//--> Models
use App\Model\Clientes;


class ClientesController{

    /**
     * Devuele listado de los clientes
     *
     * @return array|null
     **/
    public function get()
    {
        $response = Clientes::getAll();

        echo json_encode($response);
        exit();
    }

    /**
     * Devuelve todos los datos de un cliente
     *
     * @return array|null
     **/
    public function getOne()
    {
        if(!isset($_GET['id']))
            utilGenerateErrorMessage(500, 'No se indico ningun id por los parametros de la URL');

        # Obtener usuario por id
        $id = $_GET['id'];
        $response = Clientes::getById($id);
        
        # Si $response es null se ejecuta un mensaje de error y se corta el codigo
        utilBadConnectionMessage($response);

        echo json_encode($response);
        exit();
    }

    /**
     * Crear un nuevo cliente
     *
     * @return array|null
     **/
    public function create()
    {
        global $data;

        // Alterar $data
        $data['password'] = Bcrypt::encrypt($data['password']);
        
        // Crear cliente
        $response = Clientes::create($data);

        echo json_encode($response);
        exit();
    }

    /**
     * Actualizar datos de un cliente
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
        $response = Clientes::update($id, $data);

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
        $response = Clientes::delete($data['id']);
    
        echo json_encode($response);
        exit();
    }
    
}