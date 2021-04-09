<?php
session_start();

require '../../modelo/encapsulacion/Encapsulacion.class.php';
require '../../modelo/conexion/Conexion.class.php';
require '../../modelo/comando/catalogos/comandoAcuerdoCompromiso.php';

$Obj_Encapsulacion = new Encapsulacion();
$obj_comando = new comandoAcuerdoCompromiso();

$accion = $_REQUEST['yAccion'] ?? 0;

$CveAcuerdoCompromiso = $_POST['CveAcuerdoCompromiso'] ?? 0;
$cve_consejo = $_POST['CveConsejo'] ?? 0;
$cve_sesion = $_POST['CveSesion'] ?? 0;
$cve_tipo = $_POST['CveTipo'] ?? 0;
$titulo = $_POST['Titulo'] ?? '-';
$descripcion = $_POST['Descripcion'] ?? '-';
$fecha = $_POST['Fecha'] ?? '1990-01-01';
$cve_participante = $_POST['CveParticipante'] ?? 0;
$cve_suplente = $_POST['CveSuplente'] ?? 0;

if($cve_suplente != ""){
	$cve_suplente = 0;
}


try{
   // $Obj_Encapsulacion->__set('cve_consejo', );
   $Obj_Encapsulacion->__set('CveAcuerdoCompromiso', $CveAcuerdoCompromiso);
    $Obj_Encapsulacion->__set('cve_consejo', $cve_consejo);
    $Obj_Encapsulacion->__set('cve_sesion', $cve_sesion);
    $Obj_Encapsulacion->__set('cve_tipo', $cve_tipo);
    $Obj_Encapsulacion->__set('titulo', $titulo);
    $Obj_Encapsulacion->__set('descripcion', $descripcion);
    $Obj_Encapsulacion->__set('fecha', $fecha);
    $Obj_Encapsulacion->__set('cve_participante', $cve_participante);
    $Obj_Encapsulacion->__set('cve_suplente', $cve_suplente);

    switch($accion){
        case 1:
            echo $obj_comando->insertarAcuerdo($Obj_Encapsulacion);
            exit();
        break;
        case 2:
            echo $obj_comando->insertar_participantes_compromisos($Obj_Encapsulacion);
            exit();
        break;
        case 3://Tipos
            echo  json_encode($obj_comando->Tipos());
            exit();
        break;
        case 4://
            echo json_encode($obj_comando->Responsables($Obj_Encapsulacion));
            exit();
            
        break;
        case 5:
		
            if($cve_suplente > 0){
                $cve = $cve_participante.','.$cve_suplente;
            }else{
                $cve = $cve_participante;
            }

            //var_dump($Obj_Encapsulacion, $cve);
            echo $obj_comando->EliminarRespCompromiso($Obj_Encapsulacion, $cve);
            break;
        case 6:

            echo $obj_comando->modificarAcuerdo($Obj_Encapsulacion);
            break;
    }

}catch(Exception $e){
    echo $e->getMessage();
}