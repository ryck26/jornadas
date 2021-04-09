<?php //echo (extension_loaded('openssl')?'SSL loaded':'SSL not loaded')."\n"; ?>
<?php

session_start();

require '../../modelo/encapsulacion/Encapsulacion.class.php';
require '../../modelo/conexion/Conexion.class.php';
require '../../modelo/comando/catalogos/comandoConsejo.php';

$Obj_Encapsulacion = new Encapsulacion();
$Obj_Comando_consejo = new comandoConsejo();

$accion = isset($_REQUEST['accion']) && $_REQUEST['accion'] != '' ? $_REQUEST['accion'] : '0';
$nombre = isset($_REQUEST['nombre']) && $_REQUEST['nombre'] != '' ? $_REQUEST['nombre'] : '0';
$cve_responsable = isset($_REQUEST['cve_responsable']) && $_REQUEST['cve_responsable'] != '' ? $_REQUEST['cve_responsable'] : '0';

$cve_persona_session =  $_SESSION["USUARIO"]["cve_persona"];

try {

    switch ($accion) {
        case 1:
      	    echo json_encode($Obj_Comando_consejo->listaResponsables());
        break;
        case 2:
            echo json_encode($Obj_Comando_consejo->altaConsejo($nombre, $cve_responsable, $cve_persona_session));
        break;
        case 3:
            echo '{"aaData":' . json_encode($Obj_Comando_consejo->listaResponsablesConsejo()) . '}';
        break;
        default:

        break;
    }


} catch (Exception $e) {
    echo 0;
}