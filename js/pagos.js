$(document).ready(function () {
  
    idpago = "";
    obtenerAcceso();


    $(document).on('click','.eliminar',function(){
      swal({
          title: "Esta seguro que desea eliminar ?",
          text: "Esta accion sumara el abono al adeudo correspondiente de la venta!",
          type: "warning",
          showCancelButton: true,
          confirmButtonClass: "btn-danger",
          confirmButtonText: "Si, eliminarlo!",
          closeOnConfirm: false
        },
        function(){
          var valores = "";
          $('#cuerpo').find("tr").find("td").find("input").each(function () {
              if($(this).prop('checked')){
                  valores += $(this).parents("tr").find("td").eq(1).text() + "?";
              }
          });   
          valores += "0";
          result = valores.split("?");
          const postData = {
            array: JSON.stringify(result),
            tabla_afectada: 'abonos'
          };
          console.log(postData);
           $.ajax({
            url: "../Controllers/cpp.php",
            type: "POST",
            data: postData,
      
            success: function (response) {
              if(typeof(response) != '0'){
                swal("Exito!", 
                "Sus datos han sido eliminados.",
                 "success");
              }else{
                swal("Error!", 
                "Ups, algo salio mal.",
                 "warning");
              }
              $('.check').prop("checked", false);
              console.log(response);
              obtenerAcceso();
  
                  return response;
            }
          }); 
        });
  });

    function obtenerAcceso(){
      $.ajax({
        url: "../Controllers/login.php",
        type: "POST",
        data:"accesoPersona=accesoPersona",
  
        success: function (response) {
          acceso = response;
          $.ajax({
            url: "../Controllers/cpp.php",
            type: "POST",
            data: "tabla_abonos_compras=tabla_abonos_compras",
            success: function (response) {
             let datos = JSON.parse(response);
              let template = "";
              $.each(datos, function (i, item) {
                template += `<tr>`;
                if(acceso == 'CEO'){
                template +=`<td class="text-nowrap text-center"><input type="checkbox" value="si"></td>`;
                }
                template += `
                      <td class="text-nowrap text-center">${item[0]}</td>
                      <td class="text-nowrap text-center">${item[1]}</td>
                      <td class="text-nowrap text-center font-weight-bold">${item[2]}</td>
                      <td class="text-nowrap text-center text-success font-weight-bold">$${item[3]}</td>
                      <td class="text-nowrap text-center">${item[4]}</td>
                      <td class="text-nowrap text-center">${item[5]}</td>
                      <td class="text-nowrap text-center">${item[6]}</td>
                `;
              });
              $("#cuerpo").html(template);
            }
          });

        }
      });
    }
  
    $("#formulario").submit(function (e) {
      $.post("../Controllers/cpp.php",$("#formulario").serialize() + "&idpago=" + idpago, function (response) {
        console.log(response);
        if (response == "1") {
          $('.modal').modal('hide');
        } else {
          $("#mensaje").text("Registro fallido");
          $("#mensaje").css("color", "red");
          $("#email").focus();
        }
        obtenerAcceso();
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
  
    var touchtime = 0;
    $(document).on("click", "td", function () {
        if (touchtime == 0) {
          touchtime = new Date().getTime();
        } else {
          // compare first click to this click and see if they occurred within double click threshold
          if (new Date().getTime() - touchtime < 300) {
            // double click occurred
            var valores = "";
            // Obtenemos todos los valores contenidos en los <td> de la fila
            // seleccionada
            $(this).parents("tr").find("td").each(function () {
              valores += $(this).html() + "?";
            });
            datos = valores.split("?");
  
            idpago = datos[0];
            console.log(idpago);
            $("#estado").val(datos[1]);
            $("#modalForm").modal("show");
  
          } else {
            // not a double click so set as a new first click
            touchtime = new Date().getTime();
          }
        }
    }); 
  
  });
  