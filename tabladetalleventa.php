<?php
session_start();
require_once "Config/Autoload.php";
Config\Autoload::run();
if (!isset($_SESSION['acceso']) && !isset($_SESSION['estado'])) {
    header('location: index.php');
} else if ($_SESSION['estado'] == "I") {
    header('location: index.php');
} else if (
    $_SESSION['acceso'] != "Manager" && $_SESSION['acceso'] != "Employes"
) {
    header('location: index.php');
}
$con = new Models\Conexion();
$negocio = $_SESSION['idnegocio'];
$query = "SELECT detalle_venta.producto_codigo_barras,nombre,color,marca,unidad_medida,talla_numero,precio_venta, cantidad_producto,subtotal FROM producto 
INNER JOIN detalle_venta ON producto.codigo_barras = detalle_venta.producto_codigo_barras 
INNER JOIN inventario ON producto.codigo_barras = inventario.producto_codigo_barras 
WHERE usuario = '$_SESSION[login]' AND idventa IS NULL AND inventario.negocios_idnegocios = '$negocio'";
$row = $con->consultaListar($query);
$con->cerrarConexion();
$json = array();
while ($renglon = mysqli_fetch_array($row)) {
    $json[] = array(
        'codigo' => $renglon['producto_codigo_barras'],
        'nombre' => $renglon['nombre'],
        'color' => $renglon['color'],
        'marca' =>  $renglon['marca'],
        'unidad_medida' =>  $renglon['unidad_medida'],
        'talla_numero' =>  $renglon['talla_numero'],
        'precio' =>  $renglon['precio_venta'],
        'cantidad' =>  $renglon['cantidad_producto'],
        'subtotal' =>  $renglon['subtotal']
    );
}
$jsonstring = json_encode($json);
echo $jsonstring;