<?php
session_start();
include_once '../Models/Conexion.php';

if(isset($_POST['sessionNegocio'])){
    echo $_SESSION['negocio'];
}

if(isset($_POST['idnegocio'])){
    $conexion = new Models\Conexion();
    $datos = array($_POST['idnegocio']);
    $tipo = "i";
    $consulta = "SELECT p.nombre,p.marca,p.color,p.talla_numero,p.unidad_medida,sum(d.cantidad) AS CantidadProducto FROM detalle_venta d 
    INNER JOIN producto p ON p.codigo_barras = d.producto
    INNER JOIN stock s ON s.producto = d.producto
    WHERE d.producto = p.codigo_barras AND p.codigo_barras = s.producto AND s.negocio = ?
    GROUP BY p.codigo_barras
    ORDER BY `CantidadProducto`
    DESC";
    $jsonstring = json_encode($conexion->consultaPreparada($datos, $consulta,2, $tipo, false));
    echo $jsonstring;
}
