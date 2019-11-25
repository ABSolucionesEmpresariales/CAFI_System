<?php
session_start();
require_once('../Controllers/seguridadCafi.php');
privilegios("Superiores");
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
<link rel="stylesheet" href="../css/sweetalert.css">
    <script src="../js/sweetalert.js"></script>
    <script src="../js/sweetalert.min.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" href="../img/logo/nav1.png">


  <title>Productos</title>
  <script type="text/javascript">
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

    function cerrar() {
      window.close();
    }
  </script>
</head>

<body>
  <?php
  $sel = "productos";
  include("../Controllers/NavbarCafi.php")
  ?>

  <div class="contenedor container-fluid">
    <div class="row align-items-start">
      <div id="tableContainer" class="d-block col-lg-12">
        <div class="row col-12">
          <div class="input-group mb-2">

            <div class="ml-0 ml-lg-3 input-group-prepend">
              <div class="input-group-text"><i class="fa fa-search"></i>
              </div>
            </div>

            <input class="form-control col-lg-4" type="text" id="busqueda" onkeyup="busqueda()" onkeypress="return check(event)" placeholder="Buscar..." title="Type in a name" value="">

            <div class="font-weight-bold px-3 d-flex align-items-center">
                  <p class="text-white">Mostrar productos de:</p>
            </div>
            <select class="form form-control col-lg-4" id="negocio" name="Snegocio">
            </select>

            <input type="submit" style="display: none;">
            <?php if($_SESSION['acceso'] == 'CEO'){?>
                <button class="d-none d-lg-flex btn btn-danger ml-2 eliminar">Eliminar</button>
                <button class="d-lg-none btn btn-danger col-12 mb-3 p-3 eliminar">Eliminar</button>
              <?php } ?>
            <button class="d-none d-sm-flex btn btn-primary ml-5 agregar" data-toggle="modal" data-target="#modalForm">Agregar</button>
            <button class="d-none d-sm-flex btn btn-success ml-5 agregar" data-toggle="modal" id="Binventariar" data-target="#modalForm2">Inventariar</button>
            <button class="d-none d-sm-flex btn btn-danger ml-5 agregar" id="Bcodigobarra" data-toggle="modal" data-target="#modalForm3">Generar codigo de barras</button>
          </div>
        </div>
        <div style="border-radius: 10px;" class="contenedorTabla table-responsive">
          <table style="border-radius: 10px;" class="table table-bordered table-hover table-striped table-light">
            <thead class="thead-dark">
              <tr class="encabezados">
              <?php if($_SESSION['acceso'] == 'CEO'){?>
                <th class="text-nowrap text-center" onclick="sortTable(0)"><input class="check" type="checkbox" value="si"></th>
              <?php } ?>
                <th class="text-nowrap text-center" onclick="sortTable(1)">Codigo de barras</th>
                <th class="text-nowrap text-center" onclick="sortTable(2)">Modelo</th>
                <th class="text-nowrap text-center" onclick="sortTable(3)">Nombre</th>
                <th class="text-nowrap text-center" onclick="sortTable(4)">Descripción</th>
                <th class="text-nowrap text-center" onclick="sortTable(5)">Categoria</th>
                <th class="text-nowrap text-center" onclick="sortTable(6)">Marca</th>
                <th class="text-nowrap text-center" onclick="sortTable(7)">Proveedor</th>
                <th class="text-nowrap text-center" onclick="sortTable(8)">Color</th>
                <th class="text-nowrap text-center" onclick="sortTable(9)">Imagen</th>
                <th class="text-nowrap text-center" onclick="sortTable(10)">Precio compra</th>
                <th class="text-nowrap text-center" onclick="sortTable(11)">Precio venta</th>
                <th class="text-nowrap text-center" onclick="sortTable(12)">Descuento</th>
                <th class="text-nowrap text-center" onclick="sortTable(13)">Tipo Producto</th>
                <th class="text-nowrap text-center" onclick="sortTable(14)">Unidad de medida</th>
                <th class="text-nowrap text-center" onclick="sortTable(15)">Tasa de iva</th>
                <th class="text-nowrap text-center" onclick="sortTable(16)">Tasa de ipes</th>
                <th class="text-nowrap text-center" onclick="sortTable(17)">Talla numero</th>
                <th class="text-nowrap text-center" onclick="sortTable(18)">Localización</th>
                <th class="text-nowrap text-center" onclick="sortTable(19)">Stock</th>
                <th class="text-nowrap text-center" onclick="sortTable(20)">Stock Minimo</th>
              </tr>
            </thead>
            <tbody id="cuerpo"></tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
    <!-- Modal -->
    <div class="modal fade" id="modalForm3" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">
            <span aria-hidden="true">×</span>
            <span class="sr-only">Close</span>
          </button>
        </div>

        <!-- Modal Body -->
        <div class="modal-body">
          <form action="../Controllers/codigoBarras.php" id="formularioBarras"  method="POST" target="_blank">
          <h4 class="importante">Que desea Impimir</h4>
          <div class="row">
          <div class="col-12">
            <select name="Selejir"  class="form form-control form-group" id="Elejir">
              <option value="Elejir">Elejir</option>
              <option value="Todos">Todos los Productos</option>
              <option value="Producto">Por producto</option>
            </select>
          </div>
            <div class="col-6 esconderCantidad">
                <div class="tab-content" id="myTabContent">
                    <p class="general">Cantidad:</p>
                    <input type="num" name="cantidad">
                    
                </div>
            </div>
            <div class="col-6 esconderProducto">
                <div class="tab-content" id="myTabContent">
                    <p class="general">Elejir Producto:</p>
                    <select class="form form-control form-group" name="Sproducto" id="Sproducto">

                    </select>
                </div>
            </div>
            
          </div>
          <input class="mt-3 btn bg-dark text-white btn-lg btn-block esconder" type="submit" value="Imprimir">
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="modalForm2" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">
            <span aria-hidden="true">×</span>
            <span class="sr-only">Close</span>
          </button>
        </div>

        <!-- Modal Body -->
        <div class="modal-body">
        <form class="form-group" id="formularioInventario">
        <div id="mensaje2" style="text-align: center; margin: 10px; font-weight: bold;"></div>
        <div class="row">
            <div class="col-lg-6">
                <h5 class="importante">Stock:</h5>
                <input id="Stock2" name="Tstock2" class="form-control" type="number" value="0" min="0" require> <br>
            </div>
            <div class="col-lg-6">
                <h5 class="general">Stock Minimo:</h5>
                <input id="Tstock_minimo2" name="Tstock_minimo2" class="form-control" type="number" value="0" min="0" require> <br>
            </div>
        </div>
        <div class="row">
        <div class="col-lg-6">
                <h5 class="general">Localizacion:</h5>
                <input id="Tlocalizacion2" name="Tlocalizacion2" class="form-control" type="text" require> <br>
            </div>
            <div class="col-lg-6">
                <div id="productos">
                    <h5 class="importante">Producto:</h5>
                    <input id="inproducto" class="form form-control" list="lproductos" name="Sproducto" autocomplete="off" required>
                    <datalist id="lproductos">
                    </datalist>
                </div>
            </div>
        </div>



    
        <button type="submit" class="col-12 btn btn-lg btn-dark bclose text-white">Guardar</button>
    
