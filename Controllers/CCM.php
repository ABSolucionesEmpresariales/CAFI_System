<?php 
session_start();
include_once '../Models/Conexion.php';

    if(isset($_POST['CCM'])){
        $conexion = new Models\Conexion();
        $consulta_color = "INSERT INTO ccm (id,tipo,nombre,usuariocafi,negocio,eliminado) VALUES (?,?,?,?,?,?)";
        $datos_color = array(null,$_POST['CCM'],$_POST['CCMInput'],$_SESSION['email'],$_SESSION['negocio'],0);
        $tipo_datos_color = "isssii";
        $respuesta = $conexion->consultaPreparada($datos_color, $consulta_color,1, $tipo_datos_color, false);
        echo $respuesta;
    }

    if(isset($_POST['array'])){
        $conexion = new Models\Conexion();
        $data = json_decode($_POST['array']);
        $tipo_datos = "ii";
        $consulta = "UPDATE ccm SET eliminado = ? WHERE id = ?";
        for($i = 0; $i < count($data); $i++){
            if($data[$i] != '0'){
                $datos = array(1,$data[$i]);
                $respuesta = $conexion->consultaPreparada($datos, $consulta,1, $tipo_datos, false);
                if($respuesta != 1){
                    echo "error";
                }
            }
        }
        echo "sussesful";
    }

    if(isset($_POST['tablaColores'])){
        $conexion = new Models\Conexion();
        $datos = array(0,'Color',$_SESSION['negocio']);
        $tipo = "isi";
        $consulta = "SELECT * FROM ccm WHERE eliminado = ? AND tipo = ? AND negocio = ?";
        $jsonstring = json_encode($conexion->consultaPreparada($datos, $consulta,2, $tipo, false));
        echo $jsonstring;
    }

    if(isset($_POST['tablaMarcas'])){
        $conexion = new Models\Conexion();
        $datos = array(0,'Marca',$_SESSION['negocio']);
        $tipo = "isi";
        $consulta = "SELECT * FROM ccm WHERE eliminado = ? AND tipo = ? AND negocio = ?";
        $jsonstring = json_encode($conexion->consultaPreparada($datos, $consulta,2, $tipo, false));
        echo $jsonstring;
    }

    if(isset($_POST['tablaCategoria'])){
        $conexion = new Models\Conexion();
        $datos = array(0,'Categoria',$_SESSION['negocio']);
        $tipo = "isi";
        $consulta = "SELECT * FROM ccm WHERE eliminado = ? AND tipo = ? AND negocio = ?";
        $jsonstring = json_encode($conexion->consultaPreparada($datos, $consulta,2, $tipo, false));
        echo $jsonstring;
    }


?>