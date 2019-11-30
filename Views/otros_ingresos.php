<?php
session_start();
require_once('../Controllers/seguridadCafi.php');
privilegios("Superiores");
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

    <title>Otros ingresos</title>
    <script>
      function cerrar() {
        window.close();
      }
    </script>
  </head>

  <body>

  <?php
    $sel = "ingresos";
    include("../Controllers/NavbarCafi.php");
    ?>


        <div class="contenedor container-fluid">
          <div class="row align-items-start">
            <div class="col-lg-12">
              <div id="tableContainer" class="d-block col-lg-12">
                <div class="input-group mb-2">
                  <button class="agregar d-lg-none btn btn-primary col-12 mb-3 p-3" data-toggle="modal" data-target="#modalForm">Agregar</button>
                  
                  <?php if($_SESSION['acceso'] == 'CEO'){?>
                    <button class="d-lg-none btn btn-danger col-12 mb-3 p-3 eliminar">Eliminar</button>
                  <?php } ?>
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      <i class="fa fa-search"></i>
                    </div>
                  </div>
                  <div id="combo"></div>
                  <input class="form-control col-12 col-lg-4" type="text" id="busqueda" onkeypress="return check(event)" onkeyup="busqueda()" placeholder="Buscar..." title="Type in a name" value="">
                  <button class="agregar d-none d-lg-flex btn btn-primary ml-3" data-toggle="modal" data-target="#modalForm">Agregar</button>

                  <?php if($_SESSION['acceso'] == 'CEO'){?>
                    <button class="d-none d-lg-flex btn btn-danger ml-2 eliminar">Eliminar</button>
                  <?php } ?>
                          

                </div>
                <div style="border-radius: 10px;" class="contenedorTabla table-responsive">
                  <table style="border-radius: 10px;" class="table table-bordered table-hover table-striped table-light">
                    <thead class="thead-dark">
                      <tr class="encabezados">
                      <?php if($_SESSION['acceso'] == 'CEO'){?>
                          <th class="text-nowrap text-center" onclick="sortTable(0)"><input class="check" type="checkbox" value="si"></th>
                          <?php } ?>
                        <th class="text-nowrap text-center d-none" onclick="sortTable(1)">ID</th>
                        <th class="text-nowrap text-center" onclick="sortTable(2)">Cantidad</th>
                        <th class="text-nowrap text-center" onclick="sortTable(3)">Tipo</th>
                        <th class="text-nowrap text-center" onclick="sortTable(4)">Forma de ingreso</th>
                        <th class="text-nowrap text-center" onclick="sortTable(5)">Fecha</th>
                        <th class="text-nowrap text-center" onclick="sortTable(6)">Estado</th>
                        <th class="text-nowrap text-center" onclick="sortTable(7)">Usuario CAFI</th>
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
                    <div id="hideedit">
                            <div class="row">
                                <div class="col-lg-6">
                                    <h5 class="importante">Cantidad:</h5>
                                    <input id="cantidad" name="Tcantidad" class="form form-control" onkeypress="return check(event)" type="text" placeholder="" autocomplete="off">
                                </div>
                                <div class="col-lg-6">
                                    <h5 class="importante">Tipo :</h5>
                                    <select id="tipo" name="Stipo" id="concepto" class="form form-control" >
                                        <option value="">Elegir</option>
                                        <option>Dinero a caja</option>
                                        <option>Capital Externo</option>
                                        <option>Prestamo</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <h5 class="importante">Forma de Ingreso :</h5>
                                    <select name="Sforma_ingreso" id="forma_ingreso" class="form form-control" >
                                        <option value="">Elegir</option>
                                        <option>Efectivo</option>
                                        <option>Banco</option>
                                    </select> <br>
                                </div>
                                <div class="col-lg-6">
                                    <h5 class="importante">Fecha :</h5>
                                    <input class="form-control" id="fecha" type="date" name="Dfecha" >
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h5 class="importante">Estatus:</h5>
                                <select class="form form-control" id="estado" name="Sestado">
                                    <option value="A">Activo</option>
                                    <option value="I">Inactivo</option>
                                </select>  
                            </div>
                        </div>
                        <input type="submit" class="mt-3 btn btn-lg btn-block btn-dark text-white" name="" value="Guardar">
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
              <script src="../js/otros_ingresos.js"></script>

      </body>

    </html>
