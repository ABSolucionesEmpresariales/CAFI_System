<?php 
session_start();
include_once '../Models/Conexion.php';

    if(isset($_POST['CCM']) && $_POST['CCM'] == 'Color'){
        $conexion = new Models\Conexion();
        $consulta_color = "INSERT INTO colores (idcolores,color,usuariocafi,negocio,eliminado) VALUES (?,?,?,?,?)";
        $datos_color = array(null,$_POST['CCMInput'],$_SESSION['email'],$_SESSION['negocio'],0);
        $tipo_datos_color = "issii";
        $respuesta = $conexion->consultaPreparada($datos_color, $consulta_color,1, $tipo_datos_color, false);
        echo $respuesta;
    }

    if(isset($_POST['CCM']) && $_POST['CCM'] == 'Marca'){
        $conexion = new Models\Conexion();
        $consulta_marcas = "INSERT INTO marcas (idmarcas,marca,usuariocafi,negocio,eliminado) VALUES (?,?,?,?,?)";
        $datos_marcas = array(null,$_POST['CCMInput'],$_SESSION['email'],$_SESSION['negocio'],0);
        $tipo_datos_marcas = "issii";
        $respuesta = $conexion->consultaPreparada($datos_marcas, $consulta_marcas,1, $tipo_datos_marcas, false);
        echo $respuesta;
    }

    if(isset($_POST['CCM']) && $_POST['CCM'] == 'Categorias'){
        $conexion = new Models\Conexion();
        $consulta_categorias = "INSERT INTO categorias (idcategorias,categoria,usuariocafi,negocio,eliminado) VALUES (?,?,?,?,?)";
        $datos_categorias = array(null,$_POST['CCMInput'],$_SESSION['email'],$_SESSION['negocio'],0);
        $tipo_datos_categorias = "issii";
        $respuesta = $conexion->consultaPreparada($datos_categorias, $consulta_categorias,1, $tipo_datos_categorias, false);
        echo $respuesta;
    }

    if(isset($_POST['tablaColores'])){
        $conexion = new Models\Conexion();
        $datos = array(0);
        $tipo = "i";
        $consulta = "SELECT * FROM colores WHERE eliminado = ?";
        $jsonstring = json_encode($conexion->consultaPreparada($datos, $consulta,2, $tipo, false));
        echo $jsonstring;
    }

    if(isset($_POST['tablaMarcas'])){
        $conexion = new Models\Conexion();
        $datos = array(0);
        $tipo = "i";
        $consulta = "SELECT * FROM marcas WHERE eliminado = ?";
        $jsonstring = json_encode($conexion->consultaPreparada($datos, $consulta,2, $tipo, false));
        echo $jsonstring;
    }

    if(isset($_POST['tablaCategoria'])){
        $conexion = new Models\Conexion();
        $datos = array(0);
        $tipo = "i";
        $consulta = "SELECT * FROM categorias WHERE eliminado = ?";
        $jsonstring = json_encode($conexion->consultaPreparada($datos, $consulta,2, $tipo, false));
        echo $jsonstring;
    }


?>