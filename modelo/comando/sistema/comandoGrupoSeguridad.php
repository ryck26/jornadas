<?php 
    class comandoGrupoSeguridad{
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

            $this->SQL = "DECLARE @nombre varchar(45) = :nombre,
                @activo int = 1
                
                INSERT INTO [dbo].[grupo_seguridad]
                       ([nombre]
                       ,[activo]
                       )
                 VALUES
                       ( @nombre
                       ,@activo )";
        
            $this->sta = $Conexion->prepare($this->SQL);
            $this->sta->bindValue(':nombre', $p->__get('nombre'), PDO::PARAM_STR);
            
            $this->sta->execute();
            $id = $Conexion->lastInsertId();
   
            return $id;
        } catch (Exception $e) {
            
            echo $e->getMessage();
            
            return 0;
        }finally{
            Conexion::getInstance()->cerrarConexion();
        }
    }

    /**
     * @nombre :Modificar
     * @descripcion:modificar en bd 
     */
    function Actualizar($p){
        try {
            $Conexion = Conexion::getInstance()->obtenerConexion();

            $this->SQL = "DECLARE @nombre varchar(45) = :nombre,
                    @cve_grupo_seguridad int = :cve_grupo_seguridad
            
            UPDATE [dbo].[grupo_seguridad]
               SET [nombre] = @nombre
             WHERE cve_grupo_seguridad =@cve_grupo_seguridad";
        
            $this->sta = $Conexion->prepare($this->SQL);
            $this->sta->bindValue(':nombre', $p->__get('nombre'), PDO::PARAM_STR);
            $this->sta->bindValue(':cve_grupo_seguridad', $p->__get('cve_grupo_seguridad'), PDO::PARAM_INT);
            
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
     * $p
     * @descripcion:ActualizarEstatus en bd 
     */
    function ActualizarEstatus($p){
        try {
            $Conexion = Conexion::getInstance()->obtenerConexion();

            $this->SQL = "DECLARE @activo int = :activo,
                    @cve_grupo_seguridad int = :cve_grupo_seguridad
            
            UPDATE [dbo].[grupo_seguridad]
               SET [activo] = @activo
             WHERE cve_grupo_seguridad =@cve_grupo_seguridad";
        
            $this->sta = $Conexion->prepare($this->SQL);
            $this->sta->bindValue(':activo', $p->__get('activo'), PDO::PARAM_INT);
            $this->sta->bindValue(':cve_grupo_seguridad', $p->__get('cve_grupo_seguridad'), PDO::PARAM_INT);
            
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
     * $p
     * @descripcion:ActualizarEstatus en bd 
     */
    function Eliminar($p){
        try {
            $Conexion = Conexion::getInstance()->obtenerConexion();

            $this->SQL = "DECLARE @cve_grupo_seguridad int = :cve_grupo_seguridad
            
           DELETE FROM grupo_seguridad
             WHERE cve_grupo_seguridad =@cve_grupo_seguridad";
        
            $this->sta = $Conexion->prepare($this->SQL);
            $this->sta->bindValue(':cve_grupo_seguridad', $p->__get('cve_grupo_seguridad'), PDO::PARAM_INT);
            
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
    function Tabla(){
        try {
            $Conexion = Conexion::getInstance()->obtenerConexion();
            
            $this->SQL = "SELECT        cve_grupo_seguridad, nombre, activo, ISNULL
            ((SELECT        COUNT(cve_persona) AS NO
                FROM            usuario_grupo_seguridad
                WHERE        (cve_grupo_seguridad = grupo_seguridad.cve_grupo_seguridad)), 0) AS no
FROM            grupo_seguridad ORDER BY nombre ";

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


    }
?>