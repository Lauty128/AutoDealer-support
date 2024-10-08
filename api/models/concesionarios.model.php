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

        // $validation = true;
        // $requiredFields = [
        //     'direccion',
        //     'razon_social'
        // ];
        // foreach ($requiredFields as $field) {
        //     if(!isset($data[$field]))
        //         $validation = false;
        // }

        // if(!$validation)
        //     return [
        //         'message' => 'No se enviaron los datos necesarios para crear un nuevo cliente',
        //         'status' => 500    
        //     ];

        $db = new Database();
        
        #Obtener valores requeridos y ejecutar procedimiento
        $name = $data['name'];
        $subname = $data['subname'];
        $email = $data['email'];
        $phone = $data['phone'];
        $location_id = $data['location_id'];
        
        $sql = "INSERT INTO users (name, subname, email, phone, location_id)
                VALUES
                    ('$name', '$subname', '$email', '$phone', '$location_id')";
    var_dump($sql);
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
        $razon_social = $data['razon_social'];
        $direccion = $data['direccion'];
        $sql = "CALL clientes_insert('$razon_social', '$direccion')";

        if($db->getConnectionStatus()){
            $response = $db->getQuery($sql);
            $db->close();
        }

        return $response; # Retorna null o el resultado de la consulta sql
    }

    /**
     * Eliminar un cliente
     *
     * @param int $id Id del cliente a eliminar
     * @return Array|null
    **/
    public static function delete($id)
    {
        $response = null;
        $db = new Database();
        
        #Obtener valores requeridos y ejecutar procedimiento
        // $sql = "CALL clientes_delete($id)";

        if($db->getConnectionStatus()){
            $sql = "DELETE FROM stores WHERE user_id = $id";
            $response = $db->execute($sql);

            $sql = "DELETE FROM users WHERE id = $id";
            $response = $db->execute($sql);
            
            // $response = $db->getQuery($sql);
            $db->close();
        }

        return $response; # Retorna null o el resultado de la consulta sql
    }
}