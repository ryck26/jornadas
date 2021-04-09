<?php
class comandoSubirArchivo
{
	private $SQL;
	private $sta;
	
    function __construct(){
    }

    function subirArchivo($nombre, $ruta, $cve_proceso, $tipo_proceso, $cve_participante)
    {
        try {
            $Conexion = Conexion::getInstance()->obtenerConexion();
            $this->SQL = "INSERT INTO documentos_importados (nombre, ruta, activo, fecha_registro) 
            VALUES ('$nombre', '$ruta', 1, GETDATE());";
            $this->sta = $Conexion->prepare($this->SQL);
            $this->sta->execute();
            $cve_documento_importado = $Conexion->lastInsertId();   
            $this->SQL = "INSERT INTO documento_imp_proceso (cve_proceso, cve_documento_importado, cve_tipo_proceso)
                        VALUES ($cve_proceso, $cve_documento_importado, $tipo_proceso);";
            $this->sta = $Conexion->prepare($this->SQL);
            $this->sta->execute();
            if($cve_participante!=0)
            {
                $this->SQL = "UPDATE participantes_consejos SET cve_documento_importado = $cve_documento_importado
                WHERE cve_participante = $cve_participante AND cve_consejo = $cve_proceso;";
                $this->sta = $Conexion->prepare($this->SQL);
                $this->sta->execute();
            }
            // }else if($esSesion)
            // {
            //     $this->SQL = "UPDATE sesiones SET cve_documento_importado = $cve_documento_importado
            //     WHERE cve_sesion = $cve_proceso;";
            //     $this->sta = $Conexion->prepare($this->SQL);
            //     $this->sta->execute();
            // }
            
            Conexion::getInstance()->cerrarConexion();
			//var_dump($datos);
            return 1;
        }catch (Exception $e){
            Conexion::getInstance()->cerrarConexion();
            return $e->getMessage();
        }
    }


}
?>