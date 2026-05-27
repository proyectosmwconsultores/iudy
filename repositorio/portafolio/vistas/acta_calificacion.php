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
	$lstDias=$t->get_lst_dias($_GET["tokenId"]);

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
<page backtop="68mm" backbottom="20mm" backleft="10mm" backright="10mm">
	<page_header> <!-- Define el header de la hoja -->

	<table style="margin-left: 42px; margin-top: 20px; font-size: 9px; text-align: center; font-weight: bold;">
		<tr>
			<td colspan="2" style="width: 130px;"><img src="../../assets/images/campus/secretaria.png" style="width: 100%;" ></td>
			<td colspan="4" style="width: 290px; font-size: 12px;">Instituto Universitario de Yucatán<br><br><br><b style="font-size: 11px;">ACTA DE LISTA DE ASISTENCIA CON CALIFICACIONES</b></td>
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
			<td colspan="2" style="width: 483px; text-align: left;">MATERIA: <b><?php echo $lstDat[0]['NombreMod']; ?></b></td>
			<td style="width: 150px; text-align: left;">CLAVE DGP: </td>
		</tr>
		<tr>
			<td style="width: 150px; text-align: left;"><?php if($lstDat[0]['TipoCiclo'] == 'C'){ echo "CUATRIMESTRE"; } else { echo "SEMESTRE"; } ?>: <b><?php echo $lstDat[0]['Grado']; ?>°</b></td>
			<td colspan="2" style="width: 483px; text-align: left;">CARRERA: <b><?php echo $lstDat[0]['Educativa']; ?></b></td>
		</tr>
		<tr>
			<td style="width: 150px; text-align: left;">CICLO: <b><?php echo $lstDat[0]['Periodo']; ?></b></td>
			<td colspan="2" style="width: 483px; text-align: left;">PERIODO: <b><?php echo $lstDat[0]['Ciclo']; ?></b></td>
		</tr>
		<tr>
			<td style="border: none; width: 150px; text-align: left;"></td>
			<td style="border: none; width: 332px; text-align: left;"></td>
			<td style="border: none; width: 150px; text-align: left;"></td>
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
			<td style="width: 20px;"><b>NÚM</b></td>
			<td style="width: 70px;"><b>MATRÍCULA</b></td>
			<td style="width: 308px;"><b>NOMBRE DEL ALUMNO</b></td>
			<td colspan="2" style="width: 200px; text-align: center;"><b>CALIFICACIÓN</b></td>
		</tr>
		<?php $c = 0; for ($y=0;$y< sizeof($lstUs);$y++) { ?>
		<tr>
			<td style="width: 20px; text-align: center;"><?php echo $c = ($c +1 ); ?></td>
			<td style="width: 70px;"><?php echo $lstUs[$y]['Usuario']; ?></td>
			<td style="width: 308px;"><?php echo $lstUs[$y]['APaterno'].' '.$lstUs[$y]['AMaterno'].' '.$lstUs[$y]['Nombre']; ?></td>
			<td style="width: 52px; text-align: center;"><?php echo $lstUs[$y]['Promedio']; ?></td>
			<td style="width: 148px; text-align: center;"><?php if(($lstUs[$y]['Promedio'] == 'A') || ($lstUs[$y]['Promedio'] == 'N')) { if( $lstUs[$y]['Promedio'] == 'A'){ echo "ACREDITADO"; } else { echo "NO ACREDITADO"; } } else { echo obtNumLetr($lstUs[$y]['Promedio']); } ?></td>
		</tr><?php }
			if($c <= 37) {  $num = (37 - $c); }
			for ($v=1;$v<=$num;$v++) { ?>
		<tr>
			<td style="width: 20px; text-align: center;"><?php echo $c = ($c +1 ); ?></td>
			<td style="width: 70px;"></td>
			<td style="width: 308px;"></td>
			<td style="width: 52px; text-align: center;"></td>
			<td style="width: 148px; text-align: center;"></td>
		</tr><?php } ?>
	</table>

</page>
<?php } else {
	echo "<script type='text/javascript'>window.close();</script>";
} ?>
