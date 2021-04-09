<?php
class ComandoDetalleAsistencia
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
    function TablaAsistenciaSesion($p)
    {

        try {
            $Conexion = Conexion::getInstance()->obtenerConexion();
            $this->SQL = "SELECT        persona.paterno, persona.materno, persona.nombre, persona.cve_persona, asistencia_sesiones.cve_asistencia_sesion, asistencia_sesiones.cve_sesion, asistencia_sesiones.cve_participante, participantes.cve_institucion, 
                            instituciones.nombre AS institucion
                    FROM            asistencia_sesiones INNER JOIN
                            participantes ON asistencia_sesiones.cve_participante = participantes.cve_participante INNER JOIN
                            persona ON participantes.cve_persona = persona.cve_persona INNER JOIN
                            instituciones ON participantes.cve_institucion = instituciones.cve_institucion
                    WHERE        (participantes.activo = 1) AND
                     (participantes.activo = 1) AND
                      (persona.activo = 1) AND
                       (instituciones.activo = 1) AND
                        (asistencia_sesiones.cve_sesion = :cve_sesion) ";

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
     * @nombre : Guardar
     * @descripcion: GuardarAsistencia en bd 
     */
    function EliminarAsistencia($p)
    {
        try {
            
            $Conexion = Conexion::getInstance()->obtenerConexion();

            $this->SQL = "DELETE FROM  [dbo].[asistencia_sesiones]
                            WHERE cve_asistencia_sesion =:cve_asistencia_sesion ";
            // var_dump( $this->SQL);
            $this->sta = $Conexion->prepare($this->SQL);
            $this->sta->bindValue(':cve_asistencia_sesion', $p->__get('cve_asistencia_sesion'), PDO::PARAM_INT);
            return $this->sta->execute();
        } catch (Exception $e) {

            error_log($e->getMessage());
            echo $e->getMessage();

            return false;
        }

        Conexion::getInstance()->cerrarConexion();
    }

}