$(document).ready(function () {
  preciocompra = 0.0;
  precioventa = 0.0;
  iva = 0.0;
  let id_negocio_actual = '';
  obtenerNegocioActual();
  obtenerProductosInventario();
  obtenerNegocios();
  obtenerProductosCodigoBarras();
  $('.esconderCantidad').hide();
  $('.esconderProducto').hide();
  $("#accion").val("true");
  $('.esconder').css('display','none');

  $(document).on('change','#Elejir',function(){
    if($(this).val() == 'Todos'){
      $('.esconderCantidad').show();
      $('.esconderProducto').hide();
      $('.esconder').show();
    }else if($(this).val() == 'Producto'){
      $('.esconderCantidad').show();
      $('.esconderProducto').show();
      $('.esconderProducto').show();
    }
  });

  $(document).on('click','.close',function(){
    $('.esconderCantidad').hide();
    $('.esconderProducto').hide();
    $('.esconder').css('display','none');
    $("#formularioInventario").trigger("reset");
    $("#formularioBarras").trigger("reset");
    $("#formularioInventario").trigger("reset");
  });

  $(document).on("click", ".close", function (e) {
    $("#preview").html('<img  src="" width="100" height="100" />');
    $("#formulario").trigger("reset");
  });

  function obtenerProductosCodigoBarras(){
    
    $.ajax({
      url: "../Controllers/productos.php",
      type: "POST",
      data:"productosBarras=productosBarras",

      success: function (response) {
        let datos = JSON.parse(response);
        console.log(datos);
        let template = "<option value = ''>Elejir</option>";
        $.each(datos, function (i, item) {
          for(var j = 0; j <= item.length; j++){
            if(item[j] == 'null'){
              item[j] = "";
            }
          }
          template+=`<option value="${item[0]}">${item[1]} ${item[2]} ${item[3]} ${item[4]}</option>`;
        });
        $('#Sproducto').html(template);
      }
    });
  }

  function obtenerNegocioActual(){
    $.ajax({
      url: "../Controllers/productos.php",
      type: "POST",
      data:"negocioActual=negocioActual",

      success: function (response) {
        id_negocio_actual = response;
      }
    });
  }

  $(document).on('change','#negocio',function(){
    obtenerDatosTablaProductos($(this).val());;
  });

  function obtenerNegocios(){
    $.ajax({
      url: "../Controllers/productos.php",
      type: "POST",
      data:"negocios=negocios",

      success: function (response) {
        let datos = JSON.parse(response);
        var dat = "";
        let template = "<option value = ''>Elejir</option>";
        $.each(datos, function (i, item) {
          template+=`<option value="${item[0]}">${item[1]}</option>`;
        });
        $('#negocio').html(template);
      }
    });
  }

  function obtenerProductosInventario(){
    $.ajax({
      url: "../Controllers/productos.php",
      type: "POST",
      data:"producto=producto",

      success: function (response) {
        let datos = JSON.parse(response);
        let template = "";
        $.each(datos, function (i, item) {
          for(var j = 0; j <= item.length; j++){
            if(item[j] == 'null'){
              item[j] = "";
            }
      }
          template+=`<option value="${item[0]}">${item[1]} ${item[2]} ${item[3]} ${item[4]}</option>`;
        });
        $('#lproductos').html(template);
      }
    });
  }

  var touchtime = 0;
  $(document).on("click", "td", function () {
    if($('#negocio').val() == id_negocio_actual){
      if (touchtime == 0) {
        // set first click
        touchtime = new Date().getTime();
      } else {
        // compare first click to this click and see if they occurred within double click threshold
        if (new Date().getTime() - touchtime < 800) {
          // double click occurred
          var valores = "";
          $(this).parent("tr").find("td").each(function () {
            valores += $(this).html() + "?";
          });
  
          datos = valores.split("?");
  
          $("#codigo_barras").val(datos[0]);
          $("#modelo").val(datos[1]);
          $("#nombre").val(datos[2]);
          $("#descripcion").val(datos[3]);
          
          if(datos[4] == ''){
            $("#categoria").val('null');
          }else{
            $("#categoria").val(datos[4]);
          }
          pintarCombo();
          if(datos[5] == ''){
            $("#marca").val('null');
          }else{
            $("#marca").val(datos[5]);
          }
          $("#proveedor").val(datos[6]);
         
          if(datos[7] == ''){
            $("#color").val('null');
          }else{
            $("#color").val(datos[7]);
          }
          $("#preview").html(datos[8]);
          $("#precio_compra").val(datos[9]);
          $("#precio_venta").val(datos[10]);
          $("#descuento").val(datos[11]);
          $("#unidad_medida").val(datos[12]);  
          if (datos[13] == "Si") {
            $("#tasa_iva").prop("checked", true);
          } else {
            $("#tasa_iva").prop("checked", false);
          }
          $("#tasa_ipes").val(datos[14]);
          $("#talla_numero").val(datos[15]);
          $("#localizacion").val(datos[16]);
          $("#stock").val(datos[17]);
          $("#stock_minimo").val(datos[18]);
          $("#modalForm").modal("show");
          $("#accion").val("true");
          touchtime = 0;
        } else {
          // not a double click so set as a new first click
          touchtime = new Date().getTime();
        }
      }
    }
  });


  $(document).on("click", "#tasa_iva", function () {
    if($("#precio_compra").val() != ''){
      if ($("#tasa_iva").prop("checked")) {
        precioventa = parseFloat($("#precio_venta").val());
        preciocompra = parseFloat($("#precio_compra").val());
        iva = preciocompra * 0.16;
        $("#precio_venta").val(precioventa + iva);
      } else {
        iva = 0.0;
        precioventa = parseFloat($("#precio_venta").val());
        preciocompra = parseFloat($("#precio_compra").val());
        iva = preciocompra * 0.16;
        $("#precio_venta").val(precioventa - iva);
      }
    }
  });

  function pintarCombo() {
    var template = "";
    if ($("#categoria").val() == "Ropa") {
      template = `                  
          <select class="form form-control" id="talla_numero" name="Stalla_numero">
            <option value="">Elejir</option>
            <option value="XXL">XXL</option>
            <option value="XL">XL</option>
            <option value="L">L</option>
            <option value="M">M</option>
            <option value="S">S</option>
            <option value="XS">XS</option>
            <option value="XXS">XXS</option>
          </select>`;
    } else if ($("#categoria").val() == "Calzado") {
      template += `<select class="form form-control" id="talla_numero" name="Stalla_numero">
          <option value="">Elejir</option>
          `;
      for (var i = 10; i <= 30; i++) {
        for (var j = 0; j < 2; j++) {
          if (j == 0) {
            template += `
                  <option value="${i}">${i}</option>
                  `;
          } else if (j > 0 && i == 10) {} else if (j > 0 && i == 30) {} else if (j > 0) {
            medida = i + 0.5;
            template += `
                  <option value="${medida}">${medida}</option>
                  `;
          }
        }
      }
      template += `</select>`;
    } else if ($("#categoria").val() == "Otros") {
      template = `<input type="hidden" value="Otros" name="Stalla_numero">`;
    } else {
      template = `<input type="hidden" value="" name="Stalla_numero">`;
    }
    $(".mostrar_producto").html(template);
  }

  $(document).on("change", "#categoria", function () {
    pintarCombo();
  });

  $(document).on("click", "#generador", function () {
    $.ajax({
      url: "../Controllers/generador.php",
      type: "GET",

      success: function (response) {
        $("#codigo_barras").val(response);
      }
    });
  });

  $(document).on("click", "#bclose", function () {

      var codigo = $("#codigo_barras").val();
      var nombre = $("#nombre").val();
      var venta = $("#precio_venta").val();

      if (codigo.trim() == "") {
        $("#codigo_barras").focus();
        return false;
      }
      if (nombre.trim() == "") {
        $("#nombre").focus();
        return false;
      } else if (venta.trim() == "") {
        $("#precio_venta").focus();
        return false;
      }
  });

  $("#formularioInventario").submit(function (e) {

    if($('#Stock2').val() == ''){
      $('#Stock2').focus();
      return false;
    }
    if($('#inproducto').val() == ''){
      $('#inproducto').focus();
      return false;
    }

    var formData = new FormData(this);
    $.ajax({
      url: "../Controllers/productos.php",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,

      
      success: function (response) {
        console.log(response);
        if (response == "1") {
          $("#mensaje2").text("Registro Exitoso");
          $("#mensaje2").css("color", "green");
          $("#codigo_barras").focus();
          $("#formularioInventario").trigger("reset");
        } else {
          $("#mensaje2").text("Registro fallido");
          $("#mensaje2").css("color", "red");
          $("#codigo_barras").focus();
        }
        obtenerDatosTablaProductos($('#negocio').val());
        obtenerProductosInventario();
      }
    });
    e.preventDefault();
  });

  $("#formulario").submit(function (e) {

    var formData = new FormData(this);
    $.ajax({
      url: "../Controllers/productos.php",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,

      success: function (response) {
        console.log(response);
        if (response == "1") {
          if ($("#accion").val() == 'true') {
            $(".modal").modal("hide");
            $("#mensaje").css("display", "none");
            $("#accion").val("false");
          }
          $("#mensaje").text("Registro Exitoso");
          $("#mensaje").css("color", "green");
          $("#codigo_barras").focus();
          $("#formulario").trigger("reset");
        } else {
          $("#mensaje").text("Registro fallido");
          $("#mensaje").css("color", "red");
          $("#codigo_barras").focus();
        }
        obtenerDatosTablaProductos($('#negocio').val());
      }
    });
    e.preventDefault();
  });

  $(document).on('click','.agregar',function(){
    $("#accion").val("false");
    $("#formulario").trigger("reset");
  });

  function obtenerDatosTablaProductos(negocio) {
    $.ajax({
      url: "../Controllers/productos.php",
      type: "POST",
      data: "tabla=" + negocio,

      success: function (response) {
        let datos = JSON.parse(response);
        var dat = "";
        let template = "";
        $.each(datos, function (i, item) {
          for(var j = 0; j <= item.length; j++){
                if(item[j] == 'null'){
                  item[j] = "";
                }
          }
          template += `
         <tr>
                <td class="text-nowrap text-center">${item[0]}</td>
                <td class="text-nowrap text-center">${item[1]}</td>
                <td class="text-nowrap text-center">${item[2]}</td>
                <td class="text-nowrap text-center">${item[3]}</td>
                <td class="text-nowrap text-center">${item[4]}</td>
                <td class="text-nowrap text-center">${item[5]}</td>
                <td class="text-nowrap text-center">${item[6]}</td>
                <td class="text-nowrap text-center">${item[7]}</td>
                <td><img src="${item[8]}" height="100" width="100"></td>
                <td class="text-nowrap text-center">${item[9]}</td>
                <td class="text-nowrap text-center">${item[10]}</td>
                <td class="text-nowrap text-center">${item[11]}</td>
                <td class="text-nowrap text-center">${item[12]}</td>
                <td class="text-nowrap text-center">${item[13]}</td>
                <td class="text-nowrap text-center">${item[14]}</td>
                <td class="text-nowrap text-center">${item[15]}</td>
                <td class="text-nowrap text-center">${item[16]}</td>
                <td class="text-nowrap text-center">${item[17]}</td>
                <td class="text-nowrap text-center">${item[18]}</td>
          `;
        });
        $("#cuerpo").html(template);
      }
    });
  }
});
