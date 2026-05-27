<?php
if($_SESSION['Permisos']){
	include('numeros.php');
	include('../hace_fecha.php');
	require_once'../portafolio.php';

	$t=new Imprimir();
	$par = 0;
	if(isset($_GET['tok'])){
		$par = $_GET['tok'];
		$ckAsis=$t->get_chk_falta($_GET["tokenId"],$par);
	} else { $par = 0; }

	$lstDat=$t->get_enca_list($_GET["tokenId"]);
	$lstUs=$t->get_lst_prom($_GET["tokenId"]);
	//$lstDias=$t->get_lst_dias($_GET["tokenId"]);

	$rvoe=$t->get_datos_campus_rvoe($lstUs[0]['IdUsua']);
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
    padding: 4px;
}
tr:nth-child(even) {
    background-color: #dddddd;
}

-->
</style>

<!-- page define la hoja con los márgenes señalados -->
<page backtop="50mm" backbottom="20mm" backleft="10mm" backright="10mm">
	<page_header> <!-- Define el header de la hoja -->
	<table style="margin-left: 42px; margin-top: 40px; font-size: 9px; text-align: center; font-weight: bold;">
			<tr>
				<td style="width: 668px; font-size: 16px; border: none;">
				    <?php echo $rvoe[0]['_titulo']; ?><br>
				    <b style="font-size: 12px;"><?php echo $rvoe[0]['Educativa']; ?><br>
				    ACTA DE CALIFICACIÓN PARCIAL</b>
				</td>
			</tr>
		</table>
		<img src="../../assets/images/campus/<?php echo $rvoe[0]['_logoPdf']; ?>" style="width: 180px; margin-top: -60px;" >
		<br><br><br><br><br><br>
	<table style='margin-left: 42px; font-size: 10px;'>
		<tr>
			<td colspan="4" style="width: 600px; text-align: center; font-size: 12px;"><b><?php echo $lstDat[0]['Educativa']; ?></b></td>
		</tr>
		<tr>
			<td style="width: 70px; text-align: right;"><b>MATERIA:</b></td>
			<td style="width: 345px;"><?php echo $lstDat[0]['NombreMod']; ?></td>
			<td colspan="2" style="width: 200px; text-align: left;"><b><?php echo $lstDat[0]['Ciclo']; ?></b></td>
		</tr>
		<tr>
			<td style="width: 70px; text-align: right;"><b>DOCENTE:</b></td>
			<td style="width: 345px;"><?php echo $lstDat[0]['Nombre'].' '.$lstDat[0]['APaterno'].' '.$lstDat[0]['AMaterno']; ?></td>
			<td style="width: 80px; text-align: left;"><b><?php if($lstDat[0]['TipoCiclo'] == 'T'){ echo "TRIMESTRE"; } elseif($lstDat[0]['TipoCiclo'] == 'C'){ echo "CUATRIMESTRE"; } else { echo "SEMESTRE"; } ?>:</b></td>
			<td style="width: 120px;"><?php echo $lstDat[0]['Grado']; ?>°</td>
		</tr>
	</table>
	</page_header>

	<page_footer> <!-- Define el footer de la hoja -->
	<table style="margin-left: 42px;">
		<tr>
			<td style="text-align: right; width: 200px; border: none;"></td>
			<td style="text-align: center; width: 233px; border-right: none; border-bottom: none;">FIRMA DEL DOCENTE</td>
			<td style="text-align: right; width: 200px; border: none;"></td>
		</tr>
		
	</table>
	<br><br>
	</page_footer>
	<table style='margin-left: 4px; font-size: 10px;'>
		<tr>
			<td style="width: 20px;"><b>NÚM</b></td>
			<td style="width: 115px;"><b>MATRÍCULA</b></td>
			<td style="width: 350px;"><b>NOMBRE DEL ALUMNO</b></td>
			<td style="width: 130px; text-align: center;"><b>CALIFICACIÓN DEL PARCIAL</b></td>
		</tr>
		<?php $c = 0; for ($y=0;$y< sizeof($lstUs);$y++) { ?>
		<tr>
			<td style="width: 20px; text-align: center;"><?php echo $c = ($c +1 ); ?>.- </td>
			<td style="width: 100px;"><?php echo $lstUs[$y]['Usuario']; ?></td>
			<td style="width: 290px;"><?php echo $lstUs[$y]['APaterno'].' '.$lstUs[$y]['AMaterno'].' '.$lstUs[$y]['Nombre']; ?></td>
			<td style="width: 30px; text-align: center;"><?php  echo $lstUs[$y]['P1'];  ?></td>
		</tr><?php }
			if($c <= 40) {  $num = (40 - $c); }
			for ($v=1;$v<=$num;$v++) { ?>
		<tr>
			<td style="width: 20px; text-align: center;"><?php echo $c = ($c +1 ); ?>.- </td>
			<td style="width: 80px;"></td>
			<td style="width: 290px;"></td>
			<td style="width: 20px; text-align: center;"></td>
		</tr><?php } ?>
	</table>

</page>
<?php } else {
	echo "<script type='text/javascript'>window.close();</script>";
} ?>
