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

	if($usuario[0]["IdGrado"] == 1) { $txtG = "DOCTORADO"; } elseif($usuario[0]["IdGrado"] == 2){ $txtG = "MAESTRIA"; } elseif($usuario[0]["IdGrado"] == 3){ $txtG = "BACHILLERATO"; }
	if($usuario[0]["IdGrado"] == 3){ if($usuario[0]["IdOferta"] == 9) { $txtG = "PROFESIONALIZACIÓN DE LA ENFERMERIA"; } else { $txtG = "LICENCIATURA"; } }


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
						<td style="width: 90px; text-align: center;" rowspan="2"><img src="../../assets/images/campus/logo_campus.png" style="width: 90px;" ></td>
						<td style="width: 430px; text-align: center; font-size: 15px;" rowspan="2"><br><b>CÉDULA DE INSCRIPCIÓN <?php echo $txtG; ?></b></td>
						<td style="width: 90px; text-align: center;"><b>Folio:<br><?php echo $info[0]["Folio"]; ?></b></td>
					</tr>
					<tr>
						<td style="text-align: center;">Página [[page_cu]] de [[page_nb]]</td>
					</tr>
			</table>





	</div>
	</page_header>

	<page_footer> <!-- Define el footer de la hoja -->


	<table style="margin-left: 38px;">
		<tr>
			<td style="width: 685px; text-align: left;  border: none;"><p style="font-size: 10px;">Acepto los derechos y obligaciones como Alumno <?php echo $_SESSION['sis_small']; ?>.</p><br></td>
		</tr>
		<tr>
			<td style="width: 685px; text-align: center;  border: none;">__________________________________</td>
		</tr>
		<tr>
			<td style="width: 322px; text-align: center; border: none;">Firma del Titular</td>
		</tr>
	</table><br><br><br><br>

	</page_footer>

	<table >
		<tr>
			<td colspan="4" style="background: #cac5c5;">DATOS DE IDENTIFICACIÓN DEL ALUMNO</td>
		</tr>
		<tr>
			<td style="width: 140px; text-align: right; ">Nombre completo:</td>
			<td colspan="3" style="width: 470px;"><?php echo $usuario[0]["APaterno"].' '.$usuario[0]["AMaterno"].' '.$usuario[0]["Nombre"]; ?></td>
		</tr>
		<tr>
			<td style="width: 140px; text-align: right;">Lugar de nacimiento:</td>
			<td colspan="3" style="width: 470px;"><?php echo $info[0]["LugarNac"]; ?></td>
		</tr>
		<tr>
			<td style="width: 140px; text-align: right;">Fecha de nacimiento:</td>
			<td colspan="3" style="width: 470px;"><?php echo $usuario[0]["FecNac"]; ?></td>
		</tr>
		<tr>
			<td style="width: 140px; text-align: right;">Género:</td>
			<td colspan="3" style="width: 470px;"><?php echo $usuario[0]["Sexo"]; ?></td>
		</tr>
		<tr>
			<td style="width: 140px; text-align: right;">CURP:</td>
			<td colspan="3" style="width: 470px;"><?php echo $info[0]["Curp"]; ?></td>
		</tr>

		<tr>
			<td colspan="4" style="border-left: none; border-right: none; "><br></td>
		</tr>
		<tr>
			<td colspan="4" style="background: #cac5c5;">DATOS DE GENERALES</td>
		</tr>
		<tr>
			<td style="width: 140px; text-align: right;">Domicilio:</td>
			<td style="width: 270px;"><?php echo $info[0]["Domicilio"]; ?></td>
			<td style="width: 70px; text-align: right;">CP:</td>
			<td style="width: 150px"><?php echo $info[0]["CP"]; ?></td>
		</tr>
		<tr>
			<td style="width: 140px; text-align: right;">Ciudad:</td>
			<td style="width: 270px;"><?php echo $info[0]["Ciudad"]; ?></td>
			<td style="width: 70px; text-align: right;">País:</td>
			<td style="width: 150px"><?php echo $info[0]["Pais"]; ?></td>
		</tr>
		<tr>
			<td style="width: 140px; text-align: right;">Estado:</td>
			<td style="width: 270px;"><?php echo $info[0]["Estado"]; ?></td>
			<td style="width: 70px; text-align: right;">Celular:</td>
			<td style="width: 150px;"><?php echo $usuario[0]["Telefono"]; ?></td>
		</tr>
		<tr>
			<td style="width: 140px; text-align: right;">Telefono:</td>
			<td colspan="3" style="width: 270px"><?php echo $info[0]["Telefono"]; ?></td>
		</tr>
		<tr>
			<td style="width: 140px; text-align: right;">Email:</td>
			<td colspan="3" style="width: 470px"><?php echo $usuario[0]["Correo"]; ?></td>
		</tr>
		<tr>
			<td colspan="4" style="border-left: none; border-right: none; "><br></td>
		</tr>
		<tr>
			<td colspan="4" style="background: #cac5c5;">DATOS DE LA INSCRIPCIÓN</td>
		</tr>
		<tr>
			<td style="width: 140px; text-align: right;">Carrera:</td>
			<td style="width: 270px;"><?php echo $usuario[0]["Educativa"]; ?></td>
			<td style="width: 70px; text-align: right;">Grupo:</td>
			<td style="width: 150px;"><?php echo $usuario[0]["CveGrupo"]; ?></td>
		</tr>
		<tr>
			<td style="width: 140px; text-align: right;">Nivel:</td>
			<td style="width: 270px; text-transform: uppercase;"><?php echo $usuario[0]["Descripcion"]; ?></td>
			<td style="width: 70px; text-align: right;">Turno:</td>
			<td style="width: 150px;"><?php echo $info[0]["Turno"]; ?></td>
		</tr>
		<tr>
			<td style="width: 140px; text-align: right;">Matricula:</td>
			<td style="width: 270px;"><?php echo $usuario[0]["Usuario"]; ?></td>
			<td style="width: 70px; text-align: right;">Modalidad:</td>
			<td style="width: 150px;"><?php echo $info[0]["Modalidad"]; ?></td>
		</tr>
		<tr>
			<td style="width: 140px; text-align: right;">Fecha de inscripción:</td>
			<td colspan="3" style="width: 270px;"><?php echo $info[0]["FecIns"]; ?></td>
		</tr>
		<tr>
			<td style="width: 140px; text-align: right;">Escuela de procedencia:</td>
			<td colspan="3" style="width: 270px;"><?php echo $info[0]["Procedencia"]; ?></td>
		</tr>
		<tr>
			<td style="width: 140px; text-align: right;">Medio con que conoció a <?php echo $_SESSION['sis_small']; ?>:</td>
			<td style="width: 270px;"><?php echo $info[0]["Medio"]; ?></td>
			<td style="width: 70px; text-align: right;">Otro:</td>
			<td style="width: 150px;"><?php echo $info[0]["Otro"]; ?></td>
		</tr>
		<tr>
			<td style="width: 140px; text-align: right;">Asesor educativo:</td>
			<td colspan="3" style="width: 270px;"><?php echo $info[0]["Asesor"]; ?></td>
		</tr>
		<tr>
			<td colspan="4" style="border-left: none; border-right: none; "><br></td>
		</tr>
		<tr>
			<td colspan="4" style="background: #cac5c5;">EN CASO DE EMERGENCIA</td>
		</tr>
		<tr>
			<td style="width: 140px; text-align: right;">Nombre:</td>
			<td style="width: 270px;"><?php echo $info[0]["ENombre"]; ?></td>
			<td style="width: 70px; text-align: right;">Parentesco:</td>
			<td style="width: 150px;"><?php echo $info[0]["EParentesco"]; ?></td>
		</tr>
		<tr>
			<td style="width: 140px; text-align: right;">Teléfono:</td>
			<td colspan="3" style="width: 270px;"><?php echo $info[0]["ETelefono"]; ?></td>
		</tr>
	</table>
	<br><br>
	<table>
		<tr>
			<td colspan="5" style="background: #cac5c5;">DOCUMENTACION ENTREGADA</td>
		</tr>
		<tr>
			<td rowspan="2" style="width: 20px; text-align: center;">No</td>
			<td rowspan="2" style="width: 350px;">Nombre del documento</td>
			<td colspan="3" style="text-align: center;">ENTREGO</td>
		</tr>
		<tr>
			<td style="width: 80px; text-align: center;">SI</td>
			<td style="width: 80px; text-align: center;">NO</td>
			<td style="width: 80px; text-align: center;">COPIAS</td>
		</tr>
		<?php for ($i=0;$i< sizeof($docs);$i++) { $x = $x + 1; ?>
		<tr>
			<td><?php echo $x; ?></td>
			<td><?php echo $docs[$i]["Nombre"]; ?></td>
			<td style="text-align: center;"><?php if($docs[$i]["Si"] == 1){ echo "x"; } ?></td>
			<td style="text-align: center;"><?php if($docs[$i]["No"] == 1){ echo "x"; } ?></td>
			<td style="text-align: center;"><?php if($docs[$i]["Co"] == 1){ echo "x"; } ?></td>
		</tr>
		<?php } ?>
	</table>






</page>
<?php } else {
	echo "<script type='text/javascript'>window.close();</script>";
} ?>
