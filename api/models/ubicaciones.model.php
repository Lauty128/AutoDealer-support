<?php

class UbicacionesModel{

    /**
     * Obtener una ubicacion especifica
     *
     * @param Int $id Id de la categoria
     * @return Array|null
     **/
    public static function getById($id)
    {
        $response = null;
        $sql = "SELECT *
                FROM locations
                WHERE id = " . $id;
        $sql .= " LIMIT 1";

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
     * Crear una nueva ubicacion
     *
     * @param Array $data Datos del body
     * @return Array|null
    **/
    public static function create($data)
    {
        $response = null;

        $db = new Database();

        #Obtener valores requeridos y ejecutar procedimiento
        $id = $data['id'];
        $city = $data['city'];
        $department = $data['department'];
        $province = $data['province'];
        
        $sql = "INSERT INTO locations (id, city, department, province)
                VALUES
                    ('$id', '$city', '$department', '$province')";

        if($db->getConnectionStatus()){
            $response = $db->execute($sql);
            $db->close();
        }

        return $response; # Retorna null o el resultado de la consulta sql
    }
}