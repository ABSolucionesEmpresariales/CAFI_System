<?php
session_start();
require_once('../Controllers/seguridadCafi.php');
require_once('../Models/Conexion.php');
privilegios("Todos");

$conexion = new Models\Conexion();
$idabono = $_SESSION['abono'];
$consulta = "SELECT anticipo,cantidad,abono.pago,abono.cambio,totaldeuda,abono.fecha,abono.hora ,idventas ,
total,descuento,tp1.nombre,tp2.nombre,negocios.municipio,negocios.calle_numero,negocios.telefono,negocios.nombre FROM abono 
INNER JOIN usuarioscafi ON abono.usuariocafi = usuarioscafi.email
INNER JOIN adeudos ON abono.adeudos_id = adeudos.idadeudos
INNER JOIN cliente ON adeudos.cliente = cliente.email
INNER JOIN persona tp1 ON tp1.email = usuarioscafi.email
INNER JOIN persona tp2 ON tp2.email = cliente.email
INNER JOIN venta ON venta.idventas = adeudos.venta
INNER JOIN negocios ON venta.negocio = negocios.idnegocios 
WHERE idabono = ?";

$result = $conexion->consultaPreparada($datos = array($idabono), $consulta, 2, "s", false);
if ($result != null) {
    $anticipo = $result[0][0];
    $cantidad = $result[0][1];
    $abono = $result[0][2];
    $cambio = $result[0][3];
    $totaldeuda = $result[0][4];
    $fecha = $result[0][5];
    $hora = $result[0][6];
    $venta = $result[0][7];
    $total = $result[0][8];
    $descuento = $result[0][9];
    $trabajador = $result[0][10];
    $cliente = "Cliente: ". $result[0][11];
    $domicilio = $result[0][12] ." ". $result[0][13];
    $telefono = $result[0][14];
    $negocio = $result[0][15];
    
    $consulta = "SELECT nombre,color,marca,precio_venta, cantidad, unidad_medida,talla_numero,subtotal FROM
    producto INNER JOIN detalle_venta ON producto = codigo_barras WHERE
    detalle_venta.idventa = ?";
    $result = $conexion->consultaPreparada($datos = array($venta), $consulta, 2, "s", false);

}

$titulo =  "ABONO A VENTA #" . $venta; /*Define la descripcion del tipo de venta */
$fechaYHora = $fecha. " " . $hora;

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
                <p class="centrado"> <?php echo $titulo; ?>
                <br> <?php echo $cliente; ?>

                <p class="centrado"> <?php echo $negocio; ?>
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
        <div style="width: 380px; max-width: 380px; line-height: 13px;">
        <?php if ($result != null) for ($i = 0; $i < sizeof($result); $i++) {
            ?>
            <span class="font-weight-bold"><?php echo $result[$i][4] . "x"; ?></span>
            <span class="font-weight-bold"><?php echo $result[$i][0]; ?> <?php echo $result[$i][2]; ?></span>
            <span class="font-weight-bold"><?php echo $result[$i][1];  ?></span>
            <span class="font-weight-bold"><?php echo $result[$i][5];  ?></span>
            <span class="font-weight-bold"><?php echo $result[$i][6];  ?></span>
            <p class="text-right">
                <span class="font-weight-bold text-right"><?php echo "$" . $result[$i][7] ?></span>
                <p>
                <?php  } ?>
        </div>
        <div style="border-top: 1px solid black; margin-bottom: 1rem;">

        </div>
        <div class="font-weight-bold" style="width: 380px; max-width: 380px; line-height: 13px;">
            <div class="justify-content-right">
                <?php
                if ($descuento> 0.00) { ?>
                    <p class="text-right"><span class="font-weight-bold">DESCUENTO: </span><?php echo "$" . $descuento; ?></p>
                <?php   } ?>
                    <p class="text-right"><span class="font-weight-bold">TOTAL: </span><?php echo "$" . $total; ?></p>
                <?php
                if ($anticipo > 0.00) {?>
                    <p class="text-right"><span class="font-weight-bold">ANTICIPO: </span><?php echo "$" . $anticipo; ?> <?php } ?></p>
                    <p class="text-right"><span class="font-weight-bold">ABONO ACTUAL: </span><?php echo "$". $cantidad; ?></p>
                <?php if ($abono > 0.00) { ?>
                    <p class="text-right"><span class="font-weight-bold">PAGO: </span><?php echo "$" . $abono; ?></p>
                <?php   } ?>
                <?php if ($cambio > 0.00) { ?>
                    <p class="text-right"><span class="font-weight-bold">CAMBIO: </span><?php echo "$" . $cambio; ?></p>
                <?php } ?>
                <p class="text-right"><span class="font-weight-bold">ADEUDO ACTUAL: </span><?php echo "$" . $totaldeuda;?></p>
            </div>

            <br>
            <br>

            <p class="centrado font-weight-bold">¡GRACIAS POR SU COMPRA =)!</p>
            <p class="centrado">Usted fue atendido por <?php echo $trabajador; ?></p>
        </div>

        <script >
            function PrintWindow(){                   
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
            
            PrintWindow();   
        </script>
    </body>

</html>