<?php
session_start();
if($_SESSION['Permisos']){
	require_once'../classprint.php';
	include('numeros.php');
	$t=new Imprimir();
	$Usuario = substr($_GET["tokenId"], 10, 50);
	$_SESSION["Mat"] = $Usuario;
	$datUs=$t->get_datUsuario($Usuario);
	$chkRep=$t->get_chkRep($Usuario,$datUs[0]["IdOferta"]);
	$chkDup=$t->get_chkDup($Usuario,$datUs[0]["IdOferta"],$datUs[0]["IdOferta"]);
    $uni=$t->get_plataforma();

	$mod = substr($datUs[0]["CveGrupo"], 5,1);
  $tur = substr($datUs[0]["CveGrupo"], 6,1);
	$datMen=$t->get_menDatos($datUs[0]["IdGrupo"]);
	$anio = date("Y");
 	$an = substr($anio,2,2);
	$cal1=$t->get_calificacion($Usuario,$datUs[0]["IdOferta"],1);
	$cal2=$t->get_calificacion($Usuario,$datUs[0]["IdOferta"],2);
	$cal3=$t->get_calificacion($Usuario,$datUs[0]["IdOferta"],3);
	$cal4=$t->get_calificacion($Usuario,$datUs[0]["IdOferta"],4);
	$cal5=$t->get_calificacion($Usuario,$datUs[0]["IdOferta"],5);
	$cal6=$t->get_calificacion($Usuario,$datUs[0]["IdOferta"],6);
	$cal7=$t->get_calificacion($Usuario,$datUs[0]["IdOferta"],7);
	$cal8=$t->get_calificacion($Usuario,$datUs[0]["IdOferta"],8);
	$cal9=$t->get_calificacion($Usuario,$datUs[0]["IdOferta"],9);
$numg = 13;
$numF = 8;
$num1g = 8;
$num2g = 8;
$num3g = 8;
$num4g = 8;

if($datUs[0]["IdOferta"] == 14){
	$num4g = 6;
	$numg = 10.5;
}
$oferta = $datUs[0]["Educativa"];


if($datUs[0]["Linea1"]){ $num1g = $datUs[0]["Linea1"];  }
if($datUs[0]["Linea2"]){ $num2g = $datUs[0]["Linea2"];  }
if($datUs[0]["Linea3"]){ $num3g = $datUs[0]["Linea3"];  }
if($datUs[0]["Linea4"]){ $num4g = $datUs[0]["Linea4"];  }


	if($tur == "M"){ $turno = "MATUTINO"; } else { $turno = "MIXTO"; }
	if($mod == "E"){ $modalidad = "ESCOLARIZADO"; } else { $modalidad = "MIXTO"; }


?>
<!-- IMPORTANTE: El contenido de la etiqueta style debe estar entre comentarios de HTML -->
<style>
<!--

table {
    font-family: arial;
    border-collapse: collapse;
    width: 100%;
		font-size: 10px;
}

td, th {
    border: 1px solid #3e3e3e;
    padding: 2.3px;
}
tr:nth-child(even) {
    background-color: #dddddd;
}

-->
</style>

<!-- page define la hoja con los márgenes señalados -->
<page backtop="2mm" backbottom="12mm" backleft="1mm" backright="10mm">
	<page_header> <!-- Define el header de la hoja -->
	<img src="../../assets/images/logoImg.png" style="width: 85px; margin-top: 5px; margin-left:50px;">
	</page_header>

	<page_footer> <!-- Define el footer de la hoja -->
        <p style="font-size: 10px; ">Este documento no es válido si presenta raspaduras o enmendaduras.</p><br><br>
	</page_footer>

	<table>
		<tr>
			<td style="width: 765px; text-align: center; font-size: 16px; border: none;"><b>GOBIERNO CONSTITUCIONAL DEL ESTADO DE CHIAPAS</b></td>
		</tr>
		<tr>
			<td style="width: 765px; text-align: right; border: none; font-size: 9px;"><b>SECL </b><b><?php echo $an; ?>&nbsp;&nbsp;&nbsp;</b></td>
		</tr>

		<tr>
			<td style="width: 765px; text-align: center; font-size: 14px; border: none;">
				<b>SECRETARÍA DE EDUCACIÓN<br>
				SUBSECRETARÍA DE EDUCACIÓN ESTATAL<br>
				DIRECCIÓN DE EDUCACIÓN SUPERIOR<br>
				DEPARTAMENTO DE SERVICIOS ESCOLARES
				</b>
			</td>
		</tr>
		<tr>
			<td style="width: 400px; text-align: right; font-size: 11px; border: none;">Folio No: <b style="color: red; font-size: 14px;"><?php echo $datUs[0]["Folio"]; ?>&nbsp;&nbsp;&nbsp;</b></td>
		</tr>
	</table>
	<table>
		<tr>
		<td style="width: 180; text-align: left; font-size: 12px; border: none;">
		<img src="../../assets/images/fondoImg.png" style="width: 100px; margin-left: 30px; margin-top: -5px;">
		</td>
			<td style="width: 565px; text-align: justify; font-size: 12px; border: none; ">
			LA DIRECCIÓN DE LA <b><?php echo $uni[0]['Descripcion']; ?></b>, REGIMEN PARTICULAR, MODALIDAD <?php echo $datMen[0]["Modalidad"];//$modalidad; ?>, TURNO <?php echo $datMen[0]["Turno"]; //$turno; ?>, CLAVE <?php echo $datMen[0]["Clave"]; ?>, CERTIFICA QUE:
			<br><br>
			EL (LA) C. <b style="margin-left: 100px;"><?php echo $datUs[0]["Nombre"].' '.$datUs[0]["APaterno"].' '.$datUs[0]["AMaterno"]; ?></b>
			<br><br>
			CON NÚMERO DE CONTROL: <b style="margin-left: 100px;"><?php echo $Usuario; ?></b>
			<br><br>
			ACREDITÓ LAS MATERIAS QUE INTEGRAN EL PLAN DE ESTUDIOS DE LA: <b><?php echo $oferta; ?></b> SEGÚN RVOE ACUERDO NÚMERO:<b><?php echo $datMen[0]["Rvoe"]; ?></b> VIGENCIA A PARTIR DEL <b><?php echo $datMen[0]["Vigencia"]; ?></b> OTORGADO POR LA SECRETARÍA DE EDUCACIÓN.
			<br><br>
			DURANTE EL PERIODO: <b><?php echo $datUs[0]["Periodo"]; ?></b>
			<br><br>
			CON LOS RESULTADOS QUE A CONTINUACIÓN SE ANOTAN:<br><br>
			</td>
		</tr>
	</table>


	<table>
	<tr style="text-align: center; font-weight: border: 1px solid blue; font-size: 8px;">
		<td style="width: 192px;"><b>PRIMER CUATRIMESTRE</b></td>
		<td colspan="2" style="width:35px;"><b>CALIFICACIÓN</b></td>
		<td rowspan="2" style="width:65px;"><b>OBSERVACIÓN</b></td>
		<td style="width: 192px;"><b>SEGUNDO CUATRIMESTRE</b></td>
		<td colspan="2" style="width:35px;"><b>CALIFICACIÓN</b></td>
		<td rowspan="2" style="width:65px;"><b>OBSERVACIÓN</b></td>
	</tr>
	<tr style="font-weight: bold; font-size: 8px;">
	<td style="width:184px; text-align: center;"><b><?php echo $cal1[0]["Ciclo"]; ?></b></td>
		<td style="width:35px; text-align: center;"><b>CIFRA</b></td>
		<td style="width:40px; text-align: center;"><b>LETRA</b></td>
		<td style="width:184px; text-align: center;"><b><?php echo $cal2[0]["Ciclo"]; ?></b></td>
		<td style="width:35px; text-align: center;"><b>CIFRA</b></td>
		<td style="width:40px; text-align: center;"><b>LETRA</b></td>
	</tr>
		<?php $sumCal = 0; $sumM = 0;  for($i = 0; $i < $num1g; $i++){
			if($cal1[$i]["E2"]) { $p1 = $cal1[$i]["E2"]; $t1= "EX"; } elseif($cal1[$i]["E1"]) { $p1 = $cal1[$i]["E1"]; $t1= "EX"; } else { $p1 = $cal1[$i]["Promedio"]; $t1= ""; }
			if($cal2[$i]["E2"]) { $p2 = $cal2[$i]["E2"]; $t2= "EX"; } elseif($cal2[$i]["E1"]) { $p2 = $cal2[$i]["E1"]; $t2= "EX"; } else { $p2 = $cal2[$i]["Promedio"]; $t2= ""; }
			$p1 = number_format($p1);
			$p2 = number_format($p2);
			?>
		<tr style="font-size: 9px;">
			<td style="width: 175px; height: 4px; border-bottom: none;"><?php if($cal1[$i]["NombreMod"]) { echo $cal1[$i]["NombreMod"]; } else { echo ""; } ?></td>
			<td style="border-bottom: none; text-align: center;"><?php if($p1) { echo intval($p1); $sumCal1 = $sumCal1 + $p1; $sumM1 = $sumM1 + 1; }  else { echo ""; } ?></td>
			<td style="border-bottom: none; text-align: center;"><?php if($p1) { echo obtenerNumeroEnLetra($p1); } else { echo ""; } ?></td>
			<td style="border-bottom: none; text-align: center;"><?php echo $t1; ?></td>
			<td style="width: 175px; border-bottom: none;"><?php if($cal2[$i]["NombreMod"]){ echo $cal2[$i]["NombreMod"]; } else { echo ""; } ?></td>
			<td style="border-bottom: none; text-align: center;"><?php if($p2){ echo intval($p2);  $sumCal2 = $sumCal2 + $p2; $sumM2 = $sumM2 + 1; } else { echo ""; } ?></td>
			<td style="border-bottom: none; text-align: center;"><?php if($p2){ echo obtenerNumeroEnLetra($p2); } else { echo ""; } ?></td>
			<td style="border-bottom: none; text-align: center;"><?php echo $t2; ?></td>
		</tr>
		<?php } ?>
		<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
		<tr style="text-align: center; font-weight: border: 1px solid blue; font-size: 8px;">
			<td style="width: 182px; height: 4px;"><b>TERCER CUATRIMESTRE</b></td>
			<td colspan="2" style="width:35px;"><b>CALIFICACIÓN</b></td>
			<td rowspan="2" style="width:65px;"><b>OBSERVACIÓN</b></td>
			<td style="width: 182px;"><b>CUARTO CUATRIMESTRE</b></td>
			<td colspan="2" style="width:35px;"><b>CALIFICACIÓN</b></td>
			<td rowspan="2" style="width:65px;"><b>OBSERVACIÓN</b></td>
		</tr>
		<tr style="font-weight: bold; font-size: 8px;">
			<td style="width:182px; text-align: center;"><b><?php echo $cal3[0]["Ciclo"]; ?></b></td>
			<td style="width:35px; text-align: center;"><b>CIFRA</b></td>
			<td style="width:40px; text-align: center;"><b>LETRA</b></td>
			<td style="width:182px; text-align: center;"><b><?php echo $cal4[0]["Ciclo"]; ?></b></td>
			<td style="width:35px; text-align: center;"><b>CIFRA</b></td>
			<td style="width:40px; text-align: center;"><b>LETRA</b></td>
		</tr>
		<?php for($v = 0; $v < $num2g; $v++){
			if($cal3[$v]["E2"]) { $p3 = $cal3[$v]["E2"]; $t3= "EX"; } elseif($cal3[$v]["E1"]) { $p3 = $cal3[$v]["E1"]; $t3= "EX"; } else { $p3 = $cal3[$v]["Promedio"]; $t3= ""; }
			if($cal4[$v]["E2"]) { $p4 = $cal4[$v]["E2"]; $t4= "EX"; } elseif($cal4[$v]["E1"]) { $p4 = $cal4[$v]["E1"]; $t4= "EX"; } else { $p4 = $cal4[$v]["Promedio"]; $t4= ""; }
			$p3 = number_format($p3);
			$p4 = number_format($p4);
			 ?>
		<tr style="font-size: 9px;">
			<td style="width: 175px; height: 4px; border-bottom: none;"><?php if($cal3[$v]["NombreMod"]) { echo $cal3[$v]["NombreMod"]; } else { echo ""; } ?></td>
			<td style="border-bottom: none; text-align: center;"><?php if($p3) { echo intval($p3); $sumCal3 = $sumCal3 + $p3; $sumM3 = $sumM3 + 1; }  else { echo ""; } ?></td>
			<td style="border-bottom: none; text-align: center;"><?php if($p3) { echo obtenerNumeroEnLetra($p3); } else { echo ""; } ?></td>
			<td style="border-bottom: none; text-align: center;"><?php echo $t3; ?></td>
			<td style="width: 175px; border-bottom: none;"><?php if($cal4[$v]["NombreMod"]){ echo $cal4[$v]["NombreMod"]; } else { echo ""; } ?></td>
			<td style="border-bottom: none; text-align: center;"><?php if($p4){ echo intval($p4); $sumCal4 = $sumCal4 + $p4; $sumM4 = $sumM4 + 1; } else { echo ""; } ?></td>
			<td style="border-bottom: none; text-align: center;"><?php if($p4){ echo obtenerNumeroEnLetra($p4); } else { echo ""; } ?></td>
			<td style="border-bottom: none; text-align: center;"><?php echo $t4; ?></td>
		</tr>
		<?php } ?>
		<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
			<tr style="text-align: center; font-weight: bold; font-size: 8px;">
				<td style="width: 182px;">QUINTO CUATRIMESTRE</td>
				<td colspan="2" style="width:35px;">CALIFICACIÓN</td>
				<td rowspan="2" style="width:65px;">OBSERVACIÓN</td>
				<td style="width: 182px;">SEXTO CUATRIMESTRE</td>
				<td colspan="2" style="width:35px;">CALIFICACIÓN</td>
				<td rowspan="2" style="width:65px;">OBSERVACIÓN</td>
			</tr>
			<tr style="font-weight: bold; font-size: 8px;">
			<td style="width:182px; text-align: center;"><b><?php echo $cal5[0]["Ciclo"]; ?></b></td>
				<td style="width:35px; text-align: center;">CIFRA</td>
				<td style="width:40px; text-align: center;">LETRA</td>
				<td style="width:182px; text-align: center;"><b><?php echo $cal6[0]["Ciclo"]; ?></b></td>
				<td style="width:35px; text-align: center;">CIFRA</td>
				<td style="width:40px; text-align: center;">LETRA</td>
			</tr>
			<?php for($x = 0; $x < $num3g; $x++){
				if($cal5[$x]["E2"]) { $p5 = $cal5[$x]["E2"]; $t5= "EX"; } elseif($cal5[$x]["E1"]) { $p5 = $cal5[$x]["E1"]; $t5= "EX"; } else { $p5 = $cal5[$x]["Promedio"]; $t5= ""; }
				if($cal6[$x]["E2"]) { $p6 = $cal6[$x]["E2"]; $t6= "EX"; } elseif($cal6[$x]["E1"]) { $p6 = $cal6[$x]["E1"]; $t6= "EX"; } else { $p6 = $cal6[$x]["Promedio"]; $t6= ""; }
				$p5 = number_format($p5);
				$p6 = number_format($p6);
				?>
			<tr style="font-size: 9px;">
				<td style="width: 175px; height: 4px; border-bottom: none;"><?php if($cal5[$x]["NombreMod"]) { echo $cal5[$x]["NombreMod"]; } else { echo ""; } ?></td>
				<td style="border-bottom: none; text-align: center;"><?php if($p5) { echo intval($p5); $sumCal5 = $sumCal5 + $p5; $sumM5 = $sumM5 + 1; }  else { echo ""; } ?></td>
				<td style="border-bottom: none; text-align: center;"><?php if($p5) { echo obtenerNumeroEnLetra($cal5[$x]["Promedio"]); } else { echo ""; } ?></td>
				<td style="border-bottom: none; text-align: center;"><?php echo $t5; ?></td>
				<td style="width: 175px; border-bottom: none;"><?php if($cal6[$x]["NombreMod"]){ echo $cal6[$x]["NombreMod"]; } else { echo ""; } ?></td>
				<td style="border-bottom: none; text-align: center;"><?php if($p6){ echo intval($p6);  $sumCal6 = $sumCal6 + $p6; $sumM6 = $sumM6 + 1; } else { echo ""; } ?></td>
				<td style="border-bottom: none; text-align: center;"><?php if($p6){ echo obtenerNumeroEnLetra($p6); } else { echo ""; } ?></td>
				<td style="border-bottom: none; text-align: center;"><?php echo $t6; ?></td>
			</tr>
			<?php } ?>
			<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
			<tr style="text-align: center; font-weight: border: 1px solid blue; font-size: 8px;">
				<td style="width: 182px;"><b>SÉPTIMO CUATRIMESTRE</b></td>
				<td colspan="2" style="width:35px;"><b>CALIFICACIÓN</b></td>
				<td rowspan="2" style="width:65px;"><b>OBSERVACIÓN</b></td>
				<td style="width: 182px;"><b>OCTAVO CUATRIMESTRE</b></td>
				<td colspan="2" style="width:35px;"><b>CALIFICACIÓN</b></td>
				<td rowspan="2" style="width:65px;"><b>OBSERVACIÓN</b></td>
			</tr>
			<tr style="font-weight: bold; font-size: 8px;">
			<td style="width:182px; text-align: center;"><b><?php echo $cal7[0]["Ciclo"]; ?></b></td>
				<td style="width:35px; text-align: center;"><b>CIFRA</b></td>
				<td style="width:40px; text-align: center;"><b>LETRA</b></td>
				<td style="width:182px; text-align: center;"><b><?php echo $cal8[0]["Ciclo"]; ?></b></td>
				<td style="width:35px; text-align: center;"><b>CIFRA</b></td>
				<td style="width:40px; text-align: center;"><b>LETRA</b></td>
			</tr>
			<?php for($y = 0; $y < $num4g; $y++){
				if($cal7[$y]["E2"]) { $p7 = $cal7[$y]["E2"]; $t7= "EX"; } elseif($cal7[$y]["E1"]) { $p7 = $cal7[$y]["E1"]; $t7= "EX"; } else { $p7 = $cal7[$y]["Promedio"]; $t7= ""; }
				if($cal8[$y]["E2"]) { $p8 = $cal8[$y]["E2"]; $t8= "EX"; } elseif($cal8[$y]["E1"]) { $p8 = $cal8[$y]["E1"]; $t8= "EX"; } else { $p8 = $cal8[$y]["Promedio"]; $t8= ""; }
				$p7 = number_format($p7);
				$p8 = number_format($p8);
				?>
			<tr style="font-size: 9px;">
				<td style="width: 182px; height: 4px; border-bottom: none;"><?php if($cal7[$y]["NombreMod"]) { echo $cal7[$y]["NombreMod"]; } else { echo ""; } ?></td>
				<td style="border-bottom: none; text-align: center;"><?php if($p7) { echo intval($p7); $sumCal7 = $sumCal7 + $p7; $sumM7 = $sumM7 + 1; }  else { echo ""; } ?></td>
				<td style="border-bottom: none; text-align: center;"><?php if($p7) { echo obtenerNumeroEnLetra($p7); } else { echo ""; } ?></td>
				<td style="border-bottom: none; text-align: center;"><?php echo $t7; ?></td>
				<td style="width: 182px; border-bottom: none;"><?php if($cal8[$y]["NombreMod"]){ echo $cal8[$y]["NombreMod"]; } else { echo ""; } ?></td>
				<td style=" border-bottom: none; text-align: center;"><?php if($p8){ echo intval($p8); $sumCal8 = $sumCal8 + $p8; $sumM8 = $sumM8 + 1; } else { echo ""; } ?></td>
				<td style="border-bottom: none; text-align: center;"><?php if($p8){ echo obtenerNumeroEnLetra($p8); } else { echo ""; } ?></td>
				<td style="border-bottom: none; text-align: center;"><?php echo $t8; ?></td>
			</tr>
			<?php } ?>
			<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
			<tr style="text-align: center; font-weight: border: 1px solid blue; font-size: 8px;">
				<td style="width: 182px;"><b>NOVENO CUATRIMESTRE</b></td>
				<td colspan="2" style="width:35px;"><b>CALIFICACIÓN</b></td>
				<td rowspan="2" style="width:65px;"><b>OBSERVACIÓN</b></td>
				<td rowspan="2" style="width: 182px;"></td>
				<td colspan="2" style="width:35px;"><b></b></td>
				<td rowspan="2" style="width:65px;"><b></b></td>
			</tr>
			<tr style="font-weight: bold; font-size: 8px;">
				<td style="width:182px; text-align: center;"><b><?php echo $cal9[0]["Ciclo"]; ?></b></td>
				<td style="width:35px; text-align: center;"><b>CIFRA</b></td>
				<td style="width:40px; text-align: center;"><b>LETRA</b></td>
				<td style="width:35px; text-align: center;"><b></b></td>
				<td style="width:40px; text-align: center;"><b></b></td>
			</tr>
			<?php for($z = 0; $z < 6; $z++){
				if($cal9[$z]["E2"]) { $p9 = $cal9[$z]["E2"]; $t9= "EX"; } elseif($cal9[$z]["E1"]) { $p9 = $cal9[$z]["E1"]; $t9= "EX"; } else { $p9 = $cal9[$z]["Promedio"]; $t9= ""; }
				$p9 = number_format($p9);
				?>
			<tr style="font-size: 9px;">
				<td style="width: 175px; height: <?php echo $numg; ?>px; border-bottom: none;"><?php if($cal9[$z]["NombreMod"]) { echo $cal9[$z]["NombreMod"]; } else { echo ""; } ?></td>
				<td style="border-bottom: none; text-align: center;"><?php if($p9) { echo intval($p9); $sumCal9 = $sumCal9 + $p9; $sumM9 = $sumM9 + 1; }  else { echo ""; } ?></td>
				<td style="border-bottom: none; text-align: center;"><?php if($p9) { echo obtenerNumeroEnLetra($p9); } else { echo ""; } ?></td>
				<td style="border-bottom: none; text-align: center;"><?php echo $t9; ?></td>
				<td style="width: 175px; border-bottom: none;"></td>
				<td style="border-bottom: none; text-align: center;"></td>
				<td style="border-bottom: none; text-align: center;"></td>
				<td style="border-bottom: none;"></td>
			</tr>
			<?php } ?>


		<?php if($sumCal1){
			 $sumCall = ($sumCal1+$sumCal2+$sumCal3+$sumCal4+$sumCal5+$sumCal6+$sumCal7+$sumCal8+$sumCal9);
			 $sumMM = ($sumM1+$sumM2+$sumM3+$sumM4+$sumM5+$sumM6+$sumM7+$sumM8+$sumM9);
			$prom = ($sumCall / $sumMM); } else { $prom = 0; }

			?>
		<tr><td></td><td></td><td></td><td></td><td>
		</td><td></td><td></td><td></td></tr>
		<tr>
			<td style="border-left: none; border-bottom: none;"></td>
			<td colspan="3" style="font-size: 11px; text-align: center; "><b>PROMEDIO GENERAL</b><br></td>
			<td style="font-size: 10px; text-align: center; "><b><?php echo round($prom,1);  ?></b></td>
			<td style="border-right: none; border-bottom: none;" colspan="3"></td>
		</tr>

	</table>
	<img src="../../assets/diagonal.png" style="width: 384px; margin-top:-204px; margin-left: 380px; position: relative;">








	<?php $x= 0; for ($i=0;$i< 1;$i++) { ?>  <!-- Define el cuerpo de la hoja -->



	<!-- Fin del cuerpo de la hoja -->
	<?php } ?>



</page>
<?php } else {
	echo "<script type='text/javascript'>window.close();</script>";
} ?>
