<?php
// session_start();
if($_SESSION['Permisos']){
	require_once'../classprint.php';

	$t=new Imprimir();
	$IdUsua = substr($_GET["tokenId"], 20,10);
	$datos=$t->get_datosUsuario($IdUsua);
	$lstDesc=$t->get_lstCarDesc($IdUsua);
	include("../hace_fecha.php");
	$hoy = date("Y-m-d");

	$datGrupo=$t->get_datGrupo($datos[0]["IdGrupo"]);
	$lstGrp=$t->get_lstPagPe($IdUsua);

	if(!$IdUsua){
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
		font-size: 9px;
}

td, th {
    border: 0.5px solid black;
    padding: 5px;
}

-->
</style>

<!-- page define la hoja con los márgenes señalados -->
<page backtop="43mm" backbottom="10mm" backleft="10mm" backright="10mm">
	<page_header> <!-- Define el header de la hoja -->
		<div style="margin-left: 37px; margin-top: 80px; ">
		    <table >
				<tr>
					<td style="width: 150px; font-size: 12px;"><b>ALUMNO:</b></td>
					<td style="width: 460px; font-size: 12px;"><?php echo $datos[0]["APaterno"].' '.$datos[0]["AMaterno"].' '.$datos[0]["Nombre"]; ?></td>
					<td style="width: 100px; text-align: right;font-size: 12px;"><b>MATRÍCULA:</b></td>
					<td style="width: 200px; font-size: 12px;"><?php echo $datos[0]["Usuario"]; ?></td>
				</tr>
				<tr>
					<td style="width: 150px; font-size: 12px;"><b>PLAN DE ESTUDIOS:</b></td>
					<td style="width: 460px; font-size: 12px;"><?php echo $datos[0]["NomEducativa"]; ?></td>
					<td style="width: 100px; text-align: right;font-size: 12px;"><b>GRUPO:</b></td>
					<td style="width: 200px; font-size: 12px;"><?php echo $datGrupo[0]["CveGrupo"]; ?></td>
				</tr>
				<tr>
					<td colspan="4" style=" border-left: none; border-right: none; border-bottom: none; width: 460px; font-size: 12px; text-align: right;"><br><b>FECHA DE EMISIÓN: <?php echo obtFechMay($hoy); ?></b></td>
				</tr>
		</table>
	</div>
	</page_header>

	<page_footer> <!-- Define el footer de la hoja -->

	</page_footer>

	<?php $x= 0; for ($i=0;$i< 1;$i++) { ?>  <!-- Define el cuerpo de la hoja -->

	<table style="margin-left: -1px;">
			<tr style='background: #c1c5ff;'>
				<td style="width: 316px; font-size: 12px;">CONCEPTO</td>
				<td style="width: 80px; font-size: 12px;">FEC. LÍMITE</td>
				<td style="width: 108px; font-size: 12px;">ESTATUS</td>
				<td style="width: 60px; text-align: center; font-size: 12px;">ADEUDO</td>
				<td style="width: 60px; text-align: center; font-size: 12px;">DESCUENTO</td>
				<td style="width: 60px; text-align: center; font-size: 12px;">RECARGO</td>
				<td style="width: 60px; text-align: center; font-size: 12px;">ABONO</td>
				<td style="width: 80px; text-align: center; font-size: 12px;">TOTAL</td>
			</tr>
			<?php $c_i = 0; $c_f = 0; $_sx = 0;
			for ($i=0;$i< sizeof($lstGrp);$i++) {
				if($lstGrp[$i]["Fecha"] <= $hoy){
				$c_i = $lstGrp[$i]["IdCiclo"];
				//$xZ=$t->get_recargo($IdUsua,$lstGrp[$i]["IdPago"]);
				$recargo = $lstGrp[0]["Recargos"];
				$adeudo = ($lstGrp[$i]["Monto"]);
				$descuento = $lstGrp[$i]["Descuento"];
				$totalx = ($adeudo + $recargo - $descuento - $lstGrp[$i]["TotalPagado"]);
				if($c_i <> $c_f){ ?>
			<tr>
				<td style="width: 300px; font-size: 12px; color: blue; text-align: right;"><b>PERIODO ESCOLAR: </b></td>
				<td colspan='7' style="width: 300px; font-size: 12px; color: blue;"><?php echo $lstGrp[$i]["Ciclo"]; ?></td>
			</tr>
				<?php } ?>
			<tr>
				<td style="width: 316px; font-size: 12px; "><?php echo $lstGrp[$i]["NomPlan"]; ?> - <?php echo obtener_Mes($lstGrp[$i]["Fecha"]); ?></td>
				<td style="width: 80px; font-size: 12px; "><?php echo $lstGrp[$i]["Fecha"]; ?></td>
				<td style="width: 108px; font-size: 12px; "><?php echo $lstGrp[$i]["Estatus"]; ?></td>
				<td style="width: 60px; text-align: right; font-size: 12px; ">$ <?php echo number_format($adeudo, 2, '.', ','); ?></td>
				<td style="width: 60px; text-align: right; font-size: 12px; ">$ <?php echo number_format($descuento, 2, '.', ','); ?></td>
				<td style="width: 60px; text-align: right; font-size: 12px; ">$ <?php echo number_format($recargo, 2, '.', ','); ?></td>
				<td style="width: 60px; text-align: right; font-size: 12px; ">$ <?php echo number_format($lstGrp[$i]["TotalPagado"], 2, '.', ','); ?></td>
				<td style="width: 80px; text-align: right; font-size: 12px; ">$ <?php echo number_format($totalx, 2, '.', ','); ?></td>
			</tr>
			<?php $_sx = ($_sx + $totalx); $c_f = $lstGrp[$i]["IdCiclo"]; } } ?>
			<tr>
				<td colspan="7" style="text-align: right; font-size: 12px;"><b>TOTAL ADEUDO:</b></td>
				<td style="background: #ffe300; width: 80px; text-align: right; font-size: 12px;"><b>$ <?php echo number_format($_sx, 2, '.', ','); ?></b></td>
			</tr>
	</table>


	<!-- Fin del cuerpo de la hoja -->
	<?php } ?>

</page>
<?php } else {
	echo "<script type='text/javascript'>window.close();</script>";
} ?>
