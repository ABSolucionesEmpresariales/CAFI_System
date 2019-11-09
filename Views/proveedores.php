<?php
session_start();
require_once('../Controllers/seguridadCafi.php');
privilegios("Todos");
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

    <title>Prooveores</title>
    <script>
      function cerrar() {
        window.close();
      }
    </script>
  </head>

  <body>
  <?php
    $sel = "proveedores";
    include("../Controllers/NavbarCafi.php");
 
    ?>

        <div class="contenedor container-fluid">
          <div class="row align-items-start">
            <div class="col-lg-12">
              <div id="tableContainer" class="d-block col-lg-12">
                <div class="input-group mb-2">
                  <button class="agregar d-lg-none btn btn-primary col-12 mb-3 p-3" data-toggle="modal" data-target="#modalForm">Agregar</button>
                  <button class="d-lg-none btn btn-danger col-12 mb-3 p-3 eliminar">Eliminar</button>
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      <i class="fa fa-search"></i>
                    </div>
                  </div>
                  <div id="combo"></div>
                  <input class="form-control col-12 col-lg-4" type="text" id="busqueda" onkeypress="return check(event)" onkeyup="busqueda()" placeholder="Buscar..." title="Type in a name" value="">
                  <button class="agregar d-none d-lg-flex btn btn-primary ml-3 agregar" data-toggle="modal" data-target="#modalForm">Agregar</button>
                  <button class="d-none d-lg-flex btn btn-danger ml-2 eliminar">Eliminar</button>
                  
                </div>
                <div style="border-radius: 10px;" class="contenedorTabla table-responsive">
                  <table style="border-radius: 10px;" class="table table-bordered table-hover table-striped table-light">
                    <thead class="thead-dark">
                      <tr class="encabezados">
                        <th class="text-nowrap text-center" onclick="sortTable(0)"><input id="eliminar" class="check" type="checkbox" value="si" ></th>
                        <th class="text-nowrap text-center" onclick="sortTable(1)">RFC</th>
                        <th class="text-nowrap text-center" onclick="sortTable(2)">Dias Credito</th>
                        <th class="text-nowrap text-center" onclick="sortTable(3)">Nombre</th>
                        <th class="text-nowrap text-center" onclick="sortTable(4)">Domicilio</th>
                        <th class="text-nowrap text-center" onclick="sortTable(5)">Colonia</th>
                        <th class="text-nowrap text-center" onclick="sortTable(6)">Ciudad</th>
                        <th class="text-nowrap text-center" onclick="sortTable(7)">Estado</th>
                        <th class="text-nowrap text-center" onclick="sortTable(8)">Pais</th>
                        <th class="text-nowrap text-center" onclick="sortTable(9)">Telefono</th>
                        <th class="text-nowrap text-center" onclick="sortTable(10)">Email</th>
                        <th class="text-nowrap text-center" onclick="sortTable(11)">UsuarioCafi</th>
                      </tr>
                    </thead>
                    
                    <tbody id="cuerpo"></tbody>
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
                  <p class="statusMsg"></p>
                  <form class="form-group" id="formulario">
                    <div id="mensaje" style="text-align: center; margin: 10px; font-weight: bold;"></div>

                    <div class="d-block d-lg-flex row">
                    <div class="col-lg-6">
                        <h5 class="importante">Nombre:</h5>
                        <input id="nombre" class="form form-control" onkeypress="return check(event)" type="text" name="Tnombre" placeholder="Nombre" autocomplete="new-password">
                      </div>
                      <div class="col-lg-6">
                        <h5 class="general">RFC:</h5>
                        <input id="rfc" class="form form-control" onkeypress="return check(event)" type="text" name="Trfc" placeholder="rfc" autocomplete="new-password">
                      </div>
                    </div>

                    <div class="d-block d-lg-flex row">
                      <div class="col-lg-6">
                        <h5 class="general">Dias credito:</h5>
                        <input id="dias_credito" class="form form-control" onkeypress="return check(event)" type="number" name="Sdias_credito" placeholder="Dias credito" autocomplete="new-password">
                      </div>
                      <div class="col-lg-6">
                        <h5 class="general">Domicilio:</h5>
                        <input id="domicilio" class="form form-control" onkeypress="return check(event)" type="text" name="Tdomicilio" placeholder="Domicilio" autocomplete="new-password">
                      </div>
                    </div>
                    <div class="d-block d-lg-flex row">
                    <div class="col-lg-6">
                        <h5 class="general">Colonia:</h5>
                        <input id="colonia" class="form form-control" type="text" onkeypress="return check(event)" name="Tcolonia" placeholder="Colonia" autocomplete="new-password"><br>
                      </div>
                      <div class="col-lg-6">
                        <h5 class="general">Ciudad:</h5>
                        <input id="ciudad" class="form form-control" type="text" onkeypress="return check(event)" name="Tciudad" placeholder="Ciudad" autocomplete="new-password"><br>
                      </div>
                    </div>
                    <div class="d-block d-lg-flex row">
                    <div class="col-lg-6">
                        <h5 class="general">Estado:</h5>
                        <select class="form form-control" id="estado" name="Sestado">
                          <option value="Aguascalientes">Aguascalientes</option>
                          <option value="Baja California">Baja California	</option>
                          <option value="Baja California Sur">Baja California Sur</option>
                          <option value="Campeche">Campeche</option>
                          <option value="Chiapas">Chiapas</option>
                          <option value="Chihuahua">Chihuahua</option>
                          <option value="Ciudad de México">Ciudad de México</option>
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
                      <div class="col-lg-6">
                        <h5 class="general">Pais:</h5>
                        <input id="pais" class="form form-control" type="text" onkeypress="return check(event)" name="Tpais" placeholder="País" autocomplete="new-password"><br>
                      </div>
                    </div>
                    <div class="d-block d-lg-flex row">
                      <div class="col-lg-6">
                        <h5 class="importante">Teléfono:</h5>
                        <input id="telefono" class="form form-control" type="text" onkeypress="return check(event)" name="Ttelefono" placeholder="Teléfono" autocomplete="new-password"><br>
                      </div>
                      <div class="col-lg-6">
                        <h5 class="importante">Email:</h5>
                        <input id="email" class="form form-control" type="email" onkeypress="return check(event)" name="Temail" placeholder="Email" autocomplete="new-password"><br>
                      </div>
                    </div>

                        <input id="bclose" type="submit" class="mt-3 btn bg-dark text-white btn-lg btn-block" value="Guardar">
                      </form>
                      <div id="tableHolder" class="row justify-content-center"></div>
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
        <script src="../js/proveedores.js"></script>

      </body>

    </html>
