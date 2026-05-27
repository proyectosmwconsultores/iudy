<?php
if($_SESSION['Permisos']){
	include('numeros.php');
	include('../hace_fecha.php');
	require_once'../portafolio.php';

	$t=new Imprimir();
	$dat = $t->dats_constancia($_GET["idToks"]);
	if($dat[0]['Mod'] == 'E'){
		$_txt = "lunes a viernes de 8:00 a 15:00 hrs.";
	} else {
		$_txt = "sábado de 8:00 a 15:00 hrs.";
	}
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
<page backtop="60mm" backbottom="5mm" backleft="10mm" backright="10mm">
	<page_header> <!-- Define el header de la hoja -->

	<table style="margin-left: 42px; margin-top: 20px; font-size: 9px; text-align: center; font-weight: bold;">
		<tr>
			<td colspan="2" style="width: 130px;"><img src="../../assets/images/campus/secretaria.png" style="width: 100%;" ></td>
			<td colspan="4" style="width: 290px; font-size: 12px;">Instituto Universitario de Yucatán<br><br><br><b style="font-size: 11px;">CONSTANCIA DE ESTUDIOS</b></td>
			<td colspan="2" style="width: 130px;"><img src="../../assets/images/campus/iso.png" style="width: 120px;" ></td>
		</tr>
		<tr>
			<td colspan="2" style="width: 130px;">CÓDIGO:<br>SPC/ENPC-FO-PROCOAD-09</td>
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


	</page_header>

	<page_footer> <!-- Define el footer de la hoja -->
	<table style="margin-left: 42px;">

		<tr>
			<td style="text-align: left; width: 200px; border: none;">C.c.p.: Archivo.<br>*Mccc
			</td>
			<td style="text-align: center; width: 233px; border: none;"></td>
			<td style="text-align: right; width: 200px; border: none;">SPC/ENPC-FO-PROCOAD-09</td>
		</tr>

	</table>
	<br><br>
	</page_footer>
	<table style="margin-left: 4px;">
		<tr><td style="border: none; width: 666px; font-size: 19px; text-align: center;"><b>C O N S T A N C I A</b></td></tr>
		<tr><td style="border: none; width: 666px; font-size: 16px;"><br><br><br><br><br><br><b>A QUIEN CORRESPONDA:</b><br><br></td></tr>
		<tr><td style="border: none; width: 666px; font-size: 15px; text-align: justify; line-height: 2.5;">
		El &nbsp;&nbsp;&nbsp; que &nbsp;&nbsp;&nbsp;&nbsp; suscribe, &nbsp;&nbsp;&nbsp;&nbsp; Director &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; de &nbsp;&nbsp; esta &nbsp;&nbsp;&nbsp;&nbsp; institución, &nbsp;&nbsp;&nbsp;&nbsp; hace &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; CONSTAR:
&nbsp;&nbsp;&nbsp;&nbsp; que &nbsp;&nbsp;&nbsp; la C. <u><b> &nbsp; <?php echo $dat[0]['APaterno'].' '.$dat[0]['AMaterno'].' '.$dat[0]['Nombre']; ?> &nbsp; </b></u> con número de matrícula
<u><b> &nbsp; <?php echo $dat[0]['Usuario']; ?> &nbsp; </b></u> cursa el <?php echo obtenerGradox_minus($dat[0]['Grado']); ?> cuatrimestre de la <u><b>“<?php echo $dat[0]['Educativa']; ?>”</b></u>, modalidad <?php echo $dat[0]['Modalidad']; ?> (<?php echo $_txt; ?>), en el periodo escolar
<?php echo obtFechConst($dat[0]['FInicio']); ?> – <?php echo obtFechConst($dat[0]['FFinal']); ?>, en la Instituto Universitario de Yucatán, ubicada en la carretera Ocozocoautla - Tuxtla Gutiérrez Km.1.5 Antiguo Aeropuerto Llano San Juan, Ocozocoautla de Espinosa, Chiapas. Con periodo vacacional del 18 de diciembre 2022 al 01 de enero 2023.

		</td></tr>
		<tr><td style="border: none; width: 666px; font-size: 15px; text-align: justify; line-height: 2.5;">
		Para los fines que a la interesada convengan, se extiende la presente constancia a <?php echo fecha_impre($dat[0]['Fecha']); ?>.
		</td></tr>
		<tr>
			<td style="border: none; width: 666px; font-size: 16px; text-align: center; "><br><br><br>
				<b>ATENTAMENTE</b>
			</td>
		</tr>
		<tr>
			<td style="border: none; width: 666px; font-size: 16px; text-align: center; "><br><br><br>
				<b>Cap. Juan Antonio Vargas Reyes <br>
				Director de la Instituto Universitario de Yucatán
				</b>
			</td>
		</tr>
		<tr>
			<td style="border: none; width: 666px; font-size: 16px; text-align: center; "><br><br>
				<img src="../../assets/images/qr/<?php echo $dat[0]['Anio']; ?>/<?php echo $dat[0]['Mes']; ?>/<?php echo $_GET['idToks']; ?>.png" style="width: 100px;" >
			</td>
		</tr>

	</table>

</page>
<?php } else {
	echo "<script type='text/javascript'>window.close();</script>";
} ?>
