<?php
if($_SESSION['Permisos']){
	include('numeros.php');
	include('../hace_fecha.php');
	require_once'../portafolio.php';
 
	$t=new Imprimir();
	$h = $_GET["h"];
	$IdUsua = substr($_GET["id"], 10, 10);
	$IdCiclo = substr($_GET["idToks"], 10, 10);
	$rvoe=$t->get_datos_campus_rvoe($IdUsua); 
	$lstUs=$t->get_sat_us($IdUsua);
	$lstCi=$t->get_ciclo_ac($IdCiclo,$lstUs[0]['IdGrupo']);

	$lstCol=$t->get_desc_beca_id(2,$IdUsua,$IdCiclo);
	$lstBec=$t->get_mi_beca_id($IdUsua,$IdCiclo);
	$hoy = date("Y-m-d");
	if($lstUs[0]['TipoCiclo'] == 'C'){ $tipC = 'CUATRIMESTRE'; } elseif($lstUs[0]['TipoCiclo'] == 'T'){ $tipC = 'TRIMESTRE'; } else { $tipC = 'SEMESTRE'; }
	
	if($h == 'P'){
		$cic_act = $t->get_cic_activo_personalizado($_SESSION['IdUsua']);
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
<page backtop="55mm" backbottom="20mm" backleft="10mm" backright="10mm">
	<page_header> <!-- Define el header de la hoja -->

	<table style="margin-left: 42px; margin-top: 20px; font-size: 9px; text-align: center; font-weight: bold;">
			<tr>
				<td style="width: 150px;"><img src="../../assets/images/campus/<?php echo $rvoe[0]['_logoPdf']; ?>" style="width: 100%;" ></td>
				<td style="width: 500px; font-size: 16px;">
				    <?php echo $rvoe[0]['_titulo']; ?><br>
				    <b style="font-size: 12px;"><?php echo $rvoe[0]['Educativa']; ?><br>
				    FORMATO DE CONVENIO DE BECA</b>
				</td>
			</tr>
		</table>
	</page_header>

	<page_footer> <!-- Define el footer de la hoja -->
	<table>
		<tr>
			<td style="text-align: right; width: 710px; border: none; "></td>
		</tr>
	</table>
<br><br><br>
	</page_footer>
	<table style='margin-left: 4px; '>
		<tr>
			<td style='width: 665px; border-radius: 20px;'>
				<table style='margin-left: 10px; margin-top: 10px;'>
					<tr>
						<td colspan='6' style='width: 500px; border: none;'>La Instituto Universitario de Yucatán, acuerda proporcionar una Beca a:</td>
					</tr>
					<tr>
						<td style='width: 120px; text-align: right; background: #dadada; border: 1px solid white;'><b>ALUMNO</b>:</td>
						<td colspan='5' style='width: 350px; border: 1px solid white;'><?php echo $lstUs[0]['Nombre'].' '.$lstUs[0]['APaterno'].' '.$lstUs[0]['AMaterno']; ?></td>
					</tr>
					<tr>
						<td style='width: 120px; background: #dadada; border: 1px solid white; text-align: right;'><b><?php echo $tipC; ?>:</b></td>
						<td style='width: 50px; border: 1px solid white; text-align: left;'><?php if($h == 'P'){  echo '---'; } else { echo $lstCi[0]['Grado'].' °';  } ?></td>
						<td style='width: 80px; background: #dadada; border: 1px solid white; text-align: right;'><b>NIVEL:</b></td>
						<td style='width: 90px; border: 1px solid white; '><?php echo $lstUs[0]['_Grado']; ?></td>
						<td style='width: 90px; background: #dadada; border: 1px solid white; text-align: right;'><b>DIA:</b></td>
						<td style='width: 90px; border: 1px solid white;'><?php echo $lstUs[0]['_Dias']; ?></td>
					</tr>
					<tr>
						<td style='width: 120px; text-align: right; background: #dadada; border: 1px solid white;'><b>MODALIDAD</b>:</td>
						<td colspan='5' style='width: 350px; border: 1px solid white;'><?php echo $lstUs[0]['_Modalidad']; ?></td>
					</tr>
					<tr>
						<td style='width: 120px; text-align: right; background: #dadada; border: 1px solid white;'><b>AREA</b>:</td>
						<td colspan='5' style='width: 400px; border: 1px solid white;'><?php echo $lstUs[0]['Educativa']; ?></td>
					</tr>
					<tr>
						<td style='width: 120px; text-align: right; background: #dadada; border: 1px solid white;'><b>PERIODO ESCOLAR</b>:</td>
						<td colspan='5' style='width: 350px; border: 1px solid white;'><?php if($h == 'P'){ echo $cic_act[0]['Ciclo']; } else { echo $lstCi[0]['Ciclo']; }  ?></td>
					</tr>
					<tr>
						<td colspan='6' style='border: none;'>&nbsp;</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<br><br>
	<p style="text-align: center; font-size: 21px;"> <b>CONSIDERACIONES</b> </p>
	<br>
	<table style='margin-left: 4px;'>
		<tr>
			<td style='width: 100px; padding: 5px; border: none;'><b>PRIMERA:</b></td>
			<td style='width: 555px; text-align: justify; border: none;'>El estudiante tendrá una beca de <?php 
			for ($y=0;$y< sizeof($lstBec);$y++) {
				echo $lstBec[$y]['_concepto'].' del '.round($lstBec[$y]['Porcentaje'], 1).' % ';
			}
			
			?>. </td>
		</tr>
		<tr>
			<td style='width: 100px; padding: 5px; border: none;'><b>SEGUNDA:</b></td>
			<td style='width: 555px; text-align: justify; border: none;'>Deberá cumplir debidamente con el Contrato de Prestación de Servicios Educativos.</td>
		</tr>
		<tr>
			<td style='width: 100px; padding: 5px; border: none;'><b>TERCERA:</b></td>
			<td style='width: 555px; text-align: justify; border: none;'>En caso de reprobar materias en cualquier etapa de evaluación, perderá la BECA.</td>
		</tr>
		<tr>
			<td style='width: 100px; padding: 5px; border: none;'><b>CUARTA:</b></td>
			<td style='width: 555px; text-align: justify; border: none;'>El Instituto Universitario de Yucatán seguirá considerando al estudiante como becado siempre y cuando esté aprobando todas sus materias y conserve el promedio general de 9.0 como lo indica la Convocatoria de Becas y expedida por la Secretaría de educación.</td>
		</tr>
		<tr>
			<td style='width: 100px; padding: 5px; border: none;'><b>QUINTA:</b></td>
			<td style='width: 555px; text-align: justify; border: none;'>Esta BECA se otorga exclusivamente para el <?php if($h == 'P'){ echo 'Periodo Escolar: '.$cic_act[0]['Ciclo']; } else { ?> <?php echo $lstCi[0]['Grado']; ?>° <?php echo $tipC; ?> del periodo escolar <?php echo $lstCi[0]['Ciclo']; } ?>. </td>
		</tr>
		<tr>
			<td style='width: 100px; padding: 5px; border: none;'><b>SEXTA:</b></td>
			<td style='width: 555px; text-align: justify; border: none;'>El estudiante podrá tener derecho a BECA en el siguiente periodo escolar siempre y cuando reúna los requisitos y trámites señalados por la convocatoria que expida la Instituto Universitario de Yucatán.</td>
		</tr>
		<tr>
			<td style='width: 100px; padding: 5px; border: none;'><br><br><b>OBSERVACIONES:</b></td>
			<td style='width: 555px; text-align: justify; border: none;'><br><br><?php if(isset($lstCol[0]['Convenio'])){ echo $lstCol[0]['Convenio']; }  ?></td>
		</tr>
		<tr>
			<td colspan='2' style='width: 555px; text-align: right; border: none;'>
			<br><br><br><br><br>Villahermosa-Teapa KM 1, Plutarco Elias Calles, 86170 Villahermosa, Tab. <?php echo obtener_fecha_entera($hoy); ?>. </td>
		</tr>
	</table>
	<br><br><br><br><br><br>
	<table style='margin-left: 4px;'>
		<tr>
			<td style='width: 333px; text-align: center; border: none;'>_________________________________________<br><b>Estudiante<br>Nombre y firma</b></td>
			<td style='width: 333px; text-align: center; border: none;'>_________________________________________<br><b>Nombre y firma<br>de autorización</b></td>
		</tr>
	</table>

</page>
<?php } else {
	echo "<script type='text/javascript'>window.close();</script>";
} ?>
