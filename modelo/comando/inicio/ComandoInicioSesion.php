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
    public function autenticar($usuario = "", $contrasena = "") {
		
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

                
                // $stmt = $con->prepare("SELECT * FROM usuario");
                $stmt = $con->prepare(
                    "SELECT persona.cve_persona, persona.nombre, persona.paterno, persona.materno, 
                    usuario.usuario, usuario.cve_usuario FROM persona INNER JOIN usuario ON persona.cve_persona = usuario.cve_persona
                    WHERE (usuario.activo = 1) AND (usuario.usuario = :usuario) AND (usuario.contraseña = :contrasena ) " ); 
                $stmt->bindParam(":usuario", $usuario);
                $stmt->bindParam(":contrasena", $contrasena);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (Exception $e) {
            error_log( "Error: " . $e->getMessage());
            return $e->getMessage();
        }
        Conexion::getInstance()->cerrarConexion();

        return $result;
    }

}
