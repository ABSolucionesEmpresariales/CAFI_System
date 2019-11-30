$(document).ready(function () {
  preciocompra = 0.0;
  precioventa = 0.0;
  iva = 0.0;
  let id_negocio_actual = '';
  let acceso = "";
  obtenerAcceso();
  obtenerNegocioActual();
  obtenerProductosInventario();
  obtenerNegocios();
  obtenerProductosCodigoBarras();
  obtenerColores();
  obtenerMarcas();
  obtenerCategorias();
  obtenerProveedores();
  $('.esconderCantidad').hide();
  $('.esconderProducto').hide();
  $("#accion").val("true");
  $('.esconder').css('display','none');
  
  function obtenerAcceso(){
    $.ajax({
      url: "../Controllers/login.php",
      type: "POST",
      data:"accesoPersona=accesoPersona",

      success: function (response) {
        acceso = response;
        $.ajax({
          url: "../Controllers/productos.php",
          type: "POST",
          data: "tabla=" + $('#negocio').val(),
    
          success: function (response) {
            let datos = JSON.parse(response);
            var dat = "";
            let template = "";
            $.each(datos, function (i, item) {
              for(var j = 0; j <= item.length; j++){
                    if(item[j] == 'null' || item[j] === null){
                      item[j] = "";
                    }
              }
              template += `<tr>`;
             if(acceso == 'CEO'){
              template += `<td class="text-nowrap text-center"><input type="checkbox" value="si"></td>`;
             }
              template += `
                    <td class="text-nowrap text-center">${item[0]}</td>
                    <td class="text-nowrap text-center">${item[1]}</td>
                    <td class="text-nowrap text-center">${item[2]}</td>
                    <td class="text-nowrap text-center">${item[3]}</td>
                    <td class="text-nowrap text-center">${item[4]}</td>
                    <td class="text-nowrap text-center">${item[5]}</td>
                    <td class="text-nowrap text-center">${item[6]}</td>
                    <td class="text-nowrap text-center">${item[7]}</td>`;
                    if(item[8] != ''){
              template += `<td><img src="${item[8]}" height="100" width="100"></td>`;
                    }else{
              template += `<td><img src="" height="100" width="100"></td>`; 
                    }
              template += `
                    <td class="text-nowrap text-center">$${item[9]}</td>
                    <td class="text-nowrap text-center">$${item[10]}</td>
                    <td class="text-nowrap text-center">${item[11]}</td>
                    <td class="text-nowrap text-center">${item[12]}</td>
                    <td class="text-nowrap text-center">${item[13]}</td>
                    <td class="text-nowrap text-center">${item[14]}</td>
                    <td class="text-nowrap text-center">${item[15]}</td>
                    <td class="text-nowrap text-center">${item[16]}</td>
                    <td class="text-nowrap text-center">${item[17]}</td>
                    <td class="text-nowrap text-center">${item[18]}</td>
                    <td class="text-nowrap text-center">${item[19]}</td>
              `;
            });
            $("#cuerpo").html(template);
          }
        });
      }
    });
  }

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

  function obtenerProveedores(){
    $.ajax({
      url: "../Controllers/productos.php",
      type: "POST",
      data:"proveedores=proveedores",

      success: function (response) {
        let datos = JSON.parse(response);
        console.log(datos);
        let template = "<option value = '0'>Elejir</option>";
        $.each(datos, function (i, item) {
          template+=`<option value="${item[0]}">${item[1]}</option>`;
        });
        $('#proveedor').html(template);
      }
    });
  }

  function obtenerColores(){
    $.ajax({
      url: "../Controllers/productos.php",
      type: "POST",
      data:"colores=colores",

      success: function (response) {
        let datos = JSON.parse(response);
        console.log(datos);
        let template = "<option value = ''>Elejir</option>";
        $.each(datos, function (i, item) {
          template+=`<option value="${item[0]}">${item[0]}</option>`;
        });
        $('#color').html(template);
      }
    });
  }

  function obtenerMarcas(){
    $.ajax({
      url: "../Controllers/productos.php",
      type: "POST",
      data:"marcas=marcas",

      success: function (response) {
        let datos = JSON.parse(response);
        console.log(datos);
        let template = "<option value = ''>Elejir</option>";
        $.each(datos, function (i, item) {
          template+=`<option value="${item[0]}">${item[0]}</option>`;
        });
        $('#marca').html(template);
      }
    });
  }

  function obtenerCategorias(){
    $.ajax({
      url: "../Controllers/productos.php",
      type: "POST",
      data:"categorias=categorias",

      success: function (response) {
        let datos = JSON.parse(response);
        console.log(datos);
        let template = "<option value = ''>Elejir</option>";
        $.each(datos, function (i, item) {
          template+=`<option value="${item[0]}">${item[0]}</option>`;
        });
        $('#categoria2').html(template);
      }
    });
  }

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
        let template =`<option value = ''>Elejir</option>`;
        $.each(datos, function (i, item) {
          for(var j = 0; j <= item.length; j++){
            if(item[j] == 'null'){
              item[j] = "";
            }
          }
          template+=`<option value="${item[0]}">${item[1]} ${item[2]} ${item[3]} ${item[4]}</option>`;
        });
        $('#selectpro').html(template);
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
    obtenerAcceso();
  });

  function obtenerNegocios(){
    $.ajax({
      url: "../Controllers/productos.php",
      type: "POST",
      data:"negocios=negocios",

      success: function (response) {
        let datos = JSON.parse(response);
        console.log(response);
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
        if (new Date().getTime() - touchtime < 300) {
          // double click occurred
          var valores = "";
          $(this).parent("tr").find("td").each(function () {
            valores += $(this).html() + "?";
          });
  
          datos = valores.split("?");
          $('.ocultarCodigo').hide();
          $("#codigo_barras").val(datos[1]);
          $("#modelo").val(datos[2]);
          $("#nombre").val(datos[3]);
          $("#descripcion").val(datos[4]);
          
          if(datos[5] == ''){
            $("#categoria2").val('');
          }else{
            $("#categoria2").val(datos[5]);
          }
          pintarCombo();
          if(datos[6] == ''){
            $("#marca").val('');
          }else{
            $("#marca").val(datos[6]);
          }
          $("#proveedor").val(datos[7]);
         
          if(datos[8] == ''){
            $("#color").val('');
          }else{
            $("#color").val(datos[8]);
          }
          $("#preview").html(datos[9]);
          precioCompra = datos[10].split("$");
          $("#precio_compra").val(precioCompra[1]);
          precioVenta = datos[11].split("$");
          $("#precio_venta").val(precioVenta[1]);
          $("#descuento").val(datos[12]);
          $("#categoria").val(datos[13]);
          $("#unidad_medida").val(datos[14]);  
          if (datos[15] == "Si") {
            $("#tasa_iva").prop("checked", true);
          } else {
            $("#tasa_iva").prop("checked", false);
          }
          $("#tasa_ipes").val(datos[16]);
          $("#talla_numero").val(datos[17]);
          $("#localizacion").val(datos[18]);
          $("#stock").val(datos[19]);
          $("#stock_minimo").val(datos[20]);
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
        obtenerAcceso();
        obtenerProductosInventario();
      }
    });
    e.preventDefault();
  });

  $(document).on('click','.check',function(){

    if($(this).prop('checked')){
        $('#cuerpo').children("tr").find("td").find("input").each(function () {
                 $(this).prop("checked", true);
        });    
    }else{
        $('#cuerpo').children("tr").find("td").find("input").each(function () {
                 $(this).prop("checked", false);
            
        });    
    }
});

