<?php
if($_SESSION['Permisos']){
	require_once'../classprint.php';
	include('numeros.php');
	//include('../pdf/hace.php');
	$t=new Imprimir();
	$Usuario = $_GET["tokenId"];
	$_SESSION["Mat"] = $Usuario;
	$datUs=$t->get_datUsuario($Usuario);
	$dax=$t->get_configuracion();

	 $datG=$t->get_datGradoD($Usuario);
	$datGd=$t->get_updCiclo($Usuario,$datG[0]["Grado"]);
	$chkRep=$t->get_chkRep($Usuario,$datUs[0]["IdOferta"]);

	//if($datUs[0]['TipoCiclo'] == 'C'){ $xc1 = 'CUATRIMESTRAL'; $xc2 = 'CUATRIMESTRE'; } else { $xc1 = 'SEMESTRAL'; $xc2 = 'SEMESTRE'; }

	$datMen=$t->get_menDatos($datUs[0]["IdGrupo"]);

	$cal1=$t->get_calificacion($Usuario,$datUs[0]["IdOferta"], substr($_GET["Grado"],10,10));
	$edct=$t->get_ofertaId($datUs[0]["IdOferta"]);

  $campus=$t->get_campus_id($datUs[0]['IdCampus']);
	$_px = 6;
	if($edct[0]['IdGrado'] == 1){ $_px = 8; } elseif($edct[0]['IdGrado'] == 2){ $_px = 8; } elseif($edct[0]['IdGrado'] == 3){ $_px = 6; }

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
    border: 0.3px solid black;
    padding: 3px;
}


-->
</style>

