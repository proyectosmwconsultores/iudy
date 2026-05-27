<?php

session_start();
if($_SESSION['Permisos']){
	require_once'../classprint.php';
	include("numeros.php");
	include("hace.php");
	$t=new Imprimir();

	$IdPlaneacion = substr($_GET["toks"],10,10);
	$datCosto=$t->get_datCosto($IdPlaneacion);

	$datPlan=$t->get_datPlanCorp($datCosto[0]["IdAsignacion"],$datCosto[0]["IdUsua"]);
	$datGrados=$t->get_datGrados($datCosto[0]["IdUsua"]);
	// $datPlanActiva=$t->get_planActiva($_GET["Id"]);

	$datParcial=$t->get_datParcial($datCosto[0]["IdAsignacion"]);
	$datBiblio=$t->get_datBiblio($datCosto[0]["IdAsignacion"]);




	$datUsuAprob=$t->get_datAprob($datCosto[0]["IdUsuaAprob"]);
	$IdC = $datCosto[0]["IdCampus"];
	//$txtCorporativo = "PLANEACION ACADEMICA";


	if($datPlan[0]["Modalidad"] == "M"){ $mod = "Mixta"; } elseif($datPlan[0]["Modalidad"] == "N"){ $mod = "No Escolarizado"; } elseif($datPlan[0]["Modalidad"] == "E"){ $mod = "Escolarizado"; }
	if($datPlan[0]["Turno"] == "M"){ $tun = "Matutino"; } elseif($datPlan[0]["Turno"] == "V"){ $tun = "Vespertino"; } elseif($datPlan[0]["Turno"] == "I"){ $tun = "Interweeek"; }
	$dia = $datPlan[0]["IdDia"];
	if($dia == 1){
		$dd = "Lunes - Jueves";
	} elseif($dia == 2){
		$dd = "Lunes - Viernes";
	}elseif($dia == 3){
		$dd = "Viernes";
	}elseif($dia == 4){
		$dd = "Interweek";
	}elseif($dia == 5){
		$dd = "Sábado";
	}elseif($dia == 6){
		$dd = "Domingo";
	}elseif($dia == 7){
		$dd = "Viernes - Domingo";
	}elseif($dia == 8){
		$dd = "Online";
	}

	//echo $datPlan[0]["Modalidad"]; echo $datPlan[0]["IdDia"]; echo $datPlan[0]["Turno"];


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
<page backtop="25mm" backbottom="20mm" backleft="10mm" backright="10mm">
	<page_header> <!-- Define el header de la hoja -->
		<div style=" margin: left: 37px; margin-top: 15px; height: 70px; width: 100px; position: relative;">
			<img src="../../assets/images/campus/logo_inicio.png" style="width: 140px;" >
		</div>
		<div style=" margin: left: 140px; margin-top: -93px; text-align: center; height: 70px; width: 823px; position: relative;"><br>
			<b style="font-size:18px;"><?php echo $txtCorporativo; ?></b><br>
			<b style="font-size:21px;">PLANEACIÓN ACADÉMICA</b>
		</div>
		<div style=" margin: left: 965px; text-align: center; margin-top: -83px; height: 70px; width: 100px; position: relative;">
			<br><br><b style="font-size: 17px;"><?php echo $datPlan[0]["Planeacion"]; ?></b>
		</div>
	</page_header>

	<page_footer> <!-- Define el footer de la hoja -->

	</page_footer>
	<?php  for ($i=0;$i< 1;$i++) { ?>  <!-- Define el cuerpo de la hoja -->


		<table>
			<tr style="background: #979494;">
				<td colspan=2 style="text-align: center; background: #979494; color: white; width: 994px;"><b><i>ASESOR ACADÉMICO</i></b></td>
			</tr>
			<tr>
				<td style="width: 340px;"><b>Nombre del asesor:</b></td>
				<td style=" width: 560px;"><?php echo $datCosto[0]["Nombre"].' '.$datCosto[0]["APaterno"].' '.$datCosto[0]["AMaterno"]; ?></td>
			</tr>
			<tr>
				<td style=" width: 340px;"><b>Licenciatura:</b></td>
				<td style=" width: 560px;"><?php echo $datGrados[0]["Nombre"];  ?></td>
			</tr>
			<tr>
				<td style="width: 340px;"><b>Maestría:</b></td>
				<td style=" width: 560px;"><?php echo $datGrados[1]["Nombre"]; ?></td>
			</tr>
			<tr>
				<td style="width: 340px;"><b>Doctorado:</b></td>
				<td style=" width: 560px;"><?php echo $datGrados[2]["Nombre"]; ?></td>
			</tr>

		</table>

		<table>
			<tr style="background: #DDD3D3;">
				<td colspan=2 style="text-align: center; background: #979494; color: white; width: 994px;"><b><i>ASIGNATURA</i></b></td>
			</tr>
			<tr>
				<td style="width: 340px;"><b>Licenciatura / Bachillerato / Posgrado:</b></td>
				<td style=" width: 560px;"> <?php if($datPlan[0]["Nombre"]){ echo $datPlan[0]["Nombre"]; } else { echo $datPlan[0]["Oferta"];  } ?></td>
			</tr>
			<tr>
				<td style=" width: 340px;"><b>Nombre de la Asignatura:</b></td>
				<td style=" width: 560px;"><?php echo $datPlan[0]["NombreMod"]; ?></td>
			</tr>
			<tr>
				<td style="width: 340px;"><b>Modalidad / Día / Turno:</b></td>
				<td style=" width: 560px;"><?php echo $mod; ?> / <?php echo $dd; ?> / <?php echo $tun; ?></td>
			</tr><?php if($_SESSION["Permisos"] == 11){ ?>
			<tr>
				<td style="width: 340px;"><b>Cuatrimestre / Semestre:</b></td>
				<td style=" width: 560px;"><?php echo $datPlan[0]["Grado"]; ?>° <?php echo $datPlan[0]["Tipo"]; ?></td>
			</tr>
			<tr>
				<td style="width: 340px;"><b>Hora / Semana/ Mes:</b></td>
				<td style=" width: 560px;"><?php echo $datPlan[0]["HraDia"]; ?> / <?php echo $datPlan[0]["HraSemana"]; ?> / <?php echo $dax = ($datPlan[0]["HraSemana"] * 4); ?></td>
			</tr>
			<tr>
				<td style="width: 340px;"><b>Horas Cuatrimestre / Semestre:</b></td>
				<td style=" width: 560px;"><?php if($datPlan[0]["Tipo"] == "Cuatrimestre") { echo $daTx = ($dax * 4); } else { echo $daTx = ($dax * 6); }  ?> hrs.</td>
			</tr>
			<tr>
				<td style="width: 340px;"><b>Período del Cuatrimestre / Semestre  / Bimestre:</b></td>
				<td style=" width: 560px;">Periodo: <?php echo $datPlan[0]["Ciclo"]; ?> / Bimestre: <?php echo obtenerMes($datPlan[0]["MesIni"]); ?> - <?php $ms = $datPlan[0]["MesIni"] + 1; if($ms > 12) { $ms = 1; }  echo obtenerMes($ms); ?></td>
			</tr>
			<tr>
				<td style="width: 340px;"><b>Costo Hora/Semana/Mes Impartido:</b></td>
				<td style=" width: 560px;"><?php echo $datCosto[0]["Costo"]; ?></td>
			</tr><?php } else { ?>
				<tr>
					<td style="width: 340px;"><b><?php echo $datPlan[0]["Tipo"]; ?>:</b></td>
					<td style=" width: 560px;"><?php echo $datPlan[0]["Grado"]; ?>° <?php echo $datPlan[0]["Tipo"]; ?></td>
				</tr>
				<tr>
					<td style="width: 340px;"><b>Hora / Semana/ Mes:</b></td>
					<td style=" width: 560px;"><?php echo $datPlan[0]["HraDia"]; ?> / <?php echo $datPlan[0]["HraSemana"]; ?> / <?php echo $dax = ($datPlan[0]["HraSemana"] * 4); ?></td>
				</tr>
				<tr>
					<td style="width: 340px;"><b>Horas <?php echo $datPlan[0]["Tipo"]; ?>:</b></td>
					<td style=" width: 560px;"><?php if($datPlan[0]["Tipo"] == "Cuatrimestre") { echo $daTx = ($dax * 4); } else { echo $daTx = ($dax * 6); }  ?> hrs.</td>
				</tr>
				<tr>
					<td style="width: 340px;"><b>Período del <?php echo $datPlan[0]["Tipo"]; ?>:</b></td>
					<td style=" width: 560px;">Periodo: <?php echo $datPlan[0]["Ciclo"]; ?> / Bimestre: <?php echo obtenerMes($datPlan[0]["MesIni"]); ?> - <?php $ms = $datPlan[0]["MesIni"] + 1; if($ms > 12) { $ms = 1; }  echo obtenerMes($ms); ?></td>
				</tr>
				<tr>
					<td style="width: 340px;"><b>Horas docente:</b></td>
					<td style=" width: 560px;"><?php echo $datPlan[0]["HraDoc"]; ?> hrs.  / <b>Horas independiente: </b> <?php echo $datPlan[0]["HraInd"]; ?> hrs.</td>
				</tr>

			<?php } ?>
			<tr>
				<td style="width: 340px;"><b>Fecha / Hora de autorización:</b></td>
				<td style=" width: 560px;"><?php echo $datCosto[0]["FecAprobado"]; ?></td>
			</tr>

		</table>
		<br>

	<table>
		<tr style="background: #979494;">
			<td style="text-align: center; background: #979494; color: white; width: 1000px;"><b>OBJETIVO GENERAL DE LA ASIGNATURA</b></td>
		</tr>
		<tr style="background: #DDD3D3;">
			<td style="text-align: justify; width: 1000px;">
				<?php echo $datPlan[0]["Objetivo"]; ?>
			</td>
		</tr>
	</table><br>


<?php $mesIni = 0; $mesSig = 0; 	$inm = 0; $inmX = 0; for ($i=0;$i< sizeof($datParcial);$i++) {
	  $sumP = 0;
$datSemana=$t->get_datSemana($datParcial[$i]["IdParcialDocente"]);
$noSemana=$t->get_datNoSemana($datParcial[$i]["IdParcialDocente"]);
	 ?>
	<table>
		<tr style="background:#302d91; color: white; ">
			<td colspan=4 style="font-size: 14px; text-align: center; background: #979494; "><b>CRONOGRAMA DE ACTIVIDADES DEL <?php echo obtenerAbreMay($datParcial[$i]["NoParcial"]); ?> PARCIAL</b></td>
		</tr>
		<tr>
			<td colspan=2 style="font-size: 14px; text-align: center; "><b>Fecha:</b></td>
			<td colspan=2 style="font-size: 12px; text-align: center; "><?php echo obtenerFechaEnLetraD($datParcial[$i]["FecIni"]); ?> al <?php echo obtenerFechaEnLetraD($datParcial[$i]["FecFin"]); ?></td>
		</tr>

		<tr>
			<td colspan=4 style="font-size: 14px; text-align: center; "><b>Tema general: <?php echo $datParcial[$i]["Tema"]; ?></b></td>
		</tr>
		<tr>
			<td colspan=2 style="font-size: 14px; text-align: center; "><b>Objetivo específico "reto":</b></td>
			<td colspan=2 style="font-size: 12px; width: 460px; "><?php echo $datParcial[$i]["Objetivo"]; ?></td>
		</tr>

		<tr style="background: #979494";>
			<td style="width: 30px; font-size: 12px; color: white; ">Semana</td>
			<td style="width: 210px; font-size: 12px; color: white; ">Temas</td>
			<td style="width: 230px; font-size: 12px; color: white; ">Actividades de aprendizaje</td>
			<td style="width: 20px; font-size: 12px; color: white; ">Criterios de evaluación</td>
		</tr>
		<?php for ($x=0;$x< sizeof($datSemana);$x++) {

			$datActividades=$t->get_datActividades($datSemana[$x]["IdSemanaDocente"],$datParcial[$i]["IdParcialDocente"]);
			$fuente=$t->get_fuentedocente($datParcial[$i]["IdParcialDocente"],$datSemana[$x]["IdSemanaDocente"]);
			 ?>
		<tr>
			<td style="width: 30px; font-size: 12px; "><?php echo $datSemana[$x]["NoSemana"]; ?></td>
			<td style="width: 400px; font-size: 12px; "><?php echo $datSemana[$x]["Temas"]; ?></td>
			<td style="width: 20px; font-size: 12px; ">
			<?php  for ($m=0;$m< sizeof($datActividades);$m++) {
				if($datActividades[$m]["TipoActividad"]){

				echo "<b>&#8226; </b>".$datActividades[$m]["NomActividad"];
				echo "<br>";
				echo "<br>";
			} } ?>
			</td>
			<td style="width: 60px; font-size: 12px; ">
			<?php for ($v=0;$v< sizeof($datSemana);$v++) {

				if($datActividades[$v]["TipoActividad"]){
					$sumP = $sumP + $datActividades[$v]["Porcentaje"];

				echo $datActividades[$v]["Porcentaje"].' %';
				echo "<br>";
				echo "<br>";
			} }  ?>

			</td>
			</tr>

		<?php if($noSemana[0]["noSemana"] == $datSemana[$x]["NoSemana"]){  ?>
		<tr>
			<td colspan=3 style="font-size: 14px; text-align: center; "><b>TOTAL:</b></td>
			<td style="font-size: 12px; width: 20px; "><?php echo $sumP; ?> %</td>
		</tr>
		<?php }  ?>
		<?php } ?>

	</table>
	<br><br>



	<?php } ?>


<?php } ?>
	<!-- Fin del cuerpo de la hoja -->

</page>
<?php  } else {
	echo "<script type='text/javascript'>window.close();</script>";
} ?>