$(document).on('click','.eliminar',function(){
  swal({
      title: "Esta seguro que desea eliminar ?",
      text: "Esta accion eliminara los datos!",
      type: "warning",
      showCancelButton: true,
      confirmButtonClass: "btn-danger",
      confirmButtonText: "Si, eliminarlo!",
      closeOnConfirm: false
    },
    function(){
        if(enviarDatos() != '0'){
          swal("Exito!", 
          "Sus datos han sido eliminados.",
           "success");
        }else{
          swal("Error!", 
          "Ups, algo salio mal.",
           "warning");
        }
        $('.check').prop("checked", false);
        obtenerAcceso();
    });
});

function enviarDatos(){
  var valores = "";

  $('#cuerpo').children("tr").find("td").find("input").each(function () {
      if($(this).prop('checked')){
          valores += $(this).parents("tr").find("td").eq(1).text() + "?";
      }
  }); 
  valores += "0";
  result = valores.split("?");
  console.log(result);
   $.ajax({
    url: "../Controllers/productos.php",
    type: "POST",
    data: {'array': JSON.stringify(result)},

    success: function (response) {
      console.log(response);
          return response;
    }
  }); 
}

  $("#formulario").submit(function (e) {

    var formData = new FormData(this);
    $.ajax({
      url: "../Controllers/productos.php",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,

      success: function (response) {
 
        if (response == 1) {
          if ($("#accion").val() == 'true') {
            $(".modal").modal("hide");
            $("#mensaje").css("display", "none");
            $("#accion").val("false");
          }
          $("#mensaje").css("display", "block");
          $("#mensaje").text("Registro Exitoso");
          $("#mensaje").css("color", "green");
          $("#codigo_barras").focus();
          $("#formulario").trigger("reset");
        } else {
          $("#mensaje").text("Registro fallido");
          $("#mensaje").css("color", "red");
          $("#codigo_barras").focus();
        }
        obtenerAcceso();
      }
    });
    e.preventDefault();
  });

  $(document).on('click','.agregar',function(){
    $("#accion").val("false");
    $('.esconderCantidad').hide();
    $('.esconderProducto').hide();
    $('.esconder').css('display','none');
    $("#formularioInventario").trigger("reset");
    $("#formularioBarras").trigger("reset");
    $("#formularioInventario").trigger("reset");
    $("#mensaje").css("display", "none");
    $('.ocultarCodigo').show();
  });

});
