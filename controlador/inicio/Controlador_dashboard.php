<?php //echo (extension_loaded('openssl')?'SSL loaded':'SSL not loaded')."\n"; ?>
<?php

session_start();

require '../../modelo/encapsulacion/Encapsulacion.class.php';
require '../../modelo/conexion/Conexion.class.php';
require '../../modelo/comando/inicio/comandoDashboard.php';

$Obj_Encapsulacion = new Encapsulacion();
$Obj_Comando_dashboard = new comandoDashboard();

$accion = isset($_REQUEST['accion']) && $_REQUEST['accion'] != '' ? $_REQUEST['accion'] : '0';
$cve_persona_session =  $_SESSION["USUARIO"]["cve_persona"];

try {

    switch ($accion) {
        case 1:
      	    echo json_encode($Obj_Comando_dashboard->listaSesiones($cve_persona_session));
        break;
        case 2:
      	    echo json_encode($Obj_Comando_dashboard->listaCompromisos($cve_persona_session));
        break;
        default:

        break;
    }


} catch (Exception $e) {
    echo 0;
}