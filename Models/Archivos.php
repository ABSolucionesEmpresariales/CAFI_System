<?php 
class Archivos{

     function imagen($nombre){
        $tipo_imagen = $_FILES[$nombre]['type'];
        //se optine la extencion de la imagen
        $bytes = $_FILES[$nombre]['size'];
        //se optiene el tamaño de la imagen
        if ($bytes <= 1000000) {
            //si la imagen es menor a 1 mega se comprueba la extencion, si la extencion es igual a alguna de la condiconal se registra la imagen
            if ($tipo_imagen == "image/jpg" || $tipo_imagen == 'image/jpeg' || $tipo_imagen == 'image/png') {
                        $temp = explode(".", $_FILES[$nombre]["name"]);
                        $newfilename = round(microtime(true)) . '.' . end($temp);
                        $imagen2 = $_SERVER['DOCUMENT_ROOT']."/"."img/".$newfilename."";
                        if(move_uploaded_file($_FILES[$nombre]["tmp_name"],"img/".$newfilename)){
                            echo $imagen2;
                        }else{
                            echo "Error";
                        }
            }else{
                echo "imagenNoValida";
            }
        }else{
            echo "imagenGrande";
        }
    }
   
    
    function archivos($nombre){
        $temp = explode(".", $_FILES[$nombre]["name"]);
        $newfilename = round(microtime(true)) . '.' . end($temp);
        $imagen2 = $_SERVER['DOCUMENT_ROOT']."/"."archivos/".$newfilename."";
        if(move_uploaded_file($_FILES[$nombre]["tmp_name"],"archivos/".$newfilename)){
            echo $imagen2;
        }else{
            echo 0;
        }
    }
    
    public function subir_archivo($nombre, $accion){
    
            if (strlen($_FILES[$nombre]['tmp_name']) != 0) {
                    if($accion == 1){
                        if(!file_exists("img")){
                            mkdir('img',0777,true);
                            if(file_exists("img")){
                                echo imagen($nombre);
                            }
                        }else{
                            echo imagen($nombre);
                        }
                    }else{
                        if(!file_exists("archivos")){
                            mkdir('archivos',0777,true);
                            if(file_exists("archivos")){
                                echo archivos($nombre);
                            }
                    }else{
                        echo archivos($nombre);
                    }
                }
            }
    
    }

    public function diferencia_de_fechas($fecha_inicio,$fecha_fin){
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

}
 

?>