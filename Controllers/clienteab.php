<?php
include_once '../Models/Conexion.php';

if(isset($_POST['Temail']) && isset($_POST['Trfc'])  && isset($_POST['Tnombre'])  && isset($_POST['Tcp'])  && isset($_POST['Tcalle_numero'])
&& isset($_POST['Tcolonia'])  && isset($_POST['Tlocalidad'])  && isset($_POST['Tmunicipio'])  && isset($_POST['Sestado']) && isset($_POST['Tpais'])  && isset($_POST['Ttelefono'])
&& isset($_POST['Dfecha_nacimiento']) && isset($_POST['Ssexo']) && isset($_POST['Sentrada_sistema'] )  && isset($_POST['Pcontrasena']) && isset($_POST['accion']))
{

$conexion = new Models\Conexion();

if($_POST['accion'] == 'false'){
//guardar
$datos_persona = array();
$datos_usuariocafi = array();
array_push( $datos_persona,
            $conexion->eliminar_simbolos($_POST['Temail']),
            $conexion->eliminar_simbolos($_POST['Trfc']),
            $conexion->eliminar_simbolos($_POST['Tnombre']),
            $conexion->eliminar_simbolos($_POST['Tcp']),
            $conexion->eliminar_simbolos($_POST['Tcalle_numero']),
            $conexion->eliminar_simbolos($_POST['Tcolonia']),
            $conexion->eliminar_simbolos($_POST['Tlocalidad']),
            $conexion->eliminar_simbolos($_POST['Tmunicipio']),
            $conexion->eliminar_simbolos($_POST['Sestado']),
            $conexion->eliminar_simbolos($_POST['Tpais']),
            $conexion->eliminar_simbolos($_POST['Ttelefono']),
            $conexion->eliminar_simbolos($_POST['Dfecha_nacimiento']),
            $conexion->eliminar_simbolos($_POST['Ssexo']),
            0 //eliminado false
);

array_push( $datos_usuariocafi,       
           $conexion->eliminar_simbolos($_POST['Temail']),
           "CEO",
           $conexion->eliminar_simbolos($_POST['Sentrada_sistema']),
           $conexion->eliminar_simbolos($_POST['Pcontrasena']),
           NULL
        );

$consulta_persona = "INSERT INTO persona (email,rfc,nombre,cp,calle_numero,colonia,localidad,municipio,estado,pais,telefono,fecha_nacimiento,sexo,eliminado) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
$tipo_datos_persona = "sssssssssssssi";
$consulta_usuariocafi = "INSERT INTO usuarioscafi (email,acceso,entrada_sistema,contrasena,negocio) VALUES (?,?,?,?,?)";
$tipo_datos_usuariocafi = "sssss";
$result = $conexion->consultaPreparada($datos_persona,$consulta_persona,1,$tipo_datos_persona);
//respuesta al front
echo $conexion->consultaPreparada($datos_usuariocafi,$consulta_usuariocafi,1,$tipo_datos_usuariocafi);


        
}else{
  //editar  
  $datos_usuariocafi = array();
  array_push( $datos_usuariocafi, 

            $conexion->eliminar_simbolos($_POST['Trfc']),
            $conexion->eliminar_simbolos($_POST['Tnombre']),
            $conexion->eliminar_simbolos($_POST['Tcp']),
            $conexion->eliminar_simbolos($_POST['Tcalle_numero']),
            $conexion->eliminar_simbolos($_POST['Tcolonia']),
            $conexion->eliminar_simbolos($_POST['Tlocalidad']),
            $conexion->eliminar_simbolos($_POST['Tmunicipio']),
            $conexion->eliminar_simbolos($_POST['Sestado']),
            $conexion->eliminar_simbolos($_POST['Tpais']),
            $conexion->eliminar_simbolos($_POST['Ttelefono']),
            $conexion->eliminar_simbolos($_POST['Dfecha_nacimiento']),
            $conexion->eliminar_simbolos($_POST['Ssexo']),
            $conexion->eliminar_simbolos($_POST['Sentrada_sistema']),
            $conexion->eliminar_simbolos($_POST['Pcontrasena']),
            $conexion->eliminar_simbolos($_POST['Temail'])
          );
  
  $editar= "UPDATE persona INNER JOIN usuarioscafi ON persona.email=usuarioscafi.email SET rfc= ?, nombre = ?, cp = ?, calle_numero = ?, colonia = ?, localidad = ?, municipio = ?, 
            estado = ?, pais = ?, telefono = ?,fecha_nacimiento= ?,sexo= ?, entrada_sistema = ?, contrasena = ? WHERE persona.email= ?";
  $tipo_datos = "sssssssssssssss";
  //respuesta al front
  echo $conexion->consultaPreparada($datos_usuariocafi,$editar,1,$tipo_datos);
}
}else if(isset($_POST['tabla'])){
    //obtencion del json para pintar la tabla
    $conexion = new Models\Conexion();
    $consulta = "SELECT persona.email,rfc,nombre,cp,calle_numero,colonia,localidad,municipio,estado,pais,telefono,fecha_nacimiento,
    sexo,entrada_sistema,contrasena FROM persona INNER JOIN usuarioscafi ON persona.email=usuarioscafi.email WHERE acceso = ?";
    $datos = array();
    array_push($datos,"CEO");

    $jsonstring = json_encode($conexion->consultaPreparada($datos,$consulta,2,"s"));
    echo $jsonstring;
    
}
?>