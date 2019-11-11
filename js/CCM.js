$(document).ready(function () {
obtenerDatosCategoria();
obtenerDatosColores();
obtenerDatosMarcas();


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
              if(enviarDatos() != 'error'){
                swal("Exito!", 
                "Sus datos han sido eliminados.",
                 "success");
              }else{
                swal("Error!", 
                "Ups, algo salio mal.",
                 "warning");
              }
              $('#checkMarca').prop("checked", false);
              $('#checkCategoria').prop("checked", false);
              $('#checkColores').prop("checked", false);
          });
    });

    function enviarDatos(){
        var valores = "";
        let val = "";
    
        $('#cuerpoColores').children("tr").find("td").find("input").each(function () {
            if($(this).prop('checked')){
                valores += $(this).parents("tr").find("td").eq(1).text() + "?";
            }
        }); 
       $('#cuerpoMarcas').find("tr").find("td").find(".check").each(function () {
            if($(this).prop('checked')){
                valores += $(this).parents("tr").find("td").eq(1).text() + "?";
            }
        }); 
        $('#cuerpoCategoria').find("tr").find("td").find(".check").each(function () {
            if($(this).prop('checked')){
                valores += $(this).parents("tr").find("td").eq(1).text() + "?";
            }
        });   
        valores += "0";
        result = valores.split("?");
        console.log(result);
         $.ajax({
          url: "../Controllers/CCM.php",
          type: "POST",
          data: {'array': JSON.stringify(result)},
  
          success: function (response) {
            console.log(response);
                obtenerDatosMarcas();
                obtenerDatosColores();
                obtenerDatosCategoria();
                return response;
          }
        }); 
    }


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
                      <td class="text-nowrap text-center">${item[2]}</td>
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
                      <td><input class="check " type="checkbox" name="Ntasa_iva" value="si" ></td>
                      <td class="text-nowrap text-center d-none">${item[0]}</td>
                      <td class="text-nowrap text-center">${item[2]}</td>
                `;
              });
              $("#cuerpoCategoria").html(template);
            }
          });
    }

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
                      <td class="text-nowrap text-center">${item[2]}</td>
                `;
              });
              $("#cuerpoMarcas").html(template);
            }
          });
    }

    $(document).on('click','#checkColores , #checkCategoria, #checkMarca',function(){
        var boton = $(this).attr('id');
        if(boton == 'checkColores'){
            if($(this).prop('checked')){
                $('#cuerpoColores').children("tr").find("td").find("input").each(function () {
                    $(this).prop("checked", true);
                }); 
            }else{
                $('#cuerpoColores').children("tr").find("td").find("input").each(function () {
                    $(this).prop("checked", false);
                }); 
            }
        }else if(boton == 'checkCategoria'){
            if($(this).prop('checked')){
                $('#cuerpoCategoria').children("tr").find("td").find("input").each(function () {
                    $(this).prop("checked", true);
                }); 
            }else{
                $('#cuerpoCategoria').children("tr").find("td").find("input").each(function () {
                    $(this).prop("checked", false);
                }); 
            }
        }else{
            if($(this).prop('checked')){
                $('#cuerpoMarcas').children("tr").find("td").find("input").each(function () {
                    $(this).prop("checked", true);
                }); 
            }else{
                $('#cuerpoMarcas').children("tr").find("td").find("input").each(function () {
                    $(this).prop("checked", false);
                }); 
            }
        }
    });

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
        e.preventDefault();
    });

});