<?php
// session_start();
if($_SESSION['Permisos']){
	require_once'../classprint.php';
	include("numeros.php");
	include("importe.php");
	include("hace.php");
	$t=new Imprimir();
	//$IdFolio = substr($_GET["tokenId"], 10, 10);
	$_Folio = substr($_GET["idToks"], 10, 20);
	$datosFolio=$t->get_datoFolio($_Folio);
	$datosGrupo=$t->get_datoGrp($datosFolio[0]["IdGrupo"]);
	$datosPago=$t->get_datoPag($datosFolio[0]["IdPago"]);
	$campus=$t->get_datoCam($datosFolio[0]["IdCampus"]);
	$uni=$t->get_plataforma();

	$lstFolio=$t->get_lstdatoFolio($_Folio);

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
    /*border: 1px solid #dddddd;-*/
    padding: 8px;
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

	<?php $x= 0; for ($i=0;$i< 1;$i++) { ?>  <!-- Define el cuerpo de la hoja -->
		<br><br>
	<table style=" padding: 4px; border: none !important;">
		<tr style="padding: 4px;">
			<td style="width: 190px; font-size: 11px; ">
			<img src="../../assets/images/campus/logo_inicio.png" style="width: 100%" >
			</td>
			<td style="width: 430px; font-size: 11px; text-align: center;">
				<p>
				<b style="font-size: 20px;"><?php echo $uni[0]['Descripcion']; ?></b><br>
					<b>NOMBRE DE LA UNIVERSIDAD, S.C.</b><br>
					<b>RFC: XXX000000XX0</b>
				</p>
			</td>
		</tr>
	</table>
<br><br>
	<table style=" padding: 4px;">
		<tr style=" padding: 4px;">
			<td style="width: 310px; font-size: 12px; ">
			<p><?php if($datosFolio[0]["IdCampus"] != 1){ ?>
				<b>Domicilio plantel</b><br>
				<?php if($campus[0]["Ubicacion"]){ echo '<b>'.$campus[0]["Ubicacion"].'</b><br>'; } ?>
				<?php if($campus[0]["Colonia"]){ echo '<b>'.$campus[0]["Colonia"].'</b><br>'; } ?>
				<?php if($campus[0]["Tel"]){ echo '<b>'.$campus[0]["Tel"].'</b><br>'; } ?>
				<?php if($campus[0]["Lugar"]){ echo '<b>'.$campus[0]["Lugar"].'</b><br>'; } ?>
				<?php } ?>
			</p>
			</td>
			<td style="width: 310px; font-size: 11px; text-align: right;">
			<p>
				<b>Domicilio fiscal</b><br>
				<b>Tuxtla Gutiérrez</b><br>
				<b>Colonia Los Laguitos</b><br>
				<b>C.P. 29020 tel. 961 175 85 84</b><br>
				<b>Tuxtla Gutiérrez, Chiapas</b><br>
			</p>
			</td>
		</tr>
	</table>
<br><hr><br>
	<table style=" padding: 4px;">
	<tr style="padding: 4px;">
		<td style="width: 50px; font-size: 11px; "><b>NOMBRE:</b></td>
		<td style="width: 330px; font-size: 11px; "><b><?php echo $datosFolio[0]["Nombre"].' '.$datosFolio[0]["APaterno"].' '.$datosFolio[0]["AMaterno"]; ?></b></td>
		<td style="width: 60px; font-size: 11px;  text-align: right;"><b>FOLIO:</b></td>
		<td style="width: 90px; font-size: 11px; color: red; text-align: right; "><b><?php echo $_Folio; ?></b></td>

	</tr>
		<tr style="padding: 4px;">
			<td style="width: 50px; font-size: 11px; text-align: left;"><b>MATRÍCULA</b></td>
			<td style="width: 200px; font-size: 11px; text-align: center;"><b>NIVEL</b></td>
			<td style="width: 80px; font-size: 11px; text-align: right;"><b>GRUPO:</b></td>
			<td style="width: 30px; font-size: 11px; text-align: right;"><?php echo $datosGrupo[0]["CveGrupo"]; ?></td>
		</tr>
		<tr style="padding: 4px;">
			<td style="width: 50px; font-size: 11px; text-align: left;"><?php echo $datosFolio[0]["Usuario"]; ?></td>
			<td style="width: 200px; font-size: 11px; text-align: center;"><?php echo $datosGrupo[0]["Nombre"]; ?></td>
			<td style="width: 80px; font-size: 11px; text-align: right;"><b>FECHA:</b></td>
			<td style="width: 30px; font-size: 11px; text-align: right;"><?php echo $datosFolio[0]["FecPago"]; ?></td>
		</tr>
	</table>
	<br><br>
	<hr>
	<table style=" padding: 4px; ">
		<tr style="padding: 4px;">
			<td style="width: 50px; font-size: 11px; text-align: center;"><b>Cantidad</b></td>
			<td style="width: 445px; font-size: 11px; text-align: center;"><b>Descripción</b></td>
			<td style="width: 90px; font-size: 11px; text-align: right;"><b>Monto</b></td>
		</tr>
		<?php $_sum = 0; for ($i=0;$i< sizeof($lstFolio);$i++) { ?>
		<tr style="padding: 4px;">
			<td style="width: 50px; font-size: 11px; text-align: center;">1</td>
			<td style="width: 445px; font-size: 11px; text-align: left;">
				<?php echo $lstFolio[$i]["NomPlan"]; ?> <br>
				<?php echo obtenerFechaImpresion($datosPago[0]["FecDesc"]); ?>
				<?php if($lstFolio[$i]["Estatus"] == 37){ echo "<b>(Abono)</b>"; } ?>
			</td>
			<td style="width: 90px; font-size: 11px; text-align: right;">$ <?php echo number_format($lstFolio[$i]["Monto"], 2, '.', ','); ?></td>
		</tr><?php $_sum = ($_sum + $lstFolio[$i]["Monto"]);  }
		$vaImpor = $_sum.'.00'; ?>
	</table><br>
	<hr><br>
	<table style=" padding: 4px; ">
		<tr style="padding: 4px;">
			<td style="width: 350px; font-size: 11px;"><b>Importe con letra:</b></td>
			<td style="width: 145px; font-size: 11px; text-align: right;"><b>Total pagado:</b></td>
			<td style="width: 90px; font-size: 11px; text-align: right;"><b>$ <?php echo number_format($_sum, 2, '.', ','); ?></b></td>
		</tr>
		<tr style="padding: 4px;">
			<td colspan='3' style="width: 550px; font-size: 11px;"><?php echo num2letras($vaImpor, false, false); ?> 00/100 M.N.</td>
		</tr>
		<tr style="padding: 4px;">
			<td colspan='3' style="width: 550px; font-size: 11px;"><b>Forma de pago:</b> <?php echo $datosFolio[0]["Descripcion"]; ?> </td>
		</tr>
	</table>




	<!-- Fin del cuerpo de la hoja -->
	<?php } ?>



</page>
<?php } else {
	echo "<script type='text/javascript'>window.close();</script>";
} ?>
