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
    <!-- Modal -->
    <div class="modal fade" id="modalForm" role="dialog">
        <div style="width: 900px;" class="modal-dialog">
            <div style="width: 900px;" class="modal-content">
                <!-- Modal Header -->
                <div style="width: 900px;" class="modal-header administrador">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">×</span>
                        <span class="sr-only">Close</span>
                    </button>
                </div>

                <!-- Modal Body -->
                <div style="width: 900px;" class="modal-body">
                    
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->

    <div class="contenedor container-fluid">
        <div id="compras" class="row align-items-start">
            <div id="tableContainer" class="d-block col-lg-12">
                <div class="input-group mb-2">
                    <button class="d-lg-none btn btn-primary col-12 mb-3 p-3" data-toggle="modal" data-target="#modalForm">Agregar Compra</button>
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="fa fa-search"></i>
                        </div>
                    </div>
                    <input class="form-control form-control-sm col-12 col-lg-4" type="text" id="busqueda" onkeypress="return check(event)" onkeyup="busqueda()" placeholder="Buscar..." title="Type in a name" value="">
                    <button id="btncompra" class="d-none d-lg-flex btn btn-primary ml-3">Agregar Compra</button>
                </div>
                <div id="tabla_compras" style="border-radius: 10px;" class="contenedorTabla table-responsive">
                    <table style="border-radius: 10px;" class="scroll table table-hover table-striped table-light">
                        <thead class="thead-dark">
                            <tr class="encabezados">
                                <th class="text-nowrap text-center" onclick="sortTable(0)">Id</th>
                                <th class="text-nowrap text-center" onclick="sortTable(1)">Concepto</th>
                                <th class="text-nowrap text-center" onclick="sortTable(2)">Pago</th>
                                <th class="text-nowrap text-center" onclick="sortTable(3)">Descripcion</th>
                                <th class="text-nowrap text-center" onclick="sortTable(4)">Monto</th>
                                <th class="text-nowrap text-center" onclick="sortTable(5)">Estado</th>
                                <th class="text-nowrap text-center" onclick="sortTable(6)">Fecha</th>
                                <th class="text-nowrap text-center" onclick="sortTable(7)">Registró</th>
                                <th class="text-nowrap text-center" onclick="sortTable(8)"></th>
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
                    <button id="compra_finalizada" class="btn btn-primary mr-2">Guardar Compra</button>
                    <button id="cancelar_compra" class="btn btn-danger">Cancelar Compra</button>
                </div>
                <form class="form-group border p-3 bg-light" id="formgastos">
                    <div class="row">
                        <div class="d-block col-lg-4">
                            <p class="general">Folio de factura:</p>
                            <input id="folio_factura" class="form-control form-control-sm" onkeypress="return check(event)" type="text" name="TMonto" placeholder="" autocomplete="off" >
                        </div>
                        <div class="d-block col-lg-4">
                            <p class="importante">Fecha de facturación:</p>
                            <input class="form-control form-control-sm" id="fecha_facturacion" type="date" name="DFecha" >
                        </div>
                        <div class="d-block col-lg-4">
                            <p class="importante">Fecha de vencimiento:</p>
                            <input class="form-control form-control-sm" id="fecha_vencimiento" type="date" name="DFecha" >
                        </div>
                    </div>
                    <div class="row">
                        <div class="d-block col-lg-4">
                            <p class="general">Codigo de proveedor:</p>
                            <input id="codigo_proveedor" class="form form-control form-control-sm" onkeypress="return check(event)" type="text" name="TMonto" placeholder="" autocomplete="off" >
                        </div>
                        <div class="d-block col-lg-4">
                            <p class="general">Nombre proveedor:</p>
                            <input id="nombre_proveedor" class="form form-control form-control-sm" onkeypress="return check(event)" type="text" name="TMonto" placeholder="" autocomplete="off" >
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
                            <p class="importante">Fecha del credito:</p>
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
                                <input id="codigo_producto" class="form form-control form-control-sm" onkeypress="return check(event)" type="text" name="TMonto" placeholder="" autocomplete="off" >
                            </div>
                            <div class="d-block col-lg-4">
                                <p class="importante">Nombre:</p>
                                <input id="nombre_producto" class="form form-control form-control-sm" onkeypress="return check(event)" type="text" name="TMonto" placeholder="" autocomplete="off" >
                            </div>
                            <div class="d-block col-lg-4">
                                <p class="importante">Costo:</p>
                                <input type="number" min="1" id="costo_producto" class="form form-control form-control-sm" onkeypress="return check(event)" type="text" name="TMonto" placeholder="" autocomplete="off" >
                                <input type="checkbox" id="iva">
                                <label class="general" for="iva">IVA</label>
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
                            <button id="agregar_producto" class="col-4 btn btn-danger">Agregar Producto</button>
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
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="../js/index.js"></script>
    <script src="../js/user_jquery.js"></script>
    <script src="../js/compras.js"></script>
</body>
</html>