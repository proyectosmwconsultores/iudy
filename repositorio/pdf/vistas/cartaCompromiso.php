<?php
session_start();
if($_SESSION['Permisos']){
	require_once'../classprint.php';
	$t=new Imprimir();
	$IdUsua = substr($_GET["idToks"], 10,10);

	$usuario=$t->getId_usuarioId($IdUsua);
	$info=$t->getId_usuarioInfo($IdUsua);
	$docs=$t->getId_doscInfo($IdUsua);
	$_SESSION["nomDocs"] = $usuario[0]["Usuario"];

	if($usuario[0]["IdGrado"] == 1) { $txtG = "DOCTORADO"; $nvel = "Maestría"; } elseif($usuario[0]["IdGrado"] == 2){ $txtG = "MAESTRIA"; $nvel = "Licenciatura"; } elseif($usuario[0]["IdGrado"] == 3){ $txtG = "LICENCIATURA"; $nvel = "Bachillerato"; }




	if(!$IdUsua){
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
		font-size: 10px;
}

td, th {
    border: 1px solid #dddddd;
    padding: 4px;
}
tr:nth-child(even) {
    background-color: #dddddd;
}

-->
</style>

<!-- page define la hoja con los márgenes señalados -->
<page backtop="30mm" backbottom="30mm" backleft="10mm" backright="10mm">
	<page_header> <!-- Define el header de la hoja -->
		<div style="margin-left: 37px; margin-top: 20px; ">
			<table>
				<tr>
						<td style="width: 90px; text-align: center;"><img src="../../assets/images/campus/logo_inicio.png" style="width: 140px;" ></td>
						<td style="width: 532px; text-align: right; font-size: 15px;"><br><b>CARTA COMPROMISO <?php echo $txtG; ?></b></td>
					</tr>
			</table>





	</div>
	</page_header>

	<page_footer> <!-- Define el footer de la hoja -->


	<table style="margin-left: 38px;">

		<tr>
			<td style="width: 685px; text-align: center;  border: none;">__________________________________</td>
		</tr>
		<tr>
			<td style="width: 322px; text-align: center; border: none;">Alumno o Tutor</td>
		</tr>
	</table><br><br><br><br>

	</page_footer>

	<table style="font-size: 12px;">
		<tr>
			<td colspan="4" style="background: #cac5c5;">DATOS DEL ALUMNO</td>
		</tr>
		<tr>
			<td style="width: 140px; text-align: right; ">El alumno:</td>
			<td colspan="3" style="width: 470px;"><?php echo $usuario[0]["APaterno"].' '.$usuario[0]["AMaterno"].' '.$usuario[0]["Nombre"]; ?></td>
		</tr>
		<tr>
			<td style="width: 140px; text-align: right;">Inscrito a:</td>
			<td colspan="3" style="width: 470px;"><?php echo $usuario[0]["Educativa"]; ?></td>
		</tr>
		<tr>
			<td style="width: 140px; text-align: right;">Nivel de estudios:</td>
			<td colspan="3" style="width: 470px; text-transform: uppercase;"><?php echo $usuario[0]["Descripcion"]; ?></td>
		</tr>
		<tr>
			<td style="width: 140px; text-align: right;">Modalidad:</td>
			<td colspan="3" style="width: 470px;"><?php echo $info[0]["Modalidad"]; ?></td>
		</tr>
		<tr>
			<td style="width: 140px; text-align: right;">Con número de matrícula:</td>
			<td colspan="3" style="width: 470px;"><?php echo $usuario[0]["Usuario"]; ?></td>
		</tr>

		<tr>
			<td style="width: 140px; border-left: none; border-right: none;"></td>
			<td style="width: 270px; border-right: none;"></td>
			<td style="width: 70px; text-align: right; border-right: none;"></td>
			<td style="width: 150px; border-right: none;"></td>
		</tr>
		<tr>
			<td colspan="4" style="border: none; "><br></td>
		</tr>
		<tr>
			<td colspan="4" style="border: none; font-size: 15px; text-align: justify; ">
				Entregó los siguientes documentos al Asesor Educativo de la <?php echo $_SESSION['sis_long']; ?> de inscribirse
				adecuadamente con base a la normalidad de la Institución y de la Secretaría de Educación.<br><br>
				Con el conocimiento de que tendrá tres semanas una vez iniciado el ciclo escolar al que figure
				inscrito para entregar la documentación pendiente, caso contrario causará baja y no tendrá
				derecho a devolución por concepto de inscripción y/o pagos de colegiaturas.
			</td>
		</tr>
	</table>
	<br><br>
	<table style="font-size: 12px;">
		<tr>
			<td colspan="5" style="background: #cac5c5;">DOCUMENTACION ENTREGADA</td>
		</tr>
		<tr>
			<td rowspan="2" style="width: 20px; text-align: center;">No</td>
			<td rowspan="2" style="width: 345px;">Nombre del documento</td>
			<td colspan="3" style="text-align: center;">ENTREGO</td>
		</tr>
		<tr>
			<td style="width: 80px; text-align: center;">SI</td>
			<td style="width: 80px; text-align: center;">NO</td>
			<td style="width: 80px; text-align: center;">COPIAS</td>
		</tr>
		<?php for ($i=0;$i< sizeof($docs);$i++) { $x = $x + 1; ?>
		<tr>
			<td style="text-align: center;"><?php echo $x; ?></td>
			<td><?php echo $docs[$i]["Nombre"]; ?></td>
			<td style="text-align: center;"><?php if($docs[$i]["Si"] == 1){ echo "x"; } ?></td>
			<td style="text-align: center;"><?php if($docs[$i]["No"] == 1){ echo "x"; } ?></td>
			<td style="text-align: center;"><?php if($docs[$i]["Co"] == 1){ echo "x"; } ?></td>
		</tr>
		<?php } ?>
	</table>
<br><br>
	<table >
		<tr>
			<td style=" border: none; font-size: 15px; text-align: justify; ">
			<p style="text-align: justify; ">
				Estoy de acuerdo que de no cumplir con todos los requisitos para la obtención del título de
				<?php echo $usuario[0]["Descripcion"]; ?> de la <?php echo $_SESSION['sis_long']; ?> no tienen ninguna responsabilidad legal ya que eso me
				corresponde a mi y a la Escuela de donde egresé del nivel <?php echo $nvel; ?>.<br><br>
				Los trámites se iniciarán de acuerdo a la fecha de las convocatorias establecidas por la <?php echo $_SESSION['sis_long']; ?>.
				</p>
			</td>
		</tr>
	</table>







</page>
<?php } else {
	echo "<script type='text/javascript'>window.close();</script>";
} ?>
