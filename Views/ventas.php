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
                <input list="productos" autofocus style="border-color: gray;" onkeypress="return check(event)" class="form-control col-12" type="input" id="busquedap" autocomplete="off" placeholder="Buscar Producto...">
                <datalist id="productos">

                </datalist>
            </div>
            <!-- <button class="btn btn-primary col-1">CheckbCredito</button>
            <button class="btn btn-danger col-1">CheckbFacturar</button>
            <button class="btn btn-primary col-1">Clientes</button> -->
            <p class="border text-white text-align-right col-2">Nombre del Trabajador</p>
            <a id="orange" class="col-12 col-lg-2 m-1 btn btn-primary text-white font-weight-bold" onclick="window.location.href='trabajadorCafi.php'" title="Inicio">Inicio</a></button>   
                    <div class="table-responsive">
                        <table class="scroll table table-hover table-striped table-light">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="text-nowrap text-center">Codigo</th>
                                    <th class="text-nowrap text-center">Producto</th>
                                    <th class="text-nowrap text-center">Precio</th>
                                    <th class="text-nowrap text-center">Descuento</th>
                                    <th class="text-nowrap text-center">Cant</th>
                                    <th class="text-nowrap text-center">Subtotal</th>
                                    <th class="text-nowrap text-center"></th>
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
<!----------------------------------------------------------------------------------------------------- --->
<div class="modal-body">
                    <p class="statusMsg"></p>
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="nav-extra-tab" data-toggle="tab" href="#extra" role="tab" aria-controls="extra" aria-selected="false">Pagar</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="nav-user-tab" data-toggle="tab" href="#user" role="tab" aria-controls="user" aria-selected="true">Agregar cliente</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="extra" role="tabpanel" aria-labelledby="extra-tab">
                                    <div class="col-12"><br>
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
                                            <div class="factura1">
                                                <button style="color: white;" type="button" class="bvender btn btn-block bg-dark font-weight-bold m-1" id="factura1">
                                                <h6>Facturar</h6>
                                                </button>
                                            </div>
                                            <div class="factura2">
                                                <button style="color: white;" type="button" class="bvender btn btn-block bg-dark font-weight-bold m-1" id="factura">
                                                <h6>Facturar</h6>
                                                </button>
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

                                            <div id="tablapagoFacturas" class="mt-4">
                                                <div class="input-group mb-2">
                                                    <button class="d-lg-none btn btn-primary col-12 mb-3 p-3" data-toggle="modal" data-target="#modalForm">Agregar</button>

                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text"><i class="fa fa-search"></i></div>
                                                        </div>
                                                            <input autocomplete="off" style="border-color: gray;" class="form-control col-12" type="search" id="busquedac2" placeholder="Buscar Cliente...">
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <h6>Uso CFDI:</h6>
                                                            <input type="text" list="listaCFDI" class="form-control col-12">
                                                            <datalist id="listaCFDI">
                                                            </datalist>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="mensaje-factura text-center"></div>
                                                <div style="border-radius: 10px;" class="contenedorTabla table-responsive">
                                                    <table style="border-radius: 10px;" class="table table-bordered table-hover table-striped table-light">
                                                        <thead class="thead-light">
                                                            <tr>
                                                                <th class="text-nowrap text-center"></th>
                                                                <th class="text-nowrap text-center">Email</th>
                                                                <th class="text-nowrap text-center">Nombre</th>
                                                                <th class="text-nowrap text-center">Telefono</th>
                                                                <th class="text-nowrap text-center">Credito</th>
                                                                <th class="text-nowrap text-center">RFC</th>
                                                                <th class="text-nowrap text-center">Codigo Postal</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="cuerpoClienteFacturaPago">

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
                                <div class="tab-pane fade" id="user" role="tabpanel" aria-labelledby="user-tab">
                                    <div class="col-12">
                                    <form class="form-group" id="formularioCliente">
                                        <div id="mensaje3" style="text-align: center; margin: 10px; font-weight: bold;"></div>
                                        <div class="d-block d-lg-flex row">
                                        <div class="col-lg-6 ocultar-email">
                                            <h5 class="general" style="color: #EF5602">Email:</h5>
                                            <input id="email" class="form form-control" onkeypress="return check(event)" type="email" name="Temail" placeholder="Email" autocomplete="new-password" required> <br>
                                        </div>
                                        <div class="col-lg-6">
                                            <h5 class="general" style="color: #EF5602">Nombre:</h5>
                                            <input id="nombre" class="form form-control" onkeypress="return check(event)" type="text" name="Tnombre" placeholder="Nombre" autocomplete="new-password" required> <br>
                                        </div>
                                        </div>
                                        <div class="d-block d-lg-flex row">
                                        <div class="col-lg-6">
                                            <h5 class="general" style="color: #EF5602">Teléfono:</h5>
                                            <input id="telefono" class="form form-control" type="text" onkeypress="return check(event)" name="Ttelefono" placeholder="Teléfono" autocomplete="new-password" required><br>
                                        </div>
                                        <div class="col-lg-6">
                                            <h5 class="general" style="color: #EF5602">Credito:</h5>
                                            <select class="form form-control" id="credito" name="Scredito" required>
                                            <option value="A">Activa</option>
                                            <option value="I">Inactiva</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-6">
                                            <h5 class="general">Codigo Postal:</h5>
                                            <input id="cp" class="form form-control" onkeypress="return check(event)" type="text" name="Tcp" placeholder="Código postal" autocomplete="new-password"><br>
                                        </div>
                                        <div class="col-lg-6">
                                            <h5 class="general">Calle y número:</h5>
                                            <input id="calle_numero" class="form form-control" onkeypress="return check(event)" type="text" name="Tcalle_numero" placeholder="Calle y número" autocomplete="new-password"><br>
                                        </div>
                                        </div>
                                        <div class="row">
                                        <div class="col-lg-6">
                                            <h5 class="general">Colonia:</h5>
                                            <input id="colonia" class="form form-control" type="text" onkeypress="return check(event)" name="Tcolonia" placeholder="Colonia" autocomplete="new-password"><br>
                                        </div>
                                        <div class="col-lg-6">
                                            <h5 class="importante">Localidad:</h5>
                                            <input id="Tlocalidad" list="localidad" class="form form-control" name="DLlocalidad" onkeypress="return check(event)"  autocomplete="new-password" required>
                                            <datalist id="localidad">
                                            </datalist><br>
                                        </div>
                                        </div>
                                        <div class="d-block d-lg-flex row">
                                        <div class="col-lg-6">
                                            <h5 class="general">Municipio:</h5>
                                            <input id="municipio" class="form form-control" type="text" onkeypress="return check(event)" name="Tmunicipio" placeholder="Municipio" autocomplete="new-password"><br>
                                        </div>
                                        <div class="col-lg-6">
                                            <h5 class="general">Estado:</h5>
                                            <select class="form form-control" id="estado" name="Sestado">
                                            <option value="">Elegir</option>
                                            <option value="Aguascalientes">Aguascalientes</option>
                                            <option value="Baja California">Baja California </option>
                                            <option value="Baja California Sur">Baja California Sur</option>
                                            <option value="Campeche">Campeche</option>
                                            <option value="Chiapas">Chiapas</option>
                                            <option value="Chihuahua">Chihuahua</option>
                                            <option value="Ciudad de México">Ciudad de México</option>
                                            <option value="Coahuila de Zaragoza">Coahuila</option>
                                            <option value="Colima">Colima</option>
                                            <option value="Durango">Durango</option>
                                            <option value="México">México</option>
                                            <option value="Guanajuato">Guanajuato</option>
                                            <option value="Guerrero">Guerrero</option>
                                            <option value="Hidalgo">Hidalgo</option>
                                            <option value="Jalisco">Jalisco</option>
                                            <option value="Michoacán de Ocampo">Michoacán</option>
                                            <option value="Morelos">Morelos</option>
                                            <option value="Nayarit">Nayarit</option>
                                            <option value="Nuevo León">Nuevo León</option>
                                            <option value="Oaxaca">Oaxaca</option>
                                            <option value="Puebla">Puebla</option>
                                            <option value="Querétaro">Querétaro</option>
                                            <option value="Quintana Roo">Quintana Roo</option>
                                            <option value="San Luis Potosí">San Luis Potosí</option>
                                            <option value="Sinaloa">Sinaloa</option>
                                            <option value="Sonora">Sonora</option>
                                            <option value="Tabasco">Tabasco</option>
                                            <option value="Tamaulipas">Tamaulipas</option>
                                            <option value="Tlaxcala">Tlaxcala</option>
                                            <option value="Veracruz de Ignacio de la Llave">Veracruz</option>
                                            <option value="Yucatán">Yucatán</option>
                                            <option value="Zacatecas">Zacatecas</option>
                                            </select> <br>
                                        </div>
                                        </div>
                                        <div class="d-block d-lg-flex row">
                                        <div class="col-lg-6">
                                            <h5 class="general">Sexo:</h5>
                                            <select class="form form-control" id="sexo" name="Ssexo">
                                            <option value="">Elegir</option>
                                            <option value="M">Masculino</option>
                                            <option value="F">Femenino</option>
                                            </select><br>
                                        </div>
                                        <div class="col-lg-6">
                                            <h5 class="general">RFC:</h5>
                                            <input id="rfc" class="form form-control" onkeypress="return check(event)" type="text" name="Trfc" placeholder="RFC" autocomplete="new-password"> <br>
                                        </div>
                                        </div>
                                        <div class="d-block d-lg-flex row">
                                        <div class="col-lg-6">
                                            <h5 class="general">Fecha de nacimiento:</h5>
                                            <input id="fecha_nacimiento" class="form form-control" type="date" onkeypress="return check(event)" name="Dfecha_nacimiento" placeholder="Fecha de nacimiento" autocomplete="new-password"><br>
                                        </div>
                                        <div class="col-lg-6">
                                            <h5 class="general">Plazo de credito:</h5>
                                            <input id="plazo_credito" class="form form-control" type="text" onkeypress="return check(event)" name="Tplazo_credito" placeholder="Plazo Credito" autocomplete="new-password"><br>
                                        </div>
                                        </div>
                                        <div class="row">
                                        <div class="col-lg-6">
                                            <h5 class="general">Limite de credito:</h5>
                                            <input id="limite_credito" class="form form-control" type="text" onkeypress="return check(event)" name="Tlimite_credito" placeholder="Limite de credito" autocomplete="new-password"><br>
                                        </div>
                                        </div>
                                        <input id="bclose" type="submit" class="mt-3 btn btn-lg btn-block btn-dark text-white" value="Guardar">
                                    </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="tableHolder" class="row justify-content-center">

                    </div>
                </div>
<!----------------------------------------------------------------------------------------------------- --->

                <!-- Modal Body -->
                <div class="modal-body">


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