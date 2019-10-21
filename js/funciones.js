$(document).ready(function (){


var url = 'prueva.php';
var tabla = 'cuerpo';
var editar = 'editar';

function obtenerDatosCombo(){
    $.ajax({
      url:'../Controllers/usuariosab.php?combo=combo',
      type: 'GET',

      success: function(response){
        let datos = JSON.parse(response);
        let template = `
        <select>
        `;
        $.each(datos, function(i, item) {
          alert(datos[i].PageName);
          template += `
          <option value=${datos[i].PageName}>${datos[i].PageName}</option>
          `;
        });
        template += `</select>`;
        $('#combo').html(template);
      }
    });
  }
  
  function obtenerDatosTablaUsuarios(url,varpost,action,cuerpo) {
    $.ajax({
      url: url,
      type: "POST",
      data: {varpost:varpost},
      success: function (response) {
       let datos = JSON.parse(response);
        let template = "";
        if(action == 1){
            $.each(datos, function (i, item) {
                template += `<tr>
      `;
                for(var y = 0; y <= 15; y++){
                  template += `<td class="text-nowrap text-center ">${item[y]}</td>
                  `;
                }
              });
        }else if(action == 2){
            
        }

        $("#cuerpo").html(template); 
      }
    });
  }

pintarTabla(url,tabla,editar);

    function enviarFormulario(nombreIdFormulario,url){
        $.ajax({
            url: url,
            type:"POST",
            data:$('#'+nombreIdFormulario).serialize(),

            success: function (response){
                if(response == "error"){
                    console.log('Exito');
                }
            }
        });
    }

});