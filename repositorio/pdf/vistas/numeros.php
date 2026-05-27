<?php
function obtenerNumeroEnLetra($numero){
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

	function obtenerCuat($numero){
		if($numero == 1){
			$Letra = "PRIMER";
		}elseif($numero == 2){
			$Letra = "SEGUNDO";
		}elseif($numero == 3){
			$Letra = "TERCER";
		}elseif($numero == 4){
			$Letra = "CUARTO";
		}elseif($numero == 5){
			$Letra = "QUINTO";
		}elseif($numero == 6){
			$Letra = "SEXTO";
		}elseif($numero == 7){
			$Letra = "SÉPTIMO";
		}elseif($numero == 8){
			$Letra = "OCTAVO";
		}elseif($numero == 9){
			$Letra = "NOVENO";
		}
		return $Letra;
		}

	function obtenerMes($numero){
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

		function obtenerAbre($numero){
			if($numero == 1){
				$Letra = "1er";
			}elseif($numero == 2){
				$Letra = "2do";
			}elseif($numero == 3){
				$Letra = "3er";
			}elseif($numero == 4){
				$Letra = "4to";
			}elseif($numero == 5){
				$Letra = "5to";
			}elseif($numero == 6){
				$Letra = "8vo";
			}elseif($numero == 7){
				$Letra = "9no";
			}
			return $Letra;
			}

		function obtenerAbreMay($numero){
			if($numero == 1){
				$Letra = "1ER";
			}elseif($numero == 2){
				$Letra = "2DO";
			}elseif($numero == 3){
				$Letra = "3ER";
			}elseif($numero == 4){
				$Letra = "4TO";
			}elseif($numero == 5){
				$Letra = "5TO";
			}elseif($numero == 6){
				$Letra = "6TO";
			}elseif($numero == 7){
				$Letra = "7MO";
			}
			return $Letra;
			}

		function obtenerF($fecha){
			$num = date("j", strtotime($fecha));
			$anno = date("Y", strtotime($fecha));
			$mes = array('ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE');
			$mes = $mes[(date('m', strtotime($fecha))*1)-1];
			if($num < 10){ $dd = "A "; } else { $dd = "A LOS "; }
			if($num > 1){ $s = "S"; } else { $s = ""; }
			return $dd.$num.' DIA'.$s.' DEL MES DE '.$mes.' DE '.$anno;
		}

		function letra_dia($numero){
			if($numero == 1){
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
			}elseif($numero == 11){
				$Letra = "ONCE";
			}elseif($numero == 12){
				$Letra = "DOCE";
			}elseif($numero == 13){
				$Letra = "TRECE";
			}elseif($numero == 14){
				$Letra = "CATORCE";
			}elseif($numero == 15){
				$Letra = "QUINCE";
			}elseif($numero == 16){
				$Letra = "DIECISES";
			}elseif($numero == 17){
				$Letra = "DIECISIETE";
			}elseif($numero == 18){
				$Letra = "DIECIOCHO";
			}elseif($numero == 19){
				$Letra = "DIECINUEVE";
			}elseif($numero == 20){
				$Letra = "VEINTE";
			}elseif($numero == 21){
				$Letra = "VEINTIUNO";
			}elseif($numero == 22){
				$Letra = "VEINTIDOS";
			}elseif($numero == 23){
				$Letra = "VEINTITRES";
			}elseif($numero == 24){
				$Letra = "VEINTICUATRO";
			}elseif($numero == 25){
				$Letra = "VEINTICINCO";
			}elseif($numero == 26){
				$Letra = "VEINTISEIS";
			}elseif($numero == 27){
				$Letra = "VEINTISIETE";
			}elseif($numero == 28){
				$Letra = "VEINTIOCHO";
			}elseif($numero == 29){
				$Letra = "VEINTINUEVE";
			}elseif($numero == 30){
				$Letra = "TREINTA";
			}elseif($numero == 31){
				$Letra = "TREINTA Y UNO";
			}

			return $Letra;
		}

		function letra_mes($fecha){
			$num = date("j", strtotime($fecha));
			$anno = date("Y", strtotime($fecha));
			$mes = array('ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE');
			$mes = $mes[(date('m', strtotime($fecha))*1)-1];
			return $mes;
		}

		function letra_anio($numero){
			$Letra = '';
			if($numero == 2020){
				$Letra = "DOS MIL VEINTE";
			}elseif($numero == 2021){
				$Letra = "DOS MIL VEINTIUNO";
			}elseif($numero == 2022){
				$Letra = "DOS MIL VEINTIDOS";
			}elseif($numero == 2023){
				$Letra = "DOS MIL VEINTITRES";
			}elseif($numero == 2024){
				$Letra = "DOS MIL VEINTICUATRO";
			}elseif($numero == 2025){
				$Letra = "DOS MIL VEINTICINCO";
			}elseif($numero == 2026){
				$Letra = "DOS MIL VEINTISEIS";
			}elseif($numero == 2027){
				$Letra = "DOS MIL VEINTISIETE";
			}elseif($numero == 2028){
				$Letra = "DOS MIL VEINTIOCHO";
			}elseif($numero == 2029){
				$Letra = "DOS MIL VEINTINUEVE";
			}elseif($numero == 2030){
				$Letra = "DOS MIL TREINTA";
			}elseif($numero == 2031){
				$Letra = "DOS MIL TREINTA Y UNO";
			}

			if($Letra){
					return $Letra;
			} else {
				$Letra = " <b style='color: red;'>- ***AÑO NO DISPONIBLE*** - </b>";
				return $Letra;
			}

		}


?>
