<?php
session_start();
require_once '../Models/Conexion.php';
if (isset($_POST['combo']) && $_POST['combo'] === "negocio") {

    $conexion = new Models\Conexion();
    $datos = array($_SESSION['email']);
    $consulta = "SELECT idnegocios,nombre FROM negocios WHERE dueno = ?";
    echo json_encode($conexion->consultaPreparada($datos, $consulta, 2, "s", false,null));
} else if (isset($_POST['negocio'])) {

    $conexion = new Models\Conexion();
    if ($_POST['negocio'] != "Todos") {
        $datos = array("A", 1, $_POST['negocio']);
        $consulta = "SELECT SUM(total) AS ventas FROM venta WHERE estado_venta = ? AND eliminado != ? AND negocio= ?";
        $result = $conexion->consultaPreparada($datos, $consulta, 2, "sis", false,null);
        if (isset($result) && !is_null($result[0][0])) {
            $ventas = $result[0][0];
        } else {
            $ventas = 0;
        }

        $consulta = "SELECT SUM(precio_compra * stock) AS costo_venta 
        FROM producto INNER JOIN detalle_venta ON codigo_barras = detalle_venta.producto
        INNER JOIN venta ON idventa = idventas INNER JOIN stock ON codigo_barras = stock.producto
        WHERE estado_venta = ? AND venta.eliminado !=  ? AND venta.negocio = ?";
        $result = $conexion->consultaPreparada($datos, $consulta, 2, "sis", false,null);
        if (isset($result) && !is_null($result[0][0])) {
            $costo_venta = $result[0][0];
        } else {
            $costo_venta = 0;
        }
        $datos = array("ventas" => $ventas, "costo_venta" => $costo_venta, "utilidad_bruta" =>  $ventas - $costo_venta);
        echo json_encode($datos);
    } else {
        $datos = array("A", 1, $_SESSION['email']);
        $consulta = "SELECT SUM(total) AS ventas FROM venta INNER JOIN negocios ON idnegocios = negocio
        INNER JOIN usuarioscafi ON email = dueno WHERE estado_venta = ? AND eliminado != ? AND dueno = ?";

        $result = $conexion->consultaPreparada($datos, $consulta, 2, "sis", false,null);
        if (isset($result) && !is_null($result[0][0])) {
            $ventas = $result[0][0];
        } else {
            $ventas = 0;
        }

        $consulta = "SELECT SUM(precio_compra * stock) AS costo_venta 
        FROM producto INNER JOIN detalle_venta ON codigo_barras = detalle_venta.producto
        INNER JOIN venta ON idventa = idventas 
        INNER JOIN stock ON codigo_barras = stock.producto
        INNER JOIN negocios ON idnegocios = venta.negocio
        WHERE estado_venta = ? AND venta.eliminado != ? AND negocios.dueno = ?";
        $result = $conexion->consultaPreparada($datos, $consulta, 2, "sis", false,null);
        if (isset($result) && !is_null($result[0][0])) {
            $costo_venta = $result[0][0];
        } else {
            $costo_venta = 0;
        }
        $datos = array("ventas" => $ventas, "costo_venta" => $costo_venta, "utilidad_bruta" =>  $ventas - $costo_venta);
        echo json_encode($datos);
    }
} else if (isset($_POST['Ssucursal']) && isset($_POST['Dfecha1']) && isset($_POST['Dfecha2']) || isset($_POST['Ssucursal']) && isset($_POST['Dmes'])) {
    $conexion = new Models\Conexion();
    if ($_POST['Ssucursal'] != "Todos") {
        $gastos = null;
        if (!isset($_POST['Dmes'])) {
            $datos = array($_POST['Dfecha1'], $_POST['Dfecha2'], "A", "1", $_POST['Ssucursal'], NULL, NULL, NULL, NULL, NULL);
        } else {
            $fecha = explode("-", $_POST['Dmes']);
            $año = $fecha[0];
            $mes = $fecha[1];
            $datos = array($mes, $año, "A", "1", $_POST['Ssucursal'], "Articulos de Venta");
            $consulta = "SELECT SUM(monto) AS total  FROM gastos WHERE MONTH(fecha) = ? AND YEAR(fecha) = ?
            AND estado = ? AND eliminado != ? AND negocio = ? GROUP BY concepto = ? ";
            $result = $conexion->consultaPreparada($datos, $consulta, 2, "ssssss", false,null);
            if (isset($result) && !is_null($result[0][0])) {
                $gastos = $result[0][0];
            } else {
                $gatos = 0;
            }
            $datos = array(NULL, NULL, NULL, NULL, NULL, $mes, $año, "A", "1", $_POST['Ssucursal']);
        }

        $consulta = "SELECT SUM(total) AS ventas FROM venta WHERE fecha BETWEEN ? AND ?  AND estado_venta = ? AND eliminado != ? 
        AND negocio = ? OR MONTH(fecha) = ? AND YEAR(fecha) = ? AND estado_venta = ? AND eliminado != ? AND negocio = ? ";
        $result = $conexion->consultaPreparada($datos, $consulta, 2, "ssssssssss", false,null);
        if (isset($result) && !is_null($result[0][0])) {
            $ventas = $result[0][0];
        } else {
            $ventas = 0;
        }


        $consulta = "SELECT SUM(precio_compra * stock) AS costo_venta FROM producto 
        INNER JOIN detalle_venta ON codigo_barras = detalle_venta.producto
        INNER JOIN venta ON idventa = idventas INNER JOIN stock ON codigo_barras = stock.producto
        WHERE fecha BETWEEN ? AND ?  AND estado_venta = ? AND venta.eliminado != ? AND venta.negocio = ? 
        OR MONTH(fecha) = ? AND YEAR(fecha) = ? AND estado_venta = ? AND venta.eliminado != ? AND venta.negocio = ?";
        $result = $conexion->consultaPreparada($datos, $consulta, 2,  "ssssssssss", false,null);
        if (isset($result) && !is_null($result[0][0])) {
            $costo_venta = $result[0][0];
        } else {
            $costo_venta = 0;
        }

        if (!isset($_POST['Dmes'])) {
            $datos = array("ventas" => $ventas, "costo_venta" => $costo_venta, "utilidad_bruta" => $utilidad_bruta = $ventas - $costo_venta);
        } else {
            $datos = array("ventas" => $ventas, "costo_venta" => $costo_venta, "utilidad_bruta" => $utilidad_bruta = $ventas - $costo_venta, "utilidad_neta" => $utilidad_bruta - $gastos);
        }

        echo json_encode($datos);
    } else {
        $gastos = null;
        if (!isset($_POST['Dmes'])) {
            $datos = array($_POST['Dfecha1'], $_POST['Dfecha2'], "A", "1", $_SESSION['email'], NULL, NULL, NULL, NULL, NULL);
        } else {
            $fecha = explode("-", $_POST['Dmes']);
            $año = $fecha[0];
            $mes = $fecha[1];
            $datos = array($mes, $año, "A", "1", $_SESSION['email'], "Articulos de Venta");
            $consulta = "SELECT SUM(monto) AS total  FROM gastos
            INNER JOIN negocios ON idnegocios = gastos.negocio 
            WHERE MONTH(fecha) = ? AND YEAR(fecha) = ? AND gastos.estado = ? AND gastos.eliminado != ? AND dueno = ? GROUP BY concepto = ? ";
            $result = $conexion->consultaPreparada($datos, $consulta, 2, "ssssss", false,null);
            if (isset($result) && !is_null($result[0][0])) {
                $gastos = $result[0][0];
            } else {
                $gatos = 0;
            }
            $datos = array(NULL, NULL, NULL, NULL, NULL, $mes, $año, "A", "1", $_SESSION['email']);
        }
        $consulta = "SELECT SUM(total) AS ventas FROM venta 
        INNER JOIN negocios ON idnegocios = negocio
        WHERE fecha BETWEEN ? AND ?  AND estado_venta = ? AND venta.eliminado != ? 
        AND dueno = ? OR MONTH(fecha) = ? AND YEAR(fecha) = ? AND estado_venta = ? AND venta.eliminado != ? AND dueno = ?";
        $result = $conexion->consultaPreparada($datos, $consulta, 2, "ssssssssss", false,null);
        if (isset($result) && !is_null($result[0][0])) {
            $ventas = $result[0][0];
        } else {
            $ventas = 0;
        }


        $consulta = "SELECT SUM(precio_compra * stock) AS costo_venta FROM producto 
        INNER JOIN detalle_venta ON codigo_barras = detalle_venta.producto
        INNER JOIN venta ON idventa = idventas INNER JOIN stock ON codigo_barras = stock.producto
        INNER JOIN negocios ON idnegocios = venta.negocio
        WHERE fecha BETWEEN ? AND ?  AND estado_venta = ? AND venta.eliminado != ? AND negocios.dueno = ? 
        OR MONTH(fecha) = ? AND YEAR(fecha) = ? AND estado_venta = ? AND venta.eliminado != ? AND negocios.dueno = ? ";
        $result = $conexion->consultaPreparada($datos, $consulta, 2,  "ssssssssss", false,null);
        if (isset($result) && !is_null($result[0][0])) {
            $costo_venta = $result[0][0];
        } else {
            $costo_venta = 0;
        }

        if (!isset($_POST['Dmes'])) {
            $datos = array("ventas" => $ventas, "costo_venta" => $costo_venta, "utilidad_bruta" => $utilidad_bruta = $ventas - $costo_venta);
        } else {
            $datos = array("ventas" => $ventas, "costo_venta" => $costo_venta, "utilidad_bruta" => $utilidad_bruta = $ventas - $costo_venta, "utilidad_neta" => $utilidad_bruta - $gastos);
        }

        echo json_encode($datos);
    }
}
