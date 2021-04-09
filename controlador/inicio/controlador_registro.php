<?php
/*
 * Titulo			: controlador_registro.php
 * Descripción                  : 
 * Compañía			: 
 * Fecha de creación            : 01-Julio-2020
 * Desarrollador                : Juan Pablo Mendoza
 * Versión			: 1.0
 * ID Requerimiento             : 
 */
session_start();
require_once '../../modelo/conexion/Conexion.class.php';
require_once '../../modelo/comando/inicio/Registro.php';
require '../utilidades/email.php';

$obj_correo = new email();
$obj = new Registro();

$accion = clear_input(isset($_REQUEST["accion"]) && $_REQUEST["accion"] != "" ? $_REQUEST["accion"] : "0");
$nombre = clear_input(isset($_REQUEST["nombre"]) && $_REQUEST["nombre"] != "" ? $_REQUEST["nombre"] : "");
$paterno = clear_input(isset($_REQUEST["paterno"]) && $_REQUEST["paterno"] != "" ? $_REQUEST["paterno"] : "");
$materno = clear_input(isset($_REQUEST["materno"]) && $_REQUEST["materno"] != "" ? $_REQUEST["materno"] : "");
$curp = clear_input(isset($_REQUEST["curp"]) && $_REQUEST["curp"] != "" ? $_REQUEST["curp"] : "");
$cargo = clear_input(isset($_REQUEST["cargo"]) && $_REQUEST["cargo"] != "" ? $_REQUEST["cargo"] : "");
//$institucion = clear_input(isset($_REQUEST["institucion"]) && $_REQUEST["institucion"] != "" ? $_REQUEST["institucion"] : "");
$correo = clear_input(isset($_REQUEST["correo"]) && $_REQUEST["correo"] != "" ? $_REQUEST["correo"] : "");
$correoA = clear_input(isset($_REQUEST["correoA"]) && $_REQUEST["correoA"] != "" ? $_REQUEST["correoA"] : "");
$telefono = clear_input(isset($_REQUEST["telefono"]) && $_REQUEST["telefono"] != "" ? $_REQUEST["telefono"] : "");
$celular = clear_input(isset($_REQUEST["celular"]) && $_REQUEST["celular"] != "" ? $_REQUEST["celular"] : "");

$matricula = clear_input(isset($_REQUEST["matricula"]) && $_REQUEST["matricula"] != "" ? $_REQUEST["matricula"] : "-");
$grupo = clear_input(isset($_REQUEST["grupo"]) && $_REQUEST["grupo"] != "" ? $_REQUEST["grupo"] : "-");
$carrera = clear_input(isset($_REQUEST["carrera"]) && $_REQUEST["carrera"] != "" ? $_REQUEST["carrera"] : "-");

$institucion = clear_input(isset($_REQUEST["institucion"]) && $_REQUEST["institucion"] != "" ? $_REQUEST["institucion"] : "-");

$organizacion = clear_input(isset($_REQUEST["organizacion"]) && $_REQUEST["organizacion"] != "" ? $_REQUEST["organizacion"] : "-");
$puesto = clear_input(isset($_REQUEST["puesto"]) && $_REQUEST["puesto"] != "" ? $_REQUEST["puesto"] : "");

$tipo_interesado = clear_input(isset($_REQUEST["tipo_interesado"]) && $_REQUEST["tipo_interesado"] != "" ? $_REQUEST["tipo_interesado"] : "");


switch ($accion) {
	case 1:
		if($obj->existeRegistro($correo) == 1)
		{
		$resp = $obj->guardarRegistro($nombre, $paterno, $materno, $correo, $telefono, $celular, $matricula, $grupo, $carrera, $institucion, $organizacion, $puesto, $tipo_interesado);
		if (empty($resp)) {
            echo json_encode([]);
        } else {
				$Array_correo["correo"] = $correo;
				$correos_json = array();
				array_push($correos_json, $Array_correo);
				
				$asunto ="";
                $cuerpo_correo = "";
				
				$asunto ="Bienvenido a ASQ";
				$cuerpo_correo ='<h3>Estimado&nbsp; <b>'.$nombre.' '. $paterno.' ' .$materno. '</b></h3>
				<p>Su registro ha sido satisfactorio con la siguiente información:</p>
				<p>Correo electronico:&nbsp; <b>'.$correo.'</b></p>
				<p>Telefono:&nbsp; <b>'.$telefono.'</b></p>
				<p>Numero celular:&nbsp; <b>'.$celular.'</b></p>
				';
				
				if($obj_correo->enviarCorreo($correos_json, $asunto, $cuerpo_correo)){
						
							echo 1;
						
                }else{
                    echo -1;
                }
        }
		}
		else{
			echo 0;
		}
	break;
    case 3: // Opcion para validar los datos de inicio de sesion
		if($obj->existeRegistro($correo) == 1)
		{
        $resp = $obj->guardarRegistro($nombre, $paterno, $materno, $curp, $cargo, $institucion, $correo, $correoA, $telefono, $celular);
        if (empty($resp)) {
            echo json_encode([]);
        } else {
				$Array_correo["correo"] = $correo;
				$correos_json = array();
				array_push($correos_json, $Array_correo);
				
				$asunto ="";
                $cuerpo_correo = "";
				
				$asunto ="Bienvenido al Curso de Formación Dual";
				$cuerpo_correo ='<h3>Estimado&nbsp; <b>'.$nombre.' '. $paterno.' ' .$materno. '</b></h3>
				<p>Su registro ha sido satisfactorio con la siguiente información:</p>
				<p>CURP:&nbsp; <b>'.$curp.'</b> </p>
				<p>Institución:&nbsp; <b>'.$institucion.'</b></p>
				<p>Cargo:&nbsp; <b>'.$cargo.'</b></p>
				<p>Correo electronico:&nbsp; <b>'.$correo.'</b></p>
				<p>Correo electronico alternativo:&nbsp; <b>'.$correoA.'</b></p>
				<p>Telefono:&nbsp; <b>'.$telefono.'</b></p>
				<p>Numero celular:&nbsp; <b>'.$celular.'</b></p>
				';
				
				if($obj_correo->enviarCorreo($correos_json, $asunto, $cuerpo_correo)){
						$Array_correo2["correo"] = $correoA;
						$correos_json2 = array();
						array_push($correos_json2, $Array_correo2);
						if($obj_correo->enviarCorreo($correos_json2, $asunto, $cuerpo_correo)){
							echo 1;
						}
                }else{
                    echo -1;
                }
        }
		}
		else{
			echo 0;
		}
        
        break;
	case 2:
		$resp = $obj->existeCurp($curp);
        if (empty($resp)) {
            echo json_encode([]);
        } else {
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


