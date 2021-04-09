<?php
class comandoDetalleSesion
{
    private $SQL;
    private $sta;

    function __construct()
    { }

    /**
     * @nombre : ModificarSesion
     * @descripcion: UPDATE en bd 
     */
    function GuardarUbicacion($p)
    {
        try {
            $Conexion = Conexion::getInstance()->obtenerConexion();

            $this->SQL = "UPDATE [dbo].[sesiones]
            SET [ubicacion] = :ubicacion,
                [hora_inicio] = :hora_inicio,
                [hora_fin] = :hora_fin,
                [cve_usuario] = :cve_usuario_registro
                
          WHERE cve_consejo = :cve_consejo AND cve_sesion = :cve_sesion ";

            $this->sta = $Conexion->prepare($this->SQL);
            $this->sta->bindValue(':ubicacion', $p->__get('ubicacion'), PDO::PARAM_STR);
            $this->sta->bindValue(':hora_inicio', $p->__get('h_inicio'), PDO::PARAM_STR);
            $this->sta->bindValue(':hora_fin', $p->__get('h_fin'), PDO::PARAM_STR);
            $this->sta->bindValue(':cve_usuario_registro', $p->__get('cve_usuario_registro'), PDO::PARAM_INT);
           
            $this->sta->bindValue(':cve_consejo', $p->__get('cve_consejo'), PDO::PARAM_INT);
            $this->sta->bindValue(':cve_sesion', $p->__get('cve_sesion'), PDO::PARAM_INT);

            return $this->sta->execute();
        } catch (Exception $e) {

            error_log($e->getMessage());
            echo $e->getMessage();

            return false;
        }
        Conexion::getInstance()->cerrarConexion();
    }

    function Desarrollo($p)
    {
        try {
            $Conexion = Conexion::getInstance()->obtenerConexion();

            $this->SQL = "UPDATE [dbo].[sesiones]
            SET [desarrollo] = :desarrollo
                
          WHERE cve_consejo = :cve_consejo AND cve_sesion = :cve_sesion ";

            $this->sta = $Conexion->prepare($this->SQL);
            $this->sta->bindValue(':desarrollo', $p->__get('desarrollo'), PDO::PARAM_INT);
           
            $this->sta->bindValue(':cve_consejo', $p->__get('cve_consejo'), PDO::PARAM_INT);
            $this->sta->bindValue(':cve_sesion', $p->__get('cve_sesion'), PDO::PARAM_INT);

            return $this->sta->execute();
        } catch (Exception $e) {

            error_log($e->getMessage());
            echo $e->getMessage();

            return false;
        }
        Conexion::getInstance()->cerrarConexion();
    }

    function Finalizar($p)
    {
        try {
            $Conexion = Conexion::getInstance()->obtenerConexion();

            $this->SQL = "UPDATE [dbo].[sesiones]
            SET [activo] = :finalizar
                
          WHERE cve_consejo = :cve_consejo AND cve_sesion = :cve_sesion ";

            $this->sta = $Conexion->prepare($this->SQL);
            $this->sta->bindValue(':finalizar', $p->__get('finalizar'), PDO::PARAM_INT);
           
            $this->sta->bindValue(':cve_consejo', $p->__get('cve_consejo'), PDO::PARAM_INT);
            $this->sta->bindValue(':cve_sesion', $p->__get('cve_sesion'), PDO::PARAM_INT);

            return $this->sta->execute();
        } catch (Exception $e) {

            error_log($e->getMessage());
            echo $e->getMessage();

            return false;
        }
        Conexion::getInstance()->cerrarConexion();
    }


    /**
     * @nombre :Modificar
     * @descripcion:inserta en bd 
     */
    function Modificar($p)
    {
        try {
            $Conexion = Conexion::getInstance()->obtenerConexion();

            $Conexion->beginTransaction(); //inicia transaccion

            $this->SQL = "UPDATE [dbo].[persona]
            SET [nombre] = :nombre
               ,[paterno] = :paterno
               ,[materno] = :materno
               ,[correo] = :correo
               ,[celular] = :celular
          WHERE cve_persona = :cve_persona ";

            $this->sta = $Conexion->prepare($this->SQL);
            $this->sta->bindValue(':nombre', $p->__get('nombre'), PDO::PARAM_STR);
            $this->sta->bindValue(':paterno', $p->__get('paterno'), PDO::PARAM_STR);
            $this->sta->bindValue(':materno', $p->__get('materno'), PDO::PARAM_STR);
            $this->sta->bindValue(':correo', $p->__get('correo'), PDO::PARAM_STR);
            $this->sta->bindValue(':celular', $p->__get('celular'), PDO::PARAM_STR);
            $this->sta->bindValue(':cve_persona', $p->__get('cve_persona'), PDO::PARAM_INT);

            $this->sta->execute();

            /**
             * Insertar participante
             */
            $this->SQL = "UPDATE [dbo].[participantes]
            SET [cve_tipo_participante] = :cve_tipo_participante
               ,[cve_participante_primario] = :cve_participante_primario
               ,[institucion] = :institucion
               ,[responsable_consejo] = :responsable_consejo
               ,[cve_usuario_registro] = :cve_usuario_registro
            WHERE cve_persona = :cve_persona AND cve_participante = :cve_participante ";

            $this->sta2 = $Conexion->prepare($this->SQL);

            $this->sta2->bindValue(':cve_tipo_participante', $p->__get('cve_tipo_participante'), PDO::PARAM_INT);
            $this->sta2->bindValue(':cve_participante_primario', $p->__get('cve_participante_primario'), PDO::PARAM_INT);
            $this->sta2->bindValue(':institucion', $p->__get('institucion'), PDO::PARAM_STR);
            $this->sta2->bindValue(':responsable_consejo', $p->__get('responsable_consejo'), PDO::PARAM_INT);
            $this->sta2->bindValue(':cve_usuario_registro', $p->__get('cve_usuario_registro'), PDO::PARAM_INT);
            $this->sta2->bindValue(':cve_persona', $p->__get('cve_persona'), PDO::PARAM_INT);
            $this->sta2->bindValue(':cve_participante', $p->__get('cve_participante'), PDO::PARAM_INT);

            $this->sta2->execute();

            /**
             * Insertar usuario
             */
            $this->SQL = "UPDATE [dbo].[usuario]
            SET [usuario] = :usuario
            WHERE cve_persona = :cve_persona ";

            $this->sta3 = $Conexion->prepare($this->SQL);

            $this->sta3->bindValue(':usuario', $p->__get('usuario'), PDO::PARAM_STR);
            $this->sta3->bindValue(':cve_persona', $p->__get('cve_persona'), PDO::PARAM_INT);

            $this->sta3->execute();

            return $Conexion->commit();
        } catch (Exception $e) {

            error_log($e->getMessage());
            echo $e->getMessage();
            $Conexion->rollBack();
            return 0;
        }
        Conexion::getInstance()->cerrarConexion();
    }



