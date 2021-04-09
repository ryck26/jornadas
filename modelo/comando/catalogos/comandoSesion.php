<?php
class comandoSesion
{
	private $SQL;
	private $sta;
	
    function __construct(){
        
    }

    function listaConsejos($p)
    {
        try {
            $Conexion = Conexion::getInstance()->obtenerConexion();
            $this->SQL = "SELECT co.cve_consejo AS id, co.nombre AS nombreConsejo FROM consejos co 
                            INNER JOIN participantes_consejos pc ON pc.cve_consejo = co.cve_consejo
                            INNER JOIN participantes pa ON pa.cve_participante = pc.cve_participante
                            INNER JOIN persona pe ON pa.cve_persona = pe.cve_persona 
                            WHERE pe.cve_persona = $p";
            $this->sta = $Conexion->prepare($this->SQL);
            $this->sta->execute();
            $datos = $this->sta->fetchAll(PDO::FETCH_ASSOC);
            Conexion::getInstance()->cerrarConexion();
            return $datos;
			//return $this->SQL;
        }catch (Exception $e){
            Conexion::getInstance()->cerrarConexion();
            return $e->getMessage();
        }
    }

    function altaSesion($cve_consejo, $nombre, $fechaSesion, $objetivo, $fechaRegistro, $cve_persona)
    {
        try {
            $Conexion = Conexion::getInstance()->obtenerConexion();
            $this->SQL = "INSERT INTO sesiones (cve_consejo, nombre, fecha, objetivo, desarrollo, fecha_registro, cve_usuario, activo) 
                            VALUES ($cve_consejo, '$nombre', '$fechaSesion', '$objetivo', '', '$fechaRegistro', (SELECT cve_usuario FROM usuario WHERE cve_persona = $cve_persona), 0)";
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

    function listaSesiones($p)
    {
        try {
            $Conexion = Conexion::getInstance()->obtenerConexion();
            $this->SQL = "SELECT c.cve_consejo, s.cve_sesion, c.nombre AS nombre_consejo, s.nombre AS nombre_sesion, s.fecha, s.objetivo 
                            FROM sesiones s 
                            INNER JOIN consejos c ON c.cve_consejo = s.cve_consejo 
                            INNER JOIN participantes_consejos pc ON pc.cve_consejo = c.cve_consejo
                            INNER JOIN participantes pa ON pa.cve_participante = pc.cve_participante
                            WHERE s.activo = 0 AND pa.cve_persona = $p;";
			//var_dump($this->SQL);				
							
            $this->sta = $Conexion->prepare($this->SQL);
            $this->sta->execute();
            $datos = $this->sta->fetchAll(PDO::FETCH_ASSOC);
            Conexion::getInstance()->cerrarConexion();
            return $datos;
			//return $this->SQL;
        }catch (Exception $e){
            Conexion::getInstance()->cerrarConexion();
            return $e->getMessage();
        }
    }

    
    function cargarDatosSesion($cve_consejo, $cve_sesion)
    {
        try {
            $Conexion = Conexion::getInstance()->obtenerConexion();
            $this->SQL = "SELECT nombre AS nombre_sesion, fecha, objetivo 
                            FROM sesiones
                            WHERE cve_consejo = $cve_consejo AND cve_sesion = $cve_sesion";
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

    function actualizarSesion($cve_consejo, $cve_sesion, $nombreSesion, $fechaRegistro, $objetivo)
    {
        try {
            $Conexion = Conexion::getInstance()->obtenerConexion();
            $this->SQL = "UPDATE sesiones SET nombre = '$nombreSesion', fecha = '$fechaRegistro', objetivo = '$objetivo'
                            WHERE cve_consejo = $cve_consejo AND cve_sesion = $cve_sesion";
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
    
    function eliminarSesion($cve_consejo, $cve_sesion)
    {
        try {
            $Conexion = Conexion::getInstance()->obtenerConexion();
            $this->SQL = "DELETE FROM sesiones WHERE cve_consejo = $cve_consejo AND cve_sesion = $cve_sesion";
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

    function participantesConsejo($cve_consejo)
    {
        try {
            $Conexion = Conexion::getInstance()->obtenerConexion();
            $this->SQL = "SELECT pe.correo FROM participantes_consejos pc
                            INNER JOIN participantes p ON pc.cve_participante = p.cve_participante
                            INNER JOIN persona pe ON p.cve_persona = pe.cve_persona
                            WHERE pc.cve_consejo = $cve_consejo;";
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

    function listaDocumentos($cve_consejo)
    {
        try {
            $Conexion = Conexion::getInstance()->obtenerConexion();
            $this->SQL = "SELECT nombre FROM documentos_importados di
                            INNER JOIN documento_imp_proceso dip 
                            ON di.cve_documento_importado = dip.cve_documento_importado
                            WHERE dip.cve_proceso = $cve_consejo AND dip.cve_tipo_proceso = 3";
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