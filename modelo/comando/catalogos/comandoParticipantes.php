<?php
class ComandoResponsables
{
    private $SQL;
    private $sta;

    function __construct()
    { }

    /**
     * @nombre :insertar
     * @descripcion:inserta en bd 
     */
    function insertar($p)
    {
        try {
            $Conexion = Conexion::getInstance()->obtenerConexion();

            $Conexion->beginTransaction(); //inicia transaccion

            $this->SQL = "INSERT INTO persona
                    (nombre
                    ,paterno
                    ,materno
                    ,correo
                    ,celular)
            VALUES
                    (:nombre
                    ,:paterno
                    ,:materno
                    ,:correo
                    ,:celular)";
        
            $this->sta = $Conexion->prepare($this->SQL);
            $this->sta->bindValue(':nombre', $p->__get('nombre'), PDO::PARAM_STR);
            $this->sta->bindValue(':paterno', $p->__get('paterno'), PDO::PARAM_STR);
            $this->sta->bindValue(':materno', $p->__get('materno'), PDO::PARAM_STR);
            $this->sta->bindValue(':correo', $p->__get('correo'), PDO::PARAM_STR);
            $this->sta->bindValue(':celular', $p->__get('celular'), PDO::PARAM_STR);
            $this->sta->execute();
            $id = $Conexion->lastInsertId();
            
            /**
             * Insertar participante
             */
            $this->SQL = "INSERT INTO [dbo].[participantes]
            ([cve_persona]
            ,[cve_institucion]
            ,[cve_usuario_registro])
      VALUES
            (:cve_persona
            ,:cve_institucion
            ,:cve_usuario_registro)";

            $this->sta2 = $Conexion->prepare($this->SQL);
            $this->sta2->bindValue(':cve_persona', $id, PDO::PARAM_INT);
            // $this->sta2->bindValue(':cve_tipo_participante', $p->__get('cve_tipo_participante'), PDO::PARAM_INT);
            // $this->sta2->bindValue(':cve_participante_primario', $p->__get('cve_participante_primario'), PDO::PARAM_INT);
            $this->sta2->bindValue(':cve_institucion', $p->__get('cve_institucion'), PDO::PARAM_STR);
            // $this->sta2->bindValue(':responsable_consejo', $p->__get('responsable_consejo'), PDO::PARAM_INT);
            $this->sta2->bindValue(':cve_usuario_registro', $p->__get('cve_usuario_registro'), PDO::PARAM_INT);
           
            $this->sta2->execute();

            /**
             * Insertar usuario
             */
            $this->SQL = "INSERT INTO usuario
                    (cve_persona
                    ,usuario)
            VALUES
                    (:cve_persona
                    ,:usuario)";

            $this->sta3 = $Conexion->prepare($this->SQL);
            $this->sta3->bindValue(':cve_persona', $id, PDO::PARAM_INT);
            $this->sta3->bindValue(':usuario', $p->__get('usuario'), PDO::PARAM_STR);
            
            $this->sta3->execute();

            /**
             * Insertar usuario grupo de seguridad
             */
            $this->SQL = "INSERT INTO [dbo].[usuario_grupo_seguridad]
            ([cve_persona]
            ,[cve_grupo_seguridad])
      VALUES
            (:cve_persona
            ,:cve_grupo_seguridad)";

            $this->sta4 = $Conexion->prepare($this->SQL);
            $this->sta4->bindValue(':cve_persona', $id, PDO::PARAM_INT);
            $this->sta4->bindValue(':cve_grupo_seguridad', $p->__get('cve_grupo_seguridad'), PDO::PARAM_INT);
            
            $this->sta4->execute();


            $Conexion->commit();    
            return $id;
        } catch (Exception $e) {
            
            error_log($e->getMessage());
            echo $e->getMessage();
            $Conexion->rollBack();
            return 0;
        }
        Conexion::getInstance()->cerrarConexion();
    }


