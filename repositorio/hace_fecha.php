<?php
date_default_timezone_set('America/Mexico_City');

function obtenerPeriodo($fecha)
{
	$dia = conocerDiaSemanaFecha($fecha);
	$num = date("j", strtotime($fecha));
	$anno = date("Y", strtotime($fecha));
	$mes = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
	$mes = $mes[(date('m', strtotime($fecha)) * 1) - 1];
	return $num . ' de ' . $mes;
}

function obtenerAsis($fecha)
{
	$dia = conocerDiaSemanaFecha($fecha);
	$num = date("j", strtotime($fecha));
	$anno = date("Y", strtotime($fecha));
	$mes = array('ENE', 'FEB', 'MAR', 'ABR', 'MAY', 'JUN', 'JUL', 'AGO', 'SEP', 'OCT', 'NOV', 'DIC');
	$mes = $mes[(date('m', strtotime($fecha)) * 1) - 1];
	return $num . '<br>' . $mes;
}

function obtenerMesPrincipal($fecha)
{
	$dia = conocerDiaSemanaFecha($fecha);
	$num = date("j", strtotime($fecha));
	$anno = date("Y", strtotime($fecha));
	$mes = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
	$mes = $mes[(date('m', strtotime($fecha)) * 1) - 1];
	return $mes;
}

function obtener_Mes($fecha)
{
	$mes = array('ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE');
	$mes = $mes[(date('m', strtotime($fecha)) * 1) - 1];
	return $mes;
}
function obtenerFechaImpresion($fecha)
{
	$dia = conocerDiaSemanaFecha($fecha);
	$num = date("j", strtotime($fecha));
	$anno = date("Y", strtotime($fecha));
	$mes = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
	$mes = $mes[(date('m', strtotime($fecha)) * 1) - 1];
	return $mes . ' de ' . $anno;
}

function obtenerFechaImpMAY($fecha)
{
	$dia = conocerDiaSemanaFecha($fecha);
	$num = date("j", strtotime($fecha));
	$anno = date("Y", strtotime($fecha));
	$mes = array('ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE');
	$mes = $mes[(date('m', strtotime($fecha)) * 1) - 1];
	return $mes . ' ' . $anno;
}

function obtenerDiaPrincipal($fecha)
{
	$dia = conocerDiaSemanaFecha($fecha);
	$num = date("j", strtotime($fecha));
	$anno = date("Y", strtotime($fecha));
	$mes = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
	$mes = $mes[(date('m', strtotime($fecha)) * 1) - 1];
	return $num . ' de ' . $mes;
}

function obtFechConst($fecha)
{
	$dia = conocerDiaSemanaFecha($fecha);
	$num = date("j", strtotime($fecha));
	$anno = date("Y", strtotime($fecha));
	$mes = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
	$mes = $mes[(date('m', strtotime($fecha)) * 1) - 1];
	return $num . ' de ' . $mes . ' de ' . $anno;
}

function fec_titulo($fecha)
{
	if (empty($fecha)) {
		return '';
	}

	$timestamp = strtotime((string) $fecha);

	if ($timestamp === false) {
		return '';
	}

	$num = date("j", $timestamp);
	$anno = date("Y", $timestamp);

	$meses = array(
		'Enero',
		'Febrero',
		'Marzo',
		'Abril',
		'Mayo',
		'Junio',
		'Julio',
		'Agosto',
		'Septiembre',
		'Octubre',
		'Noviembre',
		'Diciembre'
	);

	$mes = $meses[((int) date('m', $timestamp)) - 1];

	return $num . ' de ' . $mes . ' de ' . $anno;
}

function fecha_impre($fecha)
{
	$dia = conocerDiaSemanaFecha($fecha);
	$num = date("j", strtotime($fecha));
	$anno = date("Y", strtotime($fecha));
	$mes = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
	$mes = $mes[(date('m', strtotime($fecha)) * 1) - 1];
	return $num . ' días del mes de ' . $mes . ' de ' . $anno;
}

