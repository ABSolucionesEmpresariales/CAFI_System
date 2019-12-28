<?php
    if(isset($_FILES['cer']) && isset($_FILES['key'])){
      $errors = array();
      
      $cer_name = $_FILES['cer']['name'];
      $cer_size = $_FILES['cer']['size'];
      $cer_tmp = $_FILES['cer']['tmp_name'];
      $cer_ext = strtolower(end(explode('.',$_FILES['cer']['name'])));

      $key_name = $_FILES['key']['name'];
      $key_size = $_FILES['key']['size'];
      $key_tmp = $_FILES['key']['tmp_name'];
      $key_ext = strtolower(end(explode('.',$_FILES['key']['name'])));
      
      $extensions = array("cer","key");
      
      if($cer_ext != "cer" || $key_ext != "key"){
        $errors[]="Extension no permitida, por favor elige un archivo .cer o .key";
      }
      
      if($cer_size > 4000 || $key_size > 4000){
        $errors[]='El archivo no debe exceder los 4kb';
      }
      
      if(empty($errors) == true){
        //Una vez que se compruebe que los archivos son los adecuados se procesan.
        move_uploaded_file($cer_tmp,"cache/".$cer_name);
        move_uploaded_file($key_tmp,"cache/".$key_name);

        //NO. DE CERTIFICADO
        $cer = shell_exec('openssl x509 -inform DER -in cache/'.$cer_name.' -noout -serial');
        $cerExpl = explode("=", $cer);
        $serial = end($cerExpl);
        $noCertificado = "";
        $var_arr = array();
        for ($i = 0; $i < mb_strlen($serial); $i++){
            if($i%2 == 1){
                $char = mb_substr($serial, $i, 1);
                $noCertificado .=  $char;
            }
        }

        //echo $noCertificado;//Guardar No. de certificado en la base de datos.

        //CERTIFICADO
        shell_exec('openssl x509 -in cache/'.$cer_name.' -inform DER -out cache/'.$cer_name.'.pem -outform PEM');//Donde dice basename tenemos que obtner el nombre del archivo del directorio
        openssl_x509_export(openssl_x509_read(file_get_contents("cache/".$cer_name.".pem")), $certificadoPEM, TRUE);//Aqui en el primer parametro debemos especificar la ruta donde se guardo el archivo PEM.
        $cerArray = explode("-----", $certificadoPEM);//Limpiar certificado de las etiquetas -----BEGIN CERTIFICATE----- y -----END CERTIFICATE-----
        $certificado = $cerArray[2];
    
        //echo $certificado;//Guardar certificado en la base de datos.

        //OBTENER ARCHIVO .key.pem Y GUARDARLO
        shell_exec('openssl pkcs8 -inform DER -in cache/'.$key_name.' -passin pass:12345678a -out SATDocs/'.$key_name.'.pem');

        //BORRAR ARCHIVOS .cer, .key, y .cer.pem.
        unlink("cache/".$cer_name);
        unlink("cache/".$key_name);
        unlink("cache/".$cer_name.".pem");

        echo "Archivos subidos exitosamente!";
      }else{
        print_r($errors);
      }
   }
?>
<html>
  <body>
    <form action="" method="POST" enctype="multipart/form-data">
      <input type="file" name="cer" />
      <input type="file" name="key" />
      <input type="submit"/>
    </form>
  </body>
</html>