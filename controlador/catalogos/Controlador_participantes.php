<?php

session_start();

require '../../modelo/encapsulacion/Encapsulacion.class.php';
require '../../modelo/conexion/Conexion.class.php';
require '../../modelo/comando/catalogos/comandoParticipantes.php';
require '../utilidades/email.php';

$Obj_Encapsulacion = new Encapsulacion();
$Obj_comando = new comandoResponsables();
$obj_correo = new email();

$accion = $_REQUEST['yAccion'] ?? '0';

$cve_persona = $_POST['CvePersona'] ?? 0;
$cve_participante = $_POST['CveParticipante'] ?? 0;
$cve_usuario = $_POST['CveUsuario'] ?? 0;
$nombre = $_POST['Nombre'] ?? '-';
$paterno = $_POST['Paterno'] ?? '-';
$materno = $_POST['Materno'] ?? '-';
$cve_institucion = $_POST['Institucion'] ?? '-';
$celular = $_POST['Celular'] ?? '-';
$correo = $_POST['Correo'] ?? '-';
// $responsable_consejo = $_POST['ResponsableActivo'] ?? 0;
// $cve_tipo_participante = $_POST['TipoParticipante'] ?? 0;
// $cve_participante_primario = $_POST['CveParticipantePrimario'] ?? 0;
$usuario_activo = $_POST['usuario_activo'] ?? 0;





try{
    $Obj_Encapsulacion->__set('cve_persona', $cve_persona);
    $Obj_Encapsulacion->__set('cve_participante', $cve_participante);
    $Obj_Encapsulacion->__set('cve_usuario', $cve_usuario);
    $Obj_Encapsulacion->__set('nombre', $nombre);
    $Obj_Encapsulacion->__set('paterno', $paterno);
    $Obj_Encapsulacion->__set('materno', $materno);
    $Obj_Encapsulacion->__set('cve_institucion', $cve_institucion);
    $Obj_Encapsulacion->__set('celular', $celular);
    $Obj_Encapsulacion->__set('correo', $correo);
    $Obj_Encapsulacion->__set('cve_usuario_registro',$_SESSION["USUARIO"]["cve_usuario"]);
    // $Obj_Encapsulacion->__set('cve_participante_primario',$cve_participante_primario);
    // $Obj_Encapsulacion->__set('cve_tipo_participante',$cve_tipo_participante);
    // $Obj_Encapsulacion->__set('responsable_consejo',$responsable_consejo);




    switch ($accion) {
        case 1://Guardar responsable
            //Usuario para inicio de sesión
            $usuario = strtok($correo, '@');

            $Obj_Encapsulacion->__set('usuario', $usuario);

            $admin=false;
            if(isset($_SESSION["USUARIO"]) && $_SESSION["USUARIO"]["cve_grupo_seguridad"] ==1){
                $Obj_Encapsulacion->__set('cve_grupo_seguridad',1);
            }else{
                $Obj_Encapsulacion->__set('cve_grupo_seguridad', 2);
            }

            // switch($cve_tipo_participante){

            //     case 1:
            //         $Obj_Encapsulacion->__set('cve_grupo_seguridad',1);
            //     break;
            //     case 2:
            //         $Obj_Encapsulacion->__set('cve_grupo_seguridad', 2);
            //     break;
            //     case 3:
            //         $Obj_Encapsulacion->__set('cve_grupo_seguridad',3);
            //     break;
            // }
        
            if($Obj_comando->insertar( $Obj_Encapsulacion) >= 0){
                echo 1;
            }else{
                echo 0;
            }
            exit();
        break;
        case 2://Modificar datos
        //Usuario para inicio de sesión
        $usuario = strtok($correo, '@');

        $Obj_Encapsulacion->__set('usuario', $usuario);

        if($Obj_comando->Modificar( $Obj_Encapsulacion) ){
            echo 1;
        }else{
            echo 0;
        }
        exit();
        break;
        case 3: //Lista de datos     
            echo  json_encode($Obj_comando->ListaUsuarios($Obj_Encapsulacion));
            exit();
        break;
        case 4://Generar contraseña
                //Usuario para inicio de sesión
                $usuario = strtok($correo, '@');
				
				$Array_correo["correo"] = $correo;
				$correos_json = array();
				array_push($correos_json, $Array_correo);
				
				
                $Obj_Encapsulacion->__set('usuario', $usuario);

            $caracteres = '123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz-.#!';
            $aleatoria = substr(str_shuffle($caracteres), 0, 8);
            $Obj_Encapsulacion->__set('constrasena',  $aleatoria);

            if($Obj_comando->ActualizarContrasena( $Obj_Encapsulacion) ){
                $asunto ="";
                $cuerpo_correo = "";

                if($usuario_activo ==1){
                    $asunto ="Datos actualizados";
                    $cuerpo_correo ='<h3>Estimado&nbsp; <b>'.$nombre.' '. $paterno.' ' .$materno. '</b></h3>
                    <p>Su cuenta fue actualizada con los siguientes datos:</p>
                    <p>Usuario:&nbsp; <b>'.$usuario.'</b> </p>
                    <p>Contraseña:&nbsp; <b>'.$aleatoria.'</b></p>
                    <p>Liga de acceso: <b><a href="http://10.16.42.73/consejo/" target="_blank">Consejo Directivo UTL</a></b></p>
                    <p><span style="text-color: rgb(255, 0, 0);">No comparta sus accesos.</span></p>
                    <p>Nota: Si desea cambiar de contraseña deberá solicitarlo al administrador al correo rfranco@gmail.com</p>';
                }else{
                    $asunto ="Bienvenido al Consejo directivo";
                    $cuerpo_correo ='<h3>Estimado&nbsp; <b>'.$nombre.' '. $paterno.' ' .$materno. '</b></h3>
                    <p>Su usuario asignado para el inicio de sesión es:</p>
                    <p>Usuario:&nbsp; <b>'.$usuario.'</b> </p>
                    <p>Contraseña:&nbsp; <b>'.$aleatoria.'</b></p>
                    <p>Liga de acceso: <b><a href="http://10.16.42.73/consejo/" target="_blank">Consejo Directivo UTL</a></b></p>
                    <p><span style="text-color: rgb(255, 0, 0);">No comparta sus accesos.</span></p>
                    <p>Nota: Si desea cambiar de contraseña deberá solicitarlo al administrador al correo rfranco@gmail.com</p>';
                }
                
                if($obj_correo->enviarCorreo($correos_json, $asunto, $cuerpo_correo)){
                    echo 1;
                }else{
                    echo -1;
                }
                
            }else{
                echo 0;
            }

        exit();
        break;
        case 5://TipoParticipante
            $admin=false;
            if(isset($_SESSION["USUARIO"]) && $_SESSION["USUARIO"]["cve_grupo_seguridad"] ==1){
                $admin = true;
            }
            echo  json_encode($Obj_comando->TipoParticipante($admin));
            
            exit();
        break;
        case 6:
            echo  json_encode($Obj_comando->ListaParticipantes());
            exit();
            break;
        case 7:
            if($Obj_comando->Desactivar( $Obj_Encapsulacion) ){
                echo 1;
            }else{
                echo 0;
            }

            exit();
            break;
            case 8:
                echo  json_encode($Obj_comando->Instituciones());
                exit();
            break;
    }
}catch(Exception $e){
    echo $e->getMessage();
}
