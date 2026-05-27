<?php
// session_start();
if($_SESSION['Permisos']){
	require_once'../classprint.php';
	include("../hace_fecha.php");
	include('importe.php');
	$t=new Imprimir();
	$IdGasto = substr($_GET["idToks"], 10, 10);
	$_gasto=$t->get_gasto_id($IdGasto);

	if((!$_SESSION['Permisos'] == 1) || (!$_SESSION['Permisos'] == 5) || (!$_SESSION['Permisos'] == 6)){
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
    border: 1px solid #003A70;-*/
    padding: 8px;
}
tr:nth-child(even) {
    background-color: #dddddd;
}

-->
</style>

<!-- page define la hoja con los márgenes señalados -->
<page backtop="60mm" backbottom="20mm" backleft="10mm" backright="10mm">
	<page_header> <!-- Define el header de la hoja -->
	<img src="../../assets/images/campus/fondo_gasto.jpg" style="width: 100%" >
	</page_header>

	<page_footer> <!-- Define el footer de la hoja -->

	</page_footer>


	<?php $x= 0; for ($i=0;$i< 1;$i++) { ?>  <!-- Define el cuerpo de la hoja -->

	<table style="font-size: 12px;">
		<tr>
			<td style='border: none; width: 680px; text-align: center; font-size: 14px; height: 50px;'><b>RECIBO DE DINERO</b> </td>
		</tr>
		<tr>
			<td style='border: none; width: 680px; text-align: right; height: 80px;'>  TUXTLA GUTIERREZ, CHIAPAS; A <?php echo obtFechMay($_gasto[0]['Fecha']); ?>. </td>
		</tr>
		<tr>
			<td style='border: none; width: 680px; text-align: right; height: 80px;'><b>BUENO POR:</b> $ <?php echo number_format($_gasto[0]['Importe'], 2, '.', ','); ?></td>
		</tr>
		<tr>
			<td style='border: none; width: 680px; text-align: justify; height: 100px;'><b>RECIBI:</b> DE LA ESCUELA NACIONAL DE PROTECCION CIVIL CAMPUS CHIAPAS, LA CANTIDAD DE $ <?php echo number_format($_gasto[0]['Importe'], 2, '.', ','); ?>  (<?php echo num2letras($_gasto[0]['Importe'],false,false); ?>) POR CONCEPTO DE <?php echo $_gasto[0]['Nombre_gasto']; ?> PARA EL DEPARTAMENTO DE <?php echo $_gasto[0]['_Permiso']; ?>.
				<?php if($_gasto[0]['Nota']){ echo "<br><br><b>NOTA:</b> ".$_gasto[0]['Nota']; } ?>
			</td>
		</tr>
		<tr>
			<td style='border: none; width: 680px; text-align: right; height: 120px;'></td>
		</tr>
		<tr>
			<td style='border: none; width: 680px; text-align: left; height: 40px;'><b>RECIBI:</b></td>
		</tr>
		<tr>
			<td style='border-left: none; border-right: none; width: 680px; text-align: center; height: 20px;'> </td>
		</tr>
		<tr>
			<td style='border-left: none; border-right: none; border-bottom: none; width: 680px; text-align: center; height: 20px;'><b>NOMBRE Y FIRMA:</b></td>
		</tr>



	</table>

	<!-- Fin del cuerpo de la hoja -->
	<?php } ?>



</page>
<?php } else {
	echo "<script type='text/javascript'>window.close();</script>";
} ?>
