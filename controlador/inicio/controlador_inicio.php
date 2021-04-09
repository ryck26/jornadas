<?php

/*
 * Titulo			: controlador_inicio.php
 * Descripción                  : Controlador de la interfaz grafica de inicio
 * Compañía			: 
 * Fecha de creación            : 02-mayo-2017
 * Desarrollador                : Oscar
 * Versión			: 1.0
 * ID Requerimiento             : 
 */
session_start();
require_once '../../modelo/conexion/Conexion.class.php';
require_once '../../modelo/comando/inicio/ComandoInicio.php';

$obj = new ComandoInicio();

$accion = clear_input(isset($_REQUEST['accion']) && $_REQUEST['accion'] != '' ? $_REQUEST['accion'] : '0');
$cve_menu = clear_input(isset($_REQUEST['cve']) && $_REQUEST['cve'] != '' ? $_REQUEST['cve'] : '0');
$opcionesMenu;

switch ($accion) {
    case 1: // Opcion para listar las opciones del menu para el usuario
//        echo json_encode($obj->listarOpcionesMenu($_SESSION["USUARIO"]["cve_persona"]/* cve de la persona */));

        $opcionesMenu = $obj->listarOpcionesMenu($_SESSION["USUARIO"]["cve_persona"]/* cve de la persona */);
        $_SESSION["OPCIONES-MENU"] = $opcionesMenu[0];
        echo json_encode($opcionesMenu[1]);

        break;
    case 2: // Opcion para cerrar sesion
        session_unset();
        session_destroy();
        break;
    case 3: // Opcion para devolver la pagina a mostrar
        if ($cve_menu) {
            if (isset($_SESSION["OPCIONES-MENU"][$cve_menu])) {
                $_SESSION["MENU-ACTUAL"] = $cve_menu;
//                echo json_encode(file_get_contents("../../" . $_SESSION["OPCIONES-MENU"][$cve_menu]["ruta"]));
				$mostrarPagina = true; include ("../../" . $_SESSION["OPCIONES-MENU"][$cve_menu]["ruta"]);
            } else {
//                echo json_encode("");
				echo "";
            }
        } else {
//            echo json_encode("");
			echo "";
        }
        break;
    default:
        echo json_encode(0);
        break;
}

// Funcion para limpiar cualquier caracter extraño, espacios en blanco
function clear_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
