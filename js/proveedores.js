$(document).ready(function () {
    let idproveedor = "";
    let editar = "";
    obteneDatosProveedor();

    var touchtime = 0;
    $(document).on("click", "td", function () {
        if (touchtime == 0) {
          touchtime = new Date().getTime();
        } else {
          // compare first click to this click and see if they occurred within double click threshold
          if (new Date().getTime() - touchtime < 800) {
            // double click occurred
            var valores = "";
            // Obtenemos todos los valores contenidos en los <td> de la fila
            // seleccionada
            $(this).parents("tr").find("td").each(function () {
              valores += $(this).html() + "?";
            });
            datos = valores.split("?");
            console.log(datos);
            idproveedor = datos[1];
            $("#rfc").val(datos[2]);
            $("#dias_credito").val(datos[3]);
            $("#nombre").val(datos[4]);
            $("#domicilio").val(datos[5]);
            $("#colonia").val(datos[6]);
            $("#ciudad").val(datos[7]);
            $("#estado").val(datos[8]);
            $("#pais").val(datos[9]);
            $("#telefono").val(datos[10]);
            $("#email").val(datos[10]);
            editar = true;
          $("#modalForm").modal("show");
          } else {
            // not a double click so set as a new first click
            touchtime = new Date().getTime();
          }
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
              $('#eliminar').prop("checked", false);
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
          url: "../Controllers/proveedores.php",
          type: "POST",
          data: {'array': JSON.stringify(result)},
  
          success: function (response) {
            console.log(response);
                return response;
          }
        }); 
    }


    $("#formulario").submit(function (e) {
        $.post("../Controllers/negocio.php",$("#formulario").serialize() + '&idproveedor=' + idproveedor + '&accion=' + editar, function (response) {
          console.log(response);
          $("#mensaje").css("display", "block");
          if (response == "1") {
            if(editar == true){
              $('.modal').modal('hide');
              $("#mensaje").css("display", "none");
            }
            $("#mensaje").text("Registro Exitoso");
            $("#mensaje").css("color", "green");
            $("#email").focus();
            $("#formulario").trigger("reset");
          } else {
            $("#mensaje").text("Registro fallido");
            $("#mensaje").css("color", "red");
            $("#email").focus();
          }
          obtenerDatosTablaUsuarios();
        });
        e.preventDefault();
      });

    function obteneDatosProveedor(){
        $.ajax({
            url: "../Controllers/proveedores.php",
            type: "POST",
            data: "tabla=tabla",
      
            success: function (response) {
              console.log(response);
              let datos = JSON.parse(response);
              let template = "";
              $.each(datos, function (i, item) {
                template+=`
                <tr>
                    <td><input id="eliminar" class="check" type="checkbox" value="si" ></td>
                    <td class="text-nowrap text-center d-none">${item[0]}</td>
                    <td class="text-nowrap text-center">${item[1]}</td>
                    <td class="text-nowrap text-center">${item[2]}</td>
                    <td class="text-nowrap text-center">${item[3]}</td>
                    <td class="text-nowrap text-center">${item[4]}</td>
                    <td class="text-nowrap text-center">${item[5]}</td>
                    <td class="text-nowrap text-center">${item[6]}</td>
                    <td class="text-nowrap text-center">${item[7]}</td>
                    <td class="text-nowrap text-center">${item[8]}</td>
                    <td class="text-nowrap text-center">${item[9]}</td>
                    <td class="text-nowrap text-center">${item[10]}</td>
                    <td class="text-nowrap text-center">${item[11]}</td>
                </tr>
                `;
              });
              $("#cuerpo").html(template);
          }
        });
    }
});