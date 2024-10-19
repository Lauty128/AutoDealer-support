<?php

namespace App\Util;

// Class
use App\Config\Config;

class Database{
    // Database connection object
    private \mysqli $DB;

    // Configs
    private bool $status;
    private string|null $error_message = null;

    /** 
     * Devuelve el estado de la conexion con la base de datos
     *
     * @return bool
    **/
    public function getConnectionStatus()
    {
        return $this->status;
    }

    /**
     * Devuelve el mensaje de error o null
     * 
     * @return string|null
     **/
    public function getErrorMessage()
    {
        return $this->error_message;
    }
    
    /**
     * Define la conexion con la base de datos a traves de mysqli
     *
     * @return void
    **/
    function __construct()
    {
        try{
            // Instanciar conexion y configurar utf8 para mostrar los datos
            $this->DB = new \mysqli(Config::$DB_HOST, Config::$DB_USER, Config::$DB_PASSWORD, Config::$DB_NAME);
            $this->DB->set_charset('utf8');
        
            $this->status = true;
        }
        catch(\mysqli_sql_exception $e){
            $this->error_message = "Ocurrio un error al conectarse a la base de datos: ("
                . $e->getCode() .") ". $e->getMessage();
            
            $this->status = false;
            exit;
        }
    }
    

    /**
     * Cerrar conexion con la base de datos
    **/
    public function close()
    {
        $this->DB->close();    
    }

    /**
     * Iniciar transaccion
    **/
    public function beginT()
    {
        $this->DB->begin_transaction();    
    }

    /**
     * Hacer commit de la transaccion
    **/
    public function commit()
    {
        $this->DB->commit();    
    }

    /**
     * Rollback para volver al estado anterior a la transaccion
    **/
    public function rollback()
    {
        $this->DB->rollback();    
    }

    /**
     * Permite ejecutar una consulta sql
     *
     * @param string $sql Consulta sql para ejecutar
     * @return Array|null Arreglo con el conjunto de datos consultados en la base de datos
     **/
    public function getQuery($sql)
    {
        try{
            // Ejecutar consulta y devolver resultado
            $this->DB->real_query($sql);
            $result = $this->DB->use_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }catch(\mysqli_sql_exception $e){
            // En caso de un error se almacenara el mensaje de error y se retornara un Null para que se sepa la existencia de un error
            $this->error_message = "Ocurrio un error durante la ejecucion de la consulta: ("
                . $e->getCode() .") ". $e->getMessage();
        }
        
    }

    /**
     * Permite ejecutar una consulta sql con parametros bindeados
     *
     * @param string $sql Description
     * @param array $params Description
     * @return bool
     **/
    public function getQueryParams($sql, $params = [])
    {
        // Creacion del conjunto de tipos de datos
        $type_bind="";
        for($index=0; $index < count($params) ; $index++){
            $var_type = gettype($params[$index]);
            $type_bind .= $var_type[0]; # "i"nteger | "s"tring | "d"ouble
        }

        // Preparación de la consulta sql
        $query = $this->DB->prepare($sql);

        // Bindear parametros solo si existen
        if(count($params) > 0)
            $query->bind_param($type_bind, ...$params);

        // ejecucion del codigo y devolucion de un booleano
        return $query->execute();
    }

    /**
     * Permite ejecutar una consulta sql de actualizacion
     *
     * @param string $sql Description
     * @param array $params Description
     * @return bool
     **/
    public function execute($sql, $params = [])
    {
        // Creacion del conjunto de tipos de datos
        $type_bind="";
        for($index=0; $index < count($params) ; $index++){
            $var_type = gettype($params[$index]);
            $type_bind .= $var_type[0]; # "i"nteger | "s"tring | "d"ouble
        }

        // Preparación de la consulta sql
        $query = $this->DB->prepare($sql);

        // Bindear parametros solo si existen
        if(count($params) > 0)
            $query->bind_param($type_bind, ...$params);

        // ejecucion del codigo y devolucion de un booleano
        return $query->execute();
    }

}

