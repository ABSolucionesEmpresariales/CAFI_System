<?php
session_start();
include_once '../Models/Conexion.php';
if (
    isset($_POST['idnegocios']) && !empty($_POST['Tnombre']) && !empty($_POST['Sgiro']) && isset($_POST['Tcp']) && !empty($_POST['Tcalle_numero']) && !isset($_POST['Tcp']) && !empty($_POST['Tcolonia'])
    && !empty($_POST['DLlocalidad']) && !empty($_POST['Tmunicipio']) && !empty($_POST['Sestado'])
    && isset($_POST['Ttelefono']) && !empty($_POST['Simpresora']) && !empty($_POST['Sdueno'])
) {
    $conexion = new Models\Conexion();
    $datos_negocio = array(
        $_POST['idnegocios'],
        $_POST['Tnombre'],
        $_POST['Sgiro'],
        $_POST['Tcp'],
        $_POST['Tcalle_numero'],
        $_POST['Tcolonia'],
        $_POST['DLlocalidad'],
        $_POST['Tmunicipio'],
        $_POST['Sestado'],
        "México",
        $_POST['Ttelefono'],
        $_POST['Simpresora'],
        $_POST['Sdueno']
    );
        $consulta = "INSERT INTO negocios (idnegocios,nombre,giro,cp,calle_numero,colonia,localidad,municipio,estado,pais,telefono,impresora,dueno) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $tipo_datos = "sssssssssssss";
        if($conexion->consultaPreparada($datos_negocio, $consulta, 1, $tipo_datos, false,null)){
            echo $conexion->optenerId();//Si se hace la consulta que retorne al javascript el ultimo id insertado en negocios, para poder insertarlo en suscripcion.
        }else{
            echo "0";
        }
    }else if (isset($_POST['tabla']) && $_POST['tabla'] === "tabla") {
    //obtencion del json para pintar los renglones de la tabla
    $conexion = new Models\Conexion();
    $consulta = "SELECT * FROM negocios";
    $jsonstring = json_encode($conexion->obtenerDatosDeTabla($consulta));
    echo $jsonstring;
}