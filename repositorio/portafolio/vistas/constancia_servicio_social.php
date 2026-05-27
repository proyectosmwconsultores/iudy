<?php
if($_SESSION['Permisos']){
	include('numeros.php');
	require_once'../portafolio.php';
	$t=new Imprimir();
	$tokenId = substr($_GET["tokenId"], 10,10);
	$serv=$t->get_const_ser_soc($tokenId);
	$firma=$t->get_lstFir($serv[0]['IdCampus'],3);
	$dat=$t->get_menDatos($serv[0]['IdGrupo']);

	$_SESSION["nom_file"] = 'CONSTANCIA_SERVICIO_SOCIAL_'.$serv[0]['Nombre'].' '.$serv[0]['APaterno'].' '.$serv[0]['AMaterno'];


?>
<!-- IMPORTANTE: El contenido de la etiqueta style debe estar entre comentarios de HTML -->
<style>
<!--

table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
		font-size: 10px;

}

td, th {
    border: 0.5px solid black;
    padding: 2px;
}
tr:nth-child(even) {
    background-color: #dddddd;
}

-->
</style>

<!-- page define la hoja con los márgenes señalados -->
<page backtop="45mm" backbottom="20mm" backleft="10mm" backright="10mm">
	<page_header> <!-- Define el header de la hoja -->
		<table style='margin-left: 42px; margin-top: 50px;'>
			<tr>
				<td style="width: 150px; border: none; "><img src="../../assets/images/campus/logo_chiapas_servicio.png" style="width: 50%; " ></td>
				<td style="width: 355px; text-align: center; border: none;">
					<b style='font-size: 19px;'>GOBIERNO DEL ESTADO DE CHIAPAS</b><br>
					<b style='font-size: 18px;'>SECRETARÍA DE EDUCACIÓN</b><br>
					<b style='font-size: 13px;'>SUBSECRETARÍA DE EDUCACIÓN ESTATAL<br>
					DIRECCIÓN DE EDUCACIÓN SUPERIOR<br>
					DEPARTAMENTO DE SERVICIOS ESCOLARES</b><br><br>
					<?php echo $dat[0]['Rvoe']; ?>
				</td>
				<td style="width: 150px; border: none;"></td>
			</tr>
		</table>

	</page_header>

	<page_footer> <!-- Define el footer de la hoja -->
	<table style="margin-left: 43px;">
		<tr>
			<td style="width: 40px; text-align: center; border: none; "></td>
			<td style="width: 270px; text-align: center; border: none; "><?php echo $firma[0]['Departamento']; ?><br>____________________________________________________</td>
			<td style="width: 20px; text-align: center; border: none; "></td>
			<td style="width: 270px; text-align: center; border: none; "><?php echo $firma[0]['Servicio']; ?><br>____________________________________________________</td>
			<td style="width: 40px; text-align: center; border: none; "></td>
		</tr>
		<tr>
			<td style="width: 40px; text-align: center; border: none; "></td>
			<td style="width: 270px; text-align: center; border: none; "><b>JEFA DEL DEPARTAMENTO DE SERVICIOS ESCOLARES</b></td>
			<td style="width: 20px; text-align: center; border: none; "></td>
			<td style="width: 270px; text-align: center; border: none; "><b>POR LA INSTITUCIÓN EDUCATIVA</b></td>
			<td style="width: 40px; text-align: center; border: none; "></td>
		</tr>
	</table><br><br><br>

	</page_footer>


<p style='text-align: center; margin-top: 0px;'>
	<img src="../../assets/images/campus/servicio_social.png" style="width: 280px; " >
