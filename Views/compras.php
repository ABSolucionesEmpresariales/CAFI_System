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

  <title>Compras</title>
</head>

<body>
  <?php
  $sel = "compras";
  include("../Controllers/NavbarCafi.php");
  ?>

  <div class="contenedor container-fluid">
    <div id="compras" class="row align-items-start">
      <div id="tableContainer" class="d-block col-lg-12">
        <div class="input-group mb-2">
          <button class="d-lg-none btn btn-primary col-12 mb-3 p-3" data-toggle="modal" data-target="#modalForm">Agregar Compra</button>
          <?php if ($_SESSION['acceso'] == 'CEO') { ?>
            <button class="d-lg-none btn btn-danger col-12 mb-3 p-3 eliminar">Eliminar</button>
          <?php } ?>
          <div class="input-group-prepend">
            <div class="input-group-text">
              <i class="fa fa-search"></i>
            </div>
          </div>
          <input class="form-control form-control-sm col-12 col-lg-4" type="text" id="busqueda" onkeypress="return check(event)" onkeyup="busqueda()" placeholder="Buscar..." title="Type in a name" value="">
          <button id="btncompra" class="d-none d-lg-flex btn btn-primary ml-3">Agregar Compra</button>
          <?php if ($_SESSION['acceso'] == 'CEO') { ?>
            <button class="d-none d-lg-flex btn btn-danger ml-2 eliminar">Eliminar</button>
          <?php } ?>
        </div>
        <div id="tabla_compras" style="border-radius: 10px;" class="contenedorTabla table-responsive">
          <table style="border-radius: 10px;" class="scroll table table-hover table-striped table-light">
            <thead class="thead-dark">
              <tr class="encabezados">
                <?php if ($_SESSION['acceso'] == 'CEO') { ?>
                  <th class="text-nowrap text-center" onclick="sortTable(0)"><input class="check" type="checkbox" value="si"></th>
                <?php } ?>
                <th class="text-nowrap text-center d-none" onclick="sortTable(1)">Id</th>
                <th class="text-nowrap text-center" onclick="sortTable(2)">Concepto</th>
                <th class="text-nowrap text-center" onclick="sortTable(3)">Folio de factura</th>
                <th class="text-nowrap text-center" onclick="sortTable(4)">Proveedor</th>
                <th class="text-nowrap text-center" onclick="sortTable(5)">Forma de pago</th>
                <th class="text-nowrap text-center" onclick="sortTable(6)">Fecha de factura</th>
                <th class="text-nowrap text-center" onclick="sortTable(7)">Fecha de compra</th>
                <th class="text-nowrap text-center" onclick="sortTable(8)">Vencimiento factura</th>
                <th class="text-nowrap text-center" onclick="sortTable(9)">Inicio de credito</th>
                <th class="text-nowrap text-center" onclick="sortTable(10)">Vencimiento credito</th>
                <th class="text-nowrap text-center" onclick="sortTable(11)">Anticipo</th>
                <th class="text-nowrap text-center" onclick="sortTable(12)">Descuento</th>
                <th class="text-nowrap text-center" onclick="sortTable(13)">Total</th>
                <th class="text-nowrap text-center" onclick="sortTable(14)">Tasa iva</th>
                <th class="text-nowrap text-center" onclick="sortTable(15)">Metodo de pago</th>
                <th class="text-nowrap text-center" onclick="sortTable(16)">Registró</th>
                <th class="text-nowrap text-center" onclick="sortTable(16)">Estado</th>
              </tr>
            </thead>
            <tbody id="cuerpo2">
            </tbody>
          </table>
        </div>
        <!--Tabla contenedor-->
      </div>
      <!--col-7 compras-->
    </div>
    <!--row-->

    <div style="display: none" id="compra" class="row align-items-start">
      <div class="col-6">
        <p class="statusMsg"></p>
        <div class="row mb-2">
          <button id="compra_finalizada2" class="btn btn-primary mr-2 ">Guardar Compra</button>
          <button id="cancelar_compra" class="btn btn-danger">Cancelar Compra</button>
        </div>
        <form class="form-group border p-3 bg-light" id="formgastos">
          <div class="row">
            <div class="d-block col-lg-4">
              <p class="general">Folio de factura:</p>
              <input id="folio_factura" class="form-control form-control-sm" onkeypress="return check(event)" type="text" placeholder="Folio de factiracion" autocomplete="off">
            </div>
            <div class="d-block col-lg-4">
              <p class="general">Fecha de facturación:</p>
              <input class="form-control form-control-sm" id="fecha_facturacion" type="date" name="DFecha">
            </div>
            <div class="d-block col-lg-4">
              <p class="general">Fecha de vencimiento:</p>
              <input class="form-control form-control-sm" id="fecha_vencimiento" type="date" name="DFecha">
            </div>
          </div>
          <div class="row">
            <div class="d-block col-lg-4">
              <p class="general">Codigo de proveedor:</p>
              <select class="form form-control form-control-sm" id="codigo_proveedor"></select>
            </div>
            <div class="d-block col-lg-4">
              <p class="general">Nuevo proveedor:</p>
              <input id="nuevo_proveedor" class="form form-control form-control-sm" type="button" value="Nuevo proveedor">
            </div>
            <div class="d-block col-lg-4">
              <p class="general">Metodo de pago:</p>
              <select name="SPago" id="metodo_pago" class="form form-control form-control-sm">
                <option value="Efectivo">Efectivo</option>
                <option value="Tarjeta">Tarjeta</option>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="d-block col-lg-6">
              <p class="general">Descuento:</p>
              <input type="number" min="0" value="0" id="descuento" class="form form-control form-control-sm" onkeypress="return check(event)" type="text" name="TMonto" placeholder="Descuento" autocomplete="off">
            </div>
            <div class="d-block col-lg-6">
              <p class="importante">Forma de pago:</p>
              <select id="forma_de_pago" class="form form-control form-control-sm">
                <option value="">Elejir</option>
                <option value="De Contado">De Contado</option>
                <option value="Credito">Credito</option>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="fechascredito d-none col-lg-4">
              <p class="importante">Inicio del credito:</p>
              <input class="form-control form-control-sm" id="inicio_de_credito" type="date" name="DFecha">
            </div>
            <div class="fechascredito d-none col-lg-4">
              <p class="importante">Fecha vencimiento del credito:</p>
              <input class="form-control form-control-sm" id="fecha_del_credito" type="date" name="DFecha">
            </div>
            <div class="fechascredito d-none col-lg-4">
              <p class="general">Anticipo:</p>
              <input type="number" min="0" value="0" id="anticipo" class="form form-control form-control-sm" onkeypress="return check(event)" type="text" name="TMonto" placeholder="Anticipo" autocomplete="off">
            </div>
          </div>
        </form>
        <div class="border p-2 shadow bg-light">
          <div class="row">
            <div class="d-block col-lg-4">
              <p class="importante">Codigo:</p>
              <input name="" id="codigo_producto" placeholder="Codigo Producto" class="form form-control form-control-sm">
              <datalist id="lproductos">
              </datalist>
            </div>
            <div class="d-block col-lg-4">
              <p class="importante">Nombre:</p>
              <input id="nombre_producto" class="form form-control form-control-sm" onkeypress="return check(event)" type="text" name="TMonto" placeholder="Nombre Producto" autocomplete="off">
            </div>
            <div class="d-block col-lg-4">
              <p class="importante">Cantidad:</p>
              <input type="number" min="1" id="cantidad" class="form form-control form-control-sm" onkeypress="return check(event)" type="text" name="TMonto" placeholder="Cantidad" autocomplete="off">
            </div>

          </div>
          <div class="row">
          <div class="col-lg-3">
                <p class="importante">Unidad de medida:</p>
                <select class="form form-control" id="unidad_medida" name="Sunidad_medida" required>
                  <option value="">Elija</option>
                  <option value="pieza">Pieza</option>
                  <option value="par">Par</option>
                  <option value="paquete">Paquete</option>
                </select>
              </div>
            <div class="d-block col-lg-3">
              <p class="importante">Costo:</p>
              <input type="number" min="1" value="0" id="costo_producto" class="form form-control form-control-sm" onkeypress="return check(event)" type="text" name="TMonto" placeholder="Costo producto" autocomplete="off">
            </div>
            <div class="d-block col-lg-3">
              <p class="general">Ganancia %</p>
              <input type="number" min="0" value="0" id="porcentaje" class="form form-control form-control-sm" onkeypress="return check(event)" type="text" placeholder="" autocomplete="off">
            </div> 
            <div class="col-lg-3">
                <p class="importante">Precio venta:</p>
                <input id="precio_venta" value="0" class="form form-control" type="text" onkeypress="return check(event)" name="Nprecio_venta" placeholder="Precio venta" autocomplete="new-password" required><br>
              </div>
          </div>
          <div class="row justify-content-center mt-2">
            <button id="agregar_producto" class="col-4 btn btn-danger">Agregar Producto a la compra</button>
          </div>
        </div>
      </div>
      <!--col-5-->

      <div class="col-6">
        <div class="table-wrapper-compra">
          <div id="tableHolder table-responsive table-wrapper">
            <table class="table table-hover table-striped table-light">
              <thead class="thead-dark">
                <tr class="encabezados">
                  <th class="text-nowrap text-center" onclick="sortTable(0)">Accion</th>
                  <th class="text-nowrap text-center" onclick="sortTable(1)">Codigo</th>
                  <th class="text-nowrap text-center" onclick="sortTable(2)">Nombre</th>
                  <th class="text-nowrap text-center" onclick="sortTable(3)">Costo</th>
                  <th class="text-nowrap text-center" onclick="sortTable(4)">IVA</th>
                  <th class="text-nowrap text-center" onclick="sortTable(5)">IEPS</th>
                  <th class="text-nowrap text-center" onclick="sortTable(6)">Cantidad</th>
                  <th class="text-nowrap text-center" onclick="sortTable(7)">Subtotal</th>
                  <th class="text-nowrap text-center" onclick="sortTable(8)">Unidad Medida</th>
                  <th class="text-nowrap text-center" onclick="sortTable(9)">Precio venta</th>
                </tr>
              </thead>
              <tbody id="tabla_compra">

              </tbody>
            </table>
          </div>
          <!--table container-->
        </div>
        <div class="col-6 p-2 text-nowrap text-right font-weight-bold bg-dark text-white">
          <p class="mb-0">Subtotal: <span id="info_subtotal" class="text-nowrap text-center font-weight-bold">$0</span></p>
          <!-- <p class="mb-0">Descuento: <span id="info_descuento" class="text-nowrap text-center font-weight-bold">$0</span></p> -->
          <p class="mb-0">IVA: <span id="info_iva" class="text-nowrap text-center font-weight-bold">$0</span></p>
          <input type="hidden" id="info_iva2">
          <p class="mb-0">IEPS: <span id="info_ieps" class="text-nowrap text-center font-weight-bold">$0</span></p>
          <!-- <p class="mb-0">Anticipo: <span id="info_anticipo" class="text-nowrap text-center font-weight-bold">$0</span></p> -->
          <p class="mb-0">Total: <span id="info_total" class="text-nowrap text-center font-weight-bold">$0</span></p>
          <input type="hidden" id="info_total2">
        </div>
      </div>
      <!--col-6-->
    </div>
    <!--row compra-->
  </div>
  <!--container-->

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
            <div class="row">
              <div id="ocultardiv" class="contenedorTabla table-responsive">
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
                      <th>Costo</th>
                      <th>Iva</th>
                      <th>Ieps</th>
                      <th>Subtotal</th>
                    </tr>
                  </thead>

                  <tbody id="cuerpotablaconcepto">

                  </tbody>
                </table>
              </div>
            </div>
            <div id = "divformedit">
            <form  id="fmestado" class="form-group">
                    <div id ="mensaje" style="text-align: center; margin: 10px; font-weight: bold;"></div>
                        <div class="row">
                            <div class="col-lg-12">
                                <h5 class="general">Estado:</label></h5>
                                <select id="estado" class="form form-control" name="Sestado">
                                    <option value="A">Activo</option>
                                    <option value="I">Inactivo</option>
                                </select>
                            </div>
                        </div>
                        <button type="submit" style="color:#E65C00;" class="mt-3 btn btn-dark btn-lg btn-block">
                            <h6>Modificar</h6>
                        </button>
                    </form>
                    </div>
          <div id="tableHolder">
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal -->
  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="../js/index.js"></script>
  <script src="../js/user_jquery.js"></script>
  <script src="../js/compras.js"></script>
</body>

</html>