<?php
class comandoDocumentoSesion
{
    private $SQL;
    private $sta;

    function __construct()
    { }

     /**
     * @nombre : Guardar
     * @descripcion: GuardarAsistencia en bd 
     */
    function GuardarAsistencia($cve_sesion,$cve_participante)
    {
        try {
            
            $Conexion = Conexion::getInstance()->obtenerConexion();

            $this->SQL = "IF NOT Exists((SELECT        cve_asistencia_sesion, cve_sesion, cve_participante, fecha_registro
            FROM            asistencia_sesiones
            WHERE        (cve_sesion = :cve_sesion) AND (cve_participante = :cve_participante)))
            BEGIN
                INSERT INTO [dbo].[asistencia_sesiones]
                            ([cve_sesion],
                            [cve_participante]) values (:cve_sesion2,:cve_participante2)
            END"; 
            // var_dump( $this->SQL);
            $this->sta = $Conexion->prepare($this->SQL);
            $this->sta->bindValue(':cve_sesion', $cve_sesion, PDO::PARAM_INT);
            $this->sta->bindValue(':cve_participante', $cve_participante, PDO::PARAM_INT);
            $this->sta->bindValue(':cve_sesion2', $cve_sesion, PDO::PARAM_INT);
            $this->sta->bindValue(':cve_participante2', $cve_participante, PDO::PARAM_INT);

            return $this->sta->execute();
        } catch (Exception $e) {

            error_log($e->getMessage());
            echo $e->getMessage();

            return false;
        }

        Conexion::getInstance()->cerrarConexion();
    }

    /**
     * @nombre :lista
     * @descripcion:consulta en bd interesado.
     */
    function TablaDocumentos($p)
    {

        try {
            $Conexion = Conexion::getInstance()->obtenerConexion();
            $this->SQL = "SELECT        tipo_proceso.cve_tipo_proceso, tipo_proceso.descripcion, documento_imp_proceso.cve_documento_importado, documento_imp_proceso.cve_proceso, documentos_importados.nombre, documentos_importados.ruta,
                    sesiones.cve_sesion, sesiones.cve_consejo
            FROM            tipo_proceso INNER JOIN
                    documento_imp_proceso ON tipo_proceso.cve_tipo_proceso = documento_imp_proceso.cve_tipo_proceso INNER JOIN
                    documentos_importados ON documento_imp_proceso.cve_documento_importado = documentos_importados.cve_documento_importado INNER JOIN
                    sesiones ON documento_imp_proceso.cve_proceso = sesiones.cve_sesion
            WHERE        (tipo_proceso.cve_tipo_proceso = 3) 
            AND (tipo_proceso.activo = 1) 
            AND (documentos_importados.activo = 1) 
            AND (sesiones.cve_sesion = :cve_sesion) ";

            $this->sta = $Conexion->prepare($this->SQL);
            $this->sta->bindValue(':cve_sesion', $p->__get('cve_sesion'), PDO::PARAM_INT);
            $this->sta->execute();
            $datos = $this->sta->fetchAll(PDO::FETCH_ASSOC);
            Conexion::getInstance()->cerrarConexion();
            return $datos;
        } catch (Exception $e) {
            Conexion::getInstance()->cerrarConexion();
            return [];
        }
    }


    /**
     * @nombre : Eliminar
     * @descripcion: Eliminar documento en bd 
     */
    // function EliminarAsistencia($p)
    // {
    //     try {
            
    //         $Conexion = Conexion::getInstance()->obtenerConexion();

    //         $this->SQL = "DELETE FROM  [dbo].[asistencia_sesiones]
    //                         WHERE cve_asistencia_sesion =:cve_asistencia_sesion ";
    //         // var_dump( $this->SQL);
    //         $this->sta = $Conexion->prepare($this->SQL);
    //         $this->sta->bindValue(':cve_asistencia_sesion', $p->__get('cve_asistencia_sesion'), PDO::PARAM_INT);
    //         return $this->sta->execute();
    //     } catch (Exception $e) {

    //         error_log($e->getMessage());
    //         echo $e->getMessage();

    //         return false;
    //     }

    //     Conexion::getInstance()->cerrarConexion();
    // }

}