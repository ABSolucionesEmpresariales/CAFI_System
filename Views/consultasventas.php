<?php
session_start();
require_once('../Controllers/seguridadCafi.php');
privilegios("Todos");
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

  <title>Ventas</title>
</head>

<body>
  <?php
  $sel = "venta";
  include("../Controllers/NavbarCafi.php");
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
          <div class="mensaje" style="text-align: center; margin: 10px; font-weight: bold;"></div>
            <div class="row">
              <div class="col-12">
                <h5 class="general">Estado:</h5>

                <div class="row" style="margin: 0 auto;">
                  <select id="estado" class="form form-control">
                    <option value="A">Activa</option>
                    <option value="I">Inactiva</option>
                  </select>
                </div>
              </div>
            </div>

            <input id="bguardar" type="submit" class="mt-3 btn btn-lg btn-block btn-dark text-primary" value="Guardar">
          </form>
          <div id="tableHolder">
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal -->

  <!-- Modal -->
  <div class="modal fade" id="modalFormMostrar" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header administrador">
          <button type="button" class="close btn-danger text-white" data-dismiss="modal">
            <span aria-hidden="true">×</span>
            <span class="sr-only">Close</span>
          </button>
        </div>

        <!-- Modal Body -->
        <div class="modal-body">
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
              <th class="text-nowrap text-center d-none" onclick="sortTable(0)">Venta</th>
              <th class="text-nowrap text-center" onclick="sortTable(1)">Concepto</th>
              <th class="text-nowrap text-center" onclick="sortTable(2)">Descuento</th>
              <th class="text-nowrap text-center" onclick="sortTable(3)">Total</th>
              <th class="text-nowrap text-center" onclick="sortTable(4)">Pago</th>
              <th class="text-nowrap text-center" onclick="sortTable(5)">Forma</th>
              <th class="text-nowrap text-center" onclick="sortTable(6)">Cambio</th>
              <th class="text-nowrap text-center" onclick="sortTable(7)">Fecha</th>
              <th class="text-nowrap text-center" onclick="sortTable(8)">Hora</th>
              <th class="text-nowrap text-center" onclick="sortTable(9)">Estado</th>
              <th class="text-nowrap text-center" onclick="sortTable(10)">Trabajador</th>
              <th class="text-nowrap text-center" onclick="sortTable(11)"></th>
            </tr>
          </thead>
          <tbody id="renglones">

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
  <script src="../js/user_jquery.js"></script>
  <script src="../js/consultaventas.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>