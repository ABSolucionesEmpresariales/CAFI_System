$(document).ready(function() {
  let idretiro = null;
  let efectivo = null;
  let banco = null;
  let acceso = '';
  obtenerAcceso();
  obtenerDatosDeTabla();
  obtenerDinero();

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
        obtenerDatosDeTabla();
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
    url: "../Controllers/retiros.php",
    type: "POST",
    data: {'array': JSON.stringify(result)},

    success: function (response) {
      console.log(response);
          return response;
    }
  }); 
}

  $(".retirar").click(function() {
    $(".mensaje").css("display", "none");
  });
  function obtenerDinero() {
    $.ajax({
      url: "../Controllers/retiros.php",
      type: "POST",
      data: "tablacantidades=cantidades",

      success: function(response) {
        console.log(response);
        let datos = JSON.parse(response);
        let template = null;
        $.each(datos, function(i, item) {
          efectivo = item[0];
          banco = item[1];

          template = `
                    <td>${efectivo}</td>
                    <td>${banco}</td>
                    `;
        });
        $("#cuerpoEfectivo").html(template);
      }
    });
  }

  function obtenerDatosDeTabla() {
    $.ajax({
      url: "../Controllers/retiros.php",
      type: "POST",
      data: "tabla=tabla",

      success: function(response) {
        let datos = JSON.parse(response);
        console.log(acceso);
        let template = null;
        $.each(datos, function(i, item) {
          template += `<tr>`;
          if(acceso == 'CEO'){
            template += `<td><input type="checkbox" value="si"></td>`;  
          }          
          template += `<td class="datos d-none">${item[0]}</td>
                    <td>${item[1]}</td>
                    <td>${item[2]}</td>
                    <td>${item[3]}</td>
                    <td>${item[4]}</td>
                    <td>${item[5]}</td>
                    <td>${item[6]}</td>
                    <td class="datos">${item[7]}</td>
                    <td>${item[8]}</td>
                   </tr> `;
        });
        $("#cuerpo").html(template);
      }
    });
  }

  $("#formulario1").submit(function(e) {
    let cantidad = $("#cant").val();
    let tipo = $("#de").val();
    let concepto = $("#cant").val();
    let descripcion = $("#desc").val();

    if (concepto == "Corte de caja" && tipo == "Banco") {
      //se compara que la cantidad a retirar en efectivo no sea superior a la cantidad en en efectivo que hay en caja
      swal({
        title: "Alerta",
        text: "Proceso erroneo, No puede hacer corte de caja en banco",
        type: "warning"
      });
    } else if (tipo == "Caja" && cantidad <= efectivo) {
      $.post(
        "../Controllers/retiros.php",
        $("#formulario1").serialize() + "&idretiro=" + null,
        function(response) {
          console.log(response);
          if (response == "1") {
            $(".mensaje").css("display", "block");
            $(".mensaje").text("Registro Exitoso");
            $(".mensaje").css("color", "green");
            $("#formulario1").trigger("reset");
            $("#cant").focus();
          } else {
            $(".mensaje").css("display", "block");
            $(".mensaje").text("Registro fallido");
            $(".mensaje").css("color", "red");
            $("#cant").focus();
          }
        }
      );
      obtenerDatosDeTabla();
      obtenerDinero();
    } else if (tipo == "Caja" && cantidad > efectivo) {
      swal({
        title: "Alerta",
        text: "Saldo insuficiente en caja",
        type: "warning"
      });
    } else if (tipo == "Banco" && cantidad <= banco) {
      $.post(
        "../Controllers/retiros.php",
        $("#formulario1").serialize() + "&idretiro=" + null,
        function(response) {
          console.log(response);
          if (response == "1") {
            $(".mensaje").css("display", "block");
            $(".mensaje").text("Registro Exitoso");
            $(".mensaje").css("color", "green");
            $("#formulario1").trigger("reset");
            $("#cant").focus();
          } else {
            $(".mensaje").css("display", "block");
            $(".mensaje").text("Registro fallido");
            $(".mensaje").css("color", "red");
            $("#cant").focus();
          }
          obtenerDatosDeTabla();
          obtenerDinero();
        }
      );
    } else if (tipo == "Banco" && cantidad > banco) {
      swal({
        title: "Alerta",
        text: "Saldo insuficiente en banco",
        type: "warning"
      });
    }

    e.preventDefault();
  });

  $("#formulario2").submit(function(e) {
    $.post(
      "../Controllers/retiros.php",
      $("#formulario2").serialize() + "&idretiro=" + idretiro,
      function(response) {
        console.log(response);
        if (response == "1") {
          $("#formulario2").trigger("reset");
          $(".modal").modal("hide");
          $(".mensaje").text("Registro Exitoso");
          $(".mensaje").css("color", "green");
          $("#modalForm2").modal("hide");
        } else {
          $(".mensaje").css("display", "block");
          $(".mensaje").text("Registro fallido");
          $(".mensaje").css("color", "red");
        }
        obtenerDatosDeTabla();
        obtenerDinero();
      
      }
    );

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

          $(".mensaje").css("display", "none");
          let valores = "";
          $(this)
            .parents("tr")
            .find(".datos")
            .each(function() {
              valores += $(this).html() + "?";
            });
      
          datos = valores.split("?");
          console.log(datos);
          idretiro = datos[0];
          $("#estado").val(datos[1]);
        $("#modalForm2").modal("show");
        } else {
          // not a double click so set as a new first click
          touchtime = new Date().getTime();
        }
      }
  }); 

});
