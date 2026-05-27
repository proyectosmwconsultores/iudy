<?php
if($_SESSION['Permisos']){
	include('numeros.php');
	include('../hace_fecha.php');
	require_once'../portafolio.php';

	$t=new Imprimir();

	$IdUsua = substr($_GET["idToks"], 10, 10);
	$lstUs=$t->get_sat_us($IdUsua);
	$ced=$t->get_infor_cel($IdUsua);
	$egre=$t->get_infor_egre($lstUs[0]['IdGrupo']);

	if($lstUs[0]['TipoCiclo'] == 'C'){ $tipC = 'CUATRIMESTRE'; } else { $tipC = 'SEMESTRE'; }
	if($lstUs[0]['TipoCiclo'] == 'C'){ $tipCb = 'CUATRIMESTRAL'; } else { $tipCb = 'SEMESTRAL'; }
	// $encabz=$t->get_datos_impresion($IdAsignacion);
	// $campus=$t->get_campus_id($lstGrp[0]['IdCampus']);
	$_SESSION['nomAr'] = 'CEDULA_PRE-EGRESO_'.$lstUs[0]['APaterno'].'_'.$lstUs[0]['AMaterno'].'_'.$lstUs[0]['Nombre']; 
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
<page backtop="30mm" backbottom="20mm" backleft="10mm" backright="10mm">
	<page_header> <!-- Define el header de la hoja -->

	<img src="../../assets/images/campus/hoja_arriba.png" style="width: 100%;" >
	</page_header>

	<page_footer> <!-- Define el footer de la hoja -->

	</page_footer>
	<p style="text-align: center; font-size: 21px;"> <b>CÉDULA DE PRE-EGRESO: </b>  </p>
	<p style="text-align: right; margin-right: 15px; font-size: 14px; color: red;"> <b style="color: black;">FOLIO:</b> <?php echo $ced[0]['Folio_egreso']; ?></p>
	<table style='margin-left: 4px; '>
		<tr>
			<td style='width: 675px; border-radius: 20px;'>
				<table style='margin-left: 10px; margin-top: 10px;'>
					<tr>
						<td colspan='6' style='width: 500px; border: none; text-align: center; height: 40px;'><b>DATOS PERSONALES DEL ALUMNO</b><br></td>
					</tr>
					<tr>
						<td style='width: 120px; text-align: right; background: #dadada; border: 1px solid white;'><b>NOMBRE</b>:</td>
						<td colspan='3' style='width: 250px; border: 1px solid white;'><?php echo $lstUs[0]['APaterno'].' '.$lstUs[0]['AMaterno'].' '.$lstUs[0]['Nombre']; ?></td>
						<td style='width: 80px; background: #dadada; border: 1px solid white; text-align: right;'><b>CONTROL:</b></td>
						<td style='width: 150px; border: 1px solid white;'><?php echo $lstUs[0]['Usuario']; ?></td>
					</tr>
					<tr>
						<td style='width: 120px; text-align: right; background: #dadada; border: 1px solid white;'><b>AREA</b>:</td>
						<td colspan='5' style='width: 400px; border: 1px solid white;'><?php echo $lstUs[0]['Educativa']; ?></td>
					</tr>
					<tr>
						<td style='width: 120px; background: #dadada; border: 1px solid white; text-align: right;'><b><?php echo $tipC; ?>:</b></td>
						<td style='width: 50px; border: 1px solid white; text-align: center;'><?php echo $egre[0]['Grado']; ?>°</td>
						<td style='width: 60px; background: #dadada; border: 1px solid white; text-align: right;'><b>GRUPO:</b></td>
						<td style='width: 100px; border: 1px solid white; '><?php echo $lstUs[0]['Grupo']; ?></td>
						<td style='width: 80px; background: #dadada; border: 1px solid white; text-align: right;'><b>CICLO EGRESO:</b></td>
						<td style='width: 150px; border: 1px solid white;'><?php echo $egre[0]['Ciclo']; ?></td>
					</tr>
					<tr>
						<td style='width: 120px; text-align: right; background: #dadada; border: 1px solid white;'><b>DIRECCIÓN</b>:</td>
						<td colspan='5' style='width: 400px; border: 1px solid white;'><?php echo $ced[0]['D_direccion']; ?></td>
					</tr>

					<tr>
						<td style='width: 120px; text-align: right; background: #dadada; border: 1px solid white;'><b>TELÉFONO</b>:</td>
						<td colspan='5' style='width: 400px; border: 1px solid white;'><?php echo $lstUs[0]['Telefono']; ?></td>
					</tr>
					<tr>
						<td style='width: 120px; text-align: right; background: #dadada; border: 1px solid white;'><b>CELULAR</b>:</td>
						<td colspan='5' style='width: 400px; border: 1px solid white;'><?php echo $lstUs[0]['Celular']; ?></td>
					</tr>
					<tr>
						<td colspan='6' style='width: 500px; border: none;'>&nbsp;</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<br><br>

	<br>
	<table style='margin-left: 4px; font-size: 13.5px;'>
		<tr>
			<td style='width: 675px; text-align: justify; border: none;'>
			A quien corresponda:<br><br>
			Por este medio, me permito hacer constar que he concluido el registro en línea de las siguientes encuestas:<br><br>
			&nbsp;&nbsp;&nbsp;&nbsp; * Actualización de Datos Personales<br>
			&nbsp;&nbsp;&nbsp;&nbsp; * Trayectoria Académica<br>
			&nbsp;&nbsp;&nbsp;&nbsp; * Trayectoria Laboral<br><br><br>
			Y anexo al presente la siguiente documentación que me fue solicitada a través del oficio de Solicitud de requisitos de Egreso:<br><br>
			Entrego en tiempo y forma la documentación que se me solicita para la expedición de los documentos oficiales que al egresar me serán entregados.<br><br>
			</td>
		</tr>
		<tr>
			<td style='width: 675px; text-align: center; border: none;'>
			<br><br><br>FIRMA<br><br><br><br>
			<?php echo $lstUs[0]['APaterno'].' '.$lstUs[0]['AMaterno'].' '.$lstUs[0]['Nombre']; ?>
			</td>
		</tr>
		<tr>
			<td style='width: 675px; text-align: justify; font-size: 12px; border: none;'><br><br>
			Aviso de privacidad: Con la firma al calce del presente documento, autorizo que mis datos sean utilizados con fines estadísticos y de localización por el Departamento de Seguimiento de Egresados y por el Departamento de Servicios Escolares.
			</td>
		</tr>
		<tr>
			<td style='width: 675px; text-align: right; font-size: 12px; border: none;'><br><br><br>
			TUXTLA GUTIÉRREZ, CHIAPAS; MÉXICO, <?php echo obtFechMay($ced[0]['Fecha_impresion']); ?>
			</td>
		</tr>
	</table>

</page>
<?php } else {
	echo "<script type='text/javascript'>window.close();</script>";
} ?>
