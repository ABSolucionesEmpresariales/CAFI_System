$(document).ready(function () {
  let pago = 0.0;
  let cambio = 0.0;
  let descuento = 0.0;
  let anticipo = 0.0;
  let forma_pago;
  let totalglobal = 0.0;
  let cliente = "";
  optenerProductos();
  pintarTablaCarrito();
  //cerrar el modal
  $(document).on("click", ".close", function () {
    pintarTablaCarrito();
    //hacer la suma de los subtotales para la variable global total
  });
  function mandarporPost() {
    var carrito = sessionStorage.getItem("info");
    var carrito = JSON.parse(carrito);
    const postData = {
      idventa: "",
      descuento: descuento,
      total: totalglobal,
      pago: pago,
      cambio: cambio,
      forma_pago: forma_pago,
      json_string: JSON.stringify(carrito),
      idadeudo: "",
      totaldeuda: totalglobal - anticipo,
      anticipo: anticipo,
      cliente: cliente
    };
    $.post("../Controllers/ventas.php", postData, function (response) {
      console.log(response);
      if (response === "Exitoprinter") {
        window.open("ticketventa.php");
      }
      if (response) {
        var explode = function () {
          swal(
            {
              title: "Exito",
              text: "Venta realizada exitosamente",
              type: "success"
            },
            function (isConfirm) {
              if (isConfirm) {
                sessionStorage.setItem("info", JSON.stringify(""));
                location.reload();
              }
            }
          );
        };
        setTimeout(explode, 200);
      } else {
        var explode = function () {
          swal(
            {
              title: "Alerta",
              text: "Venta no realizada",
              type: "warning"
            },
            function (isConfirm) {
              if (isConfirm) {
                sessionStorage.setItem("info", JSON.stringify(""));
                location.reload();
              }
            }
          );
        };
        setTimeout(explode, 200);
      }
    });
  }

/*   function convertirJsonCarritoenArray() {
    var carrito = sessionStorage.getItem("info");
    var carrito = JSON.parse(carrito);
    for (i = 0; i < carrito.length; i++) {
      for (j = 0; j < carrito[i].length; j++) {
        if (j === 1) {
          carrito[i].splice(j, 2);
        }
      }
    }
    return JSON.stringify(carrito);
  } */

  //terminar la venta
  $(document).on("click", ".bvender", function () {
    if (
      $(".tpago").val().length > 0 &&
      $(".tanticipo").val().length < 1 &&
      forma_pago === "Efectivo" &&
      totalglobal > 0
    ) {
      valor = $(".tpago").val();
      pago = valor = parseFloat(valor);
      if (valor < totalglobal) {
        swal({
          title: "Alerta",
          text: "Ingrese una cantidad mayor o igual al total de la venta",
          type: "warning"
        });
      } else {
        cambio = pago - totalglobal;
        cambio = cambio.toFixed(2);
        camiostring = cambio.toString();
        swal(
          {
            title: "Su cambio es de $" + camiostring,
            text: "Confirme la venta",
            imageUrl: "img/cambio.png",
            showCancelButton: true,
            confirmButtonClass: "btn-success",
            confirmButtonText: "Ok",
            cancelButtonClass: "btn-danger",
            cancelButtonText: "Cancelar",
            closeOnConfirm: true,
            closeOnCancel: true
          },
          function (isConfirm) {
            if (isConfirm) {
              $(".tpago").val("");
              mandarporPost();
            } else {
              $(".tpago").val("");
            }
          }
        );
      }
      //pago a credito
    } else if (
      $(".tpago").val().length > 0 &&
      $(".tanticipo").val().length > 0 &&
      forma_pago === "Crédito" &&
      totalglobal > 0
    ) {
      valor = $(".tpago").val();
      pago = valor = parseFloat(valor);
      anticipo = parseFloat($(".tanticipo").val());
      if (pago >= anticipo && anticipo < totalglobal) {
        cambio = pago - anticipo;
        cambio = cambio.toFixed(2);
        camiostring = cambio.toString();
        swal(
          {
            title: "Su cambio es de $" + camiostring,
            text: "Confirme la venta",
            imageUrl: "img/cambio.png",
            showCancelButton: true,
            confirmButtonClass: "btn-success",
            confirmButtonText: "Ok",
            cancelButtonClass: "btn-danger",
            cancelButtonText: "Cancelar",
            closeOnConfirm: true,
            closeOnCancel: true
          },
          function (isConfirm) {
            if (isConfirm) {
              $(".tpago").val("");
              $(".tanticipo").val("");
              mandarporPost();
            } else {
              $(".tpago").val("");
              $(".tanticipo").val("");
            }
          }
        );
      } else {
        swal({
          title: "Alerta",
          text:
            "Puede que el pago que recibe sea menor que el anticipo , o que el anticipo ingresado sea mayor que el total de la venta",
          type: "warning"
        });
      }
    } else if (
      $(".tpago").val().length < 1 &&
      $(".tanticipo").val().length < 1 &&
      forma_pago === "Tarjeta" &&
      totalglobal > 0
    ) {
      //pago con tarjeta
      if (totalglobal) {
        mandarporPost();
      }
    }
  });

  $("#busquedap").keydown(function (event) {
    if (event.which === 13) {
      agregarProducto();
      $("#busquedap").val("");
    } else if (event.which === 8) {
      $("#busquedap").val("");
    }
  });

  $(document).on("change", ".tcantidad", function () {
    let cantidad = $(this).val();
    let costo;
    let subtotal;
    $(this)
      .parents("tr")
      .find(".precios")
      .each(function () {
        costo = $(this).html().split("$");
      });
    subtotal = costo[1] * cantidad;
    $(this).parents("tr").find("td").eq(5).html("$" + subtotal);
    console.log(subtotal);
    obtenerDatosCarrito();
    

  });




  function agregarProducto() {
    if ($("#busquedap").val().length > 10) {
      const postData = {
        codigobarrasproducto: $("#busquedap").val()
      };
      $.post("../Controllers/ventas.php", postData, function (response) {
        let result = JSON.parse(response);
        console.log(result);
        $.each(result, function (i, item) {
          for (i = 0; i < item.length; i++) {
            if (item[i] == null || item[i] == "null") {
              item[i] = "";
            }
          }
          if (item[4] === "") {
            talla = "";
          } else {
            talla = "T:";
          }
        });

        encontrado = "";
        val = "";
        $("#tbcarrito")
          .find("#" + result[0][0])
          .find("td").find("input")
          .each(function () {
            encontrado = true;
            //Esto suma el valor que ya existe con el nuevo This valor + 1
            $(this).val(parseInt($(this).val()) + 1).trigger("change") + "?";
          });
        
        if (encontrado != true) {
          template = `
          <tr id= "${result[0][0]}" >
            <td class="datos text-center">${result[0][0]}</td>
            <td class="datos text-center">${result[0][1]} ${result[0][2]} ${result[0][3]} ${talla} ${result[0][4]}</td>
            <td class="datos precios text-center">$${result[0][6]}</td>
            <td class="datos text-center">$${result[0][7]}</td>
            <td class="datos text-center"><input class="tcantidad" type="number" min = "1" value="1"></td>
            <td class="datos text-center">$${result[0][6]}</td>
            <td><button class="beliminar btn btn-danger">Eliminar</button></td>
         </tr>`;
          $("#tbcarrito").append(template);
        }
        obtenerDatosCarrito();
        
      });
    }
  }

  //optener la informacion del producto seleccionado
  $(document).on("change", "#busquedap", function () {
    agregarProducto();
  });

  //boton descuento en pesos
  $(document).on("click", ".bpesos", function () {
    if ($(".indescuento").val()) {
      totalventa = totalglobal;
      valor = $(".indescuento").val();
      descuento = valor = parseFloat(valor);
      totalventa = totalventa - valor;
      totalventa = totalventa.toFixed(2);
      stringtotal = totalventa.toString();

      swal(
        {
          title: "El nuevo total es de $" + stringtotal,
          text: "Si está de acuerdo confirme el descuento",
          type: "success",
          showCancelButton: true,
          confirmButtonClass: "btn-success",
          confirmButtonText: "Ok",
          cancelButtonClass: "btn-danger",
          cancelButtonText: "Cancelar",
          closeOnConfirm: true,
          closeOnCancel: true
        },
        function (isConfirm) {
          if (isConfirm) {
            let menseaje = "Total: $" + stringtotal;
            $(".hmtotal").html(menseaje);
            $(".indescuento").val("");
            $("#divdescuento").hide();
            totalglobal = totalventa;
            $(".bdescuento").hide();
          } else {
            $(".indescuento").val("");
          }
        }
      );
    }
  });

  //boton descuento en porcentaje
  $(document).on("click", ".bporcentaje", function () {
    if ($(".indescuento").val()) {
      totalventa = totalglobal;
      valor = $(".indescuento").val();
      valor = parseFloat(valor);
      descuento = totalventa * valor;
      descuento = descuento / 100;
      totalventa = descuento;
      totalventa = totalglobal - totalventa;
      totalventa = totalventa.toFixed(2);
      stringtotal = totalventa.toString();

      swal(
        {
          title: "El nuevo total es de $" + stringtotal,
          text: "Si está de acuerdo confirme el descuento",
          type: "success",
          showCancelButton: true,
          confirmButtonClass: "btn-success",
          confirmButtonText: "Ok",
          cancelButtonClass: "btn-danger",
          cancelButtonText: "Cancelar",
          closeOnConfirm: true,
          closeOnCancel: true
        },
        function (isConfirm) {
          if (isConfirm) {
            let menseaje = "Total: $" + stringtotal;
            $(".hmtotal").html(menseaje);
            $(".indescuento").val("");
            $("#divdescuento").hide();
            totalglobal = totalventa;
            $(".bdescuento").hide();
          } else {
            $(".indescuento").val("");
          }
        }
      );
    }
  });

  //boton aplicar descuento
  $(document).on("click", ".bdescuento", function () {
    $("#divdescuento").show();
  });

  //boton pago en efectivo
  $(document).on("click", ".bpago1", function () {
    forma_pago = $(".bpago1").val();
    $(".divpagotarjeta").hide();
    $("#divdescuento").hide();
    $("#divanticipo").hide();
    $("#tablacliente").hide();
    $(".bdescuento").show();
    $("#divpago").show();
    $(".modal").modal("show");

    stringtotal = totalglobal.toString();
    let menseaje = "Total: $" + stringtotal;
    $(".hmtotal").html(menseaje);
  });

  //boton pago a credito
  $(document).on("click", ".bpago2", function () {
    forma_pago = $(".bpago2").val();
    $(".divpagotarjeta").hide();
    $("#divdescuento").hide();
    $("#divanticipo").hide();
    $("#divpago").hide();
    $("#tablacliente").show();
    $(".bdescuento").show();
    $("#tablacliente").show();
    $(".modal").modal("show");

    stringtotal = totalglobal.toString();
    let menseaje = "Total: $" + stringtotal;
    $(".hmtotal").html(menseaje);
  });

  //boton pago con targeta
  $(document).on("click", ".bpago3", function () {
    forma_pago = $(".bpago3").val();
    $("#divdescuento").hide();
    $("#divanticipo").hide();
    $("#divpago").hide();
    $("#tablacliente").show();
    $(".bdescuento").show();
    $("#tablacliente").hide();
    $(".divpagotarjeta").show();
    $(".modal").modal("show");

    stringtotal = totalglobal.toString();
    let menseaje = "Total: $" + stringtotal;
    $(".hmtotal").html(menseaje);
  });

  // llenar el datalist de los productos exitentes en el negocio
  function optenerProductos() {
    let talla;
    $.ajax({
      url: "../Controllers/ventas.php",
      type: "POST",
      data: "combo=combo",
      success: function (response) {
        let datos = JSON.parse(response);
        let template = "";
        $.each(datos, function (i, item) {
          for (i = 0; i < item.length; i++) {
            if (item[i] == null || item[i] == "null") {
              item[i] = "";
            }
          }
          if (item[4] === "") {
            talla = "";
          } else {
            talla = "T:";
          }
          template += `
          <option value="${item[0]}">${item[1]} ${item[2]} ${item[3]} ${talla} ${item[4]} $${item[6]}</option>`;
        });
        datos = "";
        $("#productos").html(template);
      }
    });
  }

  //filtrado tabla clientes
  $("#busquedac").keyup(function (e) {
    if ($("#busquedac").val()) {
      let searchcliente = $("#busquedac").val();
      $.ajax({
        url: "../Controllers/ventas.php",
        type: "POST",
        data: { searchcliente },
        success: function (response) {
          let datos = JSON.parse(response);
          let template = "";
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
          $("#cuerpotcliente").html(template);
        }
      });
    } else {
      let template = "";
      $("#cuerpotcliente").html(template);
    }
  });

  //boton agregar cliente al crédito
  $(document).on("click", ".bagregarc", function () {
    let valores = "";
    $(this)
      .parents("tr")
      .find(".datoscliente")
      .each(function () {
        valores += $(this).html() + "?";
      });
    renglon = valores.split("?");

    cliente = renglon[0];
    let estcliente = renglon[2];
    if (estcliente != "A") {
      swal({
        title: "Alerta",
        text: "No se puede agregar un cliente inactivo",
        type: "warning"
      });
    } else {
      titulo = $(".hmtotal").html();
      $(".hmtotal").html(titulo + " cargado a " + renglon[1]);
      $("#tablacliente").hide();
      $("#divanticipo").show();
      $("#divpago").show();
    }
  });

  $(document).on("click", ".beliminar", function () {
    var objeto = $(this).parents("tr");
    $(this)
      .parents("tr")
      .remove();
    obtenerDatosCarrito();
  });

  function obtenerDatosCarrito() {
    var cont = 0;
    var cont2 = 0;
    var filas = "";
    var datostabla = [];
    $("#tbcarrito").find("tr").find(".datos").each(function () {
        if(cont == 5) {
          filas += $(this).html();
          datos = filas.split("?");
          datostabla[cont2] = datos;
          datos = [];
          cont = 0;
          filas = "";
          cont2++;
        }else if(cont == 4){
          $(this).find("input").each(function (){
            filas += $(this).val() + "?";
            cont++;
          });
        }else{
          filas += $(this).html() + "?";
          cont++;
        }
      });
      console.log(datostabla);
      sessionStorage.setItem("info", JSON.stringify(datostabla));
      pintarTablaCarrito();
  }

  $('#cp').keyup(function (e) {
    let codigopostal = $('#cp').val();
    if (codigopostal.length === 5) {
      fetch('https://api-codigos-postales.herokuapp.com/v2/codigo_postal/' + codigopostal)
        .then(res => res.json())
        .then(data => {
          let template = '';
          for (i = 0; i < data.colonias.length; i++) {
            template += ` <option value="${data.colonias[i]}">`;
          }
          $("#localidad").html(template);
          $("#municipio").val(data.municipio);
          $("#estado").val(data.estado);

        });
    } else {
      $("#localidad").empty();
      $("#Tlocalidad").val('');
      $("#municipio").val('');
      $("#estado").val('');
    }

  });

  $('#formularioCliente').submit(function (e) {
    editar = "false";
    $.ajax({
      url: "../Controllers/clientes.php",
      type: "POST",
      data: $('#formularioCliente').serialize() + "&accion=" + editar,

      success: function (response) {
        console.log(response);
        $("#mensaje3").css("display", "block");
        if (response == "1") {
          $("#mensaje3").text("Registro Exitoso");
          $("#mensaje3").css("color", "green");
          $("#email").focus();
          $("#formularioCliente").trigger("reset");
        } else {
          $("#mensaje3").text("Registro fallido");
          $("#mensaje3").css("color", "red");
          $("#email").focus();
        }
      }
    });
      e.preventDefault();
  });

  function pintarTablaCarrito() {
    var carrito = sessionStorage.getItem("info");
    var carrito = JSON.parse(carrito);
    console.log(carrito);
    var template = "";
    totalglobal = 0.0;
    $.each(carrito, function (i, item) {
      total_split = item[5].split("$");
      totalglobal += parseFloat(total_split[1]);
      template += `
      <tr id= "${item[0]}" >
            <td class="datos text-center">${item[0]}</td>
            <td class="datos text-center">${item[1]}</td>
            <td class="datos precios text-center">${item[2]}</td>
            <td class="datos text-center">${item[3]}</td>
            <td class="datos text-center"><input class="tcantidad" type="number" min = "1" value="${item[4]}"></td>
            <td class="datos text-center">${item[5]}</td>
            <td><button class="beliminar btn btn-danger">Eliminar</button></td>
         </tr>`;
    });
    totalglobal = totalglobal.toFixed(2);
    $("#tbcarrito").html(template);
    $(".totalcarrito").html("Total: $" + totalglobal);
  }
});
