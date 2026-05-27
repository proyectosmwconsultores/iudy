<?php
if($_SESSION['Permisos']){
	include('numeros.php');
	require_once'../portafolio.php';
	$t=new Imprimir();
	$IdGrupo = $_GET["IdGrupo"];
	$hrs=$t->get_horario(substr($IdGrupo,10,10));
	$_en1=$t->get_encz1(substr($IdGrupo,10,10));
	$_en2=$t->get_encz2(substr($IdGrupo,10,10));
	// $encabz=$t->get_encabezado1($IdAsignacion);
	$s = '';
	$c = '';
	if(($_en1[0]['Modalidad'] == 'S') || ($_en1[0]['Modalidad'] == 'D')){
		$s = '';
		$c = $_en2[0]['Grado'];
	} else {
		$s = $_en2[0]['Grado'];
		$c = '';
	}
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
    border: 1px solid #dddddd;
    padding: 2px;
}
tr:nth-child(even) {
    background-color: #dddddd;
}

-->
</style>

<!-- page define la hoja con los márgenes señalados -->
<page backtop="49mm" backbottom="20mm" backleft="10mm" backright="10mm">
	<page_header> <!-- Define el header de la hoja -->

	<table style='font-size: 9px; margin-top: 50px; margin-left: 38px;'>
			<tr>
				<td rowspan='2' style="width: 157px;"><img src="../../assets/images/campus/logo_inicio.png" style="width: 90px;" ></td>
				<td style="width: 685px; font-size: 12px; text-align: center;"><b>FORMATO DE HORARIO DE CLASES</b></td>
				<td rowspan='2' style="width: 157px; text-align: center; font-size: 12px;"><b>SAC-FOR-09</b></td>
			</tr>
			<tr>
				<td style="width: 685px; font-size: 12px; text-align: center;"><b>SECRETARIA ACADEMICA</b></td>
			</tr>
	</table>

	<table style='font-size: 9px; margin-top: 20px; margin-left: 38px;'>
			<tr>
				<td style="width: 157px;"><b>NIVEL:</b></td>
				<td style="width: 165px;"><?php echo $_en1[0]['Descripcion']; ?></td>
				<td style="width: 157px;"><b>SEMESTRE:</b></td>
				<td style="width: 165px;"><?php echo $s; ?></td>
				<td style="width: 157px;"><b>ESPECIALIAD:</b></td>
				<td style="width: 165px;"></td>
			</tr>
			<tr>
				<td style="width: 157px;"><b>PERIODO ESCOLAR:</b></td>
				<td style="width: 165px;"><?php echo $_en2[0]['Ciclo']; ?></td>
				<td style="width: 157px;"><b>CUATRIMESTRE:</b></td>
				<td style="width: 165px;"><?php echo $c; ?></td>
				<td style="width: 157px;"><b>TURNO:</b></td>
				<td style="width: 165px;"><?php echo $_en1[0]['Turno']; ?></td>
			</tr>
	</table>

	</page_header>

	<page_footer> <!-- Define el footer de la hoja -->
	<table>
		<tr>
			<td style="width: 550px; text-align: center; border: none; ">______________________________</td>
			<td style="width: 550px; text-align: center; border: none; ">______________________________</td>
		</tr>
		<tr>
			<td style="width: 550px; text-align: center; border: none;">Nombre y Firma del Docente</td>
			<td style="width: 550px; text-align: center; border: none;">Coordinación de Servicios Escolares</td>
		</tr>
	</table><br><br>
	</page_footer>

	<?php $x= 0; for ($i=0;$i< 1;$i++) { ?>  <!-- Define el cuerpo de la hoja -->
		<?php if(($_en1[0]['Modalidad'] == 'S') || ($_en1[0]['Modalidad'] == 'D')){ ?>
			<table style='font-size: 9px;'>
					<tr>
						<td rowspan='2' style="width: 10px;"><b>No</b></td>
						<td rowspan='2' style="width: 250px;"><b>MATERIA</b></td>
						<td rowspan='2' style="width: 60px; text-align: center;"><b>CLAVE<br>MATERIA</b></td>
						<td rowspan='2' style="width: 60px; text-align: center;"><b>CLAVE<br>LIBRO</b></td>
						<td rowspan='2' style="width: 60px; text-align: center;"><b>CLAVE PLANEACIÓN</b></td>
						<td rowspan='2' style="width: 10px; text-align: center;"><b>H</b></td>
						<td colspan='2' style="width: 100px; text-align: center;"><b>SÁBADO</b></td>
						<td colspan='2' style="width: 100px; text-align: center;"><b>DOMINGO</b></td>
						<td rowspan='2' style="width: 240px; text-align: center;"><b>PROFESOR</b></td>
					</tr>
					<tr>

						<td style="width: 55px; text-align: center;"><b>1 MÓDULO</b></td>
						<td style="width: 55px; text-align: center;"><b>2 MÓDULO</b></td>
						<td style="width: 55px; text-align: center;"><b>1 MÓDULO</b></td>
						<td style="width: 55px; text-align: center;"><b>2 MÓDULO</b></td>

					</tr>

					<?php   for ($y=0;$y< sizeof($hrs);$y++) { $x = $x + 1; ?>
						<tr>
							<td style="width: 10px;"><?php echo $x; ?></td>
							<td style="width: 250px;"><?php echo $hrs[$y]['NombreMod'] ?></td>
							<td style="width: 60px; text-align: center;"><?php echo substr($hrs[$y]['CodeModulo'],0,6); ?></td>
							<td style="width: 60px; text-align: center;">LC-<?php echo substr($hrs[$y]['CodeModulo'],0,6); ?></td>
							<td style="width: 60px; text-align: center;">PE-<?php echo substr($hrs[$y]['CodeModulo'],0,6); ?></td>
							<td style="width: 10px; text-align: center;"><?php echo $hrs[$y]['Total'] ?></td>
							<td style="width: 55px; text-align: center;"><?php if($hrs[$y]['IdDia'] == 6){ if($hrs[$y]['Modulo'] == 1){ echo $hrs[$y]['HraIni'].':'.$hrs[$y]['MinIni'].' - '.$hrs[$y]['HraFin'].' '.$hrs[$y]['MinFin']; } } ?></td>
							<td style="width: 55px; text-align: center;"><?php if($hrs[$y]['IdDia'] == 6){ if($hrs[$y]['Modulo'] == 2){ echo $hrs[$y]['HraIni'].':'.$hrs[$y]['MinIni'].' - '.$hrs[$y]['HraFin'].' '.$hrs[$y]['MinFin']; } } ?></td>
							<td style="width: 55px; text-align: center;"><?php if($hrs[$y]['IdDia'] == 7){ if($hrs[$y]['Modulo'] == 1){ echo $hrs[$y]['HraIni'].':'.$hrs[$y]['MinIni'].' - '.$hrs[$y]['HraFin'].' '.$hrs[$y]['MinFin']; } } ?></td>
							<td style="width: 55px; text-align: center;"><?php if($hrs[$y]['IdDia'] == 7){ if($hrs[$y]['Modulo'] == 2){ echo $hrs[$y]['HraIni'].':'.$hrs[$y]['MinIni'].' - '.$hrs[$y]['HraFin'].' '.$hrs[$y]['MinFin']; } } ?></td>
							<td style="width: 240px; text-align: center;"><?php echo $hrs[$y]['Nombre'].' '.$hrs[$y]['APaterno'].' '.$hrs[$y]['AMaterno']; ?></td>
						</tr>
					<?php }  ?>
			</table>
		<?php } else { ?>
			<table style='font-size: 9px;'>
					<tr>
						<td style="width: 10px;"><b>No</b></td>
						<td style="width: 220px;"><b>MATERIA</b></td>
						<td style="width: 50px; text-align: center;"><b>CLAVE MATERIA</b></td>
						<td style="width: 50px; text-align: center;"><b>CLAVE LIBRO</b></td>
						<td style="width: 50px; text-align: center;"><b>CLAVE PLANEACIÓN</b></td>
						<td style="width: 10px; text-align: center;"><b>H</b></td>
						<td style="width: 50px; text-align: center;"><b>LUNES</b></td>
						<td style="width: 50px; text-align: center;"><b>MARTES</b></td>
						<td style="width: 50px; text-align: center;"><b>MIÉRCOLES</b></td>
						<td style="width: 50px; text-align: center;"><b>JUEVES</b></td>
						<td style="width: 50px; text-align: center;"><b>VIERNES</b></td>
						<td style="width: 200px; text-align: center;"><b>PROFESOR</b></td>
					</tr>
					<?php   for ($y=0;$y< sizeof($hrs);$y++) { $x = $x + 1; ?>
						<tr>
							<td style="width: 10px;"><?php echo $x; ?></td>
							<td style="width: 220px;"><?php echo $hrs[$y]['NombreMod'] ?></td>
							<td style="width: 70px; text-align: center;"><?php echo substr($hrs[$y]['CodeModulo'],0,6); ?></td>
							<td style="width: 70px; text-align: center;">LC-<?php echo substr($hrs[$y]['CodeModulo'],0,6); ?></td>
							<td style="width: 70px; text-align: center;">PE-<?php echo substr($hrs[$y]['CodeModulo'],0,6); ?></td>
							<td style="width: 10px; text-align: center;"><?php echo $hrs[$y]['Total'] ?></td>
							<td style="width: 50px; text-align: center;"><?php if($hrs[$y]['IdDia'] == 1){ echo $hrs[$y]['HraIni'].':'.$hrs[$y]['MinIni'].' - '.$hrs[$y]['HraFin'].' '.$hrs[$y]['MinFin']; } ?></td>
							<td style="width: 50px; text-align: center;"><?php if($hrs[$y]['IdDia'] == 2){ echo $hrs[$y]['HraIni'].':'.$hrs[$y]['MinIni'].' - '.$hrs[$y]['HraFin'].' '.$hrs[$y]['MinFin']; } ?></td>
							<td style="width: 50px; text-align: center;"><?php if($hrs[$y]['IdDia'] == 3){ echo $hrs[$y]['HraIni'].':'.$hrs[$y]['MinIni'].' - '.$hrs[$y]['HraFin'].' '.$hrs[$y]['MinFin']; } ?></td>
							<td style="width: 50px; text-align: center;"><?php if($hrs[$y]['IdDia'] == 4){ echo $hrs[$y]['HraIni'].':'.$hrs[$y]['MinIni'].' - '.$hrs[$y]['HraFin'].' '.$hrs[$y]['MinFin']; } ?></td>
							<td style="width: 50px; text-align: center;"><?php if($hrs[$y]['IdDia'] == 5){ echo $hrs[$y]['HraIni'].':'.$hrs[$y]['MinIni'].' - '.$hrs[$y]['HraFin'].' '.$hrs[$y]['MinFin']; } ?></td>
							<td style="width: 200px; text-align: center;"><?php echo $hrs[$y]['Nombre'].' '.$hrs[$y]['APaterno'].' '.$hrs[$y]['AMaterno']; ?></td>
						</tr>
					<?php }  ?>
			</table>

		<?php } ?>




	<!-- Fin del cuerpo de la hoja -->
	<?php } ?>

</page>
<?php } else {
	echo "<script type='text/javascript'>window.close();</script>";
} ?>
