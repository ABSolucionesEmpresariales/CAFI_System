$(document).ready(function () {
  let pago;
  let cambio;
  let descuento = 0.0;
  let anticipo = 0.0;
  let forma_pago;
  let totalglobal = 0.0;
  let codigo;
  let cantidad;
  filtradoProductos();
  optenerDatosTabla(0);
  //cerrar el modal
  $(document).on('click', '.close', function () {
    optenerDatosTabla(0);
    //hacer la suma de los subtotales para la variable global total
  });


  //terminar la venta
  $(document).on('click', '.bvender', function () {
    //pago efectivo
    if ($('.tpago').val().length > 0 && $('.tanticipo').val().length < 1 && forma_pago === "Efectivo" && totalglobal>0) {
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
            } else {
              $('.tpago').val("");
            }

            const postData = {
              total: totalglobal,
              pago: pago,
              cambio: cambio,
              descuento: descuento,
              formapago: forma_pago
            };
            $.post('post-guardar.php', postData, function (response) {
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
                        location.reload();
                      }
                    });
                };
                setTimeout(explode, 200);
              }
            });
          });
      }
      //pago a credito
    } else if ($('.tpago').val().length > 0 && $('.tanticipo').val().length > 0 && forma_pago === "Crédito" && totalglobal>0) {
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
              const postData = {
                total: totalglobal,
                pago: pago,
                cambio: cambio,
                totaldeuda: totalglobal - anticipo,
                anticipo: anticipo,
                descuento: descuento,
                formapago: forma_pago
              };
              $.post('post-guardar.php', postData, function (response) {
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
                          location.reload();
                        }
                      });
                  };
                  setTimeout(explode, 200);
                }
              });

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

    } else if ($('.tpago').val().length < 1 && $('.tanticipo').val().length < 1 && forma_pago === "Tarjeta" && totalglobal>0) {
      //pago con tarjeta
      if (totalglobal) {
        const postData = {
          total: totalglobal,
          descuento: descuento,
          formapago: forma_pago
        };
        $.post('post-guardar.php', postData, function (response) {
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
                    location.reload();
                  }
                });
            };
            setTimeout(explode, 200);
          }
        });

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


  //boton delete concepto venta
  $(document).on('click', '.bdelete', function () {
    let element = $(this)[0].parentElement.parentElement;
    const codigo = $(element).attr('codigoBa');
    const postData = {
      codigo: codigo
    };
    $.post('post-delete.php', postData, function (response) {
      if (response === "1") {

      } else {
        swal({
          title: 'Alerta',
          text: 'No eliminado',
          type: 'warning'
        });
      }

    });
    optenerDatosTabla(0);

  });

  function optenerDatosTabla(total) {
    $.ajax({
      url: 'tabladetalleventa.php',
      type: 'GET',
      success: function (response) {
        let datos = JSON.parse(response);
        let template = '';
        datos.forEach(datos => {
          sbtotal = parseFloat(datos.subtotal);
          total += sbtotal;
          template += `
                  <tr codigoBa="${datos.codigo}">
                  <td class="text-nowrap text-center"><button class="bdelete btn btn-danger">x</button></td>
                  <td class="text-nowrap text-center d-none">${datos.codigo}</td>
                  <td>${datos.nombre} ${datos.marca} ${datos.color} talla ${datos.talla_numero} um ${datos.unidad_medida}</td>
                  <td class="tdcosto text-nowrap text-center">${datos.precio}</td>
                  <td class="text-nowrap text-center">${datos.cantidad}</td>
                  <td class="text-nowrap text-center">${datos.subtotal}</td>
              </tr>`;
        });
        $('#renglones').html(template);
        totalglobal = total;
        template = `
              <h5>Total: $${total}</h5>`;
        $('#divtotal').html(template);
      }

    })
  }

  function filtradoProductos() {
      let search = $('#busquedap').val();
      $.ajax({
        url: '../Controllers/ventas.php',
        type: 'POST',
        data: { search },
        success: function (response) {
          let datos = JSON.parse(response);
          let template = '';
          $.each(datos, function (i, item) {
          
          for(i=0; i < item.length; i++){
            if(item[i] === null){
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
                        <td><input class='incan' type="number" value="1" name="quantity" min="1" max="" style="width: 60px; height: 38px;"></td>
                        <td>${item[7]}</td>
                        <td>${item[2]} ${item[3]} ${item[6]} </td>
                        <td class="datos">${item[8]}</td>
                        <td class="datos font-weight-bold">${item[0]}</td>
                        <td>${item[5]}</td>
                        <td>${item[4]}</td>
                        <td class="datos">${item[9]}</td>
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
      let search = $('#busquedac').val();
      $.ajax({
        url: 'bcliente.php',
        type: 'POST',
        data: { search },
        success: function (response) {
          let datos = JSON.parse(response);
          let template = '';
          datos.forEach(datos => {
            template += `<tr>
                        <td> <button class="text-nowrap text-center bagregarc btn bg-secondary text-white">ok</button></td>
                        <td class="text-nowrap text-center datoscliente d-none">${datos.idcliente}</td>
                        <td class="text-center datoscliente">${datos.nombre}</td>
                        <td class="text-nowrap text-center">${datos.telefono}</td>
                        <td class="text-nowrap text-center datoscliente">${datos.estado}</td>
                        <td class="text-nowrap text-center">${datos.adeudos}</td>
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
    const postData = {
      idcliente: renglon[0],
      estcliente: renglon[2]
    };

    $.post('post-guardar.php', postData, function (response) {

      if (response === "no agregado a la sesion") {
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


  });

  //boton agregar al concepto venta
  $(document).on('click', '.bagregardv', function () {
    var valores = "";
    let cantidad = $(this).parents("tr").find('.incan').val();
    $(this).parents("tr").find(".datos").each(function () {
      valores += $(this).html() + "?";
    });
    valores += cantidad;
    result = valores.split("?");

    const postData = {
      codigo: result[0],
      existencia: result[1],
      precio: result[2],
      cantidad: result[3]
    };

    $.post('post-guardar.php', postData, function (response) {
      optenerDatosTabla(0);

      if (response === "-1") {
        swal({
          title: 'Alerta',
          text: 'Producto agregado, por favor intente de nuevo',
          type: 'warning'
        });
      } else if (response === "stock") {
        swal({
          title: 'Alerta',
          text: 'Compruebe el stock del producto',
          type: 'warning'
        });
      }

    });
  });

});