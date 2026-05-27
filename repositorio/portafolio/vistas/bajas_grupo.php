<?php
if($_SESSION['Permisos']){
	include('numeros.php');
	require_once'../portafolio.php';
	$t=new Imprimir();
	$lstGrp=$t->get_bajas_grp($_GET['idCampus'],$_GET['idCiclo']);
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
	<p style='text-align: center; font-size: 12px;'><b>REPORTE DE BAJAS DE ALUMNOS DEL PERIODO ESCOLAR POR GRUPO</b></p>

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
			<?php $i = 0; $f = 0; for ($y=0;$y< sizeof($lstGrp);$y++) { $x = $x + 1; $i = $lstGrp[$y]['IdGrupo'];
			if($i <> $f){ ?>
				<tr>
					<td colspan='2'><b>GRUPO:</b> <?php echo $lstGrp[$y]['CveGrupo']; ?></td>
					<td colspan='3'><b><?php echo $lstGrp[$y]['NomEducativa']; ?></b></td>
				</tr>
			<?php } ?>
			<tr>
				<td style="width: 15px;"><b><?php echo $x; ?>.- </b></td>
				<td style="width: 70px;"><?php echo $lstGrp[$y]['Usuario']; ?></td>
				<td style="width: 302px"><?php echo $lstGrp[$y]['APaterno'].' '.$lstGrp[$y]['AMaterno'].' '.$lstGrp[$y]['Nombre']; ?></td>
				<td style="width: 80px"><?php echo $lstGrp[$y]['fecha_baja']; ?></td>
				<td style="width: 130px"><?php echo $lstGrp[$y]['Estatus']; ?></td>
			</tr>
			<?php $f = $lstGrp[$y]['IdGrupo']; } ?>

	</table>

	<!-- Fin del cuerpo de la hoja -->
	<?php } ?>

</page>
<?php } else {
	echo "<script type='text/javascript'>window.close();</script>";
} ?>
