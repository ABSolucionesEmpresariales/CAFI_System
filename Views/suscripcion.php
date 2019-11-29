<?php
session_start();
require_once('../Controllers/seguridadAB.php');
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

    <title>Suscripciones</title>
    <script>
      function cerrar() {
        window.close();
      }
    </script>
  </head>

  <body>
  <?php
    $sel = "suscripciones";
    include("../Controllers/NavbarAB.php")
    ?>

        <div class="contenedor container-fluid">
          <div class="row align-items-start">
            <div class="col-lg-12">
              <div id="tableContainer" class="d-block col-lg-12">
                <div class="input-group mb-2">
                  <button class="d-lg-none btn btn-primary col-12 mb-3 p-3 agregar" data-toggle="modal" data-target="#modalForm">Agregar</button>
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
                        <th class="text-nowrap text-center" onclick="sortTable(0)">Fecha Activación</th>
                        <th class="text-nowrap text-center" onclick="sortTable(1)">Fecha Vencimiento</th>
                        <th class="text-nowrap text-center" onclick="sortTable(2)">Estado</th>
                        <th class="text-nowrap text-center" onclick="sortTable(3)">Monto</th>
                        <th class="text-nowrap text-center" onclick="sortTable(4)">Paquete</th>
                        <th class="text-nowrap text-center" onclick="sortTable(5)">Usuario Extra</th>
                        <th class="text-nowrap text-center" onclick="sortTable(6)">Negocio</th>
                        <th class="text-nowrap text-center" onclick="sortTable(7)">UsuarioAB</th>
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
                  <form class="form-group" id="formulario" autocomplete="off">
                    <div id="mensaje" style="text-align: center; margin: 10px; font-weight: bold;"></div>
                    <div class="d-block d-lg-flex row">
                      <div class="col-lg-4">
                        <h5 class="general">Fecha Activación:</h5>
                        <input id="fecha_activacion" class="form form-control" onkeypress="return check(event)" type="date" name="Dfecha_activacion" placeholder="Fecha Activación" autocomplete="new-password">
                      </div>
                      <div class="col-lg-4">
                        <h5 class="general">Fecha Vencimiento:</h5>
                        <input id="fecha_vencimiento" class="form form-control" onkeypress="return check(event)" type="date" name="Dfecha_vencimiento" placeholder="Fecha Vencimiento" autocomplete="new-password">
                      </div>
                      <div class="col-lg-4">
                        <h5 class="importante">Estado del sistema:</h5>
                        <select class="form form-control" id="estado" name="Sestado">
                          <option value="A">Activo</option>
                          <option value="I">Inactivo</option>
                      </select>
                      </div>
                    </div>
                    <div class="d-block d-lg-flex row">
                      <div class="col-lg-4">
                        <h5 class="importante">Paquete:</h5>
                        <select class="form form-control" name="Spaquete" id="paquete">
                          <option value="0">Elegir</option>
                          <option value="1">Basic</option>
                          <option value="2">Standard</option>
                          <option value="3">Enterprise</option>
                        </select>
                      </div>
                      <div class="col-lg-4">
                        <h5 class="general">Usuario Extra:</h5>
                        <input id="usuario_extra" class="form form-control" type="number" value="0" min="0" onkeypress="return check(event)" name="Susuario_extra" placeholder="Usuario Extra" autocomplete="new-password" required><br>
                      </div>

                      <div class="col-lg-12 ocultar">
                        <h5 class="general">Negocio:</h5>
                        <select class="form form-control" id="negocio" name="Snegocio"></select>
                      </div>
                      <div class="col-lg-12">
                          <h5 class="general">Monto:</h5>
                          <input id="monto" class="form form-control" onkeypress="return check(event)" type="text" name="Tmonto" placeholder="Monto" autocomplete="new-password" required >
                        </div>

                        <input id="bclose" type="submit" class="mt-3 btn bg-dark text-primary btn-lg btn-block" value="Guardar">
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
        <script src="../js/user_jquery.js"></script>
        <script src="../js/suscripcion.js"></script>
      </body>

    </html>
