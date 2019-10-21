<?php
session_start();
include_once '../Models/Conexion.php';

if(isset($_POST['Tnombre']) && isset($_POST['Sgiro']) && isset($_POST['Tcalle_numero']) && isset($_POST['Tcolonia']) 
&& isset($_POST['Tlocalidad']) && isset($_POST['Tmunicipio']) && isset($_POST['Sestado'])  && isset($_POST['Spais']) 
&& isset($_POST['Ttelefono']) && isset($_POST['Simpresora']) && isset($_POST['Sdueno']) && isset($_POST['idnegocios']))
{
    $conexion = new Models\Conexion();
    $datos_negocio = array(  
    $conexion->eliminar_simbolos($_POST['idnegocios']),
    $conexion->eliminar_simbolos($_POST['Tnombre']),
    $conexion->eliminar_simbolos($_POST['Sgiro']),
    $conexion->eliminar_simbolos($_POST['Tcalle_numero']),
    $conexion->eliminar_simbolos($_POST['Tcolonia']),
    $conexion->eliminar_simbolos($_POST['Tlocalidad']),
    $conexion->eliminar_simbolos($_POST['Tmunicipio']),
    $conexion->eliminar_simbolos($_POST['Sestado']),
    $conexion->eliminar_simbolos($_POST['Spais']),
    $conexion->eliminar_simbolos($_POST['Ttelefono']),
    $conexion->eliminar_simbolos($_POST['Simpresora']),
    $conexion->eliminar_simbolos($_POST['Sdueno']),
    $_SESSION['email']);

if($_POST['accion'] === 'false'){
    $consulta = "INSERT INTO negocios (idnegocios,nombre,giro,calle_numero,colonia,localidad,municipio,estado,pais,telefono,impresora,dueno,usuarioab) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";
    $tipo_datos = "sssssssssssss";
    echo $conexion->consultaPreparada($datos_negocio,$consulta,1,$tipo_datos,false);
    //respuesta al front
}else{
    $consulta= "UPDATE negocios SET nombre = ?, giro = ?, calle_numero = ?, colonia = ?, localidad = ?, municipio = ?, 
    estado = ?, pais = ?, telefono = ?,impresora = ?, dueno = ?, usuarioab = ? WHERE idnegocios = ?";
    $tipo_datos = "ssssssssssssi";
    echo $conexion->consultaPreparada($datos_negocio,$consulta,1,$tipo_datos,true);
    //respuesta al front
}


}else if(isset($_POST['tabla']) && $_POST['tabla'] ==="tabla"){
    //obtencion del json para pintar los renglones de la tabla
    $conexion = new Models\Conexion();
    $consulta = "SELECT * FROM negocios";
    $jsonstring = json_encode($conexion->obtenerDatosDeTabla($consulta));
    echo $jsonstring;
}else if(isset($_POST['combo']) && $_POST['combo'] === "combo"){
  //obtencion de json para pinta los renglones del combo box
  $conexion = new Models\Conexion();
  $consulta = "SELECT email FROM usuarioscafi WHERE acceso = ?";
  $datos = array("CEO");
  $jsonstring = json_encode($conexion->consultaPreparada($datos,$consulta,2,"s",false));
  echo $jsonstring; 
 }
?>