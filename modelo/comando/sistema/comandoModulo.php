<?php
class comando_modulo{
    private $SQL;
    private $sta;

    function __construct(){ }

    /**
     * @nombre :insertar
     * @descripcion:inserta en bd 
     */
    function insertarModulo($p){
        try {
            $Conexion = Conexion::getInstance()->obtenerConexion();

            $this->SQL = "DECLARE @cve_menu_superior INT = 0,
                @nombre varchar(100) = :nombre,
                @ruta varchar(1000) = '-',
                @activo int = 1,
                @orden int = 0
                
                INSERT INTO [dbo].[menu]
                       ([cve_menu_superior]
                       ,[nombre]
                       ,[ruta]
                       ,[activo]
                       ,[orden])
                 VALUES
                       ( @cve_menu_superior
                       ,@nombre
                       ,@ruta
                       ,@activo
                       ,@orden )";
        
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
     * @nombre :insertar
     * @descripcion:inserta en bd 
     */
    function insertarSubModulo($p){
        try {
            $Conexion = Conexion::getInstance()->obtenerConexion();

            $this->SQL = "DECLARE @cve_menu_superior INT = :cve_menu_superior,
                @nombre varchar(100) = :nombre,
                @ruta varchar(1000) = :ruta,
                @activo int = 1,
                @orden int = 0
                
                INSERT INTO [dbo].[menu]
                       ([cve_menu_superior]
                       ,[nombre]
                       ,[ruta]
                       ,[activo]
                       ,[orden])
                 VALUES
                       ( @cve_menu_superior
                       ,@nombre
                       ,@ruta
                       ,@activo
                       ,@orden )";
        
            $this->sta = $Conexion->prepare($this->SQL);
            $this->sta->bindValue(':cve_menu_superior', $p->__get('cve_menu_superior'), PDO::PARAM_INT);
            $this->sta->bindValue(':nombre', $p->__get('nombre'), PDO::PARAM_STR);
            $this->sta->bindValue(':ruta', $p->__get('ruta'), PDO::PARAM_STR);
            
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
    function ActualizarModulo($p){
        try {
            $Conexion = Conexion::getInstance()->obtenerConexion();

            $this->SQL = "DECLARE @nombre varchar(100) = :nombre,
                    @cve_menu int = :cve_menu
            
            UPDATE [dbo].[menu]
               SET [nombre] = @nombre
             WHERE cve_menu =@cve_menu";
        
            $this->sta = $Conexion->prepare($this->SQL);
            $this->sta->bindValue(':nombre', $p->__get('nombre'), PDO::PARAM_STR);
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
     * @nombre :Modificar
     * @descripcion:modificar en bd 
     */
    function ActualizarSub($p){
        try {
            $Conexion = Conexion::getInstance()->obtenerConexion();

            $this->SQL = "DECLARE @nombre varchar(45) = :nombre,
           
            @ruta varchar(1000) = :ruta,
                    @cve_menu int = :cve_menu
            
            UPDATE [dbo].[menu]
               SET [nombre] = @nombre,
               ruta = @ruta
             WHERE cve_menu = @cve_menu";
        
            $this->sta = $Conexion->prepare($this->SQL);
            $this->sta->bindValue(':nombre', $p->__get('nombre'), PDO::PARAM_STR);
            $this->sta->bindValue(':ruta', $p->__get('ruta'), PDO::PARAM_STR);
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
     * $p
     * @descripcion:ActualizarEstatus en bd 
     */
    function ActualizarEstatus($p){
        try {
            $Conexion = Conexion::getInstance()->obtenerConexion();

            $this->SQL = "DECLARE @activo int = :activo,
                    @cve_menu int = :cve_menu
            
            UPDATE [dbo].[menu]
               SET [activo] = @activo
             WHERE cve_menu =@cve_menu";
        
            $this->sta = $Conexion->prepare($this->SQL);
            $this->sta->bindValue(':activo', $p->__get('activo'), PDO::PARAM_INT);
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
     * $p
     * @descripcion:ActualizarEstatus en bd 
     */
    function EliminarMod($p){
        try {
            $Conexion = Conexion::getInstance()->obtenerConexion();

            $this->SQL = "DECLARE @cve_menu int = :cve_menu
            
           DELETE FROM menu
             WHERE cve_menu =@cve_menu";
        
            $this->sta = $Conexion->prepare($this->SQL);
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
    function ListaMenu(){
        try {
            $Conexion = Conexion::getInstance()->obtenerConexion();
            
            $this->SQL = "SELECT        cve_menu, cve_menu_superior, nombre, ruta, activo, orden, ISNULL
            ((SELECT        COUNT(cve_menu) AS Expr1
                FROM            menu
                WHERE        (cve_menu_superior = menu_1.cve_menu)), 0) AS sub
                FROM            menu AS menu_1
                WHERE        (cve_menu_superior = 0) ORDER BY nombre ";

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
     * @nombre :ListaSubMenu
     * @descripcion:consulta en bd menu.
     */
    function ListaSubMenu($p){
        try {
            $Conexion = Conexion::getInstance()->obtenerConexion();
            
            $this->SQL = "SELECT        cve_menu, cve_menu_superior, nombre, ruta, activo, orden
                FROM            menu 
                WHERE        (cve_menu_superior > 0) AND  (cve_menu_superior = :cve_menu_superior)
                ORDER BY nombre ";

            $this->sta = $Conexion->prepare($this->SQL);
            $this->sta->bindValue(':cve_menu_superior', $p->__get('cve_menu_superior'), PDO::PARAM_INT);
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