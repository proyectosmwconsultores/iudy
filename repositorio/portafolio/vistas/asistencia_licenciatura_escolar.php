<?php
if($_SESSION['Permisos']){
	include('numeros.php');
	include('../hace_fecha.php');
	require_once'../portafolio.php';

	$t=new Imprimir();
	// $IdUsua = substr($_GET["id"], 10, 10);
	// $IdCiclo = substr($_GET["idToks"], 10, 10);
	$lstDat=$t->get_enca_list($_GET["tokenId"]);
	$lstUs=$t->get_lst_prom($_GET["tokenId"]);
	$dia=$t->get_chk_lista_as($_GET["tokenId"],$_GET['tok']);

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
<page backtop="67mm" backbottom="20mm" backleft="10mm" backright="10mm">
	<page_header> <!-- Define el header de la hoja -->

	<table style="margin-left: 42px; margin-top: 20px; font-size: 9px; text-align: center; font-weight: bold;">
		<tr>
			<td colspan="2" style="width: 130px;"><img src="../../assets/images/campus/secretaria.png" style="width: 100%;" ></td>
			<td colspan="4" style="width: 290px; font-size: 12px;">Instituto Universitario de Yucatán<br><br><br><b style="font-size: 11px;">LISTA DE ASISTENCIA</b></td>
			<td colspan="2" style="width: 130px;"><img src="../../assets/images/campus/iso.png" style="width: 120px;" ></td>
		</tr>
		<tr>
			<td colspan="2" style="width: 130px;">CÓDIGO:<br>SPC/ENPC-FO-PROCOAD-06</td>
			<td colspan="2" style="width: 167px;">ÁREA:<br>Instituto Universitario de Yucatán</td>
			<td style="width: 56px;">REVISIÓN:<br>02</td>
			<td colspan="2" style="width: 141px;">FECHA DE IMPLEMENTACIÓN:<br>27/05/2020</td>
			<td style="width: 60px;">PÁGINA:<br>1 DE 1</td>
		</tr>
		<tr>
			<td colspan="8" style="border-left: none; border-right: none; border-bottom: none;"></td>
		</tr>
		<tr>
			<td style="width: 60px; border: none;"></td>
			<td style="width: 70px; border: none;"></td>
			<td style="width: 71px; border: none;"></td>
			<td style="width: 96px; border: none;"></td>
			<td style="width: 56px; border: none;"></td>
			<td style="width: 71px; border: none;"></td>
			<td style="width: 70px; border: none;"></td>
			<td style="width: 60px; border: none;"></td>
		</tr>
	</table>
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
			<td style="width: 80px; text-align: left;"><b><?php if($lstDat[0]['TipoCiclo'] == 'C'){ echo "CUATRIMESTRE"; } else { echo "SEMESTRE"; } ?>:</b></td>
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
		<tr>
			<td style="text-align: right; width: 200px; border: none;"></td>
			<td style="text-align: center; width: 233px; border: none;"></td>
			<td style="text-align: right; width: 200px; border: none;">SPC/ENPC-FO-PROCOAD-06</td>
		</tr>
	</table>
	<br><br>
	</page_footer>

	<table style='margin-left: 4px; font-size: 10px;'>
		<tr>
			<td rowspan="2" style="width: 10px;"><b>NÚM</b></td>
			<td rowspan="2" style="width: 70px;"><b>MATRÍCULA</b></td>
			<td rowspan="2" style="width: 222px;"><b>NOMBRE DEL ALUMNO</b></td>
			<td colspan="12" style="width: 80px; text-align: center;"><b><?php echo $_GET['tok']; ?>° PARCIAL</b></td>
		</tr>
		<tr>
			<?php for ($x=0;$x<12;$x++) { ?>
			<td style="width: 10px; text-align: center; font-size: 8px; padding: 3px 0px 3px 0px !important;"><?php if(isset($dia[$x]['Fecha'])){ echo obtenerAsis($dia[$x]['Fecha']); } ?></td>
			<?php } ?>
		</tr>
		<?php $c = 0; for ($y=0;$y< sizeof($lstUs);$y++) {

			 ?>
		<tr>
			<td style="width: 10px; text-align: center;"><?php echo $c = ($c +1 ); ?></td>
			<td style="width: 70px;"><?php echo $lstUs[$y]['Usuario']; ?></td>
			<td style="width: 222px;"><?php echo $lstUs[$y]['APaterno'].' '.$lstUs[$y]['AMaterno'].' '.$lstUs[$y]['Nombre']; ?></td>
			<?php for ($x=0;$x<12;$x++) { ?>
			<td style="width: 10px; text-align: center; font-size: 8px; padding: 3px 0px 3px 0px !important;">
			<?php if(isset($dia[$x]['Fecha'])){
				$ses1=$t->get_asis_id_p($lstUs[$y]['IdUsua'],$dia[$x]['Fecha'],$_GET["tokenId"]);
				echo $ses1[0]['Imprimir'];
			 } ?>
			</td>
			<?php } ?>
		</tr><?php }
			if($c <= 36) {  $num = (36 - $c); }
			for ($v=1;$v<=$num;$v++) { ?>
		<tr>
			<td style="width: 10px; text-align: center;"><?php echo $c = ($c +1 ); ?></td>
			<td style="width: 70px;"></td>
			<td style="width: 222px;"></td>
			<td style="width: 10px; text-align: center;"></td>
			<td style="width: 10px; text-align: center;"></td>
			<td style="width: 10px; text-align: center;"></td>
			<td style="width: 10px; text-align: center;"></td>
			<td style="width: 10px; text-align: center;"></td>
			<td style="width: 10px; text-align: center;"></td>
			<td style="width: 10px; text-align: center;"></td>
			<td style="width: 10px; text-align: center;"></td>
			<td style="width: 10px; text-align: center;"></td>
			<td style="width: 10px; text-align: center;"></td>
			<td style="width: 10px; text-align: center;"></td>
			<td style="width: 10px; text-align: center;"></td>
		</tr><?php } ?>
	</table>

</page>
<?php } else {
	echo "<script type='text/javascript'>window.close();</script>";
} ?>
