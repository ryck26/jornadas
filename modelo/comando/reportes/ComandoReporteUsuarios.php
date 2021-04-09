<?php

/*
 * Titulo			: 
 * Descripción                  : 
 * Compañía			: 
 * Fecha de creación            : 05-mayo-2017
 * Desarrollador                : 
 * Versión			: 1.0
 * ID Requerimiento             : 
 */

class ComandoReporteUsuarios {

    function __construct() {
        
    }

    public function getCursos() {
        try {
            $datos = null;

            $con = Conexion::getInstance()->obtenerConexion();
            if ($con != null) {
                $stmt = $con->prepare("SELECT cve_curso, nombre FROM curso"); 
                if($stmt->execute())
                {
                    $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    Conexion::getInstance()->cerrarConexion();
        
                    return $datos;            
                }
            }
        } catch (Exception $e) {
            // error_log( "Error: " . $e->getMessage());
            Conexion::getInstance()->cerrarConexion();
            return $e;
        }
        Conexion::getInstance()->cerrarConexion();
    }

    public function getFechas() {
        try {
            $datos = null;

            $con = Conexion::getInstance()->obtenerConexion();
            if ($con != null) {
                $stmt = $con->prepare("SELECT cve_fecha_curso, fecha FROM fecha_curso"); 
                if($stmt->execute())
                {
                    $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    Conexion::getInstance()->cerrarConexion();
        
                    return $datos;            
                }
            }
        } catch (Exception $e) {
            // error_log( "Error: " . $e->getMessage());
            Conexion::getInstance()->cerrarConexion();
            return $e;
        }
        Conexion::getInstance()->cerrarConexion();
    }

