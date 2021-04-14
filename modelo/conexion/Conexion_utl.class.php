<?php
/**
  * Descripcion         : Conexión a base de datos
  * Autor           : Diego Armando Victorino Rivera
  * Version                     : 1.0
  * Fecha de creacion           : 07/06/2013, 00:00:00
  **/
class Conexion_utl {
    //  variables para conexion SQL SERVIDOR
    private $conexion_utl;

    private $SQLhost = '127.0.0.1\SQL2016';
    private $SQLDatabase = 'sito_20200829';
    private $SQLusername = 'sa';
    private $SQLpass = 'feb0213';
    private static $instancia;
     
    /**
     * 
     * Crea la configuracion para la conexion a BD en PDO
     */
    //singletone para validar si ya existe el objeto conexion

    function __construct() {
        $this->conexion_utl = NULL;
    }
    
        public static function  getInstance_utl(){
        if(!self::$instancia instanceof self){
            self::$instancia = new self;
        }
        
        return self::$instancia;
    }
    
    public function obtenerConexion_utl() 
    {
        if ($this->conexion_utl === NULL){
            error_log($this->conexion_utl);
            $this->conexionSQL_utl();
        } 

        return $this->conexion_utl;
    }

    //realiza la conexion
    public function conexionSQL_utl() 
    {
        try 
        { 
        //var_dump("sqlsrv:Server=$this->SQLhost;Database=$this->SQLDatabase", $this->SQLusername,$this->SQLpass);
            $this->conexion_utl = new PDO("sqlsrv:Server=$this->SQLhost;Database=$this->SQLDatabase", $this->SQLusername,$this->SQLpass);
            $this->conexion_utl->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          // var_dump( new PDO("sqlsrv:Server=$this->SQLhost;Database=$this->SQLDatabase", $this->SQLusername,$this->SQLpass));
        } 
        catch (PDOException $e) 
        {
            echo 'Problema de conexión'.$e->getMessage();
            exit();
        }
    }
    
    public function cerrarConexion_utl()
    {
        
    //@mssql_close($this->conexion);
        $this->conexion_utl = NULL;
    }
}
?>