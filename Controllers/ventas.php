<?php
session_start();
include_once '../Models/Conexion.php';
include_once '../Models/Fecha.php';
//respuesta de tabla de las ventas realizadas
if (isset($_POST['tabla']) && $_POST['tabla'] === "tabla") {

    $conexion = new Models\Conexion();
    $datos = array($_SESSION['negocio'], 1);
    $consulta = "SELECT idventas,descuento,total,pago,cambio,forma_pago,fecha,hora,estado_venta,usuariocafi
    FROM venta WHERE negocio = ? AND eliminado != ?";
    echo json_encode($conexion->consultaPreparada($datos, $consulta, 2, "ii", false,null));
    //respuesta del concepto de la venta
} else if (isset($_POST['idventa']) && !isset($_POST['forma_pago'])) {

    $conexion = new Models\Conexion();
    $datos = array($_POST['idventa']);
    $consulta = "SELECT cantidad,nombre,imagen,marca,color,unidad_medida,talla_numero,subtotal FROM producto INNER JOIN
    detalle_venta ON codigo_barras = producto INNER JOIN venta ON idventas = idventa WHERE idventa = ? ";
    echo json_encode($conexion->consultaPreparada($datos, $consulta, 2, "s", false,null));

} else if (isset($_POST['venta']) && isset($_POST['estado'])) {

    $conexion = new Models\Conexion();
    $datos = array($_POST['estado'], $_POST['venta']);
    $consulta = "UPDATE venta SET estado_venta = ? WHERE idventas = ?";
    $reult = $conexion->consultaPreparada($datos, $consulta,1, "ss", false,null);
    if($reult == 1){
        $datos = array($_POST['venta']);
        $cosulta_venta = "SELECT forma_pago FROM venta WHERE idventas = ?";
        $reult6 = $conexion->consultaPreparada($datos,$cosulta_venta,2, "s", false,null);
        if($reult6[0][0] == 'Crédito'){
            $cosulta_estado = "UPDATE adeudos SET estado = ? WHERE venta = ?";
            $datos_estado = array($_POST['estado'],$_POST['venta']);
            $reult2 = $conexion->consultaPreparada($datos_estado,$cosulta_estado,1,"ss", false,null);
            if( $reult2 == 1){
                $datos = array($_POST['venta']);
                $consulta = "SELECT idadeudos FROM adeudos WHERE venta = ?";
                $reult_adeuso = $conexion->consultaPreparada($datos,$consulta,2,"s", false,null);
                $id_adeudo = $reult_adeuso[0][0];
                $datos_abono = array($_POST['estado'],$id_adeudo);
                $consulta_abonos = "UPDATE abono SET estado = ? WHERE adeudos_id = ?";
                echo $reult_adeuso = $conexion->consultaPreparada($datos_abono,$consulta_abonos,1,"ss", false,null);
            }else{
                echo $reult2;
            }
        }else{
            echo $reult;
        }
    }else{
        echo $reult;
    }
    $venta = array($_POST['venta']);
    if ($_POST['estado'] === "A") {
        actualizarStock($venta, $conexion, "+");
    } else if ($_POST['estado'] === 'I') {
        actualizarStock($venta, $conexion, "-");
    }
} else if (isset($_POST['combo']) && $_POST['combo'] === "combo") {

    $conexion = new Models\Conexion();

    $consulta = "SELECT producto.codigo_barras,nombre,marca,color,talla_numero,unidad_medida,precio_venta FROM producto 
    INNER JOIN stock ON codigo_barras = producto WHERE negocio = ? AND eliminado != ?";

    $datos = array(
        $_SESSION['negocio'],
        1
    );
    echo json_encode($conexion->consultaPreparada($datos, $consulta, 2, "ss", false,null));
    //obtencion de los datos del producto selecionado del datalist
}else if(!empty($_POST["codigobarrasproducto"])){
    $conexion = new Models\Conexion();

    $consulta = "SELECT producto.codigo_barras,nombre,marca,color,talla_numero,unidad_medida,precio_venta,descuento FROM producto 
    INNER JOIN stock ON codigo_barras = producto WHERE  producto.codigo_barras = ? AND negocio = ? AND eliminado != ?";

    $datos = array(
        $_POST["codigobarrasproducto"],
        $_SESSION['negocio'],
        1
    );
    echo json_encode($conexion->consultaPreparada($datos, $consulta, 2, "sss", false,null));
} else if (isset($_POST['searchcliente'])) {

    $conexion = new Models\Conexion();
    $consulta = "SELECT persona.email,nombre,calle_numero,colonia,localidad,municipio , telefono, estado,credito,(SELECT COUNT(idadeudos) AS total FROM adeudos
    WHERE cliente = persona.email AND estado = ? AND adeudos.eliminado != ?) AS totaladeudos FROM cliente INNER JOIN persona ON cliente.email = persona.email
      WHERE  CONCAT_WS(' ',persona.email,nombre,calle_numero,colonia,localidad,municipio,telefono,estado)  
      LIKE ? AND  negocio = ? AND persona.eliminado != ? ";
    $datos = array(
        "A",
        1,
        "%" . $_POST['searchcliente'] . "%",
        $_SESSION['negocio'],
        1
    );
    echo json_encode($conexion->consultaPreparada($datos, $consulta, 2, "sisii", false,null));
} else if (
    isset($_POST['idventa']) && isset($_POST['descuento'])  && isset($_POST['total']) && isset($_POST['pago']) && isset($_POST['cambio']) && isset($_POST['forma_pago'])
    && isset($_POST['json_string']) && isset($_POST['idadeudo']) && isset($_POST['totaldeuda']) && isset($_POST['anticipo']) && isset($_POST['cliente'])
) {

    //si la venta es pagada en efectivo se actualizan los datos de la tabla venta
    $conexion = new Models\Conexion();
    $fecha = new Models\Fecha();

    if ($_POST['forma_pago'] === "Efectivo" || $_POST['forma_pago'] === "Tarjeta") {
        $datos = array(
            $_POST['idventa'],
            $_POST['descuento'],
            $_POST['total'],
            $_POST['pago'],
            $_POST['cambio'],
            $_POST['forma_pago'],
            $fecha->getFecha(),
            $fecha->getHora(),
            "A",
            $_SESSION['email'],
            $_SESSION['negocio'],
            0
        );

        $consulta = "INSERT INTO venta (idventas,descuento,total,pago,cambio,forma_pago,fecha,hora,estado_venta,usuariocafi,negocio,eliminado) VALUES(?,?,?,?,?,?,?,?,?,?,?,?)";
        $conexion->consultaPreparada($datos, $consulta, 1, "sssssssssssi", false,null);
        $venta = $conexion->optenerId();
        $_SESSION['idventa'] = $venta; // para poder imprimir el ticket
    } else if ($_POST['forma_pago'] === "Crédito") {
        $datos = array(
            $_POST['idventa'],
            $_POST['descuento'],
            $_POST['total'],
            $_POST['pago'],
            $_POST['cambio'],
            $_POST['forma_pago'],
            $fecha->getFecha(),
            $fecha->getHora(),
            "A",
            $_SESSION['email'],
            $_SESSION['negocio'],
            0
        );
        $consulta = "INSERT INTO venta (idventas,descuento,total,pago,cambio,forma_pago,fecha,hora,estado_venta,usuariocafi,negocio,eliminado) VALUES(?,?,?,?,?,?,?,?,?,?,?,?)";
        $conexion->consultaPreparada($datos, $consulta, 1, "sssssssssssi", false,null);
        $venta = $conexion->optenerId();

        $datos2 = array(
            $_POST['idadeudo'],
            $_POST['totaldeuda'],
            $_POST['anticipo'],
            "A",
            $venta,
            $_POST['cliente'], //agregar el cliente en el front
            0
        );
        $consulta = "INSERT INTO adeudos (idadeudos,totaldeuda,anticipo,estado,venta,cliente,eliminado) VALUES(?,?,?,?,?,?,?)";
        $conexion->consultaPreparada($datos2, $consulta, 1, "ssssssi", false,null);
        $_SESSION['idventa'] = $venta; // para poder imprimir el ticket
    }
    $consulta = "INSERT INTO detalle_venta(idventa,producto,descuento,cantidad,subtotal) VALUES(?,?,?,?,?)";
    $jsonstring = $_POST['json_string'];
    $carrito = json_decode($jsonstring);
    for ($i = 0; $i < sizeof($carrito); $i++) {
        unset($carrito[$i][1],$carrito[$i][2]); //elimina la posicion uno del array que es el producto y la dos que es el costo del producto / solo se necesita la posicion cero que es el codigo de barras
        $carrito[$i]= array_values($carrito[$i]); //una vez eliminado se reordena las posciones de los datos del array 
        array_unshift($carrito[$i], $venta);// se agrega el id de la venta al inicio del array
        $respuesta_detalle = $conexion->consultaPreparada($carrito[$i], $consulta, 1, "sssss", false,null); //se inserta
    }

    if($respuesta_detalle == 1){
        
    }
    

/* $datos = array(
            array("2250000","002","Tasa","0.160000","360000","","","01010101","F52","00001","1.5","TONELADA","ACERO","1500000","2250000",""),
            array("2250000","002","Tasa","0.160000","360000","","","01010101","F52","00001","1.5","TONELADA","ACERO","1500000","2250000",""),
            array("2250000","002","Tasa","0.160000","360000","","","01010101","F52","00001","1.5","TONELADA","ACERO","1500000","2250000","")
            );
                $etiqueta_traslado_atributos = array("Base","Impuesto","TipoFactor","TasaOCuota","Importe",
                "cfdi:Traslado","cfdi:Traslados","ClaveProdServ","ClaveUnidad","NoIdentificacion","Cantidad",
                "Unida","Descripcion","ValorUnitario","Importe","cfdi:Impuestos");
                $datos_traslado_producto = array();
                $datos_traslados = array();
                $datos_inpuesto = array();
                $datos_Concepto = array();
                $datos_cfdi_Concepto = array();
                for($i = 0; $i < count($datos); $i++){
                    for($y =0; $y < count($datos[$i]); $y++){
                        if($etiqueta_traslado_atributos[$y] == "cfdi:Traslado"){
                            $datosTotal = array($etiqueta_traslado_atributos[$y] => $datos_traslado_producto);
                        }
                        if($etiqueta_traslado_atributos[$y] == "cfdi:Traslados"){
                            $datos_traslados = array("cfdi:Traslados" => $datosTotal);
                        }
                        if($y >= 7){
                            if($etiqueta_traslado_atributos[$y] == "cfdi:Impuestos"){
                                $datos_Concepto += [$etiqueta_traslado_atributos[$y] => $datos_traslados];
                            }else{
                            $datos_Concepto += [$etiqueta_traslado_atributos[$y] => $datos[$i][$y]];
                            }
                        }
                        $datos_traslado_producto += [$etiqueta_traslado_atributos[$y] => $datos[$i][$y]];
                    }
                    $datos_cfdi_Concepto += ["cfdi:Concepto_$i" =>  $datos_Concepto];

                }
*/

var_dump($datos_total_tras);

    $dato = array($venta);
    actualizarStock($dato, $conexion, "-");
    $consulta = "SELECT impresora FROM negocios WHERE idnegocios = ?";
    $negocio = array($_SESSION['negocio']);
    $result = $conexion->consultaPreparada($negocio, $consulta, 2, "s", false,null);
    if ($result != null) {
        if ($result[0][0] === "A") {
            echo "Exitoprinter";
        } else {
            echo "Exito";
        }
    }
}

