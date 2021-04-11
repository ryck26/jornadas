<?php

session_start();

require '../../modelo/encapsulacion/Encapsulacion.class.php';
require '../../modelo/conexion/Conexion.class.php';
require '../../modelo/comando/sistema/comandoModulo.php';

    $Obj_Encapsulacion = new Encapsulacion();
    $Obj_comando = new comando_modulo();

    $accion = $_REQUEST['accion'] ?? '0';


    $Obj_Encapsulacion->__set('cve_menu', $_REQUEST['cve_menu'] ?? 0);
    $Obj_Encapsulacion->__set('cve_menu_superior', $_REQUEST['cve_menu_superior'] ?? 0);
    $Obj_Encapsulacion->__set('nombre', $_REQUEST['nombre'] ?? null);
    $Obj_Encapsulacion->__set('ruta', $_REQUEST['ruta'] ?? null);
    $Obj_Encapsulacion->__set('activo', $_REQUEST['activo'] ?? 0);
    $Obj_Encapsulacion->__set('orden', $_REQUEST['orden'] ?? 0);

    try{
        switch ($accion) {
            case 1://Guardar 

                if($Obj_comando->insertarModulo( $Obj_Encapsulacion) > 0){
                    echo 1;
                }else{
                    echo 0;
                }
                exit();
            break;
            case 2://Lista menú
                echo  json_encode($Obj_comando->ListaMenu());
                exit();
            break;
            case 3://Modificar datos
                if($Obj_comando->ActualizarModulo( $Obj_Encapsulacion) ){
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
                if($Obj_comando->EliminarMod( $Obj_Encapsulacion) ){
                    echo 1;
                }else{
                    echo 0;
                }
                exit();
            break;
            //submenu
            case 6://Lista subMenú
                echo  json_encode($Obj_comando->ListaSubMenu($Obj_Encapsulacion));
                exit();
            break;
            case 7://Lista subMenú
                if($Obj_comando->insertarSubModulo($Obj_Encapsulacion) > 0 ){
                    echo 1;
                }else{
                    echo 0;
                }
                exit();
            break;
            case 8://Modificar datos
                if($Obj_comando->ActualizarSub( $Obj_Encapsulacion) ){
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