    public function getPersonasCurso($p) {
        try {
            $datos = null;
            $con = Conexion::getInstance()->obtenerConexion();
            if($con != null)
            {
                $stmt = $con->prepare("SELECT persona.cve_persona, CONCAT(persona.nombre, ' ', persona.paterno, ' ', persona.materno) AS nombre, 
                    persona.curp, persona.institucion AS cargo, persona.cargo AS institucion, persona.correo, persona.correo_alternativo, persona.telefono, 
                    persona.celular FROM persona INNER JOIN suscripcion_curso ON persona.cve_persona = suscripcion_curso.cve_persona
                    WHERE (suscripcion_curso.cve_curso = ?)");
                $stmt->bindValue(1, $p, PDO::PARAM_INT);
                if($stmt->execute())
                {
                    $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    Conexion::getInstance()->cerrarConexion();
                    return $datos;
                }
            }
        } catch (Exception $e) {
            Conexion::getInstance()->cerrarConexion();
            return $e;
        }
    }

    public function getPersonasCursoCompleto($p) {
        try {
            $datos = null;
            $con = Conexion::getInstance()->obtenerConexion();
            if($con != null)
            {
                $stmt = $con->prepare("SELECT (CASE WHEN asistencia_curso.cve_asistencia IS NOT NULL THEN CAST(1 AS BIT)
                WHEN asistencia_curso.cve_asistencia IS NULL THEN CAST(0 AS BIT) END) AS asistencia, persona.cve_persona, CONCAT(persona.nombre, ' ', persona.paterno, ' ', persona.materno) AS nombre, 
                persona.curp, persona.institucion AS cargo, persona.cargo AS institucion, persona.correo, persona.correo_alternativo, persona.telefono, 
                persona.celular, 
                (CASE WHEN asistencia_curso.cve_asistencia IS NOT NULL THEN CAST(1 AS BIT)
                WHEN asistencia_curso.cve_asistencia IS NULL THEN CAST(0 AS BIT) END) AS asistencia_original  
                FROM persona INNER JOIN suscripcion_curso ON persona.cve_persona = suscripcion_curso.cve_persona
                LEFT JOIN asistencia_curso ON asistencia_curso.cve_persona = persona.cve_persona 
                AND asistencia_curso.cve_curso = ? AND asistencia_curso.cve_fecha_curso = ?
                WHERE (suscripcion_curso.cve_curso = ?)");
                //El campo asistencia_original se necesita por que el campo asistencia es alterado por el datatable, lo que sobreescribiria el estatus
                //original de la asistencia que tenia la persona
                $stmt->bindValue(1, $p->curso, PDO::PARAM_INT);
                $stmt->bindValue(2, $p->fecha, PDO::PARAM_INT);
                $stmt->bindValue(3, $p->curso, PDO::PARAM_INT);
                if($stmt->execute())
                {
                    $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    Conexion::getInstance()->cerrarConexion();
                    return $datos;
                }
            }
        } catch (Exception $e) {
            // error_log( "Error: " . $e->getMessage());
            Conexion::getInstance()->cerrarConexion();
            return $e;
        }
    }

    public function cambiarEstatusAsistencia($p) {
        try {
            $datos = null;
            $con = Conexion::getInstance()->obtenerConexion();
            if($con != null)
            {
                if($p->asistencia=="false")//Quitar asistencia
                    $stmt = $con->prepare("DELETE FROM asistencia_curso WHERE cve_curso = ? AND cve_fecha_curso = ? AND cve_persona = ?");
                else
                    $stmt = $con->prepare("INSERT INTO asistencia_curso(cve_curso, cve_fecha_curso, cve_persona, cve_persona_registro) VALUES (?, ?, ?, 1)");

                $stmt->bindValue(1, $p->curso, PDO::PARAM_INT);
                $stmt->bindValue(2, $p->fecha, PDO::PARAM_INT);
                $stmt->bindValue(3, $p->cve_persona, PDO::PARAM_INT);
                if($stmt->execute())
                {
                    Conexion::getInstance()->cerrarConexion();
                    return true;
                }
                else
                {
                    Conexion::getInstance()->cerrarConexion();
                    return false;
                }
            }
        } catch (Exception $e) {
            // error_log( "Error: " . $e->getMessage());
            Conexion::getInstance()->cerrarConexion();
            return $e;
        }
    }

    public function guardarAsistencias($p) {
        try {
            $arrayPersonas = json_decode($p->arrayPersonas);
            $hayAsistencias = false;
            $numeroAsistencias = 0;
            $asistenciasRegistradas = 0;

            foreach ($arrayPersonas as $key) {
                if($key->asistencia)
                    $numeroAsistencias++;
            }

            $con = Conexion::getInstance()->obtenerConexion();
            if($con != null)
            {
                $con->beginTransaction();
                // sqlsrv_begin_transaction($con);
                
                $stmt = $con->prepare("DELETE FROM asistencia_curso WHERE cve_curso = ? AND cve_fecha_curso = ?");
                $stmt->bindValue(1, $p->curso, PDO::PARAM_INT);
                $stmt->bindValue(2, $p->fecha, PDO::PARAM_INT);
                $stmt->execute();
                $sql = "INSERT INTO asistencia_curso(cve_curso, cve_fecha_curso, cve_persona, cve_persona_registro) VALUES ";
                for ($i=0; $i < sizeof($arrayPersonas); $i++) { 
                    if($arrayPersonas[$i]->asistencia)
                    {
                        $asistenciasRegistradas++;
                        $sql .= "($p->curso, $p->fecha, ".$arrayPersonas[$i]->cve_persona.", ". $_SESSION["USUARIO"]["cve_persona"] .")";
                        //Si no es el ultimo elemento con asistencia, se agrega una coma al final de la query
                        if($asistenciasRegistradas != $numeroAsistencias)
                            $sql .= ", ";
                    }
                    
                }
                if($numeroAsistencias > 0)
                {
                    $stmt = $con->prepare($sql);
                    $stmt->execute();
                }
                if($con->commit())
                {
                    Conexion::getInstance()->cerrarConexion();
                    return true;
                }
                else
                {
                    Conexion::getInstance()->cerrarConexion();
                    return false;
                }
            }
        } catch (Exception $e) {
            // error_log( "Error: " . $e->getMessage());
            return $e;
        }
    }
    // public function getDatosEditarDos($p) {
    //     try {
    //         $datos = null;
    //         $con = Conexion::getInstance()->obtenerConexion();
    //         if($con != null)
    //         {
    //             $stmt = $con->prepare("SELECT * FROM detalle_aptitud_carrera WHERE idCarreraES = ? ORDER BY cve_aptitud ASC;");
    //             $stmt->bindValue(1, $p, PDO::PARAM_INT);
    //             if($stmt->execute())
    //             {
    //                 $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    //                 Conexion::getInstance()->cerrarConexion();
    //                 return $datos;
    //             }
    //         }
    //     } catch (Exception $e) {
    //         // error_log( "Error: " . $e->getMessage());
    //         return $e;
    //     }
    // }




//     SELECT (CASE WHEN asistencia_curso.cve_asistencia <> NULL THEN 1 
// WHEN asistencia_curso.cve_asistencia = NULL THEN 0 END) AS asistencia,
// CONCAT(persona.nombre, ' ', persona.paterno, ' ', persona.materno) AS nombre, 
// persona.curp, persona.institucion, persona.cargo, persona.correo, persona.correo_alternativo, persona.telefono, 
// persona.celular FROM persona 
// INNER JOIN suscripcion_curso ON persona.cve_persona = suscripcion_curso.cve_persona
// LEFT JOIN asistencia_curso ON asistencia_curso.cve_persona = persona.cve_persona 
// AND asistencia_curso.cve_curso = 2 AND asistencia_curso.cve_fecha_curso = 1
// WHERE (suscripcion_curso.cve_curso = 2)
}
