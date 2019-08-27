<?php
require_once "Config/Autoload.php";
Config\Autoload::run();
session_start();

date_default_timezone_set("America/Mexico_City");
$año = date("Y");
$mes = date("m");
$dia = date("d");
$fecha = $año . "-" . $mes . "-" . $dia;

if (!isset($_SESSION['acceso'])) {
    header('location: index.php');
} else if ($_SESSION['estado'] == "I") {
    header('location: index.php');
} else if (
    $_SESSION['acceso'] != "Manager" && $_SESSION['acceso'] != "Employes"
) {
    header('location: OPCAFI.php');
}

//se optienen las cantidades que hay en banco y en efectivo

$con = new Models\Conexion();
$negocio = $_SESSION['idnegocio'];

$query = "SELECT forma_pago, SUM(total) AS totalventas FROM venta
WHERE estado_venta='R' AND idnegocios ='$negocio' GROUP BY forma_pago";
$result = $con->consultaListar($query);

$ventas_efectivo = 0;
$ventas_banco = 0;

while ($renglon = mysqli_fetch_array($result)) {
    if ($renglon['forma_pago'] === "Efectivo") {
        $ventas_efectivo = $renglon['totalventas'];
    } else if ($renglon['forma_pago'] === "Tarjeta") {
        $ventas_banco = $renglon['totalventas'];
    }
}
$query = "SELECT SUM(pago_minimo) AS anticipos FROM adeudos INNER JOIN venta ON adeudos.ventas_idventas=venta.idventas
WHERE negocios_idnegocios ='$negocio' AND estado_deuda = 'A'";
$result = $con->consultaRetorno($query);
$anticipos_efectivo = $result['anticipos'];

$query = "SELECT forma_pago, SUM(cantidad) AS totalabonos FROM abono
WHERE forma_pago='Efectivo' AND estado='R' AND negocios_idnegocios ='$negocio' GROUP BY forma_pago ";
$result = $con->consultaListar($query);

$abonos_efectivo = 0;
$abonos_banco = 0;

while ($renglon = mysqli_fetch_array($result)) {
    if ($renglon['forma_pago'] === "Efectivo") {
        $abonos_efectivo = $renglon['totalabonos'];
    } else if ($renglon['forma_pago'] === "Tarjeta") {
        $abonos_banco = $renglon['totalabonos'];
    }
}


$ventas_efectivo = $ventas_efectivo + $abonos_efectivo + $anticipos_efectivo;
$ventas_banco = $ventas_banco +  $abonos_banco;

$query = "SELECT pago, SUM(monto) AS totalgastos  FROM gastos WHERE pago='Efectivo' AND estado='A' AND negocios_idnegocios ='$negocio' GROUP BY pago";
$result = $con->consultaListar($query);

$gastos_efectivo = 0;
$gastos_tarjeta = 0;
$gastos_transferencia = 0;

while ($renglon = mysqli_fetch_array($result)) {
    if ($renglon['pago'] === "Efectivo") {
        $gastos_efectivo = $renglon['totalgastos'];
    } else if ($renglon['pago'] === "Tarjeta") {
        $gastos_tarjeta = $renglon['totalgastos'];
    } else if ($renglon['pago'] === "Transferencia") {
        $gastos_transferencia = $renglon['totalgastos'];
    }
}
$gastos_banco = $gastos_tarjeta + $gastos_transferencia;

$query = "SELECT forma_ingreso, SUM(cantidad) AS oingresos  FROM otros_ingresos WHERE forma_ingreso ='Efectivo'
AND estado='A' AND negocios_idnegocios ='$negocio' GROUP BY forma_ingreso";
$result = $con->consultaListar($query);

$otros_ingresos_efectivo = 0;
$otros_ingresos_banco = 0;

while ($renglon = mysqli_fetch_array($result)) {
    if ($renglon['forma_ingreso'] === "Efectivo") {
        $otros_ingresos_efectivo = $renglon['oingresos'];
    } else if ($renglon['forma_ingreso'] === "Banco") {
        $otros_ingresos_banco = $renglon['oingresos'];
    }
}

$query = "SELECT tipo, SUM(cantidad) AS retiro FROM retiros WHERE
negocios_idnegocios ='$negocio' AND estado='R' GROUP BY tipo";
$result = $con->consultaListar($query);

$retiros_efectivo = 0;
$retiros_banco = 0;

