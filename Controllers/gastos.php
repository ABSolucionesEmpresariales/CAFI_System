<?php
session_start();
require_once '../Models/Conexion.php';

if (isset($_POST['tabla']) && $_POST['tabla'] === "tabla") {
    $conexion = new Models\Conexion();
    $datos = array($_SESSION['negocio'], 1);

    $consulta = "SELECT idgastos,concepto,pago,descripcion,monto,estado,fecha,usuariocafi 
    FROM gastos WHERE negocio = ? AND eliminado != ?";

    echo json_encode($conexion->consultaPreparada($datos, $consulta, 2, "ii", false));
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
    echo $conexion->consultaPreparada($datos, $consulta, 1, "ssssssssi", false);

} else if (isset($_POST['idgastos']) && isset($_POST['Sestado'])) {

    $conexion = new Models\Conexion();
    $datos = array(
        $_POST['Sestado'],
        $_SESSION['email'],
        $_POST['idgastos']
    );

   $consulta = "UPDATE gastos SET estado = ? , usuariocafi = ? WHERE idgastos = ?";
   echo $conexion->consultaPreparada($datos, $consulta, 1, "ssi", false);
}
