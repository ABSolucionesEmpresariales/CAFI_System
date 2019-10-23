<form class="form-group" id="formulario" method="POST">>
  <div id="mensaje" style="text-align: center; margin: 10px; font-weight: bold;"></div>
  <div class="d-block d-lg-flex row">
      <div class="col-lg-6">
        <h5 class="general">Localización:</h5>
        <input id="localizacion" class="form form-control" onkeypress="return check(event)" type="text" name="Tlocalizacion" placeholder="Localización" autocomplete="new-password" >
      </div>
      <div class="col-lg-4">
        <h5 class="general">Stock:</h5>
        <input id="stock" class="form form-control" onkeypress="return check(event)" type="number" name="Nstock" placeholder="Stock" autocomplete="new-password" required>
      </div>
    </div>
    <div class="d-block d-lg-flex row">
      <div class="col-lg-6">
        <h5 class="general">Stock minimo:</h5>
        <input id="stock_minimo" class="form form-control" onkeypress="return check(event)" type="number" name="Nstock_minimo" placeholder="Stock minimo" autocomplete="new-password" >
      </div>
      <div class="col-lg-4">
        <h5 class="general">Estado:</h5>
        <input id="estado" class="form form-control" onkeypress="return check(event)" type="text" name="Testado" placeholder="Estado" autocomplete="new-password" required>
      </div>
      <input id="bclose" type="submit" class="mt-3 btn bg-dark text-primary btn-lg btn-block" value="Guardar">
    </form>
