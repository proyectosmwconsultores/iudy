<?php
if($_SESSION['Permisos']){
	include('numeros.php');
	include('../hace_fecha.php');
	require_once'../portafolio.php';

	$t=new Imprimir();
	$IdUsua = substr($_GET["id"], 10, 10);
	$IdCiclo = substr($_GET["idToks"], 10, 10);
	$lstUs=$t->get_sat_us($IdUsua);
	$lstCi=$t->get_ciclo_ac($IdCiclo,$lstUs[0]['IdGrupo']);

	$lstCol=$t->get_desc_beca_id(2,$IdUsua,$IdCiclo);

	if($lstUs[0]['TipoCiclo'] == 'C'){ $tipC = 'CUATRIMESTRE'; } else { $tipC = 'SEMESTRE'; }
	if($lstUs[0]['TipoCiclo'] == 'C'){ $tipCb = 'CUATRIMESTRAL'; } else { $tipCb = 'SEMESTRAL'; }

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
<page backtop="55mm" backbottom="20mm" backleft="10mm" backright="10mm">
	<page_header> <!-- Define el header de la hoja -->

	<table style="margin-left: 42px; margin-top: 20px; font-size: 9px; text-align: center; font-weight: bold;">
		<tr>
			<td colspan="2" style="width: 130px;"><img src="../../assets/images/campus/secretaria.png" style="width: 100%;" ></td>
			<td colspan="4" style="width: 290px; font-size: 12px;">Instituto Universitario de Yucatán<br><br><br>CONTROL DE DOCUMENTOS</td>
			<td colspan="2" style="width: 130px;"><img src="../../assets/images/campus/iso.png" style="width: 120px;" ></td>
		</tr>
		<tr>
			<td colspan="2" style="width: 130px;">CÓDIGO:<br>SPC-ENPC-FO-PROCOES-02</td>
			<td colspan="2" style="width: 167px;">ÁREA:<br>Instituto Universitario de Yucatán</td>
			<td style="width: 56px;">REVISIÓN:<br>01</td>
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
	<table>
		<tr>
			<td style="text-align: right; width: 710px; border: none; ">SPC-ENPC-FO-PROCOES-02</td>
		</tr>
	</table>
<br><br><br>
	</page_footer>
	<table style='margin-left: 4px; font-size: 11px;'>
		<tr>
			<td style='width: 467px;'><b>NOMBRE: </b><?php echo $lstUs[0]['Nombre'].' '.$lstUs[0]['APaterno'].' '.$lstUs[0]['AMaterno']; ?></td>
			<td style='width: 180px;'><b>MATRICULA:</b> <?php echo $lstUs[0]['Usuario']; ?></td>
		</tr>
		<tr>
			<td style='width: 467px;'><b>CARRERA:</b> <?php echo $lstUs[0]['Educativa']; ?></td>
			<td style='width: 180px;'><b>CUATRIMESTRE:</b> <?php echo $lstCi[0]['Grado']; ?>°</td>
		</tr>
		<tr>
			<td style='width: 467px;'><b>PERIODO ESCOLAR:</b> <?php echo $lstCi[0]['Ciclo']; ?></td>
			<td style='width: 180px;'><b>FECHA:</b> <?php echo date("Y-m-d"); ?></td>
		</tr>
	</table><br><br><br><br>
	<table style='margin-left: 4px; font-size: 11px;'>
		<tr>
			<td style='width: 410px; background: #dadada; text-align: center;'><b>DOCUMENTO</b></td>
			<td style='width: 110px; background: #dadada; text-align: center;'><b>ORIGINAL</b></td>
			<td style='width: 110px; background: #dadada; text-align: center;'><b>COPIAS</b></td>
		</tr>
		<tr>
			<td style='width: 410px;'>Acta de Nacimiento (Original y copia). </td>
			<td style='width: 110px;'></td>
			<td style='width: 110px;'></td>
		</tr>
		<tr>
			<td style='width: 410px;'>Certificado de Bachillerato (Original y copia). </td>
			<td style='width: 110px;'></td>
			<td style='width: 110px;'></td>
		</tr>
		<tr>
			<td style='width: 410px;'>Constancia de Estudios (Original y copia). </td>
			<td style='width: 110px;'></td>
			<td style='width: 110px;'></td>
		</tr>
		<tr>
			<td style='width: 410px;'>Carta de Buena Conducta (Original y copia). </td>
			<td style='width: 110px;'></td>
			<td style='width: 110px;'></td>
		</tr>
		<tr>
			<td style='width: 410px;'>Certificado Médico (Original y copia). </td>
			<td style='width: 110px;'></td>
			<td style='width: 110px;'></td>
		</tr>
		<tr>
			<td style='width: 410px;'>CURP (Original y copia). </td>
			<td style='width: 110px;'></td>
			<td style='width: 110px;'></td>
		</tr>
		<tr>
			<td style='width: 410px;'>4 Fotografías tamaño infantil. </td>
			<td style='width: 110px;'></td>
			<td style='width: 110px;'></td>
		</tr>
		<tr>
			<td style='width: 410px;'>Credencial Oficial (Original y copia). </td>
			<td style='width: 110px;'></td>
			<td style='width: 110px;'></td>
		</tr>
		<tr>
			<td style='width: 410px;'>Cartilla Militar (Original y copia). </td>
			<td style='width: 110px;'></td>
			<td style='width: 110px;'></td>
		</tr>
		<tr>
			<td style='width: 410px;'>Constancia de No Antecedentes penales (Original y copia). </td>
			<td style='width: 110px;'></td>
			<td style='width: 110px;'></td>
		</tr>
		<tr>
			<td style='width: 410px;'>Constancia de Aptitud Psicofísica (Original y copia). </td>
			<td style='width: 110px;'></td>
			<td style='width: 110px;'></td>
		</tr>
		<tr>
			<td style='width: 410px;'>&nbsp;</td>
			<td style='width: 110px;'></td>
			<td style='width: 110px;'></td>
		</tr>
		<tr>
			<td style='width: 410px;'>&nbsp;</td>
			<td style='width: 110px;'></td>
			<td style='width: 110px;'></td>
		</tr>
		<tr>
			<td style='width: 410px;'>&nbsp;</td>
			<td style='width: 110px;'></td>
			<td style='width: 110px;'></td>
		</tr>
		<tr>
			<td style='width: 410px;'>&nbsp;</td>
			<td style='width: 110px;'></td>
			<td style='width: 110px;'></td>
		</tr>
		<tr>
			<td style='width: 410px;'>&nbsp;</td>
			<td style='width: 110px;'></td>
			<td style='width: 110px;'></td>
		</tr>
		<tr>
			<td style='width: 410px;'>&nbsp;</td>
			<td style='width: 110px;'></td>
			<td style='width: 110px;'></td>
		</tr>
	</table>
	<br><br><br>

	<br><br><br><br><br><br>
	<table style='margin-left: 4px;'>
		<tr>
			<td style='width: 333px; text-align: center; border: none;'>_________________________________________<br><br>FIRMA DEL ALUMNO</td>
			<td style='width: 333px; text-align: center; border: none;'>_________________________________________<br><br>NOMBRE Y FIRMA DE QUIEN RECIBE</td>
		</tr>
	</table>

</page>
<?php } else {
	echo "<script type='text/javascript'>window.close();</script>";
} ?>
