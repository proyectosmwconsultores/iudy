<?php
if($_SESSION['Permisos']){
	include('numeros.php');
	require_once'../portafolio.php';
	$t=new Imprimir();
	$IdAsignacion = $_GET["tokenId"];
	$lstGrp=$t->get_calificacion_grupo_final($IdAsignacion);
	$encabz=$t->get_datos_impresion($IdAsignacion);
	$campus=$t->get_campus_id($lstGrp[0]['IdCampus']);
	$_bim = $_GET["tok"];
	if($_bim == 1){
		$_fecx = "Fec_emi_bim1";
		$cal = "P".$_bim;
	} else {
		$_fecx = "Fec_emi_bim2";
		$cal = "P".$_bim;
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
    border: 0.5px solid black;
    padding: 2px;
}
tr:nth-child(even) {
    background-color: #dddddd;
}

-->
</style>

<!-- page define la hoja con los márgenes señalados -->
<page backtop="60mm" backbottom="20mm" backleft="10mm" backright="10mm">
	<page_header> <!-- Define el header de la hoja -->


	<img src="../../assets/images/campus/hoja_arriba.png" style="width: 100%;" >

	<p style='text-align: center; font-size: 12px;'><b>REPORTE DE CALIFICACIONES DEL <?php echo $_GET["tok"]; ?>° BIMESTRE</b></p>
		<table style='margin-left: 38px; margin-top: 5px;'>
			<tr>
				<td style="width: 80px; border-bottom: none; border-left: none; border-top: none; border-right: none;"><?php if($encabz[0]['TipoCiclo'] == 'C'){ echo "CUATRIMESTRE"; } else { echo "SEMESTRE"; } ?>:</td>
				<td style="width: 20px; text-align: center; border-left: none; border-top: none; border-right: none;"><?php echo $encabz[0]['Grado']; ?></td>
				<td style="width: 50px; text-align: right; border-bottom: none; border-left: none; border-top: none; border-right: none;">GRUPO:</td>
				<td style="width: 30px; text-align: center; border-left: none; border-top: none; border-right: none;"><?php echo $encabz[0]['Grupo']; ?></td>
				<td style="width: 100px; text-align: right; border-bottom: none; border-left: none; border-top: none; border-right: none;">MODALIDAD:</td>
				<td style="width: 144px; text-align: center; border-left: none; border-top: none; border-right: none;"><?php echo $encabz[0]['_Modalidad']; ?> - <?php echo $encabz[0]['_Dias']; ?></td>
				<td style="width: 80px; text-align: right; border-bottom: none; border-left: none; border-top: none; border-right: none;">NIVEL:</td>
				<td style="width: 120px; text-align: center; border-left: none; border-top: none; border-right: none;"><?php echo $encabz[0]['_Grado']; ?></td>
			</tr>
			<tr>
				<td style="width: 80px; border-bottom: none; border-left: none; border-top: none; border-right: none;">PROGRAMA:</td>
				<td colspan="7" style="border-right: none; width: 500px;"><?php echo $encabz[0]['Educativa']; ?></td>
			</tr>
			<tr>
				<td style="width: 80px; border-bottom: none; border-left: none; border-top: none; border-right: none;">MATERIA:</td>
				<td colspan="7" style="border-right: none; width: 500px;"><?php echo $encabz[0]['NombreMod']; ?></td>
			</tr>
			<tr>
				<td style="width: 80px; border-bottom: none; border-left: none; border-top: none; border-right: none;">DOCENTE:</td>
				<td colspan="7" style="border-right: none; width: 500px;"><?php echo $encabz[0]['Nombre'].' '.$encabz[0]['APaterno'].' '.$encabz[0]['AMaterno']; ?></td>
			</tr>
			<tr>
				<td colspan="3" style="width: 170px; border-bottom: none; border-left: none; border-top: none; border-right: none;">TUXTLA GUTIERRREZ, CHIAPAS; A </td>
				<td colspan="5" style="border-right: none; width: 300px;"><?php echo obt_fec_impresion($encabz[0][$_fecx]); ?></td>
			</tr>


		</table>


	</page_header>

	<page_footer> <!-- Define el footer de la hoja -->

	<img src="../../assets/images/campus/hoja_abajo.png" style="width: 100%;" >

	</page_footer>

	<?php $x= 0; for ($i=0;$i< 1;$i++) { ?>  <!-- Define el cuerpo de la hoja -->
	<table style="font-size: 9px; margin-left: 4px;">
			<tr>
				<td style="width: 15px;"></td>
				<td rowspan='2' style="width: 50px; text-align: center;">NO. CONTROL</td>
				<td rowspan='2' style="width: 288px; text-align: center;">NOMBRE</td>
				<td colspan='2' style="width: 188px; text-align: center;">CALIFICACIÓN <?php echo $_GET["tok"]; ?>° BIMESTRE</td>
				<td style="width: 100px;"></td>
			</tr>
			<tr>
				<td style="width: 15px; text-align: center;">N/P</td>
				<td style="width: 80px; text-align: center;">NÚMERO</td>
				<td style="width: 80px; text-align: center;">LETRA</td>
				<td style="width: 100px; text-align: center;">OBSERVACIÓN</td>
			</tr>
			<?php $colr=""; $prom = 0; for ($y=0;$y< sizeof($lstGrp);$y++) { $x = $x + 1;
				$prom = ($prom + $lstGrp[$y]['Promedio']);
				if(($lstGrp[$y][$cal] == 5) || ($lstGrp[$y][$cal] == 'NP')){ $colr=" color: red;"; } else { $colr=""; }
				 ?>
				<tr>
					<td style="width: 15px; text-align: center;"><?php echo $x; ?></td>
					<td style="width: 50px;"><?php echo $lstGrp[$y]['Usuario']; ?></td>
					<td style="width: 288px"><?php echo $lstGrp[$y]['APaterno'].' '.$lstGrp[$y]['AMaterno'].' '.$lstGrp[$y]['Nombre']; ?></td>
					<td style="width: 80px; text-align: center; <?php echo $colr; ?>"><?php echo $lstGrp[$y][$cal]; ?></td>
					<td style="width: 80px; text-align: center; <?php echo $colr; ?>"><?php echo obtNumLetr($lstGrp[$y][$cal]); ?></td>
					<td style="width: 100px;"></td>
				</tr><?php } $pro_grupo = ($prom / $x);
			//	$t->get_prom_grupo($IdAsignacion,number_format($pro_grupo, 1, '.', ','));
					$num = (45 - $x);

					for ($g=0;$g< $num;$g++) { $x = ($x + 1);
				 ?>
				 <tr>
 					<td style="width: 15px; text-align: center;"><?php echo $x; ?></td>
 					<td style="width: 50px;"><?php if($g == 0){ echo "************"; } ?></td>
 					<td style="width: 288px"><?php if($g == 0){ echo "************ ************ ************ ************ ************"; } ?></td>
 					<td style="width: 80px;"></td>
 					<td style="width: 80px;"></td>
 					<td style="width: 100px;"></td>
 				</tr><?php } ?>

	</table>
	<br><br><br><br><br>
	<table style="margin-left: 43px;">
		<tr>
			<td style="width: 85px; text-align: center; border: none; "></td>
			<td style="width: 160px; text-align: center; border: none; ">___________________________</td>
			<td style="width: 160px; text-align: center; border: none; ">___________________________</td>
			<td style="width: 160px; text-align: center; border: none; ">___________________________</td>
			<td style="width: 85px; text-align: center; border: none; "></td>
		</tr>
		<tr>
			<td style="width: 85px; text-align: center; border: none; "></td>
			<td style="width: 160px; text-align: center; border: none; font-size: 8px;">Vo.Bo. SERVICIOS ESCOLARES</td>
			<td style="width: 160px; text-align: center; border: none; font-size: 8px;">Vo.Bo. COORDINACIÓN</td>
			<td style="width: 160px; text-align: center; border: none; font-size: 8px;">FIRMA DEL CATEDRÁTICO</td>
			<td style="width: 85px; text-align: center; border: none; "></td>
		</tr>

	</table>

	<!-- Fin del cuerpo de la hoja -->
	<?php } ?>

</page>
<?php
 } else {
	echo "<script type='text/javascript'>window.close();</script>";
} ?>
