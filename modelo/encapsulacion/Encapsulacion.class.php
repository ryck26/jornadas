<?php

/**
  * Descripcion 		: Clase general donde se realizarán los get y set de todas las clases
  * Autor 			: Federico Adolfo Flores Andrade
  * Version                     : 1.0
  * Fecha de creacion           : 13/06/2013, 00:00:00
  **/
 
class Encapsulacion
{
    
        function __construct() {
            
        }
    
	//SET de variables locales
        public function __set($variable, $valor)
        {
                $this->$variable = $valor;
        }
        
        //GET de variables locales
        public function __get($variable)
        {
                return $this->$variable;
        }
        
        //Saber si existe una variable
        public function __isset($variable)
        {
                return isset($variable);
        }
        

}
      
?>