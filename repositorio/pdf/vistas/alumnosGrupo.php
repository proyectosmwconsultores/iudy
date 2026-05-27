<?php
session_start();
if($_SESSION['Permisos']){
	require_once'../classprint.php';
	$t=new Imprimir();
	$IdGrupo = substr($_GET["tokenId"],10,10);
	$datGrp=$t->get_datGrupoId($IdGrupo);
	$lstGrp=$t->get_usuarioIdG($IdGrupo);


	if($datGrp[0]["Turno"] == "M"){ $turno = "MATUTINO"; } elseif($datGrp[0]["Turno"] == "S"){ $turno = "SÁBADO"; }elseif($datGrp[0]["Turno"] == "D"){ $turno = "DOMINGO"; }
	if($datGrp[0]["Modalidad"] == "E"){ $modalidad = "ESCOLARIZADO"; } elseif($datGrp[0]["Modalidad"] == "S"){ $modalidad = "SEMIESCOLARIZADO ".$turno; } elseif($datGrp[0]["Modalidad"] == "D"){ $modalidad = "SEMIESCOLARIZADO ".$turno; } elseif($datGrp[0]["Modalidad"] == "N"){ $modalidad = "SEMIESCOLARIZADO"; }

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
<page backtop="38mm" backbottom="10mm" backleft="10mm" backright="10mm">
	<page_header> <!-- Define el header de la hoja -->
		<div style="margin-left: 37px; margin-top: 20px; ">
			<table>
				<tr>
						<td style="width: 100px; text-align: center;" rowspan="2"><img src="../../assets/images/campus/logo_inicio.png" style="width: 100px;" ></td>
						<td style="width: 400px; text-align: center;"><b>LISTA DE ALUMNOS DEL GRUPO</b></td>
						<td style="width: 80px; text-align: center;" colspan="2">SE-FOR-01</td>
					</tr>
					<tr>
						<td style="text-align: center;"><b>COORDINACION DE SERVICIOS ESCOLARES</b></td>
						<td style="text-align: center;" colspan="2">Página [[page_cu]] de [[page_nb]]</td>
					</tr>
					<tr>
						<td style="width: 100px;"></td>
						<td style="width: 400px; "></td>
						<td style="width: 60px; text-align: center; "></td>
						<td style="width: 60px; text-align: center;"></td>
					</tr>
			</table>

			<table >
				<tr>
					<td style="width: 110px; border: none;"><b>OFERTA EDUCATIVA:</b></td>
					<td style="width: 230px; border: none;"><?php echo $datGrp[0]["Nombre"]; ?></td>
					<td style="width: 70px; text-align: right; border: none;"><b>CAMPUS:</b></td>
					<td style="width: 200px; border: none;"><?php echo $datGrp[0]["Campus"]; ?></td>
				</tr>
				<tr>
					<td style="width: 110px; border: none;"><b>GRUPO:</b></td>
					<td style="width: 230px; border: none;"><?php echo $datGrp[0]["CveGrupo"]; ?></td>
					<td style="width: 70px; text-align: right; border: none;"><b>TURNO:</b></td>
					<td style="width: 200px; border: none;"><?php echo $turno; ?></td>
				</tr>
				<tr>
					<td style="width: 110px; border: none;"><b>MODALIDAD:</b></td>
					<td style="width: 230px; border: none;" colspan="3"><?php echo $modalidad; ?></td>
				</tr>
		</table>
	</div>
	</page_header>

	<page_footer> <!-- Define el footer de la hoja -->

	</page_footer>

	<?php $x= 0; for ($i=0;$i< 1;$i++) { ?>  <!-- Define el cuerpo de la hoja -->
	<table>
			<tr>
				<td style="width: 10px;">NO.</td>
				<td style="width: 100px;">MATRÍCULA</td>
				<td style="width: 450px;">NOMBRE DEL ALUMNO</td>
				<td style="width: 60px;">EDUCACIÓN</td>
			</tr>
			<?php   for ($i=0;$i< sizeof($lstGrp);$i++) { $x = $x + 1; ?>

			<tr>
				<td style="width: 10px;"><?php echo $x; ?></td>
				<td style="width: 60px;"><?php echo $lstGrp[$i]["Usuario"]; ?></td>
				<td style="width: 230px;"><?php echo $lstGrp[$i]["APaterno"].' '.$lstGrp[$i]["AMaterno"].' '.$lstGrp[$i]["Nombre"]; ?></td>
				<td style="width: 40px; text-align: center;"><?php echo $lstGrp[$i]["Educacion"]; ?></td>
			</tr>
			<?php } ?>
	</table>


	<!-- Fin del cuerpo de la hoja -->
	<?php } ?>



</page>
<?php } else {
	echo "<script type='text/javascript'>window.close();</script>";
} ?>