while ($renglon = mysqli_fetch_array($result)) {
    if ($renglon['tipo'] === "Caja") {
        $retiros_efectivo = $renglon['retiro'];
    } else if ($renglon['tipo'] === "Banco") {
        $retiros_banco = $renglon['retiro'];
    }
}

$efectivo = $otros_ingresos_efectivo + $ventas_efectivo - $gastos_efectivo - $retiros_efectivo;
$banco = $otros_ingresos_banco + $ventas_banco - $gastos_banco - $retiros_banco;
$con->cerrarConexion();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/sweetalert.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">

    <script src="js/sweetalert.js"></script>
    <script src="js/sweetalert.min.js"></script>
    <script src="js/jquery.js"></script>

    <title>Retiros</title>

</head>

<body onload="inicio();">
<?php include("Navbar.php") ?>
<!-- Modal -->
<div class="modal fade" id="modalForm" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">×</span>
                    <span class="sr-only">Close</span>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <p class="statusMsg"></p>
                <form class="form-group" action="#" method="post">
                    <div class="row">
                        <div class="col-6">
                            <h5><label style="color:#E65C00;" for="cant" class="badge badge-ligh">Cantidad:</label></h5>
                            <input name="TCantidad" id="cant" class="form form-control" type="text" autocomplete="off" placeholder="Ingrese la cantidad" required>
                        </div>
                        <div class="col-6">
                            <h5><label for="de" class="badge badge-ligh">De:</label></h5>
                            <select id="de" class="form form-control" name="STipo" required>
                                <option></option>
                                <option>Caja</option>
                                <option>Banco</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <h5><label for="concepto" class="badge badge-ligh">Concepto:</label></h5>
                            <select id="concepto" class="form form-control" name="SConcepto" required>
                                <option></option>
                                <option>Retiro</option>
                                <option>Corte de caja</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <h5><label for="desc" class="badge badge-ligh">Descripcion:</label></h5>
                            <textarea id="desc" name="TADescription" rows="2" class="form-control" placeholder="Agregue su descripcion"></textarea>
                        </div>
                    </div>
                    <button type="submit" style="color: #005ce6;" class="mt-3 btn btn-dark btn-lg btn-block">
                        <h6>Retirar</h6><img src="img/retiro.png">
                    </button>
                </form>
                <div id="tableHolder" class="row justify-content-center">
                    <table class="col-12 table table-hover table-responsive">
                        <thead class="thead-dark">
                            <tr class="encabezados">
                                <th>Saldo en caja</th>
                                <th>Saldo en banco</th>
                            </tr>
                        </thead>
                        <tbody>
                            <td>$<?php echo $efectivo; ?></td>
                            <td>$<?php echo $banco; ?></td>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->

