<?php //echo (extension_loaded('openssl')?'SSL loaded':'SSL not loaded')."\n"; ?>
<?php

session_start();

require '../../modelo/encapsulacion/Encapsulacion.class.php';
require '../../modelo/conexion/Conexion.class.php';
require '../../modelo/comando/catalogos/comandoDetalleConsejo.php';

$Obj_Encapsulacion = new Encapsulacion();
$Obj_Comando_detalle_consejo = new comandoDetalleConsejo();

$accion = isset($_REQUEST['accion']) && $_REQUEST['accion'] != '' ? $_REQUEST['accion'] : '0';
$cve_consejo = isset($_REQUEST['cve_consejo']) && $_REQUEST['cve_consejo'] != '' ? $_REQUEST['cve_consejo'] : '0';
$cve_participante = isset($_REQUEST['cve_participante']) && $_REQUEST['cve_participante'] != '' ? $_REQUEST['cve_participante'] : '0';
$descripcion = isset($_REQUEST['descripcion']) && $_REQUEST['descripcion'] != '' ? $_REQUEST['descripcion'] : '0';
$objetivos = isset($_REQUEST['objetivos']) && $_REQUEST['objetivos'] != '' ? $_REQUEST['objetivos'] : '0';
$alcance = isset($_REQUEST['alcance']) && $_REQUEST['alcance'] != '' ? $_REQUEST['alcance'] : '0';
$tipo_proceso = isset($_REQUEST['tipo_proceso']) && $_REQUEST['tipo_proceso'] != '' ? $_REQUEST['tipo_proceso'] : '0';
$cve_tipo_participante = isset($_REQUEST['cve_tipo_participante']) && $_REQUEST['cve_tipo_participante'] != '' ? $_REQUEST['cve_tipo_participante'] : '0';
$cve_participante_suplantado = isset($_REQUEST['cve_participante_suplantado']) && $_REQUEST['cve_participante_suplantado'] != '' ? $_REQUEST['cve_participante_suplantado'] : '0';

$cve_persona_session =  $_SESSION["USUARIO"]["cve_persona"];

try {

    switch ($accion) {
        case 1:
      	    echo json_encode($Obj_Comando_detalle_consejo->listaConsejos($cve_persona_session));
        break;
        case 2:
      	    echo json_encode($Obj_Comando_detalle_consejo->guardarDetalle($cve_consejo, $descripcion, $objetivos, $alcance));
        break;
        case 3:
      	    echo json_encode($Obj_Comando_detalle_consejo->consultarDatosConsejo($cve_consejo));
        break;
        case 4:
      	    echo '{"aaData":' . json_encode($Obj_Comando_detalle_consejo->listaParticipantes($cve_consejo)) . '}';
        break;
        case 5:
            echo json_encode($Obj_Comando_detalle_consejo->agregarParticipante($cve_consejo, $cve_participante, $cve_persona_session, $cve_tipo_participante, $cve_participante_suplantado));
        break;
        case 6:
            echo '{"aaData":' . json_encode($Obj_Comando_detalle_consejo->listaParticipantesConsejo($cve_consejo)) . '}';
        break;
        case 7:
            echo '{"aaData":' . json_encode($Obj_Comando_detalle_consejo->listaDocumentos($cve_consejo, $tipo_proceso)) . '}';
        break;
        case 8:
      	    echo json_encode($Obj_Comando_detalle_consejo->listaParticipantesSinSuplentes($cve_consejo));
        break;
        case 9:
            echo '{"aaData":' . json_encode($Obj_Comando_detalle_consejo->listaSuplentes($cve_consejo)) . '}';
        break;
        case 10:
            if($cve_tipo_participante == 3){
				$Obj_Comando_detalle_consejo->removerSuplente( $cve_participante, $cve_tipo_participante );
			}
            echo json_encode($Obj_Comando_detalle_consejo->removerParticipante($cve_participante));
			
        break;

        default:

        break;
    }


} catch (Exception $e) {
    echo 0;
}