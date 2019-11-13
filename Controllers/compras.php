<?php
session_start();
require_once '../Models/Conexion.php';
require_once '../Models/Fecha.php';
if (
    isset($_POST['Tfolio_factura']) && isset($_POST['Sproveedor']) && isset($_POST['Sforma_pago']) && isset($_POST['Dfecha_factura'])
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
    $conexion->consultaPreparada($datos, $consulta, 1, "sssssssssssssssssi", false);
    $compra = $conexion->optenerId();
    $jsonstring = $_POST['arraycarrito'];
    $carrito = $jsonstring;
    var_dump($carrito);
    echo sizeof($carrito);
    $consulta = "INSERT INTO concepto_compra (compra,producto,nombre,iva,ieps,costo,cantidad,subtotal) VALUES(?,?,?,?,?,?,?,?)";
    for ($i = 0; $i < sizeof($carrito); $i++) {
        array_unshift($carrito[$i], $compra);
        $conexion->consultaPreparada($carrito[$i], $consulta, 1, "isssssis", false);
    }
} else if (isset($_POST['tabla']) && $_POST['tabla'] === "tabla") {

    $conexion = new Models\Conexion();
    $datos = array("A", 1, $_SESSION['negocio']);
    $consulta = "SELECT idcompras,folio_factura,nombre AS proveedor,forma_pago,fecha_factura,fecha_compra,fecha_vencimiento_factura,fecha_vencimiento_credito,
    anticipo,descuento,total,tasa_iva,metodo_pago,compras.usuariocafi, compras.estado FROM  compras INNER JOIN proveedor ON proveedor = idproveedor 
    WHERE compras.estado = ? AND compras.eliminado != ? AND compras.negocio = ?";
    echo json_encode($conexion->consultaPreparada($datos, $consulta, 2, "sii", false));
} else if (isset($_POST['idcompras']) && !isset($_POST['estado'])) {
    $conexion = new Models\Conexion();
    $datos = array($_POST['idcompras']);
    $consulta = "SELECT nombre,imagen,marca,color,unidad_medida,talla_numero,costo,cantidad FROM concepto_compra
    INNER JOIN producto ON producto = codigo_barras WHERE compra = ?";
    echo json_encode($conexion->consultaPreparada($datos, $consulta, 2, "s", false));
} else if (isset($_POST['array'])) {

    $conexion = new Models\Conexion();
    $data = json_decode($_POST['array']);
    $tipo_datos = "ii";
    $consulta = "UPDATE compras SET eliminado = ? WHERE idcompras = ?";
    for ($i = 0; $i < count($data); $i++) {
        if ($data[$i] != '0') {
            $datos = array(1, $data[$i]);
            $result =  $respuesta = $conexion->consultaPreparada($datos, $consulta, 1, $tipo_datos, false);
        }
    }
    echo $result;
} else if (isset($_POST['estado']) && isset($_POST['idcompras'])) {

    $conexion = new Models\Conexion();
    $consulta = "UPDATE compras SET estado = ? WHERE idcompras = ?";
    $datos = array($_POST['estado'], $_POST['idcompras']);
    $conexion->consultaPreparada($datos, $consulta, 1, "ss", false);
}
