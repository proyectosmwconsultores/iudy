<?php
session_start();
if($_SESSION['Permisos']){
	require_once'../classprint.php';
	$t=new Imprimir();
	$lstLista=$t->get_lstListaFinal(substr($_GET["idCa"], 10, 10),substr($_GET["idCi"], 10, 10));
	$lstCa=$t->get_lstCam(substr($_GET["idCa"], 10, 10));
	$lstCi=$t->get_lstCic(substr($_GET["idCi"], 10, 10));
	$uni=$t->get_plataforma();
	$t = 0;
	for ($b=0;$b< sizeof($lstLista);$b++) { if($lstLista[$b]["Promedio"] <> 0){
		 $prom = ($prom + $lstLista[$b]["Promedio"]);
			$t = $t + 1;
	  } }
		$promT = ($prom / $t);
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
<page backtop="28mm" backbottom="15mm" backleft="10mm" backright="10mm">
	<page_header> <!-- Define el header de la hoja -->
<br>
	<table style="margin-left: 38px;">
		<tr>
			<td rowspan="2" style="width: 140px; text-align: left; border: none; ">
			<img src="../../assets/images/campus/logo_inicio.png" style="width: 100%;">
			</td>
			<td style="width: 370px; text-align: center; font-size: 18px; border: none;"><b><?php echo $uni[0]['Descripcion']; ?></b></td>
			<td style="width: 140px; text-align: center; border: none;"></td>
		</tr>
		<tr>
			<td style="width: 365px; text-align: center; font-size: 14px; border: none;"><b>EVALUACIÓN DOCENTE</b></td>
			<td style="width: 140px; text-align: center; border: none;"></td>
		</tr>
	</table>

	</page_header>

	<page_footer> <!-- Define el footer de la hoja -->

	</page_footer>
	<table style="font-size: 9px;">
		<tr>
			<td style="width: 130px; border-right: none; border-bottom: none;">CUATRIMESTRE:</td>
			<td style="width: 200px; border-right: none; "><?php echo $lstCi[0]["Ciclo"]; ?></td>
			<td style="width: 180px; text-align: right; border-right: none; border-bottom: none;">PROFESORES EVALUADOS:</td>
			<td style="width: 130px; "><?php echo $t; ?></td>
		</tr>
		<tr>
			<td style="width: 130px; border-right: none; border-bottom: none; ">CAMPUS:</td>
			<td style="width: 200px; border-right: none;"><?php echo $lstCa[0]["Campus"]; ?></td>
			<td style="width: 180px; text-align: right; border-right: none; border-bottom: none;">ARRIBA DEL PROMEDIO:</td>
			<td style="width: 130px; "><?php echo $datUs[0]["Periodo"]; ?></td>
		</tr>
		<tr>
			<td style="width: 130px; border-right: none;">PROMEDIO GENERAL:</td>
			<td style="width: 200px; border-right: none; "><?php echo round($promT,2); ?></td>
			<td style="width: 180px; text-align: right; border-right: none;">ABAJO DEL PROMEDIO:</td>
			<td style="width: 130px; "></td>
		</tr>
	</table>
	<br>

	<table style="font-size: 9px;">
		<tr>
			<td style="width: 30px; text-align: center;">NO</td>
			<td style="width: 439px; text-align: left;">NOMBRE DEL PROFESOR</td>
			<td style="width: 180px; text-align: center;">PROMEDIO GENERAL</td>
		</tr>
		<?php for ($i=0;$i< sizeof($lstLista);$i++) { if($lstLista[$i]["Promedio"] <> 0){ ?>
		<tr>
			<td style="width: 30px; text-align: center;"><?php echo $v = $v + 1; ?></td>
			<td style="width: 439px; text-align: left;"><?php echo $lstLista[$i]["APaterno"].' '.$lstLista[$i]["AMaterno"].' '.$lstLista[$i]["Nombre"]; ?></td>
			<td style="width: 180px; text-align: center;"><?php echo $lstLista[$i]["Promedio"]; ?></td>
		</tr>
		<?php } } ?>


	</table>



</page>
<?php } else {
	echo "<script type='text/javascript'>window.close();</script>";
} ?>
