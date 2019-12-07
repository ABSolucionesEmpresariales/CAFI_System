$(document).ready(function () {
  //VUsuarios_ab
  obtenerTabla();

  function obtenerTabla() {
    $.ajax({
      url: "../Controllers/moduloab.php",
      type: "POST",
      data: "tabla=negocios",
      success: function (response) {
        console.log(response);
        let datos = JSON.parse(response);
        let template = "";
        $.each(datos, function (i, item) {
          /*           for(var y = 0; y < 12; y++){
                      template += `
                      <tr>
                            <td class="text-nowrap text-center ">${item[y]}</td>`;
                    } */
          for (i = 0; i < item.length; i++) {
            if (item[i] == null || item[i] == 'null') {
              item[i] = "";
            }
          }
          template += `
          <tr>
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
                <td class="text-nowrap text-center">${item[11]}</td>`;
                if(item[12] == null){
                  template += `<td class="text-nowrap text-center"></td>
                  `;
          }
        });
        $("#cuerpo").html(template);
      }
    });
  }
});
