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




            <div class="ml-0 ml-lg-3 input-group-prepend">
                <div class="input-group-text"><i class="fa fa-search"></i></div>
            </div>

            <input class="form-control col-12 col-lg-4" type="text" id="busqueda" onkeyup="busqueda()" onkeypress="return check(event)" placeholder="Buscar..." title="Type in a name" value="">
            <div class="col-lg-4">
              <h5 class="general">Negocio:</h5>
              <select class="form form-control" id="negocio" name="Snegocio">
                <option value="idnegocio"></option>
              </select>
            </div>

            <input type="submit" style="display: none;">


            <button class="d-none d-lg-flex btn btn-primary ml-3 agregar" data-toggle="modal" id="agregar_p" data-target="#modalForm">Agregar</button>
            <button class="d-none d-lg-flex btn btn-danger ml-3 agregar" id="Bcodigobarra"  data-toggle="modal" data-target="#modalFormCodigo">Imprimir codigo de barras</button>

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

                          <form class="form-group" enctype="multipart/form-data" id="formulario" method="post">
                            <div id="mensaje" style="text-align: center; margin: 10px; font-weight: bold;"></div>

                            <div class="d-block d-lg-flex row">
                            <div class="col-lg-4">
                                <h5 class="general" style="color: #EF5602">Codigo</h5>
                                <input id="codigo_barras" class="form form-control" onkeypress="return check(event)" type="text" name="Tcodigo_barras" placeholder="Codigo" autocomplete="new-password" required>

                              </div>
                              <div class="col-lg-4">
                                <h5 class="general">Modelo</h5>
                                <input id="modelo" class="form form-control" onkeypress="return check(event)" type="text" name="Tmodelo" placeholder="Modelo" autocomplete="new-password" >
                              </div>
                              <div class="col-lg-4">
                                <h5 class="general">Nombre:</h5>
                                <input id="nombre" class="form form-control" onkeypress="return check(event)" type="text" name="Tnombre" placeholder="Nombre" autocomplete="new-password" required>
                              </div>
                            </div>
                            <div class="d-block d-lg-flex row">
                              <div class="col-lg-4">
                                <h5 class="general">Descripción:</h5>
                                <input id="descripcion" class="form form-control" onkeypress="return check(event)" type="text" name="Tdescripcion" placeholder="Descripción" autocomplete="new-password" >
                              </div>
                                <div class="col-lg-4">
                                  <h5 class="general">Categoria:</h5>
                                  <select class="form form-control" id="categoria" name="Scategoria">
                                    <option value="A">Activa</option>
                                  </select>
                                </div>
                              <div class="col-lg-4">
                                <h5 class="general">Marca:</h5>
                                <select class="form form-control" id="marca" name="Smarca">
                                  <option value="patito">patito</option>
                                </select>
                              </div>
                            </div>
                            <div class="d-block d-lg-flex row">
                            <div class="col-lg-4">
                              <h5 class="general">Proveedor:</h5>
                              <input id="proveedor" class="form form-control" onkeypress="return check(event)" type="text" name="Tproveedor" placeholder="Proveedor" autocomplete="new-password" >
                            </div>
                              <div class="col-lg-4">
                                <h5 class="general">Color:</h5>
                                <select class="form form-control" id="color" name="Scolor">
                                  <option value="rojo">rojo</option>
                                </select>
                              </div>
                              <div class="col-lg-4">
                                <h5 class="general">Imagen:</h5>
                                <input id="imagen" class="form form-control" type="file" onkeypress="return check(event)" name="Fimagen" placeholder="imagen" autocomplete="new-password"><br>
                              </div>
                            </div>
                            <div class="d-block d-lg-flex row">
                              <div class="col-lg-5">
                                <h5 class="general">Precio compra:</h5>
                                <input id="precio_compra" class="form form-control" type="number" onkeypress="return check(event)" name="Nprecio_compra" placeholder="Precio compra" autocomplete="new-password"><br>
                              </div>

                              <div class="col-lg-5">
                                <h5 class="general">Precio venta:</h5>
                                <input id="precio_venta" class="form form-control" type="number" onkeypress="return check(event)" name="Nprecio_venta" placeholder="Precio venta" autocomplete="new-password" required><br>
                              </div>
                            </div>
                            <div class="d-block d-lg-flex row">
                              <div class="col-lg-6">
                                <h5 class="general">Unidad de medida:</h5>
                                <select class="form form-control" id="unidad_medida" name="Sunidad_medida" required>
                                  <option value="pieza">Pieza</option>
                                  <option value="par">Par</option>
                                  <option value="paquete">Paquete</option>
                                </select>
                              </div>
                              <div class="col-lg-6">
                                  <h5 class="general">Talla:</h5>
                                  <select class="form form-control" id="talla_numero" name="Stalla_numero">
                                    <option value="s">S</option>
                                    <option value="m">M</option>
                                    <option value="l">L</option>
                                    <option value="xl">XL</option>
                                  </select>
                                </div>
                            </div>
                            <div class="d-block d-lg-flex row">
                            <div class="col-lg-4">
                              <h5 class="general">Tasa IVA:</h5>
                              <input id="tasa_iva" class="form form-control" type="number" onkeypress="return check(event)" name="Ntasa_iva" placeholder="Tasa IVA" autocomplete="new-password" ><br>
                            </div>

                            <div class="col-lg-4">
                              <h5 class="general">Tasa IPES:</h5>
                              <input id="tasa_ipes" class="form form-control" type="number" onkeypress="return check(event)" name="Ntasa_ipes" placeholder="Tasa IPES" autocomplete="new-password" ><br>
                              <input type="hidden" name="accion" value="false">
                            </div>
                            <div class="col-lg-4">
                              <h5 class="general">Descuento:</h5>
                              <input id="descuento" class="form form-control" type="number" onkeypress="return check(event)" name="Ndescuento" placeholder="Descuento" autocomplete="new-password" ><br>
                            </div>

                                <input id="bclose" type="submit" class="mt-3 btn bg-dark text-primary btn-lg btn-block" value="Guardar">
                            </form>
                            <div id="tableHolder" class="row justify-content-center"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>

        <script src="../js/user_jquery.js"></script>
        <script src="../js/productos.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
      </body>

    </html>
