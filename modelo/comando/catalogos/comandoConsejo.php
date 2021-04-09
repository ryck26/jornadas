<?php
class comandoConsejo
{
	private $SQL;
	private $sta;
	
    function __construct(){
        
    }

    function listaResponsables()
    {
        try {
            $Conexion = Conexion::getInstance()->obtenerConexion();
            $this->SQL = "SELECT pa.cve_participante AS id, CONCAT(pe.nombre, ' ', pe.paterno, ' ', pe.materno) AS nombre
                            FROM participantes pa INNER JOIN persona pe
                            ON pa.cve_persona = pe.cve_persona";
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

    function altaConsejo($nombre, $responsable, $cve_persona_session)
    {
        try {
            $Conexion = Conexion::getInstance()->obtenerConexion();
            $this->SQL = "INSERT INTO consejos (nombre, cve_participante, activo, descripcion, objetivos, alcance) 
                            VALUES ('$nombre', '$responsable', 1, '', '', '')";
            $this->sta = $Conexion->prepare($this->SQL);
            $this->sta->execute();
            $id = $Conexion->lastInsertId();
            $this->SQL = "INSERT INTO participantes_consejos (cve_consejo, cve_participante, cve_tipo_participante, activo, cve_usuario) 
                            VALUES ('$id', '$responsable', 1, 1, (SELECT cve_usuario FROM usuario WHERE cve_persona = $cve_persona_session))";
            $this->sta = $Conexion->prepare($this->SQL);
            $this->sta->execute();
            //insertar aqui participante del consejo       
            Conexion::getInstance()->cerrarConexion();
			//var_dump($datos);
            return $id;
        }catch (Exception $e){
            Conexion::getInstance()->cerrarConexion();
            return $e->getMessage();
        }
    }

    function listaResponsablesConsejo()
    {
        try {
            $Conexion = Conexion::getInstance()->obtenerConexion();
            $this->SQL = "SELECT c.cve_participante, pe.nombre + ' ' + pe.paterno + ' ' + pe.materno AS nombreP, c.nombre
            FROM consejos c 
            INNER JOIN participantes pa ON pa.cve_participante = c.cve_participante
            INNER JOIN persona pe ON pa.cve_persona = pe.cve_persona";
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