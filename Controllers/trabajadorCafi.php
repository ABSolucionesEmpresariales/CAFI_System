<?php
session_start();
require_once '../Models/Conexion.php';
require_once '../Models/Email.php';

if (
  !empty($_POST['Temail']) && isset($_POST['Trfc'])  && !empty($_POST['Tnombre'])  && isset($_POST['Tcp'])  && isset($_POST['Tcalle_numero'])
  && isset($_POST['Tcolonia'])  && !empty($_POST['DLlocalidad'])  && isset($_POST['Tmunicipio'])  && isset($_POST['Sestado']) && !empty($_POST['Ttelefono'])
  && isset($_POST['Dfecha_nacimiento']) && isset($_POST['Ssexo']) && !empty($_POST['Sacceso'])  && !empty($_POST['Sentrada_sistema'])  && !empty($_POST['Pcontrasena']) && isset($_POST['accion'])
) {
  function editar(){
    $conexion = new Models\Conexion();
    $datos_usuarioab = array(
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
      $_POST['Sacceso'],
      $_POST['Sentrada_sistema'],
      $_SESSION['negocio'],
      $_POST['Temail']
    );
    $editar = "UPDATE persona INNER JOIN usuarioscafi ON persona.email=usuarioscafi.email SET rfc= ?, nombre = ?, cp = ?, calle_numero = ?, colonia = ?, localidad = ?, municipio = ?, 
          estado = ?, pais = ?, telefono = ?,fecha_nacimiento= ?,sexo= ?, eliminado=?, acceso = ?, entrada_sistema = ?,negocio = ? WHERE persona.email= ?";
    $tipo_datos = "sssssssssssssssss";
    //respuesta al front
    echo $conexion->consultaPreparada($datos_usuarioab, $editar, 1, $tipo_datos, false, null);
  }

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
    $trabajadores = 0;
    $trabajadores_extra = 0;
    $datos_suscripcion = array($_SESSION['negocio']);
    $datos_contar = array($_SESSION['negocio'], "A");
    $consulta_usuarios = "SELECT paquete,usuario_extra FROM suscripcion WHERE negocio = ?";
    $consulta_contar = "SELECT COUNT(negocio) FROM usuarioscafi WHERE negocio = ? AND entrada_sistema = ?";
    $result_usuarios = $conexion->consultaPreparada($datos_suscripcion, $consulta_usuarios, 2, 'i', false, null);
    $trabajadores_extra = (int) $result_usuarios[0][1];
    $result_contar = $conexion->consultaPreparada($datos_contar, $consulta_contar, 2, 'is', false, null);
    if ($result_usuarios[0][0] == 1) {
      $trabajadores = 2 + $trabajadores_extra;
    } else if ($result_usuarios[0][0] == 2) {
      $trabajadores = 3 + $trabajadores_extra;
    } else if ($result_usuarios[0][0] == 3) {
      $trabajadores = 4 + $trabajadores_extra;
    }

    if ($trabajadores != (int) $result_contar[0][0]) {
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

      $datos_usuarioab = array(
        $_POST['Temail'],
        $_POST['Sacceso'],
        $_POST['Sentrada_sistema'],
        password_hash($_POST['Pcontrasena'], PASSWORD_DEFAULT),
        $_SESSION['negocio']
      );


      $consulta_persona = "INSERT INTO persona (email,vkey,verificado,rfc,nombre,cp,calle_numero,colonia,localidad,municipio,estado,pais,telefono,fecha_nacimiento,sexo,eliminado) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
      $tipo_datos_persona = "ssssssssssssssss";
      $consulta_usuarioab = "INSERT INTO usuarioscafi (email,acceso,entrada_sistema,contrasena,negocio) VALUES (?,?,?,?,?)";
      $tipo_datos_usuarioab = "sssss";
      $result = $conexion->consultaPreparada($datos_persona, $consulta_persona, 1, $tipo_datos_persona, false, null);
      if ($result == 1) {
        // $email->enviarEmailConfirmacion();
        echo $conexion->consultaPreparada($datos_usuarioab, $consulta_usuarioab, 1, $tipo_datos_usuarioab, false, null);
      } 
      
    }else {
        echo "exceso";
      }
    
      //respuesta al front
    
  } else {
      $consulta_estado = "SELECT entrada_sistema FROM usuarioscafi WHERE email = ?";
      $datos_estado = array($_POST['Temail']);
      $result_estado = $conexion->consultaPreparada($datos_estado, $consulta_estado, 2,'s', false, null);
    if($result_estado[0][0] != $_POST['Sentrada_sistema'] && $_POST['Sentrada_sistema'] == "A"){
      $trabajadores = 0;
      $trabajadores_extra = 0;
      $datos_suscripcion = array($_SESSION['negocio']);
      $datos_contar = array($_SESSION['negocio'], "A");
      $consulta_usuarios = "SELECT paquete,usuario_extra FROM suscripcion WHERE negocio = ?";
      $consulta_contar = "SELECT COUNT(negocio) FROM usuarioscafi WHERE negocio = ? AND entrada_sistema = ?";
      $result_usuarios = $conexion->consultaPreparada($datos_suscripcion, $consulta_usuarios, 2, 'i', false, null);
      $trabajadores_extra = (int) $result_usuarios[0][1];
      $result_contar = $conexion->consultaPreparada($datos_contar, $consulta_contar, 2, 'is', false, null);
      if ($result_usuarios[0][0] == 1) {
        $trabajadores = 2 + $trabajadores_extra;
      } else if ($result_usuarios[0][0] == 2) {
        $trabajadores = 3 + $trabajadores_extra;
      } else if ($result_usuarios[0][0] == 3) {
        $trabajadores = 4 + $trabajadores_extra;
      }
      if ($trabajadores != (int) $result_contar[0][0] ) {
        editar();
      }else{
        echo "exceso";
      }
    }else{
        editar();
    }
  }
}

