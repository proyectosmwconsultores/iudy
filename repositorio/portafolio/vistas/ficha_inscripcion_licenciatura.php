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

	if(($lstUs[0]['IdOferta'] == 8) || ($lstUs[0]['IdOferta'] == 10) || ($lstUs[0]['IdOferta'] == 11) || ($lstUs[0]['IdOferta'] == 12)){
		$coo = "DR. EDGAR RICARDO MORGAN LÓPEZ";
	}

	if($lstUs[0]['IdOferta'] == 6){
		$coo = "CAP. P.A.C. ÁLVARO AMADO NERI MARTÍNEZ";
	}

	if(($lstUs[0]['IdOferta'] == 7) || ($lstUs[0]['IdOferta'] == 9)){
		$coo = "MTRO. ERICK SÁNCHEZ MARTÍNEZ";
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
<page backtop="60mm" backbottom="20mm" backleft="10mm" backright="10mm">
	<page_header> <!-- Define el header de la hoja -->
		<table style="margin-left: 42px; margin-top: 20px; font-size: 9px; text-align: center; font-weight: bold;">
			<tr>
				<td colspan="2" style="width: 130px;"><img src="../../assets/images/campus/secretaria.png" style="width: 100%;" ></td>
				<td colspan="4" style="width: 290px; font-size: 12px;">Instituto Universitario de Yucatán<br><br><br><?php echo $_txF; ?></td>
				<td colspan="2" style="width: 130px;"><img src="../../assets/images/campus/iso.png" style="width: 120px;" ></td>
			</tr>
			<tr>
				<td colspan="2" style="width: 130px;">CÓDIGO:<br>SPC-ENPC-FO-PROCOES-01</td>
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
	<table style='margin-left: 42px;'>

		<tr>
			<td style='width: 120px; text-align: center; border-left: none; border-top: none; border-right: none; border-bottom: none;'>CAP. JUAN ANTONIO VARGAS REYES <br><br></td>
			<td style='width: 20px; color: blue; border: none;'></td>
			<td style='width: 120px; text-align: center; border-left: none; border-top: none; border-right: none; border-bottom: none;'><?php echo $coo; ?><br><br></td>
		</tr>
		<tr>
			<td style='width: 120px; text-align: center; border-left: none; border-top: none; border-right: none;'></td>
			<td style='width: 20px; color: blue; border: none;'></td>
			<td style='width: 120px; text-align: center; border-left: none; border-top: none; border-right: none;'></td>
		</tr>
		<tr>
			<td style='width: 120px; text-align: center; border-left: none; border-top: none; border-right: none; border-bottom: none;'>Vo.Bo<br>DIRECTOR</td>
			<td style='width: 20px; color: blue; border: none;'></td>
			<td style='width: 120px; text-align: center; border-left: none; border-top: none; border-right: none; border-bottom: none;'>Vo.Bo.<br>COORDINADOR ACADÉMICO</td>
		</tr>
		<tr>
			<td colspan="3" style='width: 670px; border: none; text-align: right; height: 50px;'><b>SPC-ENPC-FO-PROCOES-07</b></td>
		</tr>

	</table>
	</page_footer>
	<table style='margin-left: 4px; '>
		<tr>
			<td colspan='2' style='width: 670px; color: black; border: none; text-align: right; height: 30px;'><b>FECHA DE EMISIÓN <?php echo obtFechMay($lstCi[0]['Fec_tramite']); ?></b></td>
		</tr>
		<tr style='background: #dadada;'>
			<td colspan='2' style='width: 670px; color: blue; border: none;'><b>FICHA DE <?php echo $_txF; ?></b></td>
		</tr>
		<tr>
			<td style='width: 70px; border: none;'><?php echo $lstUs[0]['_Grado']; ?>:</td>
			<td style='width: 500px; border-right: none;'><?php echo $lstUs[0]['Educativa']; ?></td>
		</tr>
	</table>
	<table style='margin-left: 4px; margin-top: 5px;'>
		<tr>
			<td style='width: 110px; border: none;'>PERIODO ESCOLAR:</td>
			<td style='width: 310px; border-top: none; border-right: none;'><?php echo $lstCi[0]['Ciclo']; ?></td>
			<td style='width: 80px; border: none; text-align: right;'>MATRÍCULA:</td>
			<td style='width: 120px; border-top: none; border-right: none;'><?php echo $lstUs[0]['Usuario']; ?></td>
		</tr>
	</table>
	<table style='margin-left: 4px; margin-top: 5px;'>
		<tr>
			<td style='width: 190px; border: none;'><?php echo $tipC; ?>: <?php echo obtenerGradox($lstCi[0]['Grado']); ?></td>
			<td style='width: 80px; border: none;'>GRUPO: <?php echo $lstUs[0]['Grupo']; ?></td>
			<td style='width: 150px; border: none;'>DIA: <?php echo $lstUs[0]['_Dias']; ?></td>
			<td style='width: 200px; border: none;'>MODALIDAD: <?php echo $lstUs[0]['_Modalidad']; ?></td>
		</tr>
	</table><br><br><br>
	<table style='margin-left: 4px; '>
		<tr style='background: #dadada;'>
			<td colspan='5' style='width: 670px; color: blue; border: none;'><b>DATOS DEL ALUMNO</b></td>
		</tr>
		<tr>
			<td style='width: 191px; text-align: center; border-left: none; border-right: none; '><?php echo $lstUs[0]['APaterno']; ?></td>
			<td style='width: 15px; text-align: center; border: none;'></td>
			<td style='width: 191px; text-align: center; border-right: none; '><?php echo $lstUs[0]['AMaterno']; ?></td>
			<td style='width: 15px; text-align: center; border: none;'></td>
			<td style='width: 191px; text-align: center; border-right: none; '><?php echo $lstUs[0]['Nombre']; ?></td>
		</tr>
		<tr>
			<td style='width: 191px; text-align: center; border-left: none; border-right: none; border-bottom:none;'>APELLIDO PATERNO</td>
			<td style='width: 15px; text-align: center; border: none;'></td>
			<td style='width: 191px; text-align: center; border-right: none; border-bottom:none;'>APELLIDO MATERNO</td>
			<td style='width: 15px; text-align: center; border: none;'></td>
			<td style='width: 191px; text-align: center; border-right: none; border-bottom:none;'>NOMBRE</td>
		</tr>
	</table>
	<table style='margin-left: 4px; margin-top: 5px;'>
	<tr>
		<td style='width: 70px; border:none; '>DIRECCIÓN:</td>
		<td style='width: 582px;  border-top: none; border-right: none;'><?php echo $infox[0]['D_direccion']; ?></td>
	</tr>
	</table>
	<table style='margin-left: 4px; margin-top: 5px;'>
	<tr>
		<td style='width: 70px; border:none; '>CELULAR</td>
		<td style='width: 104px; text-align: left; border-top: none; border-right: none;'><?php echo $lstUs[0]['Celular']; ?></td>
		<td style='width: 105px; border:none; text-align: right;'>CORREO:</td>
		<td style='width: 338px; border-top: none; border-right: none;'><?php echo $lstUs[0]['Correo']; ?></td>
	</tr>
	</table>

	<table style='margin-left: 4px; margin-top: 5px;'>
	<tr>
		<td style='width: 120px; border:none; '>FECHA DE NACIMIENTO:</td>
		<td style='width: 50px; text-align: center; border-top: none; border-right: none;'><?php echo $lstUs[0]['FecNac']; ?></td>
		<td style='width: 120px; text-align: right; border:none; '>LUGAR DE NACIMIENTO:</td>
		<td style='width: 329px; border-top: none; border-right: none;'><?php echo $infox[0]['Nom_municipio'].', '.$infox[0]['Estado']; ?></td>
	</tr>
	</table>
	<table style='margin-left: 4px; margin-top: 5px;'>
	<tr>
		<td style='width: 50px; border:none; '>CURP:</td>
		<td style='width: 179px; text-align: left; border-top: none; border-right: none;'><?php echo $infox[0]['P_curp']; ?></td>
		<td style='width: 120px; text-align: right; border:none; '>TIPO DE SANGRE:</td>
		<td style='width: 270px; border-top: none; border-right: none;'><?php echo $infox[0]['Sangre']; ?></td>
	</tr>
	</table>
	<table style='margin-left: 4px; margin-top: 5px;'>
	<tr>
		<td style='width: 50px; border:none; '>SEXO:</td>
		<td style='width: 150px; text-align: left; border-top: none; border-right: none;'><?php if($lstUs[0]['Sexo'] == 'H'){ echo "MASCULINO"; } else { echo "FEMENINO"; } ?></td>
		<td style='width: 100px; text-align: right; border:none; '>ESTADO CIVIL:</td>
		<td style='width: 105px; border-top: none; border-right: none;'><?php echo $p_civl; ?></td>
		<td style='width: 80px; text-align: right; border:none; '>TRABAJA:</td>
		<td style='width: 100px; border-top: none; border-right: none;'><?php echo $infox[0]['P_trabaja']; ?></td>
	</tr>
	</table>
	<br><br><br>
	<table style='margin-left: 4px; margin-top: 30px;'>
		<tr style='background: #dadada;'>
			<td style='width: 670px; color: blue; border: none;'><b>CONTACTO DE EMERGENCIA</b></td>
		</tr>
	</table>
	<table style='margin-left: 4px; margin-top: 5px;'>
		<tr>
			<td style='width: 110px; border: none;'>COMUNICARSE CON:</td>
			<td style='width: 310px; border-top: none; border-right: none;'><?php echo $infox[0]['ENombre']; ?></td>
			<td style='width: 80px; border: none; text-align: right;'>AL TELÉFONO:</td>
			<td style='width: 120px; border-top: none; border-right: none;'><?php echo $infox[0]['ECelular']; ?></td>
		</tr>
	</table>
	<table style='margin-left: 4px; margin-top: 5px;'>
		<tr>
			<td style='width: 260px; border: none;'>¿PADECE ALGUNA ENFERMEDAD O ALERGIA?</td>
			<td style='width: 40px; border-top: none; border-right: none;'><?php echo $infox[0]['_Enfermedad']; ?></td>
			<td style='width: 50px; border: none; text-align: right;'>¿CUÁL?</td>
			<td style='width: 270px; border-top: none; border-right: none;'><?php echo $infox[0]['_Cual']; ?></td>
		</tr>
	</table>
	<table style='margin-left: 4px; margin-top: 5px;'>
		<tr>
			<td style='width: 160px; border: none;'>¿TOMA ALGÚN MEDICAMENTO?</td>
			<td style='width: 490px; border-top: none; border-right: none;'><?php echo $infox[0]['_Medicamento']; ?></td>
		</tr>
	</table>
	<br><br><br>
	<table style='margin-left: 4px; margin-top: 30px;'>
		<tr>
			<td style='width: 670px; color: black; border: none; text-align: center;'>
				<b>_________________________________________________________________<br><br>
				NOMBRE Y FIRMA DEL ALUMNO</b>
			</td>
		</tr>
	</table>
</page>
<?php } else {
	echo "<script type='text/javascript'>window.close();</script>";
} ?>
