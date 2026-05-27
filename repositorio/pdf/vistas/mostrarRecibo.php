<?php
session_start();
if($_SESSION['Permisos']){
	require_once'../classprint.php';
	include("numeros.php");
	include("importe.php");
	include("hace.php");
	$t=new Imprimir();
	$IdFolio = substr($_GET["tokenId"], 10, 10);
	$datosFolio=$t->get_datoFolio($IdFolio);
	$datosGrupo=$t->get_datoGrp($datosFolio[0]["IdGrupo"]);
	$datosPago=$t->get_datoPag($datosFolio[0]["IdPago"]);
	$campus=$t->get_datoCam($datosFolio[0]["IdCampus"]);

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
    /* border: 1px solid #dddddd; */
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
			<img src="../../assets/images/campus/logo_inicio.png" style="width: 140px;" >
			</td>
			<td style="width: 430px; font-size: 11px; text-align: center;">
				<p>
				<b style="font-size: 20px;">UNIVERSIDAD DEL SURESTE</b><br>
					<b>GRUPO EDUCATIVO ALBORES ALCAZAR, S.C.</b><br>
					<b>RFC: GEA020227CQ6</b>
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
				<b>Carretera Comitán - Tzimol Km. 57</b><br>
				<b>Colonia Guadalupe Chichima</b><br>
				<b>C.P. 30093 tel. 963 632 77 67</b><br>
				<b>Comitán de Domínguez, Chiapas</b><br>
			</p>
			</td>
		</tr>
	</table>
<br><hr><br>
	<table style=" padding: 4px;">
	<tr style="padding: 4px;">
		<td style="width: 50px; font-size: 11px; ">Nombre:</td>
		<td colspan="3" style="width: 250px; font-size: 11px; "><b><?php echo $datosFolio[0]["Nombre"].' '.$datosFolio[0]["APaterno"].' '.$datosFolio[0]["AMaterno"]; ?></b></td>
		<td colspan="2" style="width: 60px; font-size: 11px;  text-align: right;">Recibo No:</td>
		<td style="width: 50px; font-size: 11px; color: red; text-align: right; "><b><?php echo $datosFolio[0]["Folio"]; ?></b></td>

	</tr>
		<tr style="padding: 4px;">
			<td style="width: 50px; font-size: 11px; text-align: center;">Matrícula</td>
			<td style="width: 20px; font-size: 11px; text-align: center;">Turno</td>
			<td style="width: 200px; font-size: 11px; text-align: center;">Nivel</td>
			<td style="width: 20px; font-size: 11px; text-align: center;"></td>
			<td style="width: 80px; font-size: 11px; text-align: center;">Grupo</td>
			<td style="width: 30px; font-size: 11px; text-align: right;">Serie:</td>
			<td style="width: 30px; font-size: 11px; text-align: right;"><?php echo $campus[0]["Serie"]; ?></td>
		</tr>
		<tr style="padding: 4px;">
			<td style="width: 50px; font-size: 11px; text-align: center;"><?php echo $datosFolio[0]["Usuario"]; ?></td>
			<td style="width: 20px; font-size: 11px; text-align: center;"><?php echo $datosGrupo[0]["Turno"]; ?></td>
			<td style="width: 200px; font-size: 11px; text-align: center;"><?php echo $datosGrupo[0]["Nombre"]; ?></td>
			<td style="width: 20px; font-size: 11px; text-align: center;"></td>
			<td style="width: 80px; font-size: 11px; text-align: center;"><?php echo $datosGrupo[0]["CveGrupo"]; ?></td>
			<td style="width: 30px; font-size: 11px; text-align: right;">Fecha:</td>
			<td style="width: 30px; font-size: 11px; text-align: right;"><?php echo $datosFolio[0]["FecPago"]; ?></td>
		</tr>
	</table>
	<br><br>
	<table style=" padding: 4px;">

		<tr style="padding: 4px;">
			<td style="width: 40px; font-size: 11px; text-align: center;"><b>Cantidad</b></td>
			<td style="width: 40px; font-size: 11px; text-align: center;"><b>Unidad Med.</b></td>
			<td colspan="2" style="width: 245px; font-size: 11px; text-align: center;"><b>Descripción</b></td>
			<td style="width: 70px; font-size: 11px; text-align: right;"><b>Cantidad</b></td>
		</tr>
		<tr style="padding: 4px;">
			<td style="width: 40px; font-size: 11px; text-align: center;">1</td>
			<td style="width: 40px; font-size: 11px; text-align: center;">N/A</td>
			<td colspan="2" style="width: 185px; font-size: 11px; text-align: center;"><?php echo $datosFolio[0]["Estatus"]; ?> / <?php echo $datosPago[0]["NomPlan"]; ?> / <?php echo obtenerFechaImpresion($datosPago[0]["FecDesc"]); ?></td>
			<td style="width: 70px; font-size: 11px; text-align: right;">$ <?php echo $datosFolio[0]["Monto"]; ?></td>
		</tr>

		<tr style="padding: 4px;">
			<td colspan="5" style="width: 450px; font-size: 11px;"><br><hr><br></td>
		</tr>
		<tr style="padding: 4px;">
			<td colspan="2" style="width: 80px; font-size: 11px;"><b>Importe con letra:</b></td>
			<td colspan="2" style="width: 250px; font-size: 11px; text-align: right;">Pago con descuento:</td>
			<td style="width: 70px; font-size: 11px; text-align: right;">$ <?php echo $datosFolio[0]["Monto"]; ?></td>
		</tr>
		<tr style="padding: 4px;">
			<td colspan="3" style="width: 180px; font-size: 11px;"><?php echo num2letras($datosFolio[0]["Monto"], false, false); ?> 00/100 M.N.</td>
			<td style="width: 185px; font-size: 11px; text-align: right;">Pago sin descuento:</td>
			<td style="width: 70px; font-size: 11px; text-align: right;">$ 0.00</td>
		</tr>
		<tr style="padding: 4px;">
			<td colspan="2" style="width: 80px; font-size: 11px;"><b>Forma de pago:</b></td>
			<td colspan="2" style="width: 325px; font-size: 11px; text-align: right;">Pago con convenio:</td>
			<td style="width: 70px; font-size: 11px; text-align: right;">$ 0.00</td>
		</tr>
		<tr style="padding: 4px;">
			<td colspan="5" style="width: 510px; font-size: 11px;"><?php echo $datosFolio[0]["Descripcion"]; ?></td>
		</tr>
		<tr style="padding: 4px;">
			<td colspan="4" style="width: 325px; font-size: 11px; text-align: right;"><b>Total:</b></td>
			<td style="width: 70px; font-size: 11px; text-align: right;">$ <?php echo $datosFolio[0]["Monto"]; ?></td>
		</tr>

	</table>

	<!-- Fin del cuerpo de la hoja -->
	<?php } ?>



</page>
<?php } else {
	echo "<script type='text/javascript'>window.close();</script>";
} ?>
