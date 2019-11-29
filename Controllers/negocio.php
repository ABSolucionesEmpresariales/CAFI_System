<?php
session_start();
include_once '../Models/Conexion.php';

if (
    empty($_POST['Tnombre']) && empty($_POST['Sgiro']) && empty($_POST['Tcalle_numero']) && empty($_POST['Tcolonia'])
    && empty($_POST['Tlocalidad']) && empty($_POST['Tmunicipio']) && empty($_POST['Sestado'])  && empty($_POST['Spais'])
    && isset($_POST['Ttelefono']) && empty($_POST['Simpresora']) && empty($_POST['Sdueno']) && isset($_POST['idnegocios'])
) {
    $conexion = new Models\Conexion();
    $datos_negocio = array(
        $_POST['idnegocios'],
        $_POST['Tnombre'],
        $_POST['Sgiro'],
        $_POST['Tcalle_numero'],
        $_POST['Tcolonia'],
        $_POST['Tlocalidad'],
        $_POST['Tmunicipio'],
        $_POST['Sestado'],
        $_POST['Spais'],
        $_POST['Ttelefono'],
        $_POST['Simpresora'],
        $_POST['Sdueno'],
        $_SESSION['email']
    );

    if ($_POST['accion'] === 'false') {
        $consulta = "INSERT INTO negocios (idnegocios,nombre,giro,calle_numero,colonia,localidad,municipio,estado,pais,telefono,impresora,dueno,usuarioab) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $tipo_datos = "sssssssssssss";
        echo $conexion->consultaPreparada($datos_negocio, $consulta, 1, $tipo_datos, false,null);
        //respuesta al front
    } else {
        $consulta = "UPDATE negocios SET nombre = ?, giro = ?, calle_numero = ?, colonia = ?, localidad = ?, municipio = ?, 
    estado = ?, pais = ?, telefono = ?,impresora = ?, dueno = ?, usuarioab = ? WHERE idnegocios = ?";
        $tipo_datos = "ssssssssssssi";
        echo $conexion->consultaPreparada($datos_negocio, $consulta, 1, $tipo_datos, true,null);
        //respuesta al front
    }
} else if (isset($_POST['tabla']) && $_POST['tabla'] === "tabla") {
    //obtencion del json para pintar los renglones de la tabla
    $conexion = new Models\Conexion();
    $consulta = "SELECT * FROM negocios";
    $jsonstring = json_encode($conexion->obtenerDatosDeTabla($consulta));
    echo $jsonstring;
} else if (isset($_POST['combo']) && $_POST['combo'] === "combo") {
    //obtencion de json para pinta los renglones del combo box
    $conexion = new Models\Conexion();
    $consulta = "SELECT email FROM usuarioscafi WHERE acceso = ?";
    $datos = array("CEO");
    $jsonstring = json_encode($conexion->consultaPreparada($datos, $consulta, 2, "s", false,null));
    echo $jsonstring;
}
