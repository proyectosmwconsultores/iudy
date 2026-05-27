<?php
if($_SESSION['Permisos']){
	require_once'../classprint.php';
	include('numeros.php');
	$t=new Imprimir();
	$Usuario = substr($_GET["tokenId"], 10, 50);
	$_SESSION["Mat"] = $Usuario;
	$datUs=$t->get_datUsuario($Usuario);
	$datMen=$t->get_menDatos($datUs[0]["IdGrupo"]);

	$acta=$t->get_acta_pro($datUs[0]["IdUsua"]);
	$lstp=$t->get_caL_user($Usuario);

	$lstfir=$t->get_lstFir($datMen[0]["IdCampus"],$datMen[0]['IdGrado']);
	$fecha=$t->get_fecha_imp($datUs[0]["IdUsua"]);

	$_nom = $datMen[0]['Nombre'];


	$vg1 = explode(" ", $datMen[0]['Vigencia']);
	$_v1 = $vg1[0].' &nbsp;&nbsp; ';
	$_v2 = $vg1[1].' &nbsp;&nbsp; ';
	$_v3 = $vg1[2].' &nbsp;&nbsp; ';
	$_v4 = $vg1[3].' &nbsp;&nbsp; ';
	$_v5 = $vg1[4];

	$_vigen = $_v1.$_v2.$_v3.$_v4.$_v5;

	$_tixc = 'CUATRIMESTRE';
	if($datUs[0]['TipoCiclo'] == 'C'){ $_tixc = 'CUATRIMESTRE'; } else { $_tixc = 'SEMESTRE'; }
 if($datMen[0]['IdGrado'] == 1){ $_lt = 'DEL ';} elseif($datMen[0]['IdGrado'] == 2){ $_lt = 'DE &nbsp; &nbsp; LA';} elseif($datMen[0]['IdGrado'] == 3){ $_lt = 'LA';}

 if(isset($fecha[0]['F_certificado'])){
	 $_dia = letra_dia(substr($fecha[0]['F_certificado'], 8, 2));
	 $_mes = letra_mes($fecha[0]['F_certificado']);
	 $_anio = letra_anio(substr($fecha[0]['F_certificado'], 0, 4));
 } else {
	 $_dia = "--------------";
	 $_mes = "--------------";
	 $_anio = "--------------";
 }
?>
<!-- IMPORTANTE: El contenido de la etiqueta style debe estar entre comentarios de HTML -->
<style>
<!--

table {
    font-family: arial;
    border-collapse: collapse;
    width: 100%;
		font-size: 10px;
}

td, th {
    border: 1px solid #3e3e3e;
    padding: 2.3px;
}
tr:nth-child(even) {
    background-color: #dddddd;
}

-->
</style>

<!-- page define la hoja con los márgenes señalados -->
<page backtop="50m" backbottom="12mm" backleft="1mm" backright="10mm">
	<page_header> <!-- Define el header de la hoja -->

	</page_header>

	<page_footer> <!-- Define el footer de la hoja -->

	</page_footer>
	<div style='width: 100%; height: 1050px;'>
		<table style=" margin-left: 20px; margin-top: 50px;">
			<tr>
				<td style="width: 150px; text-align: center; font-size: 14px; border: none;">
				<img src="../../assets/images/campus/logo_constancia.jpeg" style="width: 60px;">
				</td>
				<td style="width: 550px; text-align: center; font-size: 14px; border: none;">
						<b><?php echo $datMen[0]['Escuela']; ?></b><br>
					<b style="font-size: 11px;">INCORPORADO A LA SECRETARÍA DE EDUCACIÓN ESTATAL</b><br>
					<b style="font-size: 11px;">CON RECONOCIMIENTO DE VALIDEZ OFICIAL 07PSU023AU</b><br>
					<b style="font-size: 11px;">REGISTRO ANTE DIRECCIÓN GENERAL DE PROFESIONES 070370</b><br>
				</td>
			</tr>
		</table>

		<img src="../../assets/images/fondoImg.png" style="width: 80px; margin-left: 60px; margin-top: 30px;">


		<table style=" margin-left: 20px; margin-top: -150px;">
			<tr>
				<td style="width: 150px; text-align: center; font-size: 12px; border: none;"></td>
				<td style="width: 551px; text-align: justify;  font-size: 10px; border: none; line-height: 1.6;">
				LA DIRECCIÓN DE <b><?php echo $datMen[0]['Campus']; ?></b> RÉGIMEN PARTICULAR MODALIDAD <?php echo $datMen[0]['Modalidad']; ?> TURNO <?php echo $datMen[0]['Turno']; ?>
				CLAVE &nbsp; <b>07PSU0234U</b> &nbsp; OTORGADO &nbsp; POR &nbsp; LA &nbsp; SECRETARÍA &nbsp; DE &nbsp; EDUCACIÓN &nbsp; DEL GOBIERNO &nbsp; DEL &nbsp; ESTADO.
				</td>
			</tr>
		</table>
		<table style=" margin-left: 20px;">
			<tr>
				<td style="width: 150px; text-align: center; font-size: 12px; border: none;"></td>
				<td style="width: 130px; text-align: justify;  font-size: 10px; border: none; word-spacing: 2.5px; line-height: 1.6;">
				CERTIFICA QUE EL (LA) C.
				</td>
				<td style="width: 409px; text-align: center;  font-size: 10px; line-height: 1.6; border-top: none; border-right: none; border: 0.2px solid black;">
				<b><?php echo $datUs[0]['Nombre'].' '.$datUs[0]['APaterno'].' '.$datUs[0]['AMaterno']; ?></b>
				</td>
			</tr>
		</table>
		<table style=" margin-left: 20px;">
			<tr>
				<td style="width: 150px; text-align: center; font-size: 12px; border: none;"></td>
				<td style="width: 551px; text-align: justify;  font-size: 10px; border: none; word-spacing: 2.5px; line-height: 1.6;">
				CON No. CONTROL <b><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $datUs[0]['Usuario']; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></b> ACREDITÓ &nbsp; LAS &nbsp; MATERIAS &nbsp; QUE &nbsp; INTEGRAN &nbsp; EL &nbsp; PLAN &nbsp; DE &nbsp; ESTUDIOS
				<?php echo $_lt; ?> &nbsp;&nbsp; <?php echo $_nom; ?>, &nbsp;&nbsp;&nbsp;&nbsp; RVOE: &nbsp;&nbsp; ACUERDO &nbsp;&nbsp;&nbsp;  NÚMERO &nbsp;&nbsp;&nbsp; <b>PSU/000000</b>&nbsp;&nbsp;&nbsp;&nbsp;
				VIGENTE: &nbsp;A &nbsp;&nbsp; PARTIR &nbsp;&nbsp; DEL &nbsp;&nbsp; <?php echo $_vigen; ?>. EN &nbsp;&nbsp; EL &nbsp;&nbsp; PERIODO &nbsp;&nbsp; COMPRENDIDO &nbsp;&nbsp; DE &nbsp;&nbsp; <u> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; MAYO 2018 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u> A <u> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; AGOSTO 2019 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </u> CON LAS SIGUIENTES CALIFICACIONES:
				</td>
			</tr>
		</table>
		<br><br><br>

		<table style=" margin-left: 20px;">
			<tr>
				<td style="width: 150px; font-size: 12px; border: none;"></td>
				<td style="width: 25px; font-size: 10px; border: none; ">
				<img src="../../assets/images/img_vertical.png" style="width: 60%;">
				</td>
				<td style="width: 515px; font-size: 10px; border: none;">
					<table>
						<tr>
							<td colspan='5' style='width: 508px; font-size: 4px; border-radius: 5px 5px 0px 0px'>&nbsp;</td>
						</tr>
						<tr>
							<td rowspan='2' style='width: 300px; font-size: 12px; text-align: center;'><b>M A T E R I A S</b></td>
							<td colspan='3' style='width: 100px; font-size: 6px; text-align: center;'><b>CALIFICACIÓN</b></td>
							<td rowspan='2' style='width: 50px; font-size: 6px; text-align: center;'><b>OBSERVACIONES</b></td>
						</tr>
						<tr>
							<td style='width: 30px; font-size: 6px; text-align: center;'><b>CREDITOS</b></td>
							<td style='width: 30px; font-size: 6px; text-align: center;'><b>CIFRA</b></td>
							<td style='width: 40px; font-size: 6px; text-align: center;'><b>LETRA</b></td>
						</tr>
						<?php $_p = 0; $s = 0;  $g_i = 0; $g_f = 0; for ($i=0;$i< sizeof($lstp);$i++) { $g_i = $lstp[$i]['Grado'];
							if($g_i <> $g_f){ if($g_i <> 1){  ?>
								<tr>
									<td style='width: 8px; font-size: 6px; border-bottom: none;'>&nbsp;&nbsp;</td>
									<td style='width: 8px; font-size: 6px; border-bottom: none;'>&nbsp;&nbsp;</td>
									<td style='width: 8px; font-size: 6px; border-bottom: none;'>&nbsp;&nbsp;</td>
									<td style='width: 8px; font-size: 6px; border-bottom: none;'>&nbsp;&nbsp;</td>
									<td style='width: 8px; font-size: 6px; border-bottom: none;'>&nbsp;&nbsp;</td>
								</tr><?php } ?>
								<tr>
									<td style='width: 300px; font-size: 7px; text-align: center; border-bottom: none;'><b><?php echo obtenerCuat($lstp[$i]['Grado']).' '.$_tixc; ?></b></td>
									<td style='width: 30px; font-size: 7px; border-bottom: none;'></td>
									<td style='width: 30px; font-size: 7px; border-bottom: none;'></td>
									<td style='width: 40px; font-size: 7px; border-bottom: none;'></td>
									<td style='width: 50px; font-size: 7px; border-bottom: none;'></td>
								</tr>
						<?php $g_f = $lstp[$i]['Grado'];  }?>
						<tr>
							<td style='width: 300px; font-size: 7px; border-bottom: none;'><?php echo $lstp[$i]['NombreMod']; ?></td>
							<td style='width: 30px; font-size: 7px; text-align: center; border-bottom: none;'><?php echo number_format($lstp[$i]['Creditos'], 0, '.', ','); ?></td>
							<td style='width: 30px; font-size: 7px; text-align: center; border-bottom: none;'><?php echo $lstp[$i]['Promedio']; ?></td>
							<td style='width: 40px; font-size: 7px; text-align: center; border-bottom: none;'><?php echo obtenerNumeroEnLetra($lstp[$i]['Promedio']); ?></td>
							<td style='width: 50px; font-size: 7px; border-bottom: none;'></td>
						</tr><?php  $_p = ($_p + $lstp[$i]['Promedio']);  $s = ($s + 1);} ?>
						<tr>
							<td style='width: 8px; font-size: 13px; border-bottom: none;'>&nbsp;&nbsp;</td>
							<td style='width: 8px; font-size: 13px; border-bottom: none;'>&nbsp;&nbsp;</td>
							<td style='width: 8px; font-size: 13px; border-bottom: none;'>&nbsp;&nbsp;</td>
							<td style='width: 8px; font-size: 13px; border-bottom: none;'>&nbsp;&nbsp;</td>
							<td style='width: 8px; font-size: 13px; border-bottom: none;'>&nbsp;&nbsp;</td>
						</tr>
						<tr>
							<td colspan='5' style='width: 508px; font-size: 4px; border-radius: 0px 0px 5px 5px'>&nbsp;</td>
						</tr>
					</table>


				</td>
			</tr>
		</table>
		<?php $_pxm = ($_p / $s);
		$_pxm = number_format($_pxm, 1, '.', ',');
		?>
		<table style=" margin-left: 20px; margin-top: -3px;">
			<tr>
				<td style="width: 363px; text-align: center; font-size: 12px; border-left: none; border-bottom: none; border-top: none;"></td>
				<td style="width: 128px; text-align: right;  font-size: 9px; border-right: none;"><b>PROMEDIO GENERAL: </b></td>
				<td style="width: 30px; text-align: center;  font-size: 9px; border-right: none;"><b><?php echo $_pxm; ?></b></td>
				<td style="width: 152px; text-align: center;  font-size: 9px;"><b><?php echo promedio_letra_grp($_pxm); ?></b></td>
			</tr>
		</table>
		<table style=" margin-left: 20px; margin-top: 100px;">
			<tr>
				<td style="width: 150px; text-align: center; font-size: 12px; border: none;"></td>
				<td style="width: 551px; text-align: justify;  font-size: 10px; border: none; word-spacing: 2.5px; line-height: 1.6;">
				LA ESCALA DE CALIFICACIONES ES DE 6 A 10, CONSIDERANDO COMO MÍNIMA APROBATORIA 7 (SIETE), ESTE
				CERTIFICADO AMPARA <u> &nbsp;&nbsp;<?php echo $s; ?> &nbsp;&nbsp;</u> MATERIAS DEL PLAN DE ESTUDIOS VIGENTES Y EN CUMPLIMIENTO A LAS
				PREESCRIPCIONES LEGALES SE EXTIENDE EN TUXTLA GUTIÉRREZ, CHIAPAS, A LOS <u>&nbsp;&nbsp; <?php echo $_dia; ?> &nbsp;&nbsp; </u> DÍAS DEL MES DE
				<u>&nbsp;&nbsp; <?php echo $_mes; ?> &nbsp;&nbsp;</u> DEL AÑO <u>&nbsp;&nbsp;<?php echo $_anio; ?>.&nbsp;&nbsp;</u>
				</td>
			</tr>
		</table>

		<br>
		<table style=" margin-left: 95px; margin-top: 50px; text-align: center;">
			<tr>
				<td style='width: 250px; border: none;'>RESPONSABLE DE SERVICIOS<br>ESOLARES DEL PLANTEL</td>
				<td style='width: 40px; border: none;'></td>
				<td style='width: 250px; border: none;'>DIRECTOR GENERAL</td>
			</tr>
			<tr>
				<td style='width: 250px; border: none;'><br><br><br>________________________________________</td>
				<td style='width: 40px; border: none;'></td>
				<td style='width: 250px; border: none;'><br><br><br>________________________________________</td>
			</tr>
			<tr>
				<td style='width: 250px; border: none;'><?php echo $lstfir[0]['Res_serv_esc_plantel']; ?></td>
				<td style='width: 40px; border: none;'></td>
				<td style='width: 250px; border: none;'><?php echo $lstfir[0]['Rector']; ?></td>
			</tr>
		</table>
	</div>

</page>
<?php } else {
	echo "<script type='text/javascript'>window.close();</script>";
} ?>
