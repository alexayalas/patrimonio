<?php
// Creacion de mis helpers personalizados
use Carbon\Carbon;

function FormatFecDMY($valor) {
    $fecha = explode("/", $valor);          
    $formato = empty($valor) ? null : Carbon::create($fecha[2],$fecha[1],$fecha[0]);
	return $formato;
}