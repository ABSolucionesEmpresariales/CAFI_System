<?php
session_start();
require_once '../Models/Conexion.php';
if (isset($_POST['categoria'])) {
    $conexion = new Models\Conexion();
    $consulta = "SELECT nombre,imagen,marca,color,GROUP_CONCAT(DISTINCT talla_numero) AS talla_numero ,unidad_medida,
    GROUP_CONCAT(DISTINCT stock) AS stock ,producto FROM producto INNER JOIN stock ON codigo_barras = producto
    WHERE categoria = ? AND negocio = ? AND estado = ? AND eliminado != ? GROUP BY nombre,marca,color,unidad_medida";
    $datos = array(
        $_POST['categoria'],
        $_SESSION['negocio'],
        "A",
        1
    );

    echo json_encode($conexion->consultaPreparada($datos, $consulta, 2, "sisi", false,null));
}
