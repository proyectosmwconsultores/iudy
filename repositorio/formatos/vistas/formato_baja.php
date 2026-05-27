<?php
require_once '../class_formatos.php';
include("../hace_fecha.php");
//include("hace.php");
$formx = new Formatos();

$IdUsua = substr($_GET['idToks'], 10, 10);

$user = $formx->get_baja_alumno_id($IdUsua);

?>


<!-- page define la hoja con los márgenes señalados -->
<page backtop="10mm" backbottom="10mm" backleft="10mm" backright="10mm">
	<page_header> <!-- Define el header de la hoja -->
		<img src="../../assets/images/campus/fondo.jpg" style="width:101%" ;>

	</page_header>
	<page_footer>
	
	</page_footer>
	<table style="margin-left: 0px; margin-top: 0px; font-size: 9px; text-align: center;">
		<tr>
			<td style="width: 140px; font-size: 16px; text-align: left; border: none;">
				<img src="../../assets/images/campus/logo_pdf_1.png" style="width: 140px;">
			</td>
			<td style="width: 509px; font-size: 18px; border: none; ">
				<b><?php echo $rvoe[0]['_titulo']; ?></b>
				<p style="font-size: 16px;">
				    <b>
				        FORMATO DE <?php echo $user[0]['Estatus']; ?><br><br>
				        INSTITUTO UNIVERSITARIO DE YUCATÁN<br>
				        DIRECCIÓN DE GESTIÓN ESCOLAR
				    </b>
				</p>
				
			</td>
		</tr>
	</table>

	<table style="margin-left: 0px; margin-top: 50px; font-size: 16px; border-collapse: collapse;">
		<tr>
			<td style="text-align: right; width: 640px; padding: 5px;">Villahermosa, Tabasco. <?php echo obtFechConst($user[0]['FecCap']); ?></td>
		</tr>
	</table>
	<br><br><br>
	<table style="margin-left: 0px; margin-top: 50px; font-size: 14px; border-collapse: collapse;">
		<tr>
			<td style="text-align: left; width: 100px; padding: 5px;">TIPO:</td>
			<td style="border-bottom: 0.5px solid black; text-align: left; width: 510px; padding: 5px;"><?php echo $user[0]['Estatus']; ?></td>
		</tr>
	</table>
	<table style="margin-left: 0px; font-size: 14px; border-collapse: collapse;">
		<tr>
			<td style="text-align: left; width: 200px; padding: 5px;"><br><br>EXTENSIÓN PROCEDENCIA:</td>
			<td style="border-bottom: 0.5px solid black; text-align: left; width: 410px; padding: 5px;"><br><br><?php echo $user[0]['Campus']; ?></td>
		</tr>
	</table>
	
	<table style="margin-left: 0px; margin-top: 50px;  font-size: 14px; border-collapse: collapse;">
		<tr>
			<td style="text-align: left; width: 200px; padding: 5px;"><b>QUIEN SE SUSCRIBE:</b></td>
		</tr>
	</table>
	<table style="margin-left: 0px; margin-top: 50px; font-size: 14px; border-collapse: collapse;">
		<tr>
			<td style="text-align: left; width: 630px; padding: 5px; border-bottom: 0.5px solid black;">ALUMNO: <?php echo $user[0]['Nombre']; ?> <?php echo $user[0]['APaterno']; ?> <?php echo $user[0]['AMaterno']; ?> </td>
		</tr>
	</table>
	<table style="margin-left: 0px; margin-top: 50px; font-size: 14px; border-collapse: collapse;">
		<tr>
			<td style="text-align: left; width: 100px; padding: 5px;">MATRICULA:</td>
			<td style="border-bottom: 0.5px solid black; text-align: left; width: 510px; padding: 5px;"><?php echo $user[0]['Usuario']; ?></td>
		</tr>
	</table>
	<table style="margin-left: 0px; margin-top: 50px;  font-size: 14px; border-collapse: collapse;">
		<tr>
			<td style="text-align: left;  width: 200px; padding: 5px;">PROGRAMA DE ESTUDIO:</td>
			<td style="border-bottom: 0.5px solid black; text-align: left; width: 410px; padding: 5px;"><?php echo $user[0]['Educativa']; ?></td>
		</tr>
	</table>
	<table style="margin-left: 0px; margin-top: 50px;  font-size: 14px; border-collapse: collapse;">
		<tr>
			<td style="text-align: left; width: 200px; padding: 5px;">MODALIDAD:</td>
			<td style="border-bottom: 0.5px solid black; text-align: left; width: 410px; padding: 5px;"><?php echo $user[0]['_Dias']; ?></td>
		</tr>
	</table>
	<table style="margin-left: 0px; margin-top: 50px;  font-size: 14px; border-collapse: collapse;">
		<tr>
			<td style="text-align: left; width: 200px; padding: 5px;">MOTIVO DE LA BAJA:</td>
			<td style="border-bottom: 0.5px solid black; text-align: left; width: 410px; padding: 5px;"><?php echo $user[0]['Comentario']; ?></td>
		</tr>
	</table>
	
	<table style="margin-left: 0px; margin-top: 60px;  font-size: 14px; border-collapse: collapse;">
		<tr>
			<td style="border-bottom: 0.5px solid black; text-align: center; width: 200px; padding: 5px;"></td>
			<td style="width: 50px; padding: 5px;"></td>
			<td style="border-bottom: 0.5px solid black; text-align: center; width: 360px; padding: 5px;"></td>
		</tr>
		<tr>
			<td style="text-align: center; width: 200px; padding: 5px;"><b>Firma del Solicitante</b></td>
			<td style="width: 50px; padding: 5px;"></td>
			<td style="text-align: center; width: 360px; padding: 5px;"><b>Firma y Sello de la Dirección de Gestión Escolar</b></td>
		</tr>
	</table>
	
	<!-- Fin del cuerpo de la hoja -->
</page>