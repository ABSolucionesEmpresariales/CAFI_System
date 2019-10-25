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


    public function consultaPreparada($datos, $consulta, $accion, $datatipe, $reestructurar_arreglo)
    {

        if ($reestructurar_arreglo === true) {
            //se cambia el elemento que esta en la posicion 1 del array a la ultima posicion para hacer update
            for ($i = 0; $i < sizeof($datos) - 1; $i++) {
                if ($i === 0) {
                    $temporal = $datos[$i];
                }
                $datos[$i] = $datos[$i + 1];
            }
            $datos[$i] = $temporal;
        }

        $stmt = $this->con->prepare($consulta);

        $args = array(&$datatipe);
        for ($i = 0; $i < sizeof($datos); $i++) {
            $datos[$i] = Conexion::eliminar_simbolos($datos[$i]);
            $args[] = &$datos[$i];
        }

        call_user_func_array(array($stmt, 'bind_param'), $args);
        //accion 1 para insertar y para actualizar
        if ($accion === 1) {
            if ($stmt->execute()) {
                $mensaje = "1";
            } else {
                $mensaje = "0";
            }
            return $mensaje;
        } else if ($accion == 2) {
            //accion 2 para retornar datos en una matriz
            $stmt->execute();
            return mysqli_fetch_all($stmt->get_result());
        }
    }
    public function optenerId()
    {
        return $this->con->insert_id;
    }
    public function eliminar_simbolos($string)
    {
        $string = trim($string);
        $string = str_replace(
            array('à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
            array('a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
            $string
        );

        $string = str_replace(
            array('è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
            array('e', 'e', 'e', 'E', 'E', 'E', 'E'),
            $string
        );

        $string = str_replace(
            array('ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
            array('i', 'i', 'i', 'I', 'I', 'I', 'I'),
            $string
        );

        $string = str_replace(
            array('ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
            array('o', 'o', 'o', 'O', 'O', 'O', 'O'),
            $string
        );

        $string = str_replace(
            array('ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
            array('u', 'u', 'u', 'U', 'U', 'U', 'U'),
            $string
        );

        $string = str_replace(
            array('ñ', 'Ñ', 'ç', 'Ç'),
            array('n', 'N', 'c', 'C',),
            $string
        );

        $string = str_replace(
            array(
                "\\", "¨", "º", "~",
                "|", "!", "\"",
                "·", "$", "&",
                "(", ")", "?", "'", "¡",
                "¿", "[", "^", "<code>", "]",
                "+", "}", "{", "¨", "´",
                ">", "< ", ";", ",", ":",
                "''"
            ),
            '',
            $string
        );
        return $string;
    }

    public function obtenerDatosDeTabla($sql)
    {
        return mysqli_fetch_all($this->con->query($sql));
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


    public function __destruct()
    {
        $this->con->close();
    }
}