</form>
        </div>
      </div>
    </div>
  </div>



  <!-- Modal -->
  <div class="modal fade" id="modalForm" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">
            <span aria-hidden="true">×</span>
            <span class="sr-only">Close</span>
          </button>
        </div>

        <!-- Modal Body -->
        <div class="modal-body">
          <p class="statusMsg"></p>

          <form class="form-group" enctype="multipart/form-data" id="formulario" method="POST">
            <div id="mensaje" style="text-align: center; margin: 10px; font-weight: bold;"></div>
            <div class="d-block d-lg-flex row">
              <div class="col-lg-6 ocultarCodigo">
                <h5 class="importante">Codigo:</h5>
                <input id="codigo_barras" class="form form-control" onkeypress="return codigo(event)" type="text" name="Tcodigo_barras" placeholder="0000000000000" maxlength="13">
                <input type="button" id="generador" value="Generar Código" class="btn btn-primary">
              </div>
              <div class="col-lg-6">
                <h5 class="general">Modelo</h5>
                <input id="modelo" class="form form-control" onkeypress="return check(event)" type="text" name="Tmodelo" placeholder="Modelo" autocomplete="new-password">
              </div>
            </div>
            <div class="d-block d-lg-flex row">
              <div class="col-lg-6">
                <h5 class="importante">Nombre:</h5>
                <input id="nombre" class="form form-control" onkeypress="return check(event)" type="text" name="Tnombre" placeholder="Nombre" autocomplete="new-password" required>
              </div>
              <div class="col-lg-6">
                <h5 class="general">Descripción:</h5>
                <input id="descripcion" class="form form-control" onkeypress="return check(event)" type="text" name="Tdescripcion" placeholder="Descripción" autocomplete="new-password">
              </div>
            </div>
            <div class="d-block d-lg-flex row">
              <div class="col-lg-6">
                <h5 class="general">Marca:</h5>
                <select class="form form-control" id="marca" name="Smarca">

                </select>
              </div>
              <div class="col-lg-6">
                <h5 class="general">Proveedor:</h5>
                <select class="form form-control" id="proveedor" name="Tproveedor">
                </select>
              </div>
            </div>
            <div class="d-block d-lg-flex row">
            <div class="col-lg-6">
                <h5 class="general">Color:</h5>
                <select class="form form-control" id="color" name="Scolor">

                </select>
              </div>
              <div class="col-lg-6">
                <h5 class="general">Descuento:</h5>
                <input id="descuento" class="form form-control" type="text" onkeypress="return check(event)" name="Ndescuento" placeholder="Descuento" autocomplete="new-password"><br>
              </div>
            </div>


            <div class="row text-center">
                <div class="col-lg-12">
                  <h5><label for="imagen" class="general">Imagen:</label></h5>
                  <div id="preview">
                    <img  src="" width="100" height="100" />
                  </div>
                  <div>
                    <input onclick="ejecutar();" style="margin-left: 10px; margin-top: 10px;" id="imagen" style="margin-left: 4px;" type="file" name="Fimagen" />
                  </div>
                </div>
            </div>

            <div class="d-block d-lg-flex row">
              <div class="col-lg-6">
                <h5 class="general">Precio compra:</h5>
                <input id="precio_compra" class="form form-control" type="text" onkeypress="return check(event)" name="Nprecio_compra" placeholder="Precio compra" autocomplete="new-password"><br>
              </div>

              <div class="col-lg-6">
                <h5 class="importante">Precio venta:</h5>
                <input id="precio_venta" class="form form-control" type="text" onkeypress="return check(event)" name="Nprecio_venta" placeholder="Precio venta" autocomplete="new-password" required><br>
              </div>
            </div>

            <div class="d-block d-lg-flex row">
            <div class="col-lg-12">
                  <h5 class="general">Tipo de producto:</h5>
                  <select class="form form-control" id="categoria" name="Stipo_producto">
                    <option value="">Elejir</option>
                    <option value="Calzado">Calzado</option>
                    <option value="Ropa">Ropa</option>
                    <option value="Otros">Otros</option>
                  </select>
                </div>
            </div>
            <div class="d-block d-lg-flex row">
              <div class="col-lg-6">
                  <h5 class="general">Categoria:</h5>
                  <select class="form form-control" id="categoria2" name="Scategoria">

                  </select>
                </div>
              <div class="col-lg-6">
                <h5 class="importante">Unidad de medida:</h5>
                <select class="form form-control" id="unidad_medida" name="Sunidad_medida" required>
                  <option value="pieza">Pieza</option>
                  <option value="par">Par</option>
                  <option value="paquete">Paquete</option>
                </select>
              </div>

            </div>
            <div class="d-block d-lg-flex row">
              <div class="col-lg-6">
                  <h5 class="general">Talla:</h5>
                  <div class="mostrar_producto">
                    <input type="hidden" value="null" name="Stalla_numero">
                  </div>
              </div>
              <div class="col-lg-6">
                <h5 class="general">Tasa IVA:</h5>
                <label><input id="tasa_iva" type="checkbox" name="Ntasa_iva" value="si" >Iva incluido</label>
              </div>

            </div>
            <div class="d-block d-lg-flex row">
            <div class="col-lg-6">
                <h5 class="general">Tasa IEPS:</h5>
                <input id="tasa_ipes" class="form form-control" type="text" onkeypress="return check(event)" name="Ntasa_ipes" placeholder="Tasa IPES" autocomplete="new-password"><br>
              </div>
              <div class="col-lg-6">
                <h5 class="general">Localización:</h5>
                <input id="localizacion" class="form form-control" onkeypress="return check(event)" type="text" name="Tlocalizacion" placeholder="Localización" autocomplete="new-password">
              </div>

            </div>
            <div class="d-block d-lg-flex row">
            <div class="col-lg-6">
                <h5 class="importante">Stock:</h5>
                <input id="stock" class="form form-control" onkeypress="return check(event)" type="number" name="Nstock" placeholder="Stock" autocomplete="new-password" required>
              </div>
            <div class="col-lg-6">
                <h5 class="general">Stock minimo:</h5>
                <input id="stock_minimo" class="form form-control" onkeypress="return check(event)" type="number" name="Nstock_minimo" placeholder="Stock minimo" autocomplete="new-password">
              </div>
            </div>
              <input type="hidden" name="accion" id="accion" >
              <input id="bclose" type="submit" class="mt-3 btn bg-dark text-white btn-lg btn-block" value="Guardar">
          </form>
          <div id="tableHolder" class="row justify-content-center"></div>
        </div>
      </div>
    </div>
  </div>
  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="../js/index.js"></script>
  <script src="../js/user_jquery.js"></script>
  <script src="../js/productos.js"></script>
</body>

</html>