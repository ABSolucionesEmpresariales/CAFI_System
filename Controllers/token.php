<?php
function token()
{
    $conexion = new Models\Conexion();
    $fecha = new Models\Fecha();
    $token = "";
    $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $codeAlphabet .= "abcdefghijklmnopqrstuvwxyz";
    $codeAlphabet .= "0123456789";
    $max = strlen($codeAlphabet);
    for ($i = 0; $i < 10; $i++) {
        $token .= $codeAlphabet[random_int(0, $max - 1)];
    }

    $_SESSION['token'] = $token;

    $consulta = "SELECT id FROM sesiones WHERE usuario= ?";
    $usuario = array($_SESSION['email']);
    $idsesiones = $conexion->consultaPreparada($usuario, $consulta, 2, "s", false,null);
    $datos = array($_SESSION['email'], $fecha->getFecha() . " " . $fecha->getHora(), "", $token);

    if ($idsesiones != null) {
        $consulta = "UPDATE sesiones SET inicio = ?, fin = ?, token= ?  WHERE usuario = ?";
        $conexion->consultaPreparada($datos, $consulta, 1, "ssss", true,null);
    } else {
        $consulta = "INSERT INTO sesiones(usuario,inicio,fin,token) VALUES(?,?,?,?)";
        $conexion->consultaPreparada($datos, $consulta, 1, "ssss", false,null);
    }
}
function tokenSalida(){
    $conexion = new Models\Conexion();
    $fecha = new Models\Fecha();
    $consulta = "UPDATE sesiones SET fin = ? WHERE usuario = ?";
    $datos = array($fecha->getFecha() . " " . $fecha->getHora(),$_SESSION['email']);
    $conexion->consultaPreparada($datos, $consulta, 1, "ss", false,null);
}
