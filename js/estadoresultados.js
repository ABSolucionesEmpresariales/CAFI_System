$(document).ready(function() {
  pintarComboNegocios();
  function pintarComboNegocios() {
    $.ajax({
      url: "../Controllers/estadoresultados.php",
      type: "POST",
      data: "combo=negocio",
      success: function(response) {
        let datos = JSON.parse(response);
        let template = "";
        template += `<option value=""></option>`;
        $.each(datos, function(i, item) {
          template += `
            <option value="${item[0]}">${item[1]}</option>   
            `;
        });
        template += `<option value="Todos">Todos</option>`;
        $(".combosucursal").html(template);
      }
    });
  }

  $("#form1").submit(function(e) {
    $.post(
      "../Controllers/estadoresultados.php",
      $("#form1").serialize(),
      function(response) {
        console.log(response);
        datos = JSON.parse(response);
        let template = ` 
      <th>Ventas</th>
      <th>Costo de Venta</th>
      <th>Utilidad Bruta</th>`;

        $("#rowencabezado").html(template);
        template = `
      <tr>
      <td>${datos.ventas}</td>
      <td>${datos.costo_venta}</td>
      <td>${datos.utilidad_bruta}</td>
      </tr>
    `;
        $("#cuerpo").html(template);
        $("#modalForm").modal("hide");
      }
    );
    e.preventDefault();
  });

  $("#form2").submit(function(e) {
    $.post(
      "../Controllers/estadoresultados.php",
      $("#form2").serialize(),
      function(response) {
        let template = ` 
        <th>Ventas</th>
        <th>Costo de Venta</th>
        <th>Utilidad Bruta</th>
        <th>Utilidad Neta</th>`;

        $("#rowencabezado").html(template);
        console.log(response);
        datos = JSON.parse(response);
        template = `
        <tr>
        <td>${datos.ventas}</td>
        <td>${datos.costo_venta}</td>
        <td>${datos.utilidad_bruta}</td>
        <td>${datos.utilidad_neta}</td>
       </tr>
        `;
        $("#cuerpo").html(template);
        $("#modalForm").modal("hide");
      }
    );
    e.preventDefault();
  });

  $(document).on("change", "#sucursal", function() {
    const postData = {
      negocio: $("#sucursal").val()
    };
    $.post("../Controllers/estadoresultados.php", postData, function(response) {
      datos = JSON.parse(response);
      let template = ` 
      <th>Ventas</th>
      <th>Costo de Venta</th>
      <th>Utilidad Bruta</th>`;
      $("#rowencabezado").html(template);
      template = `
      <tr>
      <td>${datos.ventas}</td>
      <td>${datos.costo_venta}</td>
      <td>${datos.utilidad_bruta}</td>
      </tr>
      `;
      $("#cuerpo").html(template);
    });
  });
});
