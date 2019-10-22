<?php
session_start();
include_once '../Models/Conexion.php';
include_once '../Models/Fecha.php';
if (
    isset($_POST['idventa']) && isset($_POST['descuento'])  && isset($_POST['total']) && isset($_POST['pago']) && isset($_POST['cambio']) && isset($_POST['forma_pago'])
    && isset($_POST['json_string']) && !isset($_POST['totaldeuda']) && !isset($_POST['anticipo'])
) {

    //si la venta es pagada en efectivo se actualizan los datos de la tabla venta
    $conexion = new Models\Conexion();
    $fecha = new Models\Fecha();
    $datos = array(
        $conexion->eliminar_simbolos($_POST['idventa']),
        $conexion->eliminar_simbolos($_POST['descuento']),
        $conexion->eliminar_simbolos($_POST['total']),
        $conexion->eliminar_simbolos($_POST['pago']),
        $conexion->eliminar_simbolos($_POST['cambio']),
        $conexion->eliminar_simbolos($_POST['forma_pago']),
        $fecha->getFecha(),
        $fecha->getHora(),
        "A",
        $_SESSION['email'],
        $_SESSION['negocio'],
        0
    );

    $consulta = "INSERT INTO venta (idventas,descuento,total,pago,cambio,forma_pago,fecha,hora,estado_venta,usuariocafi,negocio,eliminado) VALUES(?,?,?,?,?,?,?,?,?,?,?,?)";
    $conexion->consultaPreparada($datos, $consulta, 1, "sssssssssssi", false);
    $venta = $conexion->insert_id();

    $consulta = "INSERT INTO detalle_venta(idventa,producto,cantidad,subtotal) VALUES(?,?,?,?)";
    $jsonstring = $_POST['json_string'];
    $carrito = json_decode($jsonstring);

    for ($i = 0; $i < sizeof($carrito); $i++) {
        array_unshift($carrito[$i], $venta);
        $conexion->consultaPreparada($carrito[$i], $consulta, 1, "ssss", false);
    }

    $consulta = "SELECT (stock - cantidad) AS stock, stock.producto  FROM
        stock INNER JOIN detalle_venta ON stock.producto = detalle_venta.producto
        WHERE detalle_venta.idventa= ?";
    $dato = array($venta);
    $result = $conexion->consultaPreparada($dato, $consulta, 2, "s", false);

    $consulta = "UPDATE stock SET stock = ? WHERE producto= ? AND negocio = ?";

    if ($result != null) {
        for ($i = 0; $i < sizeof($result); $i++) {
            array_push($result[$i], $_SESSION['negocio']);
            $conexion->consultaPreparada($result[$i], $consulta, 1, "sss", false);
        }
    }

    $consulta = "SELECT impresora FROM negocios WHERE idnegocios = ?";
    $negocio = array($_SESSION['negocio']);
    $result = $conexion->consultaPreparada($negocio, $consulta, 2, "s", false);
    if ($result != null) {
        if ($result[0][0] === "A") {
            echo "Exitoprinter";
        } else {
            echo "Exito";
        }
    }
}