if (isset($_POST['tabla'])) {
  $conexion = new Models\Conexion();
  $consulta = "SELECT persona.email,verificado,rfc,nombre,cp,calle_numero,colonia,localidad,municipio,estado,pais,telefono,fecha_nacimiento, sexo,acceso,entrada_sistema,negocio 
    FROM persona INNER JOIN usuarioscafi ON persona.email=usuarioscafi.email WHERE eliminado != ? 
    AND usuarioscafi.acceso != ? AND usuarioscafi.negocio = ?";
  $datos = array(1, "CEO", $_SESSION['negocio']);
  echo json_encode($conexion->consultaPreparada($datos, $consulta, 2, "isi", false, null));
}
if (isset($_POST['email']) && isset($_POST['eliminado']) && $_POST['eliminado'] == 'true') {
  $conexion = new Models\Conexion();
  $email = $conexion->eliminar_simbolos($_POST['email']);
  $consulta = "UPDATE persona SET eliminado = ? WHERE email= ?";
  $datos = array(1, $email);
  echo $conexion->consultaPreparada($datos, $consulta, 1, "is", false, null);
}

if (isset($_POST['array'])) {
  $conexion = new Models\Conexion();
  $data = json_decode($_POST['array']);
  $tipo_datos = "iss";
  $consulta = "UPDATE usuarioscafi INNER JOIN persona ON usuarioscafi.email = persona.email  SET eliminado = ? , usuarioscafi.entrada_sistema = ? WHERE usuarioscafi.email = ?";
  for ($i = 0; $i < count($data); $i++) {
    if ($data[$i] != '0') {
      $datos = array(1, "I", $data[$i]);
      $result =  $respuesta = $conexion->consultaPreparada($datos, $consulta, 1, $tipo_datos, false, null);
    }
    if (empty($result)) {
      echo $result;
    } else {
      echo '0';
    }
  }
}
