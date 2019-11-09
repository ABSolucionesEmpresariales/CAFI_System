<?php
session_start();
include_once '../Models/Conexion.php';



if(isset($_POST['tabla'])){
    $conexion = new Models\Conexion();
    $consulta_tabla = "SELECT p.email,p.rfc,p.nombre,p.cp,p.calle_numero,p.colonia,p.localidad,p.municipio,
    p.estado,p.pais,p.telefono,p.fecha_nacimiento,p.sexo,c.credito,c.plazo_credito,c.limite_credito,c.usuariocafi 
    FROM persona p INNER JOIN cliente c WHERE p.email = c.email AND c.negocio = $_SESSION[negocio] AND p.eliminado = 0";
    $jsonstring = json_encode($conexion->obtenerDatosDeTabla($consulta_tabla));
    echo $jsonstring;
}

if (
    isset($_POST['Temail']) && isset($_POST['Trfc'])  && isset($_POST['Tnombre'])  && isset($_POST['Tcp'])  && isset($_POST['Tcalle_numero'])
    && isset($_POST['Tcolonia'])  && isset($_POST['Tlocalidad'])  && isset($_POST['Tmunicipio'])  && isset($_POST['Sestado']) && isset($_POST['Tpais'])  && isset($_POST['Ttelefono'])
    && isset($_POST['Dfecha_nacimiento']) && isset($_POST['Ssexo']) && isset($_POST['Scredito'])  && isset($_POST['Tplazo_credito']) && isset($_POST['Tlimite_credito'])
  ){

    function datos_persona($accion,$tipo_datos_persona,$tipo_datos_cliente){
    $conexion = new Models\Conexion();
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
          $consulta_persona = "";
          if($accion == false){
            $consulta_persona = "INSERT INTO persona (email,rfc,nombre,cp,calle_numero,colonia,localidad,municipio,estado,pais,telefono,fecha_nacimiento,sexo,eliminado) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
          }else{
            $consulta_persona = "UPDATE persona SET rfc= ?, nombre = ?, cp = ?, calle_numero = ?, colonia = ?, localidad = ?, municipio = ?, 
            estado = ?, pais = ?, telefono = ?,fecha_nacimiento= ?,sexo= ?, eliminado = ? WHERE email= ?";
          }
       
          $result = $conexion->consultaPreparada($datos_persona, $consulta_persona, 1, $tipo_datos_persona, $accion);
          if($result == 1){
                $datos_cliente = array(
                    $_POST['Temail'],
                    $_POST['Scredito'],
                    $_POST['Tplazo_credito'],
                    $_POST['Tlimite_credito'],
                    $_SESSION['negocio'],
                    $_SESSION['email']
                );
                $consulta_cliente = "";
                if($accion == false){
                    $consulta_cliente = "INSERT INTO cliente (email,credito,plazo_credito,limite_credito,negocio,usuariocafi) VALUE (?,?,?,?,?,?)";
                }else{
                    $consulta_cliente = "UPDATE cliente SET credito = ?, plazo_credito = ?, limite_credito = ?, negocio = ?, usuariocafi = ? WHERE email = ?";
                }
                return $conexion->consultaPreparada($datos_cliente, $consulta_cliente, 1, $tipo_datos_cliente, $accion);
          }else{
              return $result;
          }
    }

    if($_POST['accion'] == 'false'){
        $accion = false;
        $tipo_datos_persona = "sssssssssssssi";
        $tipo_datos_cliente = "ssiiis";
        echo datos_persona($accion,$tipo_datos_persona,$tipo_datos_cliente);
    }else{
        $accion = true;
        $tipo_datos_persona = "ssssssssssssis";
        $tipo_datos_cliente = "siiiss";
        echo datos_persona($accion,$tipo_datos_persona,$tipo_datos_cliente);
    }

    if (isset($_POST['array'])) {
      $conexion = new Models\Conexion();
      $data = json_decode($_POST['array']);
      $tipo_datos = "is";
      $consulta = "UPDATE cliente INNER JOIN persona ON cliente.email = persona.email  SET eliminado = ? WHERE cliente.email = ?";
      for ($i = 0; $i < count($data); $i++) {
          if ($data[$i] != '0') {
              $datos = array(1, $data[$i]);
              $result =  $respuesta = $conexion->consultaPreparada($datos, $consulta, 1, $tipo_datos, false);
          }
      }
      echo $result;
  }


  }


?>