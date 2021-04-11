<?php
session_start();
$_SESSION["INDEX-DIR"] = $_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];
if (!isset($_SESSION["USUARIO"])) {
    //print_r($_SESSION["USUARIO"]);
    include_once 'vista/inicio/inicio.php';
} else {
    include_once 'vista/inicio/inicio_sesion.php';
}

