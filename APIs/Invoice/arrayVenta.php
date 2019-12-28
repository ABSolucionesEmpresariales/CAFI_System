<?php

/* $datos_venta_total = array(
    array("167ABC","2017-10-30T09:09:23","2269400","1436012.00","I","01","PUE","CONDICIONES","0.00","1","45079"),
    array("01","LAHH850905BZ4","HORACIO LLANOS","608","A39DA66B-52CA-49E3-879B-5C05185B0EF7"),
    array("HEPR930322977","RAFAEL ALEJANDRO HERNÁNDEZ PALACIOS","G01"),
    array(
        array("2250000","002","Tasa","0.160000","360000","01010101","F52","00001","1.5","TONELADA","ACERO","1500000","2250000"),
        array("2250000","002","Tasa","0.160000","360000","01010101","F52","00001","1.5","TONELADA","ACERO","1500000","2250000"),
        array("2250000","002","Tasa","0.160000","360000","01010101","F52","00001","1.5","TONELADA","ACERO","1500000","2250000")
        ),
    array("002","2720","002","Tasa","0.160000","363104"),
    array("5CB8D806-7BDF-4D24-AC4C-4C469EB4F57A","2017-10-31T17:39:42","SFE0807172W7")
    ); */



    function estructurar_Arrays($datos_venta_total){

    $etiqueta_traslado_atributos = array("Base","Impuesto","TipoFactor","TasaOCuota","Importe",
    "cfdi:Traslado","cfdi:Traslados","ClaveProdServ","ClaveUnidad","NoIdentificacion","Cantidad",
    "Unida","Descripcion","ValorUnitario","Importe","cfdi:Impuestos");

    $primera_etiqueta = array();
    $segunda_etiqueta_relacionados = array();
    $tercera_etiqueta_emisor = array();
    $cuarta_etiqueta_receptor = array();
    $quinta_etiqueta_impuestos = array();
    $sexta_etiqueta_complemento = array();
    
    $datos_traslado_producto = array();
    $datos_traslados = array();
    $datos_Concepto = array();
    $datos_cfdi_Concepto = array();
    $datos_concepto_final = array();

        for($u = 0; $u < count($datos_venta_total); $u++){
            if($u == 0){
                $primera_etiqueta = [
                                    "xmlns:cfdi" => "http://www.sat.gob.mx/cfd/3", 
                                    "xmlns:xsi" => "http://www.w3.org/2001/XMLSchema-instance", 
                                    "xsi:schemaLocation" => "http://www.sat.gob.mx/cfd/3 http://www.sat.gob.mx/sitio_internet/cfd/3/cfdv33.xsd", 
                                    "Version" => "3.3", 
                                    "Serie" => "A", 
                                    "Folio" => $datos_venta_total[$u][0], 
                                    "Fecha" => $datos_venta_total[$u][1], 
                                    "Sello" => "", 
                                    "NoCertificado" => "", 
                                    "Certificado" => "", 
                                    "SubTotal" => $datos_venta_total[$u][2], 
                                    "Moneda" => "MXN", 
                                    "Total" => $datos_venta_total[$u][3], 
                                    "TipoDeComprobante" => $datos_venta_total[$u][4],
                                    "FormaPago" => $datos_venta_total[$u][5], 
                                    "MetodoPago" => $datos_venta_total[$u][6], 
                                    "CondicionesDePago" => $datos_venta_total[$u][7], 
                                    "Descuento" => $datos_venta_total[$u][8], 
                                    "TipoCambio" => $datos_venta_total[$u][9], 
                                    "LugarExpedicion" => $datos_venta_total[$u][10],
                                ];
            }else if($u == 1){
                $segunda_etiqueta_relacionados = [
                    "TipoRelacion" => $datos_venta_total[$u][0],
                    "cfdi:CfdiRelacionado" => 
                        array(
                            "UUID" => $datos_venta_total[$u][4])
                    ];
            $tercera_etiqueta_emisor = [
                    "Rfc" => $datos_venta_total[$u][1], 
                    "Nombre" => $datos_venta_total[$u][2], 
                    "RegimenFiscal" => $datos_venta_total[$u][3]];
                        
            }else if($u == 2){
                $cuarta_etiqueta_receptor = [
                        "Rfc" => $datos_venta_total[$u][0], 
                        "Nombre" => $datos_venta_total[$u][1], 
                        "RegimenFiscal" => $datos_venta_total[$u][3]];
            }else if($u == 3){
                for($i = 0; $i < count($datos_venta_total[$u]); $i++){
                    for($y =0; $y < count($datos_venta_total[$u][$i])+3; $y++){
                        
                        if($etiqueta_traslado_atributos[$y] == "cfdi:Traslado"){
                            $datosTotal = array($etiqueta_traslado_atributos[$y] => $datos_traslado_producto);
                        }
                        if($etiqueta_traslado_atributos[$y] == "cfdi:Traslados"){
                            $datos_traslados = array("cfdi:Traslados" => $datosTotal);
                        }
                        if($y >= 7){
                            if($etiqueta_traslado_atributos[$y] == "cfdi:Impuestos"){
                                $datos_Concepto += [$etiqueta_traslado_atributos[$y] => $datos_traslados];
                            }else{
                               $datos_Concepto += [$etiqueta_traslado_atributos[$y] => $datos_venta_total[$u][$i][($y-2)]];
                            }
                        }
                        $datos_traslado_producto += [$etiqueta_traslado_atributos[$y] => $datos_venta_total[$u][$i][$y]];
                    }
            $datos_cfdi_Concepto += ["cfdi:Concepto_$i" =>  $datos_Concepto];
        }
        
            }else if($u == 4){
                $quinta_etiqueta_impuestos = [
                    "cfdi:Retenciones" => 
                            array(
                                "cfdi:Retencion" => 
                                    array(
                                        "Impuesto" => $datos_venta_total[$u][0],
                                        "Importe" => $datos_venta_total[$u][1]
                                    )
                            ),
                        "cfdi:Traslados" => 
                            array(
                                "cfdi:Traslado" => 
                                    array(
                                        "Impuesto" => $datos_venta_total[$u][2],
                                        "TipoFactor" => $datos_venta_total[$u][3],
                                        "TasaOCuota" => $datos_venta_total[$u][4],
                                        "Importe" => $datos_venta_total[$u][5]
                                        )
                                )];
            }else if($u == 5){
                $sexta_etiqueta_complemento = [
                    "tfd:TimbreFiscalDigital" => 
                        array(
                            "xmlns:tfd" => "http://www.sat.gob.mx/TimbreFiscalDigital",
                            "xsi:schemaLocation" => "http://www.sat.gob.mx/TimbreFiscalDigital http://www.sat.gob.mx/sitio_internet/cfd/TimbreFiscalDigital/TimbreFiscalDigitalv11.xsd",
                            "Version" => "1.1",
                            "UUID" => $datos_venta_total[$u][0],
                            "FechaTimbrado" => $datos_venta_total[$u][1],
                            "RfcProvCertif" => $datos_venta_total[$u][2],
                            "SelloCFD" => "",
                            "NoCertificadoSAT" => "",
                            "SelloSAT" => ""
                        )];
            }
        }

        $primera_etiqueta += ["cfdi:CfdiRelacionados" => $segunda_etiqueta_relacionados];
        $primera_etiqueta += ["cfdi:Emisor" => $tercera_etiqueta_emisor];
        $primera_etiqueta += ["cfdi:Receptor" => $cuarta_etiqueta_receptor];
        $primera_etiqueta += ["cfdi:Conceptos" => $datos_cfdi_Concepto];
        $primera_etiqueta += ["cfdi:Impuestos" => $quinta_etiqueta_impuestos];
        $primera_etiqueta += ["cfdi:Complemento" => $sexta_etiqueta_complemento];
        
        $estructura = array("cfdi:Comprobante" => $primera_etiqueta);
        return $estructura;
    }
