<?php
require_once "Config/Autoload.php";
Config\Autoload::run();
session_start();
if (!isset($_SESSION['acceso']) && !isset($_SESSION['estado'])) {
    header('location: index.php');
} else if ($_SESSION['estado'] == "I") {
    header('location: index.php');
}

if(isset($_POST['username'])){
$con = new Models\Conexion();
$username = $_POST['username'];

 $query = "SELECT login FROM trabajador WHERE BINARY login = '$username'";

 $result = $con->consultaListar($query);
 if(mysqli_num_rows($result) > 0)
 {
  // username is already exist 
  echo '<div style="color: red;">Nombre de usuario no disponible</div>';
 }
 else
 {
  // username is avaialable to use.
  echo '<div style="color: green;">Nombre de usuario disponible</div>';
 }
}

if(isset($_POST['username2'])){
    $con = new Models\Conexion();
    $username = $_POST['username2'];

 $query = "SELECT login FROM usuariosab WHERE BINARY login = '$username'";

 $result = $con->consultaListar($query);
 if(mysqli_num_rows($result) > 0)
 {
  // username is already exist 
  echo '<div style="color: red;">Nombre de usuario no disponible</div>';
 }
 else
 {
  // username is avaialable to use.
  echo '<div style="color: green;">Nombre de usuario disponible</div>';
 }
}

if(isset($_POST['username3'])){
    $con = new Models\Conexion();
    $username = $_POST['username3'];

 $query = "SELECT login FROM clientesab WHERE BINARY login = '$username'";

 $result = $con->consultaListar($query);
 if(mysqli_num_rows($result) > 0)
 {
  // username is already exist 
  echo '<div style="color: red;">Nombre de usuario no disponible</div>';
 }
 else
 {
  // username is avaialable to use.
  echo '<div style="color: green;">Nombre de usuario disponible</div>';
 }
}
?>