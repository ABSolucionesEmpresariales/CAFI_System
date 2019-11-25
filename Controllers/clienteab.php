<?php
include_once '../Models/Conexion.php';

if (
  isset($_POST['Temail']) && isset($_POST['Trfc'])  && isset($_POST['Tnombre'])  && isset($_POST['Tcp'])  && isset($_POST['Tcalle_numero'])
  && isset($_POST['Tcolonia'])  && isset($_POST['Tlocalidad'])  && isset($_POST['Tmunicipio'])  && isset($_POST['Sestado']) && isset($_POST['Tpais'])  && isset($_POST['Ttelefono'])
  && isset($_POST['Dfecha_nacimiento']) && isset($_POST['Ssexo']) && isset($_POST['Sentrada_sistema'])  && isset($_POST['Pcontrasena']) && isset($_POST['accion'])
) {

  $conexion = new Models\Conexion();

  $datos_verificar = array($_POST['Temail']);
  $consulta_verificar = "SELECT * FROM persona WHERE email = ?";
  $respuesta = json_encode($conexion->consultaPreparada($datos_verificar, $consulta_verificar,2,'s', false));
  if($respuesta == '[]'){
    $_POST['accion'] = 'false';
  }else{
    $_POST['accion'] = 'true';
  }

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

    $datos_usuariocafi = array(
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
    $result = $conexion->consultaPreparada($datos_persona, $consulta_persona, 1, $tipo_datos_persona, false);
    if($result == 1){
      echo $conexion->consultaPreparada($datos_usuariocafi, $consulta_usuariocafi, 1, $tipo_datos_usuariocafi, false);
    }else{
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
      $_POST['Tlocalidad'],
      $_POST['Tmunicipio'],
      $_POST['Sestado'],
      $_POST['Tpais'],
      $_POST['Ttelefono'],
      $_POST['Dfecha_nacimiento'],
      $_POST['Ssexo'],
      0,
      $_POST['Sentrada_sistema'],
      $_POST['Pcontrasena'],
      $_POST['Temail']
    );


    $editar = "UPDATE persona INNER JOIN usuarioscafi ON persona.email=usuarioscafi.email SET rfc= ?, nombre = ?, cp = ?, calle_numero = ?, colonia = ?, localidad = ?, municipio = ?, 
            estado = ?, pais = ?, telefono = ?,fecha_nacimiento= ?,sexo= ?,eliminado = ?, entrada_sistema = ?, contrasena = ? WHERE persona.email= ?";
    $tipo_datos = "ssssssssssssisss";
    //respuesta al front
    echo $conexion->consultaPreparada($datos_usuariocafi, $editar, 1, $tipo_datos, false);
  }
} else if (isset($_POST['tabla']) && $_POST['tabla'] === "tabla") {
  //obtencion del json para pintar la tabla
  $conexion = new Models\Conexion();
  $consulta = "SELECT persona.email,rfc,nombre,cp,calle_numero,colonia,localidad,municipio,estado,pais,telefono,fecha_nacimiento,
    sexo,entrada_sistema,contrasena FROM persona INNER JOIN usuarioscafi ON persona.email=usuarioscafi.email WHERE acceso = ? AND persona.eliminado = ?";
  $datos = array("CEO",0);
  $jsonstring = json_encode($conexion->consultaPreparada($datos, $consulta, 2, "si", false));
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
          $result =  $respuesta = $conexion->consultaPreparada($datos, $consulta, 1, $tipo_datos, false);
      }
  }
  echo $result;
}
