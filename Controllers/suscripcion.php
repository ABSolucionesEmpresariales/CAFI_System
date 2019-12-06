<?php
session_start();
include_once '../Models/Conexion.php';


if (
    isset($_POST['Dfecha_activacion']) && isset($_POST['Dfecha_vencimiento']) && !empty($_POST['Sestado'])
    && !empty($_POST['Spaquete']) && isset($_POST['Susuario_extra'])  && isset($_POST['Tmonto'])
    && isset($_POST['idsuscripcion'])
) {
    $conexion = new Models\Conexion();
    $datos_suscripcion = array(
        $_POST['idsuscripcion'],
        $_POST['Dfecha_activacion'],
        $_POST['Dfecha_vencimiento'],
        $_POST['Sestado'],
        $_POST['Tmonto'],
        $_POST['Spaquete'],
        $_POST['Susuario_extra'],
        $_POST['Snegocio']
    );

        $consulta = "INSERT INTO suscripcion (idsuscripcion,fecha_activacion,fecha_vencimiento,estado,monto,paquete,usuario_extra,negocio) VALUES (?,?,?,?,?,?,?,?)";
        $tipo_datos = "ssssssss";
        $respuesta = $conexion->consultaPreparada($datos_suscripcion, $consulta, 1, $tipo_datos, false,null);
    echo $respuesta;
    //respuesta al front

} else if (isset($_POST['tabla']) && $_POST['tabla'] === "tabla") {
    //obtencion del json para pintar los renglones de la tabla
    $conexion = new Models\Conexion();
    $consulta = "SELECT idsuscripcion,fecha_activacion,fecha_vencimiento,suscripcion.estado,monto,paquete,
    usuario_extra,nombre,idnegocios,suscripcion.usuarioab FROM suscripcion INNER JOIN negocios ON idnegocios=negocio";
    $jsonstring = json_encode($conexion->obtenerDatosDeTabla($consulta));
    echo $jsonstring;
}