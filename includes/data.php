<?php
	setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
	$fuso_horario = 3;
	$fuso_horario = -($fuso_horario*3600);
	date_default_timezone_set('America/Sao_Paulo');
	$time = time();
	$hora = date('G');
	$minuto = date('i');
	$segundos = date('s');
	$dia = date('d');
	$mes = date('m');
	$ano = date('Y');
	$data = $dia."/".$mes."/".$ano;
	// $data_30dias_anterior = date("d/m/Y", strtotime(str_replace("/", "-", $data) . "-30 days"));
	$horario = $hora."h".$minuto."m".$segundos."s";
	$data_completa = $data." - ".$horario;
?>