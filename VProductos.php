<?php
require_once "Config/Autoload.php";
Config\Autoload::run();
session_start();
include "check_token.php";

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/sweetalert.css">
    <link rel="icon" href="img/logo/nav1.png">
    

    <title>Productos</title>
    <script type="text/javascript">
        var parametro;
        //funcion para la vista previa de la imagen
        function ejecutar() {

            document.getElementById("imagen").onchange = function(e) {
                // Creamos el objeto de la clase FileReader
                let reader = new FileReader();

                // Leemos el archivo subido y se lo pasamos a nuestro fileReader
                reader.readAsDataURL(e.target.files[0]);

                // Le decimos que cuando este listo ejecute el código interno
                reader.onload = function() {
                    let preview = document.getElementById('preview'),
                        image = document.createElement('img');
                        $('.rowMostrar').css('display', 'none');
                        $('#preview').css('display', 'block');
                        
                    image.src = reader.result;
                    image.height = 100;
                    image.width = 100;  
                    preview.innerHTML = '';
                    preview.append(image);
                };
            }
        }
        //funciones para mostrar y ocultar los divs
        function activarDivTalla() {
            document.getElementById("divtalla").style.display = "block";
            document.getElementById("divmedida").style.display = "none";
            document.getElementById('tpr').disabled = true;
            document.getElementById('tpc').disabled = false;
            document.getElementById('tpo').disabled = false;
            document.getElementById('tipo_produc').value = "Ropa";
            document.getElementById('ta').value = "";
            document.getElementById('ta').setAttribute("required", true);
            document.getElementById('med').removeAttribute("required");
        }

        function activarDivMedida() {
            document.getElementById("divtalla").style.display = "none";
            document.getElementById("divmedida").style.display = "block";
            document.getElementById('tpc').disabled = true;
            document.getElementById('tpr').disabled = false;
            document.getElementById('tpo').disabled = false;
            document.getElementById('tipo_produc').value = "Calzado";
            document.getElementById('med').value = "";
            document.getElementById('med').setAttribute("required", true);
            document.getElementById('ta').removeAttribute("required");
        }

        function activarDivOtro() {
            document.getElementById("divtalla").style.display = "none";
            document.getElementById("divmedida").style.display = "none";
            document.getElementById('tpo').disabled = true;
            document.getElementById('tpc').disabled = false;
            document.getElementById('tpr').disabled = false;
            document.getElementById('tipo_produc').value = "Otro";
            document.getElementById('ta').removeAttribute("required");
            document.getElementById('med').removeAttribute("required");
        }
    </script>
</head>


