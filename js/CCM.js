$(document).ready(function () {
obtenerDatosCategoria();
obtenerDatosColores();
obtenerDatosMarcas();


    $(document).on('click','.eliminar',function(){
        swal({
            title: "Alerta!",
            text: "¿Esta seguro que desea eliminar?",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Eliminar!",
            closeOnConfirm: false
          },
          function(){
            var valores = "";
            let val = "";
        
            $('#CuerpoColores').find("tr").find("input").each(function () {
                if($(this).val() == 'si'){
                    valores += $(this).html() + "?";
                }
            }); 
/* 
           $('#CuerpoMarcas').find("tr").find("td").find(".check").each(function () {
                if($(this).val() == 'si'){
                    valores += $(this).next().text();
                }
            }); 
            $('#CuerpoCategorias').find("tr").find("td").find(".check").each(function () {
                if($(this).val() == 'si'){
                    valores += $(this).next().text();
                }
            });   */

            console.log("Estos son: "+valores);
/*             $.ajax({
              url: "../Controllers/usuariosab.php",
              type: "POST",
              data: postData,
      
              success: function (response) {
                console.log(response);
                
              }
            }); */
          });
    });


    function obtenerDatosColores(){
        $.ajax({
            url: "../Controllers/CCM.php",
            type: "POST",
            data: "tablaColores=tablaColores",
    
            success: function (response) {
              console.log(response);
              let datos = JSON.parse(response);
              let template = "";
              $.each(datos, function (i, item) {
                template += `
                <tr>
                      <td><input class="check" type="checkbox" name="Ntasa_iva" value="si" ></td>
                      <td class="text-nowrap text-center d-none">${item[0]}</td>
                      <td class="text-nowrap text-center">${item[1]}</td>
                `;
              });
              $("#cuerpoColores").html(template);
            }
          });
    }

    function obtenerDatosCategoria(){
        $.ajax({
            url: "../Controllers/CCM.php",
            type: "POST",
            data: "tablaCategoria=tablaCategoria",
    
            success: function (response) {
              console.log(response);
              let datos = JSON.parse(response);
              let template = "";
              $.each(datos, function (i, item) {
                template += `
                <tr>
                      <td><input class="check" type="checkbox" name="Ntasa_iva" value="si" ></td>
                      <td class="text-nowrap text-center d-none">${item[0]}</td>
                      <td class="text-nowrap text-center">${item[1]}</td>
                `;
              });
              $("#cuerpoCategoria").html(template);
            }
          });
    }

    $('#formulario').submit(function(e){
        if($('#CCM').val() == 'Elejir'){
            $('#CCM').focus();
            return false;
        }
        if($('#CCMInput').val() == ''){
            $('#CCMInput').focus();
            return false;
        }
        $.ajax({
            url: "../Controllers/CCM.php",
            type: "POST",
            data: $('#formulario').serialize(),
    
            success: function (response) {
                console.log(response);
                $('#formulario').trigger("reset");
                obtenerDatosMarcas();
                obtenerDatosColores();
                obtenerDatosCategoria();
            }
        });


    });

    function obtenerDatosMarcas(){
        $.ajax({
            url: "../Controllers/CCM.php",
            type: "POST",
            data: "tablaMarcas=tablaMarcas",
    
            success: function (response) {
              console.log(response);
              let datos = JSON.parse(response);
              let template = "";
              $.each(datos, function (i, item) {
                template += `
                <tr>
                      <td><input class="check" type="checkbox" name="Ntasa_iva" value="si" ></td>
                      <td class="text-nowrap text-center d-none">${item[0]}</td>
                      <td class="text-nowrap text-center">${item[1]}</td>
                `;
              });
              $("#cuerpoMarcas").html(template);
            }
          });
    }


});