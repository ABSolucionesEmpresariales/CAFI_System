<?php
session_start();
require_once '../Models/Conexion.php';
require_once '../Models/Fecha.php';

if (isset($_POST['tablacantidades'])) {

    $conexion = new Models\Conexion();

    $consulta = "SELECT forma_pago, SUM(total) AS totalventas FROM venta
    WHERE estado_venta = ? AND negocio = ? AND  eliminado != ? GROUP BY forma_pago";
    $datos = array("A", $_SESSION['negocio'], 1);
    $result = $conexion->consultaPreparada($datos, $consulta, 2, "sii", false,null);

    $ventas_efectivo = 0;
    $ventas_banco = 0;

    if (isset($result)) {
        for ($i = 0; $i < sizeof($result); $i++) {
            if ($result[$i][0] === "Efectivo") {
                $ventas_efectivo = $result[$i][1];
            } else if ($result[$i][0] === "Tarjeta") {
                $ventas_banco = $result[$i][1];
            }
        }
    }

    $consulta = "SELECT SUM(anticipo) AS anticipo FROM adeudos INNER JOIN venta ON venta = idventas
    WHERE estado = ? AND negocio = ? AND  adeudos.eliminado != ?";
    $result = $conexion->consultaPreparada($datos, $consulta, 2, "sii", false,null);
    $anticipos_efectivo = 0;
    if (isset($result)) {
        $anticipos_efectivo = $result[0][0];
    }


    $consulta = "SELECT forma_pago, SUM(cantidad) AS totalabonos FROM abono
    WHERE estado = ? AND negocio = ? AND  eliminado != ? GROUP BY forma_pago";
    $result = $conexion->consultaPreparada($datos, $consulta, 2, "sii", false,null);
    $abonos_efectivo = 0;
    $abonos_banco = 0;

    if (isset($result)) {
        for ($i = 0; $i < sizeof($result); $i++) {
            if ($result[$i][0] === "Efectivo") {
                $abonos_efectivo = $result[$i][1];
            } else if ($result[$i][0] === "Tarjeta") {
                $abonos_banco = $result[$i][1];
            }
        }
    }


    $ventas_efectivo = $ventas_efectivo + $abonos_efectivo + $anticipos_efectivo;
    $ventas_banco = $ventas_banco +  $abonos_banco;

    $consulta = "SELECT pago, SUM(monto) AS totalgastos FROM gastos 
    WHERE estado = ? AND negocio = ? AND  eliminado != ? GROUP BY pago";
    $result = $conexion->consultaPreparada($datos, $consulta, 2, "sii", false,null);

    $gastos_efectivo = 0;
    $gastos_tarjeta = 0;
    $gastos_transferencia = 0;

    if (isset($result)) {
        for ($i = 0; $i < sizeof($result); $i++) {
            if ($result[$i][0] === "Efectivo") {
                $gastos_efectivo = $result[$i][1];
            } else if ($result[$i][0] === "Tarjeta") {
                $gastos_tarjeta = $result[$i][1];
            } else if ($result[$i][0] === "Transferencia") {
                $gastos_transferencia =  $result[$i][1];
            }
        }
    }
    $gastos_banco = $gastos_tarjeta + $gastos_transferencia;

    $consulta = "SELECT forma_ingreso, SUM(cantidad) AS oingresos  FROM otros_ingresos
    WHERE estado = ? AND negocio = ? AND  eliminado!= ? GROUP BY forma_ingreso";
    $result = $conexion->consultaPreparada($datos, $consulta, 2, "sii", false,null);


    $otros_ingresos_efectivo = 0;
    $otros_ingresos_banco = 0;

    for ($i = 0; $i < sizeof($result); $i++) {
        if ($result[$i][0] === "Efectivo") {
            $otros_ingresos_efectivo = $result[$i][1];
        } else if ($result[$i][0] === "Banco") {
            $otros_ingresos_banco = $result[$i][1];
        }
    }

    $consulta = "SELECT tipo, SUM(cantidad) AS retiro FROM retiros
    WHERE estado = ? AND negocio = ? AND  eliminado != ?  GROUP BY tipo";
    $result = $conexion->consultaPreparada($datos, $consulta, 2, "sii", false,null);

    $retiros_efectivo = 0;
    $retiros_banco = 0;


    for ($i = 0; $i < sizeof($result); $i++) {
        if ($result[$i][0] === "Caja") {
            $retiros_efectivo = $result[$i][1];
        } else if ($result[$i][0] === "Banco") {
            $retiros_banco = $result[$i][1];
        }
    }

    $efectivo = $otros_ingresos_efectivo + $ventas_efectivo - $gastos_efectivo - $retiros_efectivo;
    $banco = $otros_ingresos_banco + $ventas_banco - $gastos_banco - $retiros_banco;

    $json = array();
    $json[] = array(
        $efectivo,
        $banco,
    );

    $jsonstring = json_encode($json);
    echo $jsonstring;
} else if (
    isset($_POST['idretiro']) && isset($_POST['Sconcepto']) && isset($_POST['Stipo']) && isset($_POST['Tcantidad'])
    && isset($_POST['TAdescripcion'])
) {

    $conexion = new Models\Conexion();
    $fecha = new Models\Fecha();

    $datos = array(
        $_POST['idretiro'],
        $_POST['Sconcepto'],
        $_POST['Stipo'],
        $_POST['Tcantidad'],
        $_POST['TAdescripcion'],
        $fecha->getFecha(),
        $fecha->getHora(),
        "A",
        $_SESSION['email'],
        $_SESSION['negocio'],
        0
    );
    $consulta = "INSERT INTO retiros (idretiro,concepto,tipo,cantidad,descripcion,
    fecha,hora,estado,usuariocafi,negocio,eliminado) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
    $result = $conexion->consultaPreparada($datos, $consulta, 1, "sssssssssii", false,null);
    echo $result;
} else if (isset($_POST['tabla']) && $_POST['tabla'] === "tabla") {

    $conexion = new Models\Conexion();
    $datos = array($_SESSION['negocio'], 1);

    $consulta = "SELECT idretiro,concepto,tipo,cantidad,descripcion,fecha,hora,estado,usuariocafi 
    FROM retiros WHERE negocio = ? AND eliminado != ?";

    echo json_encode($conexion->consultaPreparada($datos, $consulta, 2, "ii", false,null));

}else if(isset($_POST['idretiro']) && isset($_POST['Sestado'])){
    
    $conexion = new Models\Conexion();
    $datos = array($_POST['Sestado'],$_POST['idretiro']);

    $consulta = "UPDATE retiros SET estado = ? WHERE idretiro = ?";

    echo $conexion->consultaPreparada($datos, $consulta, 1, "si", false,null);

}else if (isset($_POST['array'])) {
    $conexion = new Models\Conexion();
    $data = json_decode($_POST['array']);
    $tipo_datos = "ii";
    $consulta = "UPDATE retiros SET eliminado = ? WHERE idretiro = ?";
    for ($i = 0; $i < count($data); $i++) {
        if ($data[$i] != '0') {
            $datos = array(1, $data[$i]);
            $result =  $respuesta = $conexion->consultaPreparada($datos, $consulta, 1, $tipo_datos, false,null);
        }
    }
    echo $result;
}

