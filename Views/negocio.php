<?php
session_start();
require_once('../Controllers/seguridadAB.php');
privilegios("Todos");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" href="../img/logo/nav1.png">
    <title>Negocios</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>

<body >
<?php
    $sel = "negocios";
    include("../Controllers/NavbarAB.php")
    ?>
    <!-- Modal -->
    <div class="modal fade" id="modalForm" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header administrador">
                    <button type="button" class="bclose close" data-dismiss="modal">
                        <span aria-hidden="true">×</span>
                        <span class="sr-only">Close</span>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <p class="statusMsg"></p>
                    <form class="form-group" id="formulario">
                            <div id="mensaje" style="text-align: center; margin: 10px; font-weight: bold;"></div>
                        <div class="row">
                            <div class="col-lg-4">
                                    <h5 class="importante">Nombre:</h5>
                                    <input id="nombre" class="form form-control" onkeypress="return check(event)" type="text" name="Tnombre" placeholder="Nombre" autocomplete="new-password" >
                            </div>
                            <div class="col-lg-4">
                                    <h5 class="importante">Giro:</h5>
                                    <select class="form form-control" id="giro" name="Sgiro">
                                        <option value="Tienda">Tienda de ropa</option>
                                        <option value="Zapateria">Zapateria</option>
                                        <option value="Otros">Otros</option>
                                    </select>
                                </div>
                            <div class="col-lg-4">
                                <h5 class="importante">Domicilio:</h5>
                                <input id="calle_numero" class="form form-control" onkeypress="return check(event)" type="text" name="Tcalle_numero" placeholder="Domicilio" autocomplete="new-password" >
                            </div>
                        </div>
                        <div class="row">
                                <div class="col-lg-4">
                                        <h5 class="importante">Colonia:</h5>
                                        <input id="colonia" class="form form-control" onkeypress="return check(event)" type="text" name="Tcolonia" placeholder="Colonia" autocomplete="new-password" >
                                    </div>
                            <div class="col-lg-4">
                                <h5 class="importante">Localidad:</h5>
                                <input id="localidad" class="form form-control" type="text" onkeypress="return check(event)" name="Tlocalidad" placeholder="Localidad" autocomplete="new-password" >
                            </div>
                            <div class="col-lg-4">
                                <h5 class="importante">Municipio:</h5>
                                <input id="municipio" class="form form-control" type="text" onkeypress="return check(event)" name="Tmunicipio" placeholder="Municipio" autocomplete="new-password" >
                            </div>
                            <div class="col-lg-4">
                                    <h5 class="importante">Estado:</h5>
                                    <select class="form form-control" id="estado" name="Sestado">
                                      <option value="Aguascalientes">Aguascalientes</option>
                                      <option value="Baja California">Baja California	</option>
                                      <option value="Baja California Sur">Baja California Sur</option>
                                      <option value="Campeche">Campeche</option>
                                      <option value="Chiapas">Chiapas</option>
                                      <option value="Chihuahua">Chihuahua</option>
                                      <option value="Coahuila">Coahuila</option>
                                      <option value="Colima">Colima</option>
                                      <option value="Durango">Durango</option>
                                      <option value="Guanajuato">Guanajuato</option>
                                      <option value="Guerrero">Guerrero</option>
                                      <option value="Hidalgo">Hidalgo</option>
                                      <option value="Jalisco">Jalisco</option>
                                      <option value="México">México</option>
                                      <option value="Michoacán">Michoacán</option>
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
                                      <option value="Veracruz">Veracruz</option>
                                      <option value="Yucatán">Yucatán</option>
                                      <option value="Zacatecas">Zacatecas</option>
                                    </select>
                                  </div>
                             <div class="col-lg-4">
                                <h5 class="importante">Pais:</h5>
                                <select class="form form-control" id="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" name="Spais">
                                        <option value="México">México</option>
                                    </select>
                            </div>
                            <div class="col-lg-4">
                                    <h5 class="general">Telefono:</h5>
                                    <input id="telefono" class="form form-control" type="text" onkeypress="return check(event)" name="Ttelefono" placeholder="Telefono" autocomplete="new-password" >
                                </div>
                            <div class="col-lg-4">
                                <h5 class="importante">Impresora:</h5>
                                <select class="form form-control" id="impresora" name="Simpresora">
                                    <option value="A">Activo</option>
                                    <option value="I">Inactivo</option>
                                </select>
                            </div>
                            <div>
                                <h5 class="importante">Dueño:</h5>
                                <input id="dueno" class="form form-control" list="clientes" name="Sdueno"  autocomplete="new-password">
                                <datalist id="clientes">
                                </datalist>
                            </div>
                        </div>

                        <input type="submit" class="bclose mt-3 btn bg-dark text-primary btn-lg btn-block" value="Guardar">
                    </form>
                    <div id="tableHolder" class="row justify-content-center">

                    </div>
                </div>
            </div>
        </div>
    </div><!-- Modal -->

    <div class="contenedor container-fluid">
        <div class="row align-items-start">
            <div class="col-md-12">
                <div id="tableContainer" class="d-block col-lg-12">
                    <div class="input-group mb-2">
                        <button class="agregar d-lg-none btn btn-info col-12 mb-3 p-3" data-toggle="modal" data-target="#modalForm">Agregar</button>
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fa fa-search"></i></div>
                        </div>
                        <input class="form-control col-12 col-lg-4" type="text" id="busqueda" onkeypress="return check(event)" onkeyup="busqueda()" placeholder="Buscar..." title="Type in a name" value="">
                        <button class="d-none d-lg-flex btn btn-primary ml-3 agregar" data-toggle="modal" data-target="#modalForm">Agregar</button>
                    </div>
                        <div style="border-radius: 10px;" class="contenedorTabla table-responsive">
                            <table style="border-radius: 10px;" class="table table-bordered table-hover table-striped table-light">
                                <thead class="thead-dark">
                                    <tr class="encabezados">
                                        <th class="text-nowrap text-center" onclick="sortTable(0)">Nombre</th>
                                        <th class="text-nowrap text-center" onclick="sortTable(1)">Giro</th>
                                        <th class="text-nowrap text-center" onclick="sortTable(2)">Calle</th>
                                        <th class="text-nowrap text-center" onclick="sortTable(3)">Colonia</th>
                                        <th class="text-nowrap text-center" onclick="sortTable(4)">Localidad</th>
                                        <th class="text-nowrap text-center" onclick="sortTable(5)">Municiopio</th>
                                        <th class="text-nowrap text-center" onclick="sortTable(6)">Estado</th>
                                        <th class="text-nowrap text-center" onclick="sortTable(7)">Pais</th>
                                        <th class="text-nowrap text-center" onclick="sortTable(8)">Telefono</th>
                                        <th class="text-nowrap text-center" onclick="sortTable(9)">Impresora</th>
                                        <th class="text-nowrap text-center" onclick="sortTable(10)">Dieño</th>
                                        <th class="text-nowrap text-center" onclick="sortTable(11)">UsuarioAB</th>
                                    </tr>
                                </thead>
                                <tbody id="cuerpo"></tbody>
                            </table>
                        </div>
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
            <script src="../js/negocios.js"></script>
            </body>
</html>
