<?php
session_start();
include '../Models/Archivos.php';
include_once '../Models/Conexion.php';

/*var_dump($_POST['Tcodigo_barras'],$_POST['Tmodelo'],$_POST['Tnombre'],$_POST['Tdescripcion'],
$_POST['Scategoria'],$_POST['Smarca'],$_POST['Tproveedor'],$_POST['Scolor'],
$_POST['Nprecio_compra'],
$_POST['Nprecio_venta'],
$_POST['Ndescuento'],
$_POST['Sunidad_medida'],
$_POST['Ntasa_iva'],
$_POST['Ntasa_ipes'],
$_POST['Stalla_numero'],
$_POST['accion'])
;*/
if (
    isset($_POST['Tcodigo_barras']) && isset($_POST['Tmodelo']) && isset($_POST['Tnombre']) && isset($_POST['Tdescripcion']) &&
    isset($_POST['Scategoria']) && isset($_POST['Smarca']) && isset($_POST['Tproveedor']) && isset($_POST['Scolor']) &&
     isset($_POST['Nprecio_compra']) && isset($_POST['Nprecio_venta']) && isset($_POST['Ndescuento'])
    && isset($_POST['Sunidad_medida']) && isset($_POST['Ntasa_iva']) && isset($_POST['Ntasa_ipes']) && isset($_POST['Stalla_numero'])
) {
    //>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>Funcion para no repetir codigo de guardar <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
    function guardar_datos_productos($estado_imagen,$accion)
    {
        $conexion = new Models\Conexion();
        $datos_productos = array(
            $_POST['Tcodigo_barras'],
            $_POST['Tmodelo'],
            $_POST['Tnombre'],
            $_POST['Tdescripcion'],
            $_POST['Scategoria'],
            $_POST['Smarca'],
            $_POST['Tproveedor'],
            $_POST['Scolor'],
            $estado_imagen,
            $_POST['Nprecio_compra'],
            $_POST['Nprecio_venta'],
            $_POST['Ndescuento'],
            $_POST['Sunidad_medida'],
            $_POST['Ntasa_iva'],
            $_POST['Ntasa_ipes'],
            $_POST['Stalla_numero'],
            $_SESSION['email']
        );

        if($accion == 1){
            $consulta_guardar_producto = "INSERT INTO producto (codigo_barras,modelo,nombre,descripcion,categoria,
            marca,proveedor,color,imagen,precio_compra,precio_venta,descuento,unidad_medida,tasa_iva,
            tasa_ipes,talla_numero,dueno) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $tipos_de_datos = "ssssssissdddsddss";
            $respuesta = $conexion->consultaPreparada($datos_productos, $consulta_guardar_producto,1, $tipos_de_datos, false);
            return $respuesta;
        }else{
            $consulta_editar_producto = "UPDATE producto SET modelo = ?,nombre = ?,descripcion = ?,categoria = ?,marca = ?,proveedor = ?,
            color = ?,imagen = ? ,precio_compra = ?,precio_venta = ?,descuento = ?,unidad_medida = ?,tasa_iva = ?,tasa_ipes = ?,
            talla_numero = ?,dueno = ? WHERE codigo_barras = ?";
            $tipos_de_datos = "sssssissdddsddsss";
            $respuesta = $conexion->consultaPreparada($datos_productos, $consulta_editar_producto,1, $tipos_de_datos, true);
            return $respuesta;

        }

    }


    //>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>Funcion guardar stock <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<


    function guardar_datos_stock($accion)
    {
        $conexion = new Models\Conexion();
        $datos_stock = array(
            $_POST['Tcodigo_barras'],
            "Almacen",
            11,
            2,
            "A",
            $_SESSION['email'],
            $_SESSION['negocio'],
            0
        );

        if($accion == 1){
            $consulta_guardar_stock = "INSERT INTO stock (producto,localizacion,stock,stock_minimo,estado,
            usuariocafi,negocio,eliminado) VALUES (?,?,?,?,?,?,?,?)";
            $tipos_de_datos_stock = "ssiissii";
            return $conexion->consultaPreparada($datos_stock, $consulta_guardar_stock, 1, $tipos_de_datos_stock, false);
        }else{
            $consulta_editar_stock = "UPDATE stock SET localizacion=?,stock=?,stock_minimio=?,estado=?,usuariocafi=?,
            negocio=?,eliminado=? WHERE producto=?";
            $tipos_de_datos_stock = "siissiis";
            return $conexion->consultaPreparada($datos_stock, $consulta_editar_stock, 1, $tipos_de_datos_stock, true);
        }

    }

    //>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> Obtener ruta de Imagen >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

    function ruta($codigo){
        $conexion = new Models\Conexion();
        $consulta = "SELECT imagen FROM producto WHERE codigo_barras = ?";
        $datos = array($codigo);
        $tipo = "s";
        $resul = $conexion->consultaPreparada($datos, $consulta,2, $tipo, false);
        return $resul[0][0];
    }




    //>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> Guardar datos <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<


    if ($_POST['accion'] == 'false') {
        if (strlen($_FILES['Fimagen']['tmp_name']) != 0) {
            $archivo = subir_archivo('Fimagen',1);
            if ($archivo == "Error") {
                echo $archivo;
            } else if ($archivo == "imagenNoValida") {
                echo $archivo;
            } else if ($archivo == "imagenGrande") {
                echo $archivo;
            } else {
                $respuesta = guardar_datos_productos($archivo,1);
                if ($respuesta != 0) {
                    echo guardar_datos_stock(1);
                } else {
                    echo $respuesta;
                }
            }
        } else {
            $respuesta = guardar_datos_productos("",1);
            if ($respuesta != 0) {
                echo guardar_datos_stock(1);
            } else {
                echo "Error2-2";
            }
        }
    } else {

        if (strlen($_FILES['Fimagen']['tmp_name']) != 0) {
            $ruta = ruta($_POST['Tcodigo_barras']);
             if($ruta != ""){
               if(!unlink($ruta)){
                    echo "Error Imagen";
               }
            }
            $archivo = subir_archivo('Fimagen',1);
            if ($archivo == "Error") {
                echo $archivo;
            } else if ($archivo == "imagenNoValida") {
                echo $archivo;
            } else if ($archivo == "imagenGrande") {
                echo $archivo;
            } else {
                $respuesta = guardar_datos_productos($archivo,2);
                if ($respuesta != 0) {
                    echo guardar_datos_stock(2);
                } else {
                    echo "Error2";
                }
            }
        }else{
            $respuesta = guardar_datos_productos("",2);
            if ($respuesta != 0) {
                echo guardar_datos_stock(2);
            } else {
                echo "Error2-2";
            }
        }
    }



}

