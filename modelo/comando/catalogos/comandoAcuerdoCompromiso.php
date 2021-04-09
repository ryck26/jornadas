<?php
use PHPMailer\PHPMailer\Exception;

class comandoAcuerdoCompromiso
{
    private $SQL;
    private $sta;

    function __construct()
    { }


    function insertarAcuerdo($p){
        try{
            $Conexion = Conexion::getInstance()->obtenerConexion();
            if($p->__get('cve_tipo') == 1){

                $this->SQL = "INSERT INTO [dbo].[acuerdo_compromiso]
                                ([cve_sesion]
                                ,[cve_tipo]
                                ,[titulo]
                                ,[descripcion])
                          VALUES
                                (:cve_sesion,
                                :cve_tipo,
                                :titulo,
                                :descripcion)";
            }else{
                $this->SQL = "INSERT INTO [dbo].[acuerdo_compromiso]
                        ([cve_sesion]
                        ,[cve_tipo]
                        ,[titulo]
                        ,[descripcion]
                        ,fecha_cumplimiento)
                  VALUES
                        (:cve_sesion,
                        :cve_tipo,
                        :titulo,
                        :descripcion,
                        :fecha_cumplimiento)";
            }




            $this->sta = $Conexion->prepare($this->SQL);
            $this->sta->bindValue(':cve_sesion', $p->__get('cve_sesion'), PDO::PARAM_INT);
            $this->sta->bindValue(':cve_tipo', $p->__get('cve_tipo'), PDO::PARAM_INT);
            $this->sta->bindValue(':titulo', $p->__get('titulo'), PDO::PARAM_STR);
            $this->sta->bindValue(':descripcion', $p->__get('descripcion'), PDO::PARAM_STR);

            if($p->__get('cve_tipo') == 2){
                $this->sta->bindValue(':fecha_cumplimiento', $p->__get('fecha'), PDO::PARAM_STR);
            }

            if($this->sta->execute())
                return $Conexion ->lastInsertId();
            else
                return 0;

        }catch(Exception $e){
            error_log($e->getMessage());
            echo $e->getMessage();
            $Conexion->rollBack();
            return 0;
        }finally{
            Conexion::getInstance()->cerrarConexion();
        }
    }

    function modificarAcuerdo($p){
        try{
            $Conexion = Conexion::getInstance()->obtenerConexion();

            if($p->__get('cve_tipo') == 1){

                $this->SQL = "UPDATE [dbo].[acuerdo_compromiso] SET
                                
                                [titulo] =  :titulo,
                                [descripcion] =  :descripcion 
                                WHERE cve_acuerdo_compromiso = :cve_acuerdo_compromiso ";
            }else{
                $this->SQL = "UPDATE [dbo].[acuerdo_compromiso] SET
                               
                                [titulo] =  :titulo,
                                [descripcion] =  :descripcion, 
                                 fecha_cumplimiento = :fecha_cumplimiento
                                WHERE cve_acuerdo_compromiso = :cve_acuerdo_compromiso ";

            }


            $this->sta = $Conexion->prepare($this->SQL);

            $this->sta->bindValue(':titulo', $p->__get('titulo'), PDO::PARAM_STR);
            $this->sta->bindValue(':descripcion', $p->__get('descripcion'), PDO::PARAM_STR);

            if($p->__get('cve_tipo') == 2){

                $this->sta->bindValue(':fecha_cumplimiento', $p->__get('fecha'), PDO::PARAM_STR);
            }
            $this->sta->bindValue(':cve_acuerdo_compromiso', $p->__get('CveAcuerdoCompromiso'), PDO::PARAM_INT);

            return$this->sta->execute();


        }catch(Exception $e){
            error_log($e->getMessage());
            echo $e->getMessage();
            return 0;
        }finally{
            Conexion::getInstance()->cerrarConexion();
        }
    }

