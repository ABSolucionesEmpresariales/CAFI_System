<?php
session_start();
require_once '../Models/Conexion.php';

if (isset($_POST['tabla'])) {
    $conexion = new Models\Conexion();
    $consulta_tabla = "SELECT * FROM facturas WHERE emisor = $_SESSION[email]";
    $jsonstring = json_encode($conexion->obtenerDatosDeTabla($consulta_tabla));
    echo $jsonstring;
}

if (isset($_POST['array'])) {
    $conexion = new Models\Conexion();
    $data = json_decode($_POST['array']);
    $tipo_datos = "ii";
    $consulta = "UPDATE otros_ingresos SET eliminado = ? WHERE id_otros_ingresos = ?";
    for ($i = 0; $i < count($data); $i++) {
        if ($data[$i] != '0') {
            $datos = array(1, $data[$i]);
            $result =  $respuesta = $conexion->consultaPreparada($datos, $consulta, 1, $tipo_datos, false,null);
        }
    }
    echo $result;
}

if(!empty($_POST['Tcantidad']) && !empty($_POST['Stipo']) && !empty($_POST['Sforma_ingreso']) && !empty($_POST['Dfecha']) 
&& !empty($_POST['Sestado'])){
    $conexion = new Models\Conexion();
    if($_POST['accion'] == 'false'){
        $datos_ingresos = array(
            $_POST['id'],
            $_POST['Tcantidad'],
            $_POST['Stipo'],
            $_POST['Sforma_ingreso'],
            $_POST['Dfecha'],
            $_POST['Sestado'],
            $_SESSION['email'],
            $_SESSION['negocio'],
            0
        );
        $tipoDeDatos = "idsssssii";
        $consulta_registro_otros = "INSERT INTO otros_ingresos (id_otros_ingresos,cantidad,tipo,forma_ingreso,
        fecha,estado,usuariocafi,negocio,eliminado) VALUES (?,?,?,?,?,?,?,?,?)";
        echo $conexion->consultaPreparada($datos_ingresos, $consulta_registro_otros,1, $tipoDeDatos, false,null);
    }else{
        $datos_ingresos = array(
            $_POST['Sestado'],
            $_SESSION['email'],
            $_POST['id']
        );
        $tipo_datos = "ssi";
        $consulta_editar_ingresos = "UPDATE otros_ingresos SET estado = ?, usuariocafi = ? WHERE id_otros_ingresos = ?";
        echo $conexion->consultaPreparada($datos_ingresos, $consulta_editar_ingresos,1, $tipo_datos, false,null);
    }

}