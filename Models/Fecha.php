<?php
namespace Models;
class Fecha
{
    public function __construct()
    {
        date_default_timezone_set("America/Mexico_City");
    }
    function getFecha(){
        $año = date("Y");
        $mes = date("m");
        $dia = date("d");
        return $año . "-" . $mes . "-" . $dia;
    }
    function getHora(){
  
        $hora = date("H");
        $minuto = date("i");
        $segundo = date("s");
        return $hora . ":" . $minuto . ":" . $segundo;
    }
}