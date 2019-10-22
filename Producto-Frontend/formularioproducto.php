<form class="form-group" enctype="multipart/form-data" id="formulario" method="post">
  <div id="mensaje" style="text-align: center; margin: 10px; font-weight: bold;"></div>

  <div class="d-block d-lg-flex row">
  <div class="col-lg-4">
      <h5 class="general" style="color: #EF5602">Codigo</h5>
      <input id="codigo_barras" class="form form-control" onkeypress="return check(event)" type="text" name="Tcodigo_barras" placeholder="Codigo" autocomplete="new-password" required>

    </div>
    <div class="col-lg-4">
      <h5 class="general">Modelo</h5>
      <input id="modelo" class="form form-control" onkeypress="return check(event)" type="text" name="Tmodelo" placeholder="Modelo" autocomplete="new-password" >
    </div>
    <div class="col-lg-4">
      <h5 class="general">Nombre:</h5>
      <input id="nombre" class="form form-control" onkeypress="return check(event)" type="text" name="Tnombre" placeholder="Nombre" autocomplete="new-password" required>
    </div>
  </div>
  <div class="d-block d-lg-flex row">
    <div class="col-lg-4">
      <h5 class="general">Descripción:</h5>
      <input id="descripcion" class="form form-control" onkeypress="return check(event)" type="text" name="Tdescripcion" placeholder="Descripción" autocomplete="new-password" >
    </div>
      <div class="col-lg-4">
        <h5 class="general">Categoria:</h5>
        <select class="form form-control" id="categoria" name="Scategoria">
          <option value="A">Activa</option>
        </select>
      </div>
    <div class="col-lg-4">
      <h5 class="general">Marca:</h5>
      <select class="form form-control" id="marca" name="Smarca">
        <option value="patito">patito</option>
      </select>
    </div>
  </div>
  <div class="d-block d-lg-flex row">
  <div class="col-lg-4">
    <h5 class="general">Proveedor:</h5>
    <input id="proveedor" class="form form-control" onkeypress="return check(event)" type="text" name="Tproveedor" placeholder="Proveedor" autocomplete="new-password" >
  </div>
    <div class="col-lg-4">
      <h5 class="general">Color:</h5>
      <select class="form form-control" id="color" name="Scolor">
        <option value="rojo">rojo</option>
      </select>
    </div>
    <div class="col-lg-4">
      <h5 class="general">Imagen:</h5>
      <input id="imagen" class="form form-control" type="file" onkeypress="return check(event)" name="Fimagen" placeholder="imagen" autocomplete="new-password"><br>
    </div>
  </div>
  <div class="d-block d-lg-flex row">
    <div class="col-lg-5">
      <h5 class="general">Precio compra:</h5>
      <input id="precio_compra" class="form form-control" type="number" onkeypress="return check(event)" name="Nprecio_compra" placeholder="Precio compra" autocomplete="new-password"><br>
    </div>

    <div class="col-lg-5">
      <h5 class="general">Precio venta:</h5>
      <input id="precio_venta" class="form form-control" type="number" onkeypress="return check(event)" name="Nprecio_venta" placeholder="Precio venta" autocomplete="new-password" required><br>
    </div>
  </div>
  <div class="d-block d-lg-flex row">
    <div class="col-lg-6">
      <h5 class="general">Unidad de medida:</h5>
      <select class="form form-control" id="unidad_medida" name="Sunidad_medida">
        <option value="pieza">Pieza</option>
        <option value="par">Par</option>
        <option value="paquete">Paquete</option>
      </select>
    </div>
    <div class="col-lg-6">
        <h5 class="general">Talla:</h5>
        <select class="form form-control" id="talla_numero" name="Stalla_numero">
          <option value="s">S</option>
          <option value="m">M</option>
          <option value="l">L</option>
          <option value="xl">XL</option>
        </select>
      </div>
  </div>
  <div class="d-block d-lg-flex row">
  <div class="col-lg-4">
    <h5 class="general">Tasa IVA:</h5>
    <input id="tasa_iva" class="form form-control" type="number" onkeypress="return check(event)" name="Ntasa_iva" placeholder="Tasa IVA" autocomplete="new-password" required><br>
  </div>

  <div class="col-lg-4">
    <h5 class="general">Tasa IPES:</h5>
    <input id="tasa_ipes" class="form form-control" type="number" onkeypress="return check(event)" name="Ntasa_ipes" placeholder="Tasa IPES" autocomplete="new-password" required><br>
    <input type="hidden" name="accion" value="false">
  </div>
  <div class="col-lg-4">
    <h5 class="general">Descuento:</h5>
    <input id="descuento" class="form form-control" type="number" onkeypress="return check(event)" name="Ndescuento" placeholder="Descuento" autocomplete="new-password" required><br>
  </div>

      <input id="bclose" type="submit" class="mt-3 btn bg-dark text-primary btn-lg btn-block" value="Guardar">
  </form>
