<?php

session_start();

require '../../modelo/encapsulacion/Encapsulacion.class.php';
require '../../modelo/conexion/Conexion.class.php';
require '../../modelo/comando/sistema/comandoGrupoSeguridad.php';

    $Obj_Encapsulacion = new Encapsulacion();
    $Obj_comando = new comandoGrupoSeguridad();

    $accion = $_REQUEST['accion'] ?? '0';

    $Obj_Encapsulacion->__set('cve_grupo_seguridad', $_REQUEST['cve_grupo_seguridad'] ?? 0);
    $Obj_Encapsulacion->__set('nombre', $_REQUEST['nombre'] ?? null);
    $Obj_Encapsulacion->__set('activo', $_REQUEST['activo'] ?? 0);

    try{
        switch ($accion) {
            case 1://Guardar 

                if($Obj_comando->insertar( $Obj_Encapsulacion) > 0){
                    echo 1;
                }else{
                    echo 0;
                }
                exit();
            break;
            case 2://Lista menú
                echo  json_encode($Obj_comando->Tabla());
                exit();
            break;
            case 3://Modificar datos
                if($Obj_comando->Actualizar( $Obj_Encapsulacion) ){
                    echo 1;
                }else{
                    echo 0;
                }
                exit();
            break;
            case 4://Modificar datos
                if($Obj_comando->ActualizarEstatus( $Obj_Encapsulacion) ){
                    echo 1;
                }else{
                    echo 0;
                }
                exit();
            break;
            case 5://eliminar datos
                if($Obj_comando->Eliminar( $Obj_Encapsulacion) ){
                    echo 1;
                }else{
                    echo 0;
                }
                exit();
            break;
        }
    }catch(Exception $e ){
        echo $e->getMessage();
        return false;
    }