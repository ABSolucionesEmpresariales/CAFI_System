<?php
function token(){
    $datetime = getDateTime();
    $token = "";
    $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $codeAlphabet .= "abcdefghijklmnopqrstuvwxyz";
    $codeAlphabet .= "0123456789";
    $max = strlen($codeAlphabet);
    $conexion = new Models\Conexion();
    for ($i = 0; $i < 10; $i++) {
    $token .= $codeAlphabet[random_int(0, $max - 1)];
     }
    
    $_SESSION['token'] = $token;

    $consulta="SELECT id FROM sesiones WHERE usuario= ?";
    $usuario = array($_SESSION['email']);
    $idsesiones = $conexion->consultaPreparada($usuario,$consulta,2,"s",false);
  

    if ($idsesiones != null) {
        $consulta="UPDATE sesiones SET token= ?, inicio = ? WHERE usuario = ?";
        $datos = array($token,$datetime,$_SESSION['email']);
        $conexion->consultaPreparada($datos,$consulta,1,"sss",false);
    } else {
        $consulta="INSERT INTO sesiones(usuario,token,inicio) VALUES(?,?,?)";
        $datos = array($_SESSION['email'],$token,$datetime);
        $conexion->consultaPreparada($datos,$consulta,1,"sss",false);
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