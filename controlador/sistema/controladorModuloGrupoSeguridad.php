<?php

session_start();

require '../../modelo/encapsulacion/Encapsulacion.class.php';
require '../../modelo/conexion/Conexion.class.php';
require '../../modelo/comando/sistema/comandoModuloGrupoSeguridad.php';

    $Obj_Encapsulacion = new Encapsulacion();
    $Obj_comando = new comandoModuloGrupoSeguridad();

    $accion = $_REQUEST['accion'] ?? '0';

    $Obj_Encapsulacion->__set('cve_menu', $_REQUEST['cve_menu'] ?? 0);
    $Obj_Encapsulacion->__set('cve_grupo_seguridad', $_REQUEST['cve_grupo_seguridad'] ?? null);

    try{
        switch ($accion) {
            case 1://Guardar 

                if($Obj_comando->insertar( $Obj_Encapsulacion) ){
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
            case 3://eliminar datos
                if($Obj_comando->Eliminar( $Obj_Encapsulacion) ){
                    echo 1;
                }else{
                    echo 0;
                }
                exit();
            break;
            case 4://combo grupo seguridad
                echo  json_encode($Obj_comando->grupoSeguridad() );
                exit();
            break;
            case 5://combo menú
                echo  json_encode($Obj_comando->subModulos($Obj_Encapsulacion) );
                exit();
            break;
        }
    }catch(Exception $e ){
        echo $e->getMessage();
        return false;
    }