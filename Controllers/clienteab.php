<?php
include_once '../Models/Conexion.php';
require_once '../Models/Email.php';

if (
  !empty($_POST['Temail']) && isset($_POST['Trfc'])  && !empty($_POST['Tnombre'])  && isset($_POST['Tcp'])  && isset($_POST['Tcalle_numero'])
  && isset($_POST['Tcolonia'])  && !empty($_POST['DLlocalidad'])  && isset($_POST['Tmunicipio'])  && isset($_POST['Sestado'])  && !empty($_POST['Ttelefono'])
  && isset($_POST['Dfecha_nacimiento']) && isset($_POST['Ssexo']) && !empty($_POST['Sentrada_sistema'])  && !empty($_POST['Pcontrasena']) && isset($_POST['accion'])
) {

  $conexion = new Models\Conexion();
  $email = new Models\Email();
  $datos_verificar = array($_POST['Temail']);
  $consulta_verificar = "SELECT * FROM persona WHERE email = ?";
  $respuesta = json_encode($conexion->consultaPreparada($datos_verificar, $consulta_verificar, 2, 's', false, null));
  if ($respuesta == '[]') {
    $_POST['accion'] = 'false';
  } else {
    $_POST['accion'] = 'true';
  }

  if ($_POST['accion'] == 'false') {
    //guardar
    $datos_persona = array(
      $_POST['Temail'],
      $email->setEmail($_POST['Temail']),
      0,
      $_POST['Trfc'],
      $_POST['Tnombre'],
      $_POST['Tcp'],
      $_POST['Tcalle_numero'],
      $_POST['Tcolonia'],
      $_POST['DLlocalidad'],
      $_POST['Tmunicipio'],
      $_POST['Sestado'],
      "México",
      $_POST['Ttelefono'],
      $_POST['Dfecha_nacimiento'],
      $_POST['Ssexo'],
      0 //eliminado false
    );

    $datos_usuariocafi = array(
      $_POST['Temail'],
      "CEO",
      $_POST['Sentrada_sistema'],
      password_hash($_POST['Pcontrasena'], PASSWORD_DEFAULT),
      NULL
    );


    $consulta_persona = "INSERT INTO persona (email,vkey,verificado,rfc,nombre,cp,calle_numero,colonia,localidad,municipio,estado,pais,telefono,fecha_nacimiento,sexo,eliminado) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    $tipo_datos_persona = "ssissssssssssssi";
    $consulta_usuariocafi = "INSERT INTO usuarioscafi (email,acceso,entrada_sistema,contrasena,negocio) VALUES (?,?,?,?,?)";
    $tipo_datos_usuariocafi = "sssss";
    $result = $conexion->consultaPreparada($datos_persona, $consulta_persona, 1, $tipo_datos_persona, false, null);
    if ($result == 1) {
      echo $conexion->consultaPreparada($datos_usuariocafi, $consulta_usuariocafi, 1, $tipo_datos_usuariocafi, false, 3);
    } else {
      echo 0;
    }
    //respuesta al front

  } else {
    //editar  
    $datos_usuariocafi = array(
      $_POST['Trfc'],
      $_POST['Tnombre'],
      $_POST['Tcp'],
      $_POST['Tcalle_numero'],
      $_POST['Tcolonia'],
      $_POST['DLlocalidad'],
      $_POST['Tmunicipio'],
      $_POST['Sestado'],
      "México",
      $_POST['Ttelefono'],
      $_POST['Dfecha_nacimiento'],
      $_POST['Ssexo'],
      0,
      $_POST['Sentrada_sistema'],
      $_POST['Temail']
    );


    $editar = "UPDATE persona INNER JOIN usuarioscafi ON persona.email=usuarioscafi.email SET rfc= ?, nombre = ?, cp = ?, calle_numero = ?, colonia = ?, localidad = ?, municipio = ?, 
            estado = ?, pais = ?, telefono = ?,fecha_nacimiento= ?,sexo= ?,eliminado = ?, entrada_sistema = ? WHERE persona.email= ?";
    $tipo_datos = "ssssssssssssiss";
    //respuesta al front
    echo $conexion->consultaPreparada($datos_usuariocafi, $editar, 1, $tipo_datos, false, null);
  }
} else if (isset($_POST['tabla']) && $_POST['tabla'] === "tabla") {
  //obtencion del json para pintar la tabla
  $conexion = new Models\Conexion();
  $consulta = "SELECT persona.email,rfc,nombre,cp,calle_numero,colonia,localidad,municipio,estado,pais,telefono,fecha_nacimiento,
    sexo,entrada_sistema,contrasena FROM persona INNER JOIN usuarioscafi ON persona.email=usuarioscafi.email WHERE acceso = ? AND persona.eliminado = ?";
  $datos = array("CEO", 0);
  $jsonstring = json_encode($conexion->consultaPreparada($datos, $consulta, 2, "si", false, null));
  echo $jsonstring;
}

if (isset($_POST['array'])) {
  $conexion = new Models\Conexion();
  $data = json_decode($_POST['array']);
  $tipo_datos = "is";
  $consulta = "UPDATE persona INNER JOIN usuarioscafi ON usuarioscafi.email = persona.email  SET persona.eliminado = ? WHERE persona.email = ?";
  for ($i = 0; $i < count($data); $i++) {
    if ($data[$i] != '0') {
      $datos = array(1, $data[$i]);
      $result =  $respuesta = $conexion->consultaPreparada($datos, $consulta, 1, $tipo_datos, false, null);
    }
  }
  echo $result;
}
