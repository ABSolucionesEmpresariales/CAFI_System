 <div id="mensaje" style="text-align: center; margin: 10px; font-weight: bold;"></div>
            <div class="d-block d-lg-flex row">
              <div class="col-lg-6 ocultar">
                <h5 class="importante">Email:</h5>
                <input id="email" class="form form-control" onkeypress="return check(event)" type="email" name="Temail" placeholder="email" autocomplete="new-password" required> <br>
              </div>
              <div class="col-lg-6">
                <h5 class="importante">Nombre:</h5>
                <input id="nombre" class="form form-control" onkeypress="return check(event)" type="text" name="Tnombre" placeholder="Nombre" autocomplete="new-password" required> <br>
              </div>
            </div>
            <div class="d-block d-lg-flex row">
              <div class="col-lg-6">
                <h5 class="importante">Teléfono:</h5>
                <input id="telefono" class="form form-control" type="text" onkeypress="return check(event)" name="Ttelefono" placeholder="Teléfono" autocomplete="new-password" required><br>
              </div>
              <div class="col-lg-6">
                <h5 class="importante">Acceso:</h5>
                <select class="form form-control" id="acceso" name="Sacceso" required>
                  <option value="Employe">Empleado</option>
                  <option value="Manager">Manager</option>
                </select> <br>
              </div>
            </div>
            <div class="d-block d-lg-flex row">
              <div id="divpass" class="col-lg-6">
                <h5 class="importante">Contraseña:</h5>
                <input id="contrasena" class="form form-control" type="password" name="Pcontrasena" placeholder="Contraseña" autocomplete="new-password" required><br>
              </div>
            </div>
            <div class="d-block d-lg-flex row">
              <div class="col-lg-6">
                <h5 class="general">Codigo Postal:</h5>
                <input id="cp" class="form form-control" onkeypress="return check(event)" type="text" name="Tcp" placeholder="Código postal" autocomplete="new-password"><br>
              </div>
              <div class="col-lg-6">
                <h5 class="general">Calle y número:</h5>
                <input id="calle_numero" class="form form-control" onkeypress="return check(event)" type="text" name="Tcalle_numero" placeholder="Calle y número" autocomplete="new-password"> <br>
              </div>
            </div>
            <div class="d-block d-lg-flex row">
              <div class="col-lg-6">
                <h5 class="general">Colonia:</h5>
                <input id="colonia" class="form form-control" type="text" onkeypress="return check(event)" name="Tcolonia" placeholder="Colonia" autocomplete="new-password"><br>
              </div>
              <div class="col-lg-6">
                <h5 class="importante">Localidad:</h5>
                <input id="Tlocalidad" list="localidad" class="form form-control" name="DLlocalidad" onkeypress="return check(event)"  autocomplete="new-password" required>
                <datalist id="localidad">
                </datalist><br>
              </div>
            </div>
            <div class="d-block d-lg-flex row">
              <div class="col-lg-6">
                <h5 class="general">Municipio:</h5>
                <input id="municipio" class="form form-control" type="text" onkeypress="return check(event)" name="Tmunicipio" placeholder="Municipio" autocomplete="new-password"><br>
              </div>
              <div class="col-lg-6">
                <h5 class="general">Estado:</h5>
                <select class="form form-control" id="estado" name="Sestado">
                  <option value="">Elegir</option>
                  <option value="Aguascalientes">Aguascalientes</option>
                  <option value="Baja California">Baja California </option>
                  <option value="Baja California Sur">Baja California Sur</option>
                  <option value="Campeche">Campeche</option>
                  <option value="Chiapas">Chiapas</option>
                  <option value="Chihuahua">Chihuahua</option>
                  <option value="Ciudad de México">Ciudad de México</option>
                  <option value="Coahuila de Zaragoza">Coahuila</option>
                  <option value="Colima">Colima</option>
                  <option value="Durango">Durango</option>
                  <option value="México">México</option>
                  <option value="Guanajuato">Guanajuato</option>
                  <option value="Guerrero">Guerrero</option>
                  <option value="Hidalgo">Hidalgo</option>
                  <option value="Jalisco">Jalisco</option>
                  <option value="Michoacán de Ocampo">Michoacán</option>
                  <option value="Morelos">Morelos</option>
                  <option value="Nayarit">Nayarit</option>
                  <option value="Nuevo León">Nuevo León</option>
                  <option value="Oaxaca">Oaxaca</option>
                  <option value="Puebla">Puebla</option>
                  <option value="Querétaro">Querétaro</option>
                  <option value="Quintana Roo">Quintana Roo</option>
                  <option value="San Luis Potosí">San Luis Potosí</option>
                  <option value="Sinaloa">Sinaloa</option>
                  <option value="Sonora">Sonora</option>
                  <option value="Tabasco">Tabasco</option>
                  <option value="Tamaulipas">Tamaulipas</option>
                  <option value="Tlaxcala">Tlaxcala</option>
                  <option value="Veracruz de Ignacio de la Llave">Veracruz</option>
                  <option value="Yucatán">Yucatán</option>
                  <option value="Zacatecas">Zacatecas</option>
                </select> <br>
              </div>
            </div>
            <div class="d-block d-lg-flex row">
              <div class="col-lg-6">
                <h5 class="general">Sexo:</h5>
                <select class="form form-control" id="sexo" name="Ssexo">
                  <option value="">Elegir</option>
                  <option value="M">Masculino</option>
                  <option value="F">Femenino</option>
                </select> <br>
              </div>
              <div class="col-lg-6">
                <h5 class="general">RFC:</h5>
                <input id="rfc" class="form form-control" onkeypress="return check(event)" type="text" name="Trfc" placeholder="rfc" autocomplete="new-password"> <br>
              </div>
            </div>

            <div class="d-block d-lg-flex row">
              <div class="col-lg-6">
                <h5 class="general">Fecha de nacimiento:</h5>
                <input id="fecha_nacimiento" class="form form-control" type="date" onkeypress="return check(event)" name="Dfecha_nacimiento" placeholder="Fecha de nacimiento" autocomplete="new-password"><br>
              </div>
            </div>

            <input id="bclose" type="submit" class="mt-3 btn bg-dark text-white btn-lg btn-block" value="Guardar">