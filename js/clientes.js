$(document).ready(function () {
  //clientes que compran cafi
  obtenerAcceso();

  function obtenerAcceso() {
    $.ajax({
      url: "../Controllers/login.php",
      type: "POST",
      data: "accesoPersona=accesoPersona",

      success: function (response) {
        acceso = response;
        $.ajax({
          url: "../Controllers/clienteab.php",
          type: "POST",
          data: "tabla=tabla",

          success: function (response) {
            console.log(response);
            let datos = JSON.parse(response);
            let template = "";
            let color;
            $.each(datos, function (i, item) {
              if (item[1] === "0") {
                item[1] = "Realizada";
                color = "text-success";
              } else {
                item[1] = "No realizada"
                color = "text-danger";
              }
              template += `<tr>`;
              template += `<td class="text-nowrap text-center">${item[0]}</td>
              <td class="text-nowrap text-center ${color}">${item[1]}</td>
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
                      <td class="text-nowrap text-center">${item[12]}</td>
                      <td class="text-nowrap text-center">${item[13]}</td>
                      <td class="text-nowrap text-center">${item[14]}</td>
                      <td class="text-nowrap text-center d-none">${item[15]}</td>
    
                `;
            });
            $("#cuerpo").html(template);
          }
        });
      }
    });
  }
});
