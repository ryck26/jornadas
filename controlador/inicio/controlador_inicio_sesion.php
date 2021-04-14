<?php
/*
 * Titulo			: controlador_inicio_sesion.php
 * Descripción                  : Controlador de la interfaz grafica de inicio de sesion
 * Compañía			: 
 * Fecha de creación            : 05-mayo-2017
 * Desarrollador                : Oscar
 * Versión			: 1.0
 * ID Requerimiento             : 
 */
session_start();
require_once '../../modelo/conexion/Conexion_utl.class.php';
require_once '../../modelo/comando/inicio/ComandoInicioSesion.php';

$obj = new ComandoInicioSesion();

$accion = clear_input(isset($_REQUEST["accion"]) && $_REQUEST["accion"] != "" ? $_REQUEST["accion"] : "0");
$folio = clear_input(isset($_REQUEST["yFolio"]) && $_REQUEST["yFolio"] != "" ? $_REQUEST["yFolio"] : "");
$curp = clear_input(isset($_REQUEST["yCurp"]) && $_REQUEST["yCurp"] != "" ? $_REQUEST["yCurp"] : "");
$datos = clear_input(isset($_REQUEST["datos"]) && $_REQUEST["datos"] != "" ?  $_REQUEST["datos"] : "");

switch ($accion) {
    case 1: // Opcion para validar los datos de inicio de sesion
       // $resp = $obj->autenticar($folio, $curp);
       $resp= json_decode(html_entity_decode( stripslashes ($datos)), true);

        if (empty($resp)) {
            echo json_encode([]);
        } else {
            $_SESSION["USUARIO"] = $resp;
            echo json_encode($resp);
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


