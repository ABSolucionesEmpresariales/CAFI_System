<?php
require_once "Config/Autoload.php";
Config\Autoload::run();
session_start();
include "check_token.php";

if (!isset($_SESSION['acceso'])) {
    header('location: index.php');
} elseif ($_SESSION['estado'] == "I") {
    header('location: index.php');
} else if (
    $_SESSION['acceso'] != "Manager" && $_SESSION['acceso'] != "Employes"
) {
    header('location: index.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/sweetalert.css">
    <link rel="icon" href="img/logo/nav1.png">
    
    <script src="js/sweetalert.js"></script>
    <script src="js/sweetalert.min.js"></script>
    <script src="js/jquery.js"></script>
    <script src="js/index.js"></script>
    <title>Ventas</title>
</head>

<body>
    <?php
    $sel = "ventas";
    include("Navbar.php")
    ?>
     <!-- Modal -->
     <div class="modal fade" id="modalForm" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header administrador">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">×</span>
                        <span class="sr-only">Close</span>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <p class="statusMsg"></p>
                    <form class="form-group" id="formConsulta">
                        <div class="row">
                            <div class="col-12">
                                <h5 class="general">Estado:</h5>

                                <div class="row" style="margin: 0 auto;">
                                            <select id="estado" class="form form-control">
                                                <option value="R">Realizado</option>
                                                <option value="C">Cancelado</option>
                                            </select>  
                                </div>
                            </div>
                            <input type="hidden" id="id" >
                            <input type="hidden" id="estadoActual">
                        </div>
                        
                        <input id="bclose" type="submit" class="mt-3 btn btn-lg btn-block btn-dark text-primary" name="submit" value="Guardar">
                    </form>
                    <div id="tableHolder">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal --> 

    <!-- Modal -->
    <div  class="modal fade" id="modalFormMostrar" role="dialog">
        <div  class="modal-dialog">
            <div  class="modal-content">
                <!-- Modal Header -->
                <div  class="modal-header administrador">
                    <button type="button" class="close btn-danger text-white" data-dismiss="modal">
                        <span aria-hidden="true">×</span>
                        <span class="sr-only">Close</span>
                    </button>
                </div>

                <!-- Modal Body -->
                <div  class="modal-body">
                    <p class="statusMsg"></p>
                    <form class="form-group" id="formConsulta">
                        <div class="row">
                                <div class="contenedorTabla table-responsive">
                                    <table class="scroll table table-hover table-striped table-light">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Cantidad</th>
                                                <th>Producto</th>
                                                <th>Imagen</th>
                                                <th>Marca</th>
                                                <th>Color</th>
                                                <th>UM</th>
                                                <th>Talla</th>
                                                <th>Subtotal</th>
                                            </tr>
                                        </thead>

                                        <tbody id="cuerpo">
                                            
                                        </tbody>
                                    </table>
                                </div>
                        </div>
                    </form>
                    <div id="tableHolder">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal --> 

    <div class="contenedor container-fluid">
        <div id="tableContainer" class="d-block col-lg-12">
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fa fa-search"></i></div>
                </div>
                <input class="form-control col-12 col-lg-4" type="text" onkeypress="return check(event)" id="busqueda" onkeyup="busqueda();" placeholder="Buscar..." title="Type in a name" value="">
            </div>
            <div style="border-radius: 10px;" class="contenedorTabla table-responsive">
                <table style="border-radius: 10px;" class="table table-hover table-striped table-light">
                    <thead class="thead-dark">
                        <tr class="encabezados">
                            <th class="text-nowrap text-center" onclick="soExplore rtTable(0)">Concepto</th>
                            <th class="text-nowrap text-center" onclick="sortTable(1)">Descuento</th>
                            <th class="text-nowrap text-center" onclick="sortTable(2)">Total</th>
                            <th class="text-nowrap text-center" onclick="sortTable(3)">Pago</th>
                            <th class="text-nowrap text-center" onclick="sortTable(4)">Forma</th>
                            <th class="text-nowrap text-center" onclick="sortTable(5)">Cambio</th>
                            <th class="text-nowrap text-center" onclick="sortTable(6)">Fecha</th>
                            <th class="text-nowrap text-center" onclick="sortTable(7)">Hora</th>
                            <th class="text-nowrap text-center" onclick="sortTable(8)">Estado</th>
                            <th class="text-nowrap text-center" onclick="sortTable(9)">Trabajador</th>
                            <th class="text-nowrap text-center" onclick="sortTable(10)"></th>
                        </tr>
                    </thead>
                    <tbody id="renglones">
                        <?php
                        $negocio = $_SESSION['idnegocio'];
                        $con = new Models\Conexion();
                        if(isset($_GET['venta'])){
                            $venta = $_GET['venta'];
                            $query = "SELECT idventas, descuento ,total , pago, forma_pago,
                            cambio, fecha, hora, estado_venta, nombre,apaterno FROM venta
                            INNER JOIN trabajador ON venta.idtrabajador = trabajador.idtrabajador
                            WHERE venta.idnegocios='$negocio' AND idventas = '$venta' ORDER BY idventas DESC";
                            $row = $con->consultaListar($query);
                        }else{
                            $query = "SELECT idventas, descuento ,total , pago, forma_pago,
                            cambio, fecha, hora, estado_venta, nombre,apaterno FROM venta
                            INNER JOIN trabajador ON venta.idtrabajador = trabajador.idtrabajador
                            WHERE venta.idnegocios='$negocio' ORDER BY idventas DESC";
                            $row = $con->consultaListar($query);
                        }

                        $con->cerrarConexion();

                        while ($renglon = mysqli_fetch_array($row)) {
                            ?>
                        <tr>
                            <td class="text-nowrap text-center"><button class="mostrar btn btn-info" data-toggle="modal" data-target="#modalFormMostrar">Mostrar</button></td>
                            <td class="text-nowrap text-center d-none"><?php echo $renglon['idventas'];  ?></td>
                            <td class="text-nowrap text-center"><?php echo $renglon['descuento']; ?></td>
                            <td class="text-nowrap text-center"><?php echo $renglon['total']; ?></td>
                            <td class="text-nowrap text-center"><?php echo $renglon['pago']; ?></td>
                            <td class="text-nowrap text-center"><?php echo $renglon['forma_pago']; ?></td>
                            <td class="text-nowrap text-center"><?php echo $renglon['cambio']; ?></td>
                            <td class="text-nowrap text-center"><?php echo $renglon['fecha']; ?></td>
                            <td class="text-nowrap text-center"><?php echo $renglon['hora']; ?></td>
                            <td class="text-nowrap text-center"><?php echo $renglon['estado_venta']; ?></td>
                            <td class="text-nowrap text-center"><?php echo $renglon['nombre'] . " " . $renglon['apaterno']; ?></td>
                            <td class="text-nowrap text-center" style="width:100px;">
                                <div class="row">
                                    <a style="margin: 0 auto;" class="btn btn-danger text-white beditar" data-toggle="modal" data-target="#modalForm" >
                                        Editar
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php  } ?>
                    </tbody>
                </table>
            </div>
            <!--Tabla contenedor-->
        </div>
        <!--col-7-->
    </div>
    <!--row-->
    </div>
    <!--container-->
    <script src="js/user_jquery.js"></script>
    <script src="js/vconsultaVentas.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>