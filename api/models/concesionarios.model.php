<?php

namespace App\Model;

//--> Dependencies

//--> Utils
use App\Util\Database;


class Concesionario{

    /**
     * Devuele un listado de todas las categorias
     *
     * @return array|null
     **/
    public static function getAll($xData = [])
    {
        $response = null;
        $db = new Database();
        
        # Crear consulta SQL
        $sql = "SELECT s.id, s.name, s.username, s.image, l.province
                FROM stores s
                    INNER JOIN users u ON u.id = s.user_id
                    INNER JOIN locations l ON s.location_id = l.id";

        if(isset($xData['filter'])) $sql.= ' WHERE '.$xData['filter'];

        if($db->getConnectionStatus()){
            $response = $db->getQuery($sql);
            $db->close();
        }

        return $response; # Retorna null o el resultado de la consulta sql
    }

    /**
     * Obtener una categoria especifica
     *
     * @param Int $id Id de la categoria
     * @return Array|null
     **/
    public static function getById($id)
    {
        $response = null;
        $sql = "SELECT s.*, l.city, l.department, l.province, CONCAT(u.name,' ',u.subname) AS user_name
                FROM stores s
                    INNER JOIN users u ON u.id = s.user_id 
                    INNER JOIN locations l ON l.id = s.location_id 
                WHERE s.id = '$id'";

        $db = new Database();

        if($db->getConnectionStatus()){
            $response = $db->getQuery($sql);
            $db->close();
        }
        if($response && count($response) == 1)
            $response = $response[0];

        return $response; # Retorna null o el resultado de la consulta sql
    }

    /**
     * Crear un cliente
     *
     * @param Array $data Datos del body
     * @return Array|null
    **/
    public static function create($data)
    {
        $response = null;
        $db = new Database();
        
        #Obtener valores requeridos y ejecutar procedimiento
        $data = [
            'id' => generarCodigo(20),
            'name' => $_POST['name'],
            'username' => $_POST['username'],
            'user_id' => $_POST['user'],
            'email' => $_POST['email'],
            'phone' => $_POST['phone'],
            'location_id' => $_POST['location'],
            'address' => $_POST['address'],
            'map' => ($_POST['map']) ? $_POST['map'] : "",
            'description' => ($_POST['description']) ? $_POST['description'] : "",
            'price_currency' => $_POST['price_currency'],
            'dolar_conversion' => $_POST['dolar_conversion'],
            'personal_info' => $_POST['personal_info'],
            'message_notify' => $_POST['message_notify'],
        ];
        
        $sql = createTable('stores', $data);

        if($db->getConnectionStatus()){
            // $response = $db->getQuery($sql);
            $response = $db->execute($sql);
            $db->close();
        }

        return $response; # Retorna null o el resultado de la consulta sql
    }

    /**
     * Actualizar un cliente
     *
     * @param Array $data Datos del body
     * @return Array|null
    **/
    public static function update($data)
    {
        
        $response = null;
        $db = new Database();
        
        #Obtener valores requeridos y ejecutar procedimiento
        $id = $_POST['id'];
        $data = [
            'name' => $_POST['name'],
            'username' => $_POST['username'],
            'user_id' => $_POST['user_id'],
            'email' => $_POST['email'],
            'phone' => $_POST['phone'],
            'location_id' => $_POST['location'],
            'address' => $_POST['address'],
            'map' => ($_POST['map']) ? $_POST['map'] : "",
            'description' => ($_POST['description']) ? $_POST['description'] : "",
            'price_currency' => $_POST['price_currency'],
            'dolar_conversion' => $_POST['dolar_conversion'],
            'personal_info' => $_POST['personal_info'],
            'message_notify' => $_POST['message_notify']
        ];

        $sql = updateTable('stores', $id, $data);

        if($db->getConnectionStatus()){
            // $response = $db->getQuery($sql);
            $response = $db->execute($sql);
            $db->close();
        }

        return $response; # Retorna null o el resultado de la consulta sql
    }

    /**
     * Eliminar un concesionario
     *
     * @param int $id Id del concesionario a eliminar
     * @return Array|null
    **/
    public static function delete($id)
    {
        $response = null;
        $db = new Database();
        
        #Obtener valores requeridos y ejecutar procedimiento
        // $sql = "CALL clientes_delete($id)";

        if($db->getConnectionStatus()){
            $sql = "DELETE FROM stores WHERE id = '$id'";
            $response = $db->execute($sql);
            
            // $response = $db->getQuery($sql);
            $db->close();
        }

        return $response; # Retorna null o el resultado de la consulta sql
    }
}