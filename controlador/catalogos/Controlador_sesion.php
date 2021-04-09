<?php //echo (extension_loaded('openssl')?'SSL loaded':'SSL not loaded')."\n"; ?>
<?php

session_start();

require '../../modelo/encapsulacion/Encapsulacion.class.php';
require '../../modelo/conexion/Conexion.class.php';
require '../../modelo/comando/catalogos/comandoSesion.php';
require '../utilidades/email.php';

$Obj_Encapsulacion = new Encapsulacion();
$Obj_Comando_sesion = new comandoSesion();
$Obj_correo = new email();

$accion = isset($_REQUEST['accion']) && $_REQUEST['accion'] != '' ? $_REQUEST['accion'] : '0';
$cve_consejo = isset($_REQUEST['cve_consejo']) && $_REQUEST['cve_consejo'] != '' ? $_REQUEST['cve_consejo'] : '0';
$cve_sesion = isset($_REQUEST['cve_sesion']) && $_REQUEST['cve_sesion'] != '' ? $_REQUEST['cve_sesion'] : '0';
$nombreSesion = isset($_REQUEST['nombreSesion']) && $_REQUEST['nombreSesion'] != '' ? $_REQUEST['nombreSesion'] : '0';
$nombreConsejo = isset($_REQUEST['nombreConsejo']) && $_REQUEST['nombreConsejo'] != '' ? $_REQUEST['nombreConsejo'] : '0';
$fechaSesion = isset($_REQUEST['fechaSesion']) && $_REQUEST['fechaSesion'] != '' ? $_REQUEST['fechaSesion'] : '0';
$objetivo = isset($_REQUEST['objetivo']) && $_REQUEST['objetivo'] != '' ? $_REQUEST['objetivo'] : '0';
$fechaRegistro = isset($_REQUEST['fechaRegistro']) && $_REQUEST['fechaRegistro'] != '' ? $_REQUEST['fechaRegistro'] : '0';

$cve_persona_session =  $_SESSION["USUARIO"]["cve_persona"];

try {

    switch ($accion) {
        case 1:
            echo json_encode($Obj_Comando_sesion->listaConsejos($cve_persona_session));
        break;
        case 2:
            echo json_encode($Obj_Comando_sesion->altaSesion($cve_consejo, $nombreSesion, $fechaSesion, $objetivo, $fechaRegistro, $cve_persona_session));
        break;
        case 3:
            echo '{"aaData":' . json_encode($Obj_Comando_sesion->listaSesiones($cve_persona_session)) . '}';
        break;
        case 4:
            echo json_encode($Obj_Comando_sesion->cargarDatosSesion($cve_consejo, $cve_sesion));
        break;
        case 5:
            echo json_encode($Obj_Comando_sesion->actualizarSesion($cve_consejo, $cve_sesion, $nombreSesion, $fechaRegistro, $objetivo));
        break;
        case 6:
            echo json_encode($Obj_Comando_sesion->eliminarSesion($cve_consejo, $cve_sesion));
        break;
        case 7:
            //json_encode()
        break;
        case 8:
            $data = json_encode($Obj_Comando_sesion->participantesConsejo($cve_consejo));
            $arrayCorreos = json_decode($data, true);
            // echo count($arrayCorreos);

            // $correos = '';
            // $i = 0;
            // $size = (count($arrayCorreos))-1;
            // while($i <= $size)
            // {
            //     if($i != $size)
            //         $correos .= $arrayCorreos[$i]['correo'] . ',';
            //     else {
            //         $correos .= $arrayCorreos[$i]['correo'];
            //     }
            //     $i++;
            // }
           //echo $correos;
				//var_dump($data);
            if($Obj_correo->enviarCorreo($arrayCorreos, "Nueva sesion del consejo '$nombreConsejo'", "Se registro la sesion '" . $nombreSesion . "', que sera llevada a cabo el $fechaSesion"))
                echo 1;
            else
                echo -1;
        break;
        case 9:
            echo json_encode($Obj_Comando_sesion->listaDocumentos($cve_sesion));
        break;
        default:

        break;
    }


} catch (Exception $e) {
    echo 0;
}