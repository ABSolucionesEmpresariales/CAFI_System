<?php
require_once "Config/Autoload.php";
Config\Autoload::run();
session_start();
include "check_token.php";

if (!isset($_SESSION['acceso'])) {
    header('location: index.php');
} else if ($_SESSION['estado'] == "I") {
    header('location: index.php');
} else if (
    $_SESSION['acceso'] != "CEO"
) {
    header('location: index.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="icon" href="img/logo/nav1.png">
    
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.js"></script>
    <title>Mas Vendidos</title>
</head>

<body onload="inicio(); ">
    <?php
        $sel = "mv";
        include("NavbarD.php")
    ?>
    <div class="contenedor container-fluid">
        <div id="tableContainer" class="d-block col-lg-12">
            <div class="input-group mb-2">
                <div class="font-weight-bold px-3 d-flex align-items-center">
                    <p>Sucursal:</p>
                </div>
                
                <div class="col-3">
                    <form action="#" method="POST">
                        <select id="sucursal" class="form form-control" name="SNegocio">
                            <option value=""></option>
                            <?php
                            $con = new Models\Conexion();
                            $dueño = $_SESSION['id'];
                            $query = "SELECT nombre_negocio, idnegocios FROM negocios 
                                        WHERE clientesab_idclienteab = '$dueño'";
                            $row = $con->consultaListar($query);
                            $con->cerrarConexion();
                            while ($renglon = mysqli_fetch_array($row)) {
                                echo "<option value='$renglon[idnegocios]'>" . $renglon['nombre_negocio'] . "</option>";
                            }
                            ?>
                        </select>

                        <input type="submit" style="display: none;">
                    </form>
                </div>
            </div>

            <div style="border-radius: 10px;" class="contenedorTabla table-responsive">
                <table style="border-radius: 10px;" class="table table-hover table-striped table-light">
                    <thead class="thead-dark">
                        <tr>
                            <th>Producto</th>
                            <th>Cantidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (isset($_POST['SNegocio'])) {
                            $negocio = $_POST['SNegocio'];
                            $con = new Models\Conexion();
                            $query = "SELECT producto.nombre,producto.marca,producto.color,producto.talla_numero,producto.unidad_medida, SUM(cantidad_producto) AS cantidadproducto FROM detalle_venta
                                INNER JOIN producto ON producto_codigo_barras = codigo_barras
                                INNER JOIN inventario ON detalle_venta.producto_codigo_barras = inventario.producto_codigo_barras
                                WHERE inventario.negocios_idnegocios ='$negocio'
                                GROUP BY  codigo_barras
                                ORDER BY `cantidadproducto` DESC";
                            $row = $con->consultaListar($query);
                            $con->cerrarConexion();

                            while ($renglon = mysqli_fetch_array($row)) {
                                ?>
                                <tr>

                                    <td><?php echo $renglon['nombre'] . " " . $renglon['marca'] . " " . $renglon['color'] . " talla " . $renglon['talla_numero'] . " um " . $renglon['unidad_medida']; ?></td>
                                    <td><?php echo $renglon['cantidadproducto']; ?></td>

                                </tr>
                            <?php
                                } ?>
                    </tbody>
                    </table>
    <?php
    } ?>
    </div>
    </div>
    </div>
    <script src="js/user_jquery.js"></script>
</body>

</html>