<?php

namespace Models;

class Fecha
{
    private $fecha, $hora;

    public function __construct()
    {
        date_default_timezone_set("America/Mexico_City");

        $año = date("Y");
        $mes = date("m");
        $dia = date("d");

        $this->fecha = $año . "-" . $mes . "-" . $dia;

        $hora = date("H");
        $minuto = date("i");
        $segundo = date("s");
        $this->hora = $hora . ":" . $minuto . ":" . $segundo;
    }
    public function getFecha()
    {
        return $this->fecha;
    }
    public function getHora()
    {
        return $this->hora;
    }
    public function getFechaVencimientoSuscripcion($tiempo_suscripcion)
    {
        if ($tiempo_suscripcion === "mes") {
            $descomposicion = explode("-", $this->fecha);
            $year = intval($descomposicion[0]);
            $mes = intval($descomposicion[1]);
            $mes = $mes + 1;
            $dias = intval($descomposicion[2]);
            $número_dias = cal_days_in_month(CAL_GREGORIAN, $mes, $year);

            if ($dias > $número_dias) {
                $fecha_vencimiento = $year . "-" . $mes . "-" . $número_dias;
            } else {
                $fecha_vencimiento = $year . "-" . $mes . "-" . $dias;
                $fecha_vencimiento;
            }
                
        } else {
            $descomposicion = explode("-", $this->fecha);
            $year = intval($descomposicion[0]);
            $year = $year + 1;
            $mes = intval($descomposicion[1]);
            $dias = $descomposicion[2];
            $número_dias = cal_days_in_month(CAL_GREGORIAN, $mes, $year);

            if ($número_dias === 28 && $dias === "29") {
                $fecha_vencimiento = $year . "-" . $mes . "-" . "28";
            } else {
                $fecha_vencimiento = $year . "-" . $mes . "-" . $dias;
            }
        }
        return $fecha_vencimiento;
    }
}