    /**
     * @nombre :lista
     * @descripcion:consulta en bd interesado.
     */
    function TablaAsistencia($p)
    {

        try {
            $Conexion = Conexion::getInstance()->obtenerConexion();

            $this->SQL = "SELECT        participantes_consejos.cve_consejo, persona.cve_persona, participantes.cve_participante, participantes.cve_institucion, participantes_consejos.cve_tipo_participante, persona.paterno, persona.materno, persona.nombre, 
                        ISNULL(participantes_1.cve_participante, 0) AS s_cve_participante, ISNULL(persona_1.paterno, '-') AS s_paterno, ISNULL(persona_1.materno, '-') AS s_materno, ISNULL(persona_1.nombre, '-') AS s_nombre
                FROM            persona AS persona_1 INNER JOIN
                            participantes AS participantes_1 ON persona_1.cve_persona = participantes_1.cve_persona RIGHT OUTER JOIN
                            participantes_consejos INNER JOIN
                            participantes ON participantes_consejos.cve_participante = participantes.cve_participante INNER JOIN
                            persona ON participantes.cve_persona = persona.cve_persona ON participantes_1.cve_participante = participantes_consejos.cve_participante_suplente
                WHERE        (participantes.activo = 1) AND (persona.activo = 1) AND (participantes_consejos.cve_consejo = :cve_consejo) AND (participantes_consejos.activo = 1) AND (participantes_consejos.cve_tipo_participante = 2) AND (NOT EXISTS
                                (SELECT        TOP (1) cve_asistencia_sesion, cve_sesion, cve_participante, fecha_registro
                                FROM            asistencia_sesiones
                                WHERE        (cve_sesion = :cve_sesion) AND (cve_participante = participantes.cve_participante)))
                ORDER BY participantes.cve_institucion, participantes_consejos.fecha_registro DESC ";
            
            $this->sta = $Conexion->prepare($this->SQL);
            $this->sta->bindValue(':cve_consejo', $p->__get('cve_consejo'), PDO::PARAM_INT);
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
     * @nombre :lista
     * @descripcion:consulta en bd interesado.
     */
    function Consejos($admin, $p)
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
                WHERE        (consejos.activo = 1) AND (usuario.cve_usuario = :cve_suario) ";
            }

            $this->sta = $Conexion->prepare($this->SQL);
            if (!$admin) {
                $this->sta->bindValue(':cve_usuario', $p->__get('cve_usuario'), PDO::PARAM_INT);
            }

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
     * @nombre :lista
     * @descripcion:consulta en bd interesado.
     */
    function Sesiones($p)
    {
        try {
            $Conexion = Conexion::getInstance()->obtenerConexion();

            $this->SQL = "SELECT        sesiones.cve_sesion AS id, sesiones.nombre, ISNULL(sesiones.ubicacion, '') AS ubicacion, ISNULL(sesiones.desarrollo, '') AS desarrollo, ISNULL(sesiones.hora_inicio, '') AS hora_inicio, ISNULL(sesiones.hora_fin, '') AS hora_fin
                FROM            consejos INNER JOIN
                                         sesiones ON consejos.cve_consejo = sesiones.cve_consejo
                WHERE        (consejos.activo = 1) AND (sesiones.activo = 0) AND (consejos.cve_consejo = :cve_consejo)";


            $this->sta = $Conexion->prepare($this->SQL);
            $this->sta->bindValue(':cve_consejo', $p->__get('cve_consejo'), PDO::PARAM_INT);
            $this->sta->execute();
            $datos = $this->sta->fetchAll(PDO::FETCH_ASSOC);
            Conexion::getInstance()->cerrarConexion();
            return $datos;
        } catch (Exception $e) {
            Conexion::getInstance()->cerrarConexion();
            return [];
        }
    }
}
