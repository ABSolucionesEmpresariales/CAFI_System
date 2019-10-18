<?php

include_once '../Models/Conexion.php';

if(isset($_POST['Dfecha_activacion']) && isset($_POST['Dfecha_vencimiento']) && isset($_POST['Sestado']) 
&& isset($_POST['Tmonto']) && isset($_POST['Spaquete']) && isset($_POST['Susuario_extra']) && isset($_POST['Snegocio']))
{
    if($_POST['accion'] == 'false'){
    
    $conexion = new Models\Conexion();
    
    $idsuscripcion = NULL;
    $usuarioab = NULL;
    $datos_suscripcion = array();
    array_push( $datos_suscripcion,
                $idsuscripcion,
                $conexion->eliminar_simbolos($_POST['Dfecha_activacion']),
                $conexion->eliminar_simbolos($_POST['Dfecha_vencimiento']),
                $conexion->eliminar_simbolos($_POST['Sestado']),
                $conexion->eliminar_simbolos($_POST['Tmonto']),
                $conexion->eliminar_simbolos($_POST['Spaquete']),
                $conexion->eliminar_simbolos($_POST['Susuario_extra']),
                $conexion->eliminar_simbolos($_POST['Snegocio']),
                $usuarioab
    );
        $consulta = "INSERT INTO suscripcion (idsuscripcion,fecha_activacion,fecha_vencimiento,estado,monto,paquete,usuario_extra,negocio,usuarioab) VALUES (?,?,?,?,?,?,?,?,?)";
        $tipo_datos = "sssssssss";

    }else{
        echo "entro";
       
        $conexion = new Models\Conexion();

        $usuarioab= NULL;
        $datos_suscripcion = array();
        array_push( $datos_suscripcion,
                    $conexion->eliminar_simbolos($_POST['Dfecha_activacion']),
                    $conexion->eliminar_simbolos($_POST['Dfecha_vencimiento']),
                    $conexion->eliminar_simbolos($_POST['Sestado']),
                    $conexion->eliminar_simbolos($_POST['Tmonto']),
                    $conexion->eliminar_simbolos($_POST['Spaquete']),
                    $conexion->eliminar_simbolos($_POST['Susuario_extra']),
                    $usuarioab,
                    $conexion->eliminar_simbolos($_POST['idsuscripcion'])
        );
        $consulta= "UPDATE suscripcion SET fecha_activacion = ?, fecha_vencimiento = ?, estado = ?, monto = ?, paquete = ?, usuario_extra = ?, 
        usuarioab = ? WHERE idsuscripcion = ?";
        $tipo_datos = "ssssssss";

        //se cambia el estado a los usuarios pertenecientes a ese negocio

        $consulta2 = "UPDATE usuarioscafi SET entrada_sistema = ? WHERE negocio = ?";
        $datos_uscafi = array();
        array_push( $datos_uscafi,
                    $conexion->eliminar_simbolos($_POST['Sestado']),
                    $conexion->eliminar_simbolos($_POST['Snegocio'])
                   );
                   
    
    $respuesta = $conexion->consultaPreparada($datos_uscafi,$consulta,1,"si");
    }
    $respuesta = $conexion->consultaPreparada($datos_suscripcion,$consulta,1,$tipo_datos);

    echo $respuesta;
    //respuesta al front
    
    }else if(isset($_POST['tabla']) && $_POST['tabla'] === "tabla"){
    //obtencion del json para pintar los renglones de la tabla
    $conexion = new Models\Conexion();
    $consulta = "SELECT idsuscripcion,fecha_activacion,fecha_vencimiento,suscripcion.estado,monto,paquete,
    usuario_extra,nombre,suscripcion.usuarioab FROM suscripcion INNER JOIN negocios ON idnegocios=negocio";
    $jsonstring = json_encode($conexion->obtenerDatosDeTabla($consulta));
    echo $jsonstring;
    
}else if(isset($_POST['combo']) && $_POST['combo'] === "combo"){
  //obtencion de json para pinta los renglones del combo box
  $conexion = new Models\Conexion();
  $consulta = "SELECT idnegocios,nombre FROM negocios t1
  WHERE NOT EXISTS (SELECT NULL FROM suscripcion t2 WHERE t2.negocio = t1.idnegocios)";
   $jsonstring = json_encode($conexion->obtenerDatosDeTabla($consulta));
   echo $jsonstring;
 }
?>