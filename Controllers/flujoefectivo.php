<?php
session_start();
require_once '../Models/Conexion.php';
if (isset($_POST['tabla']) || isset($_POST['año'])) {
   
    $conexion = new Models\Conexion();
    if (!isset($_POST['año'])) {
      
        $concatenar = " ";
        $datos = array("I", 1, $_SESSION['negocio']);
        $tipo_datos = "sii";
    } else {
        
        $concatenar = "AND YEAR(fecha) = ?";
        $datos = array("I", 1,$_SESSION['negocio'], $_POST['año']);
        $tipo_datos = "siis";
    }

    $consulta = "SELECT MONTH(fecha) Mes, SUM(total) AS ingreseos_por_venta FROM venta 
 WHERE estado_venta != ? AND eliminado != ? AND negocio = ?" . $concatenar . "GROUP BY Mes";
    $resultado = $conexion->consultaPreparada($datos, $consulta, 2, $tipo_datos, false, null);

    if (sizeof($resultado) != 0) {
        $ingresos_por_venta = asignarValorAcadaMes($resultado);
    } else {
        $ingresos_por_venta =   [0 => 0, 1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0, 7 => 0, 8 => 0, 9 => 0, 10 => 0, 11 => 0];
    }

    $consulta = "SELECT MONTH(fecha) Mes, SUM(cantidad) AS otros_ingresos FROM otros_ingresos
WHERE estado != ? AND eliminado != ?  AND negocio = ?" . $concatenar . "GROUP BY Mes";
    $resultado = $conexion->consultaPreparada($datos, $consulta, 2, $tipo_datos, false, null);
    if (sizeof($resultado) != 0) {

        $otros_ingresos = asignarValorAcadaMes($resultado);
    } else {
        $otros_ingresos = [0 => 0, 1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0, 7 => 0, 8 => 0, 9 => 0, 10 => 0, 11 => 0];
    }
    $total_de_ingreso = sumarArreglos($ingresos_por_venta, $otros_ingresos);

    $consulta = "SELECT MONTH(fecha) Mes, SUM(monto) AS egresos FROM gastos 
WHERE estado != ? AND eliminado != ? AND negocio = ?" . $concatenar . "GROUP BY Mes";
    $resultado = $conexion->consultaPreparada($datos, $consulta, 2, $tipo_datos, false, null);
    if (sizeof($resultado) != 0) {
        $egresos_por_mes = asignarValorAcadaMes($resultado);
    } else {
        $egresos_por_mes = [0 => 0, 1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0, 7 => 0, 8 => 0, 9 => 0, 10 => 0, 11 => 0];
    }

    $flujo_operacional = restarArreglos($total_de_ingreso, $egresos_por_mes);
    $front = [0 => $ingresos_por_venta, 1 => $otros_ingresos, 2 => $total_de_ingreso, 3 => $egresos_por_mes, 4 => $flujo_operacional];
    echo json_encode($front);
} else if (isset($_POST['Dmes'])) {
    /* $conexion = new Models\Conexion();
    $fecha = explode("-", $_POST['Dmes']);
    $año = $fecha[0];
    $mes = $fecha[1];

    $datos = array($mes, $año, "I", 1, 3);
    $consulta = "SELECT MONTH(fecha) Mes, SUM(monto) AS egresos FROM gastos 
     WHERE MONTH(fecha) = ? AND YEAR(fecha) = ? AND estado != ? AND eliminado != ? AND negocio = ?";
    $resultado =  $conexion->consultaPreparada($datos, $consulta, 2, "sssii", false, null);
    if (sizeof($resultado) != 0) {
        $egresos_por_mes = asignarValorAcadaMes($resultado);
    } else {
        $egresos_por_mes = [];
    } */
}




function sumarArreglos($arreglo1, $arreglo2)
{
    $c = array_map(function () {
        return array_sum(func_get_args());
    }, $arreglo1, $arreglo2);
    return $c;
}


function restarArreglos($arreglo1, $arreglo2)
{
    $b = array_map(function ($objeto1, $objeto2) {
        return $objeto1 - $objeto2;
    }, $arreglo1, $arreglo2);
    return $b;
}

function asignarValorAcadaMes($resultado_consulta)
{
    $meses_del_año = [0 => 0, 1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0, 7 => 0, 8 => 0, 9 => 0, 10 => 0, 11 => 0];
    for ($i = 0; $i < sizeof($resultado_consulta); $i++) {

        switch ($resultado_consulta[$i][0]) {
            case 1:
                $meses_del_año[0] = $resultado_consulta[$i][1];
                break;
            case 2:
                $meses_del_año[1] = $resultado_consulta[$i][1];
                break;
            case 3:
                $meses_del_año[2] = $resultado_consulta[$i][1];
                break;
            case 4:
                $meses_del_año[3] = $resultado_consulta[$i][1];
                break;
            case 5:
                $meses_del_año[4] = $resultado_consulta[$i][1];
                break;
            case 6:
                $meses_del_año[5] = $resultado_consulta[$i][1];
                break;
            case 7:
                $meses_del_año[6] = $resultado_consulta[$i][1];
                break;
            case 8:
                $meses_del_año[7] = $resultado_consulta[$i][1];
                break;
            case 9:
                $meses_del_año[8] = $resultado_consulta[$i][1];
                break;
            case 10:
                $meses_del_año[9] = $resultado_consulta[$i][1];
                break;
            case 11:
                $meses_del_año[10] = $resultado_consulta[$i][1];
                break;
            case 12:
                $meses_del_año[11] = $resultado_consulta[$i][1];
                break;
        }
    }
    return $meses_del_año;
}
    
 /*  
Nuevas consultas :

Al entrar a la tabla por primera vez hace la suma de  las cantidades que se obtienen por mes desde el año que empece hasta al año actual
para filtar por año por mes , y por rango de fecha el usuario debe de proporcionar las entradas. entre mas filtro de fecha tenga mejor



sumar los resultados de cada mes con  el mes correspondiente de la siguiente consulta para obtener el total de ingreso por mes 



*/


/* 
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

        echo json_encode($datos); */
