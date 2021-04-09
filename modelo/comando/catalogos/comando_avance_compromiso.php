<?php
class ComandoAvanceCompromiso
{
    private $SQL;
    private $sta;

    function __construct()
    { }


    function ListaConsejos($admin, $p)
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
                $this->SQL = "SELECT  co.cve_consejo AS id, co.nombre, usuario.cve_usuario
                                FROM consejos co
                                INNER JOIN participantes_consejos pc ON pc.cve_consejo = co.cve_consejo 
                                INNER JOIN participantes pa ON pa.cve_participante = pc.cve_participante
                                INNER JOIN usuario ON pa.cve_persona = usuario.cve_persona
                                WHERE (co.activo = 1) AND (usuario.cve_usuario = :cve_usuario) ORDER BY co.nombre ASC ";
            }
				
            $this->sta = $Conexion->prepare($this->SQL);
            if (!$admin) {
                $this->sta->bindValue(':cve_usuario', $p->__get('cve_usuario_registro'), PDO::PARAM_INT);
            }
            
            $this->sta->execute();
           $datos = $this->sta->fetchAll(PDO::FETCH_ASSOC);
            
            return $datos;
        }catch (Exception $e){
            Conexion::getInstance()->cerrarConexion();
            return "[]";
        }finally{
			Conexion::getInstance()->cerrarConexion();
		}
    }


    function ListaSesiones($cve_consejo)
    {
        try {
            $Conexion = Conexion::getInstance()->obtenerConexion();
          
                $this->SQL = "select cve_sesion as id, nombre from sesiones where cve_consejo=:cve_consejo and activo=0 " ;
           
            
            $this->sta = $Conexion->prepare($this->SQL);
            $this->sta->bindValue(':cve_consejo', $cve_consejo->__get('cve_consejo'), PDO::PARAM_INT);
           
            $this->sta->execute();
            $datos = $this->sta->fetchAll(PDO::FETCH_ASSOC);
            Conexion::getInstance()->cerrarConexion();
            return $datos;
        }catch (Exception $e){
            Conexion::getInstance()->cerrarConexion();
            return "[]";
        }
    }


    function ListaTipo()
    {
        try {
            $Conexion = Conexion::getInstance()->obtenerConexion();
          
                $this->SQL = " SELECT cve_tipo as id, nombre FROM tipo WHERE ACTIVO=1" ;
           
            
            $this->sta = $Conexion->prepare($this->SQL);
            
            $this->sta->execute();
           $datos = $this->sta->fetchAll(PDO::FETCH_ASSOC);
            Conexion::getInstance()->cerrarConexion();
            return $datos;
        }catch (Exception $e){
            Conexion::getInstance()->cerrarConexion();
            return "[]";
        }
    }


   
    function TablaAcuerdos($cve_sesion)
    {
        try {
            $Conexion = Conexion::getInstance()->obtenerConexion();
          
                $this->SQL = "SELECT cve_acuerdo_compromiso, titulo, descripcion,convert(varchar(10),fecha_registro,103) as fecha, 
                cve_estatus_compromiso FROM acuerdo_compromiso WHERE cve_tipo=1 and cve_sesion=:cve_sesion " ;
           
            
            $this->sta = $Conexion->prepare($this->SQL);
            $this->sta->bindValue(':cve_sesion', $cve_sesion->__get('cve_sesion'), PDO::PARAM_INT);
           
            $this->sta->execute();
            $datos = $this->sta->fetchAll(PDO::FETCH_ASSOC);
            Conexion::getInstance()->cerrarConexion();
            return $datos;
        }catch (Exception $e){
            Conexion::getInstance()->cerrarConexion();
            return "[]";
        }
    }

    function TablaCompromisos($Obj_comando)
    {
        try {
            $Conexion = Conexion::getInstance()->obtenerConexion();
          
                $this->SQL = "SELECT ac.cve_acuerdo_compromiso, c.nombre,ac.titulo,ac.descripcion,convert(varchar(10),ac.fecha_cumplimiento,103) as fechaCumplimiento ,
			ac.porcentaje_avance as porcentajeAvance,
                convert(varchar(10),ac.fecha_registro,103) as fechaRegistro, ac.cve_estatus_compromiso 
				from acuerdo_compromiso as ac
				inner join sesiones as s on ac.cve_sesion=s.cve_sesion
				inner join consejos as c on c.cve_consejo=s.cve_consejo
				where ac.cve_tipo=2 and ac.cve_sesion=:cve_sesion " ;
           
            
            $this->sta = $Conexion->prepare($this->SQL);
            $this->sta->bindValue(':cve_sesion', $Obj_comando->__get('cve_sesion'), PDO::PARAM_INT);
            
            $this->sta->execute();
            $datos = $this->sta->fetchAll(PDO::FETCH_ASSOC);
            Conexion::getInstance()->cerrarConexion();
            return $datos;
        }catch (Exception $e){
            Conexion::getInstance()->cerrarConexion();
            return "[]";
        }
    }




    function GuardarNotas($Obj_comando)
    {
        try {
            $Conexion = Conexion::getInstance()->obtenerConexion();
            $this->SQL = "INSERT INTO detalle_compromiso(cve_acuerdo_compromiso,cve_participante_compromiso, nota, porcentaje_avance, fecha_registro, estatus) 
                            values(:cve_acuerdo_compromiso,ISNULL(( SELECT        TOP (1) cve_participante
FROM            participantes
WHERE        (cve_persona = :cve_usuario_registro)),'0') , :nota, :avance * 10, GETDATE(), 1)";
            $this->sta = $Conexion->prepare($this->SQL);
            $this->sta->bindValue(':cve_acuerdo_compromiso', $Obj_comando->__get('cve_acuerdo_compromiso'), PDO::PARAM_INT);
			$this->sta->bindValue(':cve_usuario_registro', $Obj_comando->__get('cve_usuario_registro'), PDO::PARAM_INT);
           $this->sta->bindValue(':nota', $Obj_comando->__get('nota'), PDO::PARAM_STR);
            $this->sta->bindValue(':avance', $Obj_comando->__get('avance'), PDO::PARAM_INT);
          
            $this->sta->execute();
            $id = $Conexion->lastInsertId();       
            Conexion::getInstance()->cerrarConexion();
			//var_dump($datos);
            return $id;
        }catch (Exception $e){
            Conexion::getInstance()->cerrarConexion();
            return $e->getMessage();
        }
    }




    
    function TablaNotas($Obj_comando)
    {
        try {
            $Conexion = Conexion::getInstance()->obtenerConexion();
          
              /* $this->SQL = "SELECT cve_detalle_compromiso, cve_acuerdo_compromiso,nota,porcentaje_avance,
                convert(varchar(10),fecha_registro, 103) as fechaRegistro, estatus, '' as ruta
                FROM detalle_compromiso WHERE cve_acuerdo_compromiso = :cve_acuerdo_compromiso and estatus = 1
                order by porcentaje_avance asc " ;
                */
                
             /*  $this->SQL = "SELECT cve_detalle_compromiso, cve_acuerdo_compromiso,nota,porcentaje_avance,
                convert(varchar(10),detalle_compromiso.fecha_registro, 103) as fechaRegistro, estatus, di.ruta
                FROM detalle_compromiso
                inner join documento_imp_proceso as dip on dip.cve_proceso=detalle_compromiso.cve_detalle_compromiso
				inner join documentos_importados as di on di.cve_documento_importado=dip.cve_documento_importado
                 WHERE cve_acuerdo_compromiso = :cve_acuerdo_compromiso and estatus = 1 and di.activo=1
                order by porcentaje_avance asc " ;
                */
                
               $this->SQL = "SELECT cve_detalle_compromiso, cve_acuerdo_compromiso,nota,porcentaje_avance,
               convert(varchar(10),detalle_compromiso.fecha_registro, 103) as fechaRegistro, estatus, isnull((SELECT top 1 di.ruta FROM  documento_imp_proceso as dip 
               inner join documentos_importados as di on di.cve_documento_importado=dip.cve_documento_importado  
			   where dip.cve_proceso = cve_detalle_compromiso and dip.cve_tipo_proceso = 4 and di.activo=1), '') as ruta
               FROM detalle_compromiso
              
                WHERE cve_acuerdo_compromiso = :cve_acuerdo_compromiso and estatus = 1 ";
                


           
               // echo $this->SQL;
     
            
            $this->sta = $Conexion->prepare($this->SQL);
            $this->sta->bindValue(':cve_acuerdo_compromiso', $Obj_comando->__get('cve_acuerdo_compromiso'), PDO::PARAM_INT);
            
           
            $this->sta->execute();
            $datos = $this->sta->fetchAll(PDO::FETCH_ASSOC);
            Conexion::getInstance()->cerrarConexion();
            return $datos;
        }catch (Exception $e){
            Conexion::getInstance()->cerrarConexion();
            return "[]";
        }
    }



    function Desactivar($Obj_comando)
    {
        // var_dump($p);
        try {
            $Conexion = Conexion::getInstance()->obtenerConexion();

            $this->SQL = " UPDATE detalle_compromiso SET estatus=0 , 
            fecha_registro=GETDATE() 
            WHERE cve_detalle_compromiso = :cve_detalle_compromiso 
            and cve_acuerdo_compromiso = :cve_acuerdo_compromiso";
        
            $this->sta = $Conexion->prepare($this->SQL);
            $this->sta->bindValue(':cve_acuerdo_compromiso', $Obj_comando->__get('cve_acuerdo_compromiso'), PDO::PARAM_INT);
            $this->sta->bindValue(':cve_detalle_compromiso', $Obj_comando->__get('cve_detalle_compromiso'), PDO::PARAM_INT);
            
            return $this->sta->execute();
           
        } catch (Exception $e) {
            
            error_log($e->getMessage());
            echo $e->getMessage();
            $Conexion->rollBack();
            return false;
        }
        Conexion::getInstance()->cerrarConexion();
    }


    function ActualizarArchivo($Obj_comando)
    {
        // var_dump($p);
        try {
            $Conexion = Conexion::getInstance()->obtenerConexion();

            $this->SQL = "
            update documentos_importados set activo=0 where cve_documento_importado in
            (select cve_documento_importado from documento_imp_proceso where cve_proceso=:cve_detalle_compromiso AND cve_tipo_proceso =4 ) ";
        
            $this->sta = $Conexion->prepare($this->SQL);
            $this->sta->bindValue(':cve_detalle_compromiso', $Obj_comando->__get('cve_detalle_compromiso'), PDO::PARAM_INT);
            
            return $this->sta->execute();
           
        } catch (Exception $e) {
            
            error_log($e->getMessage());
            echo $e->getMessage();
            $Conexion->rollBack();
            return false;
        }
        Conexion::getInstance()->cerrarConexion();
    }
    
    function PorcentajeActual($Obj_comando)
    {
        try {
            $Conexion = Conexion::getInstance()->obtenerConexion();
          
                $this->SQL = "SELECT top(1) (porcentaje_avance/10) as porcentaje  from detalle_compromiso 
                                where cve_acuerdo_compromiso = :cve_acuerdo_compromiso and estatus = 1 
                                order by porcentaje_avance desc " ;
           
            
            $this->sta = $Conexion->prepare($this->SQL);
            $this->sta->bindValue(':cve_acuerdo_compromiso', $Obj_comando->__get('cve_acuerdo_compromiso'), PDO::PARAM_INT);
           
            $this->sta->execute();
            $datos = $this->sta->fetchAll(PDO::FETCH_ASSOC);
            Conexion::getInstance()->cerrarConexion();
            return $datos;
        }catch (Exception $e){
            Conexion::getInstance()->cerrarConexion();
            return "[]";
        }
    }




    function ActualizarNota($Obj_comando)
    {
        // var_dump($p);
        try {
            $Conexion = Conexion::getInstance()->obtenerConexion();

            $this->SQL = " UPDATE detalle_compromiso SET nota = :nota ,
            porcentaje_avance = :avance * 10,
            fecha_registro=GETDATE() 
            WHERE cve_detalle_compromiso = :cve_detalle_compromiso ";
        
            $this->sta = $Conexion->prepare($this->SQL);
            $this->sta->bindValue(':cve_detalle_compromiso', $Obj_comando->__get('cve_detalle_compromiso'), PDO::PARAM_INT);
           $this->sta->bindValue(':nota', $Obj_comando->__get('nota'), PDO::PARAM_STR);
            $this->sta->bindValue(':avance', $Obj_comando->__get('avance'), PDO::PARAM_INT);
          
            return $this->sta->execute();
           
        } catch (Exception $e) {
            
            error_log($e->getMessage());
            echo $e->getMessage();
            $Conexion->rollBack();
            return false;
        }
        Conexion::getInstance()->cerrarConexion();
    }


    
    function Terminar($Obj_comando)
    {
        // var_dump($p);
        try {
            $Conexion = Conexion::getInstance()->obtenerConexion();

            $this->SQL = "  update acuerdo_compromiso  set cve_estatus_compromiso=3 where cve_tipo=2 and 
            cve_acuerdo_compromiso=:cve_acuerdo_compromiso";
        
            $this->sta = $Conexion->prepare($this->SQL);
            $this->sta->bindValue(':cve_acuerdo_compromiso', $Obj_comando->__get('cve_acuerdo_compromiso'), PDO::PARAM_INT);
          
          
            return $this->sta->execute();
           
        } catch (Exception $e) {
            
            error_log($e->getMessage());
            echo $e->getMessage();
            $Conexion->rollBack();
            return false;
        }
        Conexion::getInstance()->cerrarConexion();
    }
	
	function ActualizarAvanceCompromiso($Obj_comando)
    {
        // var_dump($p);
        try {
            $Conexion = Conexion::getInstance()->obtenerConexion();

            $this->SQL = "  update acuerdo_compromiso  set porcentaje_avance = :avance , cve_estatus_compromiso = 2  where cve_tipo=2 and 
            cve_acuerdo_compromiso=:cve_acuerdo_compromiso";
        
            $this->sta = $Conexion->prepare($this->SQL);
			$this->sta->bindValue(':avance', $Obj_comando->__get('avance')*10, PDO::PARAM_INT);
          
            $this->sta->bindValue(':cve_acuerdo_compromiso', $Obj_comando->__get('cve_acuerdo_compromiso'), PDO::PARAM_INT);
          
          
            return $this->sta->execute();
           
        } catch (Exception $e) {
            
            error_log($e->getMessage());
            echo $e->getMessage();
            $Conexion->rollBack();
            return false;
        }
        Conexion::getInstance()->cerrarConexion();
    }
	
	function AvanceDesactivar($Obj_comando)
    {
        // var_dump($p);
        try {
            $Conexion = Conexion::getInstance()->obtenerConexion();

            $this->SQL = "  update acuerdo_compromiso  set porcentaje_avance = ISNULL(( SELECT        TOP (1) porcentaje_avance
FROM            detalle_compromiso
WHERE        (estatus = 1) AND (cve_acuerdo_compromiso = :cve_acuerdo_compromiso)
ORDER BY fecha_registro DESC ),0) , cve_estatus_compromiso = 2  where cve_tipo=2 and 
            cve_acuerdo_compromiso = :cve_acuerdo_compromiso2 ";
        
            $this->sta = $Conexion->prepare($this->SQL);
			
          
            $this->sta->bindValue(':cve_acuerdo_compromiso', $Obj_comando->__get('cve_acuerdo_compromiso'), PDO::PARAM_INT);
			$this->sta->bindValue(':cve_acuerdo_compromiso2', $Obj_comando->__get('cve_acuerdo_compromiso'), PDO::PARAM_INT);
          
          
            return $this->sta->execute();
           
        } catch (Exception $e) {
            
            error_log($e->getMessage());
            echo $e->getMessage();
            $Conexion->rollBack();
            return false;
        }
        Conexion::getInstance()->cerrarConexion();
    }
    
}
