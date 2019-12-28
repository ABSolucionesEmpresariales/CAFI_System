<?php
session_start();
require_once('../Controllers/seguridadCafi.php');
require_once('../Models/Conexion.php');
privilegios("Todos");

$idventa = $_SESSION['idventa'];

$conexion = new Models\Conexion();

$consulta = "SELECT descuento,total,pago, cambio,fecha,hora,persona.nombre,negocios.nombre AS negocio ,negocios.municipio,negocios.calle_numero, negocios.telefono FROM venta
    INNER JOIN usuarioscafi ON usuariocafi = email
    INNER JOIN persona ON usuarioscafi.email = persona.email
    INNER JOIN negocios ON venta.negocio = idnegocios
    WHERE idventas = ?";

$result = $conexion->consultaPreparada($datos = array($idventa), $consulta, 2, "s", false, null);
if ($result != null) {
    $descuento = $result[0][0];
    $total = $result[0][1];
    $pago = $result[0][2];
    $cambio = $result[0][3];
    $fecha = $result[0][4];
    $hora = $result[0][5];
    $persona = $result[0][6];
    $negocio = $result[0][7];
    $domicilio = $result[0][8] ." ". $result[0][9];
    $telefono = $result[0][10];
}

$consulta = "SELECT anticipo,totaldeuda,nombre FROM adeudos 
INNER JOIN cliente ON cliente = email
INNER JOIN persona ON persona.email = cliente
WHERE venta = ? ";

$result = $conexion->consultaPreparada($datos = array($idventa), $consulta, 2, "s", false, null);
if ($result != null) {
    $anticipo = $result[0][0];
    $totaldeuda = $result[0][1];
    $cliente =  "Cliente: " . $result[0][2];
}

$tipoVenta = (isset($anticipo)) ? "VENTA A CRÉDITO " . $idventa : "VENTA " . $idventa; /*Define la descripcion del tipo de venta */
$fechaYHora = $fecha . " " . $hora;

$consulta = "SELECT nombre,color,marca,precio_venta, cantidad, unidad_medida,talla_numero,subtotal,detalle_venta.descuento FROM
producto INNER JOIN detalle_venta ON producto = codigo_barras WHERE
detalle_venta.idventa = ?";
$result = $conexion->consultaPreparada($datos = array($idventa), $consulta, 2, "s", false, null);
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link href="https://fonts.googleapis.com/css?family=PT+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/ticket.css">
</head>

<body style="width: 380px;">
    <div style="width: 380px; max-width: 380px;" class="font-weight-bold">
        <div class="row justify-content-center">
            <img src="../img/ticketcafi.png" alt="Logotipo">
        </div>

        <div class="justify-content-center">
            <p class="centrado font-weight-bold"> <?php echo $tipoVenta; ?>
                <?php if (isset($anticipo)) { ?>
                    <br> <?php echo $cliente;
                            } ?>

                <p class="centrado font-weight-bold"> <?php echo $negocio; ?>
                    <br> <?php echo $domicilio; ?>
                    <?php if (isset($telefono)) { ?>
                        <br> <?php echo "Tel: " . $telefono;
                                } ?>
                    <br> <?php echo $fechaYHora; ?>
                    <br>
        </div>
    </div>
    <div style="border-top: 1px solid black; margin-bottom: 1rem;">

    </div>
    <div style="width: 380px; max-width: 380px; line-height: 13px;" class="ml-1">
        <?php if ($result != null) for ($i = 0; $i < sizeof($result); $i++) {
         
            ?>
            <span class="font-weight-bold"><?php if($result[$i][4] != null && $result[$i][4] != "null" )echo $result[$i][4] . "x";?></span>
            <span class="font-weight-bold"><?php if($result[$i][0] != null && $result[$i][0] != "null" )echo $result[$i][0];?> <?php if($result[$i][2] != null && $result[$i][2] != "null" )echo $result[$i][2]; ?></span>
            <span class="font-weight-bold"><?php if($result[$i][1] != null && $result[$i][1] != "null" )echo $result[$i][1];?> </span>
            <span class="font-weight-bold"><?php if($result[$i][5] != null && $result[$i][5] != "null" )echo $result[$i][5];?> </span>
            <span class="font-weight-bold"><?php if($result[$i][6] != null && $result[$i][6] != "null" )echo $result[$i][6];?> </span>
            <span class="font-weight-bold"><?php if($result[$i][8] == 0 || $result[$i][8] === null || $result[$i][8] === "" || $result[$i][8] === "null" ) {}else{echo "($".$result[$i][8]." de descuento x producto)";} 
               $descuento = $result[$i][4] * $result[$i][8];
               $subtotal = $result[$i][7] - $descuento;
            ?></span>
            <p class="text-right">
                <span class="font-weight-bold text-right"><?php echo "$" . $subtotal; ?></span>
                <p>
                <?php  } ?>
    </div>
    <div style="border-top: 1px solid black; margin-bottom: 1rem;">

    </div>
    <div class="font-weight-bold" style="width: 380px; max-width: 380px; line-height: 13px;" class="">
        <div class="justify-content-right">
            <?php if (isset($anticipo)) {
                if ($descuento > 0.00) { ?>
                    <p class="text-right font-weight-bold"><span class="font-weight-bold">DESCUENTO ESPECIAL: </span><?php echo "$" . $descuento; ?></p>
                <?php   } ?>
                <p class="text-right font-weight-bold"><span class="font-weight-bold">TOTAL: </span><?php echo "$" . $total; ?></p>
                <p class="text-right font-weight-bold"><span class="font-weight-bold">ANTICIPO: </span><?php echo "$" . $anticipo; ?></p>
                <?php if ($pago > 0.00) { ?>
                    <p class="text-right font-weight-bold"><span class="font-weight-bold">PAGO: </span><?php echo "$" . $pago; ?></p>
                <?php } ?>
                <?php if ($cambio > 0.00) { ?>
                    <p class="text-right font-weight-bold"><span class="font-weight-bold">CAMBIO: </span><?php echo "$" . $cambio;
                                                                                                                } ?></p>
                    <p class="text-right font-weight-bold"><span class="font-weight-bold">ADEUDO: </span><?php echo "$" . $totaldeuda ?></p>
                    <?php } else {
                        if ($descuento > 0.00) { ?><br>
                        <p class="text-right font-weight-bold"><span class="font-weight-bold">DESCUENTO ESPECIAL: </span><?php echo "$" . $descuento; ?></p>
                    <?php } ?>
                    <p class="text-right font-weight-bold"><span class="font-weight-bold">TOTAL: </span><?php echo "$" . $total; ?></p>
                    <p class="text-right font-weight-bold"><span class="font-weight-bold">PAGO: </span><?php echo "$" . $pago; ?></p>

                    <?php if ($cambio > 0.00) { ?><p class="text-right"><span class="font-weight-bold">CAMBIO: </span><?php echo "$" . $cambio;
                                                                                                                            } ?></p>

                    <?php } ?>
        </div>

        <br>
        <br>

        <p class="centrado font-weight-bold">¡GRACIAS POR SU COMPRA =)!</p>
        <p class="centrado font-weight-bold">Usted fue atendido por <?php echo $persona; ?></p>
    </div>

    <script>
   /*      function PrintWindow(){                   
            window.print();           
            CheckWindowState();
        }

        function CheckWindowState(){          
            if(document.readyState=="complete"){
                window.close();
            }else{          
                setTimeout("CheckWindowState()", 2000)
            }
        }
        
        PrintWindow(); */
    </script>
</body>

</html>