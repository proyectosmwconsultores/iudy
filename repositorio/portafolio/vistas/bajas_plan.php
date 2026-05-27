<?php
if($_SESSION['Permisos']){
	include('numeros.php');
	require_once'../portafolio.php';
	$t=new Imprimir();
	$lstGrp=$t->get_bajas_plan($_GET['idCampus'],$_GET['idCiclo']);
	$cic=$t->get_datos_cic($_GET['idCiclo']);
	$campus=$t->get_campus_id($_GET['idCampus']);
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
<page backtop="41mm" backbottom="20mm" backleft="10mm" backright="10mm">
	<page_header> <!-- Define el header de la hoja -->
	<img src="../../assets/images/campus/hoja_arriba.png" style="width: 100%;" >
	<p style='text-align: center; font-size: 12px;'><b>REPORTE DE BAJAS DE ALUMNOS POR PLAN DE ESTUDIOS</b></p>

	<table style='margin-left: 38px; margin-top: 0px;'>
		<tr>
			<td style="width: 150px; text-align: right;"><b>PERIODO ESCOLAR:</b></td>
			<td style="width: 503px; "><?php echo $cic[0]['Ciclo']; ?></td>
		</tr>
	</table>

	</page_header>

	<page_footer> <!-- Define el footer de la hoja -->
	<img src="../../assets/images/campus/hoja_abajo.png" style="width: 100%;" >

	</page_footer>

	<?php $x= 0; for ($i=0;$i< 1;$i++) { ?>  <!-- Define el cuerpo de la hoja -->
	<table>
			<tr>
				<td style="width: 15px;"><b>NO.</b></td>
				<td style="width: 500px;"><b>NOMBRE DEL PLAN DE ESTUDIOS</b></td>
				<td style="width: 120px; text-align: center;"><b>TOTAL BAJAS</b></td>
			</tr>
			<?php $_sb = 0; for ($y=0;$y< sizeof($lstGrp);$y++) { $x = $x + 1;  ?>
			<tr>
				<td style="width: 15px;"><b><?php echo $x; ?>.- </b></td>
				<td style="width: 500px;"><?php echo $lstGrp[$y]['NomEducativa']; ?></td>
				<td style="width: 120px; text-align: center;"><?php echo $lstGrp[$y]['Total']; ?></td>
			</tr>
			<?php $_sb = ($_sb + $lstGrp[$y]['Total']); } ?>
			<tr>
				<td colspan='2' style="width: 500px; text-align: right;"><b>TOTAL BAJAS:</b></td>
				<td style="width: 120px; text-align: center;"><b><?php echo $_sb; ?></b></td>
			</tr>

	</table>

	<!-- Fin del cuerpo de la hoja -->
	<?php } ?>

</page>
<?php } else {
	echo "<script type='text/javascript'>window.close();</script>";
} ?>
