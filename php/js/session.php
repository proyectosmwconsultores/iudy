<?php session_start();

date_default_timezone_set('America/Mexico_City');


function obtenerFechaEnLetra($fecha){
		$dia= conocerDiaSemanaFecha($fecha);
		$num = date("j", strtotime($fecha));
		$anno = date("Y", strtotime($fecha));
		$mes = array('ene', 'feb', 'mar', 'abr', 'may', 'jun', 'jul', 'ago', 'sep', 'oct', 'nov', 'dic');
		$mes = $mes[(date('m', strtotime($fecha))*1)-1];
		return $dia.', '.$num.' de '.$mes.' de '.$anno;
	}
	function obtenerFecLista($fecha){
			$dia= DiaSemanaLista($fecha);
			$num = date("j", strtotime($fecha));
			$anno = date("Y", strtotime($fecha));
			$mes = array('ene', 'feb', 'mar', 'abr', 'may', 'jun', 'jul', 'ago', 'sep', 'oct', 'nov', 'dic');
			$mes = $mes[(date('m', strtotime($fecha))*1)-1];
			return $dia.', '.$num;
			//return $dia.', '.$num.' de '.$mes;
		}
function obtenerFechaCorta($fecha){
		$dia= conocerDiaSemanaFecha($fecha);
		$num = date("j", strtotime($fecha));
		$anno = date("Y", strtotime($fecha));
		$mes = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
		$mes = $mes[(date('m', strtotime($fecha))*1)-1];
		return $num.' de '.$mes.' de '.$anno;
	}
	function obtenerAnioMes($fecha){
			$dia= conocerDiaSemanaFecha($fecha);
			$num = date("j", strtotime($fecha));
			$anno = date("Y", strtotime($fecha));
			$mes = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
			$mes = $mes[(date('m', strtotime($fecha))*1)-1];
			return $mes.' de '.$anno;
		}

function conocerDiaSemanaFecha($fecha) {
	$dias = array('Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado');
	$dia = $dias[date('w', strtotime($fecha))];
	return $dia;
}

function DiaSemanaLista($fecha) {
	$dias = array('Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb');
	$dia = $dias[date('w', strtotime($fecha))];
	return $dia;
}

function dias_semana($fecha) {
	$dias = array('7', '1', '2', '3', '4', '5', '6');
	$dia = $dias[date('w', strtotime($fecha))];
	return $dia;
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

	function obtener_Mes($numero){
		if($numero == 1){
			$Letra = "Enero";
		}elseif($numero == 2){
			$Letra = "Febrero";
		}elseif($numero == 3){
			$Letra = "Marzo";
		}elseif($numero == 4){
			$Letra = "Abril";
		}elseif($numero == 5){
			$Letra = "Mayo";
		}elseif($numero == 6){
			$Letra = "Junio";
		}elseif($numero == 7){
			$Letra = "Julio";
		}elseif($numero == 8){
			$Letra = "Agosto";
		}elseif($numero == 9){
			$Letra = "Sepiembre";
		}elseif($numero == 10){
			$Letra = "Octubre";
		}elseif($numero == 11){
			$Letra = "Noviembre";
		}elseif($numero == 12){
			$Letra = "Diciembre";
		}
		return $Letra;
		}

		function fechaMes($fecha){
			$dia= conocerDiaSemanaFecha($fecha);
			$num = date("j", strtotime($fecha));
			$anno = date("Y", strtotime($fecha));
			$mes = array('Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic');
			$mes = $mes[(date('m', strtotime($fecha))*1)-1];
			return $num.' de '.$mes;
		}
?>
