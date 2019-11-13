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
                    <?php if($_SESSION['acceso'] == 'CEO'){?>
                        <button class="d-lg-none btn btn-danger col-12 mb-3 p-3 eliminar">Eliminar</button> 
                    <?php } ?>
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="fa fa-search"></i>
                        </div>
                    </div>
                    <input class="form-control form-control-sm col-12 col-lg-4" type="text" id="busqueda" onkeypress="return check(event)" onkeyup="busqueda()" placeholder="Buscar..." title="Type in a name" value="">
                    <button id="btncompra" class="d-none d-lg-flex btn btn-primary ml-3">Agregar Compra</button>
                    <?php if($_SESSION['acceso'] == 'CEO'){?>
                        <button class="d-none d-lg-flex btn btn-danger ml-2 eliminar">Eliminar</button>
                    <?php } ?>
                </div>
                <div id="tabla_compras" style="border-radius: 10px;" class="contenedorTabla table-responsive">
                    <table style="border-radius: 10px;" class="scroll table table-hover table-striped table-light">
                        <thead class="thead-dark">
                            <tr class="encabezados">
                            <?php if($_SESSION['acceso'] == 'CEO'){?>
                                <th class="text-nowrap text-center" onclick="sortTable(0)"><input class="check" type="checkbox" value="si"></th>
                            <?php } ?>
                                <th class="text-nowrap text-center d-none" onclick="sortTable(1)">Id</th>
                                <th class="text-nowrap text-center" onclick="sortTable(2)">Concepto</th>
                                <th class="text-nowrap text-center" onclick="sortTable(3)">Pago</th>
                                <th class="text-nowrap text-center" onclick="sortTable(4)">Descripcion</th>
                                <th class="text-nowrap text-center" onclick="sortTable(5)">Monto</th>
                                <th class="text-nowrap text-center" onclick="sortTable(6)">Estado</th>
                                <th class="text-nowrap text-center" onclick="sortTable(7)">Fecha</th>
                                <th class="text-nowrap text-center" onclick="sortTable(8)">Registró</th>
                                <th class="text-nowrap text-center" onclick="sortTable(9)"></th>
                            </tr>
                        </thead>
                        <tbody id="cuerpo">
                        </tbody>
                    </table>
                </div><!--Tabla contenedor-->
            </div><!--col-7 compras-->
        </div><!--row-->

        <div style="display: none" id="compra" class="row align-items-start">
            <div class="col-6">
                <p class="statusMsg"></p>
                <div class="row mb-2">
                    <button id="compra_finalizada" class="btn btn-primary mr-2 ">Guardar Compra</button>
                    <button id="cancelar_compra" class="btn btn-danger">Cancelar Compra</button>
                </div>
                <form class="form-group border p-3 bg-light" id="formgastos">
                    <div class="row">
                        <div class="d-block col-lg-4">
                            <p class="general">Folio de factura:</p>
                            <input id="folio_factura" class="form-control form-control-sm" onkeypress="return check(event)" type="text" placeholder="" autocomplete="off" >
                        </div>
                        <div class="d-block col-lg-4">
                            <p class="general">Fecha de facturación:</p>
                            <input class="form-control form-control-sm" id="fecha_facturacion" type="date" name="DFecha" >
                        </div>
                        <div class="d-block col-lg-4">
                            <p class="general">Fecha de vencimiento:</p>
                            <input class="form-control form-control-sm" id="fecha_vencimiento" type="date" name="DFecha" >
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
                            <select name="SPago" id="metodo_pago" class="form form-control form-control-sm" >
                                <option value="Efectivo">Efectivo</option>
                                <option value="Tarjeta">Tarjeta</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="d-block col-lg-6">
                            <p class="general">Descuento:</p>
                            <input type="number" min="0" value="0" id="descuento" class="form form-control form-control-sm" onkeypress="return check(event)" type="text" name="TMonto" placeholder="" autocomplete="off" >
                        </div>
                        <div class="d-block col-lg-6">
                            <p class="importante">Forma de pago:</p>
                            <select id="forma_de_pago" class="form form-control form-control-sm" >
                                <option value="">Elejir</option>
                                <option value="De Contado">De Contado</option>
                                <option value="Credito">Credito</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="fechascredito d-none col-lg-4">
                            <p class="importante">Inicio del credito:</p>
                            <input class="form-control form-control-sm" id="inicio_de_credito" type="date" name="DFecha" >
                        </div>
                        <div class="fechascredito d-none col-lg-4">
                            <p class="importante">Fecha vencimiento del credito:</p>
                            <input class="form-control form-control-sm" id="fecha_del_credito" type="date" name="DFecha" >
                        </div>
                        <div class="fechascredito d-none col-lg-4">
                            <p class="general">Anticipo:</p>
                            <input type="number" min="0" value="0" id="anticipo" class="form form-control form-control-sm" onkeypress="return check(event)" type="text" name="TMonto" placeholder="" autocomplete="off" >
                        </div>
                    </div>
                </form>
                <div class="border p-2 shadow bg-light">
                        <div class="row">
                            <div class="d-block col-lg-4">
                                <p class="importante">Codigo:</p>
                                <input id="codigo_producto" class="form form-control form-control-sm" onkeypress="return check(event)" type="text" placeholder="" autocomplete="off" >
                                <datalist id="productosNegocio">
                                </datalist>
                            </div>
                            <div class="d-block col-lg-4">
                                <p class="importante">Nombre:</p>
                                <input id="nombre_producto" class="form form-control form-control-sm" onkeypress="return check(event)" type="text" name="TMonto" placeholder="" autocomplete="off" >
                            </div>
                            <div class="d-block col-lg-4">
                                <p class="importante">Costo:</p>
                                <input type="number" min="1" id="costo_producto" class="form form-control form-control-sm" onkeypress="return check(event)" type="text" name="TMonto" placeholder="" autocomplete="off" >
                            </div>
                        </div>
                        <div class="row">
                            <div class="d-block col-lg-4">
                                <p class="general">IEPS:</p>
                                <input type="number" min="0" value="0" id="ieps" class="form form-control form-control-sm" onkeypress="return check(event)" type="text" name="TMonto" placeholder="" autocomplete="off" >
                            </div>
                            <div class="d-block col-lg-4">
                                <p class="importante">Cantidad:</p>
                                <input type="number" min="1" id="cantidad" class="form form-control form-control-sm" onkeypress="return check(event)" type="text" name="TMonto" placeholder="" autocomplete="off" >
                            </div>
                        </div>
                        <div class="row justify-content-center mt-2">
                            <button id="agregar_producto" class="col-4 btn btn-danger">Agregar Producto a la compra</button>
                            <button class="d-none d-sm-flex btn btn-primary ml-5 agregar" data-toggle="modal" data-target="#modalForm">Producto nuevo</button>
                        </div>
                </div>
            </div><!--col-5-->

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
                                </tr>
                            </thead>
                            <tbody id="tabla_compra">
                                
                            </tbody>
                        </table>
                    </div><!--table container-->
                </div>
                <div class="col-6 p-2 text-nowrap text-right font-weight-bold bg-dark text-white">
                    <p class="mb-0">Subtotal: <span id="info_subtotal" class="text-nowrap text-center font-weight-bold">$0</span></p>
                    <!-- <p class="mb-0">Descuento: <span id="info_descuento" class="text-nowrap text-center font-weight-bold">$0</span></p> -->
                    <p class="mb-0">IVA: <span id="info_iva" class="text-nowrap text-center font-weight-bold">$0</span></p>           
                    <p class="mb-0">IEPS: <span id="info_ieps" class="text-nowrap text-center font-weight-bold">$0</span></p>
                    <!-- <p class="mb-0">Anticipo: <span id="info_anticipo" class="text-nowrap text-center font-weight-bold">$0</span></p> -->
                    <p class="mb-0">Total: <span id="info_total" class="text-nowrap text-center font-weight-bold">$0</span></p>
                </div>
            </div><!--col-6-->
        </div><!--row compra-->
    </div><!--container-->

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

          <form class="form-group" enctype="multipart/form-data" id="formulario" method="POST">
            <div id="mensaje" style="text-align: center; margin: 10px; font-weight: bold;"></div>
            <div class="d-block d-lg-flex row">
              <div class="col-lg-6">
                <h5 class="importante">Codigo:</h5>
                <input id="codigo_barras" class="form form-control" onkeypress="return codigo(event)" type="text" name="Tcodigo_barras" placeholder="0000000000000" maxlength="13">
                <input type="button" id="generador" value="Generar Código" class="btn btn-primary">
              </div>
              <div class="col-lg-6">
                <h5 class="general">Modelo</h5>
                <input id="modelo" class="form form-control" onkeypress="return check(event)" type="text" name="Tmodelo" placeholder="Modelo" autocomplete="new-password">
              </div>
            </div>
            <div class="d-block d-lg-flex row">
              <div class="col-lg-6">
                <h5 class="importante">Nombre:</h5>
                <input id="nombre" class="form form-control" onkeypress="return check(event)" type="text" name="Tnombre" placeholder="Nombre" autocomplete="new-password" required>
              </div>
              <div class="col-lg-6">
                <h5 class="general">Descripción:</h5>
                <input id="descripcion" class="form form-control" onkeypress="return check(event)" type="text" name="Tdescripcion" placeholder="Descripción" autocomplete="new-password">
              </div>
            </div>
            <div class="d-block d-lg-flex row">
              <div class="col-lg-6">
                <h5 class="general">Marca:</h5>
                <select class="form form-control" id="marca" name="Smarca">

                </select>
              </div>
              <div class="col-lg-6">
                <h5 class="general">Proveedor:</h5>
                <select class="form form-control" id="proveedor" name="Tproveedor">
                </select>
              </div>
            </div>
            <div class="d-block d-lg-flex row">
            <div class="col-lg-6">
                <h5 class="general">Color:</h5>
                <select class="form form-control" id="color" name="Scolor">

                </select>
              </div>
              <div class="col-lg-6">
                <h5 class="general">Descuento:</h5>
                <input id="descuento" class="form form-control" type="text" onkeypress="return check(event)" name="Ndescuento" placeholder="Descuento" autocomplete="new-password"><br>
              </div>
            </div>


            <div class="row text-center">
                <div class="col-lg-12">
                  <h5><label for="imagen" class="general">Imagen:</label></h5>
                  <div id="preview">
                    <img  src="" width="100" height="100" />
                  </div>
                  <div>
                    <input onclick="ejecutar();" style="margin-left: 10px; margin-top: 10px;" id="imagen" style="margin-left: 4px;" type="file" name="Fimagen" />
                  </div>
                </div>
            </div>

            <div class="d-block d-lg-flex row">
              <div class="col-lg-6">
                <h5 class="general">Precio compra:</h5>
                <input id="precio_compra" class="form form-control" type="text" onkeypress="return check(event)" name="Nprecio_compra" placeholder="Precio compra" autocomplete="new-password"><br>
              </div>

              <div class="col-lg-6">
                <h5 class="importante">Precio venta:</h5>
                <input id="precio_venta" class="form form-control" type="text" onkeypress="return check(event)" name="Nprecio_venta" placeholder="Precio venta" autocomplete="new-password" required><br>
              </div>
            </div>

            <div class="d-block d-lg-flex row">
            <div class="col-lg-12">
                  <h5 class="general">Tipo de producto:</h5>
                  <select class="form form-control" id="categoria" name="Stipo_producto">
                    <option value="">Elejir</option>
                    <option value="Calzado">Calzado</option>
                    <option value="Ropa">Ropa</option>
                    <option value="Otros">Otros</option>
                  </select>
                </div>
            </div>
            <div class="d-block d-lg-flex row">
              <div class="col-lg-6">
                  <h5 class="general">Categoria:</h5>
                  <select class="form form-control" id="categoria2" name="Scategoria">

                  </select>
                </div>
              <div class="col-lg-6">
                <h5 class="importante">Unidad de medida:</h5>
                <select class="form form-control" id="unidad_medida" name="Sunidad_medida" required>
                  <option value="pieza">Pieza</option>
                  <option value="par">Par</option>
                  <option value="paquete">Paquete</option>
                </select>
              </div>

            </div>
            <div class="d-block d-lg-flex row">
              <div class="col-lg-6">
                  <h5 class="general">Talla:</h5>
                  <div class="mostrar_producto">
                    <input type="hidden" value="null" name="Stalla_numero">
                  </div>
              </div>
              <div class="col-lg-6">
                <h5 class="general">Tasa IVA:</h5>
                <label><input id="tasa_iva" type="checkbox" name="Ntasa_iva" value="si" >Iva incluido</label>
              </div>

            </div>
            <div class="d-block d-lg-flex row">
            <div class="col-lg-6">
                <h5 class="general">Tasa IEPS:</h5>
                <input id="tasa_ipes" class="form form-control" type="text" onkeypress="return check(event)" name="Ntasa_ipes" placeholder="Tasa IPES" autocomplete="new-password"><br>
              </div>
              <div class="col-lg-6">
                <h5 class="general">Localización:</h5>
                <input id="localizacion" class="form form-control" onkeypress="return check(event)" type="text" name="Tlocalizacion" placeholder="Localización" autocomplete="new-password">
              </div>

            </div>
            <div class="d-block d-lg-flex row">
            <div class="col-lg-6">
                <h5 class="importante">Stock:</h5>
                <input id="stock" class="form form-control" onkeypress="return check(event)" type="number" name="Nstock" placeholder="Stock" autocomplete="new-password" required>
              </div>
            <div class="col-lg-6">
                <h5 class="general">Stock minimo:</h5>
                <input id="stock_minimo" class="form form-control" onkeypress="return check(event)" type="number" name="Nstock_minimo" placeholder="Stock minimo" autocomplete="new-password">
              </div>
            </div>
              <input type="hidden" name="accion" id="accion" >
              <input id="bclose" type="submit" class="mt-3 btn bg-dark text-white btn-lg btn-block" value="Guardar">
          </form>
          <div id="tableHolder" class="row justify-content-center"></div>
        </div>
      </div>
    </div>
  </div>
  </div>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="../js/index.js"></script>
    <script src="../js/user_jquery.js"></script>
    <script src="../js/compras.js"></script>
    <script src="../js/productos.js"></script>
</body>
</html>