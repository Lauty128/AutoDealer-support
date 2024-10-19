<?php

namespace App\Controller;

//--> Dependencies
use Bcrypt\Bcrypt;

//--> Models
use App\Model\Concesionario;


class ConcesionariosController{

    /**
     * Devuele listado de todos los concesionarios
     *
     * @return array|null
     **/
    public function getAll()
    {
        $where = [];
        
        if(isset($_GET['search'])){
            $search = $_GET['search'];
            $where[] = "s.name LIKE '%$search%'";
        }
        if(isset($_GET['user'])){
            $user = $_GET['user'];
            $where[] = "s.user_id = $user";
        }

        $response = Concesionario::getAll($where);

        echo json_encode($response);
        exit();
    }

    /**
     * Devuele listado de todos los concesionarios
     *
     * @return array|null
     **/
    public function getAllByClient($id)
    {
        $response = Concesionario::getAll([]);

        echo json_encode($response);
        exit();
    }

    /**
     * Devuelve todos los datos de un concesionario
     * 
     * @return array|null
     **/
    public function getOne()
    {
        if(!isset($_GET['id']))
            utilGenerateErrorMessage(500, 'No se indico ningun id por los parametros de la URL');

        # Obtener usuario por id
        $id = $_GET['id'];
        $response = Concesionario::getById($id);
        
        # Si $categorias es null se ejecuta un mensaje de error y se corta el codigo
        utilBadConnectionMessage($response);

        echo json_encode($response);
        exit();
    }

    /**
     * Crear un nuevo concesionario
     * 
     * @return array|null
     **/
    public function create()
    {
        $data = $_POST;
        $data['id'] = generarCodigo(20);

        $response = Concesionario::create($data);

        echo json_encode($response);
        exit();
    }

    /**
     * Actualizar datos de un concesionario
     *
     * @return array|null
     **/
    public function update()
    {
        if(!isset($_POST['id']))
            utilGenerateErrorMessage(500, 'No se indico ningun id por los parametros de la URL');

        $data = utilArrayAvoidElement($_POST, $_POST['id']);
        $id = $_POST['id'];

        // Actualizar concesionario
        $response = Concesionario::update($id, $data);

        echo json_encode($response);
        exit();
    }

    /**
     * Eliminar un concesionario especifico con sus datos
     *
     * @return array|null
     **/
    public function delete()
    {
        // Aqui se envia por JSON la informacion. Por eso se utiliza el $data
        global $data;

        // Si no se envio un ID por el body se devuelve mensaje de error
        if(!isset($data['id']))
            utilGenerateErrorMessage(500, 'No se indico ningun id por los parametros de la URL');

        // Eliminar cliente
        $response = Concesionario::delete($data['id']);
    
        echo json_encode($response);
        exit();
    }
    
}