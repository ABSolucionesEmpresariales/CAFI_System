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
