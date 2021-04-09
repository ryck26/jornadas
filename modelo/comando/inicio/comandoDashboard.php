<?php
class comandoDashboard
{
	private $SQL;
	private $sta;
	
    function __construct(){
        
    }

    function listaSesiones($cve_persona)
    {
        try {
            $Conexion = Conexion::getInstance()->obtenerConexion();
            $this->SQL = "SELECT se.nombre, se.fecha FROM participantes pa
                            INNER JOIN participantes_consejos pc ON pa.cve_participante = pc.cve_participante
                            INNER JOIN sesiones se ON se.cve_consejo = pc.cve_consejo
                            WHERE pa.cve_persona = $cve_persona;";
            $this->sta = $Conexion->prepare($this->SQL);
            $this->sta->execute();
            $datos = $this->sta->fetchAll(PDO::FETCH_ASSOC);
            Conexion::getInstance()->cerrarConexion();
            //var_dump($datos);
            return $datos;
        }catch (Exception $e){
            Conexion::getInstance()->cerrarConexion();
            return $e->getMessage();
        }
    }

    function listaCompromisos($cve_persona)
    {
        try {
            $Conexion = Conexion::getInstance()->obtenerConexion();
            $this->SQL = "SELECT ac.titulo, ac.fecha_cumplimiento FROM participantes pa
                            INNER JOIN participantes_compromisos pc ON pa.cve_participante = pc.cve_participante
                            INNER JOIN acuerdo_compromiso ac ON ac.cve_acuerdo_compromiso = pc.cve_acuerdo_compromiso
                            INNER JOIN detalle_compromiso dc ON dc.cve_acuerdo_compromiso = ac.cve_acuerdo_compromiso            
                            WHERE pa.cve_persona = $cve_persona;";
            $this->sta = $Conexion->prepare($this->SQL);
            $this->sta->execute();
            $datos = $this->sta->fetchAll(PDO::FETCH_ASSOC);
            Conexion::getInstance()->cerrarConexion();
            //var_dump($datos);
            return $datos;
        }catch (Exception $e){
            Conexion::getInstance()->cerrarConexion();
            return $e->getMessage();
        }
    }
}
?>