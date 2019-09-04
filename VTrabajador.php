<?php
session_start();

// se comprueba si hay un rol en la sesion si la cuenta esta activa y si ese rol es diferente a ceo

if (!isset($_SESSION['acceso'])) {
    header('location: index.php');
} else if ($_SESSION['estado'] == "I") {
    header('location: index.php');
} else if (
    $_SESSION['acceso'] != "CEO"
) {
    header('location: OPCAFI.php');
}

require_once "Config/Autoload.php";
Config\Autoload::run();
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/sweetalert.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="js/sweetalert.js"></script>
    <script src="js/sweetalert.min.js"></script>
    <script src="js/jquery.js"></script>

    <title>Trabajadores</title>
</head>

<body onload="inicio();">
    <?php 
        $sel = "trabajadores";
        include("NavbarD.php") 
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
                    <form class="form-group" id="formtrabajador">
                        <div class="d-block d-lg-flex row">
                            <div class="col-4">
                                <h5><label for="nombre" class="badge badge-primary">Nombre:</label></h5>
                                <input id="nombre" class="form form-control" type="text" name="TNombre" placeholder="Nombre" autocomplete="off" required>
                            </div>
                            <div class="col-4">
                                <h5><label for="apt" class="badge badge-primary">Apellido Paterno:</label></h5>
                                <input id="apt" class="form form-control" type="text" name="TApellidoP" placeholder="Apellido Paterno" autocomplete="off" required>
                            </div>
                            <div class="col-4">
                                <h5><label for="apm" class="badge badge-primary">Apellido Materno:</label></h5>
                                <input id="apm" class="form form-control" type="text" name="TApellidoM" placeholder="Apellido Materno" autocomplete="off" required>
                            </div>
                        </div>
                    </div>
                    <div class="d-block d-lg-flex row">
                            <div class="col-4">
                            <h5><label for="doc" class="badge badge-primary">Documento:</label></h5>
                            <select id="documento" class="form form-control">
                                <option value="INE">INE</option>
                                <option value="CURP">CURP</option>
                                <option value="Otro">Otro</option>
                            </select>
                            </div>
                            <div class="col-4">
                                <h5><label for="numdoc" class="badge badge-primary">Documento:</label></h5>
                                <input id="numdoc" class="form form-control" type="text" name="TNumDoc" placeholder="Numero del Documento" autocomplete="off" required>
                            </div>
                            <div class="col-4">
                                <h5><label for="dir" class="badge badge-primary">Direccion:</label></h5>
                                <input id="dir" class="form form-control" type="text" name="TDireccion" placeholder="Direccion" required autocomplete="off">
                            </div>
                    </div>
                    <div class="d-block d-lg-flex row">
                            <div class="col-4">
                                <h5><label for="tel" class="badge badge-primary">Telefono:</label></h5>
                                <input id="tel" class="form form-control" type="text" name="TTelefono" placeholder="Telefono" required autocomplete="off">
                            </div>
                            <div class="col-4">
                                <h5><label for="email" class="badge badge-primary">Correo electrónico:</label></h5>
                                <input id="email" class="form form-control" type="text" name="TCorreo" placeholder="correo@dominio.com" autocomplete="off">
                            </div>
                            <div class="col-4">
                                <h5><label for="acceso" class="badge badge-primary">Tipo de acceso:</label></h5>
                                <select id="acceso" class="form form-control">
                                    <option value="Manager">Manager</option>
                                    <option value="Employes">Employes</option>
                                </select>
                            </div>
                        </div>
                    <div class="row d-block d-lg-flex">
                        <div class="col-lg-4">
                            <h5><label for="login" class="badge badge-primary">Nombre de Usuario:</label></h5>
                            <input id="login" class="form form-control" type="text" name="TLogin" placeholder="Nombre de usuario" autocomplete="off" required>
                        </div>

                        <div class="col-lg-4">
                            <h5><label for="login" class="badge badge-primary">Contraseña:</label></h5>
                            <input id="contrasena" class="form form-control" type="text" name="TContrasena" placeholder="Contraseña" autocomplete="off" required>
                        </div>

                        <div class="col-lg-4">
                            <h5><label for="login" class="badge badge-primary">Sueldo:</label></h5>
                            <input id="sueldo" class="form form-control" type="text" name="TSueldo" placeholder="Sueldo" autocomplete="off" required>
                        </div>


                        <div class="row">
                            <div class="col-12">
                                <h5><label for="email" class="badge badge-primary">Agregarlo a:</label></h5>
                                <select id="agregarloa" class="form form-control" name="SSucursal" required>
                                    <?php
                                    $con = new Models\Conexion();
                                    $dueño = $_SESSION['id'];
                                    $query = "SELECT nombre_negocio, idnegocios FROM negocios 
                                                WHERE clientesab_idclienteab = '$dueño'";
                                    $row = $con->consultaListar($query);
                                    $con->cerrarConexion();
                                    $cont = 0;
                                    while ($renglon = mysqli_fetch_array($row)) {
                                        echo "<option value=".$renglon['idnegocios'].">" . $renglon['nombre_negocio'] . "</option>";
                                    }
                                    ?>
                                </select> <br>
                            </div>
                        </div>
                            <div class="col-4">
                                <h5><label  class="badge badge-primary">Estado:</label></h5>
                                <select id="estado" class="form form-control">
                                    <option value="A">Activo</option>
                                    <option value="I">Inactivo</option>
                                </select>
                            </div>
                        <div class="row">
                            <div class="col-12"><br>
                                <input id="bclose" type="submit" class="btn btn-lg btn-block btn-primary" name="" value="Guardar">
                            </div>
                        </div>
                    </div>
                </form>
                <div id="tableHolder">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
    <p id="nav-title" class="font-weight-bold">
    
    </p>
    <div class="contenedor container-fluid">
        <div class="row align-items-start">
            <div id="tableContainer" class="d-block col-lg-12">
                <div class="input-group mb-2">
                    <p>Sucursal:</p>
                    <form action="#" method="POST">
                        <select id="sucursal" class="form form-control" name="SNegocio">
                            <option></option>
                            <?php
                            $con = new Models\Conexion();
                            $dueño = $_SESSION['id'];
                            $query = "SELECT nombre_negocio, idnegocios FROM negocios 
                            WHERE clientesab_idclienteab = '$dueño'";
                            $row = $con->consultaListar($query);
                            $con->cerrarConexion();
                            while ($renglon = mysqli_fetch_array($row)) {
                    
                                echo "<option value=".$renglon['idnegocios'].">" . $renglon['nombre_negocio'] . "</option>";
                            }
                            ?>
                        </select>
                        <input type="submit" style="display: none;">
                    </form>
                    <button class="d-lg-none btn btn-primary col-12 mb-3 p-3" data-toggle="modal" data-target="#modalForm">Agregar</button>
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fa fa-search"></i></div>
                    </div>
                    <input class="form-control col-12 col-lg-4" type="text" id="busqueda" onkeyup="busqueda();" placeholder="Buscar..." title="Type in a name" value="">
                    <button class="d-none d-lg-flex btn btn-primary ml-3" data-toggle="modal" data-target="#modalForm">Agregar</button>
                </div>
                <div class="contenedorTabla table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-dark">
                            <tr class="encabezados">
                                <th onclick="sortTable(0)">Id trabajador</th>
                                <th onclick="sortTable(1)">Nombre</th>
                                <th onclick="sortTable(2)">Ap-P</th>
                                <th onclick="sortTable(3)">Ap-M</th>
                                <th onclick="sortTable(4)">Doc</th>
                                <th onclick="sortTable(5)">#Doc</th>
                                <th onclick="sortTable(6)">Direccion</th>
                                <th onclick="sortTable(7)">Telefono</th>
                                <th onclick="sortTable(8)">Email</th>
                                <th onclick="sortTable(9)">Acceso</th>
                                <th onclick="sortTable(10)">Usuario</th>
                                <th onclick="sortTable(11)">Contraseña</th>
                                <th onclick="sortTable(12)">Sueldo</th>
                                <th onclick="sortTable(13)">Estado</th>
                                <th onclick="sortTable(14)">id negocio</th>
                                <th onclick="sortTable(15)">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="cuerpo">
                        <?php
                                if (isset($_POST['SNegocio'])) {
                                            $_SESSION['idnegocio'] =  $_POST['SNegocio'];   
                                
                                } else {
                               
                                }?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php
        if(isset($_POST['BEdit'])){
            echo$_POST['BEdit'];
        }
        if (
            isset($_POST['TNombre']) && isset($_POST['TApellidoP'])
            && isset($_POST['TApellidoM']) && isset($_POST['RDoc'])
            && isset($_POST['TNumDoc']) && isset($_POST['TDireccion'])
            && isset($_POST['TTelefono']) && isset($_POST['TCorreo'])
            && isset($_POST['RAcceso'])  && isset($_POST['TLogin'])
            && isset($_POST['TPContraseña']) && isset($_POST['TSueldo'])
            && isset($_POST['SSucursal'])
            //se comprueba que existan todos los datos del formulario
        ) {
            $negocio = null;
            if (isset($_POST['SSucursal'])) {
                for ($i = 0; $i < sizeof($id); $i++) {
                    if (strcasecmp($_POST['SSucursal'], $nombre[$i]) == 0) {
                        $negocio = $id[$i];
                    }
                }
            }

            if ($result === 1) {
                ?>
        <script>
            swal({
                    title: 'Exito',
                    text: 'Se han registrado los datos exitosamente!',
                    type: 'success'
                },
                function(isConfirm) {
                    if (isConfirm) {
                        window.location.href = "VTrabajador.php";
                    }
                });
        </script>

        <?php } else {
                ?>
        <script>
            swal({
                    title: 'Error',
                    text: 'No se han guardado los datos compruebe los campos unicos',
                    type: 'error'
                },
                function(isConfirm) {
                    if (isConfirm) {
                        window.location.href = "VTrabajador.php";
                    }
                });
        </script>
        <?php }
        }
        ?>
        <script src="js/user_jquery.js"></script>
        <script src="js/vtrabajador.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>