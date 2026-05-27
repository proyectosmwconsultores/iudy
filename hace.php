<?php
date_default_timezone_set('America/Mexico_City');
function obtenerFechaEnLetra($fecha){
		$dia= conocerDiaSemanaFecha($fecha);
		$num = date("j", strtotime($fecha));
		$anno = date("Y", strtotime($fecha));
		$mes = array('ene', 'feb', 'mar', 'abr', 'may', 'jun', 'jul', 'ago', 'sep', 'oct', 'nov', 'dic');
		$mes = $mes[(date('m', strtotime($fecha))*1)-1];
		return $dia.', '.$num.' de '.$mes.' de '.$anno;
	}

	function obtener_AnioMesMAYG($fecha){
		$dia= conocerDiaSemanaFecha($fecha);
		$num = date("j", strtotime($fecha));
		$anno = date("Y", strtotime($fecha));
		$mes = array('ENE', 'FEB', 'MAR', 'ABR', 'MAY', 'JUN', 'JUL', 'AGO', 'SEP', 'OCT', 'NOV', 'DIC');
		$mes = $mes[(date('m', strtotime($fecha))*1)-1];
		return $mes.'-'.$anno;
	}

	function fechaLetraMay($fecha){
			$dia= diasMayuscula($fecha);
			$num = date("j", strtotime($fecha));
			$anno = date("Y", strtotime($fecha));
			$mes = array('ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE');
			$mes = $mes[(date('m', strtotime($fecha))*1)-1];
			return $dia.', '.$num.' DE '.$mes.' DE '.$anno;
		}

function obtenerFechaCorta($fecha){
		$dia= conocerDiaSemanaFecha($fecha);
		$num = date("j", strtotime($fecha));
		$anno = date("Y", strtotime($fecha));
		$mes = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
		$mes = $mes[(date('m', strtotime($fecha))*1)-1];
		return $num.' de '.$mes.' de '.$anno;
	}

	function fecha_pago($fecha){
			$dia= conocerDiaSemanaFecha($fecha);
			$num = date("j", strtotime($fecha));
			$anno = date("Y", strtotime($fecha));
			$mes = array('ene', 'feb', 'mar', 'abr', 'may', 'jun', 'jul', 'ago', 'sep', 'oct', 'nov', 'dic');
			$mes = $mes[(date('m', strtotime($fecha))*1)-1];
			return $num.' de '.$mes.' de '.$anno;
		}

	function obtenerFechaCorta_May($fecha){
			$dia= conocerDiaSemanaFecha($fecha);
			$num = date("j", strtotime($fecha));
			$anno = date("Y", strtotime($fecha));
			$mes = array('ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE');
			$mes = $mes[(date('m', strtotime($fecha))*1)-1];
			return $num.' DE '.$mes.' DE '.$anno;
		}

	// function obtenerMes($fecha){
	// 	$dia= conocerDiaSemanaFecha($fecha);
	// 	$num = date("j", strtotime($fecha));
	// 	$anno = date("Y", strtotime($fecha));
	// 	$mes = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
	// 	$mes = $mes[(date('m', strtotime($fecha))*1)-1];
	// 	return $mes;
	// }
	function obtener_mes($fecha){
		$dia= conocerDiaSemanaFecha($fecha);
		$num = date("j", strtotime($fecha));
		$anno = date("Y", strtotime($fecha));
		$mes = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
		$mes = $mes[(date('m', strtotime($fecha))*1)-1];
		return $mes;
	}

	function obtenerAnioMes($fecha){
		$dia= conocerDiaSemanaFecha($fecha);
		$num = date("j", strtotime($fecha));
		$anno = date("Y", strtotime($fecha));
		$mes = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
		$mes = $mes[(date('m', strtotime($fecha))*1)-1];
		return $mes.' de '.$anno;
	}

	function obtener_AnioMesMAY($fecha){
		$dia= conocerDiaSemanaFecha($fecha);
		$num = date("j", strtotime($fecha));
		$anno = date("Y", strtotime($fecha));
		$mes = array('ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE');
		$mes = $mes[(date('m', strtotime($fecha))*1)-1];
		return $mes.' DEL '.$anno;
	}

	function obtener_MesMAY($fecha){
		$dia= conocerDiaSemanaFecha($fecha);
		$num = date("j", strtotime($fecha));
		$anno = date("Y", strtotime($fecha));
		$mes = array('ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE');
		$mes = $mes[(date('m', strtotime($fecha))*1)-1];
		return $mes;
	}

		function obtener_dia($fecha){
			$dia= conocerDiaSemanaFecha($fecha);
			$num = date("j", strtotime($fecha));
			$mes = array('Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic');
			$mes = $mes[(date('m', strtotime($fecha))*1)-1];
			return $num.' '.$mes;
			}


function conocerDiaSemanaFecha($fecha) {
	$dias = array('Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado');
	$dia = $dias[date('w', strtotime($fecha))];
	return $dia;
}

function obtenerSoloFecha($fecha)
{
	$num = date("j", strtotime($fecha));
	$mes = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
	$mes = $mes[(date('m', strtotime($fecha)) * 1) - 1];
	return $num . ' de ' . $mes;
}

function diasMayuscula($fecha) {
	$dias = array('DOMINGO', 'LUNES', 'MARTES', 'MIÉRCOLES', 'JUEVES', 'VIERNES', 'SÁBADO');
	$dia = $dias[date('w', strtotime($fecha))];
	return $dia;
}

function fecha_lms($fecha)
{
    if(empty($fecha)) return '';

    $fechaObj = new DateTime($fecha);

    $meses = [
        'January'=>'enero',
        'February'=>'febrero',
        'March'=>'marzo',
        'April'=>'abril',
        'May'=>'mayo',
        'June'=>'junio',
        'July'=>'julio',
        'August'=>'agosto',
        'September'=>'septiembre',
        'October'=>'octubre',
        'November'=>'noviembre',
        'December'=>'diciembre'
    ];

    $mes = $meses[$fechaObj->format('F')];

    return $fechaObj->format('d') . ' de ' . $mes . ' de ' . $fechaObj->format('Y') . ', ' . $fechaObj->format('h:i a');
}


function tiempo_transcurrido($fecha) {
		if(empty($fecha)) {
			  return "No hay fecha";
		}

		$intervalos = array("segundo", "minuto", "hora", "día", "semana", "mes", "año");
		$duraciones = array("60","60","24","7","4.35","12");

		$ahora = time();
		$Fecha_Unix = strtotime($fecha);

		if(empty($Fecha_Unix)) {
			  return "Fecha incorrecta";
		}
		if($ahora > $Fecha_Unix) {
			  $diferencia     =$ahora - $Fecha_Unix;
			  $tiempo         = "hace";
		} else {
			  $diferencia     = $Fecha_Unix -$ahora;
			  $tiempo         = "Dentro de";
		}
		for($j = 0; $diferencia >= $duraciones[$j] && $j < count($duraciones)-1; $j++) {
		  $diferencia /= $duraciones[$j];
		}
		$diferencia = round($diferencia);
		if($diferencia != 1) {
			$intervalos[5].="e"; //MESES
			$intervalos[$j].= "s";
		}
		return "$tiempo $diferencia $intervalos[$j]";
	}


?>
