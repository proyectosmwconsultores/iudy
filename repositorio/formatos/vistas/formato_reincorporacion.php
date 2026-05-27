<?php
require_once '../class_formatos.php';
include("../hace_fecha.php");
//include("hace.php");
$formx = new Formatos();

$IdUsua = substr($_GET['idToks'], 10, 10);

$user = $formx->obtener_datos_rvoe($IdUsua);
$rein = $formx->get_datos_reincorporacion($IdUsua);
$firma = $formx->get_firma_gestion($rein[0]['IdGestion']);
$rvoe = $formx->get_datos_campus_rvoe($user[0]['IdUsua']);
?>


<!-- page define la hoja con los márgenes señalados -->
<page backtop="10mm" backbottom="10mm" backleft="10mm" backright="10mm">
	<page_header> <!-- Define el header de la hoja -->
		<img src="../../assets/images/campus/fondo.jpg" style="width:101%" ;>

	</page_header>
	<page_footer>
		<p style="font-size: 11px; margin-left: 42px;">
		<b>Nota:</b> Se anexa a éste documento, copia de la factura de Reinscripción.
		</p><br><br><br>
	</page_footer>
	<table style="margin-left: 0px; margin-top: 0px; font-size: 9px; text-align: center;">
		<tr>
			<td style="width: 140px; font-size: 16px; text-align: left; border: none;">
				<img src="../../assets/images/campus/<?php echo $rvoe[0]['_logoPdf']; ?>" style="width: 140px;">
			</td>
			<td style="width: 509px; font-size: 17px; border: none; ">
				<b><?php echo $rvoe[0]['_titulo']; ?></b>
				<p style="font-size: 12px;">DIRECCIÓN DE GESTIÓN ESCOLAR
				</p>
				<p style="font-size: 10px;"><b>FORMATO DE REINCORPORACIÓN</b></p>
			</td>
		</tr>
	</table>

	<table style="margin-left: 0px; margin-top: 50px; font-size: 13px; border-collapse: collapse;">
		<tr>
			<td style="text-align: right; width: 640px; padding: 5px;">Villahermosa, Tabasco. <?php echo obtFechConst($user[0]['_fecReincorporacion']); ?></td>
		</tr>
		<tr>
			<td style="text-align: right; width: 640px; padding: 5px;"><b>Asunto:</b> Reincorporación de alumno</td>
		</tr>
	</table>
	<br>
	<table style="margin-left: 0px; margin-top: 50px; font-size: 12px; border-collapse: collapse;">
		<tr>
			<td style="text-align: left; width: 300px; padding: 5px;">PERIODO ESCOLAR DE REINCORPORACIÓN:</td>
			<td style="border-bottom: 0.5px solid black; text-align: left; width: 310px; padding: 5px;"><b><?php echo $rein[0]['Ciclo']; ?></b></td>
		</tr>
		<tr>
			<td colspan="2" style="text-align: left; width: 300px; padding: 5px;"><br><br>QUIEN SUSCRIBE:</td>
		</tr>
	</table>
	<table style="margin-left: 0px; margin-top: 50px; font-size: 12px; border-collapse: collapse;">
		<tr>
			<td style="border-bottom: 0.5px solid black; text-align: center; width: 180px; padding: 5px;"><b><?php echo $user[0]['APaterno']; ?></b> </td>
			<td style="text-align: center; width: 5px; padding: 5px;"></td>
			<td style="border-bottom: 0.5px solid black; text-align: center; width: 180px; padding: 5px;"><b><?php echo $user[0]['AMaterno']; ?></b> </td>
			<td style="text-align: center; width: 5px; padding: 5px;"></td>
			<td style="border-bottom: 0.5px solid black; text-align: center; width: 180px; padding: 5px;"><b><?php echo $user[0]['Nombre']; ?></b> </td>
		</tr>
		<tr>
			<td style="text-align: center; width: 180px; padding: 5px;">APELLIDO PATERNO </td>
			<td style="text-align: center; width: 5px; padding: 5px;"></td>
			<td style="text-align: center; width: 180px; padding: 5px;">APELLIDO MATERNO </td>
			<td style="text-align: center; width: 5px; padding: 5px;"></td>
			<td style="text-align: center; width: 180px; padding: 5px;">NOMBRE </td>
		</tr>
	</table>
	<table style="margin-left: 0px; margin-top: 50px; font-size: 12px; border-collapse: collapse;">
		<tr>
			<td style="text-align: left; width: 80px; padding: 5px;">MATRICULA:</td>
			<td style="border-bottom: 0.5px solid black; text-align: left; width: 530px; padding: 5px;"><b><?php echo $user[0]['Usuario']; ?></b></td>
		</tr>
		<tr>
			<td style="text-align: left; width: 80px; padding: 5px;"><br><br>PROGRAMA:</td>
			<td style="border-bottom: 0.5px solid black; text-align: left; width: 530px; padding: 5px;"><br><br><b><?php echo $user[0]['Educativa']; ?></b></td>
		</tr>
	</table>
	<table style="margin-left: 0px; margin-top: 50px; font-size: 12px; border-collapse: collapse;">
		<tr>
			<td style="text-align: left; width: 630px; padding: 5px;">CUATRIMESTRE AL QUE SE REINCORPORA:</td>
		</tr>
		<tr>
			<td style="text-align: justify; width: 630px; padding: 5px;"><b><?php echo $rein[0]['Nota']; ?></b></td>
		</tr>
	</table>
	<table style="margin-left: 0px; margin-top: 50px; font-size: 12px; border-collapse: collapse;">
		<tr>
			<td style="text-align: center; width: 170px; padding: 5px;"> </td>
			<td style="text-align: center; border-bottom: 0.5px solid black; width: 250px; padding: 5px;"></td>
			<td style="text-align: center; width: 170px; padding: 5px;"></td>
		</tr>
		<tr>
			<td style="text-align: center; width: 170px; padding: 5px;"> </td>
			<td style="text-align: center; width: 250px; padding: 5px; font-size: 10px;">FIRMA DEL SOLICITANTE</td>
			<td style="text-align: center; width: 170px; padding: 5px;"></td>
		</tr>
	</table>
	<br>
	<table style="margin-left: 0px; margin-top: 30px; font-size: 12px; border-collapse: collapse;">
		<tr>
			<td style=" text-align: justify; width: 630; padding: 5px;"><b>Después de haber revisado la situación administrativa y académica del alumno, así como asignado el horario correspondiente, doy por autorizado el traslado/cambio.</b></td>
		</tr>
	</table>
	<table style="margin-left: 0px; margin-top: 30px; font-size: 12px; border-collapse: collapse;">
		<tr>
			<td style="text-align: left; width: 120px; padding: 5px;">CON UN HORARIO:</td>
			<td style="border-bottom: 0.5px solid black; text-align: left; width: 490px; padding: 5px;"><b><?php if($rein[0]['Dia'] == 'P'){ echo "PERSONALIZADO"; } else { echo "REGULAR"; } ?></b></td>
		</tr>
	</table><br>
	<table style="margin-left: 0px; margin-top: 30px; font-size: 12px; border-collapse: collapse;">
		<tr>
			<td style="text-align: center; width: 150px; padding: 5px;"> </td>
			<td style="text-align: center; border-bottom: 0.5px solid black; width: 290px; padding: 5px;"><?php echo $firma[0]['Nombre'].' '.$firma[0]['APaterno'].' '.$firma[0]['AMaterno']; ?></td>
			<td style="text-align: center; width: 150px; padding: 5px;"></td>
		</tr>
		<tr>
			<td style="text-align: center; width: 150px; padding: 5px;"> </td>
			<td style="text-align: center; width: 290px; padding: 5px; font-size: 10px;">NOMBRE Y FIRMA DE GESTION ESCOLAR</td>
			<td style="text-align: center; width: 150px; padding: 5px;"></td>
		</tr>
	</table>
	<!-- Fin del cuerpo de la hoja -->
</page>