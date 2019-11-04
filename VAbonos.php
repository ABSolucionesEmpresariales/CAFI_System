<?php
require_once "Config/Autoload.php";
Config\Autoload::run();
session_start();
include "check_token.php";

if (!isset($_SESSION['acceso'])) {
    header('location: index.php');
} else if ($_SESSION['estado'] == "I") {
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="icon" href="img/logo/nav1.png">

    <title>Abonos</title>
</head>

<body onload="inicio(); " onkeypress="parar();" onclick="parar();">
    <?php
    $sel = "abonos";
    include("Navbar.php")
    ?>
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
                    <form class="form-group" id="formabonos">
                        <div class="row">
                            <div class="col-lg-12">
                                <h5 class="general">Estado:</h5>
                                <div class="row" style="margin: 0 auto;">
                                    <select name="estado" id="estado" class="form form-control">
                                        <option value="R">Realizado</option>
                                        <option value="C">Cancelado</option>
                                    </select>  
                                </div>
                            </div>
                            <input type="hidden" id="id" name="id">
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
    <div class="contenedor container-fluid">
        <div id="tableContainer" class="d-block col-lg-12">
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fa fa-search"></i></div>
                </div>
                <input class="form-control col-12 col-lg-4" type="text" id="busqueda" onkeypress="return check(event)" onkeyup="busqueda();" placeholder="Buscar..." title="Type in a name" value="">
            </div>
            <div style="border-radius: 10px;" class="contenedorTabla table-responsive">
                <table style="border-radius: 10px;" class="table table-bordered table-hover table-striped table-light">
                    <thead class="thead-dark">
                        <tr class="encabezados">
                            <th class="text-nowrap text-center" onclick="sortTable(0)">Estado</th>
                            <th class="text-nowrap text-center" onclick="sortTable(1)">Cantidad</th>
                            <th class="text-nowrap text-center" onclick="sortTable(2)">Pago</th>
                            <th class="text-nowrap text-center" onclick="sortTable(3)">Forma de Pago</th>
                            <th class="text-nowrap text-center" onclick="sortTable(4)">Cambio</th>
                            <th class="text-nowrap text-center" onclick="sortTable(5)">Fecha</th>
                            <th class="text-nowrap text-center" onclick="sortTable(6)">Hora</th>
                            <th class="text-nowrap text-center" onclick="sortTable(7)">Cliente</th>
                            <th class="text-nowrap text-center" onclick="sortTable(8)">Registro</th>
                            <th class="text-nowrap text-center" onclick="sortTable(9)">Adeudo</th>
                            <th class="text-nowrap text-center" onclick="sortTable(10)">Editar estado</th>
                        </tr>
                    </thead>
                    <tbody id="cuerpo">
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="js/user_jquery.js"></script>
    <script src="js/vabonos.js"></script>
    <script src="js/index.js"></script>
</body>

</html>