function obtFechMay($fecha)
{
	$dia = conocerDiaSemanaFecha($fecha);
	$num = date("j", strtotime($fecha));
	$anno = date("Y", strtotime($fecha));
	$mes = array('ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE');
	$mes = $mes[(date('m', strtotime($fecha)) * 1) - 1];
	return $num . ' DE ' . $mes . ' DE ' . $anno;
}

function obtener_periodo_ini($fecha)
{
	if (isset($fecha)) {
		$mes = array('ENE', 'FEB', 'MAR', 'ABR', 'MAY', 'JUN', 'JUL', 'AGO', 'SEP', 'OCT', 'NOV', 'DIC');
		$mes = $mes[(date('m', strtotime($fecha)) * 1) - 1];
		return $mes;
	} else {
		return '--';
	}
}
function obtener_periodo_fin($fecha)
{
	if (isset($fecha)) {
		$anno = date("Y", strtotime($fecha));
		$mes = array('ENE', 'FEB', 'MAR', 'ABR', 'MAY', 'JUN', 'JUL', 'AGO', 'SEP', 'OCT', 'NOV', 'DIC');
		$mes = $mes[(date('m', strtotime($fecha)) * 1) - 1];
		$anno = substr($anno, 2, 2);
		return $mes . ' ' . $anno;
	} else {
		return '--';
	}
}

function obtenerLetraN($numero)
{
	if ($numero == 1) {
		$resultado = "PRIMER";
	}
	if ($numero == 2) {
		$resultado = "SEGUNDO";
	}
	if ($numero == 3) {
		$resultado = "TERCER";
	}
	if ($numero == 4) {
		$resultado = "CUARTO";
	}
	if ($numero == 5) {
		$resultado = "QUINTO";
	}
	if ($numero == 6) {
		$resultado = "SEXTO";
	}
	if ($numero == 7) {
		$resultado = "SÉPTIMO";
	}
	if ($numero == 8) {
		$resultado = "OCTAVO";
	}
	if ($numero == 9) {
		$resultado = "NOVENO";
	}
	if ($numero == 10) {
		$resultado = "DÉCIMO";
	}
	return $resultado;
}

function promedio_letra_grp_nuevo($numero)
{
	$pieces = explode(".", $numero);
	$entero =  $pieces[0]; // piece1
	$decimal = $pieces[1]; // piece2


	if ($entero == 0) {
		$Letra = "CERO";
	} elseif ($entero == 1) {
		$Letra = "UNO";
	} elseif ($entero == 2) {
		$Letra = "DOS";
	} elseif ($entero == 3) {
		$Letra = "TRES";
	} elseif ($entero == 4) {
		$Letra = "CUATRO";
	} elseif ($entero == 5) {
		$Letra = "CINCO";
	} elseif ($entero == 6) {
		$Letra = "SEIS";
	} elseif ($entero == 7) {
		$Letra = "SIETE";
	} elseif ($entero == 8) {
		$Letra = "OCHO";
	} elseif ($entero == 9) {
		$Letra = "NUEVE";
	} elseif ($entero == 10) {
		$Letra = "DIEZ";
	}

	if ($decimal == 0) {
		$Letra2 = "CERO";
	} elseif ($decimal == 1) {
		$Letra2 = "UNO";
	} elseif ($decimal == 2) {
		$Letra2 = "DOS";
	} elseif ($decimal == 3) {
		$Letra2 = "TRES";
	} elseif ($decimal == 4) {
		$Letra2 = "CUATRO";
	} elseif ($decimal == 5) {
		$Letra2 = "CINCO";
	} elseif ($decimal == 6) {
		$Letra2 = "SEIS";
	} elseif ($decimal == 7) {
		$Letra2 = "SIETE";
	} elseif ($decimal == 8) {
		$Letra2 = "OCHO";
	} elseif ($decimal == 9) {
		$Letra2 = "NUEVE";
	}

	return $Letra . ' PUNTO ' . $Letra2;
}

