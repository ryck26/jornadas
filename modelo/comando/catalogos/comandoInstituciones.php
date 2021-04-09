<?php
class comandoInstituciones
{
	private $SQL;
	private $sta;
	
    function __construct(){
        
    }

    function altaInstitucion($nombre)
    {
        try {
            $Conexion = Conexion::getInstance()->obtenerConexion();
            $this->SQL = "INSERT INTO instituciones (nombre, activo)
                            VALUES ('$nombre', 1)";
            $this->sta = $Conexion->prepare($this->SQL);
            $this->sta->execute();
            $id = $Conexion->lastInsertId();
            Conexion::getInstance()->cerrarConexion();
            return $id;
        }catch (Exception $e){
            Conexion::getInstance()->cerrarConexion();
            return $e->getMessage();
        }
    }

    function listaInstituciones()
    {
        try {
            $Conexion = Conexion::getInstance()->obtenerConexion();
            $this->SQL = "SELECT nombre, cve_institucion, activo FROM instituciones";
            $this->sta = $Conexion->prepare($this->SQL);
            $this->sta->execute();
            $datos = $this->sta->fetchAll(PDO::FETCH_ASSOC);
            Conexion::getInstance()->cerrarConexion();
            return $datos;
        }catch (Exception $e){
            Conexion::getInstance()->cerrarConexion();
            return $e->getMessage();
        }
    }

    function cargarInstitucion($cve_institucion)
    {
        try {
            $Conexion = Conexion::getInstance()->obtenerConexion();
            $this->SQL = "SELECT nombre, cve_institucion FROM instituciones WHERE cve_institucion = $cve_institucion";
            $this->sta = $Conexion->prepare($this->SQL);
            $this->sta->execute();
            $datos = $this->sta->fetchAll(PDO::FETCH_ASSOC);
            Conexion::getInstance()->cerrarConexion();
            return $datos;
        }catch (Exception $e){
            Conexion::getInstance()->cerrarConexion();
            return $e->getMessage();
        }
    }

    function estatusInstitucion($cve_institucion, $estatus)
    {
        try {
            $Conexion = Conexion::getInstance()->obtenerConexion();
            $this->SQL = "UPDATE instituciones SET activo = $estatus WHERE cve_institucion = $cve_institucion";
            $this->sta = $Conexion->prepare($this->SQL);
            $this->sta->execute();
            $datos = $this->sta->fetchAll(PDO::FETCH_ASSOC);
            Conexion::getInstance()->cerrarConexion();
            return $datos;
        }catch (Exception $e){
            Conexion::getInstance()->cerrarConexion();
            return $e->getMessage();
        }
    }

    function actualizarInstitucion($cve_institucion, $nombre)
    {
        try {
            $Conexion = Conexion::getInstance()->obtenerConexion();
            $this->SQL = "UPDATE instituciones SET nombre = '$nombre' WHERE cve_institucion = $cve_institucion";
            $this->sta = $Conexion->prepare($this->SQL);
            $this->sta->execute();
            $datos = $this->sta->fetchAll(PDO::FETCH_ASSOC);
            Conexion::getInstance()->cerrarConexion();
            return $datos;
        }catch (Exception $e){
            Conexion::getInstance()->cerrarConexion();
            return $e->getMessage();
        }
    }

    function eliminarInstitucion($cve_institucion)
    {
        try {
            $Conexion = Conexion::getInstance()->obtenerConexion();
            $this->SQL = "DELETE FROM instituciones WHERE cve_institucion = $cve_institucion";
            $this->sta = $Conexion->prepare($this->SQL);
            $this->sta->execute();
            $datos = $this->sta->fetchAll(PDO::FETCH_ASSOC);
            Conexion::getInstance()->cerrarConexion();
            return $datos;
        }catch (Exception $e){
            Conexion::getInstance()->cerrarConexion();
            return $e->getMessage();
        }
    }
}
?>