<?php

session_start();

require '../../modelo/encapsulacion/Encapsulacion.class.php';
require '../../modelo/conexion/Conexion.class.php';
require '../../modelo/comando/catalogos/comando_avance_compromiso.php';


$Obj_Encapsulacion = new Encapsulacion();
$Obj_comando = new ComandoAvanceCompromiso();


$accion = $_REQUEST['yAccion'] ?? '0';

$cve_consejo = $_POST['Consejo'] ?? 0;
$cve_sesion = $_POST['Sesion'] ?? 0;
$cve_acuerdo_compromiso = $_POST['cve_acuerdo_compromiso'] ?? 0;
$nota = $_POST['Notas'] ?? '-';
$avance = $_POST['Avance'] ?? 0;

$cve_detalle_compromiso = $_POST['cve_detalle_compromiso'] ?? 0;

try{
   $Obj_Encapsulacion->__set('cve_consejo',$cve_consejo);
   $Obj_Encapsulacion->__set('cve_sesion',$cve_sesion);
   $Obj_Encapsulacion->__set('cve_acuerdo_compromiso',$cve_acuerdo_compromiso);
   $Obj_Encapsulacion->__set('cve_detalle_compromiso',$cve_detalle_compromiso);
   $Obj_Encapsulacion->__set('nota',$nota);
   $Obj_Encapsulacion->__set('avance',$avance);
    $Obj_Encapsulacion->__set('cve_usuario_registro', $_SESSION["USUARIO"]["cve_usuario"]);
	

    switch ($accion) {
       
        case 1://ListaConsejos
			$admin = false;
            if (isset($_SESSION["USUARIO"]) && $_SESSION["USUARIO"]["cve_grupo_seguridad"] == 1) {
                $admin = true;
            }
                echo  json_encode($Obj_comando->ListaConsejos($admin,$Obj_Encapsulacion));            
            exit();
        break;

        case 2:
            echo json_encode($Obj_comando->ListaSesiones($Obj_Encapsulacion));
        exit();
        break;

        case 3:
            echo json_encode($Obj_comando->ListaTipo());
        exit();
        break;

        case 4:
          echo json_encode($Obj_comando->TablaAcuerdos($Obj_Encapsulacion));
        exit();
        break;

        case 5:
            echo json_encode($Obj_comando->TablaCompromisos($Obj_Encapsulacion));
        exit();
        break;

        case 6:
			$Obj_comando->ActualizarAvanceCompromiso($Obj_Encapsulacion);
            echo json_encode($Obj_comando->GuardarNotas($Obj_Encapsulacion));
        exit();
        break;

        case 7:
            echo json_encode($Obj_comando->TablaNotas($Obj_Encapsulacion));
        exit();
        break;

        case 8:
			
            if($Obj_comando->Desactivar( $Obj_Encapsulacion) ){
				if($Obj_comando->AvanceDesactivar( $Obj_Encapsulacion)){
					echo 1;
				}else{
					echo 0;
				}

            }else{
                echo 0;
            }

            exit();
            break;

        case 9:
            echo json_encode($Obj_comando->PorcentajeActual($Obj_Encapsulacion));
        exit();
        break;

		case 10:
			$Obj_comando->ActualizarAvanceCompromiso($Obj_Encapsulacion);
            if($Obj_comando->ActualizarNota( $Obj_Encapsulacion) ){
                echo 1;
            }else{
                echo 0;
            }

		exit();
		break;

		case 11:
            if($Obj_comando->Terminar( $Obj_Encapsulacion) ){
                echo 1;
            }else{
                echo 0;
            }

		exit();
		break;

		case 12:
            if($Obj_comando->ActualizarArchivo( $Obj_Encapsulacion) ){
                echo 1;
            }else{
                echo 0;
            }

		exit();
		break;
       
    }
}catch(Exception $e){
    echo $e->getMessage();
}
