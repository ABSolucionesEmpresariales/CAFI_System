<?php 

    
    function subir_archivo($nombre, $accion){

                    if($accion == 1){
                                $tipo_imagen = $_FILES[$nombre]['type'];
                                //se optine la extencion de la imagen
                                $bytes = $_FILES[$nombre]['size'];
                                //se optiene el tamaño de la imagen
                                if ($bytes <= 1000000) {
                                    //si la imagen es menor a 1 mega se comprueba la extencion, si la extencion es igual a alguna de la condiconal se registra la imagen
                                    if ($tipo_imagen == "image/jpg" || $tipo_imagen == 'image/jpeg' || $tipo_imagen == 'image/png') {
                                                $temp = explode(".", $_FILES[$nombre]["name"]);
                                                $newfilename = round(microtime(true)) . '.' . end($temp);
                                                $imagen2 = $_SERVER['DOCUMENT_ROOT']."/CAFI_System"."/"."img/"."productos/".$newfilename."";
                                                if(move_uploaded_file($_FILES[$nombre]["tmp_name"],$imagen2)){
                                                    return $imagen2;
                                                }else{
                                                    return "Error";
                                                }
                                    }else{
                                        echo "imagenNoValida";
                                    }
                                }else{
                                    echo "imagenGrande";
                                }
                    }else{
                        $temp = explode(".", $_FILES[$nombre]["name"]);
                        $newfilename = round(microtime(true)) . '.' . end($temp);
                        $imagen2 = $_SERVER['DOCUMENT_ROOT']."/"."archivos/".$newfilename."";
                        if(move_uploaded_file($_FILES[$nombre]["tmp_name"],"archivos/".$newfilename)){
                            return $imagen2;
                        }else{
                            return 0;
                        }
                }
            
    
    }

    function diferencia_de_fechas($fecha_inicio,$fecha_fin){
        //Indice 0 son años
        //indice 1 Meses
        //Indice 2 Dias
        //Indice 11 = a todos los dias transcurridos
    
        $fecha1 = date_create($fecha_inicio);
        $fecha2 = date_create($fecha_fin);
        $intervalo = date_diff($fecha1,$fecha2);
    
        $tiempo = array();
    
        foreach($intervalo as $valor){
            $tiempo[] = $valor;
        }
        return $tiempo;
    
    }


 

?>