<body>
    <?php
        $sel = "productos";
        include("Navbar.php")
    ?>
    <div class="contenedor container-fluid">
        <div class="row align-items-start">
            <div id="tableContainer" class="d-block col-lg-12">
                    <div class="row col-12">
                        <div class="input-group mb-2">

                            <div class="row col-12">
                                <button class="d-lg-none btn btn-primary col-6 mb-3 p-3 agrega mostra" data-toggle="modal" data-target="#modalForm">Agregar Productos</button>
                                <button class="d-lg-none btn btn-danger col-6 mb-3 p-3 agrega mostra" id="BcodigoBarra"  data-toggle="modal" data-target="#modalFormCodigo">Imprimir Codigos</button>
                                <p id="stockrequerido"></p>
                            </div>

                            <div class="font-weight-bold px-3 d-flex align-items-center">
                                <p>Sucursal:</p>
                            </div>
                            <select class="form form-control sucursal col-6 col-lg-2" name="SNegocio">
                                <?php
                                $negocio = $_SESSION['idnegocio'];
                                $con = new Models\Conexion();
                                $query = "SELECT nombre_negocio, idnegocios FROM negocios 
                                WHERE clientesab_idclienteab = (SELECT clientesab_idclienteab AS dueno FROM negocios WHERE negocios.idnegocios='$negocio')";
                                $row = $con->consultaListar($query);
                                $con->cerrarConexion();
                                $cont = 0;
                                while ($renglon = mysqli_fetch_array($row)) {
                                    echo "<option value =".$renglon['idnegocios'].">" . $renglon['nombre_negocio'] . "</option>";
                                }
                                ?>
                            </select>

                            <div class="ml-0 ml-lg-3 input-group-prepend">
                                <div class="input-group-text"><i class="fa fa-search"></i>
                                </div>
                            </div>

                            <input class="form-control col-12 col-lg-4" type="text" id="busqueda" onkeyup="busqueda()" onkeypress="return check(event)" placeholder="Buscar..." title="Type in a name" value="">
                            
                            <input type="hidden" id="negocioActual" value=<?php echo  $_SESSION['idnegocio'];?>>
                            <input type="submit" style="display: none;">
                            <button class="d-none d-lg-flex btn btn-primary ml-5 agrega mostra" data-toggle="modal" data-target="#modalForm">Agregar Producto</button>
                            <button class="d-none d-lg-flex btn btn-danger ml-5 agrega mostra" id="BcodigoBarra"  data-toggle="modal" data-target="#modalFormCodigo">Imprimir Codigos</button>
                        </div>
                </div>

                <div style="border-radius: 10px;" class="contenedorTabla table-responsive">
                    <table style="border-radius: 10px;" class="table table-hover table-striped table-light">
                        <thead class="thead-dark">
                            <tr class="encabezados">
                                <th class="text-nowrap text-center" onclick="sortTable(0)">Código de barras</th>
                                <th class="text-nowrap text-center" onclick="sortTable(1)">Nombre</th>
                                <th class="text-nowrap text-center" onclick="sortTable(2)">Imagen</th>
                                <th class="text-nowrap text-center" onclick="sortTable(3)">Color</th>
                                <th class="text-nowrap text-center" onclick="sortTable(4)">Marca</th>
                                <th class="text-nowrap text-center" onclick="sortTable(5)">Proveedor</th>
                                <th class="text-nowrap text-center" onclick="sortTable(6)">Descripcion</th>
                                <th class="text-nowrap text-center" onclick="sortTable(7)">Unidad de Medida</th>
                                <th class="text-nowrap text-center" onclick="sortTable(8)">Tipo</th>
                                <th class="text-nowrap text-center" onclick="sortTable(9)">Talla</th>
                                <th class="text-nowrap text-center" onclick="sortTable(10)">Compra</th>
                                <th class="text-nowrap text-center" onclick="sortTable(11)">Venta</th>
                                <th class="text-nowrap text-center" onclick="sortTable(12)">Estado</th>
                                <th class="text-nowrap text-center" onclick="sortTable(13)">Cantidad</th>
                                <th class="text-nowrap text-center" onclick="sortTable(14)">Stock minimo</th>
                                <th class="text-nowrap text-center" onclick="sortTable(15)">Stock requerido</th>
                                <th class="text-nowrap text-center" onclick="sortTable(16)"></th>
                            </tr>
                        </thead>
                        <tbody id="cuerpo">

                        </tbody>
                    </table>
                </div>
                <!--Tabla contenedor-->
            </div>
            <!--col-7-->
        </div>
        <!--row-->
    </div>
    <!--container-->
    
    <!-- Modal -->
    <div class="modal fade" id="modalForm" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header administrador">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">×</span>
                        <span class="sr-only">Close</span>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <p class="statusMsg"></p>
                    
                        <?php include("Producto-Frontend/formularioproducto.php"); ?>
                    
                    <div id="tableHolder" class="row justify-content-center">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->

            <!-- Modal -->
            <div class="f fade" id="modalFormCodigo" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header administrador">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">×</span>
                        <span class="sr-only">Close</span>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <p class="statusMsg"></p>
                    <div class="row justify-content-center">
                        <form action="codigoBarras.php" method="POST" target="_blank">
                        <div class="col-12">
                            <p>Ingrese la cantidad que desea imprimir (Se imprimiran todos los productos que esten en inventario)</p>
                            <div class="tab-content" id="myTabContent">
                                <p class="general">Cantidad:</p>
                                <input type="num" name="cantidad">
                                <input class="btn btn-danger" type="submit" value="Imprimir">
                            </div>
                            </form>
                        </div>
                    </div>
                    <div id="tableHolder" class="row justify-content-center">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <script src="js/jquery.js"></script>
    <script src="js/sweetalert.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.js"></script>
    <script src="js/sweetalert.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/index.js"></script>
    <script src="js/user_jquery.js"></script>
    <script src="js/vproductos.js"></script>
</body>

</html>