<?php
require_once '../Models/Conexion.php';
$hash = password_hash('123',PASSWORD_DEFAULT);
$conexion = new Models\Conexion();
$arreglo = array($hash);
$conexion->consultaSimple("UPDATE usuariosab SET contrasena = '$hash'");
$conexion->consultaSimple("UPDATE usuarioscafi SET contrasena = '$hash'");