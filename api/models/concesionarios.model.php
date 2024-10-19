<?php

namespace App\Model;

//--> Dependencies

//--> Utils
use App\Util\Database;


class Concesionario{

    /**
     * Obtener un listado de todos los concesionarios
     *
     * @return array|null
     **/
    public static function getAll()
    {
        $response = null;
        $db = new Database();
        
        # Crear consulta SQL
        $sql = "SELECT s.id, s.name, s.username, s.image, l.province
                FROM stores s
                    INNER JOIN users u ON u.id = s.user_id
                    INNER JOIN locations l ON s.location_id = l.id";

        //if(isset($xData['filter'])) $sql.= ' WHERE '.$xData['filter'];

        if($db->getConnectionStatus()){
            $response = $db->getQuery($sql);
            $db->close();
        }

        return $response; # Retorna null o el resultado de la consulta sql
    }

    /**
     * Obtener datos de un concesionario especifico
     *
     * @param Int $id Id del concesionario
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
     * Crear un concesionario nuevo
     *
     * @param Array $data Datos del body
     * @return Array|null
    **/
    public static function create($data)
    {
        $response = null;
        $db = new Database();
        
        // Generar sql
        $sql = createTable('stores', $data);
    
        if($db->getConnectionStatus()){
            $response = $db->execute($sql);
            $db->close();
        }

        return $response; # Retorna null o el resultado de la consulta sql
    }

    /**
     * Actualizar un concesionario
     *
     * @param Array $data Datos del body
     * @return Array|null
    **/
    public static function update($id, $data)
    {
        $response = null;
        $db = new Database();

        // Generar sql
        $sql = updateTable('stores', $id, $data);

        if($db->getConnectionStatus()){
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

        if($db->getConnectionStatus()){
            // Eliminar concesionario
            $sql = "DELETE FROM stores WHERE id = ?";
            $response = $db->execute($sql, [$id]);
            
            $db->close();
        }

        return $response; # Retorna null o el resultado de la consulta sql
    }
}