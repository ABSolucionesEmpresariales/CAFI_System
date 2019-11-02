<?php 
session_start();
include_once '../Models/Conexion.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <style>
        div.barcodes {
            display: inline;
            border: 1px solid black;
            padding: 80px;
        }

        table {
            border: 1px solid black;
        }
    </style>
</head>

<body>

            <?php
            if (isset($_POST['Selejir'])) {
                if($_POST['Selejir'] == 'Todos'){

                $negocios = $_SESSION['negocio'];
                $con = new Models\Conexion();
                $cantidad = $_POST['cantidad'];
                $numeracion = true;
                $sql = "SELECT p.codigo_barras FROM producto p, stock s WHERE p.codigo_barras = s.producto AND S.negocio = '$negocios'";
                $resultado = $con->consultaListar($sql);
                while ($row = mysqli_fetch_array($resultado)) {
                    for ($i = 0; $i < $cantidad; $i++) { ?>
                        <img src="barcode.php?text=<?php echo $row['codigo_barras']; ?>&size=50&orientation=horizontal&codetype=Code39&print=true&sizefactor=1" />
            <?php 
                  }
                }
              }else if($_POST['Selejir'] == 'Producto'){

                $negocios = $_SESSION['negocio'];
                $codigoPro = $_POST['Sproducto'];
                $con = new Models\Conexion();
                $cantidad = $_POST['cantidad'];
                $numeracion = true;
                $sql = "SELECT p.codigo_barras FROM producto p, stock s WHERE p.codigo_barras = s.producto AND S.negocio = '$negocios' AND p.codigo_barras = '$codigoPro'";
                $resultado = $con->consultaListar($sql);
                while ($row = mysqli_fetch_array($resultado)) {
                    for ($i = 0; $i < $cantidad; $i++) {
                  ?>
                    <img src="barcode.php?text=<?php echo $row['codigo_barras']; ?>&size=50&orientation=horizontal&codetype=Code39&print=true&sizefactor=1" />
            <?php 
                  }?>

      <?php }
            }
        }
            ?>



</body>

</html>
