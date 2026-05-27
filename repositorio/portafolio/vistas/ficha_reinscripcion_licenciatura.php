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
	$infox=$t->get_infor_cel($IdUsua);
	$esta=$t->get_estado_p($infox[0]['E_estado_procedencia']);
	$esta_pos=$t->get_estado_p($infox[0]['Pos_estado']);

	$cx = $infox[0]['P_civil'];
	if($lstUs[0]['TipoCiclo'] == 'C'){ $tipC = 'CUATRIMESTRE'; } else { $tipC = 'SEMESTRE'; }
	if($lstUs[0]['TipoCiclo'] == 'C'){ $tipCb = 'CUATRIMESTRAL'; } else { $tipCb = 'SEMESTRAL'; }
	$_civ = $infox[0]['P_civil'];
	if($_civ == 1){ $p_civl = "SOLTERO"; } elseif($_civ == 2){ $p_civl = "CASADO"; } elseif($_civ == 3){ $p_civl = "UNION LIBRE"; } elseif($_civ == 4){ $p_civl = "VIUDO"; } elseif($_civ == 5){ $p_civl = "DIVORCIADO"; } else { $p_civl = "-----"; }
	$_txF = '';
	if($IdCiclo == $lstUs[0]['id_ciclo_ini']){ $_txF = 'FORMATO DE INSCRIPCIÓN'; } else { $_txF = 'FORMATO DE REINSCRIPCIÓN'; }

	$_SESSION['_imprF'] = "FICHA_".$lstCi[0]['Ciclo'].'-'.$lstUs[0]['AMaterno'].'_'.$lstUs[0]['APaterno'].'_'.$lstUs[0]['Nombre'];

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
<page backtop="60mm" backbottom="20mm" backleft="10mm" backright="10mm">
	<page_header> <!-- Define el header de la hoja -->
		<table style="margin-left: 42px; margin-top: 20px; font-size: 9px; text-align: center; font-weight: bold;">
			<tr>
				<td colspan="2" style="width: 130px;"><img src="../../assets/images/campus/secretaria.png" style="width: 100%;" ></td>
				<td colspan="4" style="width: 290px; font-size: 12px;">Instituto Universitario de Yucatán<br><br><br><?php echo $_txF; ?></td>
				<td colspan="2" style="width: 130px;"><img src="../../assets/images/campus/iso.png" style="width: 120px;" ></td>
			</tr>
			<tr>
				<td colspan="2" style="width: 130px;">CÓDIGO:<br>SPC-ENPC-FO-PROCOES-07</td>
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

	<table style='margin-left: 42px;'>

		<tr>
			<td style='width: 120px; text-align: center; border-left: none; border-top: none; border-right: none;'></td>
			<td style='width: 20px; color: blue; border: none;'></td>
			<td style='width: 120px; text-align: center; border: none;'></td>
		</tr>
		<tr>
			<td style='width: 120px; text-align: center; border-left: none; border-top: none; border-right: none; border-bottom: none;'>FIRMA DEL ALUMNO<br><br><br><br><br><br><br><br> </td>
			<td style='width: 20px; color: blue; border: none;'></td>
			<td style='width: 120px; text-align: center; border: none;'></td>
		</tr>
		<tr>
			<td style='width: 120px; text-align: center; border-left: none; border-top: none; border-right: none;'></td>
			<td style='width: 20px; color: blue; border: none;'></td>
			<td style='width: 120px; text-align: center; border: none;'></td>
		</tr>
		<tr>
			<td style='width: 120px; text-align: center; border-left: none; border-top: none; border-right: none; border-bottom: none;'>FIRMA DEL PADRE O TUTOR </td>
			<td style='width: 20px; color: blue; border: none;'></td>
			<td style='width: 120px; text-align: center; border: none;'>SELLO DEL ÁREA FINANCIERA</td>
		</tr>
		<tr>
			<td colspan="3" style='width: 670px; border: none; text-align: right; height: 50px;'><br><br><b>SPC-ENPC-FO-PROCOES-07</b></td>
		</tr>

	</table><br><br><br>
	</page_footer>
	<table style='margin-left: 4px; '>
		<tr>
			<td style='width: 300px; border-left: none; border-top: none; border-bottom: none;'></td>
			<td style='width: 350px; height: 20px;'><b>FECHA: </b><?php echo obtFechMay($lstCi[0]['Fec_tramite']); ?></td>
		</tr>
		<tr>
			<td style='width: 300px; border-left: none; border-top: none; border-bottom: none;'></td>
			<td style='width: 350px; height: 20px;'><b>CARRERA: </b><?php echo $lstUs[0]['Educativa']; ?></td>
		</tr>
		<tr>
			<td style='width: 300px; border-left: none; border-top: none; border-bottom: none;'></td>
			<td style='width: 350px; height: 20px;'><b><?php echo $tipC; ?> A CURSAR: </b><?php echo obtenerGradox($lstCi[0]['Grado']); ?></td>
		</tr>
		<tr>
			<td style='width: 300px; border-left: none; border-top: none; border-bottom: none;'></td>
			<td style='width: 350px; height: 20px;'><b>PERIODO ESCOLAR:</b> <?php echo $lstCi[0]['Ciclo']; ?></td>
		</tr>
	</table><br><br><br><br>
	<table style='margin-left: 4px; '>
		<tr>
			<td style='width: 666px; height: 12px;'><b>NOMBRE:</b> <?php echo $lstUs[0]['Nombre']; ?> <?php echo $lstUs[0]['APaterno']; ?> <?php echo $lstUs[0]['AMaterno']; ?></td>
		</tr>
		<tr>
			<td style='width: 666px; height: 12px;'><b>MATRÍCULA:</b> <?php echo $lstUs[0]['Usuario']; ?></td>
		</tr>
		<tr>
			<td style='width: 666px; height: 12px;'><b>CELULAR O TELÉFONO:</b> <?php echo $lstUs[0]['Celular']; ?></td>
		</tr>
		<tr>
			<td style='width: 666px; height: 12px;'><b>CORREO ELECTRÓNICO:</b> <?php echo $lstUs[0]['Correo']; ?></td>
		</tr>
	</table><br><br><br><br>
	<table style='margin-left: 4px; '>
		<tr>
			<td style='width: 100px; height: 15px;'><b>PADRE O TUTOR:</b> </td>
			<td style='width: 550px; height: 15px;'><?php echo $infox[0]['ENombre']; ?></td>
		</tr>
		<tr>
			<td style='width: 100px; height: 15px;'><b>TELÉFONO: </b></td>
			<td style='width: 550px; height: 15px;'><?php echo $infox[0]['ECelular']; ?></td>
		</tr>
		<tr>
			<td style='width: 100px; height: 15px;'><b>DOMICILIO:</b></td>
			<td style='width: 550px; height: 15px;'><?php echo $infox[0]['D_direccion']; ?></td>
		</tr>
	</table>
</page>
<?php } else {
	echo "<script type='text/javascript'>window.close();</script>";
} ?>
