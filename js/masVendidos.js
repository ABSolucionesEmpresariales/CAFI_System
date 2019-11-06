$(document).ready(function () {
    obtenerNegocios();

    $(document).on('change','#sucursal',function(){
        obtenerDatosTabla($(this).val());
    });

    function obtenerDatosTabla(sucursal){
        $.ajax({
            url: "../Controllers/masVendidos.php",
            type: "POST",
            data: "idnegocio="+sucursal,
      
            success: function (response) {
                console.log(response);
                let datos = JSON.parse(response);
                let template = "";
                $.each(datos, function (i, item) {
                    for(var j = 0; j <= item.length; j++){
                        if(item[j] == 'null'){
                          item[j] = "";
                        }
                  }
                    template+=`
                    <tr>
                    <td>${item[0]} ${item[1]} ${item[2]} ${item[3]} ${item[4]}</td>
                    <td>${item[5]}</td>
                    </tr>
                    `;
                });

                $('#cuerpo').html(template);
          }
        });
    }

    function obtenerNegocios(){
        $.ajax({
            url: "../Controllers/masVendidos.php",
            type: "POST",
            data: "negocios=negocios",
      
            success: function (response) {
                console.log(response);
                let datos = JSON.parse(response);
                let template = "<option value=></option>";
                $.each(datos, function (i, item) {
                    for(var j = 0; j <= item.length; j++){
                        if(item[j] == 'null'){
                          item[j] = "";
                        }
                  }
                    template+=`
                    <option value="${item[0]}">${item[1]}</option>
                    `;
                });
                $('#sucursal').html(template);
          }
        });
    }

});