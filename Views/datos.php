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

    <title>Facturas</title>
</head>


<body>
    <?php
    $sel = "datos";
    include("../Controllers/NavbarCafi.php");
    ?>
    <h3 class="text-white" style="margin-top: 6rem">Datos Fiscales</h3>
    <div>
        <label class="text-white" for="">Nombre:</label>
        <input type="text">
    </div>

    <div>
        <label class="text-white" for="">Editar RFC:</label>
        <input type="text">
    </div>

    <div>
        <label class="text-white" for="">Editar Regimen fiscal:</label>
        <input type="text">
    </div>

    <div>
        <label class="text-white" for="">Codigo Postal del negocio:</label>
        <input type="text">
    </div>

    <form action="" method="POST" enctype="multipart/form-data">
    <label class="text-white" for="">Archivo cer:</label>
      <input type="file" name="cer" />
      <label class="text-white" for="">Archivo key:</label>
      <input type="file" name="key" />
      <input value="Cargar" type="submit"/>
    </form>

    <h3 class="text-white" style="margin-top: 2rem">Datos Personales</h3>
    <div>
        <label class="text-white" for="">Telefono:</label>
        <input type="text">
    </div>

    <div>
        <label class="text-white" for="">Contrasena actual:</label>
        <input type="text">
        <label class="text-white" for="">Contrasena nueva:</label>
        <input type="text">
        <input value="Guardar Contrasena" type="submit"/>
    </div>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="../js/index.js"></script>
    <script src="../js/user_jquery.js"></script>
    <script src="../js/reportes.js"></script>
</body>
</html>