function actualizarStock($dato, $conexion, $operecion)
{

    if ($operecion === "-") {
        $consulta = "SELECT (stock - cantidad) AS stock, stock.producto  FROM
        stock INNER JOIN detalle_venta ON stock.producto = detalle_venta.producto
        WHERE detalle_venta.idventa= ?";
    } else if ($operecion === "+") {

        $consulta = "SELECT (stock + cantidad) AS stock, stock.producto  FROM
        stock INNER JOIN detalle_venta ON stock.producto = detalle_venta.producto
        WHERE detalle_venta.idventa= ?";
    }
    $result = $conexion->consultaPreparada($dato, $consulta, 2, "s", false, null);
    $consulta = "UPDATE stock SET stock = ? WHERE producto= ? AND negocio = ?";
    if ($result != null) {
        for ($i = 0; $i < sizeof($result); $i++) {
            array_push($result[$i], $_SESSION['negocio']);
            $conexion->consultaPreparada($result[$i], $consulta, 1, "sss", false, null);
        }
    }
    
}

if (isset($_POST['array'])) {
    $conexion = new Models\Conexion();
    $data = json_decode($_POST['array']);
    $tipo_datos = "ii";
    $consulta = "UPDATE venta SET eliminado = ? WHERE idventas = ?";
    for ($i = 0; $i < count($data); $i++) {
        if ($data[$i] != '0') {
            $datos = array(1,$data[$i]);
            $result = $conexion->consultaPreparada($datos, $consulta, 1, $tipo_datos, false, null);
                if($result == 1){
                    $datos3  = array($data[$i],"Credito");
                    $consulta2 = "SELECT forma_pago FROM venta WHERE idventas = ? AND forma_pago = ?";
                    $jsonstring = json_encode($conexion->consultaPreparada($datos3, $consulta2,2,"is", false, null));
                        if($jsonstring != "[]"){
                            $datos2  = array(1,$data[$i]);
                            $consulta_ade = "UPDATE adeudos SET eliminado = ? WHERE venta = ?";
                            $result =  $respuesta = $conexion->consultaPreparada($datos2, $consulta_ade, 1,"ii", false, null);
                            if($result == 1){
                                    $datos_obtener_adeudo = array($data[$i]);
                                    $adeudo = "SELECT idadeudos FROM adeudos WHERE venta = ?";
                                    $result_adeudo =  json_encode($conexion->consultaPreparada($datos_obtener_adeudo, $adeudo,2,"i",false, null));
                                    $result = json_decode($result_adeudo);
                                    $datos_adeudo = array(1,$result[0][0]);
                                    $consulta_Adeudos = "UPDATE abono SET eliminado = ? WHERE  adeudos_id = ?";
                                    $result =  $conexion->consultaPreparada($datos_adeudo, $consulta_Adeudos,1,"ss",false, null);
                                }
                        }
                }
        }
    }
    echo $result;
}

