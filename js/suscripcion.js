$(document).ready(function () {
  //variables globales
  obtenerTabla();
  function obtenerTabla() {
    $.ajax({
      url: "../Controllers/moduloab.php",
      type: "POST",
      data: "tabla=suscripciones",
      success: function (response) {

       let datos = JSON.parse(response);
        let template = "";
        $.each(datos, function (i, item) {
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
                <td class="text-nowrap text-center d-none">${item[8]}</td>
                <td class="text-nowrap text-center">${item[9]}</td>
          `;
        });
        $("#cuerpo").html(template);
      }
    });
  }
});
