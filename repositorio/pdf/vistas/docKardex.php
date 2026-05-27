<?php
// session_start();
if($_SESSION['Permisos']){
	require_once'../classprint.php';
	include('numeros.php');
	$t=new Imprimir();
	$Usuario = substr($_GET["tokenId"], 10, 50);
	$_SESSION["Mat"] = $Usuario;
	$datUs=$t->get_datUsuario($Usuario);


	$datMen=$t->get_menDatos($datUs[0]["IdGrupo"]);

	$cal1=$t->get_calificacion($Usuario,$datUs[0]["IdOferta"],1);
	$cal2=$t->get_calificacion($Usuario,$datUs[0]["IdOferta"],2);
	$cal3=$t->get_calificacion($Usuario,$datUs[0]["IdOferta"],3);
	$cal4=$t->get_calificacion($Usuario,$datUs[0]["IdOferta"],4);
	$cal5=$t->get_calificacion($Usuario,$datUs[0]["IdOferta"],5);
	$cal6=$t->get_calificacion($Usuario,$datUs[0]["IdOferta"],6);
	$cal7=$t->get_calificacion($Usuario,$datUs[0]["IdOferta"],7);
	$cal8=$t->get_calificacion($Usuario,$datUs[0]["IdOferta"],8);
	$cal9=$t->get_calificacion($Usuario,$datUs[0]["IdOferta"],9);


    $campus=$t->get_campus_id($datUs[0]['IdCampus']);
    $dat_m=$t->get_dat_grp_mod($datUs[0]['IdGrupo']);


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
    padding: 3px;
}
tr:nth-child(even) {
    background-color: #dddddd;
}

-->
</style>

