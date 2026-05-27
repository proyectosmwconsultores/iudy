<?php
require_once '../class_formatos.php';
include("../hace_fecha.php");
//include("hace.php");
$formx = new Formatos();

$IdPractica = substr($_GET['idToks'], 10, 10);

$prac = $formx->obtener_datos_servicio($IdPractica);
$dom = $formx->obtener_datos_domicilio($prac[0]['IdUsua']);

$rvoe = $formx->get_datos_campus_rvoe($prac[0]['IdUsua']);

$firma = $formx->get_firma_gestion($prac[0]['IdGestion']);

$fecha = $prac[0]['Pra_ini'];
?>


<!-- page define la hoja con los márgenes señalados -->
<page backtop="5mm" backbottom="10mm" backleft="10mm" backright="10mm">
	<page_header> <!-- Define el header de la hoja -->
		<img src="../../assets/images/campus/fondo.jpg" style="width:101%" ;>

	</page_header>
	<page_footer>
		
	</page_footer>
	<table style="margin-left: 0px; margin-top: 0px; font-size: 9px; text-align: center;">
		<tr>
			<td style="width: 110px; font-size: 16px; text-align: left; border: none;">
				<img src="../../assets/images/campus/sec_educacion_tabasco.png" style="width: 100%;">
			</td>
			<td style="text-align: center; width: 460px; font-size: 17px; border: none; margin-left: 40px; ">
				<p style="font-size: 14px;">GOBIERNO DEL ESTADO DE TABASCO<br>SECRETARIA DE EDUCACIÓN<br>SUBSECRETARIA DE EDUCACIÓN MEDIA Y SUPERIOR<br>UNIDAD DE VINCULACION</p>
			</td>
			<td style="width: 100px; font-size: 16px; text-align: left; border: none;">
				<div style="width: 80px; height: 90px; border: 0.5px solid black">
				    
				</div>
			</td>
		</tr>
	</table>

	<table style="margin-left: 0px; margin-top: 20px; font-size: 13px; border-collapse: collapse;">
		<tr>
			<td style="text-align: center; width: 640px; padding: 4px; font-size: 16px;"><b>CARTA DE ASIGNACIÓN DEL SERVICIO SOCIAL</b></td>
		</tr>
		<tr>
			<td style="text-align: right; width: 640px; padding: 4px; font-size: 15px;"><br>NO. REGISTRO: <b>IUDY/<?php echo $prac[0]['Anio']; ?>/<?php echo $prac[0]['Folio']; ?></b></td>
		</tr>
		<tr>
			<td style="text-align: left; width: 640px; padding: 4px; font-size: 15px;"><br><br><b>DATOS GENERALES DEL ALUMNO:</b></td>
		</tr>
	</table>
	<table style="margin-left: 0px; margin-top: 50px; font-size: 13px; border-collapse: collapse;">
		<tr>
			<td style="text-align: center; border-bottom: 0.5 px solid black; width: 205px; padding: 4px; font-size: 12px;"><b><?php echo $prac[0]['APaterno']; ?></b></td>
			<td style="text-align: center; border-bottom: 0.5 px solid black; width: 205px; padding: 4px; font-size: 12px;"><b><?php echo $prac[0]['AMaterno']; ?></b></td>
			<td style="text-align: center; border-bottom: 0.5 px solid black; width: 205px; padding: 4px; font-size: 12px;"><b><?php echo $prac[0]['Nombre']; ?></b></td>
		</tr>
		<tr>
			<td style="text-align: center; width: 205px; padding: 4px; font-size: 8px;">APELLIDO PATERNO</td>
			<td style="text-align: center; width: 205px; padding: 4px; font-size: 8px;">APELLIDO MATERNO</td>
			<td style="text-align: center; width: 205px; padding: 4px; font-size: 8px;">NOMBRE (S)</td>
		</tr>
	</table>
	<table style="margin-left: 0px; font-size: 13px; border-collapse: collapse; margin-top: 10px;">
		<tr>
			<td style="text-align: center; border-bottom: 0.5 px solid black; width: 350px; padding: 4px; font-size: 11px;"><?php echo $dom[0]['D_direccion']; ?></td>
			<td style="text-align: center; border-bottom: 0.5 px solid black; width: 30px; padding: 4px; font-size: 11px;"><?php echo $dom[0]['D_cp']; ?></td>
			<td style="text-align: center; border-bottom: 0.5 px solid black; width: 50px; padding: 4px; font-size: 11px;"><?php echo $prac[0]['Celular']; ?></td>
			<td style="text-align: center; border-bottom: 0.5 px solid black; width: 170px; padding: 4px; font-size: 11px;"><?php echo $dom[0]['Nom_municipio']; ?>, <?php echo $dom[0]['Estado']; ?></td>
		</tr>
		<tr>
			<td style="text-align: center; width: 350px; padding: 4px; font-size: 8px;">DOMICILIO</td>
			<td style="text-align: center; width: 30px; padding: 4px; font-size: 8px;">C.P.</td>
			<td style="text-align: center; width: 50px; padding: 4px; font-size: 8px;">CEL.</td>
			<td style="text-align: center; width: 170px; padding: 4px; font-size: 8px;">LOCALIDAD</td>
		</tr>
	</table>

	<table style="margin-left: 0px; font-size: 13px; border-collapse: collapse; margin-top: 10px;">
		<tr>
			<td style=" width: 150px; padding: 4px; font-size: 11px;"><b>ESTUDIOS QUE REALIZA:</b></td>
			<td style="text-align: left; border-bottom: 0.5 px solid black; width: 340px; padding: 4px; font-size: 11px;"><?php echo $prac[0]['Educativa']; ?></td>
			<td style="text-align: center; width: 90px; padding: 4px; font-size: 11px;"><b>CUATRIMESTRE:</b></td>
			<td style="text-align: center; border-bottom: 0.5 px solid black; width: 20px; padding: 4px; font-size: 11px;"><?php echo $prac[0]['Grado']; ?>°</td>
		</tr>
	</table>
	<table style="margin-left: 0px; margin-top: 30px; font-size: 13px; border-collapse: collapse;">
		<tr>
			<td style="text-align: left; width: 640px; padding: 4px; font-size: 15px;"><b>INSTITUCIÓN EDUCATIVA:</b></td>
		</tr>
	</table>
	<table style="margin-left: 0px; font-size: 13px; border-collapse: collapse; margin-top: 10px;">
		<tr>
			<td style=" width: 70px; padding: 4px; font-size: 11px;"><b>NOMBRE:</b></td>
			<td style="text-align: left; border-bottom: 0.5 px solid black; width: 560px; padding: 4px; font-size: 11px;">INSTITUTO UNIVERSITARIO DE YUCATÁN</td>
		</tr>
		<tr>
			<td style=" width: 70px; padding: 4px; font-size: 11px;"><b>DIRECCIÓN:</b></td>
			<td style="text-align: left; border-bottom: 0.5 px solid black; width: 560px; padding: 4px; font-size: 11px;">CARRETERA VHSA-TEAPA KM. 1 COL. PLUTARCO ELÍAS CALLES, CENTRO.</td>
		</tr>
	</table>
	<table style="margin-left: 0px; margin-top: 30px; font-size: 13px; border-collapse: collapse;">
		<tr>
			<td style="text-align: left; width: 640px; padding: 4px; font-size: 15px;"><b>DEPENDENCIA, INSTITUCIÓN U ORGANISMO:</b></td>
		</tr>
	</table>
	<table style="margin-left: 0px; font-size: 13px; border-collapse: collapse; margin-top: 10px;">
		<tr>
			<td style=" width: 70px; padding: 4px; font-size: 11px;"><b>NOMBRE:</b></td>
			<td style="text-align: left; border-bottom: 0.5 px solid black; width: 560px; padding: 4px; font-size: 11px;"><?php echo $prac[0]['Empresa']; ?></td>
		</tr>
		<tr>
			<td style=" width: 70px; padding: 4px; font-size: 11px;"><b>DIRECCIÓN:</b></td>
			<td style="text-align: left; border-bottom: 0.5 px solid black; width: 560px; padding: 4px; font-size: 11px;"><?php echo $prac[0]['Domicilio']; ?></td>
		</tr>
	</table>
	<table style="margin-left: 0px; font-size: 13px; border-collapse: collapse;">
		<tr>
			<td style=" width: 100px; padding: 4px; font-size: 11px;"><b>CODIGO POSTAL:</b></td>
			<td style="text-align: center; border-bottom: 0.5 px solid black; width: 40px; padding: 4px; font-size: 11px;"><?php echo $prac[0]['CP']; ?></td>
			<td style="text-align: right; width: 80px; padding: 4px; font-size: 11px;"><b>TELEFONO:</b></td>
			<td style="text-align: center; border-bottom: 0.5 px solid black; width: 100px; padding: 4px; font-size: 11px;"><?php echo $prac[0]['Telefono']; ?></td>
		</tr>
	</table>
	<table style="margin-left: 0px; font-size: 13px; border-collapse: collapse;">
		<tr>
			<td style=" width: 130px; padding: 4px; font-size: 11px;"><b>ÁREA DE ASIGNACIÓN:</b></td>
			<td style="text-align: left; border-bottom: 0.5 px solid black; width: 500px; padding: 4px; font-size: 11px;"><?php echo $prac[0]['Area_asignado']; ?></td>
		</tr>
	</table>
	<table style="margin-left: 0px; font-size: 13px; border-collapse: collapse;">
		<tr>
			<td style=" width: 180px; padding: 4px; font-size: 11px;"><b>ACTIVIDADES A DESARROLLAR:</b></td>
			<td style="text-align: left; border-bottom: 0.5 px solid black; width: 450px; padding: 4px; font-size: 11px;">LAS QUE SE INDIQUEN</td>
		</tr>
	</table>
	<table style="margin-left: 0px; font-size: 13px; border-collapse: collapse; margin-top: 5px;">
		<tr>
			<td style=" width: 120px; padding: 4px; font-size: 11px;"><b>TOTAL DE HORAS:</b></td>
			<td style="text-align: center; border-bottom: 0.5 px solid black; width: 80px; padding: 4px; font-size: 11px;">480</td>
			<td style="text-align: right; width: 230px; padding: 4px; font-size: 11px;"><b>FECHA DE ELABORACION:</b></td>
			<td style="text-align: center; border-bottom: 0.5 px solid black; width: 170px; padding: 4px; font-size: 11px;"><?php echo obtFechConst($fecha); ?></td>
		</tr>
	</table>
	<table style="margin-left: 0px; font-size: 13px; border-collapse: collapse; margin-top: 5px;">
		<tr>
			<td style=" width: 160px; padding: 4px; font-size: 11px;"><b>PERIODO DE PRESTACIÓN:</b></td>
			<td style="text-align: left; border-bottom: 0.5 px solid black; width: 470px; padding: 4px; font-size: 11px;"><?php echo obtFechConst($prac[0]['Pra_ini']); ?> al <?php echo obtFechConst($prac[0]['Pra_fin']); ?></td>
		</tr>
	</table>
	
	<table style="margin-left: 0px; margin-top: 50px; font-size: 10px; border-collapse: collapse;">
		<tr>
			<td style="text-align: center; border-bottom: 0.5px solid black; width: 265px; padding: 4px; font-size: 10px;"><b>DR. AUDIEL HIPOLITO DURAN</b></td>
			<td style="text-align: center; width: 80px; padding: 4px; font-size: 12px;"></td>
			<td style="text-align: center; border-bottom: 0.5px solid black; width: 265px; padding: 4px; font-size: 10px;"><b><?php echo $prac[0]['Grado_responsable']; ?> <?php echo $prac[0]['Nombre_responsable']; ?></b></td>
		</tr>
		<tr>
			<td style="text-align: center; width: 265px; padding: 4px; font-size: 10px;">RECTOR DE LA INSTITUCION EDUCATIVA</td>
			<td style="text-align: center; width: 80px; padding: 4px; font-size: 12px;"></td>
			<td style="text-align: center; width: 265px; padding: 4px; font-size: 10px;">RESPONSABLE DEL PROGRAMA</td>
		</tr>
	</table>
	<table style="margin-left: 0px; margin-top: 50px; font-size: 10px; border-collapse: collapse;">
		<tr>
			<td style="text-align: center; border-bottom: 0.5px solid black; width: 265px; padding: 4px; font-size: 10px;"><b>LIC. GIULIANA DEL CARMEN NARANJO GÁLVEZ</b></td>
			<td style="text-align: center; width: 80px; padding: 4px; font-size: 12px;"></td>
			<td style="text-align: center; border-bottom: 0.5px solid black; width: 265px; padding: 4px; font-size: 10px;"><b><?php echo $prac[0]['Nombre'].' '.$prac[0]['APaterno'].' '.$prac[0]['AMaterno']; ?></b></td>
		</tr>
		<tr>
			<td style="text-align: center; width: 265px; padding: 4px; font-size: 10px;">JEFA DE LA UNIDAD DE VINCULACION</td>
			<td style="text-align: center; width: 80px; padding: 4px; font-size: 12px;"></td>
			<td style="text-align: center; width: 265px; padding: 4px; font-size: 10px;">PRESTADOR DEL SERVICIO SOCIAL</td>
		</tr>
	</table>
	<!-- Fin del cuerpo de la hoja -->
</page>