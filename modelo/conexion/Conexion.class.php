<?php
/**
  * Descripcion         : Conexión a base de datos
  * Autor           : Diego Armando Victorino Rivera
  * Version                     : 1.0
  * Fecha de creacion           : 07/06/2013, 00:00:00
  **/
class Conexion {
    //  variables para conexion SQL SERVIDOR
    private $conexion;

    private $SQLhost = '127.0.0.1\SQL2016';
    private $SQLDatabase = 'consejo';
    private $SQLusername = 'sa';
    private $SQLpass = 'feb0213';
    private static $instancia;
     
    /**
     * 
     * Crea la configuracion para la conexion a BD en PDO
     */
    //singletone para validar si ya existe el objeto conexion

    function __construct() {
        $this->conexion = NULL;
    }
    
        public static function  getInstance(){
        if(!self::$instancia instanceof self){
            self::$instancia = new self;
        }
        return self::$instancia;
    }
    
    public function obtenerConexion() 
    {
        if ($this->conexion === NULL) 
        {
            $this->conexionSQL();
        } 

        return $this->conexion;
    }

    //realiza la conexion
    public function conexionSQL() 
    {
        try 
        { 
        //var_dump("sqlsrv:Server=$this->SQLhost;Database=$this->SQLDatabase", $this->SQLusername,$this->SQLpass);
            $this->conexion = new PDO("sqlsrv:Server=$this->SQLhost;Database=$this->SQLDatabase", $this->SQLusername,$this->SQLpass);
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
           
        } 
        catch (PDOException $e) 
        {
            echo 'Problema de conexión'.$e->getMessage();
            exit();
        }
    }
    
    public function cerrarConexion()
    {
        
    //@mssql_close($this->conexion);
        $this->conexion = NULL;
    }
}
?>