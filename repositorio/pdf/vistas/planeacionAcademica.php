<?php
session_start();
if($_SESSION['Permisos']){
	require_once'../classprint.php';
	include("numeros.php");
	$t=new Imprimir();
	$datPlan=$t->get_datPlaneacion($_GET["Id"]);
	// $datPlanActiva=$t->get_planActiva($_GET["Id"]);

	$datParcial=$t->get_datParcial($_GET["Id"]);
	$datActividadesLst=$t->get_datActividadesTS($_GET["Id"]);
	$datCosto=$t->get_datCosto($_GET["Id"],$_GET["tok"]);


		if($datPlan[0]["Modalidad"] == "M"){ $mod = "Mixta"; } elseif($datPlan[0]["Modalidad"] == "N"){ $mod = "No Escolarizado"; } elseif($datPlan[0]["Modalidad"] == "E"){ $mod = "Escolarizado"; }


?>
<!-- IMPORTANTE: El contenido de la etiqueta style debe estar entre comentarios de HTML -->
<style>
<!--

table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

td, th {
    border: 1px solid #dddddd;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #dddddd;
}
#texto1 { width: 100px;}
-->
</style>

<!-- page define la hoja con los márgenes señalados -->
<page backtop="15mm" backbottom="20mm" backleft="10mm" backright="10mm">
	<page_header> <!-- Define el header de la hoja -->

	</page_header>

	<page_footer> <!-- Define el footer de la hoja -->
	<div style=" width: 100%; text-align: center;">
	Universidad del Sur <br>
	Hoja [[page_cu]] de [[page_nb]]<br><br>
  </div>



	</page_footer>


		<table>
			<tr style="background: #DDD3D3;">
				<td colspan=2 style="text-align: center; background: #302d91; color: white; width: 994px;"><b>IDENTIFICACIÓN DEL ASESOR ACADÉMICO</b></td>
			</tr>
			<tr>
				<td style="background: #DDD3D3; width: 300px;"><b>Nombre del asesor:</b></td>
				<td style=" width: 600px;"><?php echo $datCosto[0]["Nombre"].' '.$datCosto[0]["APaterno"].' '.$datCosto[0]["AMaterno"]; ?></td>
			</tr>

		</table>
		<br><br><br>


	<table>
		<tr style="background: #DDD3D3;">
			<td colspan=9 style="text-align: center; background: #302d91; color: white;"><b>IDENTIFICACIÓN DE LA ASIGNATURA</b></td>
		</tr>
		<tr>
			<td colspan=3 style="background: #DDD3D3;"><b><?php $ds = substr($datPlan[0]["CodeModulo"], 0, 1);  if($ds == "L"){ echo "Licenciatura"; } else { echo "Maestria"; }?>:</b></td>
			<td colspan=6><?php echo $datPlan[0]["Oferta"]; ?></td>
		</tr>
		<tr>
			<td colspan=3 style="background: #DDD3D3;"><b>Nombre de la asignatura:</b></td>
			<td colspan=6><?php echo $datPlan[0]["NombreMod"]; ?></td>
		</tr>
		<tr>
			<td colspan=3 style="background: #DDD3D3;"><b><?php echo $datPlan[0]["Tipo"]; ?>:</b></td>
			<td colspan=2><?php echo obtenerAbre($datPlan[0]["Grado"]).' '.$datPlan[0]["Tipo"]; ?></td>
			<td colspan=2 style="background: #DDD3D3;"><b>Modalidad:</b> </td>
			<td colspan=2><?php echo $mod; ?></td>
		</tr>

		<tr>
			<td colspan=2 style="background: #DDD3D3;"><b>Horas asignadas:</b></td>
			<td><?php echo $datPlan[0]["HraDia"]; ?> horas </td>
			<td colspan=2 style="background: #DDD3D3;"><b>Horas a la semana:</b> </td>
			<td><?php echo $datPlan[0]["HraSemana"]; ?> horas</td>
			<td colspan=2 style="background: #DDD3D3;"><b>Horas al mes:</b></td>
			<td><?php echo $mes=  ($datPlan[0]["HraSemana"]*4); ?> horas</td>
		</tr>
		<tr>
			<td colspan=3 style="background: #DDD3D3;"><b>Período del <?php echo $datPlan[0]["Tipo"]; ?>:</b></td>
			<td colspan=6><?php echo obtenerMes($datPlan[0]["MesIni"]).' - '.obtenerMes($datPlan[0]["MesFin"]).' '.substr($datPlan[0]["FFinal"], 0, 4); ?></td>
		</tr>

		<?php if($_SESSION["Permisos"] == 11){ ?>

			<tr>
				<td colspan=3 style="background: #DDD3D3;"><b>Costo Hora/Semana/Mes Impartido:</b></td>
				<td colspan=6><?php echo $datCosto[0]["Costo"]; ?></td>
			</tr>
<?php } else { ?>
		<tr>
			<td colspan=3 style="background: #DDD3D3;"><b>Horas de trabajo docente:</b></td>
			<td colspan=2><?php echo $datPlan[0]["HraDoc"]; ?> horas </td>
			<td colspan=2 style="background: #DDD3D3;"><b>Horas de trabajo independiente:</b> </td>
			<td colspan=2><?php echo $datPlan[0]["HraInd"]; ?> horas</td>
		</tr>
		<?php } ?>
		<tr style="display: none;">
			<td style="width: 80px; font-size: 0px; "></td>
			<td style="width: 80px; font-size: 0px; "></td>
			<td style="width: 80px; font-size: 0px; "></td>
			<td style="width: 80px; font-size: 0px; "></td>
			<td style="width: 80px; font-size: 0px; "></td>
			<td style="width: 80px; font-size: 0px; "></td>
			<td style="width: 80px; font-size: 0px; "></td>
			<td style="width: 80px; font-size: 0px; "></td>
			<td style="width: 80px; font-size: 0px; "></td>
		</tr>
	</table>
	<br><br><br>
	<table>
		<tr style="background: #DDD3D3;">
			<td style="text-align: center; background: #302d91; color: white; width: 1000px;"><b>OBJETIVO GENERAL DE LA ASIGNATURA</b></td>
		</tr>
		<tr style="background: #DDD3D3;">
			<td style="text-align: justify; width: 1000px;">
				<?php echo $datPlan[0]["Objetivo"]; ?>
			</td>
		</tr>
	</table>
	<br><br><br>

	<table>
		<tr style="background: #DDD3D3;">
			<td style="text-align: center; background: #302d91; color: white; width: 1000px;"><b>INTRODUCCIÓN DE LA ASIGNATURA </b></td>
		</tr>
		<tr style="background: #DDD3D3;">
			<td style="text-align: justify; width: 1000px;">
				<?php echo $datPlan[0]["Introduccion"]; echo "<br>";echo "<br>"; ?>

			</td>
		</tr>
	</table>

<?php $mesIni = 0; $mesSig = 0; 	$inm = 0; $inmX = 0; for ($i=0;$i< sizeof($datParcial);$i++) {
	if($inmX == 0){
		$mesIni = $datParcial[$i]["MesIni"];
	}
	$mesSig = $mesIni + $inm;

	if($mesSig > 12){
		$mesSig = 1;
	  $inm = 0;
	}

	$inm = $inm + 1;
	$inmX = $inmX +1;

$datSemana=$t->get_datSemana($datParcial[$i]["IdParcialDocente"]);
	 ?>
	<table>
		<tr>
			<td colspan=4 style="font-size: 14px; text-align: center; background: 302d91; "><b>CRONOGRAMA DE ACTIVIDADES DEL <?php echo obtenerAbre($datParcial[$i]["NoParcial"]); ?> PARCIAL</b></td>
		</tr>
		<tr>
			<td colspan=2 style="font-size: 14px; text-align: center; "><b>Fecha:</b></td>
			<td colspan=2 style="font-size: 12px; text-align: center; "><?php echo obtenerMes($mesSig); ?></td>
		</tr>
		<tr>
			<td colspan=4 style="font-size: 14px; text-align: center; "><b>Tema general: <?php echo $datParcial[$i]["Tema"]; ?></b></td>
		</tr>
		<tr>
			<td colspan=2 style="font-size: 14px; text-align: center; "><b>Objetivo específico "reto":</b></td>
			<td colspan=2 style="font-size: 12px; width: 460px; "><?php echo $datParcial[$i]["Objetivo"]; ?></td>
		</tr>

		<tr style="background: #302d91";>
			<td style="width: 113px; font-size: 12px; color: white; ">Tiempo estimado</td>
			<td style="width: 260px; font-size: 12px; color: white; ">Tema y subtemas</td>
			<td style="width: 260px; font-size: 12px; color: white; ">Actividades de aprendizaje</td>

		</tr>
		<?php for ($x=0;$x< sizeof($datSemana);$x++) {
			$datActividades=$t->get_datActividades($datSemana[$x]["IdSemanaDocente"]);
			$fuente=$t->get_fuentedocente($datParcial[$i]["IdParcialDocente"],$datSemana[$x]["IdSemanaDocente"]);
			 ?>
		<tr>
			<td style="width: 113px; font-size: 12px; ">SEMANA <?php echo $datSemana[$x]["NoSemana"]; ?></td>
			<td style="width: 250px; font-size: 12px; "><?php echo $datSemana[$x]["Temas"]; ?></td>
			<td style="width: 260px; font-size: 12px; ">
			<?php for ($m=0;$m< sizeof($datSemana);$m++) {
				if($datActividades[$m]["TipoActividad"]){
				echo "<b>Producto: </b>".$datActividades[$m]["TipoActividad"];echo "<br>";
				echo "<b>Actividad: </b>".$datActividades[$m]["NomActividad"];
				echo "<br>";
				echo "<br>";
			} } ?>
			</td>
		</tr>
		<tr>
			<td colspan="3" style="font-size: 12px; word-wrap: break-word; width: 865px; ">
			<?php for ($f=0;$f< sizeof($fuente);$f++) {
				if($fuente[$f]["Fuente"]){
				echo "<b>Fuente de consulta: </b><br>".$fuente[$f]["Fuente"];
			} } ?>

			</td>
		</tr>
		<?php } ?>
	</table>
	<?php } ?>
<br><br><br>
	<table>
		<tr style="background: #DDD3D3;">
			<td colspan=5 style="text-align: center; background: #302d91; color: white; width:1000px;"><b>CRITERIOS DE EVALUACIÓN</b></td>
		</tr>
		<tr style="background: #DDD3D3;">
			<td style="width: 10px;">#</td>
			<td style="width: 100px;">Parcial</td>
			<td style="width: 150px;">Actividad</td>
			<td style="width: 400px;">Descripcion de la actividad</td>
			<td style="width: 50px;">Ponderación</td>

		</tr>
		<?php for ($x=0;$x< sizeof($datActividadesLst);$x++) { ?>
			<tr>
				<td style="width: 10px;"><?php echo $mf = $mf + 1; ?></td>
				<td style="width: 100px;">Parcial <?php echo $datActividadesLst[$x]["NoParcial"]; ?></td>
				<td style="width: 150px;"><?php echo $datActividadesLst[$x]["TipoActividad"]; ?></td>
				<td style="width: 400px;"><?php echo $datActividadesLst[$x]["NomActividad"]; ?></td>
				<td style="width: 50px;"><?php echo $datActividadesLst[$x]["Porcentaje"]; ?></td>

			</tr>
		<?php } ?>
	</table>

	<!-- Fin del cuerpo de la hoja -->

</page>
<?php } else {
	echo "<script type='text/javascript'>window.close();</script>";
} ?>
