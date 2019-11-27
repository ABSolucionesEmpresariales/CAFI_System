<?php
session_start();
date_default_timezone_set("America/Mexico_City");
include_once '../Models/Conexion.php';
include_once '../Models/Fecha.php';

if(isset($_POST['Tabono']) && isset($_POST['Tcantidad']) && isset($_POST['idcpp']) && isset($_POST['totaldeuda'])){
     $forma = "Efectivo";
     if($_POST['accion'] == "true"){
     $forma = "Tarjeta";
     }
    $conexion = new Models\Conexion();
    $fecha = new Models\Fecha();
    //var_dump($_POST['Tabono'], $_POST['Tcantidad'], $_POST['idcpp'], $_POST['totaldeuda']);
    $datos_abono = array(
        NULL,
        "A",
        $fecha->getFecha(),
        $_POST['Tabono'],
        $_POST['idcpp'],
        $_SESSION['email'],
        $_SESSION['negocio'],
        0
    );
/*     var_dump(        
    NULL,
    "A",
    $fecha->getFecha(),
    $_POST['Tabono'],
    $_POST['idcpp'],
    $_SESSION['email'],
    $_SESSION['negocio'],
    0); */
    $consulta_abonos = "INSERT INTO abono_compras (idpago,estado,fecha_abono,abono,compra,usuariocafi,
    negocio,eliminado) VALUES(?,?,?,?,?,?,?,?)";
    $consulta_adeudo = "UPDATE cpp SET totaldeuda = ? WHERE idcpp = ?";
    $consulta_estado = "UPDATE cpp SET estado = ? WHERE idcpp = ?";
    $tipo_datos = "issiissi";
    $tipo_datos_adeudo = "di";
    $tipo = "sd";
    $datos = array("P",0.00);
    $datos_adeudo = array($_POST['totaldeuda'],$_POST['idcpp']);
    $result =  $conexion->consultaPreparada($datos_abono, $consulta_abonos,1, $tipo_datos, false,null);
    $_SESSION['abono'] = $conexion->optenerId();
    if($result == 1){
        $result2 =  $conexion->consultaPreparada($datos_adeudo, $consulta_adeudo,1, $tipo_datos_adeudo, false,null);
        echo $result2;
    }else{
        echo $result;
    }
    $conexion->consultaPreparada($datos, $consulta_estado,1, $tipo, false,null);
    
    
    
}

if(isset($_POST['tabla'])){
    $conexion = new Models\Conexion();
    $consulta_tabla = "SELECT cpp.idcpp,cpp.totaldeuda,cpp.anticipo,cpp.estado,cpp.compra,cpp.proovedor,cpp.eliminado 
    FROM cpp INNER JOIN compras ON compras.idcompras = cpp.compra WHERE cpp.eliminado = ? AND compras.negocio = ?";
    $datos = array(0,$_SESSION['negocio']);
    $jsonstring = json_encode($conexion->consultaPreparada($datos, $consulta_tabla,2,"ii", false,null));
    echo $jsonstring;
/*     $jsonstring = json_encode($conexion->consultaPreparada($datos, $consulta_tabla,2, "ii", false));
    var_dump($jsonstring);
    echo $jsonstring; */
}

if(isset($_POST['tabla_abonos_compras'])){
    $conexion = new Models\Conexion();
    $consulta_tabla = "SELECT * FROM abono_compras WHERE eliminado = 0";
    $jsonstring = json_encode($conexion->obtenerDatosDeTabla($consulta_tabla));
    echo $jsonstring;
}

if(isset($_POST['Sestado']) && isset($_POST['idpago'])){
    $conexion = new Models\Conexion();
    $consulta="";
    $datos = array($_POST['Sestado'],$_SESSION['email'],$_POST['idpago']);
    $tipo_datos = "ssi";
    if($_POST['Sestado'] == "A"){
        $consulta = "UPDATE cpp INNER JOIN abono_compras ON cpp.idcpp = abono_compras.compra 
        SET cpp.totaldeuda = (cpp.totaldeuda-abono_compras.abono),abono_compras.estado = ? ,abono_compras.usuariocafi = ?
        WHERE abono_compras.idpago = ?";
    }else{
        $consulta = "UPDATE cpp INNER JOIN abono_compras ON cpp.idcpp = abono_compras.compra 
        SET cpp.totaldeuda = (cpp.totaldeuda+abono_compras.abono),abono_compras.estado = ? ,abono_compras.usuariocafi = ?
        WHERE abono_compras.idpago = ?";
    }
    $result =  $conexion->consultaPreparada($datos, $consulta,1, $tipo_datos, false,null);
    $datos2 = array("A",0.00);
    $consulta="UPDATE cpp SET estado = ? WHERE totaldeuda != ?";
    $tipos = "si";
    $conexion->consultaPreparada($datos2, $consulta,1, $tipos, false,null);
    echo $result;
}

    if (isset($_POST['array']) && isset($_POST['tabla_afectada'])) {
    $conexion = new Models\Conexion();
    $data = json_decode($_POST['array']);
    $tipo_datos = "ii";
    if($_POST['tabla_afectada'] === "abono_compra"){
        $consulta = "UPDATE abono_compras SET eliminado = ? WHERE idpago = ?";
    }else if($_POST['tabla_afectada'] === "cpp"){
        $consulta = "UPDATE cpp SET eliminado = ? WHERE idcpp = ?";
    }
    for ($i = 0; $i < count($data); $i++) {
        if ($data[$i] != '0') {
            $datos = array(1, $data[$i]);
            $result =  $respuesta = $conexion->consultaPreparada($datos, $consulta, 1, $tipo_datos, false,null);
        }
    }
    echo $result;
}