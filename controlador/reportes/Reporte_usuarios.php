<?php
/*
 * Titulo			: 
 * Descripción                  : 
 * Compañía			: 
 * Fecha de creación            : 
 * Desarrollador                : 
 * Versión			: 1.0
 * ID Requerimiento             : 
 */

session_start();
require_once '../../modelo/conexion/Conexion.class.php';
require_once '../../modelo/comando/reportes/ComandoReporteUsuarios.php';

$obj = new ComandoReporteUsuarios ();

$accion = clear_input($_REQUEST["accion"] ?? "0");

$obj->curso = clear_input($_REQUEST["curso"] ?? "0");
$obj->fecha = clear_input($_REQUEST["fecha"] ?? "0");
$obj->cve_persona = clear_input($_REQUEST["cve_persona"] ?? "0");
$obj->asistencia = clear_input($_REQUEST["asistencia"] ?? "0");
$obj->arrayPersonas = $_REQUEST["arrayPersonas"] ?? "0";
// $obj->claveCarrera = clear_input($_REQUEST["claveCarrera"] ?? "0");
// $obj->clavePlantel = clear_input($_REQUEST["clavePlantel"] ?? "0");
// $obj->cAmplio2016 = clear_input($_REQUEST["cAmplio2016"] ?? "0");
// $obj->nivel = clear_input($_REQUEST["nivel"] ?? "0");
// $obj->cEspecifico2016 = clear_input($_REQUEST["cEspecifico2016"] ?? "0");
// $obj->aptitudes = $_REQUEST["aptitudes"] ?? "0";
// $obj->sectorProductivo = clear_input($_REQUEST["sectorProductivo"] ?? "0");
// $obj->RVOE = clear_input($_REQUEST["RVOE"] ?? "0");
// $obj->modalidad = clear_input($_REQUEST["modalidad"] ?? "0");

switch ($accion) {
    case 1:
        echo json_encode($obj->getCursos());
        break;
    case 2:
        echo json_encode($obj->getFechas());
        break;
    case 3:
        echo json_encode($obj->getPersonasCurso($obj->curso));
        break;
    case 4:
        echo json_encode($obj->getPersonasCursoCompleto($obj));
        break; 
    case 5:
        echo json_encode($obj->cambiarEstatusAsistencia($obj));
        break;
    case 6:
        echo json_encode($obj->guardarAsistencias($obj));
        break;
    case 7:
        echo "{\"data\":".json_encode($obj->getNivelAgrupado())."}";
        break;
    case 8:
        echo "{\"data\":".json_encode($obj->getNivel())."}";
        break;
    case 9:
        echo "{\"data\":".json_encode($obj->getCampoEspecifico2016())."}";
        break;
    case 10:
        echo "{\"data\":".json_encode($obj->getNivelEstudio())."}";
        break;        
    case 11:
        echo "{\"data\":".json_encode($obj->getPlanteles())."}";
        break;        
    case 12:
        echo "{\"data\":".json_encode($obj->getAptitudes())."}";
        break;
    case 13:
        $cveCarrera = clear_input($_REQUEST["cveCarrera"] ?? "0");
        echo "{\"data\":".json_encode($obj->getDatosEditarDos($cveCarrera))."}";
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


