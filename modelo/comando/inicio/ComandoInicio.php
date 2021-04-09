<?php

/*
 * Titulo			: ComandoInicio.php
 * Descripción                  : Documento que contiene los metodos que interactuan con la base de datos
 * Compañía			: 
 * Fecha de creación            : 02-mayo-2017
 * Desarrollador                : Oscar
 * Versión			: 1.0
 * ID Requerimiento             : 
 */

class ComandoInicio {

    function __construct() {
        
    }

    /*
     * Metodo que devuelve un arreglo asociativo con las opciones del menu
     * para un usuario especificado por su cve
     */

    public function listarOpcionesMenu($cve = 0) {
        try {
            $result = [];
            $opcionesIn = [];
            $opcionesOut = [];
            $con = Conexion::getInstance()->obtenerConexion();

            if ($con != null) {
                $stmt = $con->prepare(
                        "SELECT a.cve_menu,
                             a.cve_menu_superior,
                             a.nombre,
                             a.ruta
                        FROM menu a,
                             menu_grupo_seguridad b,
                             grupo_seguridad c,
                             usuario_grupo_seguridad d
                        WHERE a.cve_menu = b.cve_menu
                          AND b.cve_grupo_seguridad = c.cve_grupo_seguridad
                          AND c.cve_grupo_seguridad = d.cve_grupo_seguridad
                          AND a.activo = 1
                          AND c.activo = 1
                          AND d.cve_persona = :cve
                          ORDER BY a.cve_menu_superior
                          ,a.orden
                          ,a.nombre"
                );
                $stmt->bindParam(":cve", $cve);
                $stmt->execute();
//                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $value) {
                    $opcionesIn[$value["cve_menu"]] = [
                        "cve_menu" => $value["cve_menu"]
                        , "cve_menu_superior" => $value["cve_menu_superior"]
                        , "nombre" => $value["nombre"]
                        , "ruta" => empty($value["ruta"]) ? "" : $value["ruta"]
                    ];
                    $opcionesOut[] = [
                        "cve_menu" => $value["cve_menu"]
                        , "cve_menu_superior" => $value["cve_menu_superior"]
                        , "nombre" => $value["nombre"]
                        , "ruta" => empty($value["ruta"]) ? 0 : 1
                    ];
                }

                $result = [$opcionesIn, $opcionesOut];
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
        Conexion::getInstance()->cerrarConexion();

        return $result;
    }

}
