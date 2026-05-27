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

	function obtenerCuat($numero){
		if($numero == 1){
			$Letra = "PRIMERO";
		}elseif($numero == 2){
			$Letra = "SEGUNDO";
		}elseif($numero == 3){
			$Letra = "TERCERO";
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


?>