<!-- page define la hoja con los márgenes señalados -->
<page backtop="35mm" backbottom="20mm" backleft="10mm" backright="10mm">
	<page_header> <!-- Define el header de la hoja -->
	<table style="margin-left: 42px; margin-top: 20px; font-size: 9px; text-align: center; font-weight: bold;">
		<tr>
			<td colspan="2" style="width: 130px;"><img src="../../assets/images/campus/secretaria.png" style="width: 100%;" ></td>
			<td colspan="4" style="width: 290px; font-size: 12px;">Instituto Universitario de Yucatán<br><br><br><b style="font-size: 11px;">BOLETA DE CALIFICACIÓN</b></td>
			<td colspan="2" style="width: 130px;"><img src="../../assets/images/campus/iso.png" style="width: 120px;" ></td>
		</tr>
		<tr>
			<td colspan="2" style="width: 130px;">CÓDIGO:<br>SPC/ENPC-FO-PROCOAD-06</td>
			<td colspan="2" style="width: 167px;">ÁREA:<br>Instituto Universitario de Yucatán</td>
			<td style="width: 56px;">REVISIÓN:<br>02</td>
			<td colspan="2" style="width: 141px;">FECHA DE IMPLEMENTACIÓN:<br>27/05/2020</td>
			<td style="width: 60px;">PÁGINA:<br>1 DE 1</td>
		</tr>
		<tr>
			<td colspan="8" style="border-left: none; border-right: none; border-bottom: none;"></td>
		</tr>
		<tr>
			<td style="width: 60px; border: none;"></td>
			<td style="width: 70px; border: none;"></td>
			<td style="width: 71px; border: none;"></td>
			<td style="width: 96px; border: none;"></td>
			<td style="width: 56px; border: none;"></td>
			<td style="width: 71px; border: none;"></td>
			<td style="width: 70px; border: none;"></td>
			<td style="width: 60px; border: none;"></td>
		</tr>
	</table>

	</page_header>

	<page_footer> <!-- Define el footer de la hoja -->
		<table style="margin-left: 42px;">
			<tr>
				<td style="text-align: right; width: 200px; border: none;"></td>
				<td style="text-align: center; width: 233px; border-right: none; border-bottom: none;">FIRMA DEL DOCENTE</td>
				<td style="text-align: right; width: 200px; border: none;"></td>
			</tr>
			<tr>
				<td style="text-align: right; width: 200px; border: none;"></td>
				<td style="text-align: center; width: 233px; border: none;"></td>
				<td style="text-align: right; width: 200px; border: none;">SPC/ENPC-FO-PROCOAD-06</td>
			</tr>
		</table>
		<br><br>
	</page_footer>

	<br><br><br>
	<table style="font-size: 9px;">
		<tr>
			<td colspan="4" style="width: 500px; font-size: 14px; text-align: center; border-left: none; border-right: none; border-top: none; height: 40px;"><b>BOLETA DE CALIFICACIÓN FINAL</b></td>
		</tr>
		<tr>
			<td colspan="4" style="width: 500px; font-size: 12px; text-align: center;"><b><?php //echo $edct[0]["Nombre"]; ?></b></td>
		</tr>
		<tr>
			<td colspan="4" style="width: 500px; font-size: 12px; text-align: center; border-left: none; border-right: none;">&nbsp;</td>
		</tr>
		<tr>
			<td style="width: 90px; border-right: none; border-bottom: none;">NOMBRE:</td>
			<td style="width: 290px; border-right: none; "><?php //echo $datUs[0]["Nombre"].' '.$datUs[0]["APaterno"].' '.$datUs[0]["AMaterno"]; ?></td>
			<td style="width: 80px; text-align: right; border-right: none; border-bottom: none;"><?php //echo $xc2; ?>:</td>
			<td style="width: 180px; "><?php //echo substr($_GET["Grado"],10,10); ?> °</td>
		</tr>
		<tr>
			<td style="width: 90px; border-right: none; border-bottom: none;">LICENCIATURA:</td>
			<td style="width: 285px; border-right: none; "><?php //echo $edct[0]["Nombre"]; ?></td>
			<td style="width: 80px; text-align: right; border-right: none; border-bottom: none;">GRUPO:</td>
			<td style="width: 180px;"><?php //echo $datUs[0]["CveGrupo"]; ?></td>
		</tr>
		<tr>
				<td style="width: 90px; border-right: none; ">PERIODO ESCOLAR:</td>
			<td  style="width: 285px; border-right: none;"><?php// echo $cal1[0]['Ciclo']; ?></td>
			<td style="width: 80px; text-align: right; border-right: none; ">MATRICULA:</td>
			<td style="width: 180px;"><?php //echo $Usuario; ?></td>
		</tr>
	</table>
	<br>
	<br><br><br><br>
	<table style="font-size: 9px;">
		<tr style="background: #ccc4c4;">
			<td rowspan="2" style="width: 338px; text-align: center;"><b>NOMBRE DE LA MATERIA</b></td>
			<td colspan="2" style="width: 100px; text-align: center;"><b>CALIFICACIONES</b></td>
		</tr>
		<tr style="background: #ccc4c4;">
			<td style="width: 100px; text-align: center;"><b>CIFRA</b></td>
			<td style="width: 100px; text-align: center;"><b>LETRA</b></td>
		</tr>

		<?php $prom = 0; $cs1 = 0; $cxl1 = 0; foreach($cal1 as $lista){
		 //for($i = 0; $i < sizeof($cal1); $i++){
			 if($lista["E2"]) { $p1 = $lista["E2"];  $t1= "EX"; } elseif($lista["E1"]) { $p1 = $lista["E1"]; $t1= "EX"; } else { $p1 = $lista["Promedio"]; $t1= ""; }
			 $p1 = intval($p1);
			?>
		<tr>
			<td><?php echo $lista["NombreMod"]; ?></td>
			<td style="text-align: center;"><?php echo $p1; $cs1 = ($cs1+1); ?></td>
			<td style="text-align: center;"><?php echo obtenerNumeroEnLetra($p1); ?></td>

		</tr>
		<?php $cxl1 = ($p1 + $cxl1); } ?>
	</table>
	<?php
$px = 0;
if($cxl1){ $prom = ($cxl1/$cs1); }
?>
<table style="font-size: 9px;">

	<tr>
		<td style="width: 176px; border-left: none; border-bottom: none; "></td>
		<td style="width: 150px; text-align: right;"><b>PROMEDIO GENERAL:</b></td>
		<td style="width: 213px; text-align: center; background: #ccc4c4;">
			<b><?php
		echo $px = number_format($prom, 1, '.', ',');
			echo ' ('.promedio_letra_grp($px).')';
			 ?>
			</b>
		</td>
	</tr>
</table><br>
<p style="text-align: justify; font-size: 12px;">Este documento no es válido si presenta raspaduras o enmendaduras: La escala de calificaciones es de 6 a 10 calificación mínima aprobatoria: <?php echo $_px; ?>.</p>
<br><br>
<p style="text-align: center; font-size: 12px;"><b>DIRECTOR</b><br><br><br><br><br>
____________________________________________ <br>
<b><?php echo $dax[9]['Descripcion']; ?></b>
</p>

	<?php $x= 0; for ($i=0;$i< 1;$i++) { ?>  <!-- Define el cuerpo de la hoja -->



	<!-- Fin del cuerpo de la hoja -->
	<?php } ?>



</page>
<?php } else {
	echo "<script type='text/javascript'>window.close();</script>";
} ?>
