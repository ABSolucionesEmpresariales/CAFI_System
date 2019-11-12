<?php
session_start();
date_default_timezone_set("America/Mexico_City");
include_once '../Models/Conexion.php';
/* var_dump($_POST['Tabono'],
$_POST['Tcantidad'],
$_POST['idadeudo'],
$_POST['totaldeuda'],
$_POST['cambio']); */

 function setFecha()
{
    $año = date("Y");
    $mes = date("m");
    $dia = date("d");
    return $año . "-" . $mes . "-" . $dia;
}
 function setHora()
{
    $hora = date("H");
    $minuto = date("i");
    $segundo = date("s");
    return $hora . ":" . $minuto . ":" . $segundo;
}

if(isset($_POST['Tabono']) && isset($_POST['Tcantidad']) && isset($_POST['idadeudo']) && isset($_POST['totaldeuda'])
 && isset($_POST['cambio'])){
     $forma = "Efectivo";
     if($_POST['accion'] == "true"){
     $forma = "Tarjeta";
     }
    $conexion = new Models\Conexion();
    $datos_abono = array(
        null,
        "A",
        $_POST['Tabono'],
        $_POST['Tcantidad'],
        $forma,
        $_POST['cambio'],
        setFecha(),
        setHora(),
        $_SESSION['email'],
        $_POST['idadeudo'],
        $_SESSION['negocio'],
        0
    );
    $consulta_abonos = "INSERT INTO abono (idabono,estado,cantidad,pago,forma_pago,cambio,fecha,
    hora,usuariocafi,adeudos_id,negocio,eliminado) VALUES(?,?,?,?,?,?,?,?,?,?,?,?)";
    $consulta_adeudo = "UPDATE adeudos SET totaldeuda = ? WHERE idadeudos = ?";
    $consulta_estado = "UPDATE adeudos SET estado = ? WHERE totaldeuda = ?";
    $tipo_datos = "isddsdsssiii";
    $tipo_datos_adeudo = "di";
    $tipo = "sd";
    $datos = array("P",0.00);
    $datos_adeudo = array($_POST['totaldeuda'],$_POST['idadeudo']);
    $result =  $conexion->consultaPreparada($datos_abono, $consulta_abonos,1, $tipo_datos, false);
    $_SESSION['abono'] = $conexion->optenerId();
    if($result == 1){
        $result2 =  $conexion->consultaPreparada($datos_adeudo, $consulta_adeudo,1, $tipo_datos_adeudo, false);
        echo $result2;
    }else{
        echo "0";
    }
    $conexion->consultaPreparada($datos, $consulta_estado,1, $tipo, false);
    
    
    
}

if(isset($_POST['tabla'])){
    $conexion = new Models\Conexion();
    $consulta_tabla = "SELECT * FROM adeudos WHERE eliminado = 0";
    $jsonstring = json_encode($conexion->obtenerDatosDeTabla($consulta_tabla));
    echo $jsonstring;
}

if(isset($_POST['tabla_abonos'])){
    $conexion = new Models\Conexion();
    $consulta_tabla = "SELECT * FROM abono WHERE eliminado = 0";
    $jsonstring = json_encode($conexion->obtenerDatosDeTabla($consulta_tabla));
    echo $jsonstring;
}

if(isset($_POST['Sestado']) && isset($_POST['idabono'])){
    $conexion = new Models\Conexion();
    $consulta="";
    $datos = array($_POST['Sestado'],$_SESSION['email'],$_POST['idabono']);
    $tipo_datos = "ssi";
    if($_POST['Sestado'] == "A"){
        $consulta = "UPDATE adeudos INNER JOIN abono ON adeudos.idadeudos = abono.adeudos_id 
        SET adeudos.totaldeuda = (adeudos.totaldeuda-abono.cantidad),abono.estado = ? ,abono.usuariocafi = ?
        WHERE abono.idabono = ?";
    }else{
        $consulta = "UPDATE adeudos INNER JOIN abono ON adeudos.idadeudos = abono.adeudos_id 
        SET adeudos.totaldeuda = (adeudos.totaldeuda+abono.cantidad),abono.estado = ? ,abono.usuariocafi = ?
        WHERE abono.idabono = ?";
    }
    $result =  $conexion->consultaPreparada($datos, $consulta,1, $tipo_datos, false);
    $datos2 = array("A",0.00);
    $consulta="UPDATE adeudos SET estado = ? WHERE totaldeuda != ?";
    $tipos = "si";
    $conexion->consultaPreparada($datos2, $consulta,1, $tipos, false);
    echo $result;
}

    if (isset($_POST['array']) && isset($_POST['tabla_afectada'])) {
    $conexion = new Models\Conexion();
    $data = json_decode($_POST['array']);
    $tipo_datos = "ii";
    if($_POST['tabla_afectada'] === "abonos"){
        $consulta = "UPDATE abono SET eliminado = ? WHERE idabono = ?";
    }else if($_POST['tabla_afectada'] === "adeudos"){
        $consulta = "UPDATE adeudos SET eliminado = ? WHERE idadeudos = ?";
    }
    for ($i = 0; $i < count($data); $i++) {
        if ($data[$i] != '0') {
            $datos = array(1, $data[$i]);
            $result =  $respuesta = $conexion->consultaPreparada($datos, $consulta, 1, $tipo_datos, false);
        }
    }
    echo $result;
}
