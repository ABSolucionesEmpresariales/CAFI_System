<?php
session_start();
require_once('../Controllers/seguridadCafi.php');
privilegios("Master");
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="../css/bootstrap.css">
  <link rel="stylesheet" href="../css/sweetalert.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="../css/style.css">
  <link rel="icon" href="img/logo/nav1.png">

  <script src="../js/sweetalert.js"></script>
  <script src="../js/sweetalert.min.js"></script>
  <script src="../js/jquery.js"></script>
  <script src="../js/index.js"></script>
    <title>Estado Resultados</title>

</head>

<body>
    <?php
    $sel = "edr";
    include("../Controllers/NavbarCafi.php");
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
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="nav-Producto-tab" data-toggle="tab" href="#Producto" role="tab" aria-controls="Producto" aria-selected="false">Rango de Fecha</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="nav-Inventario-tab" data-toggle="tab" href="#Inventario" role="tab" aria-controls="Inventario" aria-selected="true">Mes</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="Producto" role="tabpanel" aria-labelledby="Producto-tab">
                                    <div class="col-12"><br>
                                        <form id="form1">
                                            <h5><label for="negocio" style="margin: 0 auto;" class="badge badge-info">Negocio:</label></h5>
                                            <select class="form form-control combosucursal" name="Ssucursal">
                                                
                                            </select> <br>
                                            <fieldset class="border p-2">
                                                <legend class="w-auto">
                                                    <h6>FECHA 1 - FECHA 2</h6>
                                                </legend>
                                                <h5><label for="fecha1" style="margin: 0 auto;" class="badge badge-primary">De:</label></h5>
                                                <input id="fecha1" class="form-control" type="date" name="Dfecha1">
                                                <br>
                                                <h5><label for="fecha2" style="margin: 0 auto;" class="badge badge-success">A:</label></h5>
                                                <input id="fecha2" class="form-control" type="date" name="Dfecha2">
                                            </fieldset><br>
                                            <input id="bform1" type="submit" class="btn btn-secondary btn-lg btn-block btn-dark" name="" value="Consultar">
                                        </form>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="Inventario" role="tabpanel" aria-labelledby="Inventario-tab">
                                    <div class="col-12">
                                        <br>
                                        <form id="form2">
                                            <h5><label for="negocio" style="margin: 0 auto;" class="badge badge-info">Negocio:</label></h5>
                                            <select class="form form-control combosucursal" name="Ssucursal">
                                            </select> <br>
                                            <h5><label for="inmes" style="margin: 0 auto;" class="badge badge-primary">Mes:</label></h5>
                                            <input id="inmes" class="form-control" type="month" name="Dmes"><br>
                                            <input type="submit" class="btn btn-secondary btn-lg btn-block btn-dark" name="" value="Consultar">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="tableHolder" class="row justify-content-center">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="contenedor container-fluid">
        <button class="btn btn-primary ml-3" data-toggle="modal" data-target="#modalForm">Consultar</button>
            <select id="sucursal" class="form form-control combosucursal" name="SNegocio">
            </select>
        <div style="margin: 0 auto; margin-top:10px;" class="col-md-8">

            <table class="table table-bordered">

                <thead>
                    <tr id="rowencabezado">
                      
                    </tr>
                </thead>
                <tbody id="cuerpo">
                   
                </tbody>
            </table>
        </div>
    </div>
    </div>
    </div>
    <script src="../js/estadoresultados.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>