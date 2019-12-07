<?php
include_once '../Models/Conexion.php';
if (isset($_POST['tabla']) && $_POST['tabla'] === "negocios") {
    //obtencion del json para pintar los renglones de la tabla
    $conexion = new Models\Conexion();
    $consulta = "SELECT * FROM negocios";
    $jsonstring = json_encode($conexion->obtenerDatosDeTabla($consulta));
    echo $jsonstring;
}else if (isset($_POST['tabla']) && $_POST['tabla'] === "clientes") {
    //obtencion del json para pintar la tabla
    $conexion = new Models\Conexion();
    $consulta = "SELECT persona.email,verificado,rfc,nombre,cp,calle_numero,colonia,localidad,municipio,estado,pais,telefono,fecha_nacimiento,
      sexo,entrada_sistema FROM persona INNER JOIN usuarioscafi ON persona.email=usuarioscafi.email WHERE acceso = ? AND persona.eliminado = ?";
    $datos = array("CEO", 0);
    $jsonstring = json_encode($conexion->consultaPreparada($datos, $consulta, 2, "si", false, null));
    echo $jsonstring;
  }else if (isset($_POST['tabla']) && $_POST['tabla'] === "suscripciones") {
    //obtencion del json para pintar los renglones de la tabla
    $conexion = new Models\Conexion();
    $consulta = "SELECT idsuscripcion,fecha_activacion,fecha_vencimiento,suscripcion.estado,monto,paquete,
    usuario_extra,nombre,idnegocios,suscripcion.usuarioab FROM suscripcion INNER JOIN negocios ON idnegocios=negocio";
    $jsonstring = json_encode($conexion->obtenerDatosDeTabla($consulta));
    echo $jsonstring;
} 