if(isset($_POST['busquedaCliente'])){
    $conexion = new Models\Conexion();
    $consulta = "SELECT persona.email,nombre,calle_numero,colonia,localidad,municipio,telefono, estado,credito,persona.rfc,persona.cp,(SELECT COUNT(idadeudos) AS total FROM adeudos
    WHERE cliente = persona.email AND estado = ? AND adeudos.eliminado != ?) AS totaladeudos FROM cliente INNER JOIN persona ON cliente.email = persona.email
      WHERE  CONCAT_WS(' ',persona.email,nombre,calle_numero,colonia,localidad,municipio,telefono,estado)  
      LIKE ? AND  negocio = ? AND persona.eliminado != ? ";
    $datos = array(
        "A",
        1,
        "%" . $_POST['busquedaCliente'] . "%",
        $_SESSION['negocio'],
        1
    );
    echo json_encode($conexion->consultaPreparada($datos, $consulta, 2, "sisii", false,null));
}

if(isset($_POST['datosCliente'])){
    $conexion = new Models\Conexion();
    $datos = array($_POST['datosCliente']);
    $consulta = "SELECT p.email,p.nombre,p.telefono,c.credito,p.cp,p.calle_numero,p.colonia,p.localidad,p.municipio,
    p.estado,p.sexo,p.rfc,p.fecha_nacimiento,c.plazo_credito,c.limite_credito FROM persona p 
    INNER JOIN cliente c ON c.email = p.email WHERE p.email = ?";
    echo json_encode($conexion->consultaPreparada($datos, $consulta, 2, "s", false,null));
}


