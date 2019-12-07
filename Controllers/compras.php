<?php
session_start();
require_once '../Models/Conexion.php';
require_once '../Models/Fecha.php';
if (
    isset($_POST['Tfolio_factura']) && isset($_POST['Sproveedor']) && !empty($_POST['Sforma_pago']) && isset($_POST['Dfecha_factura'])
    && isset($_POST['Dfecha_vencimiento_factura']) && isset($_POST['Dfecha_vencimiento_credito']) && isset($_POST['Tanticipo']) && isset($_POST['Tdescuento'])
    && isset($_POST['total']) && isset($_POST['tasa_iva']) && isset($_POST['Smetodo_pago']) && isset($_POST['arraycarrito'])
) {
    $conexion = new Models\Conexion();
    $fecha = new Models\Fecha();

    

    $datos =  array(
        NULL,
        $_POST['Tfolio_factura'],
        $_POST['Sproveedor'],
        $_POST['Sforma_pago'],
        $_POST['Dfecha_factura'],
        $fecha->getFecha(),
        $_POST['Dfecha_vencimiento_factura'],
        $fecha->getFecha(),
        $_POST['Dfecha_vencimiento_credito'],
        $_POST['Tanticipo'],
        $_POST['Tdescuento'],
        $_POST['total'],
        $_POST['tasa_iva'],
        $_POST['Smetodo_pago'],
        $_SESSION['email'],
        $_SESSION['negocio'],
        "A",
        0
    );
    $consulta = "INSERT INTO compras (idcompras,folio_factura,proveedor,forma_pago,fecha_factura,fecha_compra,fecha_vencimiento_factura,fecha_inicio_credito,fecha_vencimiento_credito,anticipo,descuento,total,tasa_iva,metodo_pago,usuariocafi,negocio,estado,eliminado) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    $result = $conexion->consultaPreparada($datos, $consulta,1, "sssssssssssssssssi", false,null);
    $compra = $conexion->optenerId();
    $jsonstring = $_POST['arraycarrito'];
    $carrito = json_decode($jsonstring);
    $consulta3 = "INSERT INTO concepto_compra (compra,producto,nombre,iva,ieps,costo,cantidad,subtotal) VALUES(?,?,?,?,?,?,?,?)";
    if($result == 1){
        for ($i = 0; $i < sizeof($carrito); $i++) {            $codigo_producto = $carrito[$i][0];
            $nombre_producto = $carrito[$i][1];
            $costo_producto = $carrito[$i][2];
            $iva_producto = $carrito[$i][3];
            $ipes_producto = $carrito[$i][4];
            $cantidad_producto = $carrito[$i][5];
            $subtotal_producto = $carrito[$i][6];
            $unidad_medida_producto = $carrito[$i][7];
            $precio_venta_producto = $carrito[$i][8];
            $datos_producto = array($codigo_producto);
            $consulta_producto = 'SELECT * FROM producto WHERE codigo_barras = ?';
            $producto = json_encode($conexion->consultaPreparada($datos_producto, $consulta_producto,2,"s",false,null));
            if($producto == '[]'){
                $consulta_registro = 'INSERT INTO producto (codigo_barras,nombre,proveedor,precio_compra,precio_venta,unidad_medida,dueno) VALUES (?,?,?,?,?,?,?)';
                $datos_producto2 = array($codigo_producto,$nombre_producto,$costo_producto,$_POST['Sproveedor'],$precio_venta_producto,$unidad_medida_producto,$_SESSION['email']);
                $registro = $conexion->consultaPreparada($datos_producto2, $consulta_registro,1,"sssiiss",false,null);
                if($registro == 1){
                    $consulta_registro_stock = "INSERT INTO stock (producto,stock,estado,usuariocafi,negocio,eliminado) VALUES (?,?,?,?,?,?)";
                    $datos_stock = array($codigo_producto,$cantidad_producto,"A",$_SESSION['email'],$_SESSION['negocio'],0);
                    $registro_stock = $conexion->consultaPreparada($datos_stock, $consulta_registro_stock,1,"sissii",false,null);
                    if($registro_stock != 1){
                        echo 0;
                    }
                }else{
                    echo 0;
                }
            }else{
                $consulta_editar = 'UPDATE producto SET precio_venta = ? WHERE codigo_barras = ?';
                $datos_editar = array($precio_venta_producto,$codigo_producto);
                $registro2 = $conexion->consultaPreparada($datos_editar, $consulta_editar,1,"is",false,null);
                if($registro2 == 1){
                    $consulta_update_stock = "UPDATE stock SET stock = (stock + ?) WHERE producto = ? ";
                    $datos_update_stock = array($cantidad_producto,$codigo_producto);
                    $update_stock = $conexion->consultaPreparada($datos_update_stock, $consulta_update_stock,1,"is",false,null);
                    if($update_stock != 1){
                        echo 0;
                    }
                }else{
                    echo 0;
                }
            }
            $datos_carrito = array($compra,$codigo_producto,$nombre_producto,$iva_producto,$ipes_producto,$costo_producto,
            $cantidad_producto ,$subtotal_producto);
            array_unshift($carrito[$i], $compra);
            $result2 = $conexion->consultaPreparada($datos_carrito, $consulta3, 1, "isssssis", false,null);
        }
    }
    if($_POST['Sforma_pago'] == 'Credito'){
        $datos2 = array(null,$_POST['total'],$_POST['Tanticipo'],'A',$compra,$_POST['Sproveedor'],0);
        $consulta2 = 'INSERT INTO cpp (idcpp,totaldeuda,anticipo,estado,compra,proovedor,eliminado) VALUES(?,?,?,?,?,?,?)';
        $conexion->consultaPreparada($datos2, $consulta2, 1, "iddsiii", false,null);
    }
    echo $result2;

} else if (isset($_POST['tabla']) && $_POST['tabla'] === "tabla") {
    $conexion = new Models\Conexion();
    $datos = array(1, $_SESSION['negocio']);
    $consulta = "SELECT idcompras,folio_factura,proveedor,forma_pago,fecha_factura,fecha_compra,fecha_vencimiento_factura,fecha_inicio_credito,fecha_vencimiento_credito,
    anticipo,descuento,total,tasa_iva,metodo_pago,compras.usuariocafi, compras.estado FROM  compras
    WHERE compras.eliminado != ? AND compras.negocio = ?";
    echo json_encode($conexion->consultaPreparada($datos, $consulta, 2, "ii", false,null));

} else if (isset($_POST['idcompras']) && !isset($_POST['estado'])) {
    $conexion = new Models\Conexion();
    $datos = array($_POST['idcompras']);
    $consulta = "SELECT cantidad,producto.nombre,imagen,marca,color,unidad_medida,talla_numero,costo,iva,ieps,subtotal FROM concepto_compra
    INNER JOIN producto ON producto = codigo_barras WHERE compra = ?";
    echo json_encode($conexion->consultaPreparada($datos, $consulta, 2, "s", false,null));

} else if (isset($_POST['array'])) {
    $conexion = new Models\Conexion();
    $data = json_decode($_POST['array']);
    if($data == ["0"]){
        echo 0;
    }else{
        $data = json_decode($_POST['array']);
        $tipo_datos = "ii";
        $consulta = "UPDATE compras SET eliminado = ? WHERE idcompras = ?";
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i] != '0') {
                $idcompra = $data[$i];
                $datos = array(1, $data[$i]);
                $result = $conexion->consultaPreparada($datos, $consulta, 1, $tipo_datos, false,null);
                if($result == 1){
                    $consulta2 = "UPDATE cpp SET eliminado = ? WHERE compra = ?";
                    $datos2 = array(1, $data[$i]);
                    $result = $conexion->consultaPreparada($datos2, $consulta2, 1,'ii', false,null);
                    if($result == 1){
                        $datos_adeudo = array($data[$i]);
                        $consulta_adeudo_compra = "SELECT idcpp FROM cpp WHERE compra = ?";
                        $id_adeudo = json_encode($conexion->consultaPreparada($datos_adeudo,$consulta_adeudo_compra,2,'i',false,null));
                        $result3 = json_decode($id_adeudo);
                        $datos3 = array(1,$idcompra);
                        $consulta3 = "UPDATE abono_compras SET eliminado = ? WHERE compra = ?";
                        $result = $conexion->consultaPreparada($datos3, $consulta3, 1,'ii', false,null);  
                    }
                }
            }
        }
        echo $result;
    }
} else if (isset($_POST['estado']) && isset($_POST['idcompras'])) {
    $conexion = new Models\Conexion();
    $consulta = "UPDATE compras SET estado = ? WHERE idcompras = ?";
    $datos = array($_POST['estado'], $_POST['idcompras']);
    $result =  $conexion->consultaPreparada($datos, $consulta, 1, "ss", false,null);
    if($result == 1){
        $consulta_cpp = "UPDATE cpp INNER JOIN compras on compras.idcompras = cpp.compra SET cpp.estado = ? WHERE compras.idcompras = ?";
        $result =  $conexion->consultaPreparada($datos, $consulta_cpp, 1, "ss", false,null);
        if($result == 1){
            $consulta_anonos_compra = "UPDATE abono_compras INNER JOIN cpp ON cpp.compra = abono_compras.compra SET abono_compras.estado = ? WHERE abono_compras.compra = ?";
            $result = $conexion->consultaPreparada($datos, $consulta_anonos_compra, 1, "ss", false,null);
        }

    }
     echo $result;
}

if(isset($_POST['producto'])){
    $conexion = new Models\Conexion();
    $consulta = "SELECT codigo_barras,nombre FROM producto p INNER JOIN stock s ON s.producto = p.codigo_barras WHERE s.negocio = ?";
    $datos = array($_SESSION['negocio']);
    echo json_encode($conexion->consultaPreparada($datos, $consulta,2, "i", false,null));
}
if(isset($_POST['idproducto'])){
    $conexion = new Models\Conexion();
    $consulta = "SELECT nombre,unidad_medida FROM producto WHERE codigo_barras = ?";
    $datos = array($_POST['idproducto']);
    echo json_encode($conexion->consultaPreparada($datos, $consulta,2, "s", false,null));
}