function obtener_prom_letra($numero)
{
	if ($numero == 1) {
		$resultado = "UNO";
	}
	if ($numero == 2) {
		$resultado = "DOS";
	}
	if ($numero == 3) {
		$resultado = "TRES";
	}
	if ($numero == 4) {
		$resultado = "CUARTO";
	}
	if ($numero == 5) {
		$resultado = "CINCO";
	}
	if ($numero == 6) {
		$resultado = "SEIS";
	}
	if ($numero == 7) {
		$resultado = "SIETE";
	}
	if ($numero == 8) {
		$resultado = "OCHO";
	}
	if ($numero == 9) {
		$resultado = "NUEVE";
	}
	if ($numero == 10) {
		$resultado = "DIEZ";
	}
	if ($numero == 'NP') {
		$resultado = "NP";
	}
	return $resultado;
}

function obtenerGradox($numero)
{
	if ($numero == 1) {
		$resultado = "PRIMERO";
	}
	if ($numero == 2) {
		$resultado = "SEGUNDO";
	}
	if ($numero == 3) {
		$resultado = "TERCERO";
	}
	if ($numero == 4) {
		$resultado = "CUARTO";
	}
	if ($numero == 5) {
		$resultado = "QUINTO";
	}
	if ($numero == 6) {
		$resultado = "SEXTO";
	}
	if ($numero == 7) {
		$resultado = "SÉPTIMO";
	}
	if ($numero == 8) {
		$resultado = "OCTAVO";
	}
	if ($numero == 9) {
		$resultado = "NOVENO";
	}
	if ($numero == 10) {
		$resultado = "DÉCIMO";
	}
	return $resultado;
}

function obtenerGradox_minus($numero)
{
	if ($numero == 1) {
		$resultado = "primer";
	}
	if ($numero == 2) {
		$resultado = "segundo";
	}
	if ($numero == 3) {
		$resultado = "tercer";
	}
	if ($numero == 4) {
		$resultado = "cuarto";
	}
	if ($numero == 5) {
		$resultado = "quinto";
	}
	if ($numero == 6) {
		$resultado = "sexto";
	}
	if ($numero == 7) {
		$resultado = "séptimo";
	}
	if ($numero == 8) {
		$resultado = "octavo";
	}
	if ($numero == 9) {
		$resultado = "noveno";
	}
	if ($numero == 10) {
		$resultado = "décimo";
	}
	return $resultado;
}



function conocerDiaSemanaFecha($fecha)
{
	if (empty($fecha)) {
		return '';
	}

	$timestamp = strtotime((string) $fecha);

	if ($timestamp === false) {
		return '';
	}

	$dias = array('Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado');

	return $dias[date('w', $timestamp)];
}

function conocerDia($fecha)
{
	$dias = array('DOMINGO', 'LUNES', 'MARTES', 'MIÉRCOLES', 'JUEVES', 'VIERNES', 'SÁBADO');
	$dia = $dias[date('w', strtotime($fecha))];
	return $dia;
}

function obtenerFechaEnLetraD($fecha)
{
	$dia = conocerDiaSemanaFecha($fecha);
	$num = date("j", strtotime($fecha));
	$anno = date("Y", strtotime($fecha));
	$mes = array('ene', 'feb', 'mar', 'abr', 'may', 'jun', 'jul', 'ago', 'sep', 'oct', 'nov', 'dic');
	$mes = $mes[(date('m', strtotime($fecha)) * 1) - 1];
	return $dia . ', ' . $num . ' de ' . $mes . ' de ' . $anno;
}
function obtener_fecha_entera($fecha)
{
	$dia = conocerDiaSemanaFecha($fecha);
	$num = date("j", strtotime($fecha));
	$anno = date("Y", strtotime($fecha));
	$mes = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
	$mes = $mes[(date('m', strtotime($fecha)) * 1) - 1];
	return $dia . ', ' . $num . ' de ' . $mes . ' de ' . $anno;
}

