<?php
session_start();
require_once '../Models/Conexion.php';
require_once 'token.php';
if (isset($_POST['Pcontrasena']) && isset($_POST['Temail'])) {
    $conexion = new Models\Conexion();

    $login = array(
        $_POST['Temail'],
        $_POST['Pcontrasena']
    );

    $consulta = "SELECT email,acceso,entrada_sistema,negocio FROM usuarioscafi WHERE BINARY  email = ?  AND BINARY contrasena = ?";
    $tipo_datos = "ss";
    $respuesta = json_encode($conexion->consultaPreparada($login, $consulta, 2, $tipo_datos, false));

    if ($respuesta === "[]") {
        $consulta = "SELECT email,acceso,entrada_sistema FROM usuariosab WHERE BINARY  email = ?  AND BINARY contrasena = ?";
        $tipo_datos = "ss";
        //para el front
        $respuesta = json_encode($conexion->consultaPreparada($login,$consulta,2,$tipo_datos,false));
    }
    //para el back
    $result = json_decode($respuesta);
    if ($respuesta != "[]" && $result[0][2] === "A") {
        $_SESSION['email'] = $result[0][0];
        $_SESSION['acceso'] = $result[0][1];
        $_SESSION['entrada_sistema'] = $result[0][2];
        if (isset($result[0][3])) {
            $_SESSION['negocio'] = $result[0][3];
        }
        token();
    }
     echo  $respuesta;
    
    }
    if(isset($_POST['combo']) && $_POST['combo'] === "combo"){
        $conexion = new Models\Conexion();
        $consulta="SELECT idnegocios,nombre FROM negocios WHERE dueno = ?";
        $dato = array($_SESSION['email']);
        echo json_encode($conexion->consultaPreparada($dato,$consulta,2,"s",false));
    }

    if(isset($_POST['negocio'])){
        $_SESSION['negocio'] =  Models\Conexion::eliminar_simbolos($_POST['negocio']);
        echo "exito";
    }


if (isset($_GET['cerrar_sesion'])) {
    session_unset();
    session_destroy();
    header('Location: ./../Views/login.php');
    //se destruye la sesion al dar click en los botones de salir
}
