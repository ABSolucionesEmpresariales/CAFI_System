<?php
$rutaCer = "Dueno1/SATDocs/cacx7605101p8.cer";//Obtener la ruta del ceritifcado de acuerdo al usuario (dueno) que esta logeado.
$rutaKey = "Dueno1/SATDocs/Claveprivada_FIEL_CACX7605101P8_20190528_152826.key";

//NO. DE CERTIFICADO
$cer = shell_exec('openssl x509 -inform DER -in '.$rutaCer.' -noout -serial');
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

echo $noCertificado;

//CERTIFICADO
shell_exec('openssl x509 -in '.$rutaCer.' -inform DER -out '.basename($rutaCer).'.pem -outform PEM');//Donde dice basename tenemos que obtner el nombre del archivo del directorio
openssl_x509_export(openssl_x509_read(file_get_contents(basename($rutaCer).".pem")), $certificadoPEM, TRUE);//Aqui en el primer parametro debemos especificar la ruta donde se guardo el archivo PEM.
$cerArray = explode("-----", $certificadoPEM);//Limpiar certificado de las etiquetas -----BEGIN CERTIFICATE----- y -----END CERTIFICATE-----
$certificado = $cerArray[2];

//echo $certificado;

//CADENA ORIGINAL
$xmlFile="Dueno1/Facturas/2/2.xml";
$xslFile = "XSL.xslt";
$xml = new DOMDocument("1.0","UTF-8");
$xml->load($xmlFile);
$xsl = new DOMDocument();
$xsl->load($xslFile);
$proc = new XSLTProcessor;
error_reporting(E_ALL ^ E_WARNING);//Desactivamos los Warnings de PHP para que solo se muestre la cadena original y se borre toda la cagada de PHP.
$proc->importStyleSheet($xsl);
$cadenaOriginal = $proc->transformToXML($xml);
$file = 'cadena_original.txt';
file_put_contents($file, $cadenaOriginal);

//echo $cadenaOriginal;
error_reporting(-1);//Volvemos a activar los Warnings de PHP para debuggear.

//SELLADO
shell_exec('openssl pkcs8 -inform DER -in '.$rutaKey.' -passin pass:12345678a -out '.basename($rutaKey).'.pem');
shell_exec('openssl dgst -sha256 -sign '.basename($rutaKey).'.pem -out "digest.txt" "cadena_original.txt"');
shell_exec('openssl enc -in "digest.txt" -out "sello.txt" -base64 -A -K '.basename($rutaKey).'.pem');

//$sello = readfile('sello.txt');
//echo $sello;