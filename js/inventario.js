$(document).ready(function() {
  let codigo = null;
  $(document).on("change", "#categoria", function() {
    let head = null;
    let categoria = $("#categoria").val();
    if (categoria === "Ropa") {
      head = `        
        <th class="text-nowrap text-center" onclick="sortTable(0)">Nombre</th>
        <th class="text-nowrap text-center" onclick="sortTable(0)">Imagen</th>
        <th class="text-nowrap text-center" onclick="sortTable(0)">Marca</th>
        <th class="text-nowrap text-center" onclick="sortTable(0)">Color</th>
        <th class="text-nowrap text-center" onclick="sortTable(0)">UM</th>
        <th class="text-nowrap text-center" onclick="sortTable(0)">XXL</th>
        <th class="text-nowrap text-center" onclick="sortTable(0)">XL</th>
        <th class="text-nowrap text-center" onclick="sortTable(0)">L</th>
        <th class="text-nowrap text-center" onclick="sortTable(0)">M</th>
        <th class="text-nowrap text-center" onclick="sortTable(0)">S</th>
        <th class="text-nowrap text-center" onclick="sortTable(0)">XS</th>
        <th class="text-nowrap text-center" onclick="sortTable(0)">XXS</th>`;

      $(".encabezados").html(head);
    } else if (categoria === "Zapatos") {
      head = `        
        <th class="text-nowrap text-center" onclick="sortTable(0)">Nombre</th>
        <th class="text-nowrap text-center" onclick="sortTable(0)">Imagen</th>
        <th class="text-nowrap text-center" onclick="sortTable(0)">Marca</th>
        <th class="text-nowrap text-center" onclick="sortTable(0)">Color</th>
        <th class="text-nowrap text-center" onclick="sortTable(0)">UM</th>
        <th class="text-nowrap text-center" onclick="sortTable(0)">10</th>
        <th class="text-nowrap text-center" onclick="sortTable(0)">11</th>
        <th class="text-nowrap text-center" onclick="sortTable(0)">11.5</th>
        <th class="text-nowrap text-center" onclick="sortTable(0)">12</th>
        <th class="text-nowrap text-center" onclick="sortTable(0)">12.5</th>
        <th class="text-nowrap text-center" onclick="sortTable(0)">13</th>
        <th class="text-nowrap text-center" onclick="sortTable(0)">13.5</th>
        <th class="text-nowrap text-center" onclick="sortTable(0)">14</th>
        <th class="text-nowrap text-center" onclick="sortTable(0)">14.5</th>
        <th class="text-nowrap text-center" onclick="sortTable(0)">15</th>
        <th class="text-nowrap text-center" onclick="sortTable(0)">15.5</th>
        <th class="text-nowrap text-center" onclick="sortTable(0)">16</th>
        <th class="text-nowrap text-center" onclick="sortTable(0)">16.5</th>
        <th class="text-nowrap text-center" onclick="sortTable(0)">17</th>
        <th class="text-nowrap text-center" onclick="sortTable(0)">17.5</th>
        <th class="text-nowrap text-center" onclick="sortTable(0)">18</th>
        <th class="text-nowrap text-center" onclick="sortTable(0)">18.5</th>
        <th class="text-nowrap text-center" onclick="sortTable(0)">19</th>
        <th class="text-nowrap text-center" onclick="sortTable(0)">19.5</th>
        <th class="text-nowrap text-center" onclick="sortTable(0)">20</th>
        <th class="text-nowrap text-center" onclick="sortTable(0)">20.5</th>
        <th class="text-nowrap text-center" onclick="sortTable(0)">21</th>
        <th class="text-nowrap text-center" onclick="sortTable(0)">21.5</th>
        <th class="text-nowrap text-center" onclick="sortTable(0)">22</th>
        <th class="text-nowrap text-center" onclick="sortTable(0)">22.5</th>
        <th class="text-nowrap text-center" onclick="sortTable(0)">23</th>
        <th class="text-nowrap text-center" onclick="sortTable(0)">23.5</th>
        <th class="text-nowrap text-center" onclick="sortTable(0)">24</th>
        <th class="text-nowrap text-center" onclick="sortTable(0)">24.5</th>
        <th class="text-nowrap text-center" onclick="sortTable(0)">25</th>
        <th class="text-nowrap text-center" onclick="sortTable(0)">25.5</th>
        <th class="text-nowrap text-center" onclick="sortTable(0)">26</th>
        <th class="text-nowrap text-center" onclick="sortTable(0)">26.5</th>
        <th class="text-nowrap text-center" onclick="sortTable(0)">27</th>
        <th class="text-nowrap text-center" onclick="sortTable(0)">27.5</th>
        <th class="text-nowrap text-center" onclick="sortTable(0)">28</th>
        <th class="text-nowrap text-center" onclick="sortTable(0)">28.5</th>
        <th class="text-nowrap text-center" onclick="sortTable(0)">29</th>
        <th class="text-nowrap text-center" onclick="sortTable(0)">29.5</th>
        <th class="text-nowrap text-center" onclick="sortTable(0)">30</th>

        `;

      $(".encabezados").html(head);
    }

    const postData = {
      categoria: categoria
    };

    $.post("../Controllers/inventario.php", postData, function(response) {
      $("#cuerpo").html("");
      let datos = JSON.parse(response);
      let template = null;
      $.each(datos, function(i, item) {
        for (i = 0; i < item.length; i++) {
          if (item[i] === null) {
            item[i] = "";
          }
        }
        if (categoria === "Ropa") {
          template = `
        <tr id ="${item[7]}">
        <td>${item[0]}</td>
        <td><img src="${item[1]}"></td>
        <td>${item[2]}</td>
        <td>${item[3]}</td>
        <td>${item[5]}</td>
        <td class="XXL"></td>
        <td class="XL"></td>
        <td class="L"></td>
        <td class="M"></td>
        <td class="S"></td>
        <td class="XS"></td>
        <td class="XXS"></td>
       </tr> `;
          $("#cuerpo").append(template);
          let talla = item[4].split(",");
          let cantidades = item[6].split(",");
          for (i = 0; i < talla.length; i++) {
             hijo = $("#" + item[7]).find("." + talla[i]);
             hijo.html(cantidades[i]);
          }
         
         
        } else if (categoria === "Zapatos") {
          template = `
        <tr id ="${item[7]}">
        <td>${item[0]}</td>
        <td><img src="${item[1]}"></td>
        <td>${item[2]}</td>
        <td>${item[3]}</td>
        <td>${item[5]}</td>
        <td class="10"></td>
        <td class="11"></td>
        <td class="115"></td>
        <td class="12"></td>
        <td class="125"></td>
        <td class="13"></td>
        <td class="135"></td>
        <td class="14"></td>
        <td class="145"></td>
        <td class="15"></td>
        <td class="155"></td>
        <td class="16"></td>
        <td class="165"></td>
        <td class="17"></td>
        <td class="175"></td>
        <td class="18"></td>
        <td class="185"></td>
        <td class="19"></td>
        <td class="195"></td>
        <td class="20"></td>
        <td class="205"></td>
        <td class="21"></td>
        <td class="215"></td>
        <td class="22"></td>
        <td class="225"></td>
        <td class="23"></td>
        <td class="235"></td>
        <td class="24"></td>
        <td class="245"></td>
        <td class="25"></td>
        <td class="255"></td>
        <td class="26"></td>
        <td class="265"></td>
        <td class="27"></td>
        <td class="275"></td>
        <td class="28"></td>
        <td class="285"></td>
        <td class="29"></td>
        <td class="295"></td>
        <td class="30"></td>
        </tr> `;

         $("#cuerpo").append(template);
          let talla = item[4].split(".");
          let tallasplit = "";
          for (i = 0; i < talla.length; i++) {
            tallasplit += talla[i];
          }
          // console.log(tallasplit);

        /*   $("#cuerpo").append(template);
          hijo = $("#" + item[7]).find("." + medida);
          hijo.html(item[6]);
 */

        
          talla = tallasplit.split(",");
          let cantidades = item[6].split(",");
          for (i = 0; i < talla.length; i++) {
            hijo = $("#" + item[7]).find("." + talla[i]);
             hijo.html(cantidades[i]);
          } 
        }
      });
    });
  });
});
