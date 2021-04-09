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
require_once '../../modelo/conexion/Conexion.class.php';
require_once '../../modelo/comando/inicio/ComandoInicioSesion.php';

$obj = new ComandoInicioSesion();

$accion = clear_input(isset($_REQUEST["accion"]) && $_REQUEST["accion"] != "" ? $_REQUEST["accion"] : "0");
$usuario = clear_input(isset($_REQUEST["xTxtUsuario"]) && $_REQUEST["xTxtUsuario"] != "" ? $_REQUEST["xTxtUsuario"] : "");
$contrasena = clear_input(isset($_REQUEST["xTxtContrasena"]) && $_REQUEST["xTxtContrasena"] != "" ? $_REQUEST["xTxtContrasena"] : "");

switch ($accion) {
    case 1: // Opcion para validar los datos de inicio de sesion
        $resp = $obj->autenticar($usuario, $contrasena);
        if (empty($resp)) {
            echo json_encode([]);
        } else {
            $_SESSION["USUARIO"] = $resp[0];
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


