<?php //echo (extension_loaded('openssl')?'SSL loaded':'SSL not loaded')."\n"; ?>
<?php

session_start();

require '../../modelo/encapsulacion/Encapsulacion.class.php';
require '../../modelo/conexion/Conexion.class.php';
require '../../modelo/comando/procesos/comandoSubirArchivo.php';

$Obj_Encapsulacion = new Encapsulacion();
$Obj_Comando_subir_archivo = new comandoSubirArchivo();

$accion = isset($_REQUEST['accion']) && $_REQUEST['accion'] != '' ? $_REQUEST['accion'] : '0';
$nombre = isset($_REQUEST['nombre']) && $_REQUEST['nombre'] != '' ? $_REQUEST['nombre'] : '0';
$ruta = isset($_REQUEST['ruta']) && $_REQUEST['ruta'] != '' ? $_REQUEST['ruta'] : '0';
$cve_proceso = isset($_REQUEST['cve_proceso']) && $_REQUEST['cve_proceso'] != '' ? $_REQUEST['cve_proceso'] : '0';
$tipo_proceso = isset($_REQUEST['tipo_proceso']) && $_REQUEST['tipo_proceso'] != '' ? $_REQUEST['tipo_proceso'] : '0';
$cve_participante = isset($_REQUEST['cve_participante']) && $_REQUEST['cve_participante'] != '' ? $_REQUEST['cve_participante'] : '0';

try {

    switch ($accion) {
        case 1:
      	    echo json_encode($Obj_Comando_subir_archivo->subirArchivo($nombre, $ruta, $cve_proceso, $tipo_proceso, $cve_participante));
        break;
    }


} catch (Exception $e) {
    echo 0;
}