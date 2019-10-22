<?php
session_start();
require_once('../Controllers/seguridadCafi.php');
privilegios("Superiores");
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

    <title>Productos</title>
    <script>
      function cerrar() {
        window.close();
      }
    </script>
  </head>

  <body onload="inicio();">
  <?php
    $sel = "usuarios";
    include("../Controllers/NavbarCafi.php")
    ?>

  <div class="contenedor container-fluid">
  <div class="row align-items-start">
  <div id="tableContainer" class="d-block col-lg-12">


    <div class="row col-12">
        <div class="input-group mb-2">
          <div class="row col-12">
            <button class="d-lg-none btn btn-primary col-6 mb-3 p-3 agrega mostra" data-toggle="modal" data-target="#modalForm">Agregar Productos</button>
            <button class="d-lg-none btn btn-danger col-6 mb-3 p-3 agrega mostra" id="BcodigoBarra"  data-toggle="modal" data-target="#modalFormCodigo">Imprimir Codigos</button>
              <p id="stockrequerido"></p>
          </div>

          <select class="form form-control sucursal col-6 col-lg-2" name="Snegocio">
              <?php
              $negocios = $_SESSION['idnegocios'];
              $con = new Models\Conexion();
              $query = "SELECT nombre, idnegocios FROM negocios
              WHERE usuarioscafi = (SELECT Manager AS CEO FROM negocios WHERE negocios.idnegocios='$negocio')";
              $row = $con->consultaListar($query);
              $con->cerrarConexion();
              $cont = 0;
              while ($renglon = mysqli_fetch_array($row)) {
                  echo "<option value =".$renglon['idnegocios'].">" . $renglon['nombre_negocio'] . "</option>";
              }
              ?>
          </select>


            <div class="ml-0 ml-lg-3 input-group-prepend">
                <div class="input-group-text"><i class="fa fa-search"></i></div>
            </div>
            <input class="form-control col-12 col-lg-4" type="text" id="busqueda" onkeyup="busqueda()" onkeypress="return check(event)" placeholder="Buscar..." title="Type in a name" value="">

            <input type="hidden" id="negocioActual" value=<?php echo  $_SESSION['idnegocios'];?>>
            <input type="submit" style="display: none;">


            <button class="d-none d-lg-flex btn btn-primary ml-5 agregar" data-toggle="modal" id="agregar_p" data-target="#modalForm">Agregar</button>
            <button class="d-none d-lg-flex btn btn-danger ml-5 agregar" id="Bcodigobarra"  data-toggle="modal" data-target="#modalFormCodigo">Imprimir codigo de barras</button>
            <div class="col-lg-4">
              <h5 class="general">Negocio:</h5>
              <select class="form form-control" id="negocio" name="Snegocio">
                <option value="idnegocio"></option>
              </select>
            </div>
        </div>
      </div>

                <div style="border-radius: 10px;" class="contenedorTabla table-responsive">
                  <table style="border-radius: 10px;" class="table table-bordered table-hover table-striped table-light">
                    <thead class="thead-dark">
                      <tr class="encabezados">
                        <th class="text-nowrap text-center" onclick="sortTable(0)">Codigo de barras</th>
                        <th class="text-nowrap text-center" onclick="sortTable(1)">Modelo</th>
                        <th class="text-nowrap text-center" onclick="sortTable(2)">Nombre</th>
                        <th class="text-nowrap text-center" onclick="sortTable(3)">Descripción</th>
                        <th class="text-nowrap text-center" onclick="sortTable(4)">Categoria</th>
                        <th class="text-nowrap text-center" onclick="sortTable(5)">Marca</th>
                        <th class="text-nowrap text-center" onclick="sortTable(6)">Proveedor</th>
                        <th class="text-nowrap text-center" onclick="sortTable(7)">Color</th>
                        <th class="text-nowrap text-center" onclick="sortTable(8)">Imagen</th>
                        <th class="text-nowrap text-center" onclick="sortTable(9)">Precio compra</th>
                        <th class="text-nowrap text-center" onclick="sortTable(10)">Precio venta</th>
                        <th class="text-nowrap text-center" onclick="sortTable(11)">Descuento</th>
                        <th class="text-nowrap text-center" onclick="sortTable(12)">Unidad de medida</th>
                        <th class="text-nowrap text-center" onclick="sortTable(13)">Tasa de iva</th>
                        <th class="text-nowrap text-center" onclick="sortTable(14)">Tasa de ipes</th>
                        <th class="text-nowrap text-center" onclick="sortTable(15)">Talla numero</th>
                      </tr>
                    </thead>
                    <tbody id="cuerpo"></tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>

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

                              <?php include("../Producto-Frontend/formularioproducto.php"); ?>

                          <div id="tableHolder" class="row justify-content-center">

                          </div>
                      </div>
                  </div>
              </div>
          </div>
          <!-- Modal -->

                  <!-- Modal -->
                  <div class="f fade" id="modalFormCodigo" role="dialog">
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
                          <div class="row justify-content-center">
                              <form action="codigoBarras.php" method="POST" target="_blank">
                              <div class="col-12">
                                  <p>Ingrese la cantidad que desea imprimir (Se imprimiran todos los productos que esten en inventario)</p>
                                  <div class="tab-content" id="myTabContent">
                                      <p class="general">Cantidad:</p>
                                      <input type="num" name="cantidad">
                                      <input class="btn btn-danger" type="submit" value="Imprimir">
                                  </div>
                                  </form>
                              </div>
                          </div>
                          <div id="tableHolder" class="row justify-content-center">

                          </div>
                      </div>
                  </div>
              </div>
          </div>
          <!-- Modal -->



        <script src="../js/user_jquery.js"></script>
        <script src="../js/productos.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
      </body>

    </html>
