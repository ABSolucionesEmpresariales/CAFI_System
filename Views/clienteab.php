<?php
session_start();
require_once('../Controllers/seguridadAB.php');
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
  <link rel="icon" href="../img/logo/nav1.png">

  <title>Cliente AB</title>
  <script>
    function cerrar() {
      window.close();
    }
  </script>
</head>

<body>
  <?php
  $sel = "clientes";
  include("../Controllers/NavbarAB.php");
  ?>

  <div class="contenedor container-fluid">
    <div class="row align-items-start">
      <div class="col-lg-12">
        <div id="tableContainer" class="d-block col-lg-12">
          <div class="input-group mb-2">
          <div class="input-group-prepend">
            <div class="input-group-text">
              <i class="fa fa-search"></i>
            </div>
          </div>
          <div id="combo"></div>
          <input class="form-control col-12 col-lg-4" type="text" id="busqueda" onkeypress="return check(event)" onkeyup="busqueda()" placeholder="Buscar..." title="Type in a name" value="">
          </div>
          <div style="border-radius: 10px;" class="contenedorTabla table-responsive">
            <table style="border-radius: 10px;" class="table table-bordered table-hover table-striped table-light">
              <thead class="thead-dark">
                <tr class="encabezados">
                  <th class="text-nowrap text-center" onclick="sortTable(0)">EMAIL</th>
                  <th class="text-nowrap text-center" onclick="sortTable(1)">Verificación</th>
                  <th class="text-nowrap text-center" onclick="sortTable(2)">RFC</th>
                  <th class="text-nowrap text-center" onclick="sortTable(3)">Nombre</th>
                  <th class="text-nowrap text-center" onclick="sortTable(4)">Codigo Postal</th>
                  <th class="text-nowrap text-center" onclick="sortTable(5)">Calle</th>
                  <th class="text-nowrap text-center" onclick="sortTable(6)">Colonia</th>
                  <th class="text-nowrap text-center" onclick="sortTable(7)">Localidad</th>
                  <th class="text-nowrap text-center" onclick="sortTable(8)">Municipio</th>
                  <th class="text-nowrap text-center" onclick="sortTable(9)">Estado</th>
                  <th class="text-nowrap text-center" onclick="sortTable(10)">Pais</th>
                  <th class="text-nowrap text-center" onclick="sortTable(11)">Telefono</th>
                  <th class="text-nowrap text-center" onclick="sortTable(12)">Fecha nacimiento</th>
                  <th class="text-nowrap text-center" onclick="sortTable(13)">Sexo</th>
                  <th class="text-nowrap text-center" onclick="sortTable(14)">Entrada</th>
                </tr>
              </thead>
              <tbody id="cuerpo"></tbody>
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
  <script src="../js/clientes.js"></script>
</body>

</html>