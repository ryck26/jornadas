<?php 
    class comandoUsuarioGrupoSeguridad{
        private $SQL;
        private $sta;

        function __construct(){}

         /**
     * @nombre :insertar
     * @descripcion:inserta en bd 
     */
    function insertar($p){
        try {
            $Conexion = Conexion::getInstance()->obtenerConexion();

            $this->SQL = "DECLARE @cve_persona int = :cve_persona,
                @cve_grupo_seguridad int = :cve_grupo_seguridad
                
                INSERT INTO [dbo].[usuario_grupo_seguridad]
                       ([cve_persona]
                       ,[cve_grupo_seguridad]
                       )
                 VALUES
                       ( @cve_persona
                       ,@cve_grupo_seguridad )";
        
            $this->sta = $Conexion->prepare($this->SQL);
            $this->sta->bindValue(':cve_persona', $p->__get('cve_persona'), PDO::PARAM_INT);
            $this->sta->bindValue(':cve_grupo_seguridad', $p->__get('cve_grupo_seguridad'), PDO::PARAM_INT);
            
            
            return   $this->sta->execute();
             
        } catch (Exception $e) {
            
            echo $e->getMessage();
            
            return 0;
        }finally{
            Conexion::getInstance()->cerrarConexion();
        }
    }

   

    /**
     * $p
     * @descripcion:ActualizarEstatus en bd 
     */
    function Eliminar($p){
        try {
            $Conexion = Conexion::getInstance()->obtenerConexion();

            $this->SQL = "DECLARE @cve_grupo_seguridad int = :cve_grupo_seguridad,
            @cve_persona int = :cve_persona
            
           DELETE FROM usuario_grupo_seguridad
             WHERE cve_grupo_seguridad = @cve_grupo_seguridad AND cve_persona = @cve_persona";
        
            $this->sta = $Conexion->prepare($this->SQL);
            $this->sta->bindValue(':cve_grupo_seguridad', $p->__get('cve_grupo_seguridad'), PDO::PARAM_INT);
            $this->sta->bindValue(':cve_persona', $p->__get('cve_persona'), PDO::PARAM_INT);
            
            return $this->sta->execute();
           
        } catch (Exception $e) {
            
            error_log($e->getMessage());
            echo $e->getMessage();
            $Conexion->rollBack();
            return false;
        }finally{
            Conexion::getInstance()->cerrarConexion();
        }
        
    }


     /**
     * @nombre :lista
     * @descripcion:consulta en bd interesado.
     */
    function Tabla($p){
        try {
            $Conexion = Conexion::getInstance()->obtenerConexion();
            
                $this->SQL = " SELECT        usuario_grupo_seguridad.cve_persona, usuario_grupo_seguridad.cve_grupo_seguridad, grupo_seguridad.nombre AS perfil, persona.nombre, persona.paterno, persona.materno, persona.activo AS act_persona, 
                grupo_seguridad.activo AS act_grupo
            FROM            usuario_grupo_seguridad INNER JOIN
                grupo_seguridad ON usuario_grupo_seguridad.cve_grupo_seguridad = grupo_seguridad.cve_grupo_seguridad INNER JOIN
                persona ON usuario_grupo_seguridad.cve_persona = persona.cve_persona
            WHERE        (persona.activo = 1) AND (usuario_grupo_seguridad.cve_grupo_seguridad = :cve_grupo_seguridad )
            ORDER BY persona.nombre ";

            $this->sta = $Conexion->prepare($this->SQL);
            $this->sta->bindValue(':cve_grupo_seguridad', $p->__get('cve_grupo_seguridad'), PDO::PARAM_INT);

            $this->sta->execute();
            $datos = $this->sta->fetchAll(PDO::FETCH_ASSOC);
            
            return $datos;
        }catch (Exception $e){
            
            return [];
        }finally{
            Conexion::getInstance()->cerrarConexion();
        }
    }


    /**
     * @nombre :lista
     * @descripcion:consulta en bd interesado.
     */
    function grupoSeguridad(){
        try {
            $Conexion = Conexion::getInstance()->obtenerConexion();
            
            $this->SQL = "SELECT        cve_grupo_seguridad, nombre, activo
            FROM            grupo_seguridad
            ORDER BY nombre ";

            $this->sta = $Conexion->prepare($this->SQL);
           
            $this->sta->execute();
            $datos = $this->sta->fetchAll(PDO::FETCH_ASSOC);
            
            return $datos;
        }catch (Exception $e){
            
            return [];
        }finally{
            Conexion::getInstance()->cerrarConexion();
        }
    }

       /**
     * @nombre :lista
     * @descripcion:consulta en bd interesado.
     */
    function usuarios($p){
        try {
            $Conexion = Conexion::getInstance()->obtenerConexion();
            
            $this->SQL = " SELECT        usuario.usuario + ' - ' + persona.nombre + ' ' + persona.paterno + ' ' + persona.materno AS nombre, persona.activo AS act_persona, persona.cve_persona, usuario.usuario, usuario.activo AS act_usuario, ISNULL
                ((SELECT        TOP (1) 1 AS Expr1
                    FROM            usuario_grupo_seguridad
                    WHERE        (cve_grupo_seguridad = :cve_grupo_seguridad ) AND (cve_persona = usuario.cve_persona)), 0) AS existe
            FROM            persona INNER JOIN
                    usuario ON persona.cve_persona = usuario.cve_persona
            WHERE        (persona.activo = 1) AND (usuario.activo = 1)
            ORDER BY nombre";

            $this->sta = $Conexion->prepare($this->SQL);
            $this->sta->bindValue(':cve_grupo_seguridad', $p->__get('cve_grupo_seguridad'), PDO::PARAM_INT);

            $this->sta->execute();
            $datos = $this->sta->fetchAll(PDO::FETCH_ASSOC);
            
            return $datos;
        }catch (Exception $e){
            
            return [];
        }finally{
            Conexion::getInstance()->cerrarConexion();
        }
    }


    }
?>