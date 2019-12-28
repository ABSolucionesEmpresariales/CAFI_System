<?php
include_once '../Models/Conexion.php';
include_once '../Models/Email.php';

if (
  !empty($_POST['Temail']) && isset($_POST['Trfc'])  && !empty($_POST['Tnombre'])  && isset($_POST['Tcp'])  && isset($_POST['Tcalle_numero'])
  && isset($_POST['Tcolonia'])  && !empty($_POST['DLlocalidad'])  && isset($_POST['Tmunicipio'])  && isset($_POST['Sestado'])  && !empty($_POST['Ttelefono'])
  && isset($_POST['Dfecha_nacimiento']) && isset($_POST['Ssexo']) && !empty($_POST['Sentrada_sistema'])  && !empty($_POST['Pcontrasena'])
) {
  $conexion = new Models\Conexion();
  $email = new Models\Email();

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
      "fijo",
      NULL,
      $_POST['Sentrada_sistema'],
      password_hash($_POST['Pcontrasena'], PASSWORD_DEFAULT),
      NULL
    );


    $consulta_persona = "INSERT INTO persona (email,vkey,verificado,rfc,nombre,cp,calle_numero,colonia,localidad,municipio,estado,pais,telefono,fecha_nacimiento,sexo,eliminado) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    $tipo_datos_persona = "ssissssssssssssi";
    $consulta_usuariocafi = "INSERT INTO usuarioscafi (email,acceso,tipo,fecha_vencimiento,entrada_sistema,contrasena,negocio) VALUES (?,?,?,?,?,?,?)";
    $tipo_datos_usuariocafi = "sssssss";
    $result = $conexion->consultaPreparada($datos_persona, $consulta_persona, 1, $tipo_datos_persona, false, null);
    if ($result == 1) {
      $total =  $conexion->consultaPreparada($datos_usuariocafi, $consulta_usuariocafi, 1, $tipo_datos_usuariocafi, false, 3);
      if($total == 1){

      }else{
        echo $total;
      }
    } else {
      echo 0;
    }
    //respuesta al front
} else if (isset($_POST['tabla']) && $_POST['tabla'] === "tabla") {
  //obtencion del json para pintar la tabla
  $conexion = new Models\Conexion();
  $consulta = "SELECT persona.email,rfc,nombre,cp,calle_numero,colonia,localidad,municipio,estado,pais,telefono,fecha_nacimiento,
    sexo,entrada_sistema FROM persona INNER JOIN usuarioscafi ON persona.email=usuarioscafi.email WHERE acceso = ? AND persona.eliminado = ?";
  $datos = array("CEO", 0);
  $jsonstring = json_encode($conexion->consultaPreparada($datos, $consulta, 2, "si", false, null));
  echo $jsonstring;
}