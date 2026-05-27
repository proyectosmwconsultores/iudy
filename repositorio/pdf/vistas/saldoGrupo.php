<?php
session_start();
if($_SESSION['Permisos']){
	require_once'../classprint.php';
	$t=new Imprimir();
	$IdGrupo = substr($_GET["tokenId"], 10,10);
	$IdEstatus = substr($_GET["IdEs"], 10,10);
	$lstPag=$t->get_pagosPenGrupo($IdGrupo,$IdEstatus);
	$lstGrp=$t->get_datGrupoId($IdGrupo);

	if($IdEstatus == 8){ $txtE = "ACTIVO"; } elseif($IdEstatus == 20){ $txtE = "BAJA POR DESERCIÓN"; } elseif($IdEstatus == 50){ $txtE = "BLOQUEADO TEMPORALMENTE"; }


	if(!$IdGrupo){
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
    border: 1px solid #dddddd;
    padding: 5px;
}
tr:nth-child(even) {
    background-color: #dddddd;

}

-->
</style>

<!-- page define la hoja con los márgenes señalados -->
<page backtop="30.5mm" backbottom="15mm" backleft="10mm" backright="10mm">
	<page_header> <!-- Define el header de la hoja -->
		<div style="margin-left: 37px; margin-top: 20px; ">

			<table>
				<tr>
					<td style="width: 1000px; border: none; font-size: 15px; text-align: center;"><b>CAMPUS <?php echo $lstGrp[0]["Campus"]; ?></b></td>
				</tr>
				<tr>
					<td style="width: 1000px; border: none; font-size: 13px; text-align: center;">REPORTE DETALLADO DE ADEUDOS CON CORTE AL DIA <?php echo date("Y-m-d"); ?></td>
				</tr>
				<tr>
					<td style="width: 1000px; border: none; font-size: 13px; text-align: center;"><b>OFERTA EDUCATIVA:</b> <?php echo $lstGrp[0]["Nombre"]; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>GRUPO:</b> <?php echo $lstGrp[0]["CveGrupo"]; ?></td>
				</tr>
		</table>
		<table>
		<tr style="background: gray;">
			<td style="width: 10px; font-size: 10px; text-align: center;">No.</td>
			<td style="width: 156px; font-size: 10px;border-right: none;">Ciclo / Plan de pago</td>
			<td style="width: 50px; font-size: 10px; border-right: none;"></td>
			<td style="width: 115px; font-size: 10px;"></td>
			<td style="width: 85px; font-size: 10px;">Fec. Vencimiento</td>
			<td style="width: 75px; text-align: center; font-size: 10px;">Adeudo</td>
			<td style="width: 75px; text-align: center; font-size: 10px;">Beca</td>
			<td style="width: 75px; text-align: center; font-size: 10px;">Recargo</td>
			<td style="width: 75px; text-align: center; font-size: 10px;">Abono</td>
			<td style="width: 75px; text-align: center; font-size: 10px;">Adeudo total</td>
		</tr>
		</table>
	</div>
	</page_header>

	<page_footer> <!-- Define el footer de la hoja -->
	<table style=" margin-left: 38px;">
		<tr>
			<td style="width: 500px; border: none; font-size: 10px; text-align: left;"><b>Fecha de impresión: <?php echo date("Y-m-d H:m:s"); ?></b></td>
			<td style="width: 480px; border: none; font-size: 10px; text-align: right;"><b>Hoja [[page_cu]] de [[page_nb]]</b></td>
		</tr>
	</table><br><br><br>
	</page_footer>

	<?php $x= 0; for ($i=0;$i< 1;$i++) { ?>  <!-- Define el cuerpo de la hoja -->
	<table>
	<tr style="display: none;">
		<td style="width: 10px; font-size: 10px; text-align: center;"></td>
		<td style="width: 156px; font-size: 10px;border-right: none;"></td>
		<td style="width: 50px; font-size: 10px; border-right: none;"></td>
		<td style="width: 115px; font-size: 10px;"></td>
		<td style="width: 85px; font-size: 10px;"></td>
		<td style="width: 75px; text-align: center; font-size: 10px;"></td>
		<td style="width: 75px; text-align: center; font-size: 10px;"></td>
		<td style="width: 75px; text-align: center; font-size: 10px;"></td>
		<td style="width: 75px; text-align: center; font-size: 10px;"></td>
		<td style="width: 75px; text-align: center; font-size: 10px;"></td>
	</tr>


			<?php $idX = 0; $idY = 0; $Ini = 0; $adeudoInd = 0; $descInd = 0; $recarInd = 0; $abonoInd = 0; $totalInd = 0;
			for($i = 0; $i < sizeof($lstPag); $i++){
				$idX= $lstPag[$i]["IdUsua"];
				$xZ=$t->get_recargo($lstPag[$i]["IdUsua"],$lstPag[$i]["IdPago"]);
				$sumX = ($lstPag[$i]["Monto"] - $lstPag[$i]["Descuento"] + $xZ[0]["Recargo"] - $lstPag[$i]["TotalPagado"]);




				?>


			<?php if($idX <> $idY) { $c = 0; if($i <> 0){
				$ums = $adeudoInd-$descInd; $des = ($des + $ums);
				$recSum = ($recSum + $xZ[0]["Recargo"]);
				$abonSum = ($abonSum + $abonoInd);
				?>
				<tr style="background: #d0bdbd;">
					<td colspan="5" style="width: 400px; font-size: 10px; text-align: right; ">TOTAL POR ALUMNO:</td>
					<td style="width: 75px; text-align: right; font-size: 10px;">$ <?php echo number_format($adeudoInd-$descInd, 2, '.', ',');  ?></td>
					<td style="width: 75px; text-align: right; font-size: 10px;">  </td>
					<td style="width: 75px; text-align: right; font-size: 10px;">$ <?php echo number_format($recarInd, 2, '.', ',');  ?></td>
					<td style="width: 75px; text-align: right; font-size: 10px;">$ <?php echo number_format($abonoInd, 2, '.', ',');  ?></td>
					<td style="width: 75px; text-align: right; font-size: 10px;">$ <?php echo number_format($totalInd, 2, '.', ',');  ?></td>
				</tr>
				<?php $adeudoInd = 0; $descInd = 0; $recarInd = 0; $abonoInd = 0; $totalInd = 0; $sumTotaX=0; } ?>

				<tr style="background: #5a7979;">
					<td colspan="2" style="width: 116px; font-size: 10px; text-align: left;"><b>MATRICULA:</b> <?php echo $lstPag[$i]["Usuario"]; ?></td>
					<td colspan="5" style="width: 435px; font-size: 10px;"><b>NOMBRE DEL ALUMNO:</b> <?php echo $lstPag[$i]["APaterno"].' '.$lstPag[$i]["AMaterno"].' '.$lstPag[$i]["Nombre"]; ?></td>
					<td style="width: 75px; text-align: right; font-size: 10px;"><b>ESTATUS:</b></td>
					<td colspan="2" style="width: 150px; text-align: left; font-size: 10px;"><?php echo $txtE; ?></td>
				</tr>

				<?php }
				$adeudoInd = $lstPag[$i]["Monto"] + $adeudoInd;
				$descInd = $lstPag[$i]["Descuento"] + $descInd;
				$recarInd = $xZ[0]["Recargo"] + $recarInd;
				$abonoInd = $lstPag[$i]["TotalPagado"] + $abonoInd;


				$totalInd = ($sumX + $totalInd);

				 ?>
				<tr>
					<td style="width: 10px; font-size: 10px; text-align: center;"><?php echo $c = $c + 1; ?></td>
					<td colspan="3" style="width: 315px; font-size: 10px;"><?php echo $lstPag[$i]["Ciclo"]; ?><br><?php echo $lstPag[$i]["NomPlan"]; ?></td>
					<td style="width: 85px; font-size: 10px;"><?php echo $lstPag[$i]["FecDesc"]; ?></td>
					<td style="width: 75px; text-align: right; font-size: 10px;">$ <?php echo number_format($lstPag[$i]["Monto"]-$lstPag[$i]["Descuento"], 2, '.', ',');  ?></td>
					<td style="width: 75px; text-align: right; font-size: 10px;">  </td>
					<td style="width: 75px; text-align: right; font-size: 10px;">$ <?php echo number_format($xZ[0]["Recargo"], 2, '.', ',');  ?></td>
					<td style="width: 75px; text-align: right; font-size: 10px;">$ <?php echo number_format($lstPag[$i]["TotalPagado"], 2, '.', ',');  ?></td>
					<td style="width: 75px; text-align: right; font-size: 10px;">$ <?php echo number_format($sumX, 2, '.', ',');  ?></td>
				</tr>

			<?php $idY= $lstPag[$i]["IdUsua"];  }
			$ums = $adeudoInd-$descInd; $des = ($des + $ums);
			$recSum = ($recSum + $xZ[0]["Recargo"]);
			$abonSum = ($abonSum + $abonoInd);
			  ?>
			<tr style="background: #d0bdbd;">
				<td colspan="5" style="width: 400px; font-size: 10px; text-align: right; ">TOTAL POR ALUMNO:</td>
				<td style="width: 75px; text-align: right; font-size: 10px;">$ <?php echo number_format($adeudoInd-$descInd, 2, '.', ',');  ?></td>
				<td style="width: 75px; text-align: right; font-size: 10px;"> </td>
				<td style="width: 75px; text-align: right; font-size: 10px;">$ <?php echo number_format($recarInd, 2, '.', ',');  ?></td>
				<td style="width: 75px; text-align: right; font-size: 10px;">$ <?php echo number_format($abonoInd, 2, '.', ',');  ?></td>
				<td style="width: 75px; text-align: right; font-size: 10px;">$ <?php echo number_format($totalInd, 2, '.', ',');  ?></td>
			</tr>
			<tr style="background: #4a3636; color: white;">
				<td colspan="5" style="width: 400px; font-size: 10px; text-align: right; "><b>TOTAL:</b></td>
				<td style="width: 75px; text-align: right; font-size: 10px;">$ <?php echo number_format($des, 2, '.', ',');  ?></td>
				<td style="width: 75px; text-align: right; font-size: 10px;"> </td>
				<td style="width: 75px; text-align: right; font-size: 10px;">$ <?php echo number_format($recSum, 2, '.', ',');  ?></td>
				<td style="width: 75px; text-align: right; font-size: 10px;">$ <?php echo number_format($abonSum, 2, '.', ',');  ?></td>
				<td style="width: 75px; text-align: right; font-size: 10px;">$ <?php echo number_format($des-$abonSum, 2, '.', ',');  ?></td>
			</tr>



	</table>


	<!-- Fin del cuerpo de la hoja -->
	<?php } ?>

</page>
<?php } else {
	echo "<script type='text/javascript'>window.close();</script>";
} ?>
