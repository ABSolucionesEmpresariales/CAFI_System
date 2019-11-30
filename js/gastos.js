$(document).ready(function () {
  //Vgastos
  let editar = false;
  let idgastos = "";
  let acceso = "";
  obtenerAcceso();
  obtenerTrabajadores();
  $("#divtrabajadores").css("display", "none");
  function obtenerTrabajadores() {
    $.ajax({
      url: "../Controllers/gastos.php",
      type: "POST",
      data: "combo=combo",

      success: function (response) {
        let datos = JSON.parse(response);

        let template = null;
        template += `
        <option></option>`;

        $.each(datos, function (i, item) {
          template += `
          <option>${item[0]}</option>`;
        });
        $("#strabajadores").html(template);
      }
    });
  }

  function obtenerAcceso() {
    $.ajax({
      url: "../Controllers/login.php",
      type: "POST",
      data: "accesoPersona=accesoPersona",

      success: function (response) {
        acceso = response;
        $.ajax({
          url: "../Controllers/gastos.php",
          type: "POST",
          data: "tabla=tabla",
    
          success: function(response) {
            let datos = JSON.parse(response);
    
            let template = null;
            $.each(datos, function(i, item) {
              template += `<tr>`;
                if(acceso ==  'CEO'){
                  template += `<td><input type="checkbox" value="si"></td>`;            
                }
              template += `
                        <td class="datos d-none">${item[0]}</td>
                        <td class="datos">${item[1]}</td>
                        <td class="datos">${item[2]}</td>
                        <td class="datos">${item[3]}</td>
                        <td class="datos">$${item[4]}</td>
                        <td class="datos">${item[5]}</td>
                        <td class="datos">${item[6]}</td> `;
            });
            $("#cuerpo").html(template);
          }
        });
      }
    });
  }

  function enviarDatos() {
    var valores = "";

    $("#cuerpo")
      .children("tr")
      .find("td")
      .find("input")
      .each(function () {
        if ($(this).prop("checked")) {
          valores +=
            $(this)
              .parents("tr")
              .find("td")
              .eq(1)
              .text() + "?";
        }
      });
    valores += "0";
    result = valores.split("?");
    console.log(result);
    $.ajax({
      url: "../Controllers/gastos.php",
      type: "POST",
      data: { array: JSON.stringify(result) },

      success: function (response) {
        console.log(response);
        return response;
      }
    });
  }

  $(document).on("click", ".eliminar", function () {
    swal(
      {
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

  $(document).on("click", ".check", function () {
    if ($(this).prop("checked")) {
      $("#cuerpo")
        .children("tr")
        .find("td")
        .find("input")
        .each(function () {
          $(this).prop("checked", true);
        });
    } else {
      $("#cuerpo")
        .children("tr")
        .find("td")
        .find("input")
        .each(function () {
          $(this).prop("checked", false);
        });
    }
  });

  $(".agregar").click(function () {
    $(".ocultar").show();
    $("#mensaje").css("display", "none");
    $("#divtrabajadores").css("display", "none");
    editar = false;
    console.log(editar);
  });

  $(".close").click(function () {
    $("#formulario").trigger("reset");
  });

  $("#formulario").submit(function(e) {
    if (editar === false) {
      $.post(
        "../Controllers/gastos.php",
        $("#formulario").serialize() + "&idgastos=" + null,
        function (response) {
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
          obtenerAcceso();
        }
      );
    } else {
      const postData = {
        idgastos: idgastos,
        Sestado: $("#estado").val()
      };
      $.post("../Controllers/gastos.php", postData, function (response) {
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
      obtenerAcceso();
    }
    e.preventDefault();
  });

  $(document).on("change", "#concepto", function () {
    if ($("#concepto").val() === "Sueldo") {
      $("#divtrabajadores").css("display", "block");
      $("#divdescripcion").css("display", "none");
      console.log('llego');
    } else {
      $("#divtrabajadores").css("display", "none");
    }
  });

  $(document).on("change", "#strabajadores", function () {
    $("#descripcion").val($("#strabajadores").val());
    console.log( $("#descripcion").val());
  });



  var touchtime = 0;
  $(document).on("click", "td", function () {
    if (touchtime == 0) {
      touchtime = new Date().getTime();
    } else {
      // compare first click to this click and see if they occurred within double click threshold
      if (new Date().getTime() - touchtime < 300) {
        // double click occurred
        $(".ocultar").hide();
        $("#divtrabajadores").hide();
        $("#mensaje").css("display", "none");
        let valores = "";
        $(this)
          .parents("tr")
          .find(".datos")
          .each(function () {
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
