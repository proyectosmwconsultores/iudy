<?php
session_start();
if($_SESSION['Permisos']){
	include("consultas.php");
	include("numeros.php");

	$t=new Imprimir();

	$idCiclo = substr($_GET["idCiclo"], 10,10);
	$idGrupo = substr($_GET["idGrupo"], 10,10);

	// $lstGrp=$t->get_calificacion_grupo_final($IdAsignacion);
	// $encabz=$t->get_datos_impresion($IdAsignacion);
	$grp=$t->get_dat_grupo($idGrupo);
	$cic=$t->get_dat_cic($idCiclo);
	$campus=$t->get_campus_id($grp[0]['IdCampus']);
	$lst_us=$t->get_lst_us($idCiclo,$idGrupo);
	$firma=$t->get_lstFir($grp[0]['IdCampus'],$grp[0]['IdGrado']);

?>
<!-- IMPORTANTE: El contenido de la etiqueta style debe estar entre comentarios de HTML -->
<style>
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

td, th {
    padding: 2px;
}
tr:nth-child(even) {
    /* background-color: #dddddd; */
}

</style>
<title>Registro de regularizacion de estudios</title>
<!-- page define la hoja con los márgenes señalados -->
<page backtop="60mm" backbottom="20mm" backleft="10mm" backright="10mm">
	<page_header> <!-- Define el header de la hoja -->
		<table style='margin-left: 0px; margin-top: 50px;'>
			<tr>
				<td style="width: 150px; border: none; "><img src="../assets/images/campus/log_estado_chiapas.jpg" style="width: 80%; " ></td>
				<td style="width: 355px; text-align: center; border: none;">
					SECRETARÍA DE EDUCACIÓN<br>
					SUBSECRETARÍA DE EDUCACIÓN ESTATAL<br>
					DIRECCION DE EDUCACIÓN SUPERIOR<br>
					DEPARTAMENTO DE SERVICIOS ESCOLARES
				</td>
				<td style="width: 150px; border: none;"><img src="../assets/images/campus/logo_inicio.png" style="width: 130px; margin-left: 30px;" ></td>
			</tr>
		</table><br>
		<table style='margin-left: 0px;'>
			<tr>
				<td style='width: 75px; border: none;'></td>
				<td style='width: 75px; border: none;'></td>
				<td style='width: 45px; border: none;'></td>
				<td style='width: 70px; border: none;'></td>
				<td style='width: 45px; border: none;'></td>
				<td style='width: 120px; border: none;'></td>
				<td style='width: 186px; border: none;'></td>
			</tr>
			<tr>
				<td colspan='2' style='width: 150px; border: none;'>NOMBRE DE LA ESCUELA:</td>
				<td colspan='5' style='width: 400px; text-align: center; border-bottom: 1px solid black;'><?php echo $campus[0]['Campus']; ?></td>
			</tr>
			<tr>
				<td style='width: 70px; border: none;'>UBICACION:</td>
				<td colspan='6' style='width: 400px; text-align: center; border-bottom: 1px solid black;'><?php echo $campus[0]['Direccion']; ?></td>
			</tr>
			<tr>
				<td style='width: 75px; border: none;'>TURNO: </td>
				<td colspan='2' style='width: 75px; text-align: center; border-bottom: 1px solid black;'><?php echo $grp[0]['_Modalidad']; ?></td>
				<td style='width: 70px; text-align: right; border-right: none; border-bottom: none;'>CLAVE: </td>
				<td style='width: 45px; text-align: center; border-bottom: 1px solid black;'>6015</td>
				<td style='width: 120px; text-align: right; border-right: none; border-bottom: none;'>CICLO ESCOLAR: </td>
				<td style='width: 186px; text-align: center; border-bottom: 1px solid black;'><?php echo $cic[0]['Periodo']; ?></td>
			</tr>
			<tr>
				<td colspan='2' style='width: 150px; border: none;'>GRADO O CUATRIMESTRE: </td>
				<td style='width: 45px; text-align: center; border-bottom: 1px solid black;'><?php echo $_GET["Grado"]; ?>°</td>
				<td style='width: 70px; text-align: right; border-bottom: none; border-right: none;'>GRUPO: </td>
				<td style='width: 45px; text-align: center; border-bottom: 1px solid black;'><?php echo $grp[0]['Grupo']; ?></td>
				<td style='width: 120px; text-align: right; border-bottom: none; border-right: none;'>PERIODO: </td>
				<td style='width: 186px; text-align: center; border-bottom: 1px solid black;'><?php echo $cic[0]['Ciclo']; ?></td>
			</tr>
			<tr>
				<td style='width: 75px; border: none;'>ÁREA:</td>
				<td colspan="6" style='width: 590px; border-bottom: 1px solid black;'><?php echo $grp[0]['Nombre']; ?></td>
			</tr>
		</table>
		<br>
		<table style="margin-left: 4px;">
				<tr>
					<td colspan='5' style="width: 400px; padding: 5px; text-align: center; border-left: none; border-top: none; border-right: none;">REPORTE DE BAJA</td>
				</tr>
				<tr>
					<td style="width: 20px; text-align: center;">N</td>
					<td style="width: 80px; text-align: center;">NO.CONTROL</td>
					<td style="width: 334px; text-align: center;">NOMBRE DEL ALUMNO</td>
					<td style="width: 80px; text-align: center;">FECHA</td>
					<td style="width: 120px; text-align: center;">MOTIVO</td>
				</tr>
				<?php $x= 0; for ($i=0;$i< sizeof($lst_us);$i++) { $x = ($x + 1); ?>
				<tr>
					<td style="width: 20px; text-align: center;"><?php echo $x; ?>.- </td>
					<td style="width: 80px; text-align: center;"><?php if(isset($lst_us[$i]['Usuario'])){ echo $lst_us[$i]['Usuario']; } ?></td>
					<td style="width: 334px; text-align: left;"><?php if(isset($lst_us[$i]['Usuario'])){ echo $lst_us[$i]['Nombre']; } ?></td>
					<td style="width: 80px; text-align: center;"><?php if(isset($lst_us[$i]['Usuario'])){ echo $lst_us[$i]['fecha_baja']; } ?></td>
					<td style="width: 120px; text-align: center;"><?php if(isset($lst_us[$i]['Usuario'])){ echo $lst_us[$i]['Estatus']; } ?></td>
				</tr>
				<?php } $num = (15 - $x); ?>
				<?php $v = 0;  for ($y=$i;$y<= $num;$y++) { $x = ($x + 1); $v = ($v + 1); ?>
				<tr>
					<td style="width: 20px; text-align: center;"><?php echo $x; ?>.- </td>
					<td style="width: 80px; text-align: center;"></td>
					<td style="width: 334px; text-align: left;"><?php if($v ==1){ echo "*********************************************************************";} ?></td>
					<td style="width: 80px; text-align: center;"></td>
					<td style="width: 120px; text-align: center;"></td>
				</tr>
				<?php } ?>


		</table>
	</page_header>

	<page_footer> <!-- Define el footer de la hoja -->
	<table style="margin-left: 0px;">
		<tr>
			<td style="width: 80px; text-align: center; border: none; "></td>
			<td style="width: 200px; text-align: center; border: none; ">ELABORÓ<br>EL RESPONSABLE DE SERVICIOS<br>ESCOLARES DEL PLANTEL</td>
			<td style="width: 80px; text-align: center; border: none; "></td>
			<td style="width: 200px; text-align: center; border: none; ">DIRECTOR DE LA ESCUELA</td>
			<td style="width: 80px; text-align: center; border: none; "></td>
		</tr>
		<tr>
			<td style="width: 80px; text-align: center; border: none; "></td>
			<td style="width: 200px; text-align: center; border: none; "><br><br><br><br><?php echo $firma[0]['Elaboro']; ?></td>
			<td style="width: 80px; text-align: center; border: none; "></td>
			<td style="width: 200px; text-align: center; border: none; "><br><br><br><br><?php echo $firma[0]['Rector']; ?></td>
			<td style="width: 80px; text-align: center; border: none; "></td>
		</tr>
		<tr>
			<td colspan='5' style="width: 80px; text-align: center; border: none; "><br><br><br><br></td>
		</tr>
		<tr>
			<td style="width: 80px; text-align: center; border: none; "></td>
			<td style="width: 200px; text-align: center; border: none; ">JEFE DE OFICINA</td>
			<td style="width: 80px; text-align: center; border: none; "></td>
			<td style="width: 200px; text-align: center; border: none; ">Vo.Bo.<br>JEFA DEL DEPARTAMENTO DE<br>SERVICIOS ESCOLARES</td>
			<td style="width: 80px; text-align: center; border: none; "></td>
		</tr>
		<tr>
			<td style="width: 80px; text-align: center; border: none; "></td>
			<td style="width: 200px; text-align: center; border: none; "><br><br><br><br><br><?php echo $firma[0]['Oficina']; ?></td>
			<td style="width: 80px; text-align: center; border: none; "></td>
			<td style="width: 200px; text-align: center; border: none; "><br><br><br><br><br><?php echo $firma[0]['Departamento']; ?></td>
			<td style="width: 80px; text-align: center; border: none; "></td>
		</tr>
		<tr>
			<td colspan='5' style="width: 400px; text-align: center; border: none; "><br><br><br><br><br>FECHA DE LEGALIZACIÓN<br><br></td>
		</tr>


	</table>

	</page_footer>

</page>
<?php } else {
	echo "<script type='text/javascript'>window.close();</script>";
} ?>
