<?php
session_start();
require_once '../Models/Conexion.php';
require_once '../Models/Fecha.php';
require_once 'token.php';
if (isset($_POST['Pcontrasena']) && isset($_POST['Temail'])) {
    $conexion = new Models\Conexion();

    $login = array(
        $_POST['Temail']
    );

    $consulta = "SELECT email,acceso,entrada_sistema,contrasena,negocio FROM usuarioscafi WHERE BINARY email = ?";
    $tipo_datos = "s";
    $respuesta = json_encode($conexion->consultaPreparada($login, $consulta, 2, $tipo_datos, false, null));
    $result = json_decode($respuesta);
    if ($respuesta != "[]") {
        if (password_verify($_POST['Pcontrasena'], $result[0][3])) {
            echo $respuesta;
            $negocio = $result[0][4];
          
        } else {
            $respuesta = "[]";
            echo $respuesta;
        }
    }

    if ($respuesta === "[]") {
        $consulta = "SELECT email,acceso,entrada_sistema,contrasena FROM usuariosab WHERE BINARY  email = ?";
        $tipo_datos = "s";
        //para el front
        $respuesta = json_encode($conexion->consultaPreparada($login, $consulta, 2, $tipo_datos, false, null));
        $result = json_decode($respuesta);
        if ($respuesta != "[]") {
            if (password_verify($_POST['Pcontrasena'], $result[0][3])) {
                echo $respuesta;
            } else {
                $respuesta = "[]";
                echo $respuesta;
            }
        }
    }
    //para el back

    if ($respuesta != "[]" && $result[0][2] === "A") {
        $_SESSION['email'] = $result[0][0];
        $_SESSION['acceso'] = $result[0][1];
        $_SESSION['entrada_sistema'] = $result[0][2];
        if (isset($negocio)) {
            $_SESSION['negocio'] = $negocio;
        }
        token();
    }
}
if (isset($_POST['combo']) && $_POST['combo'] === "combo") {
    $conexion = new Models\Conexion();
    $consulta = "SELECT idnegocios,nombre FROM negocios WHERE dueno = ?";
    $dato = array($_SESSION['email']);
    echo json_encode($conexion->consultaPreparada($dato, $consulta, 2, "s", false, null));
}


if (isset($_POST['negocio'])) {
    $_SESSION['negocio'] =  Models\Conexion::eliminar_simbolos($_POST['negocio']);
    echo "exito";
}

if (isset($_GET['cerrar_sesion'])) {
    tokenSalida();
    session_unset();
    session_destroy();
    header('Location: ./../Views/login.php');
    //se destruye la sesion al dar click en los botones de salir
}

if (isset($_POST['accesoPersona'])) {
    echo $_SESSION['acceso'];
}