if(isset($_POST['tabla'])){
    $conexion = new Models\Conexion();
    $consulta = "SELECT codigo_barras,modelo,nombre,descripcion,categoria,marca,proveedor,color,imagen,precio_compra,
    precio_venta,descuento,unidad_medida,tasa_iva,tasa_ipes,talla_numero FROM producto p INNER JOIN stock s
     WHERE p.codigo_barras = s.producto AND s.negocio = $_SESSION[negocio] AND s.eliminado = '0'";
     $jsonstring = json_encode($conexion->obtenerDatosDeTabla($consulta));
     echo $jsonstring;
}



if(isset($_POST['negocios'])){
    $conexion = new Models\Conexion();
    $consulta = "SELECT idnegocios,nombre FROM negocios WHERE dueno = $_SESSION[negocio]";
    $jsonstring = json_encode($conexion->obtenerDatosDeTabla($consulta));
    echo $jsonstring;
}

if(isset($_POST['producto'])){
    $conexion = new Models\Conexion();
    $consulta = "SELECT t1.codigo_barras,t1.nombre,t1.color,t1.marca,t1.talla_numero FROM producto t1
    WHERE t1.dueno = $_SESSION[email]
    AND NOT EXISTS (SELECT NULL FROM stock t2 WHERE t2.producto = t1.codigo_barras AND t2.negocio = $_SESSION[negocio])";
    $jsonstring = json_encode($conexion->obtenerDatosDeTabla($consulta));
    echo $jsonstring;
}

if(isset($_POST['Tstock2']) && isset($_POST['Sproducto'])){
    $datos_stock = array(
        $_POST['Sproducto'],
        $_POST['Talmazen'],
        $_POST['Tstock2'],
        $_POST['Tstock_minimo'],
        "A",
        $_SESSION['email'],
        $_SESSION['negocio'],
        0
    );
    $consulta_guardar_stock = "INSERT INTO stock (producto,localizacion,stock,stock_minimio,estado,
    usuariocafi,negocio,eliminado) VALUES (?,?,?,?,?,?,?,?)";
    $tipos_de_datos_stock = "ssiissii";

    return $conexion->consultaPreparada($datos_stock, $consulta_guardar_stock, 1, $tipos_de_datos_stock, false);

}
