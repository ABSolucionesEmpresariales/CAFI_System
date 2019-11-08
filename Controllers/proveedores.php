<?php
session_start();
require_once '../Models/Conexion.php';

if (isset($_POST['tabla']) && $_POST['tabla'] === "tabla") {

    $conexion = new Models\Conexion();
    $datos = array($_SESSION['negocio'], 1);
    $consulta = "SELECT idproveedor,rfc,dias_credito,nombre,domicilio,colonia,ciudad,estado,pais,telefono,email,usuariocafi
    FROM proveedor WHERE negocio = ? AND eliminado != ? ";
    echo json_encode($conexion->consultaPreparada($datos, $consulta, 2, "ii", false));
} else if (
    isset($_POST['idproveedor']) && isset($_POST['Trfc']) && isset($_POST['Sdias_credito']) && isset($_POST['Tnombre'])
    && isset($_POST['Tdomicilio']) && isset($_POST['Tcolonia']) && isset($_POST['Tciudad']) && isset($_POST['Sestado'])
    && isset($_POST['Tpais']) && isset($_POST['Ttelefono']) && isset($_POST['Temail']) && isset($_POST['accion'])
) {

    $conexion = new Models\Conexion();
    $datos = array(
        $_POST['idproveedor'],
        $_POST['Trfc'],
        $_POST['Sdias_credito'],
        $_POST['Tnombre'],
        $_POST['Tdomicilio'],
        $_POST['Tcolonia'],
        $_POST['Tciudad'],
        $_POST['Sestado'],
        $_POST['Tpais'],
        $_POST['Ttelefono'],
        $_POST['Temail'],
        $_SESSION['email'],
        $_SESSION['negocio'],
        0
    );

    if ($_POST['accion'] === 'false') {

        $consulta = "INSERT INTO proveedor (idproveedor,rfc,dias_credito,nombre,domicilio,colonia,ciudad,estado,pais,telefono,email,usuariocafi,negocio,eliminado)
        VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        echo $conexion->consultaPreparada($datos, $consulta, 1, "ssisssssssssii", false);
    } else {

        $consulta = "UPDATE proveedor SET rfc = ?, dias_credito = ?, nombre = ? ,domicilio = ? , colonia = ?,
          ciudad = ? , estado = ? , pais = ?, telefono = ?, email = ? , usuariocafi = ? , negocio = ? , eliminado = ? WHERE idproveedor = ?";
        echo $conexion->consultaPreparada($datos, $consulta, 1, "sisssssssssiis", true);
    }
} else if (isset($_POST['array'])) {
    $conexion = new Models\Conexion();
    $data = json_decode($_POST['array']);
    $tipo_datos = "ii";
    $consulta = "UPDATE proveedor SET eliminado = ? WHERE idproveedor = ?";
    for ($i = 0; $i < count($data); $i++) {
        if ($data[$i] != '0') {
            $datos = array(1, $data[$i]);
            $result =  $respuesta = $conexion->consultaPreparada($datos, $consulta, 1, $tipo_datos, false);
        }
    }
    echo $result;
}
