<?php
require_once '../class_formatos.php';
include("../hace_fecha.php");
//include("hace.php");
$formx = new Formatos();

$IdPractica = substr($_GET['idToks'], 10, 10);

$prac = $formx->obtener_datos_practica($IdPractica);

$rvoe = $formx->get_datos_campus_rvoe($prac[0]['IdUsua']);
$firma = $formx->get_firma_gestion($prac[0]['IdGestion']);
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
				<img src="../../assets/images/campus/<?php echo $rvoe[0]['_logoPdf']; ?>" style="width: 140px;">
			</td>
			<td style="width: 509px; font-size: 17px; border: none; ">
				<b><?php echo $rvoe[0]['_titulo']; ?></b>
				<p style="font-size: 10px;">INCORPORADO A LA SECRETARÍA DE EDUCACIÓN DEL GOBIERNO DEL ESTADO  DE  TABASCO<br>CON CLAVE DEL CENTRO DE TRABAJO: 27PSU0051Z</p>
			</td>
		</tr>
	</table>
	<table style="margin-left: 0px; margin-top: 50px;  border-collapse: collapse;">
		<tr>
			<td style="text-align: center; width: 640px; padding: 5px; font-size: 16px;"><b>CONSTANCIA DE LIBERACIÓN DE PRÁCTICAS<br>PROFESIONALES</b></td>
		</tr>
		<tr>
			<td style="text-align: center; width: 640px; padding: 5px; font-size: 12px; font-family:timesnewromanmtstd"><br><br>QUE SE OTORGA A:</td>
		</tr>
		<tr>
			<td style="text-align: center; width: 640px; padding: 5px; font-size: 12px; font-family:timesnewromanmtstdb; border-bottom: 1px solid black"><br><b><?php echo $prac[0]['APaterno']; ?> <?php echo $prac[0]['AMaterno']; ?> <?php echo $prac[0]['Nombre']; ?></b></td>
		</tr>
		<tr>
			<td style="text-align: center; width: 640px; padding: 5px; font-size: 12px; font-family:timesnewromanmtstd;"><br><br>DE LA CARRERA:</td>
		</tr>
		<tr>
			<td style="text-align: center; width: 640px; padding: 5px; font-size: 12px; font-family:timesnewromanmtstdb; border-bottom: 1px solid black;"><br><b><?php echo $prac[0]['Educativa']; ?></b></td>
		</tr>
		<tr>
			<td style="text-align: center; width: 640px; padding: 5px; font-size: 12px; font-family:timesnewromanmtstd; "><br><br>DE LA INSTITUCIÓN EDUCATIVA:</td>
		</tr>
		<tr>
			<td style="text-align: center; width: 640px; padding: 5px; font-size: 12px; font-family:timesnewromanmtstdb; border-bottom: 1px solid black;"><br><b>INSTITUTO UNIVERSITARIO DE YUCATÁN</b></td>
		</tr>
		<tr>
			<td style="text-align: center; width: 640px; padding: 5px; font-size: 12px; font-family:timesnewromanmtstd; "><br><br> NO. DE REGISTRO:</td>
		</tr>
		<tr>
			<td style="text-align: center; width: 640px; padding: 5px; font-size: 12px; font-family:timesnewromanmtstdb; border-bottom: 1px solid black;"><br><b>IUDY/<?php echo $prac[0]['Anio']; ?>/<?php echo $prac[0]['Folio']; ?></b></td>
		</tr>
		<tr>
			<td style="text-align: center; width: 640px; padding: 5px; font-size: 12px; font-family:timesnewromanmtstd; "><br><br>POR HABER PRESTADO SUS PRÁCTICAS PROFESIONALES EN:<br>(DEPENDENCIA, INSTITUCIÓN U ORGANISMOS)</td>
		</tr>
		<tr>
			<td style="text-align: center; width: 640px; padding: 5px; font-size: 12px; font-family:timesnewromanmtstdb; border-bottom: 1px solid black;"><br><b><?php echo $prac[0]['Empresa']; ?></b></td>
		</tr>
		<tr>
			<td style="text-align: center; width: 640px; padding: 5px; font-size: 12px; font-family:timesnewromanmtstd;"><br><br>DURANTE EL PERIODO:</td>
		</tr>
		<tr>
			<td style="text-align: center; width: 640px; padding: 5px; font-size: 12px; font-family:timesnewromanmtstdb; border-bottom: 1px solid black;"><br><b><?php echo strtoupper(obtFechConst($prac[0]['Pra_ini'])); ?> - <?php echo strtoupper(obtFechConst($prac[0]['Pra_fin'])); ?></b></td>
		</tr>

		<tr>
			<td style="text-align: center; width: 640px; padding: 5px; font-size: 12px; font-family:timesnewromanmtstd;"><br><br>Y PARA LOS FINES  LEGALES PROCEDENTES, SE EXTIENDE LA PRESENTE<br>EN LA CIUDAD DE VILLAHERMOSA, TAB.</td>
		</tr>
		<tr>
			<td style="text-align: center; width: 640px; padding: 5px; font-size: 12px; font-family:timesnewromanmtstdb; "><br>EL DIA <b> <?php echo strtoupper(obtFechConst($prac[0]['_cer_fecha_liberacion'])); ?></b></td>
		</tr>
	</table>


	<table style="margin-left: 0px; margin-top: 50px; font-size: 13px; border-collapse: collapse;">
		
		<tr>
			<td style="text-align: center; width: 640px; padding: 5px;">
			<b>Atentamente</b><br>
			“<i>Educación con Valor</i>”<br><br><br><br><br><br>
			<b>
			<?php echo $firma[0]['Nombre'].' '.$firma[0]['APaterno'].' '.$firma[0]['AMaterno']; ?><br><?php echo $firma[0]['Cargo']; ?>
			
			</b>
			
			</td>
		</tr>
		<tr>
			<td style="text-align: center; width: 640px; padding: 5px;">
				<img src="../../assets/images/campus/sello.png" style="width:150px; margin-top: -150px; margin-left: 300px;" ;>
			</td>
		</tr>
		<tr>
			<td style="text-align: center; width: 640px; padding: 5px;">
				<?php if($firma[0]['id_paquete']){ ?>
					<img src="../../assets/firma/<?php echo $firma[0]['id_paquete']; ?>" style="width:200px; margin-top: -180px;" ;>
				<?php }?>
				
			</td>
		</tr>
	</table>
	<!-- Fin del cuerpo de la hoja -->
</page>