$(document).ready(function () {
    var datos = [];
    let acceso = "";
    let compra = "";
    $('#accion').val('false');
    console.log($('#accion').val());
    obtenerColores();
    obtenerMarcas();
    obtenerCategorias();
    obtenerProveedores2();
    obtenerProveedores();
    obtenerProductos();
    obtenerAcceso();
    verificarJSON();
    datosFactura();
    pintarTablaCarrito();
    obtenerDatosTabla();

    $(document).on('keyup','#porcentaje',function(){
      if($(this).val() != ''){
        precio = $('#costo_producto').val();
        dato = 0;
        if(precio != 0 || precio != ''){
          dato = precio * parseFloat('.'+$('#porcentaje').val());
          $('#precio_venta').val(parseFloat(precio) + dato);
        } 
      }else{
        $('#precio_venta').val('0');
      }
    });

    $(document).on('keyup','#precio_venta',function(){
      if($(this).val() != ''){
        precio = $('#costo_producto').val();
        dato = 0;
        if(precio != 0 || precio != ''){
          dato = 100 * (parseFloat($(this).val()) - parseFloat(precio));
          if(dato > 0){
            $('#porcentaje').val(dato / precio);
          }else{
            $('#porcentaje').val(0);
          }
        }
      }else{
        $('#porcentaje').val('0');
      }
    });

    $(document).on('keyup','#costo_producto',function(){
      console.log(parseInt($(this).val()));
      if($(this).val() == ''){
        $('#precio_venta').val('0');
        $('#porcentaje').val('0');
      }else{
        if(parseInt($(this).val()) > 0){
          if($('#porcentaje').val() != '0' && $('#precio_venta').val() != '0'){
              if($('#porcentaje').val() != '' || $('#porcentaje').val() != '0'){
                porsentaje = $('#porcentaje').val();
                precio = $(this).val();
                $('#precio_venta').val( parseFloat(precio) + (parseFloat(precio) * parseFloat("."+ porsentaje)) );
              }else if($('#precio_venta').val() != ''){
                $('#porcentaje').val(parseFloat($(this).val()) / ((parseFloat($('#precio_venta').val()) - parseFloat($(this).val())) * 100) );
              }
          }
      }
      }
    });

    $(document).on('keyup','#codigo_producto',function(){

      if($(this).val().length > 3){
        $.ajax({
          url: "../Controllers/compras.php",
          type: "POST",
          data: "idproducto="+$(this).val(),
          success: function(response) {
            console.log(response);
            if(response != '[]'){
              let datos = JSON.parse(response);
              let template = null;
              $.each(datos, function(i, item) {
                $('#nombre_producto').val(item[0]);
                $('#unidad_medida').val(item[1]);
              });
            }
          }
        });
      }else{
        $('#nombre_producto').val('');
        $('#unidad_medida').val('');
      }
    });

    var touchtime = 0;
    $(document).on("click", "td", function () {
        if (touchtime == 0) {
          touchtime = new Date().getTime();
        } else {
          // compare first click to this click and see if they occurred within double click threshold
          if (new Date().getTime() - touchtime < 300) {
            // double click occurred
            $("#ocultardiv").css("display", "none");
            $("#divformedit").css("display", "block");
            $("#mensaje").css("display", "none");
            let valores = "";
            $(this)
              .parents("tr")
              .find(".datos")
              .each(function() {
                valores += $(this).html() + "?";
              });
        
            datos = valores.split("?");
            compra = datos[0];
            estado = datos[1];
            $("#estado").val(estado);

  
          $("#modalFormMostrar").modal("show");
          
          } else {
            // not a double click so set as a new first click
            touchtime = new Date().getTime();
          }
        }
    }); 

    $("#fmestado").submit(function(e){

        const postData2 = {
            estado: $("#estado").val(),
            idcompras: compra
          };

          $.ajax({
            url: "../Controllers/compras.php",
            type: "POST",
            data: postData2,
            success: function(response) {
                if (response == "1") {
                  $('#modalFormMostrar').modal('hide');
                  $("#mensaje").css("display", "none");
                  obtenerDatosTabla();
                } else {
                  $("#mensaje").css("display", "block");
                  $("#mensaje").text("Registro fallido");
                  $("#mensaje").css("color", "red");
                  $("#estado").focus();

            }
        }
          });
        obtenerDatosTabla();
        e.preventDefault();
      });

   
//mostrar el concepto de la compra
$(document).on('click','.bconcepto',function(){
    $("#divformedit").css("display", "none");
    $('#modalFormMostrar').modal('show');
    $("#ocultardiv").css("display", "block");
    $("#mensaje").css("display", "none");
          
    let valores = '';
    $(this)
    .parents("tr")
    .find(".datos")
    .each(function() {
      valores += $(this).html() + "?";
    });
    datos = valores.split("?");
     const postData = {
      idcompras: datos[0]
    };

  
    $.post("../Controllers/compras.php", postData, function(response) {
        console.log(response);
      let datos = JSON.parse(response);
  
      let template = null;
      $.each(datos, function(i, item) {
        template += `
                  <tr>
                  <td>${item[0]}</td>
                  <td>${item[1]}</td>
                  <td><img src="${item[2]}" height="100" width="100"></td>
                  <td>${item[3]}</td>
                  <td>${item[4]}</td>
                  <td>${item[5]}</td>
                  <td>${item[6]}</td>
                  <td>${item[7]}</td>
                  <td>${item[8]}</td>
                  <td>${item[9]}</td>
                  <td>${item[10]}</td>
                 </tr> `;
      });
      $("#cuerpotablaconcepto").html(template);
    });
});

    $(document).on('click','#nuevo_proveedor',function(){
        obtenerDatosFactura();
        location.href ="proveedores.php";
    });
    
    //Datos compra
    var descuento = $('#descuento').val();
    var anticipo = $('#anticipo').val();

    //Descripcion de compra
    var subtotal_total = 0;
    var iva_total = 0;
    var ieps_total = 0;
    var total = parseInt($('#info_total').text().split('$')[1]);

    function obtenerAcceso(){
        $.ajax({
          url: "../Controllers/login.php",
          type: "POST",
          data:"accesoPersona=accesoPersona",
    
          success: function (response) {
            acceso = response
          }
        });
      }

      $(document).on('click','.check',function(){
        if($(this).prop('checked')){
            $('#cuerpo2').children("tr").find("td").find("input").each(function () {
                     $(this).prop("checked", true);
            });    
        }else{
            $('#cuerpo2').children("tr").find("td").find("input").each(function () {
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
              enviarDatos3();
              swal("Exito!", 
              "Sus datos han sido eliminados.",
               "success");
              $('.check').prop("checked", false);
          });
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

    
  function obtenerProveedores2(){
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


    function enviarDatos3(){
        var valores = "";
        $('#cuerpo2').children("tr").find("td").find("input").each(function () {
            if($(this).prop('checked')){
                valores += $(this).parents("tr").find("td").eq(1).text() + "?";
            }
        }); 
        valores += "0";
        result = valores.split("?");

         $.ajax({
          url: "../Controllers/compras.php",
          type: "POST",
          data: {'array': JSON.stringify(result)},
  
          success: function (response) {
            console.log(response);
            obtenerDatosTabla();
            if(response == 1){
              return 1;
            }
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
        }
      });
      e.preventDefault();
    });

    $(document).on('click','#btncompra, #compra_finalizada2, #cancelar_compra, #agregar_producto, #eliminar_producto', function(){
        var boton = $(this).attr('id');

        if(boton == "cancelar_compra"){//Boton cancelar compra
            sessionStorage.setItem('info-compras', JSON.stringify(null));
            sessionStorage.setItem('info-facturas', JSON.stringify(null));
            $('#compras').show();
            $('#compra').hide();
            $('#folio_factura').val(parseInt(factura[0]));
            $('#fecha_facturacion').val("");
            $('#fecha_vencimiento').val("");
            $('#codigo_proveedor').val("");
            $('#metodo_pago').val("");
            $('#descuento').val("");
            $('#forma_de_pago').val("");
            $('#inicio_de_credito').val("");
            $('#fecha_del_credito').val("");
            $('#anticipo').val(""); 
        }else if(boton == "btncompra"){//Boton comprar
            $('#compras').hide();
            $('#compra').show();
        }else if(boton == "agregar_producto"){//Boton agregar producto a compra
            //Productos en la compra
            var codigo = $('#codigo_producto').val();
            var nombre = $('#nombre_producto').val();
            var costo = $('#costo_producto').val();
            var ieps = '0';
            var cantidad = $('#cantidad').val();
            var unidad_medida = $('#unidad_medida').val();
            var precio_venta = $('#precio_venta').val();
            if(codigo.trim() == '' || codigo.trim() < 0){
                $('#codigo_producto').focus();
                return false;
            }else if(nombre.trim() == ''){
                $('#nombre_producto').focus();
                return false;
            }else if(cantidad.trim() == '' || cantidad.trim() < 1){
              $('#cantidad').focus();
              return false;
            }else if(unidad_medida.trim() == ''){
              $('#unidad_medida').focus();
              return false;
            }else if(costo.trim() == '' || costo.trim() < 1){
              $('#costo_producto').focus();
              return false;
            }else if(precio_venta.trim() == ''){
              $('#precio_venta').focus();
              return false;
            }else{
                iva_producto = 0;
                var ieps_producto = 0;
                ieps_producto = ((costo/100)*ieps)*cantidad;

                var subtotal_producto = costo*cantidad;
                
                if ($('#fecha_facturacion').val() != '' && $('#fecha_vencimiento').val() != ''){//Impuesto IVA
                    iva_producto = ((costo/100)*16)*cantidad;
                    subtotal_producto += iva_producto;
                }
                if (ieps != 0){//Impuesto IEPS
                    subtotal_producto += ieps_producto;
                }

                console.log(unidad_medida);
                console.log(precio_venta);

                var row=`
                        <tr>
                            <td class="text-nowrap text-center"><button id='eliminar_producto' class='btn btn-danger' name=''>Eliminar</button></td>
                            <td class="text-nowrap text-center numero datos">${codigo}</td>
                            <td class="text-nowrap text-center datos">${nombre}</td>
                            <td id="producto_costo" class="text-nowrap text-center datos">$${costo}</td>
                            <td id="producto_iva" class="text-nowrap text-center datos">$${iva_producto}</td>
                            <td id="producto_ieps" class="text-nowrap text-center datos">$${ieps_producto}</td>
                            <td id="producto_cantidad" class="text-nowrap text-center datos">${cantidad}</td>
                            <td id="producto_subtotal" class="text-nowrap text-center datos">$${subtotal_producto}</td>
                            <td id="producto_unidad_medida" class="text-nowrap text-center datos">${$('#unidad_medida').val()}</td>
                            <td id="producto_precio_venta" class="text-nowrap text-center datos">$${$('#precio_venta').val()}</td>
                        </tr>
                        `;
    
                $('#tabla_compra').append(row);

                
                subtotal_total += (costo*cantidad);
                iva_total += iva_producto;
                ieps_total += ieps_producto;
                total += subtotal_producto;

                $('#info_subtotal').html("$"+subtotal_total);
                $('#info_descuento').html("$"+descuento);
                $('#info_iva').html("$"+iva_total);
                $('#info_ieps').html("$"+ieps_total);
                $('#info_anticipo').html("$"+anticipo);
                $('#info_total').html("$"+total);

                $('#info_total2').val(total);
                $('#info_iva2').val(iva_total);
        
                $('#codigo_producto').val('');
                $('#nombre_producto').val('');
                $('#costo_producto').val('');
                $('#ieps').val('');
                $('#cantidad').val('');
                $('#codigo_producto').focus();
                $('#unidad_medida').val('');
                $('#precio_venta').val('');
                obtenerDatosCarrito();
            }

        }else if(boton == "eliminar_producto"){//Boton eliminar producto de tabla
            $(this).parent().parent().remove();
            obtenerDatosCarrito();
        }else if(boton == "compra_finalizada2"){//Boton compra finalizada

          console.log($('#info_total').val());

            //if()

            var carrito = sessionStorage.getItem('info-compras');
            carrito = JSON.parse(carrito);
            const postData = {
                Tfolio_factura:  $('#folio_factura').val(),
                Sproveedor:  $('#codigo_proveedor').val(),
                Sforma_pago:  $('#forma_de_pago').val(),
                Dfecha_factura:  $('#fecha_facturacion').val(),
                Dfecha_vencimiento_factura:  $('#fecha_vencimiento').val(),
                Dfecha_vencimiento_credito: $('#fecha_del_credito').val(),
                Tanticipo: $('#anticipo').val(),
                Tdescuento: $('#descuento').val(),
                total: $('#info_total2').val(),
                tasa_iva: $('#info_iva2').val(),
                Smetodo_pago: $('#metodo_pago').val(),
                arraycarrito: JSON.stringify(carrito)
              };

               $.ajax({
                url: "../Controllers/compras.php",
                type: "POST",
                data: postData,
        
                success: function (response) {
                    console.log(response);
                  if(response == 1){
                    $('#compras').show();
                    $('#compra').hide();
                    sessionStorage.setItem('info-compras', JSON.stringify(null));
                    sessionStorage.setItem('info-facturas', JSON.stringify(null));
                    verificarJSON();
                    pintarTablaCarrito(); 
                    obtenerDatosTabla();
                  }
                }
              });  
        }

    });//Clicks en botones

    $(document).on('change','#forma_de_pago',function(){
        if($(this).val() == "Credito"){
            $('.fechascredito').removeClass("d-none").addClass("d-block");
        }else{
            $('.fechascredito').removeClass("d-block").addClass("d-none");
        }
    });//Combobox on change

    function verificarJSON(){

        var carrito = sessionStorage.getItem('info-compras');
        var datos_facturacion = sessionStorage.getItem('info-facturas');
        console.log(datos_facturacion);
        var carrito = JSON.parse(carrito);
        if(datos_facturacion == null || datos_facturacion == "" || datos_facturacion == 'null'){
            if(carrito == null || carrito == "" || carrito == 'null'){
                $('#compras').show();
                $('#compra').hide();
            }else{
                $('#compras').hide();
                $('#compra').show();
            }
        }else{
            $('#compras').hide();
            $('#compra').show();
        }

    }

    function obtenerDatosCarrito(){
        var cont = 0;
        var cont2 = 0;
        var filas = "";
        var datostabla = [];
      
         $('#tabla_compra').find("tr").find(".datos").each(function() {
           if(cont == 8){
              filas+= $(this).html();
              datos = filas.split("?");
              datostabla[cont2] = datos;
              datos = [];
              cont = 0;
              filas = "";
              cont2++;
           }else{
            filas+= $(this).html()+"?";
            cont++;
           }
           
        });

        obtenerDatosFactura();
        sessionStorage.setItem('info-compras', JSON.stringify(datostabla));
        pintarTablaCarrito();
      }

      function obtenerDatosFactura(){
        var datos_factura = [$('#folio_factura').val(),$('#fecha_facturacion').val(),$('#fecha_vencimiento').val(),
        $('#codigo_proveedor').val(),$('#metodo_pago').val(),$('#descuento').val(),
        $('#forma_de_pago').val(),$('#inicio_de_credito').val(),$('#fecha_del_credito').val(),$('#anticipo').val()];

        sessionStorage.setItem('info-facturas', JSON.stringify(datos_factura));
      }

      function pintarTablaCarrito(){
        var carrito = sessionStorage.getItem('info-compras');
        var carrito = JSON.parse(carrito);
        console.log(carrito);
        var template = "";
        let subtotal_total = 0.0;
        let iva_total = 0.0;
        let ieps_total = 0.0;
        let total2 = 0.0;

        $.each(carrito, function (i, item) {
          template += `
        <tr>
          <td class="text-nowrap text-center"><button id='eliminar_producto' class='btn btn-danger' name=''>Eliminar</button></td>
          <td class="text-nowrap text-center numero datos">${item[0]}</td>
          <td class="text-nowrap text-center datos">${item[1]}</td>
          <td id="producto_costo" class="text-nowrap text-center datos">${item[2]}</td>
          <td id="producto_iva" class="text-nowrap text-center datos">${item[3]}</td>
          <td id="producto_ieps" class="text-nowrap text-center datos">${item[4]}</td>
          <td id="producto_cantidad" class="text-nowrap text-center datos">${item[5]}</td>
          <td id="producto_subtotal" class="text-nowrap text-center datos">${item[6]}</td>
          <td id="producto_unidad_medida" class="text-nowrap text-center datos">${item[7]}</td>
          <td id="producto_precio_venta" class="text-nowrap text-center datos">${item[8]}</td>
        </tr>
       `;
            costo2 = item[2].split('$');
            subtotal_total += (parseFloat(costo2[1])*parseFloat(item[5]));
            iva_producto2 = item[3].split('$'); 
            iva_total += parseFloat(iva_producto2[1]);
            ieps_producto2 = item[4].split('$');
            ieps_total += parseFloat(ieps_producto2[1]);
            subtotal_producto2 = item[6].split('$');
            total2 += parseFloat(subtotal_producto2[1]); 
        });
        
        $('#tabla_compra').html(template);
        $('#info_subtotal').html("$"+subtotal_total);
        $('#info_descuento').html("$" + $('#descuento').val());
        $('#info_iva').html("$"+iva_total);
        
        $('#info_ieps').html("$"+ieps_total);
        $('#info_anticipo').html("$" + $('#anticipo').val());
        $('#info_total').html("$"+total2);
        $('#info_total2').val(total2);
        $('#info_iva2').val(iva_total);
      }

      function datosFactura(){
        var datos_facturacion = sessionStorage.getItem('info-facturas');
        var factura = JSON.parse(datos_facturacion);
        console.log(factura);
        if(factura != null){
            $('#folio_factura').val(parseInt(factura[0]));
            $('#fecha_facturacion').val(factura[1]);
            $('#fecha_vencimiento').val(factura[2]);
            $('#codigo_proveedor').val(factura[3]);
            $('#metodo_pago').val(factura[4]);
            $('#descuento').val(factura[5]);
            $('#forma_de_pago').val(factura[6]);
            $('#inicio_de_credito').val(factura[7]);
            $('#fecha_del_credito').val(factura[8]);
            $('#anticipo').val(factura[9]); 
        }

      }

      function obtenerDatosTabla(){
        $.ajax({
            url: "../Controllers/compras.php",
            type: "POST",
            data:"tabla=tabla",
    
            success: function (response) {
                let datos = JSON.parse(response);
                console.log(datos);
                let template = '';
                $.each(datos, function (i, item) {
                    template += `<tr>`;
                    if(acceso == 'CEO'){
                        template += `<td class="text-nowrap text-center"><input type="checkbox" value="si"></td>`;
                    }
                    template += ` 
                    <td  class="text-nowrap text-center d-none datos">${item[0]}</td>
                    <td><button class="bconcepto btn btn-info">Mostrar</button></td>
                    <td  class="text-nowrap text-center">${item[1]}</td>
                    <td  class="text-nowrap text-center">${item[2]}</td>
                    <td  class="text-nowrap text-center">${item[3]}</td>
                    <td  class="text-nowrap text-center">${item[4]}</td>
                    <td  class="text-nowrap text-center">${item[5]}</td>
                    <td  class="text-nowrap text-center">${item[6]}</td>
                    <td  class="text-nowrap text-center">${item[7]}</td>
                    <td  class="text-nowrap text-center">${item[8]}</td>
                    <td  class="text-nowrap text-center">${item[9]}</td>
                    <td  class="text-nowrap text-center">${item[10]}</td>
                    <td  class="text-nowrap text-center">${item[11]}</td>
                    <td  class="text-nowrap text-center">${item[12]}</td>
                    <td  class="text-nowrap text-center">${item[13]}</td>
                    <td  class="text-nowrap text-center">${item[14]}</td>
                    <td  class="text-nowrap text-center datos">${item[15]}</td>
                </tr>`;
                });
                $('#cuerpo2').html(template);
            }
          });  
      }


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
                $('#codigo_proveedor').html(template);
            }
        });
      }

      function obtenerProductos(){
        $.ajax({
            url: "../Controllers/compras.php",
            type: "POST",
            data:"producto=producto",
      
            success: function (response) {
              let datos = JSON.parse(response);
              console.log(datos);
              let template = "";
              $.each(datos, function (i, item) {
                for(var j = 0; j <= item.length; j++){
                  if(item[j] == 'null'){
                    item[j] = "";
                  }
                }
                template+=`<option value="${item[0]}">${item[1]}</option>`;
              });
              $('#lproductos').html(template);
            }
          });
      }



    
});//Document ready