    function insertar_participantes_compromisos($p){
        try{
            $Conexion = Conexion::getInstance()->obtenerConexion();
            $resultado = false;
			$this->SQL = "if(( ISNULL( (SELECT   1  FROM participantes_compromisos A2 
							WHERE A2.cve_acuerdo_compromiso = :cve_acuerdo_compromiso2 AND A2.cve_participante = :cve_participante2 ) , 0 ) )= 0 ) 
							begin 
								INSERT INTO participantes_compromisos ( cve_acuerdo_compromiso, 		cve_participante, fecha_registro, activo)
								SELECT :cve_acuerdo_compromiso, :cve_participante, getdate(), 1
							end 
							ELSE
							BEGIN
							RAISERROR (
								   N'Ya existe el participante para este compromiso', -- Mensaje de ejemplo
								   16, -- Severity,  
								   1   -- State
						);
							END";
			
            

            $this->sta = $Conexion->prepare($this->SQL);

            $this->sta->bindValue(':cve_acuerdo_compromiso', $p->__get('CveAcuerdoCompromiso'), PDO::PARAM_INT);
            $this->sta->bindValue(':cve_participante', $p->__get('cve_participante'), PDO::PARAM_INT);
            $this->sta->bindValue(':cve_acuerdo_compromiso2', $p->__get('CveAcuerdoCompromiso'), PDO::PARAM_INT);
            $this->sta->bindValue(':cve_participante2', $p->__get('cve_participante'), PDO::PARAM_INT);

            $resultado=  $this->sta->execute();



            if($p->__get('cve_suplente') > 0){

                $this->SQL = "if(( ISNULL( (SELECT   1  FROM participantes_compromisos A2 
							WHERE A2.cve_acuerdo_compromiso = :cve_acuerdo_compromiso2 AND A2.cve_participante = :cve_participante2 ) , 0 ) )= 0 ) 
							begin 
								INSERT INTO participantes_compromisos ( cve_acuerdo_compromiso, 		cve_participante, fecha_registro, activo)
								SELECT :cve_acuerdo_compromiso, :cve_participante, getdate(), 1
							end 
							ELSE
							BEGIN
							RAISERROR (
								   N'Ya existe el participante para este compromiso', -- Mensaje de ejemplo
								   16, -- Severity,  
								   1   -- State
						);
							END";
				
				
			/*	" INSERT participantes_compromisos ( cve_acuerdo_compromiso, cve_participante, fecha_registro, activo)
                    SELECT top(1) :cve_acuerdo_compromiso, :cve_participante, getdate(), 1
                    FROM participantes_compromisos
                    WHERE NOT EXISTS (SELECT 1 FROM participantes_compromisos A2 
                    WHERE A2.cve_acuerdo_compromiso = :cve_acuerdo_compromiso2 AND A2.cve_participante = :cve_participante2 ); "; */

                $this->sta = $Conexion->prepare($this->SQL);

                $this->sta->bindValue(':cve_acuerdo_compromiso', $p->__get('CveAcuerdoCompromiso'), PDO::PARAM_INT);
                $this->sta->bindValue(':cve_participante', $p->__get('cve_suplente'), PDO::PARAM_INT);
                $this->sta->bindValue(':cve_acuerdo_compromiso2', $p->__get('CveAcuerdoCompromiso'), PDO::PARAM_INT);
                $this->sta->bindValue(':cve_participante2', $p->__get('cve_suplente'), PDO::PARAM_INT);

                $resultado= $this->sta->execute();
            }

                return $resultado;

        }catch(Exception $e){
            error_log($e->getMessage());
            echo $e->getMessage();

            return 0;
        }finally{
            Conexion::getInstance()->cerrarConexion();
        }
    }


    /**
     * @nombre :lista
     * @descripcion:consulta en bd interesado.
     */
    function Tipos()
    {
        try {
            $Conexion = Conexion::getInstance()->obtenerConexion();

            $this->SQL = "Select cve_tipo as id,nombre FROM tipo WHERE activo =1 ORDER BY nombre ASC";

            $this->sta = $Conexion->prepare($this->SQL);
            // $this->sta->bindValue(':cve_tipo_participante', $p->__get('cve_tipo_participante'), PDO::PARAM_INT);
            $this->sta->execute();
            $datos = $this->sta->fetchAll(PDO::FETCH_ASSOC);

            return $datos;
        } catch (Exception $e) {
            Conexion::getInstance()->cerrarConexion();
            return [];
        }finally{
            Conexion::getInstance()->cerrarConexion();
        }
    }


    /**
     * @nombre :Tabla
     * @descripcion:consulta en bd Responsables.
     */
    function Responsables($p)
    {
        try {
            $Conexion = Conexion::getInstance()->obtenerConexion();

            $this->SQL = " SELECT        persona.paterno, persona.materno, persona.nombre, instituciones.nombre AS institucion, participantes_consejos.cve_participante_suplente AS cve_suplente, sesiones.cve_sesion, participantes_consejos.cve_participante, 
                         participantes_consejos.cve_tipo_participante, participantes_compromisos.cve_participante_compromiso, participantes_compromisos.activo,participantes_compromisos.cve_acuerdo_compromiso, ISNULL((SELECT        TOP (1) 0 AS Expr1
                    FROM            detalle_compromiso INNER JOIN
                         participantes_compromisos ON detalle_compromiso.cve_participante_compromiso = participantes_compromisos.cve_participante_compromiso
                            WHERE        (detalle_compromiso.cve_acuerdo_compromiso = :cve_acuerdo_compromiso) 
                            AND (detalle_compromiso.estatus = 1) 
                            AND ((participantes_compromisos.cve_participante = participantes_consejos.cve_participante) 
                            OR  (participantes_compromisos.cve_participante = participantes_consejos.cve_participante_suplente))),1) AS eliminar
                            FROM            sesiones INNER JOIN
                         participantes_consejos ON sesiones.cve_consejo = participantes_consejos.cve_consejo INNER JOIN
                         participantes ON participantes_consejos.cve_participante = participantes.cve_participante INNER JOIN
                         persona ON participantes.cve_persona = persona.cve_persona INNER JOIN
                         instituciones ON participantes.cve_institucion = instituciones.cve_institucion LEFT OUTER JOIN
                         participantes_compromisos ON participantes.cve_participante = participantes_compromisos.cve_participante AND participantes_compromisos.activo = 1 AND  participantes_compromisos.cve_acuerdo_compromiso = :cve_acuerdo_compromiso2
                WHERE        (sesiones.cve_consejo = :cve_consejo) 
                AND (sesiones.cve_sesion = :cve_sesion) 
                AND (participantes_consejos.cve_tipo_participante = :cve_tipo) ";

//            $this->SQL = " SELECT        persona.paterno, persona.materno, persona.nombre, instituciones.nombre AS institucion, participantes_consejos.cve_participante_suplente AS cve_suplente, sesiones.cve_sesion, participantes_consejos.cve_participante,
//                         participantes_consejos.cve_tipo_participante
//                        FROM            sesiones INNER JOIN
//                         participantes_consejos ON sesiones.cve_consejo = participantes_consejos.cve_consejo INNER JOIN
//                         participantes ON participantes_consejos.cve_participante = participantes.cve_participante INNER JOIN
//                         persona ON participantes.cve_persona = persona.cve_persona INNER JOIN
//                         instituciones ON participantes.cve_institucion = instituciones.cve_institucion
//                    WHERE        (sesiones.cve_consejo = :cve_consejo) AND (sesiones.cve_sesion = :cve_sesion) AND (participantes_consejos.cve_tipo_participante = :cve_tipo)";
            // var_dump($p,$this->SQL);
            $this->sta = $Conexion->prepare($this->SQL);
            $this->sta->bindValue(':cve_acuerdo_compromiso', $p->__get('CveAcuerdoCompromiso'), PDO::PARAM_INT);
            $this->sta->bindValue(':cve_acuerdo_compromiso2', $p->__get('CveAcuerdoCompromiso'), PDO::PARAM_INT);
            $this->sta->bindValue(':cve_consejo', $p->__get('cve_consejo'), PDO::PARAM_INT);
            $this->sta->bindValue(':cve_sesion', $p->__get('cve_sesion'), PDO::PARAM_INT);
            $this->sta->bindValue(':cve_tipo', $p->__get('cve_tipo'), PDO::PARAM_INT);

            $this->sta->execute();
            $datos = $this->sta->fetchAll(PDO::FETCH_ASSOC);

            return $datos;
        } catch (Exception $e) {
            error_log($e->getMessage());
            Conexion::getInstance()->cerrarConexion();
            return [];
        }finally{
            Conexion::getInstance()->cerrarConexion();
        }
    }

    function EliminarRespCompromiso($p,$cve){
        try{
            $Conexion = Conexion::getInstance()->obtenerConexion();
            $this->SQL = "DELETE FROM participantes_compromisos
                            WHERE cve_acuerdo_compromiso = :cve_acuerdo_compromiso AND cve_participante in (".$cve.")  ";
            $this->sta = $Conexion->prepare($this->SQL);
            $this->sta->bindValue(':cve_acuerdo_compromiso', $p->__get('CveAcuerdoCompromiso'), PDO::PARAM_INT);


            return $this->sta->execute();
        }catch(Exception $e){
            error_log($e->getMessage());
            echo $e->getMessage();
            $Conexion->rollBack();
            return 0;
        }finally{
            Conexion::getInstance()->cerrarConexion();
        }
    }

}


