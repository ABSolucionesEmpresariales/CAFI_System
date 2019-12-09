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
    <link rel="icon" href="../img/logo/nav1.png">
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">

    <title>Ventas</title>
</head>

<body>
    <?php
    //$sel = "venta";
    //include("../Controllers/NavbarCafi.php");
    ?>
    <div class="contenedor container-fluid" style="top: 20px;">
        <div class="row justify-content-between">
            <div class="input-group mb-2 col-3">
                <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fa fa-search"></i></div>
                </div>
                <input autofocus style="border-color: gray;" onkeypress="return check(event)" class="form-control col-12" type="search" id="busquedap" autocomplete="off" placeholder="Buscar Producto...">
            </div>
            <!-- <button class="btn btn-primary col-1">CheckbCredito</button>
            <button class="btn btn-danger col-1">CheckbFacturar</button>
            <button class="btn btn-primary col-1">Clientes</button> -->
            <p class="border text-white text-align-right col-2">Nombre del Cliente?</p>
            <p class="border text-white text-align-right col-2">Nombre del Trabajador</p>
            <button value="Inicio" class="col-12 col-lg-2 m-1 bpago3 btn btn-primary text-white font-weight-bold" type="button">Inicio</button>
        </div>
        <div class="row">
            <div class="col-12 col-lg-12 p-3 order-2 order-lg-1">
                <!-- <h3 style="background-color: #282d33; border-radius: 7px;" class="text-center bg-dark text-white mb-3">Venta</h3> -->
                <div class="contenedorTabla table-wrapper">
                    <div class="table-responsive">
                        <table class="scroll table table-hover table-striped table-light">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="text-nowrap text-center"></th>
                                    <th class="text-nowrap text-center">Codigo</th>
                                    <th class="text-nowrap text-center">Producto</th>
                                    <th class="text-nowrap text-center">Precio</th>
                                    <th class="text-nowrap text-center">Descuento</th>
                                    <th class="text-nowrap text-center">Cant</th>
                                    <th class="text-nowrap text-center">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody id="tbcarrito">

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="d-block d-lg-flex justify-content-between p-2" style="background:  #262626; border-radius: 7px;">
                    <button value="Efectivo" class="col-12 col-lg-2 m-1 bpago1 btn btn-primary text-white font-weight-bold" type="button">Pagar</button>
                    <button value="Crédito" class="col-12 col-lg-2 m-1 bpago2 btn btn-primary text-white font-weight-bold" type="button">Crédito</button>
                    <button value="Tarjeta" class="col-12 col-lg-2 m-1 bpago3 btn btn-primary text-white font-weight-bold" type="button">Tarjeta</button>
                    <div id="divtotal" class="text-white text-right font-weight-bold p-1 col-6">
                        <h1 class="totalcarrito font-weight-bold"></h1>
                    </div>
                </div>
            </div>
            <!-- <div class="col-12 col-lg-7 p-3 order-1 order-lg-2">
                <h3 class="text-center bg-dark text-white mb-3">Busqueda de Producto</h3>
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fa fa-search"></i></div>
                    </div>
                    <input autofocus style="border-color: gray;" onkeypress="return check(event)" class="form-control col-12 col-lg-4" type="search" id="busquedap" autocomplete="off" placeholder="Buscar Producto...">
                </div>
                <div class="contenedorTabla table-responsive table-wrapper-productos">
                    <table class="table table-hover table-striped table-light">
                        <thead class="thead-dark">
                            <tr class="encabezados">
                                <th class="text-nowrap text-center"></th>
                                <th class="text-nowrap text-center">Imagen</th>
                                <th class="text-nowrap text-center">Cantidad</th>
                                <th class="text-nowrap text-center">Producto</th>
                                <th class="text-nowrap text-center">Codigo</th>
                                <th class="text-nowrap text-center">Existencia</th>   
                                <th class="text-nowrap text-center bg-importante">Precio</th>
                            </tr>
                        </thead>
                        <tbody id="cuerpo">
                        </tbody>
                    </table>
                </div>
            </div> -->
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
                <div class="modal-body">
                    <p class="statusMsg"></p>
                    <div>
                        <td class="text-nowrap text-center" colspan="8">
                            <h3 style="text-align: right;" class="hmtotal p-2 font-weight-bold"></h3>
                        </td>
                    </div>
                    <div class="divpagotarjeta text-center my-5">
                        <h5>Ingrese la tarjeta en la terminal y cobre el total</h5>
                    </div>
                    <button class="bdescuento btn btn-block btn-large btn-dark text-white" type="button">Aplicar descuento</button><br>
                    <div id="divdescuento" class="mb-3">
                        <h6>Descuento (El mensaje esta de mas):</h6>
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
                            <input autocomplete="off" style="border-color: gray;" class="form-control col-12 col-lg-4" type="search" id="busquedac" placeholder="Buscar Cliente...">
                        </div>
                        
                        <div style="border-radius: 10px;" class="contenedorTabla table-responsive">
                            <table style="border-radius: 10px;" class="table table-bordered table-hover table-striped table-light">
                            <thead class="thead-light">
                                <tr>
                                    <th class="text-nowrap text-center"></th>
                                    <th class="text-nowrap text-center">Email</th>
                                    <th class="text-nowrap text-center">Nombre</th>
                                    <th class="text-nowrap text-center">Telefono</th>  
                                    <th class="text-nowrap text-center">Credito</th>
                                    <th class="text-nowrap text-center">Adeudos</th>
                                </tr>
                            </thead>
                            <tbody id="cuerpotcliente">

                            </tbody>
                            </table>
                        </div>

                    </div>

                    <div id="divanticipo">
                        <h6>Anticipo:</h6>
                        <input class="tanticipo form form-control" type="text" onkeypress="return check(event)" placeholder="$" autocomplete="off"><br>
                    </div>
                    <div class="mb-1 text-center">
<!--                         <button class="btn btn-primary">Efectivo</button>
                        <button class="btn btn-danger">Tarjeta</button> -->
                    </div>
                    <div id="divpago" class="mt-4">
                        <h6 class="font-weight-bold">Cantidad Recibida/Pago:</h6>
                        <input class="tpago form form-control" type="text" onkeypress="return check(event)" placeholder="" autocomplete="off"><br>
                    </div>
                    <button style="color: white;" type="button" class="bvender btn btn-block bg-dark font-weight-bold p-3">
                        <h5>Pagar</h5>
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