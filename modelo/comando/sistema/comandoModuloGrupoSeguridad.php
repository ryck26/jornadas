<?php 
    class comandoModuloGrupoSeguridad{
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

            $this->SQL = "DECLARE @cve_menu int = :cve_menu,
                @cve_grupo_seguridad int = :cve_grupo_seguridad
                
                INSERT INTO [dbo].[menu_grupo_seguridad]
                       ([cve_menu]
                       ,[cve_grupo_seguridad]
                       )
                 VALUES
                       ( @cve_menu
                       ,@cve_grupo_seguridad )";
        
            $this->sta = $Conexion->prepare($this->SQL);
            $this->sta->bindValue(':cve_menu', $p->__get('cve_menu'), PDO::PARAM_INT);
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
            @cve_menu int = :cve_menu
            
           DELETE FROM menu_grupo_seguridad
             WHERE cve_grupo_seguridad = @cve_grupo_seguridad AND cve_menu = @cve_menu";
        
            $this->sta = $Conexion->prepare($this->SQL);
            $this->sta->bindValue(':cve_grupo_seguridad', $p->__get('cve_grupo_seguridad'), PDO::PARAM_INT);
            $this->sta->bindValue(':cve_menu', $p->__get('cve_menu'), PDO::PARAM_INT);
            
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
            
            $this->SQL = "SELECT         menu_grupo_seguridad.cve_menu, menu_grupo_seguridad.cve_grupo_seguridad, menu.nombre AS menu, grupo_seguridad.nombre AS perfil
            FROM            menu_grupo_seguridad INNER JOIN
                                     menu ON menu_grupo_seguridad.cve_menu = menu.cve_menu INNER JOIN
                                     grupo_seguridad ON menu_grupo_seguridad.cve_grupo_seguridad = grupo_seguridad.cve_grupo_seguridad ORDER BY menu ";

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
    function subModulos($p){
        try {
            $Conexion = Conexion::getInstance()->obtenerConexion();
            
            $this->SQL = " SELECT        cve_menu, cve_menu_superior, nombre, ruta, activo, orden
            FROM            menu
            WHERE        (activo = 1) AND (NOT EXISTS
                                         (SELECT        cve_menu
                                           FROM            menu_grupo_seguridad
                                           WHERE        (cve_grupo_seguridad = :cve_grupo_seguridad ) AND (cve_menu = menu.cve_menu))) AND (cve_menu_superior > 0)
            ORDER BY nombre  ";

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


    }
?>