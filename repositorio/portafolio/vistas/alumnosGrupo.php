<?php
if($_SESSION['Permisos']){
	include('numeros.php');
	require_once'../portafolio.php';
	$t=new Imprimir();
	$IdGrupo = substr($_GET["tokenId"],10,10);
	$lstGrp=$t->get_lstGrupoId($IdGrupo);
	$encabz=$t->get_encabezado2($IdGrupo);
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
<page backtop="40mm" backbottom="20mm" backleft="10mm" backright="10mm">
	<page_header> <!-- Define el header de la hoja -->
	<img src="encabezado.jpg" style="width: 100%;">

	<div style="margin-left: 1px; margin-top: -75px; ">
			<table>
				<tr>
					<td style="border: none; width: 590px; text-align: center; font-size: 15px;"><b><?php echo $encabz[0]['Campus']; ?></b></td>
					<td rowspan='3' style="border: none; width: 140px; text-align: center;"><img src="../../assets/images/campus/logo_inicio.png" style=" height: 70px;" ></td>
				</tr>
				<tr>
					<td style="border: none; width: 590px; text-align: center;"><b>COORDINACIÓN DE SERVICIOS ESCOLARES</b></td>
				</tr>
				<tr>
					<td style="border: none; width: 590px; text-align: center;"><b>LISTA DE ALUMNOS</b></td>
				</tr>
		</table>
		<br>
		<div style='margin-left: 37px; position: absolute; margin-top: 105px;'>
		<table>
				<tr>
					<td style="width: 60px; border-right: none; border-bottom: none; "><b>GRUPO:</b></td>
					<td style="width: 250px; border-right: none; border-bottom: none; "><?php echo $encabz[0]['CveGrupo']; ?></td>
					<td style="width: 60px; border-right: none; border-bottom: none; "><b>MODALIDAD:</b></td>
					<td style="width: 250px; border-bottom: none; "><?php echo $encabz[0]['Modalidad']; ?></td>
				</tr>
				<tr>
					<td style="width: 60px; border-right: none;"><b>OFERTA:</b></td>
					<td style="width: 250px; border-right: none;"><?php echo $encabz[0]['Nombre']; ?></td>
					<td colspan='2' style="width: 300px; "><b><?php echo $encabz[0]['Ubicacion']; ?>; <?php echo obtFecha(date("Y-m-d")); ?></b></td>
				</tr>
		</table>
		</div>
	</div>

	</page_header>

	<page_footer> <!-- Define el footer de la hoja -->
	<table>
		<tr>
			<td style="width: 365px; text-align: center; border: none; ">______________________________</td>
			<td style="width: 365px; text-align: center; border: none; ">______________________________</td>
		</tr>
		<tr>
			<td style="width: 320px; text-align: center; border: none;">Nombre y Firma del Docente</td>
			<td style="width: 320px; text-align: center; border: none;">Coordinación de Servicios Escolares</td>
		</tr>
	</table><br><br>
	</page_footer>

	<?php $x= 0; for ($i=0;$i< 1;$i++) { ?>  <!-- Define el cuerpo de la hoja -->
	<table>
			<tr>
				<td style="width: 15px;"><b>NO.</b></td>
				<td style="width: 70px;"><b>CONTROL</b></td>
				<td style="width: 400px"><b>NOMBRE</b></td>
				<td style="width: 130px;"><b>ESTATUS</b></td>
			</tr>
			<?php   for ($y=0;$y< sizeof($lstGrp);$y++) { $x = $x + 1; ?>
				<tr>
					<td style="width: 15px;"><?php echo $x; ?>.</td>
					<td style="width: 70px;"><?php echo $lstGrp[$y]['Usuario']; ?></td>
					<td style="width: 400px"><?php echo $lstGrp[$y]['APaterno'].' '.$lstGrp[$y]['AMaterno'].' '.$lstGrp[$y]['Nombre']; ?></td>
					<td style="width: 130px;"><?php echo $lstGrp[$y]['Estatus']; ?></td>
				</tr><?php } ?>

	</table>

	<!-- Fin del cuerpo de la hoja -->
	<?php } ?>

</page>
<?php } else {
	echo "<script type='text/javascript'>window.close();</script>";
} ?>
