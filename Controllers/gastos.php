<?php
session_start();
require_once '../Models/Conexion.php';

if (isset($_POST['tabla']) && $_POST['tabla'] === "tabla") {
    $conexion = new Models\Conexion();
    $datos = array($_SESSION['negocio'], 1);

    $consulta = "SELECT idgastos,concepto,pago,descripcion,monto,estado,fecha,usuariocafi 
    FROM gastos WHERE negocio = ? AND eliminado != ?";

    echo json_encode($conexion->consultaPreparada($datos, $consulta, 2, "ii", false, null));
} else if (
    isset($_POST['idgastos']) && isset($_POST['Sconcepto']) && isset($_POST['Spago'])
    && isset($_POST['Tdescripcion']) && isset($_POST['Tmonto'])  && isset($_POST['Sestado'])
    && isset($_POST['Dfecha'])
) {
    $conexion = new Models\Conexion();

    $datos = array(
        $_POST['idgastos'],
        $_POST['Sconcepto'],
        $_POST['Spago'],
        $_POST['Tdescripcion'],
        $_POST['Tmonto'],
        $_POST['Sestado'],
        $_POST['Dfecha'],
        $_SESSION['email'],
        $_SESSION['negocio']
    );

    $consulta = "INSERT INTO gastos (idgastos,concepto,pago,descripcion,monto,
        estado,fecha,usuariocafi,negocio) VALUES (?,?,?,?,?,?,?,?,?)";
    echo $conexion->consultaPreparada($datos, $consulta, 1, "ssssssssi", false, null);
} else if (isset($_POST['idgastos']) && isset($_POST['Sestado'])) {

    $conexion = new Models\Conexion();
    $datos = array(
        $_POST['Sestado'],
        $_SESSION['email'],
        $_POST['idgastos']
    );

    $consulta = "UPDATE gastos SET estado = ? , usuariocafi = ? WHERE idgastos = ?";
    echo $conexion->consultaPreparada($datos, $consulta, 1, "ssi", false, null);
} else if (isset($_POST['array'])) {
    $conexion = new Models\Conexion();
    $data = json_decode($_POST['array']);
    $tipo_datos = "ii";
    $consulta = "UPDATE gastos SET eliminado = ? WHERE idgastos = ?";
    for ($i = 0; $i < count($data); $i++) {
        if ($data[$i] != '0') {
            $datos = array(1, $data[$i]);
            $result =  $respuesta = $conexion->consultaPreparada($datos, $consulta, 1, $tipo_datos, false, null);
        }
    }
    echo $result;
} else if (isset($_POST['combo']) && $_POST['combo'] === "combo") {
    $conexion = new Models\Conexion();
    $datos = array(
        "CEO",
        $_SESSION['negocio']
    );

    $consulta = "SELECT nombre FROM persona INNER JOIN 
   usuarioscafi ON persona.email = usuarioscafi.email
   WHERE acceso != ? AND negocio =  ?";
    echo json_encode($conexion->consultaPreparada($datos, $consulta, 2, "si", false, null));
}