function fechaLetra($fecha)
{
	$dia = conocerDia($fecha);
	$num = date("j", strtotime($fecha));
	$anno = date("Y", strtotime($fecha));
	$mes = array('ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE');
	$mes = $mes[(date('m', strtotime($fecha)) * 1) - 1];
	return $dia . ', ' . $num . ' DE ' . $mes . ' DE ' . $anno;
}


function letra_dia($numero)
{
	if ($numero == 1) {
		$Letra = "UNO";
	} elseif ($numero == 2) {
		$Letra = "DOS";
	} elseif ($numero == 3) {
		$Letra = "TRES";
	} elseif ($numero == 4) {
		$Letra = "CUATRO";
	} elseif ($numero == 5) {
		$Letra = "CINCO";
	} elseif ($numero == 6) {
		$Letra = "SEIS";
	} elseif ($numero == 7) {
		$Letra = "SIETE";
	} elseif ($numero == 8) {
		$Letra = "OCHO";
	} elseif ($numero == 9) {
		$Letra = "NUEVE";
	} elseif ($numero == 10) {
		$Letra = "DIEZ";
	} elseif ($numero == 11) {
		$Letra = "ONCE";
	} elseif ($numero == 12) {
		$Letra = "DOCE";
	} elseif ($numero == 13) {
		$Letra = "TRECE";
	} elseif ($numero == 14) {
		$Letra = "CATORCE";
	} elseif ($numero == 15) {
		$Letra = "QUINCE";
	} elseif ($numero == 16) {
		$Letra = "DIECISES";
	} elseif ($numero == 17) {
		$Letra = "DIECISIETE";
	} elseif ($numero == 18) {
		$Letra = "DIECIOCHO";
	} elseif ($numero == 19) {
		$Letra = "DIECINUEVE";
	} elseif ($numero == 20) {
		$Letra = "VEINTE";
	} elseif ($numero == 21) {
		$Letra = "VEINTIUNO";
	} elseif ($numero == 22) {
		$Letra = "VEINTIDOS";
	} elseif ($numero == 23) {
		$Letra = "VEINTITRES";
	} elseif ($numero == 24) {
		$Letra = "VEINTICUATRO";
	} elseif ($numero == 25) {
		$Letra = "VEINTICINCO";
	} elseif ($numero == 26) {
		$Letra = "VEINTISEIS";
	} elseif ($numero == 27) {
		$Letra = "VEINTISIETE";
	} elseif ($numero == 28) {
		$Letra = "VEINTIOCHO";
	} elseif ($numero == 29) {
		$Letra = "VEINTINUEVE";
	} elseif ($numero == 30) {
		$Letra = "TREINTA";
	} elseif ($numero == 31) {
		$Letra = "TREINTA Y UNO";
	}

	return $Letra;
}

function letra_mes($fecha)
{
	$num = date("j", strtotime($fecha));
	$anno = date("Y", strtotime($fecha));
	$mes = array('ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE');
	$mes = $mes[(date('m', strtotime($fecha)) * 1) - 1];
	return $mes;
}

function letra_mes_titulo($fecha)
{
	if (empty($fecha)) {
		return '';
	}

	$timestamp = strtotime((string) $fecha);

	if ($timestamp === false) {
		return '';
	}

	$meses = array(
		'Enero',
		'Febrero',
		'Marzo',
		'Abril',
		'Mayo',
		'Junio',
		'Julio',
		'Agosto',
		'Septiembre',
		'Octubre',
		'Noviembre',
		'Diciembre'
	);

	$mes = $meses[((int) date('m', $timestamp)) - 1];

	return $mes;
}

