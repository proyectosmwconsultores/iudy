<?php
require_once '../class_formatos.php';
include("../hace_fecha.php");
//include("hace.php");
$formx = new Formatos();
$IdUsua = substr($_GET['idToks'], 10, 10);

$cal = $formx->obtener_lista_materias($IdUsua);
$rvoe = $formx->obtener_datos_rvoe($IdUsua);
$cert = $formx->obtener_datos_certificado($IdUsua);
$prom = $formx->obtener_promedio_user($IdUsua,$rvoe[0]['IdEducativa']);
?>


<!-- page define la hoja con los márgenes señalados -->
<page backtop="10mm" backbottom="10mm" backleft="10mm" backright="10mm">
	<page_header> <!-- Define el header de la hoja -->
	</page_header>
	<page_footer>
		<p style="text-align: center; font-size: 9px;"><b>ESTE DOCUMENTO NO ES VÁLIDO SI PRESENTA BORRADURAS O ENMENDADURAS</b><br><br><br></p>
	</page_footer>



	<div style="width: 710px; font-size: 12px; height: 15px; padding: 4px; text-align: center; ">
		<b>INCORPORADO A LA SECRETARÍA DE EDUCACIÓN DEL<br>
			GOBIERNO DEL ESTADO DE TABASCO<br></b>
		<b style="font-size: 10px;">CLAVE: 27PSU0051Z</b>
		<p style="font-size: 10px; text-align: right;"><b>CERTIFICADO No: 34673</b></p>
	</div>
	<div style="width: 710px; font-size: 12px; height: 15px; padding: 4px; text-align: center; ">
		<b>CERTIFICADO DE ESTUDIOS TOTALES</b>
	</div>
	<table style="font-weight:bold; font-size: 12px;">
		<tr>
			<td style="width: 130px;">HACE CONSTAR QUE</td>
			<td style="width: 325px; border-bottom: 0.5px solid black; text-align: center;"> <?php echo $rvoe[0]['APaterno'].' '.$rvoe[0]['AMaterno'].' '.$rvoe[0]['Nombre']; ?></td>
			<td style="width: 80px;  text-align: center;">CON CURP</td>
			<td style="width: 155px; border-bottom: 0.5px solid black; text-align: center;"><?php echo $rvoe[0]['Curp']; ?></td>
		</tr>
	</table>
	<table style="font-weight:bold; font-size: 12px;">
		<tr>
			<td style="width: 150px;">CURSO Y ACREDITÓ LA </td>
			<td style="width: 553px; border-bottom: 0.5px solid black; text-align: center;"> <?php echo $rvoe[0]['Educativa']; ?></td>
		</tr>
	</table>
	<table style="font-weight:bold; font-size: 12px;">
		<tr>
			<td style="width: 710px;">CON RECONOCIMIENTO DE VALIDEZ OFICIAL DE ESTUDIOS DE LA SECRETARÍA DE EDUCACIÓN DEL GOBIERNO DEL</td>
		</tr>
	</table>
	<table style="font-weight:bold; font-size: 12px;">
		<tr>
			<td style="width: 270px;">ESTADO DE TABASCO, SEGÚN ACUERDO No.</td>
			<td style="width: 60px; border-bottom: 0.5px solid black; text-align: center;"><?php echo $rvoe[0]['Rvoe']; ?></td>
			<td style="width: 70px; text-align: center;"> DE FECHA</td>
			<td style="width: 225px; border-bottom: 0.5px solid black; text-align: center;"> <?php echo $rvoe[0]['Vigencia']; ?></td>
			<td style="width: 70px;">CLAVE DE</td>
		</tr>
	</table>
	<table style="font-weight:bold; font-size: 12px;">
		<tr>
			<td style="width: 220px;">REGISTRO DEL PLAN DE ESTUDIOS</td>
			<td style="width: 35px; border-bottom: 0.5px solid black; text-align: center;"><?php echo $rvoe[0]['Clave_rpe']; ?>,</td>
			<td style="width: 150px; text-align: center;">CLAVE DE LA CARRERA</td>
			<td style="width: 45px; border-bottom: 0.5px solid black; text-align: center;"><?php echo $rvoe[0]['Clave_dgp']; ?></td>
			<td style="width: 180px; text-align: center;">Y CLAVE DE LA INSTITUCIÓN</td>
			<td style="width: 45px; border-bottom: 0.5px solid black; text-align: center;">210160</td>
		</tr>
	</table><br>
	<div style="height: 1040px; width: 700px; font-family: arial, sans-serif;">
		<table style="font-size: 10px;">
			<tr>
				<td style="width: 110px; text-align: center;"><b style="margin-top: 500px;">________________<br>FIRMA DEL<br>ALUMNO</b></td>
				<td style="width: 595px; text-align: center;"><b>ANTECENDENTES ACADÉMICOS<br>ESTUDIOS DE </b><?php echo $cert[0]['Estudios']; ?>
					<table>
						<tr>
							<td style="width: 70px; text-align: left;"><b>INSTITUCIÓN:</b> </td>
							<td colspan="3" style="border-bottom: 0.5px solid black; width: 514px; text-align: left;"><?php echo $cert[0]['Institucion']; ?></td>
						</tr>
						<tr>
							<td style="width: 70px; text-align: left;"><b>PERIODO:</b></td>
							<td style="width: 150px; text-align: left; border-bottom: 0.5px solid black;"><?php echo $cert[0]['Periodo']; ?></td>
							<td style="width: 120px; text-align: right;"><b>ENTIDAD FEDERATIVA:</b></td>
							<td style="width: 100px; text-align: left; border-bottom: 0.5px solid black;"> <?php echo $cert[0]['Entidad']; ?></td>
						</tr>
					</table><br>
					<table style="border-collapse: collapse; font-size: 10px; ">
						<tr>
							<td rowspan="2" style="border: 0.5px solid black; padding: 4px; width:40px;"><b style='margin-top: 10px;'>CLAVE</b></td>
							<td rowspan="2" style="border: 0.5px solid black; padding: 4px; width:220px;"><b style='margin-top: 10px;'>NOMBRE DE LA ASIGNATURA</b></td>
							<td rowspan="2" style="border: 0.5px solid black; padding: 4px; width:82px;"><b style='margin-top: 5px;'>CICLO<br>ESCOLAR</b></td>
							<td colspan="2" style="border: 0.5px solid black; padding: 4px; width:70px;"><b>CALIFICACIÓN</b></td>
							<td rowspan="2" style="border: 0.5px solid black; padding: 4px; width:80px;"><b style='margin-top: 10px;'>OBSERVACIONES</b></td>
						</tr>
						<tr>
							<td style="border: 0.5px solid black; padding: 4px; width:34px;"><b>NÚMERO</b></td>
							<td style="border: 0.5px solid black; padding: 4px; width:34px;"><b>LETRA</b></td>
						</tr>
						<?php for ($i = 0; $i <= 41; $i++) { ?>
							<tr>
								<td style="border: 0.5px solid black; padding: 4px; width:40px; text-align: left; border-bottom: none;"><?php echo $cal[$i]['CodeModulo']; ?></td>
								<td style="border: 0.5px solid black; padding: 4px; width:220px; text-align: left; border-bottom: none;"><?php echo $cal[$i]['NombreMod']; ?></td>
								<td style="border: 0.5px solid black; padding: 4px; width:82px; border-bottom: none;"><?php echo obtener_periodo_ini($cal[$i]['FInicio']); ?>-<?php echo obtener_periodo_fin($cal[$i]['FFinal']); ?></td>
								<td style="border: 0.5px solid black; padding: 4px; width:34px; border-bottom: none;"><?php echo $cal[$i]['Promedio']; ?></td>
								<td style="border: 0.5px solid black; padding: 4px; width:34px; border-bottom: none;"><?php echo obtener_prom_letra($cal[$i]['Promedio']); ?></td>
								<td style="border: 0.5px solid black; padding: 4px; width:80px; border-bottom: none;"></td>
							</tr>
						<?php } ?>
						<tr>
							<td style="border: 0.5px solid black; padding: 4px; width:40px;"></td>
							<td style="border: 0.5px solid black; padding: 4px; width:220px;"></td>
							<td style="border: 0.5px solid black; padding: 4px; width:82px;"></td>
							<td style="border: 0.5px solid black; padding: 4px; width:34px;"></td>
							<td style="border: 0.5px solid black; padding: 4px; width:34px;"></td>
							<td style="border: 0.5px solid black; padding: 4px; width:80px;"></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		
	</div><br><br>
	<table style="border-collapse: collapse; font-size: 10px; margin-left: 50px;">
			<tr>
				<td rowspan="2" style="border: 0.5px solid black; padding: 4px; width:40px;"><b>CLAVE</b></td>
				<td rowspan="2" style="border: 0.5px solid black; padding: 4px; width:220px;"><b>NOMBRE DE LA ASIGNATURA</b></td>
				<td rowspan="2" style="border: 0.5px solid black; padding: 4px; width:82px;"><b>CICLO ESCOLAR</b></td>
				<td colspan="2" style="border: 0.5px solid black; padding: 4px; width:70px;"><b>CALIFICACIÓN</b></td>
				<td rowspan="2" style="border: 0.5px solid black; padding: 4px; width:80px;"><b>OBSERVACIONES</b></td>
			</tr>
			<tr>
				<td style="border: 0.5px solid black; padding: 4px; width:34px;"><b>NÚMERO</b></td>
				<td style="border: 0.5px solid black; padding: 4px; width:34px;"><b>LETRA</b></td>
			</tr>
			<?php for ($i = 42; $i < 82; $i++) { ?>
				<tr>
					<td style="border: 0.5px solid black; padding: 4px; width:40px; text-align: left; border-bottom: none;"><?php echo $cal[$i]['CodeModulo']; ?></td>
					<td style="border: 0.5px solid black; padding: 4px; width:220px; text-align: left; border-bottom: none;"><?php echo $cal[$i]['NombreMod']; ?></td>
					<td style="border: 0.5px solid black; padding: 4px; width:82px; border-bottom: none;"><?php echo obtener_periodo_ini($cal[$i]['FInicio']); ?>-<?php echo obtener_periodo_fin($cal[$i]['FFinal']); ?></td>
					<td style="border: 0.5px solid black; padding: 4px; width:34px; border-bottom: none;"><?php echo $cal[$i]['Promedio']; ?></td>
					<td style="border: 0.5px solid black; padding: 4px; width:34px; border-bottom: none;"><?php echo obtener_prom_letra($cal[$i]['Promedio']); ?></td>
					<td style="border: 0.5px solid black; padding: 4px; width:80px; border-bottom: none;"></td>
				</tr>
			<?php } ?>
			<tr>
				<td style="border: 0.5px solid black; padding: 4px; width:40px;"></td>
				<td style="border: 0.5px solid black; padding: 4px; width:220px;"></td>
				<td style="border: 0.5px solid black; padding: 4px; width:82px;"></td>
				<td style="border: 0.5px solid black; padding: 4px; width:34px;"></td>
				<td style="border: 0.5px solid black; padding: 4px; width:34px;"></td>
				<td style="border: 0.5px solid black; padding: 4px; width:80px;"></td>
			</tr>
		</table>
		<br><br>
		<div style="margin-left: 50px; width: 600px; font-size: 12px; height: 15px; padding: 4px; text-align: justify;  ">
			<b>EL PRESENTE DOCUMENTO AMPARA <?php echo $rvoe[0]['Materias']; ?> ASIGNATURAS, QUE INTEGRAN EN PLAN DE ESTUDIOS RESPECTIVO,
				CORRESPONDIENTE A <?php echo $rvoe[0]['Creditos']; ?> CRÉDITOS. LA ESCALA DE CALIFICACIONES ES DE 5 A 10 Y LA MÍNIMA APROBATORIA ES DE 6.</b><br><br>
			<b>PROMEDIO GENERAL: <?php echo bcdiv($prom[0]['Promedio'], 1, 1); ?> </b>
			<p style="text-align: center;"><b>CENTRO, TABASCO A <?php echo obtFechMay($cert[0]['Fecha']); ?>.</b></p>
		</div><br><br>
		<table style="border-collapse: collapse; font-size: 10px; margin-left: 50px;">
			<tr>
				<td style="border-bottom: 0.5px solid black; padding: 4px; width:250px; text-align: center;"></td>
				<td style="padding: 4px; width:48px;"></td>
				<td style="border-bottom: 0.5px solid black; padding: 4px; width:250px; text-align: center;"><b>SE AUTENTIFICA CON FUNDAMENTO EN EL<br>ARTÍCULO 14 DE LA LEY GENERAL DE<br> EDUCACIÓN SUPERIOR</b><br><br><br><br><br><br><br></td>
			</tr>
			<tr>
				<td style="padding: 4px; width:250px; text-align: center;"><b><?php echo $cert[0]['Gestion']; ?><br>DIRECTORA DE GESTIÓN ESCOLAR Y TITULACIÓN</b></td>
				<td style="padding: 4px; width:48px;"></td>
				<td style="border-top: 1px solid black; padding: 4px; width:250px; text-align: center;"><b><?php echo $cert[0]['Escolar']; ?><br>DIRECTOR DE CONTROL ESCOLAR E INCORPORACIÓN</b></td>
			</tr>
		</table>


	<!-- Fin del cuerpo de la hoja -->




</page>