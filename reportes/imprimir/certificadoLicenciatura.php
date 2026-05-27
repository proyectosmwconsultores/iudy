<?php
session_start();
if ($_SESSION['Permisos']) {
	include("consulta_impresion.php");
	include("../../repositorio/hace_fecha.php");

	$rep = 0;
	$formx = new Imprimir();

	$IdUsua = substr($_GET["idToks"], 10, 50);
	$cal = $formx->obtener_lista_materias_part1($IdUsua);
	$cal2 = $formx->obtener_lista_materias_part2($IdUsua);
	$rvoe = $formx->obtener_datos_rvoe($IdUsua);
	$cert = $formx->obtener_datos_certificado($IdUsua);
	$miscreditos = $formx->get_mis_creditos($IdUsua);
	$materias = $formx->get_mis_materias($IdUsua);
	$info = $formx->obtener_informacion_ido($IdUsua);
	$promedio = $formx->get_promedio_alumno_id($IdUsua);
	$especial = 0;
	if($cert[0]['IdCiclo'] > 0){
		$especial = 1;
	}
	
?>
	<style>
		table {
			border-collapse: collapse;
		}

		table,
		tr,
		td {
			/* border: 1px solid #3e3e3e; */
			padding: 0.5px;
		}

		.underlined {
			text-decoration: underline;
		}

		.page-break {

			page-break-after: always;
			/* Inserta un salto de página después del elemento */
		}

		.contenedor {
			display: flex;
		}

		.div1 {
			width: 130px;
		}

		.div2 {
			width: 590px;
		}
	</style>
	<html>

	<head>
		<title>Cerficado de estudios</title>
	</head>
	<!-- <body onload="imprimir();"> -->

	<body>
	    <?php for($m = 0; $m<2; $m++){   ?>
	    <?php if($m == 1){ ?>
	    <div style="page-break-after: always;"></div><br>
	    <?php } ?>
		<table style='width: 720px; margin-top: 80px;'>
			<tr>
				<td style="text-align: center; font-family: Arial; font-size: 10px;">
					<p>
						<b style="font-size: 12px;">INCORPORADO A LA SECRETARÍA DE EDUCACIÓN DEL</b><br>
						<b style="font-size: 12px;">GOBIERNO DEL ESTADO DE TABASCO</b><br>
						<b>CLAVE: 27PSU0051Z</b><br>
					</p>
				</td>
			</tr>
			<tr>
				<td style="text-align: center; font-family: Arial; font-size: 10.5px; text-align: right; height: 40px;">
					<p>
						<b>CERTIFICADO No. </b> <b class="underlined"> <?php echo $cert[0]['Folio']; ?></b>
					</p>
				</td>
			</tr>
		</table>
		<br>
		<table style='width: 720px; '>
			<tr>
				<td style="text-align: center; font-family: Arial; font-size: 12px; text-align: center;">
					<p>
						<b>CERTIFICADO DE ESTUDIOS<b> <b class="underlined">TOTALES</b>
					</p>
				</td>
			</tr>
		</table>

		<table style='width: 720px; margin-top: 10px; font-weight: bold; font-family: Arial; font-size: 13px; text-align: justify; '>
			<tr>
				<td style="width: 150px;">
					HACE CONSTAR QUE
				</td>
				<td style="border-bottom: 0.5px solid black; text-align: center;">
					<?php echo $rvoe[0]['Nombre']; ?> <?php echo $rvoe[0]['APaterno']; ?> <?php echo $rvoe[0]['AMaterno']; ?>
				</td>
				<td style="text-align: center;">
					CON CURP
				</td>
				<td style="border-bottom: 0.5px solid black; text-align: center;">
					<?php echo $info[0]['P_curp']; ?>
				</td>
			</tr>
		</table>
		<table style='width: 720px; margin-top: 5px; font-weight: bold; font-family: Arial; font-size: 13px; text-align: justify; '>
			<tr>
				<td style="width: 160px;">
					CURSÓ Y ACREDITÓ LA
				</td>
				<td style="border-bottom: 0.5px solid black; text-align: center;">
					<?php echo $rvoe[0]['Educativa']; ?>
				</td>
			</tr>
		</table>
		<table style='width: 720px; margin-top: 5px; font-weight: bold; font-family: Arial; font-size: 12px; text-align: justify;  line-height: 20px;'>
			<tr>
				<td>
					<p>
						CON RECONOCIMIENTO DE VALIDEZ OFICIAL DE ESTUDIOS DE LA SECRETARÍA DE EDUCACIÓN DEL GOBIERNO
						DEL ESTADO DE TABASCO, SEGÚN ACUERDO No. <b class="underlined"> <?php if($rvoe[0]['Rvoe']){ echo $rvoe[0]['Rvoe']; } else { echo " ------ ";} ?>
						</b> DE FECHA <b class="underlined"><?php if($rvoe[0]['Vigencia']) { echo $rvoe[0]['Vigencia']; } else { echo " ----- --- -- "; } ?>,</b>
						CLAVE DE REGISTRO DEL PLAN DE ESTUDIOS <b class="underlined"><?php if($rvoe[0]['Clave_rpe']){ echo $rvoe[0]['Clave_rpe']; } else echo " ----------- "; ?> </b>, CLAVE DE
						LA CARRERA <b class="underlined"><?php if($rvoe[0]['Clave_dgp']) { echo $rvoe[0]['Clave_dgp']; } else { echo " ---------- ";} ?> </b> Y CLAVE DE LA INSTITUCIÓN <b class="underlined">270160.</b>
					</p>
				</td>
			</tr>
		</table><br>
		<div class="contenedor">
			<div class="div1">
			<br><br><br><br><br><br>
				<div style="width: 80px; height: 100px; border: 0.5px solid black; margin-top: 0px;">

				</div><br><br><br><br><br><br><br><br><br>
				<p style="font-family: Arial; font-size: 12px; text-align: center; width: 100px;">
					_______________
					<b>FIRMA DEL ALUMNO</b>
				</p>
			</div>
			<div class="div2">
				<table style="width: 590px; text-align: center; font-weight: bold; font-family: Arial; font-size: 11px; line-height: 15px;">
					<tr>
						<td>ANTECEDENTES ACADÉMICOS</td>
					</tr>
					<tr>
						<td><b>ESTUDIOS DE</b> <b style="font-weight: normal;" class="underlined"> &nbsp; <?php echo $cert[0]['Estudios']; ?> &nbsp; </b></td>
					</tr>
					<tr>
						<td style="text-align: left;"><b>INSTITUCIÓN:</b> <b style="font-weight: normal;" class="underlined"> &nbsp; <?php echo $cert[0]['Institucion']; ?> </b></td>
					</tr>
				</table>
				<table style="width: 590px; text-align: center; font-weight: bold; font-family: Arial; font-size: 11px; line-height: 15px;">
					<tr>
						<td style="text-align: left;"><b>PERÍODO:</b> <b style="font-weight: normal;" class="underlined"> &nbsp; 
						<?php echo substr($cert[0]['Cer_inicio'], 0, 4); ?> - 
						<?php echo substr($cert[0]['Cer_final'], 0, 4); ?> &nbsp; </b> </td>
						<td style="text-align: left;"><b>ENTIDAD FEDERATIVA:</b> <b style="font-weight: normal;" class="underlined"> &nbsp; <?php echo $cert[0]['Entidad']; ?> &nbsp; </b> </td>
					</tr>
				</table>
				<table style="border: 0.5px solid black; border-collapse: collapse; margin-top: 20px; width: 590px; text-align: center; font-family: Arial; font-size: 11px; line-height: 15px;">
					<tr>
						<td rowspan="2" style="width: 60px; border: 0.5px solid black;"><b>CLAVE</b></td>
						<td rowspan="2" style="width: 300px; border: 0.5px solid black;"><b>NOMBRE DE LA ASIGNATURA</b></td>
						<td rowspan="2" style="width: 90px; border: 0.5px solid black;"><b>CICLO ESCOLAR</b></td>
						<td colspan="2" style="width: 90px; border: 0.5px solid black;"><b>CALIFICACIÓN</b></td>
						<td rowspan="2" style="width: 90px; border: 0.5px solid black;"><b>OBSERVACIONES</b></td>
					</tr>
					<tr>
						<td style="width: 55px; border: 0.5px solid black;"><b>NÚMERO</b></td>
						<td style="width: 55px; border: 0.5px solid black; "><b>LETRA</b></td>
					</tr>
					<tr>
						<td style="width: 60px; border-right: 0.5px solid black;"> &nbsp; </td>
						<td style="width: 300px; border-right: 0.5px solid black; text-align: left;"> &nbsp; </td>
						<td style="width: 90px; border-right: 0.5px solid black;"> &nbsp; </td>
						<td style="width: 50px; border-right: 0.5px solid black;"> &nbsp; </td>
						<td style="width: 50px; border-right: 0.5px solid black;"> &nbsp; </td>
						<td style="width: 90px;"> &nbsp; </td>
					</tr>
					<?php $gi = 0; $gf = 0; for ($i = 0; $i < sizeof($cal); $i++) {  $gi = $cal[$i]['Grado'];
						if($especial == 1){
							if($gi <>  $gf) {
								$cicx = $formx->obtener_ciclo_impresion($cert[0]['IdCiclo'],$gi);
								$periodo =  obtener_periodo_ini($cicx[0]['FInicio']).' '.obtener_periodo_fin($cicx[0]['FFinal']);
							}
							
							
						} else {
							$periodo =  obtener_periodo_ini($cal[$i]['FInicio']).' '.obtener_periodo_fin($cal[$i]['FFinal']);
						}

						
						?>
						<tr style="font-family: Calibri; font-size: 11px; ">
							<td style="width: 60px; border-right: 0.5px solid black;"><?php echo $cal[$i]['CodeModulo']; ?></td>
							<td style="width: 300px; border-right: 0.5px solid black; text-align: left;"><?php echo $cal[$i]['NombreMod']; ?></td>
							<td style="width: 90px; border-right: 0.5px solid black;"><?php echo $periodo; ?></td>
							<td style="width: 55px; border-right: 0.5px solid black;"><?php echo $cal[$i]['Promedio']; ?>.0</td>
							<td style="width: 55px; border-right: 0.5px solid black;"><?php echo obtener_prom_letra($cal[$i]['Promedio']); ?></td>
							<td style="width: 90px;"><b><?php if($cal[$i]['_obs'] == "E"){ echo 'E.E.';  } ?></b></td>
						</tr>
					<?php $gf = $cal[$i]['Grado']; } ?>
					<tr>
						<td style="width: 60px; border-right: 0.5px solid black;"> &nbsp; </td>
						<td style="width: 300px; border-right: 0.5px solid black; text-align: left;"> &nbsp; </td>
						<td style="width: 90px; border-right: 0.5px solid black;"> &nbsp; </td>
						<td style="width: 50px; border-right: 0.5px solid black;"> &nbsp; </td>
						<td style="width: 50px; border-right: 0.5px solid black;"> &nbsp; </td>
						<td style="width: 90px;"> &nbsp; </td>
					</tr>
				</table>
				<table style="margin-top: 50px; width: 590px; text-align: center; font-family: Arial; font-size: 11px; line-height: 15px;">
					<tr>
						<td style="width: 200px;">&nbsp;</td>
						<td style="width: 200px; text-align: center; font-family: Arial; font-size: 9px; color: #7f7f7f;"><b><?php if($m == 1){ ?>C O P I A <?php } ?></b></td>
						<td style="width: 200px; text-align: right; font-family: Arial; font-size: 9px;">Continúa...</td>
					</tr>
				</table>
			</div>
		</div>

		<div class="page-break"></div><br>
		<table style="border: 0.5px solid black; margin-left: 50px; border-collapse: collapse; margin-top: 40px; width: 640px; text-align: center; font-family: Arial; font-size: 11px; line-height: 15px;">
			<tr>
				<td rowspan="2" style="width: 60px; border: 0.5px solid black;"><b>CLAVE</b></td>
				<td rowspan="2" style="width: 300px; border: 0.5px solid black;"><b>NOMBRE DE LA ASIGNATURA</b></td>
				<td rowspan="2" style="width: 90px; border: 0.5px solid black;"><b>CICLO ESCOLAR</b></td>
				<td colspan="2" style="width: 90px; border: 0.5px solid black;"><b>CALIFICACIÓN</b></td>
				<td rowspan="2" style="width: 90px; border: 0.5px solid black;"><b>OBSERVACIONES</b></td>
			</tr>
			<tr>
				<td style="width: 55px; border: 0.5px solid black;"><b>NÚMERO</b></td>
				<td style="width: 55px; border: 0.5px solid black; "><b>LETRA</b></td>
			</tr>
			<tr>
				<td style="width: 60px; border-right: 0.5px solid black;"> &nbsp; </td>
				<td style="width: 350px; border-right: 0.5px solid black; text-align: left;"> &nbsp; </td>
				<td style="width: 90px; border-right: 0.5px solid black;"> &nbsp; </td>
				<td style="width: 50px; border-right: 0.5px solid black;"> &nbsp; </td>
				<td style="width: 50px; border-right: 0.5px solid black;"> &nbsp; </td>
				<td style="width: 90px;"> &nbsp; </td>
			</tr>
			<?php $gi = 0; $gf = 0; for ($i = 0; $i < sizeof($cal2); $i++) { $gi = $cal2[$i]['Grado'];
				if($especial == 1){
					if($gi <>  $gf) {
						$cicx = $formx->obtener_ciclo_impresion($cert[0]['IdCiclo'],$gi);
						$periodo =  obtener_periodo_ini($cicx[0]['FInicio']).' '.obtener_periodo_fin($cicx[0]['FFinal']);
					}
					
					
				} else {
					$periodo =  obtener_periodo_ini($cal[$i]['FInicio']).' '.obtener_periodo_fin($cal[$i]['FFinal']);
				}

				?>
				<tr style="font-family: Calibri; font-size: 11px;">
					<td style="width: 60px; border-right: 0.5px solid black;"><?php echo $cal2[$i]['CodeModulo']; ?></td>
					<td style="width: 350px; border-right: 0.5px solid black; text-align: left;"><?php echo $cal2[$i]['NombreMod']; ?></td>
					<td style="width: 90px; border-right: 0.5px solid black;"><?php echo $periodo; ?></td>
					<td style="width: 55px; border-right: 0.5px solid black;"><?php echo $cal2[$i]['Promedio']; ?>.0</td>
					<td style="width: 55px; border-right: 0.5px solid black;"><?php echo obtener_prom_letra($cal2[$i]['Promedio']); ?></td>
					<td style="width: 90px;"><b><?php if($cal2[$i]['_obs'] == "E"){ echo 'E.E.';  } ?></b></td>
				</tr>
			<?php $gf = $cal2[$i]['Grado'];  }
			$v  = 0; ?>
			<?php if ($i > 40) {
				$maxi = 40;
			} else {
				$maxi = 40;
			}
			$vc = 0;
			for ($x = $i; $x < $maxi; $x++) {
				$vc = ($vc =  +1);
				$v = ($v + 1);
			?>
				<tr>
					<td style="height: 17px; width: 60px; border-right: 0.5px solid black;"> <?php if ($vc == 1) { ?><canvas id="canv_<?php echo $m; ?>" style="position: absolute; margin-left:-27px; margin-top:-1px;"></canvas><?php } ?> &nbsp; </td>
					<td style="width: 300px; border-right: 0.5px solid black; text-align: left;"> &nbsp; </td>
					<td style="width: 90px; border-right: 0.5px solid black;"> &nbsp; </td>
					<td style="width: 50px; border-right: 0.5px solid black;"> &nbsp; </td>
					<td style="width: 50px; border-right: 0.5px solid black;"> &nbsp; </td>
					<td style="width: 90px;"> &nbsp; </td>
				</tr>
			<?php }
			$num = (40 - $i);
			$_toc = (39 - $i); ?>
		</table>
		<input type="hidden" name="Numero" id="Numero" value="<?php echo $num; ?>">
		<input type="hidden" name="_total" id="_total" value="<?php echo $_toc; ?>">
		<br>
		<table style=" margin-left: 50px; border-collapse: collapse; margin-top: 20px; width: 640px; text-align: justify; font-family: Arial; font-size: 11px; line-height: 15px;">
			<tr>
				<td>
					<b>EL PRESENTE DOCUMENTO AMPARA <b class="underlined"> &nbsp; <?php echo $materias[0]['Total']; ?> &nbsp; </b> ASIGNATURAS, QUE
						INTEGRAN EL PLAN DE ESTUDIOS RESPECTIVO, CORRESPONDIENTE A <b class="underlined"> &nbsp; <?php echo intval($miscreditos[0]['Total']); ?> &nbsp; </b>
						CRÉDITOS. LA ESCALA DE CALIFICACIONES ES DE 5 A 10 Y LA MÍNIMA APROBATORIA ES DE <b class="underlined"> &nbsp; 6.0 &nbsp; </b>.
						<br>
						PROMEDIO GENERAL <b class="underlined"> &nbsp; <?php echo bcdiv($promedio[0]['Promedio'], 1, 1); ?> &nbsp; </b>
						</b>
				</td>
			</tr>
		</table>
		<table style=" margin-left: 50px; border-collapse: collapse; margin-top: 20px; width: 640px; text-align: center; font-family: Arial; font-size: 12px; line-height: 15px;">
			<tr>
				<td>
					<b>CENTRO, TABASCO A <b class="underlined"> &nbsp; <?php echo substr($cert[0]['Fecha'], 8, 2); ?> &nbsp; </b> DE <b class="underlined"> &nbsp; <?php echo obtener_Mes($cert[0]['Fecha']);  ?> &nbsp; </b> DE <b class="underlined"> &nbsp; <?php echo substr($cert[0]['Fecha'], 0, 4); ?>. &nbsp; </b> </b>
				</td>
			</tr>
		</table>
		<table style=" margin-left: 50px; border-collapse: collapse; margin-top: 60px; width: 640px; text-align: center; font-family: Calibri; font-size: 12px; line-height: 15px;">
			<tr>
				<td style="width: 30px;"></td>
				<td style="width: 180px;"></td>
				<td style="width: 40px;"></td>
				<td style="width: 180px; font-family: Arial; "><b>SE AUTENTICA CON FUNDAMENTO EN EL<br> ARTÍCULO 14 DE LA LEY GENERAL DE<br> EDUCACIÓN SUPERIOR</b><br><br><br><br><br><br></td>
				<td style="width: 30px;"></td>
			</tr>
			<tr>
				<td style="width: 30px;"></td>
				<td style="width: 180px; border-top: 0.5px solid black;"><b><?php echo $cert[0]['Gestion']; ?><br>DIRECTORA DE GESTIÓN ESCOLAR Y <br>TITULACIÓN</b></td>
				<td style="width: 40px;"></td>
				<td style="width: 180px; border-top: 0.5px solid black;"><b><?php echo $cert[0]['Escolar']; ?><br>DIRECTOR DE CONTROL ESCOLAR E <br>INCORPORACIÓN</b></td>
				<td style="width: 30px;"></td>
			</tr>
		</table>
		<table style="margin-left: 0px; border-collapse: collapse; margin-top: 80px; width: 720px; text-align: center; font-family: Calibri; font-size: 12px; line-height: 15px;">
			<tr>
				<td style="width: 200px; text-align: center; font-family: Arial; font-size: 9px; color: #7f7f7f;"><b>ESTE CERTIFICADO NO ES VÁLIDO SI PRESENTA BORRADURAS O ENMENDADURAS</b></td>
			</tr>
		</table>

<?php } ?>
	</body>
	<script>
		var c0 = document.getElementById("canv_0");
		var c1 = document.getElementById("canv_1");
		var Num = document.getElementById("Numero").value;
		var Total = document.getElementById("_total").value;
		var sum = 0;

		var mult = 0;

		if (Total == 1) {
			mult = 17.0;
		}
		if (Total == 2) {
			mult = 17.0;
		}
		if (Total == 3) {
			mult = 17.0;
		}
		if (Total == 4) {
			mult = 17.0;
		}
		if (Total == 5) {
			mult = 17.0;
		}
		if (Total == 6) {
			mult = 17.0;
		}
		if (Total == 7) {
			mult = 17.0;
		}
		if (Total == 8) {
			mult = 17.0;
		}
		if (Total == 9) {
			mult = 17.0;
		}
		if (Total == 10) {
			mult = 17.0;
		}
		if (Total == 11) {
			mult = 17.0;
		}
		if (Total == 12) {
			mult = 17.0;
		}
		if (Total == 13) {
			mult = 17.0;
		}
		if (Total == 14) {
			mult = 17.0;
		}
		if (Total == 15) {
			mult = 17.0;
		}
		if (Total == 16) {
			mult = 17.0;
		}
		if (Total == 17) {
			mult = 17.0;
		}
		if (Total == 18) {
			mult = 17.0;
		}
		if (Total == 19) {
			mult = 17.0;
		}
		if (Total == 20) {
			mult = 17.0;
		}
		if (Total == 21) {
			mult = 17.0;
		}
		if (Total == 22) {
			mult = 17.0;
		}
		if (Total == 23) {
			mult = 17.0;
		}
		if (Total == 24) {
			mult = 17.0;
		}
		if (Total == 25) {
			mult = 17.9;
		}
		if (Total == 26) {
			mult = 17.0;
		}
		if (Total == 27) {
			mult = 17.0;
		}
		if (Total == 28) {
			mult = 17.0;
		}
		if (Total == 29) {
			mult = 17.0;
		}
		if (Total == 30) {
			mult = 17.0;
		}
		if (Total == 31) {
			mult = 17.0;
		}
		if (Total == 32) {
			mult = 17.0;
		}
		if (Total == 33) {
			mult = 17.0;
		}
		if (Total == 34) {
			mult = 17.0;
		}
		if (Total == 35) {
			mult = 17.0;
		}
		if (Total == 36) {
			mult = 17.0;
		}
		if (Total == 37) {
			mult = 17.0;
		}
		if (Total == 38) {
			mult = 17.0;
		}
		if (Total == 39) {
			mult = 17.0;
		}
		if (Total == 40) {
			mult = 17.3;
		}
		sum = (mult * Num);

		var contexto = c0.getContext("2d");
		var cw = c0.width = 640,
			cx = cw / 2;
		var ch = c0.height = sum,
			cy = ch / 2;
		var a = {
			x: 0,
			y: 0,
		}
		var b = {
			x: 640,
			y: sum,
		}

		contexto.moveTo(a.x, a.y);
		contexto.lineTo(b.x, b.y);
		contexto.stroke();
		
		var contexto = c1.getContext("2d");
		var cw = c1.width = 640,
			cx = cw / 2;
		var ch = c1.height = sum,
			cy = ch / 2;
		var a = {
			x: 0,
			y: 0,
		}
		var b = {
			x: 640,
			y: sum,
		}

		contexto.moveTo(a.x, a.y);
		contexto.lineTo(b.x, b.y);
		contexto.stroke();
		
		
	</script>
	<script>
		function imprimir() {
			if (window.print) {
				window.print();
			} else {
				alert("La función de impresion no esta soportada por su navegador.");
			}
		}
	</script>

	</html>
<?php } else {
	echo "<script type='text/javascript'>window.close();</script>";
} ?>