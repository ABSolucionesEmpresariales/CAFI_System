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
    <link rel="icon" href="img/logo/nav1.png">

    <title>Clientes</title>
</head>


<body>
    <?php
    $sel = "ccm";
    include("../Controllers/NavbarCafi.php");
    ?>

    <div class="contenedor container-fluid">
        <div class="row align-items-start">
        <div class="input-group mb-2 border">
                        <button class="d-lg-none btn btn-primary col-12 mb-3 p-3 eliminar">Eliminar</button>
                        <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fa fa-search"></i></div>
                        </div>
                        <input class="form-control col-12 col-lg-4" type="text" id="busqueda" onkeypress="return check(event)" onkeyup="busqueda()" placeholder="Buscar..." title="Type in a name" value="">
                        <button class="d-none d-lg-flex btn btn-primary ml-3 eliminar">Eliminar</button>
                        <form id="formulario" class="form form-inline">
                            <h5 class="general">Elejir:</h5>
                                <select class="form form-control" name="CCM" id="CCM">
                                    <option value="Elejir">Elejir</option>
                                    <option value="Color">Color</option>
                                    <option value="Marca">Marca</option>
                                    <option value="Categoria">Categoria</option>
                                </select>
                            <h5 class="general">Nombre:</h5>
                            <input class="form form-control" type="text" name="CCMInput" id="CCMInput">
                            <input id="bclose" type="submit" class="btn-dark text-primary" name="" value="Guardar">
                        </form>
                    </div>
            <div class="col-md-4">
              <div id="tableContainer" class="d-block col-lg-12">
                    <div style="border-radius: 10px;" class="contenedorTabla table-responsive">
                        <h2 style="">Colores</h2>
                        <input type="checkbox" value="si" id="checkColores">
                        <table style="border-radius: 10px;" class="table table-hover table-striped table-light">
                            <thead class="thead-dark">
                                <tr class="encabezados">
                                    <th class="text-nowrap text-center" onclick="sortTable(0)">Eliminar</th>
                                    <th class="text-nowrap text-center" onclick="sortTable(1)">Nombre</th>
                                </tr>
                            </thead>
                            <tbody  id="cuerpoColores">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
              <div id="tableContainer" class="d-block col-lg-12">
                    <div style="border-radius: 10px;" class="contenedorTabla table-responsive">
                    <h2 style="">Categorias</h2>
                    <input type="checkbox" value="si" id="checkCategoria">
                        <table style="border-radius: 10px;" class="table table-hover table-striped table-light">
                            <thead class="thead-dark">
                                <tr class="encabezados">
                                    <th class="text-nowrap text-center" onclick="sortTable(0)">Eliminar</th>
                                    <th class="text-nowrap text-center" onclick="sortTable(1)">Nombre</th>
                                </tr>
                            </thead>
                            <tbody  id="cuerpoCategoria">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
              <div id="tableContainer" class="d-block col-lg-12">
                    <div style="border-radius: 10px;" class="contenedorTabla table-responsive">
                    <h2 style="">Marcas</h2>
                    <input type="checkbox" value="si" id="checkMarca">
                        <table style="border-radius: 10px;" class="table table-hover table-striped table-light">
                            <thead class="thead-dark">
                                <tr class="encabezados">
                                    <th class="text-nowrap text-center" onclick="sortTable(0)">Eliminar</th>
                                    <th class="text-nowrap text-center" onclick="sortTable(1)">Nombre</th>
                                </tr>
                            </thead>
                            <tbody  id="cuerpoMarcas">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>




        </div>
    </div>

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
                    <h5 class="statusMsg"></h5>
                    <div class="row">

                    </div>
                    <div class="row">

                    </div>

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
    <script src="../js/CCM.js"></script>
</body>
</html>