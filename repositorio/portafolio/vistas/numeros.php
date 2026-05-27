<?php
function obtNumLetr($numero){
	if($numero == 0){
		$Letra = "CERO";
	}elseif($numero == 1){
		$Letra = "UNO";
	}elseif($numero == 2){
		$Letra = "DOS";
	}elseif($numero == 3){
		$Letra = "TRES";
	}elseif($numero == 4){
		$Letra = "CUATRO";
	}elseif($numero == 5){
		$Letra = "CINCO";
	}elseif($numero == 6){
		$Letra = "SEIS";
	}elseif($numero == 7){
		$Letra = "SIETE";
	}elseif($numero == 8){
		$Letra = "OCHO";
	}elseif($numero == 9){
		$Letra = "NUEVE";
	}elseif($numero == 10){
		$Letra = "DIEZ";
	}elseif($numero == NP){
		$Letra = "NP";
	}
	return $Letra;
}

function promedio_letra_grp($numero){
$pieces = explode(".", $numero);
$entero =  $pieces[0]; // piece1
$decimal = $pieces[1]; // piece2


	if($entero == 0){
		$Letra = "CERO";
	}elseif($entero == 1){
		$Letra = "UNO";
	}elseif($entero == 2){
		$Letra = "DOS";
	}elseif($entero == 3){
		$Letra = "TRES";
	}elseif($entero == 4){
		$Letra = "CUATRO";
	}elseif($entero == 5){
		$Letra = "CINCO";
	}elseif($entero == 6){
		$Letra = "SEIS";
	}elseif($entero == 7){
		$Letra = "SIETE";
	}elseif($entero == 8){
		$Letra = "OCHO";
	}elseif($entero == 9){
		$Letra = "NUEVE";
	}elseif($entero == 10){
		$Letra = "DIEZ";
	}

	if($decimal == 0){
		$Letra2 = "CERO";
	}elseif($decimal == 1){
		$Letra2 = "UNO";
	}elseif($decimal == 2){
		$Letra2 = "DOS";
	}elseif($decimal == 3){
		$Letra2 = "TRES";
	}elseif($decimal == 4){
		$Letra2 = "CUATRO";
	}elseif($decimal == 5){
		$Letra2 = "CINCO";
	}elseif($decimal == 6){
		$Letra2 = "SEIS";
	}elseif($decimal == 7){
		$Letra2 = "SIETE";
	}elseif($decimal == 8){
		$Letra2 = "OCHO";
	}elseif($decimal == 9){
		$Letra2 = "NUEVE";
	}

	return $Letra.' PUNTO '.$Letra2;
}



function obtFecha($fecha){
	$num = date("j", strtotime($fecha));
	$anno = date("Y", strtotime($fecha));
	$mes = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
	$mes = $mes[(date('m', strtotime($fecha))*1)-1];
	return $num.' de '.$mes.' de '.$anno;
}

function obt_fec_impresion($fecha){
	$num = date("j", strtotime($fecha));
	$anno = date("Y", strtotime($fecha));
	$mes = array('ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE');
	$mes = $mes[(date('m', strtotime($fecha))*1)-1];
	return $num.' DE '.$mes.' DEL '.$anno;
}

function obt_fec_imp_ser($fecha){
	$num = date("j", strtotime($fecha));
	$anno = date("Y", strtotime($fecha));
	$mes = array('ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE');
	$mes = $mes[(date('m', strtotime($fecha))*1)-1];
	return 'A LOS '.$num.' DIAS DEL MES DE '.$mes.' DEL '.$anno;
}


?>
