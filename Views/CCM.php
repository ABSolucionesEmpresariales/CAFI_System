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

    <title>Clientes</title>
</head>


<body>
    <?php
    $sel = "ccm";
    include("../Controllers/NavbarCafi.php");
    ?>

    <div class="contenedor container-fluid">
        <div class="row align-items-start">

            <div class="input-group mb-2">
                <div class="input-group-prepend">
                <div class="input-group-text"><i class="fa fa-search"></i></div>
                </div>
                <input class="form-control col-12 col-lg-4" type="text" id="busqueda" onkeypress="return check(event)" onkeyup="busqueda()" placeholder="Buscar..." title="Type in a name" value="">
                <p class="text-white font-weight-bold ml-lg-4">Agregar elemento:</p>
                <form id="formulario" class="form form-inline ml-lg-2">
                    <select class="form form-control" name="CCM" id="CCM">
                        <option value="Elejir">Elegir Tipo</option>
                        <option value="Color">Color</option>
                        <option value="Marca">Marca</option>
                        <option value="Categoria">Categoria</option>
                    </select>
                    <input placeholder="Nombre" class="form form-control ml-lg-2" type="text" name="CCMInput" id="CCMInput">
                    <input id="bclose" type="submit" class="btn btn-primary text-white ml-lg-2" name="" value="Agregar">
                </form>
                <button class="d-none d-lg-flex btn btn-danger ml-2 eliminar">Eliminar</button>
                <button class="d-lg-none btn btn-danger col-12 mb-3 p-3 eliminar">Eliminar</button>
            </div>

            <div class="col-md-4">
                <div id="tableContainer" class="d-block col-lg-12">
                    <div style="border-radius: 10px;" class="contenedorTabla table-responsive">
                        <h2 class="bg-light text-center">Colores</h2>
                        <table style="border-radius: 10px;" class="table table-bordered table-hover table-striped table-light">
                            <thead class="thead-dark">
                                <tr class="encabezados">
                                    <th class="text-nowrap text-left" onclick="sortTable(0)"><input type="checkbox" value="si" id="checkColores"></th>
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
                        <h2 class="bg-light text-center">Categorias</h2>
                        <table style="border-radius: 10px;" class="table table-bordered table-hover table-striped table-light">
                            <thead class="thead-dark">
                                <tr class="encabezados">
                                    <th class="text-nowrap text-left" onclick="sortTable(0)"><input type="checkbox" value="si" id="checkCategoria"></th>
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
                        <h2 class="bg-light text-center">Marcas</h2>
                        <table style="border-radius: 10px;" class="table table-bordered table-hover table-striped table-light">
                            <thead class="thead-dark">
                                <tr class="encabezados">
                                    <th class="text-nowrap text-left" onclick="sortTable(0)"><input type="checkbox" value="si" id="checkMarca"></th>
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
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="../js/index.js"></script>
    <script src="../js/user_jquery.js"></script>
    <script src="../js/CCM.js"></script>
</body>
</html>