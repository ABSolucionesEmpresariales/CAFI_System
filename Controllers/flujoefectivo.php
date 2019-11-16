<?php
session_start();
require_once '../Models/Conexion.php';
if (isset($_POST['combo']) && $_POST['combo'] === "negocio") {

    $conexion = new Models\Conexion();
    $datos = array($_SESSION['email']);
    $consulta = "SELECT idnegocios,nombre FROM negocios WHERE dueno= ?";
    echo json_encode($conexion->consultaPreparada($datos, $consulta, 2, "s", false, null));
} else if (isset($_POST['negocio'])) {
    $conexion  = new Models\Conexion();
    if ($_POST['negocio'] != "Todos") {
        $datos = array("A", 1, $_POST['negocio'], "Crédito");
        $consulta = "SELECT SUM(total) AS totalventas FROM venta 
        WHERE estado_venta = ? AND eliminado != ? AND negocio = ? AND NOT forma_pago = ?";
        $result = $conexion->consultaPreparada($datos, $consulta, 2, "siss", false, null);

        if (isset($result) && !is_null($result[0][0])) {
            $ventastotal = $result[0][0];
        } else {
            $ventastotal = 0;
        }

        $datos = array("I", 1, $_POST['negocio']);
        $consulta = "SELECT SUM(anticipo) AS anticipos FROM adeudos
        INNER JOIN venta ON adeudos.venta = venta.idventas
        WHERE  estado != ?  AND adeudos.eliminado != ? AND negocio = ?";
        $result = $conexion->consultaPreparada($datos, $consulta, 2, "sis", false, null);

        if (isset($result) && !is_null($result[0][0])) {
            $anticipos = $result[0][0];
        } else {
            $anticipos = 0;
        }

        $datos = array("A", 1, $_POST['negocio']);
        $consulta = "SELECT SUM(cantidad) AS totalabonos FROM abono WHERE estado = ? AND eliminado != ? AND negocio = ?";
        $result = $conexion->consultaPreparada($datos, $consulta, 2, "sis", false, null);

        if (isset($result) && !is_null($result[0][0])) {
            $total_abonos = $result[0][0];
        } else {
            $total_abonos = 0;
        }

        $ventas = $ventastotal + $total_abonos + $anticipos;

        $consulta = "SELECT SUM(monto) AS totalgastos  FROM gastos WHERE estado= ? AND eliminado != ? AND negocio = ?";
        $result = $conexion->consultaPreparada($datos, $consulta, 2, "sis", false, null);

        if (isset($result) && !is_null($result[0][0])) {
            $gastos = $result[0][0];
        } else {
            $gastos = 0;
        }

        $consulta = "SELECT SUM(cantidad) AS oingresos  FROM otros_ingresos WHERE estado = ? AND eliminado !=  ? AND negocio = ?";
        $result = $conexion->consultaPreparada($datos, $consulta, 2, "sis", false, null);

        if (isset($result) && !is_null($result[0][0])) {
            $otros_ingresos = $result[0][0];
        } else {
            $otros_ingresos = 0;
        }

        $consulta = "SELECT SUM(cantidad) AS retiro FROM retiros WHERE 
        estado = ? AND eliminado != ?  AND  negocio = ?";
        $result = $conexion->consultaPreparada($datos, $consulta, 2, "sis", false, null);

        if (isset($result) && !is_null($result[0][0])) {
            $retiros = $result[0][0];
        } else {
            $retiros = 0;
        }

        $efectivo = $otros_ingresos + $ventas - $gastos - $retiros;

        $consulta = "SELECT forma_pago, SUM(total) AS totalventas FROM
        venta WHERE  estado_venta = ? AND  eliminado != ? AND negocio = ? GROUP BY forma_pago ORDER BY forma_pago ASC";
        $result = $conexion->consultaPreparada($datos, $consulta, 2, "sii", false, null);

        $ventas_efectivo = 0;
        $ventas_tarjeta = 0;

        if (isset($result)) {
            for ($i = 0; $i < sizeof($result); $i++) {
                if ($result[$i][0] === "Efectivo") {
                    $ventas_efectivo = $result[$i][1];
                } else if ($result[$i][0] === "Tarjeta") {
                    $ventas_tarjeta = $result[$i][1];
                }
            }
        }

        $consulta = "SELECT forma_pago, SUM(cantidad) AS totalabonos FROM abono WHERE
        estado = ?  AND eliminado != ?  AND negocio = ? GROUP BY forma_pago ORDER BY forma_pago ASC";
        $result = $conexion->consultaPreparada($datos, $consulta, 2, "sii", false, null);

        $abonos_efectivo = 0;
        $abonos_tarjeta = 0;

        if (isset($result)) {
            for ($i = 0; $i < sizeof($result); $i++) {
                if ($result[$i][0] === "Efectivo") {
                    $abonos_efectivo = $result[$i][1];
                } else if ($result[$i][0] === "Tarjeta") {
                    $abonos_tarjeta = $result[$i][1];
                }
            }
        }

        $consulta = "SELECT SUM(adeudos.totaldeuda) AS ingresos_credito FROM 
        adeudos INNER JOIN venta ON venta=idventas WHERE adeudos.estado = ? AND adeudos.eliminado != ? AND negocio = ?";
        $result = $conexion->consultaPreparada($datos, $consulta, 2, "sis", false, null);
        if (isset($result) && !is_null($result[0][0])) {
            $ingresos_credito = $result[0][0];
        } else {
            $ingresos_credito = 0;
        }

        $ingresos_efectivo = $ventas_efectivo + $abonos_efectivo + $anticipos;
        $ingresos_banco = $ventas_tarjeta + $abonos_tarjeta;

        $consulta = "SELECT forma_ingreso, SUM(cantidad) AS total FROM otros_ingresos WHERE
        estado = ? AND eliminado != ? AND negocio = ? GROUP BY forma_ingreso ORDER BY  forma_ingreso ASC";
        $result = $conexion->consultaPreparada($datos, $consulta, 2, "sii", false, null);

        $otros_ingresos_banco = 0;
        $otros_ingresos_efectivo = 0;

        if (isset($result)) {
            for ($i = 0; $i < sizeof($result); $i++) {
                if ($result[$i][0] === "Efectivo") {
                    $otros_ingresos_efectivo = $result[$i][1];
                } else if ($result[$i][0] === "Banco") {
                    $otros_ingresos_banco = $result[$i][1];
                }
            }
        }

        $datos = array(
            "ventas" => $ventas, "otros_ingresos" => $otros_ingresos,
            "gastos" => $gastos, "retiros" => $retiros, "efectivo" => $efectivo,
            "ingresos_efectivo" => $ingresos_efectivo, "ingresos_banco" => $ingresos_banco,
            "ingresos_credito" => $ingresos_credito, "otros_ingresos_efectivo" => $otros_ingresos_efectivo,
            "otros_ingresos_banco" => $otros_ingresos_banco
        );
        echo json_encode($datos);
    } else {

        $datos = array("A", 1, $_SESSION['email'], "Crédito");
        $consulta = "SELECT SUM(total) AS totalventas FROM venta 
        INNER JOIN negocios ON idnegocios = venta.negocio
        WHERE estado_venta = ? AND venta.eliminado != ? AND negocios.dueno = ? AND NOT forma_pago = ? ";
        $result = $conexion->consultaPreparada($datos, $consulta, 2, "siss", false, null);

        if (isset($result) && !is_null($result[0][0])) {
            $ventastotal = $result[0][0];
        } else {
            $ventastotal = 0;
        }

        $datos = array("I", 1, $_SESSION['email']);
        $consulta = "SELECT SUM(anticipo) AS anticipos FROM adeudos
        INNER JOIN venta ON adeudos.venta = venta.idventas
        INNER JOIN negocios ON idnegocios = venta.negocio
        WHERE  adeudos.estado != ? AND adeudos.eliminado != ? AND negocios.dueno = ?";
        $result = $conexion->consultaPreparada($datos, $consulta, 2, "sis", false, null);

        if (isset($result) && !is_null($result[0][0])) {
            $anticipos = $result[0][0];
        } else {
            $anticipos = 0;
        }

        $datos = array("A", 1, $_SESSION['email']);
        $consulta = "SELECT SUM(cantidad) AS totalabonos FROM abono
        INNER JOIN negocios ON negocio = negocios.idnegocios
        WHERE abono.estado = ? AND eliminado != ? AND negocios.dueno = ?";
        $result = $conexion->consultaPreparada($datos, $consulta, 2, "sis", false, null);

        if (isset($result) && !is_null($result[0][0])) {
            $total_abonos = $result[0][0];
        } else {
            $total_abonos = 0;
        }

        $ventas = $ventastotal + $total_abonos + $anticipos;

        $consulta = "SELECT SUM(monto) AS totalgastos  FROM gastos
        INNER JOIN negocios ON negocio = idnegocios
        WHERE gastos.estado = ? AND eliminado != ? AND dueno = ?";
        $result = $conexion->consultaPreparada($datos, $consulta, 2, "sis", false, null);

        if (isset($result) && !is_null($result[0][0])) {
            $gastos = $result[0][0];
        } else {
            $gastos = 0;
        }

        $consulta = "SELECT SUM(cantidad) AS oingresos  FROM otros_ingresos
        INNER JOIN negocios ON negocio = idnegocios
        WHERE otros_ingresos.estado = ? AND eliminado !=  ? AND dueno = ?";
        $result = $conexion->consultaPreparada($datos, $consulta, 2, "sis", false, null);

        if (isset($result) && !is_null($result[0][0])) {
            $otros_ingresos = $result[0][0];
        } else {
            $otros_ingresos = 0;
        }

        $consulta = "SELECT SUM(cantidad) AS retiro FROM retiros
        INNER JOIN negocios ON negocio = idnegocios
        WHERE retiros.estado = ? AND eliminado != ?  AND dueno = ?";
        $result = $conexion->consultaPreparada($datos, $consulta, 2, "sis", false, null);

        if (isset($result) && !is_null($result[0][0])) {
            $retiros = $result[0][0];
        } else {
            $retiros = 0;
        }

        $efectivo = $otros_ingresos + $ventas - $gastos - $retiros;

        $consulta = "SELECT forma_pago, SUM(total) AS totalventas FROM venta 
        INNER JOIN negocios ON negocio = idnegocios
        WHERE  estado_venta = ? AND  eliminado != ? AND dueno = ? GROUP BY forma_pago ORDER BY forma_pago ASC";
        $result = $conexion->consultaPreparada($datos, $consulta, 2, "sii", false, null);

        $ventas_efectivo = 0;
        $ventas_tarjeta = 0;


        if (isset($result)) {
            for ($i = 0; $i < sizeof($result); $i++) {
                if ($result[$i][0] === "Efectivo") {
                    $ventas_efectivo = $result[$i][1];
                } else if ($result[$i][0] === "Tarjeta") {
                    $ventas_tarjeta = $result[$i][1];
                }
            }
        }

        $consulta = "SELECT forma_pago, SUM(cantidad) AS totalabonos FROM abono 
        INNER JOIN negocios ON negocio = idnegocios
        WHERE abono.estado = ?  AND eliminado != ? AND  dueno = ? GROUP BY forma_pago ORDER BY forma_pago ASC";

        $result = $conexion->consultaPreparada($datos, $consulta, 2, "sii", false, null);

        $abonos_efectivo = 0;
        $abonos_tarjeta = 0;

        if (isset($result)) {
            for ($i = 0; $i < sizeof($result); $i++) {
                if ($result[$i][0] === "Efectivo") {
                    $abonos_efectivo = $result[$i][1];
                } else if ($result[$i][0] === "Tarjeta") {
                    $abonos_tarjeta = $result[$i][1];
                }
            }
        }


        $consulta = "SELECT SUM(adeudos.totaldeuda) AS ingresos_credito FROM adeudos 
        INNER JOIN venta ON venta = idventas
        INNER JOIN negocios ON negocio = idnegocios
        WHERE adeudos.estado = ? AND adeudos.eliminado != ? AND dueno = ?";
        $result = $conexion->consultaPreparada($datos, $consulta, 2, "sis", false, null);

        if (isset($result) && !is_null($result[0][0])) {
            $ingresos_credito = $result[0][0];
        } else {
            $ingresos_credito = 0;
        }

        $ingresos_efectivo = $ventas_efectivo + $abonos_efectivo + $anticipos;
        $ingresos_banco = $ventas_tarjeta + $abonos_tarjeta;

        $consulta = "SELECT forma_ingreso, SUM(cantidad) AS total FROM otros_ingresos 
        INNER JOIN negocios ON negocio = idnegocios
        WHERE otros_ingresos.estado = ? AND otros_ingresos.eliminado != ? AND dueno = ? GROUP BY forma_ingreso ORDER BY  forma_ingreso ASC";
        $result = $conexion->consultaPreparada($datos, $consulta, 2, "sii", false, null);

        $otros_ingresos_banco = 0;
        $otros_ingresos_efectivo = 0;

        if (isset($result)) {
            for ($i = 0; $i < sizeof($result); $i++) {
                if ($result[$i][0] === "Efectivo") {
                    $otros_ingresos_efectivo = $result[$i][1];
                } else if ($result[$i][0] === "Banco") {
                    $otros_ingresos_banco = $result[$i][1];
                }
            }
        }

        $datos = array(
            "ventas" => $ventas, "otros_ingresos" => $otros_ingresos,
            "gastos" => $gastos, "retiros" => $retiros, "efectivo" => $efectivo,
            "ingresos_efectivo" => $ingresos_efectivo, "ingresos_banco" => $ingresos_banco,
            "ingresos_credito" => $ingresos_credito, "otros_ingresos_efectivo" => $otros_ingresos_efectivo,
            "otros_ingresos_banco" => $otros_ingresos_banco
        );

        echo json_encode($datos);
    }
} else if (isset($_POST['Ssucursal']) && isset($_POST['Dfecha1']) && isset($_POST['Dfecha2']) || isset($_POST['Ssucursal']) && isset($_POST['Dmes'])) {

    $conexion = new Models\Conexion();

    if ($_POST['Ssucursal'] != "Todos") {
        if (!isset($_POST['Dmes'])) {

            $datos = array($_POST['Dfecha1'], $_POST['Dfecha2'], "A", "1", $_POST['Ssucursal'], "Crédito", NULL, NULL, NULL, NULL, NULL, NULL);

            $consulta = "SELECT SUM(total) AS totalventas FROM venta 
            WHERE fecha BETWEEN ? AND ?  AND estado_venta = ? AND eliminado != ? AND negocio = ? AND NOT forma_pago = ? 
            OR MONTH(fecha) = ? AND YEAR(fecha) = ? AND estado_venta = ? AND eliminado != ? AND negocio = ? AND NOT forma_pago = ? ";
            $result = $conexion->consultaPreparada($datos, $consulta, 2, "ssssssssssss", false, null);

            if (isset($result) && !is_null($result[0][0])) {
                $ventastotal = $result[0][0];
            } else {
                $ventastotal = 0;
            }

            $datos = array($_POST['Dfecha1'], $_POST['Dfecha2'], "I", "1", $_POST['Ssucursal'], NULL, NULL, NULL, NULL, NULL);

            $consulta = "SELECT SUM(anticipo) AS anticipos FROM adeudos
            INNER JOIN venta ON adeudos.venta = venta.idventas
            WHERE  fecha BETWEEN ? AND ? AND  estado != ?  AND adeudos.eliminado != ? AND negocio = ?
            OR MONTH(fecha) = ? AND YEAR(fecha) = ? AND  estado != ?  AND adeudos.eliminado != ? AND negocio = ?";
            $result = $conexion->consultaPreparada($datos, $consulta, 2, "ssssssssss", false, null);

            if (isset($result) && !is_null($result[0][0])) {
                $anticipos = $result[0][0];
            } else {
                $anticipos = 0;
            }

            $datos = array($_POST['Dfecha1'], $_POST['Dfecha2'], "A", "1", $_POST['Ssucursal'], NULL, NULL, NULL, NULL, NULL);
        } else {

            $fecha = explode("-", $_POST['Dmes']);
            $año = $fecha[0];
            $mes = $fecha[1];
            $datos = array(NULL, NULL, NULL, NULL, NULL, NULL, $mes, $año, "A", "1", $_POST['Ssucursal'], "Crédito");

            $consulta = "SELECT SUM(total) AS totalventas FROM venta 
            WHERE fecha BETWEEN ? AND ?  AND estado_venta = ? AND eliminado != ? AND negocio = ? AND NOT forma_pago = ? 
            OR MONTH(fecha) = ? AND YEAR(fecha) = ? AND estado_venta = ? AND eliminado != ? AND negocio = ? AND NOT forma_pago = ? ";
            $result = $conexion->consultaPreparada($datos, $consulta, 2, "ssssssssssss", false, null);

            if (isset($result) && !is_null($result[0][0])) {
                $ventastotal = $result[0][0];
            } else {
                $ventastotal = 0;
            }

            $datos = array(NULL, NULL, NULL, NULL, NULL, $mes, $año, "I", "1", $_POST['Ssucursal']);

            $consulta = "SELECT SUM(anticipo) AS anticipos FROM adeudos
            INNER JOIN venta ON adeudos.venta = venta.idventas
            WHERE  fecha BETWEEN ? AND ? AND  estado != ?  AND adeudos.eliminado != ? AND negocio = ?
            OR MONTH(fecha) = ? AND YEAR(fecha) = ? AND  estado != ?  AND adeudos.eliminado != ? AND negocio = ?";
            $result = $conexion->consultaPreparada($datos, $consulta, 2, "ssssssssss", false, null);

            if (isset($result) && !is_null($result[0][0])) {
                $anticipos = $result[0][0];
            } else {
                $anticipos = 0;
            }

            $datos = array(NULL, NULL, NULL, NULL, NULL, $mes, $año, "A", "1", $_POST['Ssucursal']);
        }


        $consulta = "SELECT SUM(cantidad) AS totalabonos FROM abono   
        WHERE fecha BETWEEN ? AND ? AND  estado = ?  AND  eliminado != ? AND negocio = ?
        OR MONTH(fecha) = ? AND YEAR(fecha) = ? AND  estado = ?  AND eliminado != ? AND negocio = ?";
        $result = $conexion->consultaPreparada($datos, $consulta, 2, "ssssssssss", false, null);

        if (isset($result) && !is_null($result[0][0])) {
            $total_abonos = $result[0][0];
        } else {
            $total_abonos = 0;
        }

        $ventas = $ventastotal + $total_abonos + $anticipos;

        $consulta = "SELECT SUM(monto) AS totalgastos  FROM gastos
        WHERE  fecha BETWEEN ? AND ? AND  estado = ?  AND  eliminado != ? AND negocio = ?
        OR MONTH(fecha) = ? AND YEAR(fecha) = ? AND  estado = ?  AND eliminado != ? AND negocio = ?";
        $result = $conexion->consultaPreparada($datos, $consulta, 2, "ssssssssss", false, null);

        if (isset($result) && !is_null($result[0][0])) {
            $gastos = $result[0][0];
        } else {
            $gastos = 0;
        }

        $consulta = "SELECT SUM(cantidad) AS oingresos  FROM otros_ingresos
        WHERE  fecha BETWEEN ? AND ? AND  estado = ?  AND  eliminado != ? AND negocio = ?
        OR MONTH(fecha) = ? AND YEAR(fecha) = ? AND  estado = ? AND eliminado != ? AND negocio = ?";
        $result = $conexion->consultaPreparada($datos, $consulta, 2, "ssssssssss", false, null);

        if (isset($result) && !is_null($result[0][0])) {
            $otros_ingresos = $result[0][0];
        } else {
            $otros_ingresos = 0;
        }

        $consulta = "SELECT SUM(cantidad) AS retiro FROM retiros  
        WHERE fecha BETWEEN ? AND ? AND  estado = ?  AND  eliminado != ? AND negocio = ?
        OR MONTH(fecha) = ? AND YEAR(fecha) = ? AND  estado = ? AND eliminado != ? AND negocio = ?";
        $result = $conexion->consultaPreparada($datos, $consulta, 2, "ssssssssss", false, null);

        if (isset($result) && !is_null($result[0][0])) {
            $retiros = $result[0][0];
        } else {
            $retiros = 0;
        }

        $efectivo = $otros_ingresos + $ventas - $gastos - $retiros;

        $consulta = "SELECT forma_pago, SUM(total) AS totalventas FROM venta
        WHERE fecha BETWEEN ? AND ? AND  estado_venta = ?  AND  eliminado != ? AND negocio = ?
        OR MONTH(fecha) = ? AND YEAR(fecha) = ? AND  estado_venta = ? AND eliminado != ? AND negocio = ? GROUP BY forma_pago ORDER BY forma_pago ASC";
        $result = $conexion->consultaPreparada($datos, $consulta, 2, "ssssssssss", false, null);

        $ventas_efectivo = 0;
        $ventas_tarjeta = 0;

        if (isset($result)) {
            for ($i = 0; $i < sizeof($result); $i++) {
                if ($result[$i][0] === "Efectivo") {
                    $ventas_efectivo = $result[$i][1];
                } else if ($result[$i][0] === "Tarjeta") {
                    $ventas_tarjeta = $result[$i][1];
                }
            }
        }


        $consulta = "SELECT forma_pago, SUM(cantidad) AS totalabonos FROM abono WHERE fecha 
        BETWEEN ? AND ? AND  estado = ?  AND  eliminado != ? AND negocio = ?
        OR MONTH(fecha) = ? AND YEAR(fecha) = ? AND  estado = ? AND eliminado != ? AND negocio = ? 
        GROUP BY forma_pago ORDER BY forma_pago ASC";

        $result = $conexion->consultaPreparada($datos, $consulta, 2, "ssssssssss", false, null);

        $abonos_efectivo = 0;
        $abonos_tarjeta = 0;

        if (isset($result)) {
            for ($i = 0; $i < sizeof($result); $i++) {
                if ($result[$i][0] === "Efectivo") {
                    $abonos_efectivo = $result[$i][1];
                } else if ($result[$i][0] === "Tarjeta") {
                    $abonos_tarjeta = $result[$i][1];
                }
            }
        }


        $consulta = "SELECT SUM(adeudos.totaldeuda) AS ingresos_credito FROM 
        adeudos INNER JOIN venta ON venta=idventas
        WHERE fecha BETWEEN ? AND ? AND  estado = ?  AND  adeudos.eliminado != ? AND negocio = ?
        OR MONTH(fecha) = ? AND YEAR(fecha) = ? AND  estado = ? AND adeudos.eliminado != ? AND negocio = ?";
        $result = $conexion->consultaPreparada($datos, $consulta, 2, "ssssssssss", false, null);

        if (isset($result) && !is_null($result[0][0])) {
            $ingresos_credito = $result[0][0];
        } else {
            $ingresos_credito = 0;
        }

        $ingresos_efectivo = $ventas_efectivo + $abonos_efectivo + $anticipos;
        $ingresos_banco = $ventas_tarjeta + $abonos_tarjeta;

        $consulta = "SELECT forma_ingreso, SUM(cantidad) AS total FROM otros_ingresos WHERE
        fecha BETWEEN ? AND ? AND  estado = ?  AND  eliminado != ? AND negocio = ?
        OR MONTH(fecha) = ? AND YEAR(fecha) = ? AND  estado = ? AND eliminado != ? AND negocio = ? 
        GROUP BY forma_ingreso ORDER BY forma_ingreso ASC";
        $result = $conexion->consultaPreparada($datos, $consulta, 2, "ssssssssss", false, null);

        $otros_ingresos_banco = 0;
        $otros_ingresos_efectivo = 0;

        if (isset($result)) {
            for ($i = 0; $i < sizeof($result); $i++) {
                if ($result[$i][0] === "Efectivo") {
                    $otros_ingresos_efectivo = $result[$i][1];
                } else if ($result[$i][0] === "Banco") {
                    $otros_ingresos_banco = $result[$i][1];
                }
            }
        }

        $datos = array(
            "ventas" => $ventas, "otros_ingresos" => $otros_ingresos,
            "gastos" => $gastos, "retiros" => $retiros, "efectivo" => $efectivo,
            "ingresos_efectivo" => $ingresos_efectivo, "ingresos_banco" => $ingresos_banco,
            "ingresos_credito" => $ingresos_credito, "otros_ingresos_efectivo" => $otros_ingresos_efectivo,
            "otros_ingresos_banco" => $otros_ingresos_banco
        );

        echo json_encode($datos);
    } else {

        if (!isset($_POST['Dmes'])) {
            $datos = array($_POST['Dfecha1'], $_POST['Dfecha2'], "A", "1", $_SESSION['email'], "Crédito", NULL, NULL, NULL, NULL, NULL, NULL);

            $consulta = "SELECT SUM(total) AS totalventas FROM venta
            INNER JOIN negocios ON negocio = idnegocios
            WHERE fecha BETWEEN ? AND ?  AND estado_venta = ? AND eliminado != ? AND dueno = ? AND NOT forma_pago = ? 
            OR MONTH(fecha) = ? AND YEAR(fecha) = ? AND estado_venta = ? AND eliminado != ? AND dueno = ? AND NOT forma_pago = ?";
            $result = $conexion->consultaPreparada($datos, $consulta, 2, "ssssssssssss", false, null);

            if (isset($result) && !is_null($result[0][0])) {
                $ventastotal = $result[0][0];
            } else {
                $ventastotal = 0;
            }

            $datos =  array($_POST['Dfecha1'], $_POST['Dfecha2'], "I", "1", $_SESSION['email'], NULL, NULL, NULL, NULL, NULL);

            $consulta = "SELECT SUM(anticipo) AS anticipos FROM adeudos
            INNER JOIN venta ON adeudos.venta = venta.idventas
            INNER JOIN negocios ON negocio = idnegocios
            WHERE fecha BETWEEN ? AND ? AND  adeudos.estado != ?  AND adeudos.eliminado != ? AND dueno = ?
            OR MONTH(fecha) = ? AND YEAR(fecha) = ? AND adeudos.estado != ?  AND adeudos.eliminado != ? AND dueno = ?";
            $result = $conexion->consultaPreparada($datos, $consulta, 2, "ssssssssss", false, null);

            if (isset($result) && !is_null($result[0][0])) {
                $anticipos = $result[0][0];
            } else {
                $anticipos = 0;
            }

            $datos =  array($_POST['Dfecha1'], $_POST['Dfecha2'], "A", "1", $_SESSION['email'], NULL, NULL, NULL, NULL, NULL);
        } else {
            $fecha = explode("-", $_POST['Dmes']);
            $año = $fecha[0];
            $mes = $fecha[1];
            $datos = array(NULL, NULL, NULL, NULL, NULL, NULL, $mes, $año, "A", "1", $_SESSION['email'], "Crédito");

            $consulta = "SELECT SUM(total) AS totalventas FROM venta
            INNER JOIN negocios ON negocio = idnegocios
            WHERE fecha BETWEEN ? AND ?  AND estado_venta = ? AND eliminado != ? AND dueno = ? AND NOT forma_pago = ? 
            OR MONTH(fecha) = ? AND YEAR(fecha) = ? AND estado_venta = ? AND eliminado != ? AND dueno = ? AND NOT forma_pago = ?";
            $result = $conexion->consultaPreparada($datos, $consulta, 2, "ssssssssssss", false, null);

            if (isset($result) && !is_null($result[0][0])) {
                $ventastotal = $result[0][0];
            } else {
                $ventastotal = 0;
            }
            $datos = array(NULL, NULL, NULL, NULL, NULL, $mes, $año, "I", "1", $_SESSION['email']);
            $consulta = "SELECT SUM(anticipo) AS anticipos FROM adeudos
            INNER JOIN venta ON adeudos.venta = venta.idventas
            INNER JOIN negocios ON negocio = idnegocios
            WHERE fecha BETWEEN ? AND ? AND  adeudos.estado != ?  AND adeudos.eliminado != ? AND dueno = ?
            OR MONTH(fecha) = ? AND YEAR(fecha) = ? AND adeudos.estado != ?  AND adeudos.eliminado != ? AND dueno = ?";
            $result = $conexion->consultaPreparada($datos, $consulta, 2, "ssssssssss", false, null);

            if (isset($result) && !is_null($result[0][0])) {
                $anticipos = $result[0][0];
            } else {
                $anticipos = 0;
            }

            $datos = array(NULL, NULL, NULL, NULL, NULL, $mes, $año, "A", "1", $_SESSION['email']);
        }


        $consulta = "SELECT SUM(cantidad) AS totalabonos FROM abono
        INNER JOIN negocios ON negocio = idnegocios
        WHERE fecha BETWEEN ? AND ? AND  abono.estado = ?  AND abono.eliminado != ? AND dueno = ?
        OR MONTH(fecha) = ? AND YEAR(fecha) = ? AND  abono.estado = ?  AND abono.eliminado != ? AND dueno = ?";
        $result = $conexion->consultaPreparada($datos, $consulta, 2, "ssssssssss", false, null);

        if (isset($result) && !is_null($result[0][0])) {
            $total_abonos = $result[0][0];
        } else {
            $total_abonos = 0;
        }

        $ventas = $ventastotal + $total_abonos + $anticipos;

        $consulta = "SELECT SUM(monto) AS totalgastos  FROM gastos
        INNER JOIN negocios ON negocio = idnegocios
        WHERE  fecha BETWEEN ? AND ? AND  gastos.estado = ?  AND  gastos.eliminado != ? AND dueno = ?
        OR MONTH(fecha) = ? AND YEAR(fecha) = ? AND  gastos.estado = ? AND gastos.eliminado != ? AND dueno = ?";
        $result = $conexion->consultaPreparada($datos, $consulta, 2, "ssssssssss", false, null);

        if (isset($result) && !is_null($result[0][0])) {
            $gastos = $result[0][0];
        } else {
            $gastos = 0;
        }

        $consulta = "SELECT SUM(cantidad) AS oingresos  FROM otros_ingresos
        INNER JOIN negocios ON negocio = idnegocios
        WHERE  fecha BETWEEN ? AND ? AND  otros_ingresos.estado = ?  AND otros_ingresos.eliminado != ? AND dueno = ?
        OR MONTH(fecha) = ? AND YEAR(fecha) = ? AND  otros_ingresos.estado = ? AND otros_ingresos.eliminado != ? AND dueno = ?";
        $result = $conexion->consultaPreparada($datos, $consulta, 2, "ssssssssss", false, null);

        if (isset($result) && !is_null($result[0][0])) {
            $otros_ingresos = $result[0][0];
        } else {
            $otros_ingresos = 0;
        }

        $consulta = "SELECT SUM(cantidad) AS retiro FROM retiros
        INNER JOIN negocios ON idnegocios = negocio
        WHERE fecha BETWEEN ? AND ? AND  retiros.estado = ?  AND  retiros.eliminado != ? AND dueno = ?
        OR MONTH(fecha) = ? AND YEAR(fecha) = ? AND  retiros.estado = ? AND retiros.eliminado != ? AND dueno = ?";
        $result = $conexion->consultaPreparada($datos, $consulta, 2, "ssssssssss", false, null);

        if (isset($result) && !is_null($result[0][0])) {
            $retiros = $result[0][0];
        } else {
            $retiros = 0;
        }

        $efectivo = $otros_ingresos + $ventas - $gastos - $retiros;

        $consulta = "SELECT forma_pago, SUM(total) AS totalventas FROM venta
        INNER JOIN negocios ON negocio = idnegocios
        WHERE fecha BETWEEN ? AND ? AND  estado_venta = ?  AND  eliminado != ? AND dueno = ?
        OR MONTH(fecha) = ? AND YEAR(fecha) = ? AND  estado_venta = ? AND eliminado != ? AND dueno = ? GROUP BY forma_pago ORDER BY forma_pago ASC";
        $result = $conexion->consultaPreparada($datos, $consulta, 2, "ssssssssss", false, null);

        $ventas_efectivo = 0;
        $ventas_tarjeta = 0;

        if (isset($result)) {
            for ($i = 0; $i < sizeof($result); $i++) {
                if ($result[$i][0] === "Efectivo") {
                    $ventas_efectivo = $result[$i][1];
                } else if ($result[$i][0] === "Tarjeta") {
                    $ventas_tarjeta = $result[$i][1];
                }
            }
        }

        $consulta = "SELECT forma_pago, SUM(cantidad) AS totalabonos FROM abono
        INNER JOIN negocios ON negocio = idnegocios
        WHERE fecha BETWEEN ? AND ? AND  abono.estado = ?  AND  abono.eliminado != ? AND dueno = ?
        OR MONTH(fecha) = ? AND YEAR(fecha) = ? AND  abono.estado = ? AND abono.eliminado != ? AND dueno = ? 
        GROUP BY forma_pago ORDER BY forma_pago ASC";

        $result = $conexion->consultaPreparada($datos, $consulta, 2, "ssssssssss", false, null);

        $abonos_efectivo = 0;
        $abonos_tarjeta = 0;

        if (isset($result)) {
            for ($i = 0; $i < sizeof($result); $i++) {
                if ($result[$i][0] === "Efectivo") {
                    $abonos_efectivo = $result[$i][1];
                } else if ($result[$i][0] === "Tarjeta") {
                    $abonos_tarjeta = $result[$i][1];
                }
            }
        }

        $consulta = "SELECT SUM(adeudos.totaldeuda) AS ingresos_credito FROM adeudos 
        INNER JOIN venta ON venta=idventas
        INNER JOIN negocios ON negocio = idnegocios
        WHERE fecha BETWEEN ? AND ? AND  adeudos.estado = ?  AND  adeudos.eliminado != ? AND dueno = ?
        OR MONTH(fecha) = ? AND YEAR(fecha) = ? AND  adeudos.estado = ? AND adeudos.eliminado != ? AND dueno = ?";
        $result = $conexion->consultaPreparada($datos, $consulta, 2, "ssssssssss", false, null);

        if (isset($result) && !is_null($result[0][0])) {
            $ingresos_credito = $result[0][0];
        } else {
            $ingresos_credito = 0;
        }

        $ingresos_efectivo = $ventas_efectivo + $abonos_efectivo + $anticipos;
        $ingresos_banco = $ventas_tarjeta + $abonos_tarjeta;

        $consulta = "SELECT forma_ingreso, SUM(cantidad) AS total FROM otros_ingresos
        INNER JOIN negocios ON negocio = idnegocios 
        WHERE fecha BETWEEN ? AND ? AND  otros_ingresos.estado = ?  AND  otros_ingresos.eliminado != ? AND dueno = ?
        OR MONTH(fecha) = ? AND YEAR(fecha) = ? AND  otros_ingresos.estado = ? AND otros_ingresos.eliminado != ? AND dueno = ? 
        GROUP BY forma_ingreso ORDER BY forma_ingreso ASC";

        $result = $conexion->consultaPreparada($datos, $consulta, 2, "ssssssssss", false, null);

        $otros_ingresos_banco = 0;
        $otros_ingresos_efectivo = 0;

        if (isset($result)) {
            for ($i = 0; $i < sizeof($result); $i++) {
                if ($result[$i][0] === "Efectivo") {
                    $otros_ingresos_efectivo = $result[$i][1];
                } else if ($result[$i][0] === "Banco") {
                    $otros_ingresos_banco = $result[$i][1];
                }
            }
        }

        $datos = array(
            "ventas" => $ventas, "otros_ingresos" => $otros_ingresos,
            "gastos" => $gastos, "retiros" => $retiros, "efectivo" => $efectivo,
            "ingresos_efectivo" => $ingresos_efectivo, "ingresos_banco" => $ingresos_banco,
            "ingresos_credito" => $ingresos_credito, "otros_ingresos_efectivo" => $otros_ingresos_efectivo,
            "otros_ingresos_banco" => $otros_ingresos_banco
        );

        echo json_encode($datos);
    }
}
