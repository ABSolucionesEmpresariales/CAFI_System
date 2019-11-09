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
    <title>Retiros</title>

</head>

<body>
    <?php
    $sel = "retiros";
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
               
                    <form class="form-group" id="formulario1">
                    <div class="mensaje" style="text-align: center; margin: 10px; font-weight: bold;"></div>
                        <div class="row">
                            <div class="col-lg-6">
                                <h5 class="importante">Cantidad:</h5>
                                <input style="" name="Tcantidad" id="cant" onkeypress="return check(event)" class="form form-control bg-light" type="text" autocomplete="off" placeholder="Ingrese la cantidad">
                            </div>
                            <div class="col-lg-6">
                                <h5 class="importante">Desde:</h5>
                                <select id="de" class="form form-control" name="Stipo">
                                    <option></option>
                                    <option value="Caja">Caja</option>
                                    <option value="Banco">Banco</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <h5 class="importante">Concepto:</h5>
                                <select id="concepto" class="form form-control" name="Sconcepto">
                                    <option></option>
                                    <option value="Retiro">Retiro</option>
                                    <option value="Corte de caja">Corte de caja</option>
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <h5 class="general">Descripcion:</h5>
                                <textarea id="desc" name="TAdescripcion" onkeypress="return check2(event)" rows="2" class="form-control bg-light" placeholder="Agregue su descripcion"></textarea>
                            </div>
                        </div>
                        <button type="submit" style="" class="mt-3 btn btn-lg btn-block btn-dark text-white">
                            <h6>Retirar</h6>
                        </button>
                    </form>
                    <div class="contenedorTabla table-responsive">
                        <table class="scroll table table-hover table-striped table-light">
                            <thead class="thead-dark">
                                <tr class="encabezados">
                                    <th>Saldo en caja</th>
                                    <th>Saldo en banco</th>
                                </tr>
                            </thead>
                            <tbody id="cuerpoEfectivo">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->

    <!-- Modal -->
    <div class="modal fade" id="modalForm2" role="dialog">
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
                
                    <form class="form-group" id="formulario2">
                    <div class="mensaje" style="text-align: center; margin: 10px; font-weight: bold;"></div>
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
            </div>
        </div>
    </div>
    <!-- Modal -->

    <div class="contenedor container-fluid">
        <div class="row align-items-start">
            <!-- <div id="formulario" class="d-none d-lg-flex col-lg-4 card card-body">

        </div> -->
            <div class="col-md-12">
                <div id="tableContainer" class="d-block col-lg-12">
                    <div class="input-group mb-2">
                        <button class="d-lg-none btn  btn-danger col-12 mb-3 p-3 retirar" data-toggle="modal" data-target="#modalForm">Retirar</button>
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fa fa-search"></i></div>
                        </div>
                        <input class="form-control col-12 col-lg-4" type="text" id="busqueda" onkeypress="return check(event)" onkeyup="busqueda()" placeholder="Buscar..." title="Type in a name">
                        <button class="d-none d-lg-flex btn btn-danger ml-3 retirar" data-toggle="modal" data-target="#modalForm">Retirar</button>
                    </div>
                    <div style="border-radius: 10px;" class="contenedorTabla table-responsive">
                        <table style="border-radius: 10px;" class="table table-hover table-striped table-light">
                            <thead class="thead-dark">
                                <tr class="encabezados">
                                    <th onclick="sortTable(0)">Id</th>
                                    <th onclick="sortTable(1)">Concepto</th>
                                    <th onclick="sortTable(2)">De</th>
                                    <th onclick="sortTable(3)">Cantidad</th>
                                    <th onclick="sortTable(4)">Descripcion</th>
                                    <th onclick="sortTable(5)">Fecha</th>
                                    <th onclick="sortTable(6)">Hora</th>
                                    <th onclick="sortTable(7)">Estado</th>
                                    <th onclick="sortTable(8)">Retiró</th>
                                </tr>
                            <tbody id="cuerpo">
                            
                            </tbody>
                        </table>
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
    <script src="../js/retiros.js"></script>
</body>

</html>