      /**
     * @nombre :insertar
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
            SET [cve_institucion] = :cve_institucion
               ,[cve_usuario_registro] = :cve_usuario_registro
            WHERE cve_persona = :cve_persona AND cve_participante = :cve_participante ";

            $this->sta2 = $Conexion->prepare($this->SQL);

            // $this->sta2->bindValue(':cve_tipo_participante', $p->__get('cve_tipo_participante'), PDO::PARAM_INT);
            // $this->sta2->bindValue(':cve_participante_primario', $p->__get('cve_participante_primario'), PDO::PARAM_INT);
            $this->sta2->bindValue(':cve_institucion', $p->__get('cve_institucion'), PDO::PARAM_STR);
            // $this->sta2->bindValue(':responsable_consejo', $p->__get('responsable_consejo'), PDO::PARAM_INT);
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
            $this->sta3->bindValue(':cve_persona',$p->__get('cve_persona'), PDO::PARAM_INT);
            
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
     * @nombre :insertar
     * @descripcion:inserta en bd 
     */
    function ActualizarContrasena($p)
    {
        // var_dump($p);
        try {
            $Conexion = Conexion::getInstance()->obtenerConexion();

            $this->SQL = "UPDATE [dbo].[usuario]
            SET [contrasena] = :contrasena
               ,[activo] = 1
          WHERE cve_persona =:cve_persona AND cve_usuario = :cve_usuario";
        
            $this->sta = $Conexion->prepare($this->SQL);
            $this->sta->bindValue(':contrasena', $p->__get('constrasena'), PDO::PARAM_STR);
            $this->sta->bindValue(':cve_persona', $p->__get('cve_persona'), PDO::PARAM_INT);
            $this->sta->bindValue(':cve_usuario', $p->__get('cve_usuario'), PDO::PARAM_INT);
            
            return $this->sta->execute();
           
        } catch (Exception $e) {
            
            error_log($e->getMessage());
            echo $e->getMessage();
            $Conexion->rollBack();
            return false;
        }
        Conexion::getInstance()->cerrarConexion();
    }

    /**
     * @nombre :insertar
     * @descripcion:inserta en bd 
     */
    function Desactivar($p)
    {
        // var_dump($p);
        try {
            $Conexion = Conexion::getInstance()->obtenerConexion();

            $this->SQL = "UPDATE [dbo].[usuario]
            SET [activo] = 0
          WHERE cve_persona =:cve_persona AND cve_usuario = :cve_usuario";
        
            $this->sta = $Conexion->prepare($this->SQL);
            $this->sta->bindValue(':cve_persona', $p->__get('cve_persona'), PDO::PARAM_INT);
            $this->sta->bindValue(':cve_usuario', $p->__get('cve_usuario'), PDO::PARAM_INT);
            
            return $this->sta->execute();
           
        } catch (Exception $e) {
            
            error_log($e->getMessage());
            echo $e->getMessage();
            $Conexion->rollBack();
            return false;
        }
        Conexion::getInstance()->cerrarConexion();
    }

