<?php
if($_SESSION['Permisos']){
	require_once'../classprint.php';
	$t=new Imprimir();
	$IdAsignacion = $_GET["tokenId"];
	$datMat=$t->get_datMateria($IdAsignacion);

	$datGrupo=$t->get_datGrupo($datMat[0]["IdGrupo"]);
	$lstGrp=$t->get_lstGrupo($IdAsignacion);
	$lstPar=$t->get_no_par($IdAsignacion);
	$tipo = $lstPar[0]['NoParcial'];
	$_texto = $lstPar[0]['_texto'];

    $campus=$t->get_campus_id($datGrupo[0]['IdCampus']);

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
<page backtop="68mm" backbottom="20mm" backleft="10mm" backright="10mm">
	<page_header> <!-- Define el header de la hoja -->
	<img src="../../assets/images/campus/encabezado_formato.jpg" style="width: 100%;" >
    <table style='margin-top: -150px;'>
        <tr>
            <td style='width: 762px; text-align: center; border: none;'>
                <p style='font-size: 14px; color: #343f51;'>
                    <b style='font-size: 30px;'><?php echo $campus[0]['Campus']; ?></b><br>
                INCORPORADA EN LA SECRETARÍA DE EDUCACIÓN ESTATAL<br>
                REGISTRO ANTE DIRECCIÓN GENERAL DE PROFESIONES 070370<br>
                SUPERIOR CLAVE <?php echo $campus[0]['Clave']; ?><br><br>
                <b>ACTA DE CALIFICACIONES</b>
                </p>
            </td>
            <td style='width: 100px; border: none;'></td>
            <td style='width: 180px; text-align: center; border: none;'>
                <img src="../../assets/images/campus/logo_campus_formato.png" style="width: 130px; height: 130px;" >
            </td>
        </tr>
    </table>
    <table style='font-size: 12px; margin-left: 38px; margin-top: 15px;'>
		<tr>
			<td style="width: 100px; text-align: right;"><b>GRUPO:</b></td>
			<td style="width: 375px; "><?php echo $datMat[0]['CveGrupo']; ?></td>
			<td style="width: 100px; text-align: right;"><b>MODALIDAD:</b></td>
			<td style="width: 369px; "><?php echo $datMat[0]['_Modalidad']; ?> - <?php echo $datMat[0]['_Dias']; ?></td>
		</tr>
		<tr>
			<td style="width: 100px; text-align: right;"><b>OFERTA:</b></td>
			<td style="width: 375px; "><?php echo $datMat[0]['Educativa']; ?></td>
			<td style="width: 100px; text-align: right;"><b>MATERIA:</b></td>
			<td style="width: 369px; "><?php echo $datMat[0]['NombreMod']; ?></td>
		</tr>
		<tr>
			<td style="width: 100px; text-align: right;"><b>DOCENTE:</b></td>
			<td style="width: 375px; "><?php echo $datMat[0]['Nombre'].' '.$datMat[0]['APaterno'].' '.$datMat[0]['AMaterno']; ?></td>
			<td style="width: 100px; text-align: right;"><b>PERIODO ESC:</b></td>
			<td style="width: 369px; "><?php echo $datMat[0]['Ciclo']; ?></td>
		</tr>
	</table>
	</page_header>

	<page_footer> <!-- Define el footer de la hoja -->
	<table>
		<tr>
			<td style="width: 520px; text-align: center; border: none;">__________________________________</td>
			<td style="width: 520px; text-align: center; border: none;">__________________________________</td>
		</tr>
		<tr>
			<td style="width: 420px; text-align: center; border: none;">Nombre y Firma del Docente</td>
			<td style="width: 420px; text-align: center; border: none;">Coordinación de Servicios Escolares</td>
		</tr>
	</table><br>
	<img src="../../assets/images/campus/pie_formato.jpg" style="width: 100%;" >
	<table style='font-size: 12px; margin-top: -65px;'>
        <tr>
            <td style='width: 660px; border: none;'>
                <p style='margin-left: 30px; color: #343f51; margin-top: -0px;'>
                <?php echo $campus[0]['Link']; ?><br>
                <?php echo $campus[0]['Direccion']; ?> <br>
                <?php echo $campus[0]['Ciudad']; ?>
                </p>
            </td>
            <td style='width: 400px; text-align: center; font-size: 12px; color: #fff; border: none;'><b>“<?php echo $campus[0]['Lema']; ?>”</b></td>
        </tr>
    </table>
	</page_footer>

	<?php $x= 0; for ($i=0;$i< 1;$i++) { ?>  <!-- Define el cuerpo de la hoja -->
	<table>
			<tr>
				<td style="width: 10px;"><b>No.</b></td>
				<td style="width: 60px;"><b>Matrícula</b></td>
				<td style="width: <?php if($tipo==4){ echo "270px"; } else { echo "678px"; } ?>"><b>Nombre del alumno</b></td>
				<?php if($tipo==4){ ?>
				<td style="width: 90px; text-align: center;"><b>1er <?php echo $_texto; ?></b></td>
				<td style="width: 90px; text-align: center;"><b>2do <?php echo $_texto; ?></b></td>
				<td style="width: 90px; text-align: center;"><b>3er <?php echo $_texto; ?></b></td>
				<td style="width: 90px; text-align: center;"><b>4to <?php echo $_texto; ?></b></td>
				<td style="width: 70px; text-align: center;"><b>Promedio</b></td>
				<td style="width: 80px; text-align: center;"><b>Calificación final</b></td>
				<?php } elseif($tipo == 1){ ?>
				<td style="width: 90px; text-align: center;"><b>1er <?php echo $_texto; ?></b></td>
				<td style="width: 90px; text-align: center;"><b>Calificación final</b></td>
				<?php } ?>
			</tr>
			<?php   for ($i=0;$i< sizeof($lstGrp);$i++) { $x = $x + 1;
				$ex1 = $lstGrp[$i]["E1"];
				if($ex1){
					$promediF = $ex1; $txtP = "Ex";
				} else {
					$promediF = $lstGrp[$i]["Promedio"]; $txtP = "";

				}

				$prom = ($lstGrp[$i]["ParcialF1"] + $lstGrp[$i]["ParcialF2"] + $lstGrp[$i]["ParcialF3"] + $lstGrp[$i]["ParcialF4"]);
				$promedio = ($prom / $tipo);

				?>

			<tr>
				<td style="width: 10px;"><?php echo $x; ?></td>
				<td style="width: 60px;"><?php echo $lstGrp[$i]["Usuario"]; ?></td>
				<td style="width: <?php if($tipo==4){ echo "270px"; } else { echo "678px"; } ?>"><?php echo $lstGrp[$i]["APaterno"].' '.$lstGrp[$i]["AMaterno"].' '.$lstGrp[$i]["Nombre"]; ?></td>
				<?php if($tipo==4){ ?>
				<td style="width: 90px; text-align: center;"><?php echo $lstGrp[$i]["ParcialF1"]; ?></td>
				<td style="width: 90px; text-align: center;"><?php echo $lstGrp[$i]["ParcialF2"]; ?></td>
				<td style="width: 90px; text-align: center;"><?php echo $lstGrp[$i]["ParcialF3"]; ?></td>
				<td style="width: 90px; text-align: center;"><?php echo $lstGrp[$i]["ParcialF4"]; ?></td>
				<td style="width: 70px; text-align: center;"><?php echo round($promedio, 2); ?></td>
				<td style="width: 80px; text-align: center;"><?php echo $promediF; ?> <?php echo $txtP; ?></td>
				<?php } elseif($tipo == 1){ ?>
				<td style="width: 90px; text-align: center;"><?php echo $lstGrp[$i]["ParcialF1"]; ?></td>
				<td style="width: 90px; text-align: center;"><?php echo $promediF; ?> <?php echo $txtP; ?></td>
				<?php } ?>
			</tr>
			<?php } ?>
	</table>


	<!-- Fin del cuerpo de la hoja -->
	<?php } ?>



</page>
<?php } else {
	echo "<script type='text/javascript'>window.close();</script>";
} ?>