function fechaEnLetra($fecha)
{
	// Convertimos la fecha a formato YYYY-MM-DD si viene con / u otro formato
	$fecha = date('Y-m-d', strtotime($fecha));
	[$anio, $mes, $dia] = explode('-', $fecha);

	// Diccionarios
	$meses = [
		'01' => 'enero',
		'02' => 'febrero',
		'03' => 'marzo',
		'04' => 'abril',
		'05' => 'mayo',
		'06' => 'junio',
		'07' => 'julio',
		'08' => 'agosto',
		'09' => 'septiembre',
		'10' => 'octubre',
		'11' => 'noviembre',
		'12' => 'diciembre'
	];

	$numeros = [
		1 => 'uno',
		2 => 'dos',
		3 => 'tres',
		4 => 'cuatro',
		5 => 'cinco',
		6 => 'seis',
		7 => 'siete',
		8 => 'ocho',
		9 => 'nueve',
		10 => 'diez',
		11 => 'once',
		12 => 'doce',
		13 => 'trece',
		14 => 'catorce',
		15 => 'quince',
		16 => 'dieciséis',
		17 => 'diecisiete',
		18 => 'dieciocho',
		19 => 'diecinueve',
		20 => 'veinte',
		21 => 'veintiuno',
		22 => 'veintidós',
		23 => 'veintitrés',
		24 => 'veinticuatro',
		25 => 'veinticinco',
		26 => 'veintiséis',
		27 => 'veintisiete',
		28 => 'veintiocho',
		29 => 'veintinueve',
		30 => 'treinta',
		31 => 'treinta y uno'
	];

	// Años comunes
	$anios = [
		'2024' => 'dos mil veinticuatro',
		'2025' => 'dos mil veinticinco',
		'2026' => 'dos mil veintiseis',
		'2027' => 'dos mil veintisiete',
		'2028' => 'dos mil veintiocho',
		'2029' => 'dos mil veintinueve',
		'2023' => 'dos mil veintitrés',
		// Puedes agregar más años si lo necesitas
	];

	return "día " . $numeros[intval($dia)] . " del mes de " . $meses[$mes] . " de " . ($anios[$anio] ?? $anio);
}


function horaEnLetra($hora)
{
	$numeros = [
		1 => 'una',
		2 => 'dos',
		3 => 'tres',
		4 => 'cuatro',
		5 => 'cinco',
		6 => 'seis',
		7 => 'siete',
		8 => 'ocho',
		9 => 'nueve',
		10 => 'diez',
		11 => 'once',
		12 => 'doce',
		13 => 'trece',
		14 => 'catorce',
		15 => 'quince',
		16 => 'dieciséis',
		17 => 'diecisiete',
		18 => 'dieciocho',
		19 => 'diecinueve',
		20 => 'veinte',
		21 => 'veintiuna',
		22 => 'veintidós',
		23 => 'veintitrés',
		24 => 'veinticuatro'
	];

	$hora = intval($hora);
	if ($hora < 1 || $hora > 24) {
		return "hora no válida";
	}

	$texto = $numeros[$hora];
	return $texto . ($hora === 1 ? " hora" : " horas");
}


function letra_anio($numero)
{
	$Letra = '';
	if ($numero == 2020) {
		$Letra = "DOS MIL VEINTE";
	} elseif ($numero == 2021) {
		$Letra = "DOS MIL VEINTIUNO";
	} elseif ($numero == 2022) {
		$Letra = "DOS MIL VEINTIDOS";
	} elseif ($numero == 2023) {
		$Letra = "DOS MIL VEINTITRES";
	} elseif ($numero == 2024) {
		$Letra = "DOS MIL VEINTICUATRO";
	} elseif ($numero == 2025) {
		$Letra = "DOS MIL VEINTICINCO";
	} elseif ($numero == 2026) {
		$Letra = "DOS MIL VEINTISEIS";
	} elseif ($numero == 2027) {
		$Letra = "DOS MIL VEINTISIETE";
	} elseif ($numero == 2028) {
		$Letra = "DOS MIL VEINTIOCHO";
	} elseif ($numero == 2029) {
		$Letra = "DOS MIL VEINTINUEVE";
	} elseif ($numero == 2030) {
		$Letra = "DOS MIL TREINTA";
	} elseif ($numero == 2031) {
		$Letra = "DOS MIL TREINTA Y UNO";
	}

	if ($Letra) {
		return $Letra;
	} else {
		$Letra = " <b style='color: red;'>- ***AÑO NO DISPONIBLE*** - </b>";
		return $Letra;
	}
}
