<?php

namespace App\Model;

//--> Dependencies
use Exception;

//--> Utils
use App\Util\Database;


class Clientes{

    /**
     * Devuele un listado de todos los clientes
     *
     * @return array|null
     **/
    public static function getAll($where = [])
    {
        $response = null;
        $db = new Database();
        
        # Crear consulta SQL
        $sql = "SELECT u.id, u.name, u.subname, l.province
                FROM users u
                    INNER JOIN locations l ON u.location_id = l.id";

        if(count($where) > 0){
            $sql .= " WHERE " . implode(' AND ', $where);
        }

        if($db->getConnectionStatus()){
            $response = $db->getQuery($sql);
            $db->close();
        }

        return $response; # Retorna null o el resultado de la consulta sql
    }

    /**
     * Obtener un cliente especifico
     *
     * @param Int $id Id del cliente
     * @return Array|null
     **/
    public static function getById($id)
    {
        $response = null;
        $sql = "SELECT u.id, u.name, u.subname, u.email, u.phone, u.image, u.location_id, l.city, l.province, u.created_at
                FROM users u
                    INNER JOIN locations l ON l.id = u.location_id 
                WHERE u.id = ".$id;

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
        
        // Generar sql
        $sql = createTable('users', $data);
    
        if($db->getConnectionStatus()){
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
    public static function update($id, $data)
    {
        $response = null;
        $db = new Database();

        // Generar sql
        $sql = updateTable('users', $id, $data);

        if($db->getConnectionStatus()){
            $response = $db->execute($sql);
            $db->close();
        }

        return $response; # Retorna null o el resultado de la consulta sql
    }

    /**
     * Eliminar un cliente junto a todos sus datos relacionados
     *
     * @param int $id Id del cliente a eliminar
     * @return Array|null
    **/
    public static function delete($id)
    {
        $response = null;
        $db = new Database();

        if($db->getConnectionStatus()){

            // Iniciar transaccion
            $db->beginT();

            try{
                // Eliminar concesionarios relacionados con el cliente
                $sql = "DELETE FROM stores WHERE user_id = ?";
                $response = $db->execute($sql, [$id]);
    
                // Eliminar cliente
                $sql = "DELETE FROM users WHERE id = ?";
                $response = $db->execute($sql, [$id]);

                $db->commit();
            } catch(Exception $error) {
                $response = false;
                $db->rollback();
            }
            
            $db->close();
        }

        return $response; # Retorna null o el resultado de la consulta sql
    }
}