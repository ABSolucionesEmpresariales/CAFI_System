<?php
include_once '../Models/Conexion.php';

if (
  isset($_POST['Temail']) && isset($_POST['Trfc'])  && isset($_POST['Tnombre'])  && isset($_POST['Tcp'])  && isset($_POST['Tcalle_numero'])
  && isset($_POST['Tcolonia'])  && isset($_POST['Tlocalidad'])  && isset($_POST['Tmunicipio'])  && isset($_POST['Sestado']) && isset($_POST['Tpais'])  && isset($_POST['Ttelefono'])
  && isset($_POST['Dfecha_nacimiento']) && isset($_POST['Ssexo']) && isset($_POST['Sacceso'])  && isset($_POST['Sentrada_sistema'])  && isset($_POST['Pcontrasena']) && isset($_POST['accion'])
) {

  $conexion = new Models\Conexion();

  if ($_POST['accion'] == 'false') {
    //guardar
    $datos_persona = array(
     $_POST['Temail'],
     $_POST['Trfc'],
     $_POST['Tnombre'],
     $_POST['Tcp'],
     $_POST['Tcalle_numero'],
     $_POST['Tcolonia'],
     $_POST['Tlocalidad'],
     $_POST['Tmunicipio'],
     $_POST['Sestado'],
     $_POST['Tpais'],
     $_POST['Ttelefono'],
     $_POST['Dfecha_nacimiento'],
     $_POST['Ssexo'],
      0 //eliminado false
    );

    $datos_usuarioab = array(
     $_POST['Temail'],
     $_POST['Sacceso'],
     $_POST['Sentrada_sistema'],
     $_POST['Pcontrasena']
    );


    $consulta_persona = "INSERT INTO persona (email,rfc,nombre,cp,calle_numero,colonia,localidad,municipio,estado,pais,telefono,fecha_nacimiento,sexo,eliminado) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    $tipo_datos_persona = "sssssssssssssi";
    $consulta_usuarioab = "INSERT INTO usuariosab (email,acceso,entrada_sistema,contrasena) VALUES (?,?,?,?)";
    $tipo_datos_usuarioab = "ssss";
    $result = $conexion->consultaPreparada($datos_persona, $consulta_persona, 1, $tipo_datos_persona, false);
    //respuesta al front
    echo $conexion->consultaPreparada($datos_usuarioab, $consulta_usuarioab, 1, $tipo_datos_usuarioab, false);
  } else {
    //editar  
    $datos_usuarioab = array(
      $_POST['Trfc'],
      $_POST['Tnombre'],
      $_POST['Tcp'],
      $_POST['Tcalle_numero'],
      $_POST['Tcolonia'],
      $_POST['Tlocalidad'],
      $_POST['Tmunicipio'],
      $_POST['Sestado'],
      $_POST['Tpais'],
      $_POST['Ttelefono'],
      $_POST['Dfecha_nacimiento'],
      $_POST['Ssexo'],
      $_POST['Sacceso'],
      $_POST['Sentrada_sistema'],
      $_POST['Pcontrasena'],
      $_POST['Temail']
    );

    $editar = "UPDATE persona INNER JOIN usuariosab ON persona.email=usuariosab.email SET rfc= ?, nombre = ?, cp = ?, calle_numero = ?, colonia = ?, localidad = ?, municipio = ?, 
            estado = ?, pais = ?, telefono = ?,fecha_nacimiento= ?,sexo= ?, acceso = ?, entrada_sistema = ?, contrasena = ? WHERE persona.email= ?";
    $tipo_datos = "ssssssssssssssss";
    //respuesta al front
    echo $conexion->consultaPreparada($datos_usuarioab, $editar, 1, $tipo_datos, false);
  }
} else if (isset($_POST['tabla']) && $_POST['tabla'] === "tabla") {
  //obtencion del json para pintar la tabla
  $conexion = new Models\Conexion();
  $consulta = "SELECT persona.email,rfc,nombre,cp,calle_numero,colonia,localidad,municipio,estado,pais,telefono,fecha_nacimiento,
    sexo,acceso,entrada_sistema,contrasena FROM persona INNER JOIN usuariosab ON persona.email=usuariosab.email WHERE eliminado != ?";
  $datos = array(1);

  $jsonstring = json_encode($conexion->consultaPreparada($datos, $consulta, 2, "i", false));
  echo $jsonstring;
} else if (isset($_POST['email']) && isset($_POST['eliminado']) && $_POST['eliminado'] == 'true') {
  $conexion = new Models\Conexion();
  $email = $conexion->eliminar_simbolos($_POST['email']);
  $consulta = "UPDATE persona SET eliminado = ? WHERE email= ?";
  $datos = array(1, $email);
  echo $conexion->consultaPreparada($datos, $consulta, 1, "is", false);
}
