<?php
if($_SESSION['Permisos']){
	include('numeros.php');
	require_once'../portafolio.php';
	$t=new Imprimir();
	$IdUsua = substr($_GET["tokenId"], 10,10);

	$us=$t->get_usuario_id($IdUsua);
	$seg=$t->get_seguimiento_us($IdUsua);
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
<page backtop="50mm" backbottom="20mm" backleft="10mm" backright="10mm">
	<page_header> <!-- Define el header de la hoja -->
	<img src="../../assets/images/campus/hoja_arriba.png" style="width: 100%;" >

	<p style='text-align: center; font-size: 12px;'><b>REPORTE DE SEGUIMIENTO</b></p>
	<table style='margin-left: 41px;'>
		<tr>
			<td style='width: 60px; text-align: right;'><b>NOMBRE:</b></td>
			<td style='width: 357px;'><?php echo $us[0]['APaterno'].' '.$us[0]['AMaterno'].' '.$us[0]['Nombre']; ?></td>
			<td style='width: 80px; text-align: right;'><b>NO.CONTROL:</b></td>
			<td style='width: 150px;'><?php echo $us[0]['Usuario']; ?></td>
		</tr>
		<tr>
			<td style='width: 60px; text-align: right;'><b>CARRERA:</b></td>
			<td style='width: 357px;'><?php echo $us[0]['Educativa']; ?></td>
			<td style='width: 80px; text-align: right;'><b>GRUPO:</b></td>
			<td style='width: 150px;'><?php echo $us[0]['CveGrupo']; ?></td>
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
				<td style="width: 50px;"><b>FECHA</b></td>
				<td style="width: 100px;"><b>PERIODO ESCOLAR</b></td>
				<td style="width: 120px;"><b>RESPONSABLE</b></td>
				<td style="width: 70px; text-align: center;"><b>TIPO SEGUIMIENTO</b></td>
				<td style="width: 144px; text-align: center;"><b>SEGUIMIENTO</b></td>
				<td style="width: 120px; text-align: center;"><b>RESPUESTA</b></td>
			</tr>
			<?php $x = 0; for($y=0;$y< sizeof($seg);$y++) { $x = $x + 1; ?>
			<tr>
				<td style="width: 15px;"><b><?php echo $x; ?></b>.- </td>
				<td style="width: 50px;"><?php echo $seg[$y]['FecCap']; ?></td>
				<td style="width: 100px;"><?php echo $seg[$y]['Ciclo']; ?></td>
				<td style="width: 120px;"><?php echo $seg[$y]['Nombre'].' '.$seg[$y]['APaterno'].' '.$seg[$y]['AMaterno']; ?></td>
				<td style="width: 70px; text-align: center;"><?php echo $seg[$y]['Seguimiento']; ?></td>
				<td style="width: 144px; text-align: justify;"><?php echo $seg[$y]['Comentario_control']; ?></td>
				<td style="width: 120px; text-align: justify;"><?php echo $seg[$y]['Comentario_usuario']; ?></td>
			</tr>
			<?php } ?>
	</table>

	<!-- Fin del cuerpo de la hoja -->
	<?php } ?>

</page>
<?php } else {
	echo "<script type='text/javascript'>window.close();</script>";
} ?>