<div class="contenedor container-fluid">
    <div class="row align-items-start">
        <!-- <div id="formulario" class="d-none d-lg-flex col-lg-4 card card-body">

        </div> -->
            <div id="tableContainer" class="d-block col-lg-12">
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fa fa-search"></i></div>
                    </div>
                    <input class="form-control col-12 col-lg-4" type="text" id="busqueda" onkeyup="busqueda()" placeholder="Buscar..." title="Type in a name">
                    <button class="btn btn-danger ml-3" data-toggle="modal" data-target="#modalForm">Retirar</button>
                </div>
                <div class="contenedorTabla">
                    <table class="scroll table width="100%" table-bordered table-hover fixed_headers table-responsive">
                        <thead class="thead-dark">
                            <tr class="encabezados">
                                <th onclick="sortTable(0)">Concepto</th>
                                <th onclick="sortTable(1)">De</th>
                                <th onclick="sortTable(2)">Cantidad</th>
                                <th onclick="sortTable(3)">Descripcion</th>
                                <th onclick="sortTable(4)">Fecha</th>
                                <th onclick="sortTable(5)">Hora</th>
                                <th onclick="sortTable(6)">Estado</th>
                                <th onclick="sortTable(7)">Retiró</th>
                                <th onclick="sortTable(8)">Tarea</th>
                            </tr>
                <tbody>
                    <?php
                    if (isset($_GET['idedit'])) {
                        $id = $_GET['idedit'];
                        $negocio = "";
                    } else {
                        $id = "";
                    }
                    $con = new Models\Conexion();
                    $query = "SELECT idretiro,concepto,tipo,cantidad,descripcion,fecha,hora,retiros.estado,nombre,apaterno FROM retiros INNER JOIN trabajador ON retiros.trabajador_idtrabajador=trabajador.idtrabajador
                    WHERE retiros.negocios_idnegocios ='$negocio' AND retiros.fecha='$fecha' OR idretiro = '$id' ORDER BY idretiro DESC";
                    $row = $con->consultaListar($query);
                    $con->cerrarConexion();

                    while ($renglon = mysqli_fetch_array($row)) {
                        ?>
                    <tr>
                        <td><?php echo $renglon['concepto']; ?></td>
                        <td><?php echo $renglon['tipo']; ?></td>
                        <td><?php echo $renglon['cantidad']; ?></td>
                        <td><?php if (strlen($renglon['descripcion']) == 0) {
                                    echo "Sin descripcion";
                                } else {
                                    echo $renglon['descripcion'];
                                } ?></td>
                        <td><?php echo $renglon['fecha']; ?></td>
                        <td><?php echo $renglon['hora']; ?></td>
                        <td><?php echo $renglon['estado']; ?></td>
                        <td><?php echo $renglon['nombre'] . " " . $renglon['apaterno']; ?></td>
                        <td style="width:100px;">
                            <div class="row">
                                <a style="margin: 0 auto;" class="btn btn-secondary" href="VEditRetiros.php?id=<?php echo $renglon['idretiro']; ?>&estado=<?php echo $renglon['estado']; ?>">
                                    <img src="img/edit.png">
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
    </div>
</div>

</div>

    <?php
    function retirar($concepto, $tipo, $cantidad, $descripcion)
    {
        $retiro = new Models\Retiro();
        $retiro->setConcepto($concepto);
        $retiro->setTipo($tipo);
        $retiro->setCantidad($cantidad);
        $retiro->setDescripcion($descripcion);
        $retiro->setFecha();
        $retiro->setHora();
        $retiro->setEstado("R");
        $retiro->setNegocio($_SESSION['idnegocio']);
        $retiro->setTrabajador($_SESSION['id']);
        $result = $retiro->guardar();
        if ($result === 1) {
            ?>
    <script>
        swal({
                title: 'Exito',
                text: 'Se han registrado los datos exitosamente!',
                type: 'success'
            },
            function(isConfirm) {
                if (isConfirm) {
                    window.location.href = "VRetiros.php";
                }
            });
    </script>

    <?php } else {
            ?>
    <script>
        swal({
                title: 'Error',
                text: 'No se han guardado los datos',
                type: 'error'
            },
            function(isConfirm) {
                if (isConfirm) {
                    window.location.href = "VRetiros.php";
                }
            });
    </script>
    <?php }
    }
    if (isset($_POST['SConcepto']) && isset($_POST['STipo']) && isset($_POST['TCantidad'])) {
        //se optiene los datos ingresados por el usuario
        $cantidad = $_POST['TCantidad'];
        $concepto = $_POST['SConcepto'];
        $tipo = $_POST['STipo'];
        $descripcion = $_POST['TADescription'];

        //se condiciona que sea imposible que el usuario quiera realizar un corte de caja de banco
        if ($concepto === "Corte de caja" && $tipo === "Banco") {
            //se compara que la cantidad a retirar en efectivo no sea superior a la cantidad en en efectivo que hay en caja
            ?>
    <script>
        swal({
            title: 'Error',
            text: 'No es posible realizar un corte de caja de banco',
            type: 'error'
        });
    </script>
    <?php } else {
            if ($tipo === "Caja" && $cantidad <= $efectivo) {
                retirar($concepto, $tipo, $cantidad, $descripcion);
            } else if ($tipo === "Caja" && $cantidad > $efectivo) {
                ?>
    <script>
        swal({
            title: 'Error',
            text: 'Saldo insuficiente en caja',
            type: 'error'
        });
    </script>
    <?php   } else if ($tipo === "Banco" && $cantidad <= $banco) {
                //se compara que la cantidad a retirar en banco no sea superior a la cantidad que hay en banco
                retirar($concepto, $tipo, $cantidad, $descripcion);
            } else if ($tipo === "Banco" && $cantidad > $banco) {
                ?>
    <script>
        swal({
            title: 'Error',
            text: 'Saldo insuficiente en banco',
            type: 'error'
        });
    </script>
    <?php }
        }
    }
    ?>
    <script src="js/user_jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>
