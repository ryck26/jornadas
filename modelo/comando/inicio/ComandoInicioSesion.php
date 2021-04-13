<?php

/*
 * Titulo			: ComandoInicioSesion.php
 * Descripción                  : Documento que contiene los metodos que interactuan con la base de datos
 * Compañía			: 
 * Fecha de creación            : 05-mayo-2017
 * Desarrollador                : Oscar
 * Versión			: 1.0
 * ID Requerimiento             : 
 */

class ComandoInicioSesion {

    function __construct() {
        
    }

    /*
     * Metodo que verifica los datos ingresados para iniciar sesion,
     * si existe devuelve los datos en un arreglo asosiativo, si no devuelve
     * un arreglo vacio
     */
    public function autenticar($folio = "", $curp = "") {
		
        try {
            $result = [];
			
            $con = Conexion::getInstance()->obtenerConexion();
			
            if ($con != null) {
                // $stmt = $con->prepare(
                //         "SELECT persona.cve_persona,
                //             persona.nombre,
                //             persona.paterno,
                //             persona.materno,
                //             usuario.usuario
                //         FROM persona,
                //              usuario
                //         WHERE persona.cve_persona = usuario.cve_persona
                //         AND usuario.activo = 1
                //         AND usuario.usuario = :usuario
                //         AND usuario.contrasena = :contrasena "
                // );

                $stmt = $con->prepare(
                    "DECLARE @folio varchar(10) = :usuario,
                    @curp varchar(20) = :contrasena
                    SELECT        TOP (1) interesado.cve_interesado, interesado.cve_solicitud_admision, interesado.nombre, interesado.apellido_paterno, interesado.apellido_materno, interesado.curp, interesado.sexo, interesado.mail, 
                                 solicitud_admision.cve_unidad_academica, solicitud_admision.cve_carrera1, solicitud_admision.cve_especialidad1, especialidad_carrera.titulo_carrera, unidad_academica.cve_nivel_estudio, 
                                 unidad_academica.nombre AS unidad, interesado.movil, bachillerato.nombre AS bachillerato, ficha_admision.cve_aspirante, ISNULL((SELECT        descripcion_turno
                    FROM            turno_admision
                    WHERE        (activo = 1) AND (cve_turno_admision = interesado.medio_registro)),'-') AS turno, 0 AS estatus
                        FROM            interesado INNER JOIN
                                 solicitud_admision ON interesado.cve_solicitud_admision = solicitud_admision.cve_solicitud_admision INNER JOIN
                                 especialidad_carrera ON solicitud_admision.cve_carrera1 = especialidad_carrera.cve_carrera AND solicitud_admision.cve_especialidad1 = especialidad_carrera.cve_especialidad INNER JOIN
                                 unidad_academica ON solicitud_admision.cve_unidad_academica = unidad_academica.cve_unidad_academica INNER JOIN
                                 datos_escolares ON interesado.cve_interesado = datos_escolares.cve_interesado INNER JOIN
                                 bachillerato ON datos_escolares.cve_bachillerato = bachillerato.cve_bachillerato
                                inner JOIN ficha_admision ON ficha_admision.cve_solicitud_admision = interesado.cve_solicitud_admision                                   
                            WHERE        (interesado.fecha_registro >= CONVERT(DATETIME, '2021-01-01 00:00:00', 102)) AND (interesado.cve_solicitud_admision = @folio ) AND (interesado.curp = @curp ) 
         " ); 
                $stmt->bindParam(":usuario", $folio);
                $stmt->bindParam(":contrasena", $curp);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (Exception $e) {
           echo ( "Error: " . $e->getMessage());
        }
        Conexion::getInstance()->cerrarConexion();

        return $result;
    }

}