</p>
	<p style='text-align: center; font-size: 68px; margin-top: -380px; margin-left: 10px;'><b>C o n s t a n c i a</b></p>
	<table style="margin-left: 10px; margin-top: -50px; ">
			<tr>
				<td colspan='5' style="width: 400px; font-size: 13px; text-align: center; border-left: none; border-top: none; border-right: none;">
					<b style='font-size: 14px;'>DE SERVICIO SOCIAL QUE SE OTORGA A</b><br><br><br>
					<?php echo $serv[0]['Nombre'].' '.$serv[0]['APaterno'].' '.$serv[0]['AMaterno']; ?>
				</td>
			</tr>
			<tr>
				<td colspan='5' style="width: 400px; font-size: 13px; text-align: center; border-left: none; border-top: none; border-right: none;">
					<b style='font-size: 14px;'>DE LA CARRERA</b><br><br><br>
					<?php echo $serv[0]['Educativa']; ?>
				</td>
			</tr>
			<tr>
				<td colspan='5' style="width: 400px; font-size: 13px; text-align: center; border-left: none; border-top: none; border-right: none;">
					<b style='font-size: 14px;'><br>EN LA INSTITUCIÓN EDUCACTIVA</b><br><br>
					<?php echo $dat[0]['Escuela']; ?>
				</td>
			</tr>
			<tr>
				<td colspan='5' style="width: 400px; font-size: 13px; text-align: center; border-left: none; border-top: none; border-right: none;">
					<b style='font-size: 14px;'><br>REGISTRO No.</b><br><br><br>
					<?php echo $serv[0]['Registro']; ?>
				</td>
			</tr>
			<tr>
				<td colspan='5' style="width: 400px; font-size: 13px; text-align: center; border-left: none; border-top: none; border-right: none;">
					<b style='font-size: 14px;'><br>POR HABER PRESENTADO SU SERVICIO SOCIAL<br>EN EL PROGRAMA</b><br><br><br>
					<?php echo $serv[0]['NomPrograma']; ?>
				</td>
			</tr>
			<tr>
				<td colspan='5' style="width: 400px; font-size: 13px; text-align: center; border-left: none; border-top: none; border-right: none;">
					<b style='font-size: 14px;'><br>EN</b><br><br><br>
					<?php echo $serv[0]['NomDependencia']; ?>
				</td>
			</tr>
			<tr>
				<td colspan='5' style="width: 400px; font-size: 13px; text-align: center; border-left: none; border-top: none; border-right: none;">
					<b style='font-size: 14px;'><br>DURANTE EL PERIODO</b><br><br><br>
					<?php echo $serv[0]['Periodo']; ?>
				</td>
			</tr>
			<tr>
				<td colspan='5' style="width: 400px; font-size: 13px; text-align: center; border-left: none; border-top: none; border-right: none;">
					<b style='font-size: 14px;'><br>CON DURACIÓN DE </b><br><br><br>
					480 HORAS
				</td>
			</tr>
			<tr>
				<td colspan='5' style="width: 400px; font-size: 13px; text-align: center; border-left: none; border-top: none; border-right: none;">
					<b style='font-size: 14px;'><br>Y PARA LOS EFECTOS PROCEDENTES SE EXTIENDE<br>LA PRESENTE CONSTANCIA<br>EN LA CIUDAD DE</b><br><br><br>
					<?php echo $dat[0]['Localidad']; ?>
				</td>
			</tr>
			<tr>
				<td colspan='5' style="width: 400px; font-size: 13px; text-align: center; border-left: none; border-top: none; border-right: none; padding: 5px;">
				<b style='font-size: 14px; '><?php echo obt_fec_imp_ser($serv[0]['FecImpresion']); ?></b>
				</td>
			</tr>
			<tr>
				<td style="width: 20px; text-align: center; border: none;"></td>
				<td style="width: 80px; text-align: center; border: none;"></td>
				<td style="width: 334px; text-align: center; border: none;"></td>
				<td style="width: 80px; text-align: center; border: none;"></td>
				<td style="width: 120px; text-align: center; border: none;"></td>
			</tr>
	</table>
</page>
<?php } else {
	echo "<script type='text/javascript'>window.close();</script>";
} ?>
