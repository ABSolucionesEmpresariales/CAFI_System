$(document).ready(function () {
  let pago = 0.0;
  let cambio = 0.0;
  let descuento = 0.0;  
  let anticipo = 0.0;
  let forma_pago;
  let totalglobal = 0.0;
  let cliente = "";
  filtradoProductos();
  pintarTablaCarrito();
  //cerrar el modal
  $(document).on('click', '.close', function () {
    pintarTablaCarrito();
    //hacer la suma de los subtotales para la variable global total
  });
function mandarporPost(){
  const postData = {
    idventa: "",
    descuento: descuento,
    total: totalglobal,
    pago: pago,
    cambio: cambio,
    forma_pago: forma_pago,
    json_string: convertirJsonCarritoenArray(),
    idadeudo: "",
    totaldeuda: totalglobal-anticipo,
    anticipo: anticipo,
    cliente: cliente
  
  };
  $.post('../Controllers/ventas.php', postData, function (response) {
    console.log(response);
    if (response === "Exitoprinter") {
        window.open('ticketVenta.php');
    }
    if (response) {
      var explode = function () {
        swal({
          title: 'Exito',
          text: 'Venta realizada exitosamente',
          type: 'success'
        },
          function (isConfirm) {
            if (isConfirm) {
              sessionStorage.setItem('info', JSON.stringify(""));
              location.reload();
            }
          });
      };
      setTimeout(explode, 200);
    } else {
      var explode = function () {
        swal({
          title: 'Alerta',
          text: 'Venta no realizada',
          type: 'warning'
        },
          function (isConfirm) {
            if (isConfirm) {
              sessionStorage.setItem('info', JSON.stringify(""));
              location.reload();
            }
          });
      };
      setTimeout(explode, 200);
    }
  });
}
function convertirJsonCarritoenArray(){
  var carrito = sessionStorage.getItem('info');
  var carrito = JSON.parse(carrito);
   for(i=0; i< carrito.length; i++){
    for(j=0; j<carrito[i].length; j++){
      if(j === 1){
       carrito[i].splice(j,2);
      }
    }
  } 

  return JSON.stringify(carrito);
  
}

  //terminar la venta
  $(document).on('click', '.bvender', function () {
    if ($('.tpago').val().length > 0 && $('.tanticipo').val().length < 1 && forma_pago === "Efectivo" && totalglobal > 0) {
      valor = $('.tpago').val();
      pago = valor = parseFloat(valor);
      if (valor < totalglobal) {
        swal({
          title: 'Alerta',
          text: 'Ingrese una cantidad mayor o igual al total de la venta',
          type: 'warning'
        });
      } else {
        cambio = valor - totalglobal;
        camiostring = cambio.toString();
        swal({
          title: 'Su cambio es de $' + camiostring,
          text: 'Confirme la venta',
          imageUrl: 'img/cambio.png',
          showCancelButton: true,
          confirmButtonClass: 'btn-success',
          confirmButtonText: 'Ok',
          cancelButtonClass: 'btn-danger',
          cancelButtonText: 'Cancelar',
          closeOnConfirm: true,
          closeOnCancel: true
        },
          function (isConfirm) {
            if (isConfirm) {
              $('.tpago').val("");
              mandarporPost();
            } else {
              $('.tpago').val("");
            }
           
          });
      }
      //pago a credito
    } else if ($('.tpago').val().length > 0 && $('.tanticipo').val().length > 0 && forma_pago === "Crédito" && totalglobal > 0) {
      valor = $('.tpago').val();
      pago = valor = parseFloat(valor);
      anticipo = parseFloat($('.tanticipo').val());
      if (pago >= anticipo) {
        cambio = pago - anticipo;
        camiostring = cambio.toString();
        swal({
          title: 'Su cambio es de $' + camiostring,
          text: 'Confirme la venta',
          imageUrl: 'img/cambio.png',
          showCancelButton: true,
          confirmButtonClass: 'btn-success',
          confirmButtonText: 'Ok',
          cancelButtonClass: 'btn-danger',
          cancelButtonText: 'Cancelar',
          closeOnConfirm: true,
          closeOnCancel: true
        },
          function (isConfirm) {
            if (isConfirm) {
              $('.tpago').val("");
              $('.tanticipo').val("");
              mandarporPost();
            } else {
              $('.tpago').val("");
              $('.tanticipo').val("");
            }

          });
      } else {
        swal({
          title: 'Alerta',
          text: 'Ingrese pago mayor o igual al anticipo',
          type: 'warning'
        });
      }

    } else if ($('.tpago').val().length < 1 && $('.tanticipo').val().length < 1 && forma_pago === "Tarjeta" && totalglobal > 0) {
      //pago con tarjeta
      if (totalglobal) {
        mandarporPost();
      }
    } 
  });

  //boton descuento en pesos
  $(document).on('click', '.bpesos', function () {
    if ($('.indescuento').val()) {
      totalventa = totalglobal;
      valor = $('.indescuento').val();
      descuento = valor = parseFloat(valor);
      totalventa = totalventa - valor;
      stringtotal = totalventa.toString();

      swal({
        title: 'El nuevo total es de $' + stringtotal,
        text: 'Si está de acuerdo confirme el descuento',
        type: 'success',
        showCancelButton: true,
        confirmButtonClass: 'btn-success',
        confirmButtonText: 'Ok',
        cancelButtonClass: 'btn-danger',
        cancelButtonText: 'Cancelar',
        closeOnConfirm: true,
        closeOnCancel: true
      },
        function (isConfirm) {
          if (isConfirm) {
            let menseaje = "Total: $" + stringtotal;
            $('.hmtotal').html(menseaje);
            $('.indescuento').val("");
            $('#divdescuento').hide();
            totalglobal = totalventa;
            $('.bdescuento').hide();


          } else {
            $('.indescuento').val("");
          }
        });

    }
  });

  //boton descuento en porcentaje
  $(document).on('click', '.bporcentaje', function () {
    if ($('.indescuento').val()) {
      totalventa = totalglobal;
      valor = $('.indescuento').val();
      valor = parseFloat(valor);
      descuento = totalventa * valor;
      descuento = descuento / 100;
      totalventa = descuento;
      totalventa = totalglobal - totalventa;
      stringtotal = totalventa.toString();


      swal({
        title: 'El nuevo total es de $' + stringtotal,
        text: 'Si está de acuerdo confirme el descuento',
        type: 'success',
        showCancelButton: true,
        confirmButtonClass: 'btn-success',
        confirmButtonText: 'Ok',
        cancelButtonClass: 'btn-danger',
        cancelButtonText: 'Cancelar',
        closeOnConfirm: true,
        closeOnCancel: true
      },
        function (isConfirm) {
          if (isConfirm) {
            let menseaje = "Total: $" + stringtotal;
            $('.hmtotal').html(menseaje);
            $('.indescuento').val("");
            $('#divdescuento').hide();
            totalglobal = totalventa;
            $('.bdescuento').hide();


          } else {
            $('.indescuento').val("");
          }
        });

    }
  });

  //boton aplicar descuento
  $(document).on('click', '.bdescuento', function () {
    $('#divdescuento').show();
  });

  //boton pago en efectivo
  $(document).on('click', '.bpago1', function () {
    forma_pago = $('.bpago1').val();
    $('.divpagotarjeta').hide();
    $('#divdescuento').hide();
    $('#divanticipo').hide();
    $('#tablacliente').hide();
    $('.bdescuento').show();
    $('#divpago').show();
    $('.modal').modal('show');

    stringtotal = totalglobal.toString();
    let menseaje = "Total: $" + stringtotal;
    $('.hmtotal').html(menseaje);
  });

  //boton pago a credito
  $(document).on('click', '.bpago2', function () {
    forma_pago = $('.bpago2').val();
    $('.divpagotarjeta').hide();
    $('#divdescuento').hide();
    $('#divanticipo').hide();
    $('#divpago').hide();
    $('#tablacliente').show();
    $('.bdescuento').show();
    $('#tablacliente').show();
    $('.modal').modal('show');

    stringtotal = totalglobal.toString();
    let menseaje = "Total: $" + stringtotal;
    $('.hmtotal').html(menseaje);
  });

  //boton pago con targeta
  $(document).on('click', '.bpago3', function () {
    forma_pago = $('.bpago3').val();
    $('#divdescuento').hide();
    $('#divanticipo').hide();
    $('#divpago').hide();
    $('#tablacliente').show();
    $('.bdescuento').show();
    $('#tablacliente').hide();
    $('.divpagotarjeta').show();
    $('.modal').modal('show');

    stringtotal = totalglobal.toString();
    let menseaje = "Total: $" + stringtotal;
    $('.hmtotal').html(menseaje);
  });

  function filtradoProductos() {
    let searchproducto = $('#busquedap').val();
    $.ajax({
      url: '../Controllers/ventas.php',
      type: 'POST',
      data: { searchproducto },
      success: function (response) {
        let datos = JSON.parse(response);
        let template = '';
        $.each(datos, function (i, item) {

          for (i = 0; i < item.length; i++) {
            if (item[i] === null) {
              item[i] = "";
            }
          }
          template += `<tr>
                          <td> 
                             <div class="row">
                                <a class="bagregardv btn btn-secondary ml-1" href="#">
                                   <img src="../img/carrito.png">
                                </a>
                              </div>
                           </td>
                           <td><img src="${item[1]}" height="50" width="50" /></td>
                           <td><input id='incantidad' type="number" value="1" name="quantity" min="1" max="" style="width: 60px; height: 38px;"></td>
                           <td class="datos">${item[2]} ${item[3]} ${item[6]} </td>
                           <td class="datos font-weight-bold">${item[0]}</td>
                           <td>${item[9]}</td>
                           <td class="datos">${item[8]}</td>
                        </tr>`;
        });
        datos = "";
        $('#cuerpo').html(template);

      }
    });

  }

  //filtrado tabla productos
  $('#busquedap').keyup(function (e) {

    filtradoProductos();
  });

  //filtrado tabla clientes
  $('#busquedac').keyup(function (e) {
    if ($('#busquedac').val()) {
      let searchcliente = $('#busquedac').val();
      $.ajax({
        url: '../Controllers/ventas.php',
        type: 'POST',
        data: { searchcliente },
        success: function (response) {
          let datos = JSON.parse(response);
          let template = '';
          $.each(datos, function (i, item) {
            template += `<tr>
                        <td> <button class="text-nowrap text-center bagregarc btn bg-secondary text-white">ok</button></td>
                        <td class="text-nowrap text-center datoscliente">${item[0]}</td>
                        <td class="text-center datoscliente">${item[1]}</td>
                        <td class="text-nowrap text-center">${item[6]}</td>
                        <td class="text-nowrap text-center datoscliente">${item[8]}</td>
                        <td class="text-nowrap text-center">${item[9]}</td>
                      
                        </tr>`;
          });
          $('#cuerpotcliente').html(template);

        }
      });
    } else {
      let template = '';
      $('#cuerpotcliente').html(template);
    }

  });

  //boton agregar cliente al crédito
  $(document).on('click', '.bagregarc', function () {
    let valores = "";
    $(this).parents("tr").find(".datoscliente").each(function () {
      valores += $(this).html() + "?";
    });
    renglon = valores.split("?");

    cliente = renglon[0];
    let estcliente = renglon[2];
      if (estcliente != "A") {
        swal({
          title: 'Alerta',
          text: 'No se puede agregar un cliente inactivo',
          type: 'warning'
        });
      } else {
        titulo = $('.hmtotal').html();
        $('.hmtotal').html(titulo + " cargado a " + renglon[1]);
        $('#tablacliente').hide();
        $('#divanticipo').show();
        $('#divpago').show();
      }
 


  });


$(document).on('click','.beliminar',function(){
 var objeto = $(this).parents("tr");
  $(this).parents("tr").remove();
  obtenerDatosCarrito();
});
   
  //boton agregar al concepto venta
  $(document).on('click', '.bagregardv', function () {
    let encontrado = false;
    let cantidadinput = $(this).parents("tr").find('#incantidad').val();
    var valores = "";
    let val = "";

    $(this).parents("tr").find(".datos").each(function () {
      valores += $(this).html() + "?";
    });
    
    valores += cantidadinput;
    result = valores.split("?");

    $('#tbcarrito').find("#" + result[1]).find("td").each(function () {
      encontrado = true;
      val += $(this).html() + "?";
    });
    row = val.split("?");
     
    
    let costo = parseFloat(result[2]);
    let cantidad = parseInt(result[3]);
    let subtotal = cantidad * costo;

  if(encontrado === false){

    template = `<tr id="${result[1]}">
    <td><button class="beliminar btn btn-danger">Eliminar</button></td>
    <td class="datos d-none">${result[1]}</td>
    <td class="datos">${result[0]}</td>
    <td class="datos">${result[2]}</td>
    <td class="datos">${cantidad}</td>
    <td class="datos">${subtotal}</td>
 </tr>`;

  }else{
    $('#tbcarrito').find("#" + result[1]).remove();
    cantidad += parseInt(row[4]);
    subtotal = cantidad * costo;
    template = `<tr id="${result[1]}">
    <td><button class="beliminar btn btn-danger">Eliminar</button></td>
    <td class="datos d-none">${result[1]}</td>
    <td class="datos">${result[0]}</td>
    <td class="datos">${result[2]}</td>
    <td class="datos">${cantidad}</td>
    <td class="datos">${subtotal}</td>
 </tr>`;
  }

  $('#tbcarrito').append(template);
    obtenerDatosCarrito();
  });

  function obtenerDatosCarrito(){
    var cont = 0;
    var cont2 = 0;
    var filas = "";
    var datostabla = [];
  
     $('#tbcarrito').find("tr").find(".datos").each(function() {
       if(cont == 4){
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
    sessionStorage.setItem('info', JSON.stringify(datostabla));
    pintarTablaCarrito();
  }

  function pintarTablaCarrito(){
    var carrito = sessionStorage.getItem('info');
    var carrito = JSON.parse(carrito);
    console.log(carrito);
    var template = "";
    totalglobal = 0.0;
    $.each(carrito, function (i, item) {
      totalglobal +=  parseInt(item[4]);
      template += `<tr id="${item[0]}">
      <td><button class="beliminar btn btn-danger">Eliminar</button></td>
      <td class="datos d-none">${item[0]}</td>
      <td class="datos">${item[1]}</td>
      <td class="datos">${item[2]}</td>
      <td class="datos">${item[3]}</td>
      <td class="datos">${item[4]}</td>
   </tr>`;
    });
    $('#tbcarrito').html(template);
    $('.totalcarrito').html("Total: $"+totalglobal);
  }
});