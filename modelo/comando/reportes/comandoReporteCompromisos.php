<?php
class comandoReporteCompromisos
{
	private $SQL;
	private $sta;
	
    function __construct(){
        
    }

    function listaConsejos($admin,$p)
    {
        try {
            $Conexion = Conexion::getInstance()->obtenerConexion();
            if ($admin) {
                $this->SQL = "SELECT  consejos.cve_consejo AS id, consejos.nombre, usuario.cve_usuario
                FROM            consejos INNER JOIN
                                         participantes ON consejos.cve_participante = participantes.cve_participante INNER JOIN
                                         usuario ON participantes.cve_persona = usuario.cve_persona
                WHERE        (consejos.activo = 1)  ";
            } else {
                $this->SQL = "SELECT  consejos.cve_consejo AS id, consejos.nombre, usuario.cve_usuario
                FROM            consejos INNER JOIN
                                         participantes ON consejos.cve_participante = participantes.cve_participante INNER JOIN
                                         usuario ON participantes.cve_persona = usuario.cve_persona
                WHERE        (consejos.activo = 1) AND (usuario.cve_usuario = :cve_usuario) ORDER BY consejos.nombre ASC ";
            }
				
            $this->sta = $Conexion->prepare($this->SQL);
            if (!$admin) {
                $this->sta->bindValue(':cve_usuario', $p->__get('cve_usuario_registro'), PDO::PARAM_INT);
            }
            
            $this->sta->execute();
            $datos = $this->sta->fetchAll(PDO::FETCH_ASSOC);
            
			//var_dump($datos);
            return $datos;
        }catch (Exception $e){
            Conexion::getInstance()->cerrarConexion();
            return $e->getMessage();
        }finally{
			Conexion::getInstance()->cerrarConexion();
		}
    }

    function listaSesiones($cve_consejo)
    {
        try {
            $Conexion = Conexion::getInstance()->obtenerConexion();
            $this->SQL = "SELECT nombre, cve_sesion
                            FROM sesiones
                            WHERE cve_consejo = $cve_consejo";
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

    function listaParticipantes($cve_sesion)
    {
        try {
            $Conexion = Conexion::getInstance()->obtenerConexion();
            $this->SQL = "SELECT  CONCAT(pe.nombre, ' ', pe.paterno, ' ', pe.materno) AS nombre, pa.cve_participante
                            FROM acuerdo_compromiso ac INNER JOIN participantes_compromisos pc
                            ON ac.cve_acuerdo_compromiso = pc.cve_acuerdo_compromiso
                            INNER JOIN participantes pa ON pc.cve_participante = pa.cve_participante
                            INNER JOIN persona pe ON pa.cve_persona = pe.cve_persona
                            WHERE ac.cve_sesion = $cve_sesion";
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

    function listaCompromisos($cve_participante)
    {
        try {
            $Conexion = Conexion::getInstance()->obtenerConexion();
            $this->SQL = "SELECT ac.cve_acuerdo_compromiso, ac.titulo, ac.fecha_cumplimiento,
                                    co.nombre, ac.descripcion, ac.fecha_registro, 
                                    ac.fecha_cumplimiento, ac.porcentaje_avance
                                    FROM acuerdo_compromiso ac INNER JOIN participantes_compromisos pc
                                    ON ac.cve_acuerdo_compromiso = pc.cve_acuerdo_compromiso
                                    INNER JOIN participantes pa ON pc.cve_participante = pa.cve_participante
                                    INNER JOIN sesiones se ON ac.cve_sesion = se.cve_sesion
                                    INNER JOIN consejos co ON se.cve_consejo = co.cve_consejo
                                    WHERE pa.cve_participante = $cve_participante";
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

    function listaAvances($cve_acuerdo_compromiso)
    {
        try {
            $Conexion = Conexion::getInstance()->obtenerConexion();
            $this->SQL = "SELECT cve_detalle_compromiso, nota, porcentaje_avance, estatus
                                    FROM detalle_compromiso
                                    WHERE cve_acuerdo_compromiso = $cve_acuerdo_compromiso";
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