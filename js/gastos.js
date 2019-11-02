$(document).ready(function() {
  //Vgastos
  let editar = false;
  let idgastos = "";
  obtenerDatosTablaGastos();
  $(".agregar").click(function() {
    $(".ocultar").show();
    $("#mensaje").css("display", "none");
  });
  $(".close").click(function() {
    $("#formulario").trigger("reset");
  });

  function obtenerDatosTablaGastos() {
    $.ajax({
      url: "../Controllers/gastos.php",
      type: "POST",
      data: "tabla=tabla",

      success: function(response) {
        let datos = JSON.parse(response);

        let template = null;
        $.each(datos, function(i, item) {
          template += `
                    <tr>
                    <td class="datos">${item[0]}</td>
                    <td class="datos">${item[1]}</td>
                    <td class="datos">${item[2]}</td>
                    <td class="datos">${item[3]}</td>
                    <td class="datos">${item[4]}</td>
                    <td class="datos">${item[5]}</td>
                    <td class="datos">${item[6]}</td> `;
        });
        $("#cuerpo").html(template);
      }
    });
  }

  $("#formulario").submit(function(e) {
    if (editar === false) {
      $.post(
        "../Controllers/gastos.php",
        $("#formulario").serialize() + "&idgastos=" + null,
        function(response) {
          if (response == "1") {
            $("#mensaje").css("display", "block");
            $("#mensaje").text("Registro Exitoso");
            $("#mensaje").css("color", "green");
            $("#formulario").trigger("reset");
            $("#concepto").focus();
          } else {
            $("#mensaje").css("display", "block");
            $("#mensaje").text("Registro fallido");
            $("#mensaje").css("color", "red");
            $("#concepto").focus();
          }
          obtenerDatosTablaGastos();
        }
      );
    } else {
      const postData = {
        idgastos: idgastos,
        Sestado: $("#estado").val()
      };
      $.post("../Controllers/gastos.php", postData, function(response) {
        if (response == "1") {
          $("#formulario").trigger("reset");
          $(".modal").modal("hide");
          $("#mensaje").text("Registro Exitoso");
          $("#mensaje").css("color", "green");
          $("#concepto").focus();
        } else {
          $("#mensaje").css("display", "block");
          $("#mensaje").text("Registro fallido");
          $("#mensaje").css("color", "red");
          $("#concepto").focus();
        }
      });

      obtenerDatosTablaGastos();
    }
    e.preventDefault();
  });

  var touchtime = 0;
  $(document).on("click", "td", function () {
      if (touchtime == 0) {
        touchtime = new Date().getTime();
      } else {
        // compare first click to this click and see if they occurred within double click threshold
        if (new Date().getTime() - touchtime < 800) {
          // double click occurred
          $(".ocultar").hide();
          $("#mensaje").css("display", "none");
          let valores = "";
          $(this)
            .parents("tr")
            .find(".datos")
            .each(function() {
              valores += $(this).html() + "?";
            });
      
          datos = valores.split("?");
          idgastos = datos[0];
          $("#concepto").val(datos[1]);
          $("#pago").val(datos[2]);
          $("#descripcion").val(datos[3]);
          $("#monto").val(datos[4]);
          $("#estado").val(datos[5]);
          $("#fecha").val(datos[6]);
          editar = true;

        $("#modalForm").modal("show");
        } else {
          // not a double click so set as a new first click
          touchtime = new Date().getTime();
        }
      }
  }); 
});