    /**
     * @nombre :lista
     * @descripcion:consulta en bd interesado.
     */
    function ListaUsuarios($p)
    {
        try {
            $Conexion = Conexion::getInstance()->obtenerConexion();
            // $this->SQL = "SELECT        persona.paterno, persona.materno, persona.nombre, persona.correo, persona.celular, persona.activo AS p_activo, usuario.usuario, ISNULL(usuario.contrasena, '-') AS contrasena, usuario.activo AS u_activo, 
            //                 participantes.institucion, participantes.activo AS r_activo, participantes.cve_participante, usuario.cve_usuario, participantes.cve_persona, participantes.cve_tipo_participante, participantes.cve_participante_primario, 
            //                 participantes.responsable_consejo, ISNULL(persona_1.paterno, '-') AS p_paterno, ISNULL(persona_1.materno, '-') AS p_materno, ISNULL(persona_1.nombre, '-') AS p_nombre, 
            //                 tipo_participantes.nombre AS tipo_participante
            //              FROM            tipo_participantes INNER JOIN
            //                 persona INNER JOIN
            //                 participantes ON persona.cve_persona = participantes.cve_persona INNER JOIN
            //                 usuario ON persona.cve_persona = usuario.cve_persona ON tipo_participantes.cve_tipo_participante = participantes.cve_tipo_participante LEFT OUTER JOIN
            //                 persona AS persona_1 INNER JOIN
            //                 participantes AS participantes_1 ON persona_1.cve_persona = participantes_1.cve_persona ON participantes.cve_participante_primario = participantes_1.cve_participante 
            //                 WHERE participantes.cve_tipo_participante =:cve_tipo_participante " ;

            $this->SQL = "SELECT        persona.paterno, persona.materno, persona.nombre, persona.correo, persona.celular, persona.activo AS p_activo, usuario.usuario, ISNULL(usuario.contrasena, '-') AS contrasena, usuario.activo AS u_activo, 
                         participantes.cve_institucion, participantes.activo AS r_activo, participantes.cve_participante, usuario.cve_usuario, participantes.cve_persona, ISNULL(instituciones.nombre, 'Sin asignar') AS institucion
            FROM            persona INNER JOIN
                        participantes ON persona.cve_persona = participantes.cve_persona INNER JOIN
                        usuario ON persona.cve_persona = usuario.cve_persona LEFT OUTER JOIN
                        instituciones ON participantes.cve_institucion = instituciones.cve_institucion 
                        ORDER BY participantes.fecha_registro DESC";

            $this->sta = $Conexion->prepare($this->SQL);
            // $this->sta->bindValue(':cve_tipo_participante', $p->__get('cve_tipo_participante'), PDO::PARAM_INT);
            $this->sta->execute();
            $datos = $this->sta->fetchAll(PDO::FETCH_ASSOC);
            Conexion::getInstance()->cerrarConexion();
            return $datos;
        }catch (Exception $e){
            Conexion::getInstance()->cerrarConexion();
            return [];
        }
    }
     /**
     * @nombre :lista
     * @descripcion:consulta en bd interesado.
     */
    function TipoParticipante($admin)
    {
        try {
            $Conexion = Conexion::getInstance()->obtenerConexion();
            if($admin){
                $this->SQL = "SELECT        cve_tipo_participante AS id, nombre
                        FROM            tipo_participantes
                        WHERE        (activo = 1) AND (cve_grupo_seguridad IN (2, 3)) " ;
            }else{
                $this->SQL = "SELECT        cve_tipo_participante AS id, nombre
                        FROM            tipo_participantes
                        WHERE        (activo = 1) AND (cve_grupo_seguridad IN ( 3)) " ;
            }
            
            $this->sta = $Conexion->prepare($this->SQL);
            
            $this->sta->execute();
            $datos = $this->sta->fetchAll(PDO::FETCH_ASSOC);
            Conexion::getInstance()->cerrarConexion();
            return $datos;
        }catch (Exception $e){
            Conexion::getInstance()->cerrarConexion();
            return [];
        }
    }

    /**
     * @nombre :lista
     * @descripcion:consulta en bd interesado.
     */
    function ListaParticipantes()
    {
        try {
            $Conexion = Conexion::getInstance()->obtenerConexion();
           
                $this->SQL = "SELECT        persona.paterno + ' ' + persona.materno + ' ' + persona.nombre AS participante, participantes.cve_participante AS id
                FROM            persona INNER JOIN
                                         participantes ON persona.cve_persona = participantes.cve_persona
                WHERE        (participantes.activo = 1) AND (persona.activo = 1) AND (participantes.cve_tipo_participante = 2) " ;
            
            
            $this->sta = $Conexion->prepare($this->SQL);
            
            $this->sta->execute();
            $datos = $this->sta->fetchAll(PDO::FETCH_ASSOC);
            Conexion::getInstance()->cerrarConexion();
            return $datos;
        }catch (Exception $e){
            Conexion::getInstance()->cerrarConexion();
            return [];
        }
    }

    /**
     * @nombre :lista
     * @descripcion:consulta en bd interesado.
     */
    function Instituciones()
    {
        try {
            $Conexion = Conexion::getInstance()->obtenerConexion();
           
                $this->SQL = "SELECT        cve_institucion as id, nombre, fecha_registro, activo
                FROM            instituciones
                WHERE        (activo = 1) " ;
            
            
            $this->sta = $Conexion->prepare($this->SQL);
            
            $this->sta->execute();
            $datos = $this->sta->fetchAll(PDO::FETCH_ASSOC);
            Conexion::getInstance()->cerrarConexion();
            return $datos;
        }catch (Exception $e){
            Conexion::getInstance()->cerrarConexion();
            return [];
        }
    }
}
