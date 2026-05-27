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


	$mod = substr($datUs[0]["CveGrupo"], 5,1);
  $tur = substr($datUs[0]["CveGrupo"], 6,1);
	$datMen=$t->get_menDatos($datUs[0]["IdGrupo"]);
	$anio = date("Y");
 	$an = substr($anio,2,2);
	$cal1=$t->get_calificacion($Usuario,$datUs[0]["IdOferta"],1);
	$cal2=$t->get_calificacion($Usuario,$datUs[0]["IdOferta"],2);
	$cal3=$t->get_calificacion($Usuario,$datUs[0]["IdOferta"],3);
	$cal4=$t->get_calificacion($Usuario,$datUs[0]["IdOferta"],4);


$oferta = $datUs[0]["Educativa"];
if(($datUs[0]["IdOferta"] == 1) || ($datUs[0]["IdOferta"] == 9)){
	$oferta = "LICENCIATURA EN ENFERMERIA";
}


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
<page backtop="15mm" backbottom="10mm" backleft="1mm" backright="10mm">
	<page_header> <!-- Define el header de la hoja -->
	<img src="../../assets/images/logoImg.png" style="width: 85px; margin-top: 55px; margin-left:50px;">
	</page_header>

	<page_footer> <!-- Define el footer de la hoja -->
		<p style="font-size: 10px; ">Este documento no es válido si presenta raspaduras o enmendaduras.</p>
		<br><br><br><br><br>
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
			LA DIRECCIÓN DE LA <b>UNIVERSIDAD DEL SURESTE</b>, REGIMEN PARTICULAR, MODALIDAD <?php echo $datMen[0]["Modalidad"];//$modalidad; ?>, TURNO <?php echo $datMen[0]["Turno"]; //$turno; ?>, CLAVE <?php echo $datMen[0]["Clave"]; ?>, CERTIFICA QUE:
			<br><br><br>
			EL (LA) C. <b style="margin-left: 100px;"><?php echo $datUs[0]["Nombre"].' '.$datUs[0]["APaterno"].' '.$datUs[0]["AMaterno"]; ?></b>
			<br><br><br>
			CON NÚMERO DE CONTROL: <b style="margin-left: 100px;"><?php echo $Usuario; ?></b>
			<br><br>
			ACREDITÓ LAS MATERIAS QUE INTEGRAN EL PLAN DE ESTUDIOS DE LA: <b><?php echo $oferta; ?></b> SEGÚN RVOE ACUERDO NÚMERO:<b><?php echo $datMen[0]["Rvoe"]; ?></b> VIGENCIA A PARTIR DEL <b><?php echo $datMen[0]["Vigencia"]; ?></b> OTORGADO POR LA SECRETARÍA DE EDUCACIÓN.
			<br><br><br>
			DURANTE EL PERIODO: <b><?php echo $datUs[0]["Periodo"]; ?></b>
			<br><br><br>
			CON LOS RESULTADOS QUE A CONTINUACIÓN SE ANOTAN:<br><br><br>
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
		<?php $sumCal = 0; $sumM = 0;  for($i = 0; $i < 7; $i++){
			if($cal1[$i]["E2"]) { $p1 = $cal1[$i]["E2"]; $t1= "EX"; } elseif($cal1[$i]["E1"]) { $p1 = $cal1[$i]["E1"]; $t1= "EX"; } else { $p1 = $cal1[$i]["Promedio"]; $t1= ""; }
			if($cal2[$i]["E2"]) { $p2 = $cal2[$i]["E2"]; $t2= "EX"; } elseif($cal2[$i]["E1"]) { $p2 = $cal2[$i]["E1"]; $t2= "EX"; } else { $p2 = $cal2[$i]["Promedio"]; $t2= ""; }
			$p1 = number_format($p1);
			$p2 = number_format($p2);
			?>
		<tr style="font-size: 9px;">
			<td style="width: 175px; height: 17px; border-bottom: none;"><?php if($cal1[$i]["NombreMod"]) { echo $cal1[$i]["NombreMod"]; } else { echo ""; } ?></td>
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
		<?php for($v = 0; $v < 7; $v++){
			if($cal3[$v]["E2"]) { $p3 = $cal3[$v]["E2"]; $t3= "EX"; } elseif($cal3[$v]["E1"]) { $p3 = $cal3[$v]["E1"]; $t3= "EX"; } else { $p3 = $cal3[$v]["Promedio"]; $t3= ""; }
			if($cal4[$v]["E2"]) { $p4 = $cal4[$v]["E2"]; $t4= "EX"; } elseif($cal4[$v]["E1"]) { $p4 = $cal4[$v]["E1"]; $t4= "EX"; } else { $p4 = $cal4[$v]["Promedio"]; $t4= ""; }
			$p3 = number_format($p3);
			$p4 = number_format($p4);
			 ?>
		<tr style="font-size: 9px;">
			<td style="width: 175px; height: 17px; border-bottom: none;"><?php if($cal3[$v]["NombreMod"]) { echo $cal3[$v]["NombreMod"]; } else { echo ""; } ?></td>
			<td style="border-bottom: none; text-align: center;"><?php if($p3) { echo intval($p3); $sumCal3 = $sumCal3 + $p3; $sumM3 = $sumM3 + 1; }  else { echo ""; } ?></td>
			<td style="border-bottom: none; text-align: center;"><?php if($p3) { echo obtenerNumeroEnLetra($p3); } else { echo ""; } ?></td>
			<td style="border-bottom: none; text-align: center;"><?php echo $t3; ?></td>
			<td style="width: 175px; border-bottom: none;"><?php if($cal4[$v]["NombreMod"]){ echo $cal4[$v]["NombreMod"]; } else { echo ""; } ?></td>
			<td style="border-bottom: none; text-align: center;"><?php if($p4){ echo intval($p4); $sumCal4 = $sumCal4 + $p4; $sumM4 = $sumM4 + 1; } else { echo ""; } ?></td>
			<td style="border-bottom: none; text-align: center;"><?php if($p4){ echo obtenerNumeroEnLetra($p4); } else { echo ""; } ?></td>
			<td style="border-bottom: none; text-align: center;"><?php echo $t4; ?></td>
		</tr>
		<?php } ?>


		<?php if($sumCal1){
			 $sumCall = ($sumCal1+$sumCal2+$sumCal3+$sumCal4);
			 $sumMM = ($sumM1+$sumM2+$sumM3+$sumM4);
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
<br><br>








	<?php $x= 0; for ($i=0;$i< 1;$i++) { ?>  <!-- Define el cuerpo de la hoja -->



	<!-- Fin del cuerpo de la hoja -->
	<?php } ?>



</page>
<?php } else {
	echo "<script type='text/javascript'>window.close();</script>";
} ?>
