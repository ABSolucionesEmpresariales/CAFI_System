<?php
session_start();
require_once "Config/Autoload.php";
Config\Autoload::run();
if (!isset($_SESSION['acceso'])) {
    header('location: index.php');
} else if ($_SESSION['estado'] == "I") {
    header('location: index.php');
} else if (
    $_SESSION['acceso'] != "Manager"
) {
    header('location: OPCAFI.php');
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/sweetalert.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">

    <script src="js/sweetalert.js"></script>
    <script src="js/sweetalert.min.js"></script>
    <script src="js/jquery.js"></script>

    <title>Clientes</title>
</head>


<body onload="inicio(); " onkeypress="parar();" onclick="parar();" style="background: #f2f2f2;">
    <?php
    $sel = "clientes";
    include("Navbar.php")
    ?>
    <!-- Modal -->
    <div class="modal fade" id="modalForm" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">×</span>
                        <span class="sr-only">Close</span>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <p class="statusMsg"></p>
                    <form class="form-group" action="#" method="post">
                        <div class="row">
                            <div class="col-lg-4">
                                <h5>Nombre:</h5>
                                <input id="nombre" class="form form-control" type="text" name="TNombre" placeholder="Nombre" autocomplete="off" required>
                            </div>
                            <div class="col-lg-4">
                                <h5>Apellido Paterno:</h5>
                                <input id="apt" class="form form-control" type="text" name="TApellidoP" placeholder="Apellido Paterno" autocomplete="off" required>
                            </div>
                            <div class="col-lg-4">
                                <h5>Apellido Materno:</h5>
                                <input id="apm" class="form form-control" type="text" name="TApellidoM" placeholder="Apellido Materno" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <h5>Documento:</h5>

                                <div class="row" style="margin: 0 auto;">
                                    <div class="form-check-inline">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" id="doc" name="RDoc" value="INE" checked autofocus>INE
                                        </label>
                                    </div>
                                    <div class="form-check-inline">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" id="doc" name="RDoc" value="CURP">CURP
                                        </label>
                                    </div>
                                    <div class="form-check-inline">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" id="doc" name="RDoc" value="Otro">Otro
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <h5># Documento:</h5>
                                <input id="numdoc" class="form form-control" type="text" name="TNumDoc" placeholder="Numero del Documento" autocomplete="off" required>
                            </div>
                            <div class="col-lg-4">
                                <h5>Direccion:</h5>
                                <input id="dir" class="form form-control" type="text" name="TDireccion" placeholder="Direccion" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <h5>Telefono:</h5>
                                <input id="tel" class="form form-control" type="text" name="TTelefono" placeholder="Telefono" required>
                            </div>
                            <div class="col-lg-4">
                                <h5>Correo electrónico:</h5>
                                <input id="email" class="form form-control" type="text" name="TCorreo" placeholder="correo@dominio.com">
                            </div>
                            <div class="col-lg-4">
                                <h5>Estado:</h5>

                                <div class="row" style="margin-left: 5px;">
                                    <div class="form-check-inline">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" id="estado" name="REstado" value="A" checked autofocus>Activo
                                        </label>
                                    </div>
                                    <div class="form-check-inline">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" id="estado" name="REstado" value="I">Inactivo
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <input type="submit" class="mt-3 btn btn-lg btn-block btn-primary" name="" value="Guardar">
                    </form>
                    <div id="tableHolder">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->

    <div class="contenedor container-fluid">
        <div class="row align-items-start">
            <div class="col-md-12">
              <div id="tableContainer" class="d-block col-lg-12">
                    <div class="input-group mb-2">
                        <button class="d-lg-none btn btn-primary col-12 mb-3 p-3" data-toggle="modal" data-target="#modalForm">Agregar</button>
                        <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fa fa-search"></i></div>
                        </div>
                        <input class="form-control col-12 col-lg-4" type="text" id="busqueda" onkeyup="busqueda()" placeholder="Buscar..." title="Type in a name" value="">
                        <button class="d-none d-lg-flex btn btn-primary ml-3" data-toggle="modal" data-target="#modalForm">Agregar</button>
                    </div>

                    <div class="contenedorTabla">
                        <table class="scroll table table-bordered table-hover fixed_headers table-responsive">
                            <thead class="thead-dark">
                                <tr class="encabezados">
                                    <th class="text-nowrap text-center" onclick="sortTable(0)">Nombre</th>
                                    <th class="text-nowrap text-center" onclick="sortTable(1)">Apellido Paterno</th>
                                    <th class="text-nowrap text-center" onclick="sortTable(2)">Apellido Materno</th>
                                    <th class="text-nowrap text-center" onclick="sortTable(3)">Tipo de Documento</th>
                                    <th class="text-nowrap text-center" onclick="sortTable(4)">Numero Documento</th>
                                    <th class="text-nowrap text-center" onclick="sortTable(5)">Direccion</th>
                                    <th class="text-nowrap text-center" onclick="sortTable(6)">Telefono</th>
                                    <th class="text-nowrap text-center" onclick="sortTable(7)">Correo</th>
                                    <th class="text-nowrap text-center" onclick="sortTable(8)">Estado</th>
                                    <th class="text-nowrap text-center" onclick="sortTable(9)">Acciones
                                    </tr>
                            </thead>

                    <tbody>
                        <?php
                        $negocio = $_SESSION['idnegocio'];
                        $con = new Models\Conexion();
                        $query = "SELECT * FROM cliente WHERE negocios_idnegocios ='$negocio' ORDER BY idcliente DESC";
                        $row = $con->consultaListar($query);

                        while ($renglon = mysqli_fetch_array($row)) {
                            ?>
                        <tr>
                            <td class="text-nowrap text-center"><?php echo $renglon['nombre']; ?></td>
                            <td class="text-nowrap text-center"><?php echo $renglon['apaterno']; ?></td>
                            <td class="text-nowrap text-center"><?php echo $renglon['amaterno']; ?></td>
                            <td class="text-nowrap text-center"><?php echo $renglon['tipo_documento']; ?></td>
                            <td class="text-nowrap text-center"><?php echo $renglon['numero_documento']; ?></td>
                            <td class="text-nowrap text-center"><?php echo $renglon['direccion']; ?></td>
                            <td class="text-nowrap text-center"><?php echo $renglon['telefono']; ?></td>
                            <td class="text-nowrap text-center"><?php echo $renglon['correo']; ?></td>
                            <td class="text-nowrap text-center"><?php echo $renglon['estado']; ?></td>
                            <td class="text-nowrap text-center" style="width:100px;">
                                <div class="row">
                                    <a style="margin: 0 auto;" class="btn btn-secondary" href="EditVCliente.php?id=<?php echo $renglon['idcliente'] ?>">
                                        <img src="img/edit.png">
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
      </div>
          </div>
</div>
    <?php
    if (
        isset($_POST['TNombre']) && isset($_POST['TApellidoP'])
        && isset($_POST['TApellidoM']) && isset($_POST['RDoc'])
        && isset($_POST['TNumDoc']) && isset($_POST['TDireccion'])
        && isset($_POST['TTelefono']) && isset($_POST['TCorreo'])
        && isset($_POST['REstado'])
    ) {
        $cliente = new Models\Cliente();
        $cliente->setNombre($_POST['TNombre']);
        $cliente->setApaterno($_POST['TApellidoP']);
        $cliente->setAmaterno($_POST['TApellidoM']);
        $cliente->setDocumento($_POST['RDoc']);
        $cliente->setNumDoc($_POST['TNumDoc']);
        $cliente->setDireccion($_POST['TDireccion']);
        $cliente->setTelefono($_POST['TTelefono']);
        $cliente->setCorreo($_POST['TCorreo']);
        $cliente->setEstado($_POST['REstado']);
        $result = $cliente->guardar($_SESSION['idnegocio'], $_SESSION['id']);
        if ($result === 1) {
            ?>
    <script>
        swal({
            title: 'Exito',
            text: 'Se han registrado los datos exitosamente!',
            type: 'success'
        });
    </script>

    <?php } else {
            ?>
    <script>
        swal({
            title: 'Error',
            text: 'No registrado compruebe los campos unicos!',
            type: 'error'
        });
    </script>
    <?php }
    }
    ?>
    <script src="js/user_jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
