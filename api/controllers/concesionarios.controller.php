<?php

namespace App\Controller;


//--> Dependencies
use App\Config\Config;
use CURLFile;

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

        if(isset($_FILES['image'])){
            // Ruta temporal del archivo subido
            $tempPath = $_FILES['image']['tmp_name'];
            
            $user_id = $data['user_id'];
            $store_id = $data['id'];

            // URL de la API externa a la que deseas enviar la imagen
            $url = Config::$API_URL . "stores/user/$user_id/$store_id/image"; // Cambia esta URL por la de la API real

            // Abrir el archivo en modo lectura binaria
            $imageData = new CURLFile($tempPath, $_FILES['image']['type'], $_FILES['image']['name']);

            // Inicializar cURL
            $ch = curl_init();

            // Configurar cURL para hacer una petición POST
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);

            // Crear un array con los datos a enviar (la imagen)
            $postData = array(
                'image' => $imageData
            );
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

            // Configurar opciones adicionales
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  // Para recibir la respuesta de la API
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                "Content-Type: multipart/form-data"
            ));

            // Ejecutar la petición cURL y cerrarla
            curl_exec($ch);
            curl_close($ch);
        }

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