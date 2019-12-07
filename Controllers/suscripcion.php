<?php
session_start();
include_once '../Models/Conexion.php';
include_once '../Models/Fecha.php';
if (!empty($_POST['Spaquete']) && isset($_POST['Susuario_extra'])  && isset($_POST['Tmonto'])
    && isset($_POST['idsuscripcion'])
) {
    $conexion = new Models\Conexion();
    $fecha = new Models\Fecha();
    $datos_suscripcion = array(
        $_POST['idsuscripcion'],
        $fecha->getFecha(),
        $fecha->getFechaVencimientoSuscripcion("mes"),
        "A",
        "prueba",
        $_POST['Tmonto'],
        $_POST['Spaquete'],
        $_POST['Susuario_extra'],
        $_POST['Snegocio']
    );

    $consulta = "INSERT INTO suscripcion (idsuscripcion,fecha_activacion,fecha_vencimiento,estado,tipo,monto,paquete,usuario_extra,negocio) VALUES (?,?,?,?,?,?,?,?,?)";
    $tipo_datos = "sssssssss";
    $respuesta = $conexion->consultaPreparada($datos_suscripcion, $consulta, 1, $tipo_datos, false, null);
    echo $respuesta;
    //respuesta al front

} else if (!empty($_POST['idsuscripcion']) && !empty($_POST['tiempo']) && !empty($_POST['pago'])) {

    $conexion = new Models\Conexion();
    $fecha = new Models\Fecha();
    $datos = array(
        $fecha->getFecha(),
        $fecha->getFechaVencimientoSuscripcion($_POST['tiempo']),
        "A",
        $_POST['idsuscripcion']
    );
    if ($_POST['pago'] === "SUCCESS") {
        $consulta = "UPDATE suscripcion SET fecha_activacion = ? , fecha_vencimiento = ? , estado = ? WHERE idsuscripcion = ?";
        echo  $conexion->consultaPreparada($datos, $consulta, 1, "ssss", false, null);
    }
} else if (isset($_POST['tabla']) && $_POST['tabla'] === "tabla") {
    //obtencion del json para pintar los renglones de la tabla
    $conexion = new Models\Conexion();
    $consulta = "SELECT idsuscripcion,fecha_activacion,fecha_vencimiento,suscripcion.estado,monto,paquete,
    usuario_extra,nombre,idnegocios,suscripcion.usuarioab FROM suscripcion INNER JOIN negocios ON idnegocios=negocio";
    $jsonstring = json_encode($conexion->obtenerDatosDeTabla($consulta));
    echo $jsonstring;
}
