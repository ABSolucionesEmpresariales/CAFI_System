<?php
session_start();
include_once '../Models/Conexion.php';
include_once '../Models/Fecha.php';

if (isset($_POST['tabla']) && $_POST['tabla'] === "tabla") {

    $conexion = new Models\Conexion();
    $datos = array($_SESSION['negocio'], 1);
    $consulta = "SELECT idventas,descuento,total,pago,cambio,forma_pago,fecha,hora,estado_venta,usuariocafi
    FROM venta WHERE negocio = ? AND eliminado != ?";
    echo json_encode($conexion->consultaPreparada($datos, $consulta, 2, "ii", false));
} else if (isset($_POST['idventa']) && !isset($_POST['forma_pago'])) {

    $conexion = new Models\Conexion();
    $datos = array($_POST['idventa']);
    $consulta = "SELECT cantidad,nombre,imagen,marca,color,unidad_medida,talla_numero,subtotal FROM producto INNER JOIN
    detalle_venta ON codigo_barras = producto INNER JOIN venta ON idventas = idventa WHERE idventa = ? ";
    echo json_encode($conexion->consultaPreparada($datos, $consulta, 2, "s", false));
} else if (isset($_POST['venta']) && isset($_POST['estado'])) {

    $conexion = new Models\Conexion();
    $datos = array($_POST['estado'], $_POST['venta']);
    $consulta = "UPDATE venta SET estado_venta = ? WHERE idventas = ?";
    echo $conexion->consultaPreparada($datos, $consulta, 1, "ss", false);
    $venta = array($_POST['venta']);
    if ($_POST['estado'] === "A") {
        actualizarStock($venta, $conexion, "+");
    } else if ($_POST['estado'] === 'I') {
        actualizarStock($venta, $conexion, "-");
    }
} else if (isset($_POST['searchproducto'])) {

    $conexion = new Models\Conexion();

    $consulta = "SELECT producto.codigo_barras,imagen,nombre,marca,modelo,color,talla_numero,unidad_medida,precio_venta,stock FROM producto INNER JOIN stock ON codigo_barras = producto
    WHERE CONCAT_WS(' ',nombre,marca,modelo,color,descripcion,talla_numero,codigo_barras) LIKE ? AND negocio = ?";

    $datos = array(
        "%" . $_POST['searchproducto'] . "%",
        $_SESSION['negocio']
    );
    echo json_encode($conexion->consultaPreparada($datos, $consulta, 2, "ss", false));
} else if (isset($_POST['searchcliente'])) {

    $conexion = new Models\Conexion();
    $consulta = "SELECT persona.email,nombre,calle_numero,colonia,localidad,municipio , telefono, estado,credito,(SELECT COUNT(idadeudos) AS total FROM adeudos
    WHERE cliente = persona.email AND estado = ? AND adeudos.eliminado != ?) AS totaladeudos FROM cliente INNER JOIN persona ON cliente.email = persona.email
      WHERE  CONCAT_WS(' ',persona.email,nombre,calle_numero,colonia,localidad,municipio,telefono,estado)  
      LIKE ? AND  negocio = ? AND persona.eliminado != ? ";
    $datos = array(
        "A",
        1,
        "%" . $_POST['searchcliente'] . "%",
        $_SESSION['negocio'],
        1
    );
    echo json_encode($conexion->consultaPreparada($datos, $consulta, 2, "sisii", false));
} else if (
    isset($_POST['idventa']) && isset($_POST['descuento'])  && isset($_POST['total']) && isset($_POST['pago']) && isset($_POST['cambio']) && isset($_POST['forma_pago'])
    && isset($_POST['json_string']) && isset($_POST['idadeudo']) && isset($_POST['totaldeuda']) && isset($_POST['anticipo']) && isset($_POST['cliente'])
) {

    //si la venta es pagada en efectivo se actualizan los datos de la tabla venta
    $conexion = new Models\Conexion();
    $fecha = new Models\Fecha();

    if ($_POST['forma_pago'] === "Efectivo" || $_POST['forma_pago'] === "Tarjeta") {
        $datos = array(
            $_POST['idventa'],
            $_POST['descuento'],
            $_POST['total'],
            $_POST['pago'],
            $_POST['cambio'],
            $_POST['forma_pago'],
            $fecha->getFecha(),
            $fecha->getHora(),
            "A",
            $_SESSION['email'],
            $_SESSION['negocio'],
            0
        );

        $consulta = "INSERT INTO venta (idventas,descuento,total,pago,cambio,forma_pago,fecha,hora,estado_venta,usuariocafi,negocio,eliminado) VALUES(?,?,?,?,?,?,?,?,?,?,?,?)";
        $conexion->consultaPreparada($datos, $consulta, 1, "sssssssssssi", false);
        $venta = $conexion->optenerId();
    } else if ($_POST['forma_pago'] === "Crédito") {
        $datos = array(
            $_POST['idventa'],
            $_POST['descuento'],
            $_POST['total'],
            $_POST['pago'],
            $_POST['cambio'],
            $_POST['forma_pago'],
            $fecha->getFecha(),
            $fecha->getHora(),
            "A",
            $_SESSION['email'],
            $_SESSION['negocio'],
            0
        );
        $consulta = "INSERT INTO venta (idventas,descuento,total,pago,cambio,forma_pago,fecha,hora,estado_venta,usuariocafi,negocio,eliminado) VALUES(?,?,?,?,?,?,?,?,?,?,?,?)";
        $conexion->consultaPreparada($datos, $consulta, 1, "sssssssssssi", false);
        $venta = $conexion->optenerId();

        $datos2 = array(
            $_POST['idadeudo'],
            $_POST['totaldeuda'],
            $_POST['anticipo'],
            "A",
            $venta,
            $_POST['cliente'], //agregar el cliente en el front
            0
        );

        $consulta = "INSERT INTO adeudos (idadeudos,totaldeuda,anticipo,estado,venta,cliente,eliminado) VALUES(?,?,?,?,?,?,?)";
        $conexion->consultaPreparada($datos2, $consulta, 1, "ssssssi", false);
    }


    $consulta = "INSERT INTO detalle_venta(idventa,producto,cantidad,subtotal) VALUES(?,?,?,?)";
    $jsonstring = $_POST['json_string'];
    $carrito = json_decode($jsonstring);

    for ($i = 0; $i < sizeof($carrito); $i++) {
        array_unshift($carrito[$i], $venta);
        $conexion->consultaPreparada($carrito[$i], $consulta, 1, "ssss", false);
    }

    $dato = array($venta);
    actualizarStock($dato, $conexion, "-");
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

function actualizarStock($dato, $conexion, $operecion)
{

    if ($operecion === "-") {

        $consulta = "SELECT (stock - cantidad) AS stock, stock.producto  FROM
        stock INNER JOIN detalle_venta ON stock.producto = detalle_venta.producto
        WHERE detalle_venta.idventa= ?";
    } else if ($operecion === "+") {

        $consulta = "SELECT (stock + cantidad) AS stock, stock.producto  FROM
        stock INNER JOIN detalle_venta ON stock.producto = detalle_venta.producto
        WHERE detalle_venta.idventa= ?";
    }


    $result = $conexion->consultaPreparada($dato, $consulta, 2, "s", false);

    $consulta = "UPDATE stock SET stock = ? WHERE producto= ? AND negocio = ?";

    if ($result != null) {
        for ($i = 0; $i < sizeof($result); $i++) {
            array_push($result[$i], $_SESSION['negocio']);
            $conexion->consultaPreparada($result[$i], $consulta, 1, "sss", false);
        }
    }
}
