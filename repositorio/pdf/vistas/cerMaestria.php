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

	$mod = substr($datUs[0]["CveGrupo"], 5,1);
  $tur = substr($datUs[0]["CveGrupo"], 6,1);
	$datMen=$t->get_menDatos($datUs[0]["IdGrupo"]);

	$cal1=$t->get_calificacion($Usuario,$datUs[0]["IdOferta"],1);
	$cal2=$t->get_calificacion($Usuario,$datUs[0]["IdOferta"],2);
	$cal3=$t->get_calificacion($Usuario,$datUs[0]["IdOferta"],3);
	$cal4=$t->get_calificacion($Usuario,$datUs[0]["IdOferta"],4);



	if($tur == "M"){ $turno = "MATUTINO"; } else { $turno = "MIXTO"; }
	if($mod == "E"){ $modalidad = "ESCOLARIZADO"; } else { $modalidad = "MIXTO"; }


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
    padding: 4px;
}
tr:nth-child(even) {
    background-color: #dddddd;
}

-->
</style>

<!-- page define la hoja con los márgenes señalados -->
<page backtop="10mm" backbottom="10mm" backleft="1mm" backright="10mm">
	<page_header> <!-- Define el header de la hoja -->
	<img src="../../assets/images/logoImg.png" style="width: 90px; margin-top: 70px; margin-left:25px;">
	</page_header>

	<page_footer> <!-- Define el footer de la hoja -->

	</page_footer>

	<table>
		<tr>
			<td style="width: 765px; text-align: center; font-size: 15px; border: none;"><b>GOBIERNO CONSTITUCIONAL DEL ESTADO DE CHIAPAS</b></td>
		</tr>
		<tr>
			<td style="width: 765px; text-align: right; border: none;"><b>SECD </b><b style="color: red;">19</b></td>
		</tr>

		<tr>
			<td style="width: 765px; text-align: center; font-size: 13px; border: none;">
				<b>SECRETARÍA DE EDUCACIÓN<br>
				SUBSECRETARÍA DE EDUCACIÓN ESTATAL<br>
				DIRECCIÓN DE EDUCACIÓN SUPERIOR<br>
				DEPARTAMENTO DE SERVICIOS ESCOLARES
				</b>
			</td>
		</tr>
		<tr>
			<td style="width: 765px; text-align: right; font-size: 12px; border: none;">Folio No: <b style="color: red;"><?php echo $datUs[0]["Folio"]; ?></b></td>
		</tr>
	</table>
	<br><br>
	<table>
		<tr>
		<td style="width: 180; text-align: left; font-size: 12px; border: none;">
		<img src="../../assets/images/fondoImg.png" style="width: 120px;">
		</td>
			<td style="width: 565px; text-align: justify; font-size: 12px; border: none;">
			LA DIRECCIÓN DE LA <b>UNIVERSIDAD DEL SURESTE</b>, REGIMEN PARTICULAR, <label style="color: red;">MODALIDAD <?php echo $datMen[0]["Modalidad"];//$modalidad; ?>, TURNO <?php echo $datMen[0]["Turno"]; //$turno; ?>, CLAVE 07PSU0075W</label>, CERTIFICA QUE:
			<br><br><br>
			EL (LA) C. <b><?php echo $datUs[0]["Nombre"].' '.$datUs[0]["APaterno"].' '.$datUs[0]["AMaterno"]; ?></b>
			<br><br><br>
			CON NÚMERO DE CONTROL: <b><?php echo $Usuario; ?></b>
			<br><br><br>
			ACREDITÓ LAS MATERIAS QUE INTEGRAN EL PLAN DE ESTUDIOS DE LA: <b style="color: red;"><?php echo $datUs[0]["Educativa"]; ?></b> SEGÚN RVOE ACUERDO NÚMERO: <b style="color: red;"><?php echo $datMen[0]["Rvoe"]; ?></b> VIGENCIA A PARTIR DEL <b style="color: red;"><?php echo $datMen[0]["Vigencia"]; ?></b> OTORGADO POR LA SECRETARÍA DE EDUCACIÓN
			<br><br><br>
			DURANTE EL PERIODO: <b><?php echo $datUs[0]["Periodo"]; ?></b>
			<br><br><br>
			CON LOS RESULTADOS QUE A CONTINUACIÓN SE ANOTAN:<br>
			</td>
		</tr>
	</table>

	<br><br><br>
	<table>
		<tr style="text-align: center; font-weight: bold;">
			<td rowspan="2" style="width: 175px;">PRIMER CUATRIMESTRE</td>
			<td colspan="2" style="width:35px;">CALIFICACIÓN</td>
			<td rowspan="2" style="width:65px;">OBSERVACIÓN</td>
			<td rowspan="2" style="width: 175px;">SEGUNDO CUATRIMESTRE</td>
			<td colspan="2" style="width:35px;">CALIFICACIÓN</td>
			<td rowspan="2" style="width:65px;">OBSERVACIÓN</td>
		</tr>
		<tr style="font-weight: bold;">
			<td style="width:35px; text-align: center;">CIFRA</td>
			<td style="width:40px; text-align: center;">LETRA</td>
			<td style="width:35px; text-align: center;">CIFRA</td>
			<td style="width:40px; text-align: center;">LETRA</td>
		</tr>
		<?php $sumCal = 0; $sumM = 0;  for($i = 0; $i < 6; $i++){ ?>
		<tr>
			<td style="width: 175px; border-right: none; border-bottom: none;"><?php if($cal1[$i]["NombreMod"]) { echo $cal1[$i]["NombreMod"]; } else { echo ""; } ?></td>
			<td style="border-right: none; border-bottom: none; text-align: center;"><?php if($cal1[$i]["Promedio"]) { echo $cal1[$i]["Promedio"]; $sumCal = $sumCal + $cal1[$i]["Promedio"]; $sumM = $sumM + 1; }  else { echo ""; } ?></td>
			<td style="border-right: none; border-bottom: none; text-align: center;"><?php if($cal1[$i]["Promedio"]) { echo obtenerNumeroEnLetra($cal1[$i]["Promedio"]); } else { echo ""; } ?></td>
			<td style="border-bottom: none;"></td>
			<td style="width: 175px; border-right: none; border-bottom: none;"><?php if($cal2[$i]["NombreMod"]){ echo $cal2[$i]["NombreMod"]; } else { echo ""; } ?></td>
			<td style="border-right: none; border-bottom: none; text-align: center;"><?php if($cal2[$i]["Promedio"]){ echo $cal2[$i]["Promedio"];  $sumCal = $sumCal + $cal2[$i]["Promedio"]; $sumM = $sumM + 1; } else { echo ""; } ?></td>
			<td style="border-right: none; border-bottom: none; text-align: center;"><?php if($cal2[$i]["Promedio"]){ echo obtenerNumeroEnLetra($cal2[$i]["Promedio"]); } else { echo ""; } ?></td>
			<td style="border-bottom: none;"></td>
		</tr>
		<?php } ?>
		<tr><td colspan="4"><br><br></td><td colspan="4"></td></tr>
		<tr style="text-align: center; font-weight: border: 1px solid blue;">
			<td rowspan="2" style="width: 175px;">TERCER CUATRIMESTRE</td>
			<td colspan="2" style="width:35px;">CALIFICACIÓN</td>
			<td rowspan="2" style="width:65px;">OBSERVACIÓN</td>
			<td rowspan="2" style="width: 175px;">CUARTO CUATRIMESTRE</td>
			<td colspan="2" style="width:35px;">CALIFICACIÓN</td>
			<td rowspan="2" style="width:65px;">OBSERVACIÓN</td>
		</tr>
		<tr style="font-weight: bold;">
			<td style="width:35px; text-align: center;">CIFRA</td>
			<td style="width:40px; text-align: center;">LETRA</td>
			<td style="width:35px; text-align: center;">CIFRA</td>
			<td style="width:40px; text-align: center;">LETRA</td>
		</tr>
		<?php for($v = 0; $v < 6; $v++){ ?>
		<tr>
			<td style="width: 175px; border-right: none; border-bottom: none;"><?php if($cal3[$v]["NombreMod"]) { echo $cal3[$v]["NombreMod"]; } else { echo ""; } ?></td>
			<td style="border-right: none; border-bottom: none; text-align: center;"><?php if($cal3[$v]["Promedio"]) { echo $cal3[$v]["Promedio"]; $sumCal = $sumCal + $cal3[$v]["Promedio"]; $sumM = $sumM + 1; }  else { echo ""; } ?></td>
			<td style="border-right: none; border-bottom: none; text-align: center;"><?php if($cal3[$v]["Promedio"]) { echo obtenerNumeroEnLetra($cal3[$v]["Promedio"]); } else { echo ""; } ?></td>
			<td style="border-bottom: none;"></td>
			<td style="width: 175px; border-right: none; border-bottom: none;"><?php if($cal4[$v]["NombreMod"]){ echo $cal4[$v]["NombreMod"]; } else { echo ""; } ?></td>
			<td style="border-right: none; border-bottom: none; text-align: center;"><?php if($cal4[$v]["Promedio"]){ echo $cal4[$v]["Promedio"]; $sumCal = $sumCal + $cal4[$v]["Promedio"]; $sumM = $sumM + 1; } else { echo ""; } ?></td>
			<td style="border-right: none; border-bottom: none; text-align: center;"><?php if($cal4[$v]["Promedio"]){ echo obtenerNumeroEnLetra($cal4[$v]["Promedio"]); } else { echo ""; } ?></td>
			<td style="border-bottom: none;"></td>
		</tr>
		<?php } ?>
		<?php if($sumM){ $prom = ($sumCal / $sumM); } else { $prom = 0; } ?>
		<tr><td colspan="4"><br><br></td><td colspan="4"></td></tr>
		<tr>
			<td style="border-left: none; border-bottom: none;"></td>
			<td colspan="3" style="font-size: 14px; text-align: center; "><br><b>PROMEDIO GENERAL</b><br><br></td>
			<td style="font-size: 14px; text-align: center; "><b><?php echo round($prom);  ?></b></td>
			<td style="border-right: none; border-bottom: none;" colspan="3"></td>
		</tr>

	</table>
<br><br>
<p>Este documento no es válido si presenta raspaduras o enmendaduras.</p>







	<?php $x= 0; for ($i=0;$i< 1;$i++) { ?>  <!-- Define el cuerpo de la hoja -->



	<!-- Fin del cuerpo de la hoja -->
	<?php } ?>



</page>
<?php } else {
	echo "<script type='text/javascript'>window.close();</script>";
} ?>
