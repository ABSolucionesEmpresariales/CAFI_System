$(document).ready(function () {
    let session = '';
    obtenerSesion();
    

    function obtenerSesion(){
        $.ajax({
            url: "../Controllers/masVendidos.php",
            type: "POST",
            data: "sessionNegocio=sessionNegocio",
            success: function (response) {
                console.log(response);
                session = response;
                obtenerDatosTabla(session);
          }
        });
    }

    $(document).on('change','#sucursal',function(){
        obtenerDatosTabla($(this).val());
    });

    function obtenerDatosTabla(session){
        console.log("session = "+session);
        $.ajax({
            url: "../Controllers/masVendidos.php",
            type: "POST",
            data: "idnegocio="+session,
      
            success: function (response) {
                
                let datos = JSON.parse(response);
                console.log(datos);
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

});