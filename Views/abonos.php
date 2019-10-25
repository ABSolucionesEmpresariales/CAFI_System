<?php
session_start();
require_once('../Controllers/seguridadCafi.php');
privilegios("Todos");
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

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

    <title>Abono</title>
    <script>
      function cerrar() {
        window.close();
      }
    </script>
  </head>

  <body onload="inicio();">
  <?php
    $sel = "abonos";
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
                  <button class="agregar d-none d-lg-flex btn btn-primary ml-3 agregar" data-toggle="modal" data-target="#modalForm">Agregar</button>
                </div>
                <div style="border-radius: 10px;" class="contenedorTabla table-responsive">
                  <table style="border-radius: 10px;" class="table table-bordered table-hover table-striped table-light">
                    <thead class="thead-dark">
                      <tr class="encabezados">
                        <th class="text-nowrap text-center" onclick="sortTable(0)">ID</th>
                        <th class="text-nowrap text-center" onclick="sortTable(1)">Estado</th>
                        <th class="text-nowrap text-center" onclick="sortTable(2)">Cantidad</th>
                        <th class="text-nowrap text-center" onclick="sortTable(3)">Pago</th>
                        <th class="text-nowrap text-center" onclick="sortTable(4)">Forma Pago</th>
                        <th class="text-nowrap text-center" onclick="sortTable(5)">Cambio</th>
                        <th class="text-nowrap text-center" onclick="sortTable(6)">Fecha</th>
                        <th class="text-nowrap text-center" onclick="sortTable(7)">Hora</th>
                        <th class="text-nowrap text-center" onclick="sortTable(8)">Usuario CAFI</th>
                        <th class="text-nowrap text-center" onclick="sortTable(9)">Adeudos</th>
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
                  <p class="statusMsg"></p>
                  <form class="form-group" id="formulario">
                    <div id="mensaje" style="text-align: center; margin: 10px; font-weight: bold;"></div>
                    <div class="d-block d-lg-flex row">
                      <div class="col-lg-4">
                        <h5 class="general">Cantidad:</h5>
                        <input id="cantidad" class="form form-control" onkeypress="return check(event)" type="number" name="Ncantidad" placeholder="Cantidad" autocomplete="new-password" required>
                      </div>
                      <div class="col-lg-4">
                        <h5 class="general">Pago:</h5>
                        <input id="pago" class="form form-control" onkeypress="return check(event)" type="number" name="Npago" placeholder="Pago" autocomplete="new-password" required>
                      </div>
                      <div class="col-lg-4">
                        <h5 class="general">Forma de pago:</h5>
                        <input id="forma_pago" class="form form-control" onkeypress="return check(event)" type="text" name="Tforma_pago" placeholder="Forma de pago" autocomplete="new-password" required>
                      </div>
                      <div class="col-lg-4">
                        <h5 class="general">Cambio:</h5>
                        <input id="cambio" class="form form-control" onkeypress="return check(event)" type="number" name="Ncambio" placeholder="Cambio" autocomplete="new-password" required>
                      </div>

                        <input id="bclose" type="submit" class="mt-3 btn bg-dark text-primary btn-lg btn-block" value="Guardar">
                      </form>
                      <div id="tableHolder" class="row justify-content-center"></div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Modal -->
        <script src="../js/user_jquery.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

      </body>

    </html>
