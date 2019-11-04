<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <title>Login</title>
    <link rel="stylesheet" href="../css/sweetalert.css">
    <script src="../js/sweetalert.js"></script>
    <script src="../js/sweetalert.min.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" href="img/logo/nav1.png">
</head>


<body style="background-color: white;">
  <div class="container text-center">

    <div id="index_logo" class="row d-block">
      <img src="../img/logo/2.png" alt="" id="logo" class="animaLogo">
      <div>


        <div id="index_form" class="card card-body row d-block col-md-4">
          <div class="mostrar" style="display: none">
            <div class="col-lg-12">
              <h5 class="general">Selecionar negocio:</h5>
              <select class="form form-control" id="Snegocios" name="Snegocio" required>
                <option value="">Elegir Sucursal</option>
              </select>
          </div>

          </div>
          <div class="ocultar">

          <legend>Ingrese su usuario y contraseña:</legend>
          <form class="form-group" id="formulario" action="login.html" method="post">
            <div id="mensaje" style="text-align: center; margin: 10px; font-weight: bold;"></div>
            <input id="email" class="index_input form-control" type="email" pattern= "[A-Za-z0-9_-@.]{1,15}" name="Temail" placeholder="Email" autocomplete="off" required ><br>
            <input id="contrasena" class="index_input form-control" pattern= "[A-Za-z0-9_-@.]{1,15}" type="password" name="Pcontrasena" value="" placeholder="Contraseña" required ><br>
            <input id="index_button" type="submit" class="btn btn-secondary btn-lg btn-block btn-dark" name="Login" value="Continuar">
          </form>
        </div>
      </div>

      </div>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
      <script src="../js/index.js"></script>
      <script src="../js/login.js"></script>
</body>

</html>

<?php



?>
