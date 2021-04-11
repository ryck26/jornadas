<?php

/*
 * Titulo			: Registro.php
 * Descripción                  : 
 * Compañía			: 
 * Fecha de creación            : 01-julio-2020
 * Desarrollador                : Juan Pablo Mendoza
 * Versión			: 1.0
 * ID Requerimiento             : 
 */

class Registro {

    function __construct() {
        
    }

    /*
     * Metodo que verifica los datos ingresados para iniciar sesion,
     * si existe devuelve los datos en un arreglo asosiativo, si no devuelve
     * un arreglo vacio
     */
     function guardarRegistro($nombre, $paterno, $materno, $curp, $cargo, $institucion, $correo, $correoA, $telefono, $celular)
    {
        try {
            $Conexion = Conexion::getInstance()->obtenerConexion();
            $this->SQL = "INSERT INTO persona (nombre, paterno, materno, curp, institucion, cargo, correo, correo_alternativo, telefono, celular) 
                            VALUES ('$nombre', '$paterno', '$materno', '$curp', '$cargo', '$institucion', '$correo', '$correoA', '$telefono', '$celular')";
            $this->sta = $Conexion->prepare($this->SQL);
            $this->sta->execute();
			
            $id = $Conexion->lastInsertId();
			
            $this->SQL = "INSERT INTO suscripcion_curso (cve_persona, cve_curso) 
                            VALUES ('$id', 1)";
            $this->sta = $Conexion->prepare($this->SQL);
            $this->sta->execute();
            //insertar aqui participante del consejo       
            Conexion::getInstance()->cerrarConexion();
			//var_dump($datos);
            return $id;
        }catch (Exception $e){
            Conexion::getInstance()->cerrarConexion();
            return $e->getMessage();
        }
    }
	
	 function existeCurp($curp)
    {
        try {
            $Conexion = Conexion::getInstance()->obtenerConexion();
            $this->SQL = "SELECT        1 AS existe
							FROM            persona
							WHERE        (curp = :curp)";
            $this->sta = $Conexion->prepare($this->SQL);
			$this->sta->bindParam(":curp", $curp);
            $this->sta->execute();
			$result = $this->sta->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		catch (Exception $e){
            Conexion::getInstance()->cerrarConexion();
            return $e->getMessage();
        }
	}

}
