<?php
include_once '../Models/Conexion.php';

if (isset($_SESSION['email'])) {
    $conexion = new Models\Conexion();
    $consulta = "SELECT token FROM sesiones WHERE usuario = ?";
    $dato = array($_SESSION['email']);
    $result = $conexion->consultaPreparada($dato, $consulta, 2, "s", false,null);
    if (isset($result[0][0])) {
        $token = $result[0][0];
        if ($_SESSION['token'] != $token) {
            header("location: login.php?cerrar_sesion");
        }
    }
}
function privilegios($privilegios)
{
    if (!isset($_SESSION['acceso'])) {
        header("location: login.php?cerrar_sesion");
    } else if ($_SESSION['entrada_sistema'] != "A") {
        header("location: login.php?cerrar_sesion");
    }
    if ($privilegios === "Todos") {
        if ($_SESSION['acceso'] != "ManagerAB" && $_SESSION['acceso'] != "CEOAB") {
            header("location: login.php?cerrar_sesion");
        }
    } else if ($privilegios === "Superiores") {
        if ($_SESSION['acceso'] != "CEOAB") {
            header("location: login.php?cerrar_sesion");
        }
    }
}
