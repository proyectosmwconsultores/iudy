<?php
//session_start();
if($_SESSION['Permisos']){
	require_once'../classprint.php';
	$t=new Imprimir();
	$IdAsignacion = $_GET["tokenId"];
	$datMat=$t->get_datMateria($IdAsignacion);
	$datGrupo=$t->get_datGrupo($datMat[0]["IdGrupo"]);
	$lstGrp=$t->get_lstGrupo($IdAsignacion);
	$modalidad = "";
	$turno = "";

	if($datGrupo[0]["Turno"] == "M"){ $turno = "MATUTINO"; } elseif($datGrupo[0]["Turno"] == "S"){ $turno = "SÁBADO"; }elseif($datGrupo[0]["Turno"] == "D"){ $turno = "DOMINGO"; }
	if($datGrupo[0]["Modalidad"] == "E"){ $modalidad = "ESCOLARIZADO"; } elseif($datGrupo[0]["Modalidad"] == "S"){ $modalidad = "SEMIESCOLARIZADO ".$turno; } elseif($datGrupo[0]["Modalidad"] == "D"){ $modalidad = "SEMIESCOLARIZADO ".$turno; } elseif($datGrupo[0]["Modalidad"] == "N"){ $modalidad = "SEMIESCOLARIZADO"; }


	// $datosGrupo=$t->get_datoGrp($datosFolio[0]["IdGrupo"]);
	// $datosPago=$t->get_datoPag($datosFolio[0]["IdPago"]);
	// $campus=$t->get_datoCam($datosFolio[0]["IdCampus"]);

	// if(!$datosFolio[0]["IdPago"]){
	// 	echo "<script type='text/javascript'>window.close();</script>";
	// }
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
<page backtop="52mm" backbottom="10mm" backleft="10mm" backright="10mm">
	<page_header> <!-- Define el header de la hoja -->
		<div style="margin-left: 37px; margin-top: 20px; ">
			<table>
				<tr>
						<td style="width: 200px; text-align: center;" rowspan="2"><img src="../../assets/images/campus/logo_inicio.png" style="width: 140px;" ></td>
						<td style="width: 547px; text-align: center;"><b>MAPA DE REGISTRO</b></td>
						<td style="width: 100px; text-align: center;" colspan="2">SE-FOR-01</td>
					</tr>
					<tr>
						<td style="text-align: center;"><b>COORDINACION DE SERVICIOS ESCOLARES</b></td>
						<td style="text-align: center;" colspan="2">Página [[page_cu]] de [[page_nb]]</td>
					</tr>
					<tr>
						<td style="width: 200px;">Tipo: Formato</td>
						<td style="width: 547px; ">Disposición interno</td>
						<td style="width: 100px; text-align: center; ">Emisión</td>
						<td style="width: 100px; text-align: center;">Revision 2a</td>
					</tr>
					<tr>
						<td style="width: 200px;" >Emitido: Comité de calidad</td>
						<td style="width: 547px; ">Autorización: Rectoria</td>
						<td style="width: 100px; text-align: center; ">20/08/2012</td>
						<td style="width: 100px; text-align: center; ">22/08/2014</td>
					</tr>

			</table>

			<table >
				<tr>
					<td style="width: 110px; border: none;">Materia:</td>
					<td style="width: 230px; border: none;"><?php echo $datMat[0]["NombreMod"]; ?></td>
					<td style="width: 70px; text-align: right; border: none;">Grupo:</td>
					<td style="width: 200px; border: none;"><?php echo $datGrupo[0]["CveGrupo"]; ?></td>
					<td style="width: 100px; text-align: right; border: none;">Periodo:</td>
					<td style="width: 200px; border: none;"><?php echo $datMat[0]["Ciclo"]; ?></td>
				</tr>
				<tr>
					<td style="width: 110px; border: none;">Modalidad:</td>
					<td style="width: 230px; border: none;" colspan="5"><?php echo $modalidad; ?></td>
				</tr>
				<tr>
					<td style="width: 110px; border: none;">Nombre del profesor:</td>
					<td style="width: 230px; border: none;"><?php echo $datMat[0]["Nombre"].' '.$datMat[0]["APaterno"].' '.$datMat[0]["AMaterno"]; ?></td>
					<td style="width: 70px; text-align: right; border: none;"></td>
					<td style="width: 200px; border: none;"></td>
					<td style="width: 100px; text-align: right; border: none;">Turno:</td>
					<td style="width: 200px; border: none;"><?php echo $turno; ?></td>
				</tr>
		</table>
	</div>
	</page_header>

	<page_footer> <!-- Define el footer de la hoja -->

	</page_footer>

	<?php $x= 0; for ($i=0;$i< 1;$i++) { ?>  <!-- Define el cuerpo de la hoja -->
	<table>
			<tr>
				<td style="width: 10px;">No.</td>
				<td style="width: 60px;">Matrícula</td>
				<td style="width: 230px;">Nombre del alumno</td>
				<td style="width: 40px;">Educación</td>
				<td style="width: 200px; text-align: center;" colspan="18">Asistencias e inasistencias</td>
				<td style="width: 45px;">No. Faltas</td>
				<td style="width: 45px;">Promedio</td>
				<td style="width: 80px;">Firma del alumno</td>
			</tr>
			<?php   for ($i=0;$i< sizeof($lstGrp);$i++) { $x = $x + 1; ?>

			<tr>
				<td style="width: 10px;"><?php echo $x; ?></td>
				<td style="width: 60px;"><?php echo $lstGrp[$i]["Usuario"]; ?></td>
				<td style="width: 230px;"><?php echo $lstGrp[$i]["APaterno"].' '.$lstGrp[$i]["AMaterno"].' '.$lstGrp[$i]["Nombre"]; ?></td>
				<td style="width: 40px; text-align: center;"><?php echo $lstGrp[$i]["Educacion"]; ?></td>
				<td style="width: 2px;"></td>
				<td style="width: 2px;"></td>
				<td style="width: 2px;"></td>
				<td style="width: 2px;"></td>
				<td style="width: 2px;"></td>
				<td style="width: 2px;"></td>
				<td style="width: 2px;"></td>
				<td style="width: 2px;"></td>
				<td style="width: 2px;"></td>
				<td style="width: 2px;"></td>
				<td style="width: 2px;"></td>
				<td style="width: 2px;"></td>
				<td style="width: 2px;"></td>
				<td style="width: 2px;"></td>
				<td style="width: 2px;"></td>
				<td style="width: 2px;"></td>
				<td style="width: 2px;"></td>
				<td style="width: 2px;"></td>
				<td style="width: 45px;"></td>
				<td style="width: 45px;"></td>
				<td style="width: 80px;"></td>
			</tr>
			<?php }
			for ($g=$x;$g< 20;$g++) { $x = $x + 1;
			 ?>
				<tr>
				<td style="width: 10px;"><?php echo $x; ?></td>
					<td style="width: 60px;"></td>
					<td style="width: 230px;"></td>
					<td style="width: 40px;"></td>
					<td style="width: 2px;"></td>
					<td style="width: 2px;"></td>
					<td style="width: 2px;"></td>
					<td style="width: 2px;"></td>
					<td style="width: 2px;"></td>
					<td style="width: 2px;"></td>
					<td style="width: 2px;"></td>
					<td style="width: 2px;"></td>
					<td style="width: 2px;"></td>
					<td style="width: 2px;"></td>
					<td style="width: 2px;"></td>
					<td style="width: 2px;"></td>
					<td style="width: 2px;"></td>
					<td style="width: 2px;"></td>
					<td style="width: 2px;"></td>
					<td style="width: 2px;"></td>
					<td style="width: 2px;"></td>
					<td style="width: 2px;"></td>
					<td style="width: 45px;"></td>
					<td style="width: 45px;"></td>
					<td style="width: 80px;"></td>
				</tr>
			<?php } ?>
			<tr>
				<td colspan="23" style="width: 250px; text-align: right;">Promedio Grupal:</td>
				<td colspan="2" style="width: 100px;"></td>
			</tr>
	</table>
	<p style="font-size: 10px;">* Una vez entregada las calificaciones de cada alumno, este debera firmar de conformidad el mapa de registro, dicho mapa sera turnado a coordinacion de servicios escolares con copia.</p>
	<table>
		<tr>
			<td style="width: 322px; text-align: center; border: none;">__________________________________</td>
			<td style="width: 322px; text-align: center; border: none;">__________________________________</td>
			<td style="width: 322px; text-align: center; border: none;">__________________________________</td>
		</tr>
		<tr>
			<td style="width: 322px; text-align: center; border: none;">Profesor</td>
			<td style="width: 322px; text-align: center; border: none;">Representante de grupo</td>
			<td style="width: 322px; text-align: center; border: none;">Coordinacion de Servicios Escolares</td>
		</tr>
	</table>

	<!-- Fin del cuerpo de la hoja -->
	<?php } ?>



</page>
<?php } else {
	echo "<script type='text/javascript'>window.close();</script>";
} ?>
