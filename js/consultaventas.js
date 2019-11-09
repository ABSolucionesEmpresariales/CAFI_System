$(document).ready(function () {
  let venta = null;
  let estadoglobal = '';
  obtenerDatosTabla();
  function obtenerDatosTabla() {
    $.ajax({
      url: "../Controllers/ventas.php",
      type: "POST",
      data: "tabla=tabla",

      success: function(response) {
        let datos = JSON.parse(response);

        let template = null;
        $.each(datos, function(i, item) {
          template += `
                    <tr>
                    <td class="datos d-none">${item[0]}</td>
                    <td><button class="bconcepto btn btn-info">Mostrar</button></td>
                    <td>${item[1]}</td>
                    <td>${item[2]}</td>
                    <td>${item[3]}</td>
                    <td>${item[4]}</td>
                    <td>${item[5]}</td>
                    <td>${item[6]}</td>
                    <td>${item[7]}</td>
                    <td class="datos">${item[8]}</td>
                    <td>${item[9]}</td>
                   </tr> `;
        });
        $("#renglones").html(template);
      }
    });
  }

  $(document).on("click", ".bconcepto", function () {
  $('#modalFormMostrar').modal('show');
  let valores = '';
  $(this)
  .parents("tr")
  .find(".datos")
  .each(function() {
    valores += $(this).html() + "?";
  });
  datos = valores.split("?");
   const postData = {
    idventa: datos[0]
  };

  $.post("../Controllers/ventas.php", postData, function(response) {
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
               </tr> `;
    });
    $("#cuerpo").html(template);
  });
  });

  var touchtime = 0;
  $(document).on("click", "td", function () {
      if (touchtime == 0) {
        touchtime = new Date().getTime();
      } else {
        // compare first click to this click and see if they occurred within double click threshold
        if (new Date().getTime() - touchtime < 800) {
          // double click occurred
          $("#mensaje").css("display", "none");
          let valores = '';
          $(this)
          .parents("tr")
          .find(".datos")
          .each(function() {
            valores += $(this).html() + "?";
          });
          datos = valores.split("?");
        
           venta = datos[0];
           estadoglobal = datos[1];
           console.log(venta);
           $('#estado').val(estadoglobal);
        $("#modalForm").modal("show");
        } else {
          // not a double click so set as a new first click
          touchtime = new Date().getTime();
        }
      }
  }); 


    $("#formConsulta").submit(function (e) {

    const postData = {
       venta: venta, 
       estado: $('#estado').val()
     };
     if($('#estado').val() != estadoglobal){
      $.post("../Controllers/ventas.php",postData, function (response) {
        console.log(response);
        $("#mensaje").css("display", "block");
        if (response == "1") {
          $('#modalForm').modal('hide');
          $("#mensaje").css("display", "none");
          obtenerDatosTabla();
        } else {
          $("#mensaje").css("display", "block");
          $("#mensaje").text("Registro fallido");
          $("#mensaje").css("color", "red");
          $("#estado").focus();
        }
      });
    
     }else{
      $('#modalForm').modal('hide');
     }
     e.preventDefault();
    });
});