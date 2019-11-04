<?php 
session_start();
require_once "Config/Autoload.php";
Config\Autoload::run();
$con = new Models\Conexion();
$query = "SELECT codigo_barras,nombre,imagen,color,marca,proveedor,descripcion,unidad_medida,talla_numero,tipo,precio_compra,precio_venta,pestado,cantidad,stock_minimo
FROM producto INNER JOIN inventario ON producto.codigo_barras=inventario.producto_codigo_barras
WHERE inventario.negocios_idnegocios='$_POST[idProducto]' ORDER BY nombre ASC";
$row = $con->consultaListar($query);
$con->cerrarConexion();
$json = array();
$idnego = $_SESSION['idnegocio'];
   while ($renglon = mysqli_fetch_array($row)) {
       $json[] = array(
           'codigo_barras' =>  $renglon['codigo_barras'],
           'nombre' => $renglon['nombre'],
           'imagen' =>  $renglon['imagen'],
           'color' =>  $renglon['color'],
           'marca' =>  $renglon['marca'],
           'proveedor' =>  $renglon['proveedor'],
           'descripcion' => $renglon['descripcion'],
           'unidad_medida' => $renglon['unidad_medida'],
           'talla_numero' =>  $renglon['talla_numero'],
           'tipo' =>  $renglon['tipo'],
           'precio_compra' => $renglon['precio_compra'],
           'precio_venta' => $renglon['precio_venta'],
           'pestado' => $renglon['pestado'],
           'cantidad' => $renglon['cantidad'],
            'stockmin' =>  $renglon['stock_minimo'],
           'idNegocio' => $idnego
           
       );
   }
   $jsonstring = json_encode($json);
   echo $jsonstring;
?>