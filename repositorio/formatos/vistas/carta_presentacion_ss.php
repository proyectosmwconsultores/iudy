<?php
require_once '../class_formatos.php';
include("../hace_fecha.php");
//include("hace.php");
$formx = new Formatos();

$IdPractica = substr($_GET['idToks'], 10, 10);

$prac = $formx->obtener_datos_servicio($IdPractica);

//$prac = $formx->obtener_datos_practica($IdPractica);

$rvoe = $formx->get_datos_campus_rvoe($prac[0]['IdUsua']);
$firma = $formx->get_firma_gestion($prac[0]['IdGestion']);

$ini = $prac[0]['Pra_ini'];
$fin = $prac[0]['Pra_fin'];

?>


<!-- page define la hoja con los márgenes señalados -->
<page backtop="10mm" backbottom="10mm" backleft="10mm" backright="10mm">
	<page_header> <!-- Define el header de la hoja -->
		<img src="../../assets/images/campus/fondo.jpg" style="width:101%" ;>

	</page_header>
	<page_footer>
		<table style="margin-left: 42px; margin-top: 8px; border-collapse: collapse;">
			<tr>
				<td colspan="2" style="width: 400px; font-size: 11px;">
				C.c.p. Archivo<br><br></td>
			</tr>
			<tr>
				<td style="width: 400px; font-size: 8px; color: #858585;">
				Carretera Federal Villahermosa-Teapa Km 1<br>
				Col. Plutarco Elías Calles C.P. 86280<br>
				Villahermosa, Tabasco
			</td>
				<td style="width: 250px; font-size: 8px; color: #858585; ">
				Tels.:   993 139 9042<br>
				993 688 78 66<br>
				www.iudysureste.com
			</td>
			</tr>
		</table><br><br><br>
	</page_footer>
	<table style="margin-left: 0px; margin-top: 0px; font-size: 9px; text-align: center;">
		<tr>
			<td style="width: 140px; font-size: 16px; text-align: left; border: none;">
				<img src="../../assets/images/campus/logo_pdf_1.png" style="width: 140px;">
			</td>
			<td style="width: 509px; font-size: 17px; border: none; ">
			    <b style='font-size: 16px'>INSTITUTO UNIVERSITARIO DE YUCATÁN</b>
				
				<p style="font-size: 10px;">INCORPORADO A LA SECRETARÍA DE EDUCACIÓN DEL GOBIERNO DEL ESTADO  DE  TABASCO<br>CON CLAVE DEL CENTRO DE TRABAJO: 27PSU0051Z</p>
			</td>
		</tr>
	</table>

	<table style="margin-left: 0px; margin-top: 50px; font-size: 13px; border-collapse: collapse;">
		<tr>
			<td style="text-align: right; width: 640px; padding: 5px;">Villahermosa, Tabasco, <?php echo obtFechConst($prac[0]['Fecha_impresion']); ?></td>
		</tr>
		<tr>
			<td style="text-align: right; width: 640px; padding: 5px;"><b>Asunto:</b> Carta de Presentación de Servicio Social</td>
		</tr>
		
		<tr>
			<td style="text-align: left; width: 640px; padding: 5px;"><br><br>
				<b><?php echo $prac[0]['Grado_responsable']; ?>. <?php echo $prac[0]['Nombre_responsable']; ?><br>
				<?php echo $prac[0]['Cargo']; ?><br>
				<?php echo $prac[0]['Empresa']; ?><br>
				P R E S E N T E<br><br><br>
				</b>
			</td>
		</tr>
		<tr>
			<td style="text-align: justify; width: 640px; padding: 5px;">
			Agradeciendo la atención de poder recibir a nuestros estudiantes en la Institución a su digno cargo, me permito poner a consideración al (la) siguiente estudiante de la <b><?php echo $prac[0]['Educativa']; ?></b>:<br><br><br>
			</td>
		</tr>
		<tr>
			<td style="text-align: center; width: 640px; padding: 5px;">
			<b style="font-size: 16px;"><?php echo $prac[0]['Nombre']; ?> <?php echo $prac[0]['APaterno']; ?> <?php echo $prac[0]['AMaterno']; ?><br></b>
			<b style="font-size: 14px;">Matricula: <?php echo $prac[0]['Usuario']; ?></b><br><br><br>
			</td>
		</tr>
		<tr>
			<td style="text-align: justify; width: 640px; padding: 5px;">
			Quien a la fecha ha cubierto un 70% de los créditos de dicha licenciatura y se encuentra interesado (a) en realizar <b>“Servicio Social”</b> con el fin de ampliar sus conocimientos y comenzar su desarrollo profesional. El (La) estudiante deberá cubrir 480 horas en un periodo de seis meses, <b>iniciando el <?php echo obtFechConst($ini); ?> y concluyendo el <?php echo obtFechConst($fin); ?>,</b> presentando bimestralmente un reporte de actividades. Las cartas de aceptación y terminación de la prestación del Servicio Social, deberán dirigirse al Rector del Instituto Universitario de Yucatán, Dr. Audiel Hipólito Durán.<br><br><br>
			</td>
		</tr>
		<tr>
			<td style="text-align: justify; width: 640px; padding: 5px;">
			Estando muy agradecido por el apoyo brindado, me suscribo a sus apreciables órdenes.<br><br><br><br><br><br>
			</td>
		</tr>
		<tr>
			<td style="text-align: center; width: 640px; padding: 5px;">
			<b>Atentamente</b><br>
			“<i>Educación con Valor</i>”<br><br><br><br><br><br>
			_________________________________________<br>
			<b>
			Dr. Audiel Hipólito Durán<br>Rector<br>Campus Tabasco
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
				
					<img src="../../assets/firma/rector.png" style="width:200px; margin-top: -180px;" ;>
				
				
			</td>
		</tr>
	</table>
	<!-- Fin del cuerpo de la hoja -->
</page>