<!-- page define la hoja con los márgenes señalados -->
<page backtop="55mm" backbottom="15mm" backleft="10mm" backright="10mm">
	<page_header> <!-- Define el header de la hoja -->
	<img src="../../assets/images/campus/hoja_arriba.png" style="width: 100%;" >
	<br><br>
  <table style="font-size: 9px; margin-left: 39px; ">
		<tr>
			<td colspan="4" style="width: 500px; text-align: center; border-left: none; border-top: none; border-right: none;"><b>KARDEX DE CALIFICACIONES</b></td>
		</tr>
		<tr>
			<td style="width: 90px; border-right: none; border-bottom: none;">NOMBRE:</td>
			<td style="width: 290px; border-right: none; "><?php echo $datUs[0]["Nombre"].' '.$datUs[0]["APaterno"].' '.$datUs[0]["AMaterno"]; ?></td>
			<td style="width: 80px; text-align: right; border-right: none; border-bottom: none;">SEXO:</td>
			<td style="width: 180px; "><?php echo $datUs[0]["Sexo"]; ?></td>
		</tr>
		<tr>
			<td style="width: 90px; border-right: none; border-bottom: none; ">MATRÍCULA:</td>
			<td style="width: 285px; border-right: none;"><?php echo $Usuario; ?></td>
			<td style="width: 80px; text-align: right; border-right: none; border-bottom: none;">GENERACIÓN:</td>
			<td style="width: 180px; "><?php echo $datUs[0]["Periodo"]; ?></td>
		</tr>
		<tr>
			<td style="width: 90px; border-right: none; border-bottom: none;">CARRERA:</td>
			<td style="width: 285px; border-right: none;"><?php echo $datUs[0]["Educativa"]; ?></td>
			<td style="width: 80px; text-align: right; border-right: none; border-bottom: none;">MODALIDAD:</td>
			<td style="width: 180px; "><?php echo $dat_m[0]["_Modalidad"]; ?></td>
		</tr>
		<tr>
			<td style="width: 90px; border-right: none;">CLAVE ESCOLAR:</td>
			<td style="width: 285px; border-right: none; ">07PSU0075W</td>
			<td style="width: 80px; text-align: right; border-right: none;">GRUPO:</td>
			<td style="width: 180px; "><?php echo $datUs[0]["CveGrupo"]; ?></td>
		</tr>
	</table>

	</page_header>

	<page_footer> <!-- Define el footer de la hoja -->
	

	</page_footer>

	<?php if($cal1[0]){ ?>

	<table style="font-size: 9px;">
		<tr>
			<td rowspan="3" style="width: 90px; text-align: center;">CICLO<br>ESCOLAR</td>
			<td colspan="4" style="width: 300px; text-align: center;"><?php echo $cal1[0]["Ciclo"]; ?></td>
		</tr>
		<tr>
			<td rowspan="2" style="width: 288px; ">NOMBRE DE LA MATERIA</td>
			<td rowspan="2" style="width: 80px; text-align: center;">CALIFICACIÓN</td>
			<td colspan="2" style="width: 80px; text-align: center; ">REGULARIZACIÓN</td>
		</tr>
		<tr>
			<td style="width: 80px; text-align: center;">OBSERVACIÓN</td>
			<td style="width: 80px; text-align: center;">ESTATUS</td>
		</tr>

		<tr>
			<td rowspan="9" style="width: 80px; text-align: center; height: 124px;">PRIMER<br>CUATRIMESTRE</td>
		</tr>
		<?php for($i = 0; $i < 7; $i++){
			 if($cal1[$i]["E2"]) { $p1 = $cal1[$i]["E2"];  $t1= "EX"; } elseif($cal1[$i]["E1"]) { $p1 = $cal1[$i]["E1"]; $t1= "EX"; } else { $p1 = $cal1[$i]["Promedio"]; $t1= ""; }
			?>
		<tr>
			<td style="width: 288px; "><?php if($cal1[$i]["NombreMod"]) { echo $cal1[$i]["NombreMod"]; } else { echo ""; } ?></td>
			<td style="width: 80px; text-align: center;"><?php if($p1) { echo intval($p1); $cs1 = ($cs1+1); } else { echo ""; } ?></td>
			<td style="width: 80px; text-align: center; "><?php echo $t1; ?></td>
			<td style="width: 80px; "></td>
		</tr>
		<?php $cxl1 = ($p1 + $cxl1);  } ?>
	</table>
	<?php  } if($cal2[0]){
		?>
	<br>
	<table style="font-size: 9px;">
		<tr>
			<td rowspan="3" style="width: 90px; text-align: center;">CICLO<br>ESCOLAR</td>
			<td colspan="4" style="width: 300px; text-align: center;"><?php echo $cal2[0]["Ciclo"]; ?></td>
		</tr>
		<tr>
			<td rowspan="2" style="width: 288px; ">NOMBRE DE LA MATERIA</td>
			<td rowspan="2" style="width: 80px; text-align: center;">CALIFICACIÓN</td>
			<td colspan="2" style="width: 80px; text-align: center; ">REGULARIZACIÓN</td>
		</tr>
		<tr>
			<td style="width: 80px; text-align: center;">OBSERVACIÓN</td>
			<td style="width: 80px; text-align: center;">ESTATUS</td>
		</tr>

		<tr>
			<td rowspan="9" style="width: 80px; text-align: center; height: 124px;">SEGUNDO<br>CUATRIMESTRE</td>
		</tr>
		<?php for($i = 0; $i < 7; $i++){
			if($cal2[$i]["E2"]) { $p2 = $cal2[$i]["E2"]; $t2= "EX"; } elseif($cal2[$i]["E1"]) { $p2 = $cal2[$i]["E1"]; $t2= "EX"; } else { $p2 = $cal2[$i]["Promedio"]; $t2= ""; }
			?>
		<tr>
			<td style="width: 270px; "><?php if($cal2[$i]["NombreMod"]) { echo $cal2[$i]["NombreMod"]; } else { echo ""; } ?></td>
			<td style="width: 80px; text-align: center;"><?php if($p2) { echo intval($p2); $cs2 = ($cs2+1); } else { echo ""; } ?></td>
			<td style="width: 80px; text-align: center; "><?php echo $t2; ?></td>
			<td style="width: 80px; "></td>
		</tr>
		<?php $cxl2 = ($p2 + $cxl2);  } ?>
	</table>
	<?php } if($cal3[0]){ ?>
	<br>
	<table style="font-size: 9px;">
		<tr>
			<td rowspan="3" style="width: 90px; text-align: center;">CICLO<br>ESCOLAR</td>
			<td colspan="4" style="width: 300px; text-align: center;"><?php echo $cal3[0]["Ciclo"]; ?></td>
		</tr>
		<tr>
			<td rowspan="2" style="width: 288px; ">NOMBRE DE LA MATERIA</td>
			<td rowspan="2" style="width: 80px; text-align: center;">CALIFICACIÓN</td>
			<td colspan="2" style="width: 80px; text-align: center; ">REGULARIZACIÓN</td>
		</tr>
		<tr>
			<td style="width: 80px; text-align: center;">OBSERVACIÓN</td>
			<td style="width: 80px; text-align: center;">ESTATUS</td>
		</tr>

		<tr>
			<td rowspan="9" style="width: 80px; text-align: center; height: 124px;">TERCER<br>CUATRIMESTRE</td>
		</tr>
		<?php for($i = 0; $i < 7; $i++){
			if($cal3[$i]["E2"]) { $p3 = $cal3[$i]["E2"]; $t3= "EX"; } elseif($cal3[$i]["E1"]) { $p3 = $cal3[$i]["E1"]; $t3= "EX"; } else { $p3 = $cal3[$i]["Promedio"]; $t3= ""; }
			?>
		<tr>
			<td style="width: 270px; "><?php if($cal3[$i]["NombreMod"]) { echo $cal3[$i]["NombreMod"]; } else { echo ""; } ?></td>
			<td style="width: 80px; text-align: center;"><?php if($p3) { echo intval($p3); $cs3 = ($cs3+1); } else { echo ""; } ?></td>
			<td style="width: 80px; text-align: center; "><?php echo $t3; ?></td>
			<td style="width: 80px; "></td>
		</tr>
		<?php $cxl3 = ($p3 + $cxl3); } ?>
	</table>
	<?php } if($cal4[0]){ ?>
	<br>
	<table style="font-size: 9px;">
		<tr>
			<td rowspan="3" style="width: 90px; text-align: center;">CICLO<br>ESCOLAR</td>
			<td colspan="4" style="width: 300px; text-align: center;"><?php echo $cal4[0]["Ciclo"]; ?></td>
		</tr>
		<tr>
			<td rowspan="2" style="width: 288px; ">NOMBRE DE LA MATERIA</td>
			<td rowspan="2" style="width: 80px; text-align: center;">CALIFICACIÓN</td>
			<td colspan="2" style="width: 80px; text-align: center; ">REGULARIZACIÓN</td>
		</tr>
		<tr>
			<td style="width: 80px; text-align: center;">OBSERVACIÓN</td>
			<td style="width: 80px; text-align: center;">ESTATUS</td>
		</tr>

		<tr>
			<td rowspan="9" style="width: 80px; text-align: center; height: 124px;">CUARTO<br>CUATRIMESTRE</td>
		</tr>
		<?php for($i = 0; $i < 7; $i++){
			if($cal4[$i]["E2"]) { $p4 = $cal4[$i]["E2"]; $t4= "EX"; } elseif($cal4[$i]["E1"]) { $p4 = $cal4[$i]["E1"]; $t4= "EX"; } else { $p4 = $cal4[$i]["Promedio"]; $t4= ""; }
			?>
		<tr>
			<td style="width: 270px; "><?php if($cal4[$i]["NombreMod"]) { echo $cal4[$i]["NombreMod"]; } else { echo ""; } ?></td>
			<td style="width: 80px; text-align: center;"><?php if($p4) { echo intval($p4); $cs4 = ($cs4+1); } else { echo ""; } ?></td>
			<td style="width: 80px; text-align: center; "><?php echo $t4; ?></td>
			<td style="width: 80px; "></td>
		</tr>
		<?php $cxl4 = ($p4 + $cxl4);  } ?>
	</table>
	<?php } if($cal5[0]){ ?>
	<br>
	<table style="font-size: 9px;">
		<tr>
			<td rowspan="3" style="width: 90px; text-align: center;">CICLO<br>ESCOLAR</td>
			<td colspan="4" style="width: 300px; text-align: center;"><?php echo $cal5[0]["Ciclo"]; ?></td>
		</tr>
		<tr>
			<td rowspan="2" style="width: 288px; ">NOMBRE DE LA MATERIA</td>
			<td rowspan="2" style="width: 80px; text-align: center;">CALIFICACIÓN</td>
			<td colspan="2" style="width: 80px; text-align: center; ">REGULARIZACIÓN</td>
		</tr>
		<tr>
			<td style="width: 80px; text-align: center;">OBSERVACIÓN</td>
			<td style="width: 80px; text-align: center;">ESTATUS</td>
		</tr>

		<tr>
			<td rowspan="9" style="width: 80px; text-align: center; height: 124px;">QUINTO<br>CUATRIMESTRE</td>
		</tr>
		<?php for($i = 0; $i < 7; $i++){
			if($cal5[$i]["E2"]) { $p5 = $cal5[$i]["E2"]; $t5= "EX"; } elseif($cal5[$i]["E1"]) { $p5 = $cal5[$i]["E1"]; $t5= "EX"; } else { $p5 = $cal5[$i]["Promedio"]; $t5= ""; }
			?>
		<tr>
			<td style="width: 270px; "><?php if($cal5[$i]["NombreMod"]) { echo $cal5[$i]["NombreMod"]; } else { echo ""; } ?></td>
			<td style="width: 80px; text-align: center;"><?php if($p5) { echo intval($p5); $cs5 = ($cs5+1); } else { echo ""; } ?></td>
			<td style="width: 80px; text-align: center; "><?php echo $t5; ?></td>
			<td style="width: 80px; "></td>
		</tr>
		<?php $cxl5 = ($p5 + $cxl5);  } ?>
	</table>
	<?php } if($cal6[0]){ ?>
	<br>
	<table style="font-size: 9px;">
		<tr>
			<td rowspan="3" style="width: 90px; text-align: center;">CICLO<br>ESCOLAR</td>
			<td colspan="4" style="width: 300px; text-align: center;"><?php echo $cal6[0]["Ciclo"]; ?></td>
		</tr>
		<tr>
			<td rowspan="2" style="width: 288px; ">NOMBRE DE LA MATERIA</td>
			<td rowspan="2" style="width: 80px; text-align: center;">CALIFICACIÓN</td>
			<td colspan="2" style="width: 80px; text-align: center; ">REGULARIZACIÓN</td>
		</tr>
		<tr>
			<td style="width: 80px; text-align: center;">OBSERVACIÓN</td>
			<td style="width: 80px; text-align: center;">ESTATUS</td>
		</tr>

		<tr>
			<td rowspan="9" style="width: 80px; text-align: center; height: 124px;">SEXTO<br>CUATRIMESTRE</td>
		</tr>
		<?php for($i = 0; $i < 7; $i++){
			if($cal6[$i]["E2"]) { $p6 = $cal6[$i]["E2"]; $t6= "EX"; } elseif($cal6[$i]["E1"]) { $p6 = $cal6[$i]["E1"]; $t6= "EX"; } else { $p6 = $cal6[$i]["Promedio"]; $t6= ""; }
			?>
		<tr>
			<td style="width: 270px; "><?php if($cal6[$i]["NombreMod"]) { echo $cal6[$i]["NombreMod"]; } else { echo ""; } ?></td>
			<td style="width: 80px; text-align: center;"><?php if($p6) { echo intval($p6); $cs6 = ($cs6+1); } else { echo ""; } ?></td>
			<td style="width: 80px; text-align: center; "><?php echo $t6; ?></td>
			<td style="width: 80px; "></td>
		</tr>
		<?php $cxl6 = ($p6 + $cxl6);  } ?>
	</table>
	<?php } if($cal7[0]){ ?>
	<br>
	<table style="font-size: 9px;">
		<tr>
			<td rowspan="3" style="width: 90px; text-align: center;">CICLO<br>ESCOLAR</td>
			<td colspan="4" style="width: 300px; text-align: center;"><?php echo $cal7[0]["Ciclo"]; ?></td>
		</tr>
		<tr>
			<td rowspan="2" style="width: 288px; ">NOMBRE DE LA MATERIA</td>
			<td rowspan="2" style="width: 80px; text-align: center;">CALIFICACIÓN</td>
			<td colspan="2" style="width: 80px; text-align: center; ">REGULARIZACIÓN</td>
		</tr>
		<tr>
			<td style="width: 80px; text-align: center;">OBSERVACIÓN</td>
			<td style="width: 80px; text-align: center;">ESTATUS</td>
		</tr>

		<tr>
			<td rowspan="9" style="width: 80px; text-align: center; height: 124px;">SÉPTIMO<br>CUATRIMESTRE</td>
		</tr>
		<?php for($i = 0; $i < 7; $i++){
			if($cal7[$i]["E2"]) { $p7 = $cal7[$i]["E2"]; $t7= "EX"; } elseif($cal7[$i]["E1"]) { $p7 = $cal7[$i]["E1"]; $t7= "EX"; } else { $p7 = $cal7[$i]["Promedio"]; $t7= ""; }
			?>
		<tr>
			<td style="width: 270px; "><?php if($cal7[$i]["NombreMod"]) { echo $cal7[$i]["NombreMod"]; } else { echo ""; } ?></td>
			<td style="width: 80px; text-align: center;"><?php if($p7) { echo intval($p7); $cs7 = ($cs7+1); } else { echo ""; } ?></td>
			<td style="width: 80px; text-align: center; "><?php echo $t7; ?></td>
			<td style="width: 80px; "></td>
		</tr>
		<?php $cxl7 = ($p7 + $cxl7);  } ?>
	</table>
	<?php } if($cal8[0]){ ?>
	<br>
	<table style="font-size: 9px;">
		<tr>
			<td rowspan="3" style="width: 90px; text-align: center;">CICLO<br>ESCOLAR</td>
			<td colspan="4" style="width: 300px; text-align: center;"><?php echo $cal8[0]["Ciclo"]; ?></td>
		</tr>
		<tr>
			<td rowspan="2" style="width: 288px; ">NOMBRE DE LA MATERIA</td>
			<td rowspan="2" style="width: 80px; text-align: center;">CALIFICACIÓN</td>
			<td colspan="2" style="width: 80px; text-align: center; ">REGULARIZACIÓN</td>
		</tr>
		<tr>
			<td style="width: 80px; text-align: center;">OBSERVACIÓN</td>
			<td style="width: 80px; text-align: center;">ESTATUS</td>
		</tr>

		<tr>
			<td rowspan="9" style="width: 80px; text-align: center; height: 124px;">OCTAVO<br>CUATRIMESTRE</td>
		</tr>
		<?php for($i = 0; $i < 7; $i++){
			if($cal8[$i]["E2"]) { $p8 = $cal8[$i]["E2"]; $t8= "EX"; } elseif($cal8[$i]["E1"]) { $p8 = $cal8[$i]["E1"]; $t8= "EX"; } else { $p8 = $cal8[$i]["Promedio"]; $t8= ""; }
			?>
		<tr>
			<td style="width: 270px; "><?php if($cal8[$i]["NombreMod"]) { echo $cal8[$i]["NombreMod"]; } else { echo ""; } ?></td>
			<td style="width: 80px; text-align: center;"><?php if($p8) { echo intval($p8); $cs8 = ($cs8+1); } else { echo ""; } ?></td>
			<td style="width: 80px; text-align: center;"><?php echo $t8; ?></td>
			<td style="width: 80px; "></td>
		</tr>
		<?php $cxl8 = ($p8 + $cxl8);  } ?>
	</table>
<?php } if($cal9[0]){ ?>
	<br>
	<table style="font-size: 9px;">
		<tr>
			<td rowspan="3" style="width: 90px; text-align: center;">CICLO<br>ESCOLAR</td>
			<td colspan="4" style="width: 300px; text-align: center;"><?php echo $cal9[0]["Ciclo"]; ?></td>
		</tr>
		<tr>
			<td rowspan="2" style="width: 288px; ">NOMBRE DE LA MATERIA</td>
			<td rowspan="2" style="width: 80px; text-align: center;">CALIFICACIÓN</td>
			<td colspan="2" style="width: 80px; text-align: center; ">REGULARIZACIÓN</td>
		</tr>
		<tr>
			<td style="width: 80px; text-align: center;">OBSERVACIÓN</td>
			<td style="width: 80px; text-align: center;">ESTATUS</td>
		</tr>

		<tr>
			<td rowspan="9" style="width: 80px; text-align: center; height: 124px;">NOVENO<br>CUATRIMESTRE</td>
		</tr>
		<?php for($i = 0; $i < 7; $i++){
			if($cal9[$i]["E2"]) { $p9 = $cal9[$i]["E2"]; $t9= "EX"; } elseif($cal9[$i]["E1"]) { $p9 = $cal9[$i]["E1"]; $t9= "EX"; } else { $p9 = $cal9[$i]["Promedio"]; $t9= ""; }
			?>
		<tr>
			<td style="width: 270px; "><?php if($cal9[$i]["NombreMod"]) { echo $cal9[$i]["NombreMod"]; } else { echo ""; } ?></td>
			<td style="width: 80px; text-align: center;"><?php if($p9) { echo intval($p9); $cs9 = ($cs9+1); } else { echo ""; } ?></td>
			<td style="width: 80px; text-align: center; "><?php echo $t9; ?></td>
			<td style="width: 80px; "></td>
		</tr>
		<?php $cxl9 = ($p9 + $cxl9);  } ?>
	</table>
<?php }
$pro = ($cxl1+$cxl2+$cxl3+$cxl4+$cxl5+$cxl6+$cxl7+$cxl8+$cxl9);
$mat = ($cs1+$cs2+$cs3+$cs4+$cs5+$cs6+$cs7+$cs8+$cs9);
if($pro){ $prom = ($pro/$mat); }
?>
<table style="font-size: 9px;">

	<tr>
		<td style="width: 250px; border-left: none; border-bottom: none; "></td>
		<td style="width: 131px; text-align: center;"><b>PROMEDIO GENERAL</b></td>
		<td style="width: 80px; text-align: center; "><b><?php echo number_format($prom, 2, '.', ',');  //round($prom,1); ?></b></td>
	</tr>
</table>
	</page>
<?php } else {
	echo "<script type='text/javascript'>window.close();</script>";
} ?>
