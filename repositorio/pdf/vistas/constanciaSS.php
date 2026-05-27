<?php
session_start();
if($_SESSION['Permisos']){
	require_once'../classprint.php';
	include("numeros.php");
	$t=new Imprimir();
	$Id = substr($_GET["tokenId"], 45, 4);
	$alumno=$t->get_imprimir($Id);
	$servicio=$t->get_servicio($Id);
	$registroX = $servicio[0]["FecImpresion"];

?>
<!-- IMPORTANTE: El contenido de la etiqueta style debe estar entre comentarios de HTML -->
<style>

table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

td, th {
    border: none;

}
#encabezado td, th {
    border: 1px solid #dddddd;
    padding: 1px;
}
tr:nth-child(even) {
    background-color: #dddddd;
}
#texto1 { width: 100px;}
-->
</style>

<!-- page define la hoja con los márgenes señalados -->
<page backtop="71mm" backbottom="20mm" backleft="10mm" backright="10mm">
	<page_header> <!-- Define el header de la hoja -->

	</page_header>

	<page_footer> <!-- Define el footer de la hoja -->
	<b></b>

	</page_footer>

	<?php $x= 0; for ($i=0;$i< 1;$i++) { ?>  <!-- Define el cuerpo de la hoja -->
	<table style="margin-left:-50px; border: none;">
		<tr>
			<td rowspan=9 style="width: 55px; font-size: 10px; padding: 8px;"></td>
			<td style="width: 545px; font-size: 12px; text-align: center; padding: 22px;"><b><?php echo $alumno[0]["Nombre"].' '.$alumno[0]["APaterno"].' '.$alumno[0]["AMaterno"]; ?></b></td>
		</tr>
		<tr>
			<td style="width: 545px; font-size: 12px; text-align: center; padding: 21px;"><b><?php echo $alumno[0]["NomOferta"]; ?></b></td>
		</tr>
		<tr>
			<td style="width: 545px; font-size: 12px; text-align: center; padding: 21px;"><b>UNIVERSIDAD DEL SURESTE</b></td>
		</tr>
		<tr>
			<td style="width: 545px; font-size: 12px; text-align: center; padding: 21px;"><b><?php echo $servicio[0]["Registro"]; ?></b></td>
		</tr>
		<tr>
			<td style="width: 545px; font-size: 12px; text-align: center; padding: 42px;"><b><?php echo $servicio[0]["NomPrograma"]; ?></b></td>
		</tr>
		<tr>
			<td style="width: 545px; font-size: 12px; text-align: center; padding: 16px;"><b><?php echo $servicio[0]["NomDependencia"]; ?></b></td>
		</tr>
		<tr>
			<td style="width: 545px; font-size: 12px; text-align: center; padding: 35px;"><b><?php echo $servicio[0]["Periodo"]; ?></b></td>
		</tr>
		<tr>
			<td style="width: 545px; font-size: 12px; text-align: center; padding: 18px;"><b>480 HORAS</b></td>
		</tr>
		<tr>
			<td style="width: 545px; font-size: 12px; text-align: center; padding: 51px;"><b>TUXTLA GUTIÉRREZ, CHIAPAS<BR><BR><?php echo obtenerF($servicio[0]["FecImpresion"]); ?></b></td>
		</tr>


	</table>
	<!-- Fin del cuerpo de la hoja -->
	<?php } ?>



</page>
<?php } else {
	echo "<script type='text/javascript'>window.close();</script>";
} ?>
