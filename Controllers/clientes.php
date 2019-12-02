<?php
session_start();
require_once '../Models/Conexion.php';
require_once '../Models/Email.php';

if (isset($_POST['tabla'])) {
    $conexion = new Models\Conexion();
    $consulta_tabla = "SELECT p.email,verificado,p.rfc,p.nombre,p.cp,p.calle_numero,p.colonia,p.localidad,p.municipio,
    p.estado,p.pais,p.telefono,p.fecha_nacimiento,p.sexo,c.credito,c.plazo_credito,c.limite_credito,c.usuariocafi 
    FROM persona p INNER JOIN cliente c WHERE p.email = c.email AND c.negocio = $_SESSION[negocio] AND p.eliminado = 0";
    $jsonstring = json_encode($conexion->obtenerDatosDeTabla($consulta_tabla));
    echo $jsonstring;
}

if (
    !empty($_POST['Temail']) && isset($_POST['Trfc'])  && !empty($_POST['Tnombre'])  && isset($_POST['Tcp'])  && isset($_POST['Tcalle_numero'])
    && isset($_POST['Tcolonia'])  && !empty($_POST['DLlocalidad'])  && isset($_POST['Tmunicipio'])  && isset($_POST['Sestado']) && !empty($_POST['Ttelefono'])
    && isset($_POST['Dfecha_nacimiento']) && isset($_POST['Ssexo']) && !empty($_POST['Scredito'])  && isset($_POST['Tplazo_credito']) && isset($_POST['Tlimite_credito'])
) {

    function datos_persona($accion, $tipo_datos_persona, $tipo_datos_cliente)
    {
        $conexion = new Models\Conexion();
        $email = new Models\Email();
        $datos_persona = array(
            $_POST['Temail'],
            $email->setEmail($_POST['Temail']),
            0, // correo verificado false
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
        $consulta_persona = "";
        if ($accion == false) {
            $consulta_persona = "INSERT INTO persona (email,vkey,verificado,rfc,nombre,cp,calle_numero,colonia,localidad,municipio,estado,pais,telefono,fecha_nacimiento,sexo,eliminado) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
           // $email->enviarEmailConfirmacion();
        } else {
            unset($datos_persona[1],$datos_persona[2]);
            $datos_persona = array_values($datos_persona);
            $consulta_persona = "UPDATE persona SET  rfc= ?, nombre = ?, cp = ?, calle_numero = ?, colonia = ?, localidad = ?, municipio = ?, 
            estado = ?, pais = ?, telefono = ?,fecha_nacimiento= ?,sexo= ?, eliminado = ? WHERE email= ?";
        }

        $result = $conexion->consultaPreparada($datos_persona, $consulta_persona, 1, $tipo_datos_persona, $accion, null);
        if ($result == 1) {
            $datos_cliente = array(
                $_POST['Temail'],
                $_POST['Scredito'],
                $_POST['Tplazo_credito'],
                $_POST['Tlimite_credito'],
                $_SESSION['negocio'],
                $_SESSION['email']
            );
            $consulta_cliente = "";
            if ($accion == false) {
                $consulta_cliente = "INSERT INTO cliente (email,credito,plazo_credito,limite_credito,negocio,usuariocafi) VALUE (?,?,?,?,?,?)";
            } else {
                $consulta_cliente = "UPDATE cliente SET credito = ?, plazo_credito = ?, limite_credito = ?, negocio = ?, usuariocafi = ? WHERE email = ?";
            }
            return $conexion->consultaPreparada($datos_cliente, $consulta_cliente, 1, $tipo_datos_cliente, $accion, null);
        } else {
            return $result;
        }
    }
    $conexion = new Models\Conexion();
    $datos_verificar = array($_POST['Temail']);
    $consulta_verificar = "SELECT * FROM persona WHERE email = ?";
    $respuesta = json_encode($conexion->consultaPreparada($datos_verificar, $consulta_verificar,2,'s', false,null));
    if($respuesta == '[]'){
      $_POST['accion'] = 'false';
    }else{
      $_POST['accion'] = 'true';
    }

    if ($_POST['accion'] == 'false') {
        $accion = false;
        $tipo_datos_persona = "ssssssssssssssss";
        $tipo_datos_cliente = "ssssss";
        echo datos_persona($accion, $tipo_datos_persona, $tipo_datos_cliente);
    } else {
        $accion = true;
        $tipo_datos_persona = "ssssssssssssss";
        $tipo_datos_cliente = "ssssss";
        echo datos_persona($accion, $tipo_datos_persona, $tipo_datos_cliente);
    }
}

if (isset($_POST['array'])) {
    $conexion = new Models\Conexion();
    $data = json_decode($_POST['array']);
    $tipo_datos = "is";
    $consulta = "UPDATE persona INNER JOIN cliente ON cliente.email = persona.email  SET persona.eliminado = ? WHERE cliente.email = ?";
    for ($i = 0; $i < count($data); $i++) {
        if ($data[$i] != '0') {
            $datos = array(1, $data[$i]);
            $result =  $respuesta = $conexion->consultaPreparada($datos, $consulta, 1, $tipo_datos, false, null);
        }
    }
    echo $result;
}
