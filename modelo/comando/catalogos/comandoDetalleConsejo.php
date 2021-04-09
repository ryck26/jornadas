<?php
class comandoDetalleConsejo
{
	private $SQL;
	private $sta;
	
    function __construct(){
        
    }

    function listaConsejos($cve_persona_session)
    {
        try {
            $Conexion = Conexion::getInstance()->obtenerConexion();
            $this->SQL = "SELECT co.cve_consejo AS cveConsejo, co.nombre AS nombreConsejo
                            FROM consejos co 
                            INNER JOIN participantes_consejos pc ON pc.cve_consejo = co.cve_consejo
                            INNER JOIN participantes pa ON pa.cve_participante = pc.cve_participante
                            WHERE pa.cve_persona = $cve_persona_session";
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

    function guardarDetalle($cve_consejo, $descripcion, $objetivos, $alcance)
    {
        try {
            $Conexion = Conexion::getInstance()->obtenerConexion();
            $this->SQL = "UPDATE consejos SET descripcion = '$descripcion', objetivos = '$objetivos', alcance = '$alcance'
                            WHERE cve_consejo = $cve_consejo";
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

    function consultarDatosConsejo($cve_consejo)
    {
        try {
            $Conexion = Conexion::getInstance()->obtenerConexion();
            $this->SQL = "SELECT descripcion, objetivos, alcance 
            FROM consejos WHERE cve_consejo = $cve_consejo";
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

    function listaParticipantes($cve_consejo)
    {
        try {
            $Conexion = Conexion::getInstance()->obtenerConexion();
            $this->SQL = "SELECT DISTINCT pa.cve_participante AS cveParticipante, pe.nombre + ' ' + pe.paterno + ' ' + pe.materno AS nombreParticipante, it.nombre AS institucion
            FROM persona AS pe 
            INNER JOIN participantes AS pa ON pe.cve_persona = pa.cve_persona 
            INNER JOIN instituciones AS it ON pa.cve_institucion = it.cve_institucion
            LEFT OUTER JOIN participantes_consejos AS pc ON pa.cve_participante = pc.cve_participante
            WHERE (ISNULL(pc.cve_consejo, 0) <> $cve_consejo)
            AND pa.cve_participante NOT IN ((SELECT cve_participante FROM participantes_consejos WHERE cve_consejo = $cve_consejo))";
            // (pa.cve_tipo_participante = 2) AND
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

    function listaParticipantesSinSuplentes($cve_consejo)
    {
        try {
            $Conexion = Conexion::getInstance()->obtenerConexion();
            $this->SQL = "SELECT pa.cve_participante AS cve_participante, pe.nombre + ' ' + pe.paterno + ' ' + pe.materno AS nombre_suplantado
                            FROM persona AS pe 
                            INNER JOIN participantes AS pa ON pe.cve_persona = pa.cve_persona 
                            INNER JOIN participantes_consejos AS pc ON pa.cve_participante = pc.cve_participante
                            WHERE pc.cve_consejo = $cve_consejo AND cve_tipo_participante != 3 AND  (cve_participante_suplente IS NULL or cve_participante_suplente= 0 )";
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


    function listaParticipantesConsejo($cve_consejo)
    {
        try {
            $Conexion = Conexion::getInstance()->obtenerConexion();
            $this->SQL = "SELECT pa.cve_participante AS cveParticipante, pe.nombre + ' ' + pe.paterno + ' ' + pe.materno AS nombreParticipante, pc.cve_documento_importado AS doc,
                            di.nombre AS nombre_documento, pc.cve_tipo_participante
                            FROM persona AS pe 
                            INNER JOIN participantes AS pa ON pe.cve_persona = pa.cve_persona 
                            INNER JOIN participantes_consejos AS pc ON pa.cve_participante = pc.cve_participante
                            LEFT JOIN documentos_importados AS di ON pc.cve_documento_importado = di.cve_documento_importado
                            LEFT JOIN documento_imp_proceso AS dip ON di.cve_documento_importado = dip.cve_documento_importado
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

    function agregarParticipante($cve_consejo, $cve_participante, $cve_persona_session, $cve_tipo, $cve_suplantado)
    {
        try {
            $Conexion = Conexion::getInstance()->obtenerConexion();
            $this->SQL = "INSERT INTO participantes_consejos (cve_consejo, cve_participante, cve_tipo_participante, activo, cve_usuario) 
                        VALUES ('$cve_consejo', '$cve_participante', $cve_tipo, 1, (SELECT cve_usuario FROM usuario WHERE cve_persona = $cve_persona_session))";
            $this->sta = $Conexion->prepare($this->SQL);
            $this->sta->execute();
            //var_dump($cve_tipo);
            if($cve_tipo == "3")
            {
                $this->SQL = "UPDATE participantes_consejos SET cve_participante_suplente = $cve_participante
                WHERE cve_participante = $cve_suplantado";
                $this->sta = $Conexion->prepare($this->SQL);
                $this->sta->execute();
                $datos = $this->sta->fetchAll(PDO::FETCH_ASSOC);
                Conexion::getInstance()->cerrarConexion();
            }
            return $datos;
        }catch (Exception $e){
            Conexion::getInstance()->cerrarConexion();
            return $e->getMessage();
        }
    }

    function listaDocumentos($cve_consejo, $tipo_proceso)
    {
        try {
            $Conexion = Conexion::getInstance()->obtenerConexion();
            //El proceso 1 corresponde a un consejo
                $this->SQL = "SELECT di.cve_documento_importado AS cve, di.nombre AS nombre 
                            FROM documentos_importados di 
                            INNER JOIN documento_imp_proceso dip 
                            ON di.cve_documento_importado = dip.cve_documento_importado 
                            WHERE dip.cve_proceso = $cve_consejo AND dip.cve_tipo_proceso = $tipo_proceso;";
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

    function listaSuplentes($cve_consejo)
    {
        try {
            $Conexion = Conexion::getInstance()->obtenerConexion();
            //El proceso 1 corresponde a un consejo
                $this->SQL = "SELECT pe.nombre + ' ' + pe.paterno + ' ' + pe.materno AS suplente,
                            (SELECT pe2.nombre + ' ' + pe2.paterno + ' ' + pe2.materno AS nombreS
                            FROM persona AS pe2 
                            INNER JOIN participantes AS pa2 ON pe2.cve_persona = pa2.cve_persona
                            INNER JOIN participantes_consejos AS pc2 ON pa2.cve_participante = pc2.cve_participante
                            WHERE pc2.cve_participante_suplente IS NOT NULL 
                            AND pc2.cve_participante_suplente = pc.cve_participante AND pc2.cve_consejo = $cve_consejo) as principal
                            FROM persona AS pe 
                            INNER JOIN participantes AS pa ON pe.cve_persona = pa.cve_persona 
                            INNER JOIN participantes_consejos AS pc ON pa.cve_participante = pc.cve_participante
                            WHERE pc.cve_consejo = $cve_consejo AND pc.cve_tipo_participante = 3";
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
    function removerParticipante($cve_participante)
    {
        try {
            $Conexion = Conexion::getInstance()->obtenerConexion();
            $this->SQL = "DELETE FROM participantes_consejos
                            WHERE cve_participante = $cve_participante";
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
	
	function removerSuplente($cve_participante,$cve_consejo)
    {
        try {
            $Conexion = Conexion::getInstance()->obtenerConexion();
            $this->SQL = "UPDATE participantes_consejos set cve_participante_suplente = 0
                            WHERE cve_consejo = $cve_consejo  
							AND cve_participante_suplente= $cve_participante ";
						
            $this->sta = $Conexion->prepare($this->SQL);
            return $this->sta->execute();
            
            Conexion::getInstance()->cerrarConexion();
             
        }catch (Exception $e){
            Conexion::getInstance()->cerrarConexion();
            return $e->getMessage();
        }
    }
}
?>