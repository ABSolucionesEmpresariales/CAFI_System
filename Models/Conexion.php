<?php

namespace Models;

class Conexion
{

    private $datos = array(
        "host" => "localhost",
        "user" => "root",
        "pass" => "",
        "db" => "cafi_db"

    );

    public $con;
    private $datatipe;

    public function __construct()
    {
        $this->con = new \mysqli(
            $this->datos['host'],
            $this->datos['user'],
            $this->datos['pass'],
            $this->datos['db']
        );

        /* Comprueba la conexión */

        if ($this->con->connect_errno) {
            printf("Connect failed: %s\n", $this->con->connect_error);
            exit();
        }
    }


    public function consultaPreparada($datos,$consulta,$accion){
       
        for ($i = 0; $i < sizeof($datos); $i++) {
            
            if (gettype($datos[$i]) === "string") {
                $this->datatipe .= "s";
            }
            if (gettype($datos[$i]) === "double") {
                $this->datatipe .= "d";
            }
            if (gettype($datos[$i]) === "integer") {
                $this->datatipe .= "i";
            }
        }

        $datatipe = $this->datatipe;
        $valCount = count($datos);
        
        $stmt = $this->con->prepare($consulta);
        
        $args = array(&$datatipe);
        for ($i = 0; $i < $valCount; $i++) {
            $args[] = &$datos[$i];
        }
       
        call_user_func_array( array($stmt,'bind_param'), $args);
        
        if($accion == 1){
            $stmt->execute();
        }else{
            $stmt->execute();
            return mysqli_fetch_all($stmt->get_result());
        }
        
        
        

    }
   public function eliminar_simbolos($string){
        $string = trim($string);
        $string = str_replace(
            array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
            array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
            $string
        );
     
        $string = str_replace(
            array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
            array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
            $string
        );
     
        $string = str_replace(
            array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
            array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
            $string
        );
     
        $string = str_replace(
            array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
            array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
            $string
        );
     
        $string = str_replace(
            array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
            array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
            $string
        );
     
        $string = str_replace(
            array('ñ', 'Ñ', 'ç', 'Ç'),
            array('n', 'N', 'c', 'C',),
            $string
        );
     
        $string = str_replace(
            array("\\", "¨", "º", "~",
                 "|", "!", "\"",
                 "·", "$", "%", "&",
                 "(", ")", "?", "'", "¡",
                 "¿", "[", "^", "<code>", "]",
                 "+", "}", "{", "¨", "´",
                 ">", "< ", ";", ",", ":",
                "''"," ","#"),
            ' ',
            $string
        );
    return $string;
    } 

    public function obtenerDatosDeTabla($sql)
    {
        $result = $this->con->query($sql);
        return $result;
    }


    public function consultaSimple($sql)
    {
        $this->con->query($sql);
        return $this->con->affected_rows;
    }
    public function consultaListar($sql)
    {
        return $this->con->query($sql);
    }
    
    public function cerrarConexion()
    {
        $this->con->close();
    }
    
    public function consultaRetorno($sql)
    {
        $datos = $this->con->query($sql);
        $row = mysqli_fetch_assoc($datos);
        return $row;
    }

    

}
