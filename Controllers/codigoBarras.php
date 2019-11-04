<?php
session_start();
$negocios = $_SESSION['idnegocios'];
if (!isset($_SESSION['acceso']) && !isset($_SESSION['estado'])) {
    header('location: login.php');
} else if ($_SESSION['estado'] == "I") {
    header('location: login.php');
} else if (
    $_SESSION['acceso'] != "Manager" && $_SESSION['acceso'] != "Employes"
) {
    header('location: login.php');
}
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
    <table>
        <thead>
        </thead>
        <tbody>
            <?php
            if (isset($_POST['cantidad'])) {
                require_once "Config/Autoload.php";
                Config\Autoload::run();
                $con = new Models\Conexion();
                $cantidad = $_POST['cantidad'];
                $numeracion = true;
                $sql = "SELECT codigo_barras FROM producto WHERE negocios_idnegocios = '$negocios'";
                $resultado = $con->consultaListar($sql);
                while ($row = mysqli_fetch_array($resultado)) {
                    for ($i = 0; $i < $cantidad; $i++) { ?>
                        <img src="barcode.php?text=<?php echo $row['codigo_barras']; ?>&size=50&orientation=horizontal&codetype=Code39&print=true&sizefactor=1" />
            <?php }
                }
            }
            ?>
        </tbody>
    </table>


</body>

</html>
