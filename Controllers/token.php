<?php
function token(){
    $datetime = getDateTime();
    $token = "";
    $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $codeAlphabet .= "abcdefghijklmnopqrstuvwxyz";
    $codeAlphabet .= "0123456789";
    $max = strlen($codeAlphabet);

    for ($i = 0; $i < $length; $i++) {
    $token .= $codeAlphabet[random_int(0, $max - 1)];
     }
    
    $_SESSION['token'] = $token;

    $consulta="SELECT id FROM sesiones WHERE usuario= ?";
    $usuario = array();
    array_push($usuario,$_SESSION['email']);
    $idsesiones = $conexion->consultaPreparada($usuario,$consulta,2,"s");
  

    if ($idsesiones != "[]") {
        $consulta="UPDATE sesiones SET token= ?, inicio = ? WHERE usuario = ?";
        $datos = array();
        array_push($datos,$token,$datetime,$_SESSION['email']);
        $conexion->consultaPreparada($datos,$consulta,"sss");
    } else {
        $consulta="INSERT INTO sesiones(usuario,token,inicio) VALUES(?,?,?)";
        $datos = array();
        array_push($datos,$_SESSION['email'],$token,$datetime);
        $conexion->consultaPreparada($datos,$consulta,1,"sss");
    }
}
function getDateTime()
{
  date_default_timezone_set("America/Mexico_City");
  $año = date("Y");
  $mes = date("m");
  $dia = date("d");
  $fecha = $año . "-" . $mes . "-" . $dia;
  $hora = date("H");
  $minuto = date("i");
  $segundo = date("s");
  $hora = $hora . ":" . $minuto . ":" . $segundo;

  return  $fecha . " " . $hora;
}