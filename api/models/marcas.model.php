<?php

namespace App\Model;

//--> Dependencies

use App\Config\Config;
use Exception;

//--> Utils
use App\Util\Database;


class Marca{

    /**
     * Devuele un listado de todas las marcas
     *
     * @return array|null
     **/
    public static function getAll()
    {
        $response = null;
        $db = new Database();
        
        # Crear consulta SQL
        $sql = "SELECT m.*, COUNT(v.id) AS vehicles
                FROM marks m
                    LEFT JOIN vehicles v ON v.mark_id = m.id
                GROUP BY (m.id)
                ORDER BY vehicles DESC";

        if($db->getConnectionStatus()){
            $response = $db->getQuery($sql);
            $db->close();
        }

        return $response; # Retorna null o el resultado de la consulta sql
    }

    /**
     * Crear una marca
     *
     * @param Array $data Datos del body
     * @return Array|null
    **/
    public static function create($data)
    {
        $response = null;
        $db = new Database();
        
        // Generar sql
        $sql = createTableWithoutDate('marks', $data);
    
        if($db->getConnectionStatus()){
            $response = $db->execute($sql);
            $db->close();
        }

        return $response; # Retorna null o el resultado de la consulta sql
    }

    /**
     * Actualizar una marca
     *
     * @param Array $data Datos del body
     * @return Array|null
    **/
    public static function update($id, $data)
    {
        $response = null;
        $db = new Database();

        // Generar sql
        $sql = updateTableWithoutDate('marks', $id, $data);

        if($db->getConnectionStatus()){
            $response = $db->execute($sql);
            $db->close();
        }

        return $response; # Retorna null o el resultado de la consulta sql
    }

    /**
     * Eliminar una marca junto a todos sus datos relacionados
     *
     * @param int $id Id de la marca a eliminar
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
                // Eliminar vehiculos relacionados con la marca
                $sql = "DELETE FROM vehicles WHERE mark_id = ?";
                $response = $db->execute($sql, [$id]);
    
                // Eliminar la marca
                $sql = "DELETE FROM marks WHERE id = ?";
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

    /**
     * Limpiar cache del servidor para marcas
     *
     * @return 
     **/
    public static function clearCache()
    {
        $url = Config::$API_URL . 'marks/clear-cache';
        
       // Inicializar cURL
       $ch = curl_init();

       // Configurar cURL para hacer una petición POST
       curl_setopt($ch, CURLOPT_URL, $url);
       curl_setopt($ch, CURLOPT_POST, true);

       // Configurar opciones adicionales
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  // Para recibir la respuesta de la API

       // Ejecutar la petición cURL y cerrarla
       curl_exec($ch);
       curl_close($ch);

    }
}