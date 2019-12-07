<?php
session_start();
require_once('../Controllers/seguridadCafi.php');
privilegios("Todos");
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

  <head>
    <link rel="stylesheet" href="../css/sweetalert.css">
    <script src="../js/sweetalert.js"></script>
    <script src="../js/sweetalert.min.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" href="../img/logo/nav1.png">

    <title>Cuentas Por Pagar</title>
    <script>
      function cerrar() {
        window.close();
      }
    </script>
  </head>

  <body>
  <?php
    $sel = "cpp";
    include("../Controllers/NavbarCafi.php")
    ?>

        <div class="contenedor container-fluid">
          <div class="row align-items-start">
            <div class="col-lg-12">
              <div id="tableContainer" class="d-block col-lg-12">
                <div class="input-group mb-2">
                  <button class="agregar d-lg-none btn btn-primary col-12 mb-3 p-3" data-toggle="modal" data-target="#modalForm">Agregar</button>
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      <i class="fa fa-search"></i>
                    </div>
                  </div>
                  <div id="combo"></div>
                  <input class="form-control col-12 col-lg-4" type="text" id="busqueda" onkeypress="return check(event)" onkeyup="busqueda()" placeholder="Buscar..." title="Type in a name" value="">
                </div>
                <div style="border-radius: 10px;" class="contenedorTabla table-responsive">
                  <table style="border-radius: 10px;" class="table table-bordered table-hover table-striped table-light">
                    <thead class="thead-dark">
                      <tr class="encabezados">
                        <th class="text-nowrap text-center" onclick="sortTable(0)">ID</th>
                        <th class="text-nowrap text-center" onclick="sortTable(1)">Total deuda</th>
                        <th class="text-nowrap text-center" onclick="sortTable(2)">Anticipo</th>
                        <th class="text-nowrap text-center" onclick="sortTable(3)">Estado deuda</th>
                        <th class="text-nowrap text-center" onclick="sortTable(4)">Compra</th>
                        <th class="text-nowrap text-center" onclick="sortTable(5)">Proveedor</th>
                        <th class="text-nowrap text-center" onclick="sortTable(6)">Abonar</th>
                      </tr>
                    </thead>
                    <tbody id="cuerpo"></tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
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

                <form id="formulario">
                <p class="statusMsg"></p>
                    <p id="msjtarjeta" class="font-weight-bold"></p>
                   
                        <h6 >Abono:</h6>
                        <input class="inabono form form-control"  name="Tabono" onkeypress="return check(event)" type="text" placeholder="" autocomplete="off"><br>
                        <div id="divefectivo">
                        <h6 >Cantidad Recibida/Pago:</h6>
                        <input class="tpago form form-control"  type="text" name="Tcantidad" onkeypress="return check(event)" placeholder="" autocomplete="off"><br>
                        </div>

                    <input type="submit" class=" btn btn-dark text-danger font-weight-bold btn-large btn-block" value="Abonar">
                    </form>
                      <div id="tableHolder" class="row justify-content-center"></div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Modal -->
              
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script src="../js/index.js"></script>
        <script src="../js/user_jquery.js"></script>
        <script src="../js/cpp.js"></script>

      </body>

    </html>