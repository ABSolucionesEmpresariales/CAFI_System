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
    $result = $conexion->consultaPreparada($datos, $consulta, 1, "sssssssssssssssssi", false,null);
    $compra = $conexion->optenerId();
    $jsonstring = $_POST['arraycarrito'];
    $carrito = json_decode($jsonstring);
    $consulta3 = "INSERT INTO concepto_compra (compra,producto,nombre,iva,ieps,costo,cantidad,subtotal) VALUES(?,?,?,?,?,?,?,?)";
    if($result == 1){
        for ($i = 0; $i < sizeof($carrito); $i++) {
            array_unshift($carrito[$i], $compra);
            $result = $conexion->consultaPreparada($carrito[$i], $consulta, 1, "isssssis", false,null);
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
    $tipo_datos = "ii";
    $consulta = "UPDATE compras SET eliminado = ? WHERE idcompras = ?";
    for ($i = 0; $i < count($data); $i++) {
        if ($data[$i] != '0') {
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
                    $datos3 = array(1,$result3[0][0]);
                    $consulta3 = "UPDATE abono_compras SET eliminado = ? WHERE compra = ?";
                    $result = $conexion->consultaPreparada($datos3, $consulta3, 1,'ii', false,null);  
                }
            }
        }
    }
    echo $result;
} else if (isset($_POST['estado']) && isset($_POST['idcompras'])) {

    $conexion = new Models\Conexion();
    $consulta = "UPDATE compras SET estado = ? WHERE idcompras = ?";
    $datos = array($_POST['estado'], $_POST['idcompras']);
    echo $conexion->consultaPreparada($datos, $consulta, 1, "ss", false,null);
}

if(isset($_POST['producto'])){
    $conexion = new Models\Conexion();
    $consulta = "SELECT codigo_barras,nombre FROM producto p INNER JOIN stock s ON s.producto = p.codigo_barras WHERE s.negocio = ?";
    $datos = array($_SESSION['negocio']);
    echo json_encode($conexion->consultaPreparada($datos, $consulta,2, "i", false,null));
}
