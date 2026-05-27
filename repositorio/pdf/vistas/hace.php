<?php
date_default_timezone_set('America/Mexico_City');

function obtenerPeriodo($fecha){
		$dia= conocerDiaSemanaFecha($fecha);
		$num = date("j", strtotime($fecha));
		$anno = date("Y", strtotime($fecha));
		$mes = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
		$mes = $mes[(date('m', strtotime($fecha))*1)-1];
		return $num.' de '.$mes;
	}

	function obtenerMesPrincipal($fecha){
			$dia= conocerDiaSemanaFecha($fecha);
			$num = date("j", strtotime($fecha));
			$anno = date("Y", strtotime($fecha));
			$mes = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
			$mes = $mes[(date('m', strtotime($fecha))*1)-1];
			return $mes;
		}
	function obtenerFechaImpresion($fecha){
			$dia= conocerDiaSemanaFecha($fecha);
			$num = date("j", strtotime($fecha));
			$anno = date("Y", strtotime($fecha));
			$mes = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
			$mes = $mes[(date('m', strtotime($fecha))*1)-1];
			return $mes.' de '.$anno;
		}

		function fec_Mes($fecha){
				$dia= conocerDiaSemanaFecha($fecha);
				$num = date("j", strtotime($fecha));
				$anno = date("Y", strtotime($fecha));
				$mes = array('ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE');
				$mes = $mes[(date('m', strtotime($fecha))*1)-1];
				return $mes.' DEL '.$anno;
			}

		function obtenerDiaPrincipal($fecha){
				$dia= conocerDiaSemanaFecha($fecha);
				$num = date("j", strtotime($fecha));
				$anno = date("Y", strtotime($fecha));
				$mes = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
				$mes = $mes[(date('m', strtotime($fecha))*1)-1];
				return $num.' de '.$mes;
			}

	function obtenerLetraN($numero){
		if($numero == 1){ $resultado = "PRIMER"; }
		if($numero == 2){ $resultado = "SEGUNDO"; }
		if($numero == 3){ $resultado = "TERCER"; }
		if($numero == 4){ $resultado = "CUARTO"; }
		if($numero == 5){ $resultado = "QUINTO"; }
		if($numero == 6){ $resultado = "SEXTO"; }
		if($numero == 7){ $resultado = "SÉPTIMO"; }
		if($numero == 8){ $resultado = "OCTAVO"; }
		if($numero == 9){ $resultado = "NOVENO"; }
		if($numero == 10){ $resultado = "DÉCIMO"; }
			return $resultado;
		}



function conocerDiaSemanaFecha($fecha) {
	$dias = array('Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado');
	$dia = $dias[date('w', strtotime($fecha))];
	return $dia;

}

function conocerDia($fecha) {
	$dias = array('DOMINGO', 'LUNES', 'MARTES', 'MIÉRCOLES', 'JUEVES', 'VIERNES', 'SÁBADO');
	$dia = $dias[date('w', strtotime($fecha))];
	return $dia;

}

function obtenerFechaEnLetraD($fecha){
		$dia= conocerDiaSemanaFecha($fecha);
		$num = date("j", strtotime($fecha));
		$anno = date("Y", strtotime($fecha));
		$mes = array('ene', 'feb', 'mar', 'abr', 'may', 'jun', 'jul', 'ago', 'sep', 'oct', 'nov', 'dic');
		$mes = $mes[(date('m', strtotime($fecha))*1)-1];
		return $dia.', '.$num.' de '.$mes.' de '.$anno;
	}

	function obtFechConst($fecha){
			$dia= conocerDiaSemanaFecha($fecha);
			$num = date("j", strtotime($fecha));
			$anno = date("Y", strtotime($fecha));
			$mes = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
			$mes = $mes[(date('m', strtotime($fecha))*1)-1];
			return $num.' de '.$mes.' de '.$anno;
	}

	function fechaLetra($fecha){
			$dia= conocerDia($fecha);
			$num = date("j", strtotime($fecha));
			$anno = date("Y", strtotime($fecha));
			$mes = array('ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE');
			$mes = $mes[(date('m', strtotime($fecha))*1)-1];
			return $dia.', '.$num.' DE '.$mes.' DE '.$anno;
		}
?>
