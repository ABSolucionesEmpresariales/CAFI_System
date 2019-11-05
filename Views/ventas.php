<?php
session_start();
require_once('../Controllers/seguridadCafi.php');
privilegios("Todos");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="../css/sweetalert.css">
    <script src="../js/sweetalert.js"></script>
    <script src="../js/sweetalert.min.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" href="img/logo/nav1.png">
    <title>Ventas</title>
</head>

<body>
    <?php
    $sel = "venta";
    include("../Controllers/NavbarCafi.php");
    ?>
    <div class="contenedor container-fluid">
        <div class="row">
            <div class="col-12 col-lg-5 p-3 order-2 order-lg-1">
                <h3 class="text-center bg-dark text-white mb-3">Venta</h3>
                <div class="contenedorTabla table-wrapper">
                    <div class="table-responsive">
                        <table class="scroll table table-hover table-striped table-dark">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="text-nowrap text-center"></th>
                                    <th class="text-nowrap text-center d-none">Codigo</th>
                                    <th class="text-nowrap text-center">Producto</th>
                                    <th class="text-nowrap text-center">Costo</th>
                                    <th class="text-nowrap text-center">Cant</th>
                                    <th class="text-nowrap text-center">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody id="tbcarrito">

                            </tbody>
                        </table>
                    </div>
                </div>
                <div id="divtotal" style="background:  #3366ff;" class="text-white text-right font-weight-bold p-1 col-12">
                <h2 class="totalcarrito"></h2>
                </div>
                <div class="d-block d-lg-flex mt-4 justify-content-center">
                    <button value="Efectivo" class="col-12 col-lg-4 m-1 bpago1 btn btn-dark text-white" type="button">Pago en efectivo</button>
                    <button value="Crédito" class="col-12 col-lg-4 m-1 bpago2 btn btn-dark text-white" type="button">Pago a crédito</button>
                    <button value="Tarjeta" class="col-12 col-lg-4 m-1 bpago3 btn btn-dark text-white" type="button">Pago con tarjeta</button>
                </div>
            </div>
            <div class="col-12 col-lg-7 p-3 order-1 order-lg-2">
                <h3 class="text-center bg-dark text-white mb-3">Busqueda de Producto</h3>
                <div class="input-group mb-2">
                    <!-- <button class="d-lg-none btn btn-primary col-12 mb-3 p-3" data-toggle="modal" data-target="#modalForm">Agregar</button> -->
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fa fa-search"></i></div>
                    </div>
                    <input autofocus style="color: white; border-color: gray;" onkeypress="return check(event)" class="form-control col-12 col-lg-4 bg-dark" type="search" id="busquedap" autocomplete="off" placeholder="Buscar Producto...">
                </div>
                <div class="contenedorTabla table-responsive table-wrapper-productos">
                    <table class="table table-hover table-striped table-dark">
                        <thead class="thead-dark">
                            <tr class="encabezados">
                                <th class="text-nowrap text-center"></th>
                                <th class="text-nowrap text-center">Imagen</th>
                                <th class="text-nowrap text-center">Cantidad</th>
                                <th class="text-nowrap text-center">U.Medida</th>
                                <th class="text-nowrap text-center">Producto</th>
                                <th style="background-color: orangered;" class="text-nowrap text-center bg-importante">Precio</th>
                                <th class="text-nowrap text-center bg-primary">Codigo</th>
                                <th class="text-nowrap text-center">Color</th>
                                <th class="text-nowrap text-center">Modelo</th>
                                <th class="text-nowrap text-center">Existencia</th>
                                
                            </tr>
                        </thead>
                        <tbody id="cuerpo">
                        </tbody>
                    </table>
                </div>
            </div>
        </div><!-- Row -->
    </div><!-- Contenedor -->
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
                <div class="modal-body administrador">
                    <p class="statusMsg"></p>
                    <div>
                        <td class="text-nowrap text-center" colspan="8">
                            <h3 style="color: white; text-align: right;" class="hmtotal p-2 font-weight-bold"></h3>
                        </td>
                    </div>
                    <div class="divpagotarjeta text-center my-5" style="color:white;">
                        <h5>Ingrese la tarjeta en la terminal y cobre el total</h5>
                    </div>
                    <button class="bdescuento btn btn-block btn-large btn-primary" type="button">Aplicar descuento</button><br>
                    <div id="divdescuento">
                        <h6 style="color: white;">Descuento:</h6>
                        <input class="indescuento form form-control" onkeypress="return check(event)" type="text" placeholder="Ingrese el descuento" autocomplete="off"><br>
                        <button type="button" class="bporcentaje btn btn-dark btn-lg">%</button>
                        <button type="button" class="bpesos btn btn-dark btn-lg">$</button>
                    </div>

                    <div id="tablacliente" class="mt-4">
                        <div class="input-group mb-2">
                            <button class="d-lg-none btn btn-primary col-12 mb-3 p-3" data-toggle="modal" data-target="#modalForm">Agregar</button>
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fa fa-search"></i></div>
                            </div>
                            <input autocomplete="off" style="color: white; border-color: gray;" class="form-control col-12 col-lg-4 bg-dark" type="search" id="busquedac" placeholder="Buscar Cliente...">
                        </div>

                        <table class="scroll table table-hover table-striped table-dark">
                            <thead>
                                <tr>
                                    <th class="text-nowrap text-center"></th>
                                    <th class="text-nowrap text-center">Email</th>
                                    <th class="text-nowrap text-center">Nombre</th>
                                    <th class="text-nowrap text-center">Domicilio</th>
                                    <th class="text-nowrap text-center">Colonia</th>
                                    <th class="text-nowrap text-center">Localidad</th>
                                    <th class="text-nowrap text-center">Municipio</th>
                                    <th class="text-nowrap text-center">Telefono</th>  
                                    <th class="text-nowrap text-center">Estado</th>
                                    <th class="text-nowrap text-center">Credito</th>
                                    <th class="text-nowrap text-center">Adeudos</th>
                                </tr>
                            </thead>
                            <tbody id="cuerpotcliente">

                            </tbody>
                        </table>

                    </div>

                    <div id="divanticipo">
                        <h6 style="color: white;">Anticipo:</h6>
                        <input class="tanticipo form form-control" type="text" onkeypress="return check(event)" placeholder="$" autocomplete="off"><br>
                    </div>
                    <div id="divpago" class="mt-4">
                        <h6 style="color: white;">Cantidad Recibida/Pago:</h6>
                        <input class="tpago form form-control" type="text" onkeypress="return check(event)" placeholder="$" autocomplete="off"><br>
                    </div>
                    <button style="background-color: orangered;" type="button" class="bvender btn btn-block text-white font-weight-bold p-3">
                        <h5>Vender</h5>
                    </button>

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
    <script src="../js/ventas.js"></script>
</body>

</html>