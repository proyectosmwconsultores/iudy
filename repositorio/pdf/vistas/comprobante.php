<?php
// session_start();
if($_SESSION['Permisos']){
	require_once'../classprint.php';
	include("numeros.php");
	include("importe.php");
	include("hace.php");
	$t=new Imprimir();

	$_Folio = substr($_GET["idToks"], 10, 20);
	$datosFolio=$t->get_dato_folio($_Folio);
	$datosGrupo=$t->get_datoGrp($datosFolio[0]["IdGrupo"]);
	$datosPago=$t->get_datoPag($datosFolio[0]["IdPago"]);

	$niv=$t->get_grad_px($datosFolio[0]["IdGrupo"],$datosPago[0]['IdCiclo']);

	$lstFolio=$t->get_lstdato_folio($_Folio);
	if(isset($lstFolio[0]['_idtemporal'])){
	    $temporal=$t->get_lst_temporal($lstFolio[0]['_idtemporal']);
	}

	if(!$datosFolio[0]["IdPago"]){
		echo "<script type='text/javascript'>window.close();</script>";
	}
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
    border: 1px solid #003A70;
    padding: 4px;
}
tr:nth-child(even) {
    background-color: #dddddd;
}


-->
</style>

<!-- page define la hoja con los márgenes señalados -->
<page backtop="10mm" backbottom="20mm" backleft="10mm" backright="10mm">
	<page_header> <!-- Define el header de la hoja -->

	</page_header>

	<page_footer> <!-- Define el footer de la hoja -->

	</page_footer>
		<table>
			<tr style="font-size: 10px;">
				<td style="width: 150px; border: none; "><img src="../../assets/images/campus/logo_inicio.png" style="width: 150px;" ></td>
				<td style="width: 328px; text-align: center; border: none;">
					<b style="font-size: 14px;">INSTITUTO UNIVERSITARIO DE YUCATÁN</b>
					<p style="font-size: 9px; font-family: courier;">
						RFC: CIE090115D22<br>
						Carretera Federal Villahermosa-Teapa No. KM. 1<br> Plutarco Elias Calles, 86280, <br>
						Centro Tabasco, México.<br>
						TEL. 999 518 2223
					</p>
				</td>
				<td style="width: 150px; text-align: center;  border: none; font-family: courier; ">
					<p><b>FECHA</b></p>
					<p style="margin-top: -7px;"><?php echo obtFechConst($lstFolio[0]['FecCap']); ?><br><?php echo substr($lstFolio[0]['FecCap'], 11, 10); ?></p>
					<p><b>RECIBO</b></p>
					<p style="margin-top: -7px; font-size: 14px; color: red;"><b><?php echo $lstFolio[0]['NoFolio']; ?></b></p>
				</td>
			</tr>
		</table><br><br>

		<table style="font-size: 10px;">
			<?php if(($datosGrupo[0]['IdGrado'] == 1) || ($datosGrupo[0]['IdGrado'] == 2) || ($datosGrupo[0]['IdGrado'] == 3) || ($datosGrupo[0]['IdGrado'] == 4)){  ?>
			<tr>
				<td style="width: 55px; text-align: right; border-right: none; border-bottom: none;"><b>NOMBRE:</b></td>
				<td colspan="3" style="width: 205px; font-family: courier; border-right: none; border-bottom: none;"><?php echo $datosFolio[0]["APaterno"].' '.$datosFolio[0]["AMaterno"].' '.$datosFolio[0]["Nombre"]; ?></td>
				<td style="width: 55px; text-align: right; border-right: none; border-bottom: none;"><b>NIVEL:</b></td>
				<td style="width: 266px; font-family: courier; border-bottom: none;"><?php echo $datosGrupo[0]["Nombre"]; ?></td>
			</tr>
			<tr>
				<td style="width: 55px; text-align: right; border-right: none;"><b>GRADO:</b></td>
				<td style="width: 55px; border-right: none; font-family: courier;"><?php if(isset($niv[0]['Grado'])){ echo $niv[0]['Grado']; } ?> - <?php if(isset($datosGrupo[0]['Grupo'])){ echo $datosGrupo[0]['Grupo']; } ?></td>
				<td style="width: 60px; text-align: right; border-right: none;"><b>MATRÍCULA:</b></td>
				<td style="width: 90px; border-right: none; font-family: courier;"><?php echo $datosFolio[0]['Usuario']; ?></td>
				<td style="width: 55px; text-align: right; border-right: none;"><b>CICLO:</b></td>
				<td style="width: 266px; font-family: courier;"><?php if(isset($niv[0]['Ciclo'])){ echo $niv[0]['Ciclo']; } ?></td>
			</tr><?php } else { 
			
			$oferta=$t->get_oferta_id($datosPago[0]["IdOferta"]);
			?>
				<tr>
				<td style="width: 55px; text-align: right; border-right: none; border-bottom: none;"><b>NOMBRE:</b></td>
				<td colspan="3" style="width: 205px; font-family: courier; border-right: none; border-bottom: none;"><?php echo $datosFolio[0]["APaterno"].' '.$datosFolio[0]["AMaterno"].' '.$datosFolio[0]["Nombre"]; ?></td>
				<td style="width: 55px; text-align: right; border-right: none; border-bottom: none;"></td>
				<td style="width: 266px; font-family: courier; border-bottom: none;"><?php echo $oferta[0]["Nombre"]; ?></td>
			</tr>
			<tr>
				<td style="width: 55px; text-align: right; border-right: none;"><b>MATRÍCULA:</b></td>
				<td style="width: 55px; border-right: none; font-family: courier;"><?php echo $datosFolio[0]['Usuario']; ?></td>
				<td style="width: 60px; text-align: right; border-right: none;"></td>
				<td style="width: 90px; border-right: none; font-family: courier;"></td>
				<td style="width: 55px; text-align: right; border-right: none;"></td>
				<td style="width: 266px; font-family: courier;"></td>
			</tr>
			<?php } ?>
		</table>
		<br><br>
		<div style="width: 674px; padding: 5px; font-size: 10px; border-radius: 10px; height: 240px; border: 1px solid #003A70;">
			<table>
				<tr>
					<td style="border: none; width: 100px;"><b>CONCEPTO</b></td>
					<td style="border: none; width: 450px;"><b>DESCRIPCIÓN</b></td>
					<td style="border: none; width: 60px; text-align: right;"><b>IMPORTE</b></td>
				</tr>
				<?php $_sum = 0; for ($i=0;$i< sizeof($lstFolio);$i++) {
					$_fxP=$t->get_datoPag($lstFolio[$i]["IdPago"]);
					 ?>
				<tr>
					<td colspan="2" style="border: none; width: 495px; font-family: courier;">
					<?php echo $lstFolio[$i]["NomPlan"].' '; echo fec_Mes($_fxP[0]["Fecha"]);  ?>
					<?php if($lstFolio[$i]["Estatus"] == 37){ echo " <b>(ABONO)</b>"; } ?><br>
					<?php echo '<br>**'.$lstFolio[$i]["Nota"]; ?>
					</td>
					<td style="border: none; width: 60px; text-align: right; font-family: courier;">$ <?php echo number_format($lstFolio[$i]["Monto"], 2, '.', ','); ?></td>
				</tr>
				<?php $_sum = ($_sum + $lstFolio[$i]["Monto"]);  } $vaImpor = $_sum.'.00'; ?>
				<?php for ($x=$i;$x<=4;$x++) { ?>
				<tr>
					<td colspan="3" style="width: 140px; border: none;">&nbsp;</td>
				</tr> <?php } ?>
			</table><br>
			<table>
				<tr>
					<td style="width: 513px; border: none;"></td>
					<td style="width: 110px; border: none; text-align: right;"><b>TOTAL</b></td>
				</tr>
				<tr>
					<td style="width: 500px; border: none; font-family: courier;">(<?php echo num2letras($vaImpor, false, false); ?>)</td>
					<td style="width: 110px; border: none; text-align: right; font-family: courier;">$ <?php echo number_format($_sum, 2, '.', ','); ?></td>
				</tr>
				<tr>
					<td colspan="2" style="width: 513px; border: none; font-family: courier;"><?php echo $datosFolio[0]["Descripcion"]; ?><br><br>
					VALIDADO POR:  <?php echo $datosFolio[0]["Nom"]; ?> <?php echo $datosFolio[0]["Pat"]; ?> <?php echo $datosFolio[0]["Mat"]; ?> 
					<?php if(isset($lstFolio[0]['_idtemporal'])){
					    echo '/ <b>Referencia: </b>'.$temporal[0]['referencia'];
					    echo ' <b>Autorización: </b>'.$temporal[0]['autorizacion'];
					} ?>
					</td>
				</tr>
			</table>
		</div>
		<p style="text-align: center; margin-top: -220px;">
		<img src="../../assets/images/campus/logo_opacidad.png" style="opacity: 0.5; width: 300px; position: relative;" >
		</p>

	<!-- Fin del cuerpo de la hoja -->


</page>
<?php } else {
	echo "<script type='text/javascript'>window.close();</script>";
} ?>
