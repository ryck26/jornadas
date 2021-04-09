<?php //echo (extension_loaded('openssl')?'SSL loaded':'SSL not loaded')."\n"; ?>
<?php

session_start();

require '../../modelo/encapsulacion/Encapsulacion.class.php';
require '../../modelo/conexion/Conexion.class.php';
require '../../modelo/comando/catalogos/comandoInstituciones.php';

$Obj_Encapsulacion = new Encapsulacion();
$Obj_Comando_instituciones = new comandoInstituciones();

$accion = isset($_REQUEST['accion']) && $_REQUEST['accion'] != '' ? $_REQUEST['accion'] : '0';
$cve_institucion = isset($_REQUEST['cve_institucion']) && $_REQUEST['cve_institucion'] != '' ? $_REQUEST['cve_institucion'] : '0';
$nombre = isset($_REQUEST['nombre']) && $_REQUEST['nombre'] != '' ? $_REQUEST['nombre'] : '0';
$estatus = isset($_REQUEST['estatus']) && $_REQUEST['estatus'] != '' ? $_REQUEST['estatus'] : '0';

$cve_persona_session =  $_SESSION["USUARIO"]["cve_persona"];

try {

    switch ($accion) {
        case 1:
      	    echo json_encode($Obj_Comando_instituciones->altaInstitucion($nombre));
            break;
        case 2:
            echo '{"aaData":' . json_encode($Obj_Comando_instituciones->listaInstituciones()) . '}';
            break;
        case 3:
      	    echo json_encode($Obj_Comando_instituciones->cargarInstitucion($cve_institucion));
            break;
        case 4:
      	    echo json_encode($Obj_Comando_instituciones->estatusInstitucion($cve_institucion, $estatus));
            break;
        case 5:
            echo json_encode($Obj_Comando_instituciones->actualizarInstitucion($cve_institucion, $nombre));
            break;
        case 6:
            echo json_encode($Obj_Comando_instituciones->eliminarInstitucion($cve_institucion));
            break;
        default:
            break;
    }


} catch (Exception $e) {
    echo 0;
}