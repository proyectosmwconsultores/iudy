<?php
if($_SESSION['Permisos']){
	include('numeros.php');
	require_once'../portafolio.php';
	$t=new Imprimir();
	$IdAsignacion = $_GET["tokenId"];
	$lstGrp=$t->get_calificacion_grupo_final($IdAsignacion);
	$encabz=$t->get_datos_impresion($IdAsignacion);
	$campus=$t->get_campus_id($lstGrp[0]['IdCampus']);

	$fx = 0;
	$vx = 0;
	if((isset($_GET['x'])) && ($_GET['x'] == 1)){
		$fecha = $encabz[0]['Fecha_impresion'];
		$vx = 1;
	} else { $vx = 0;
		if(isset($encabz[0]['Fec_extra'])){ $fecha = $encabz[0]['Fec_extra']; } else { $fecha = $encabz[0]['Fecha_impresion']; }
	}

    if((isset($_GET['f'])) && ($_GET['f'] == 1)){
			$usx=$t->get_firma($IdAsignacion);
			$fx = 1;
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
    padding: 2px;
}
tr:nth-child(even) {
    background-color: #dddddd;
}

-->
</style>

<!-- page define la hoja con los márgenes señalados -->
<page backtop="60mm" backbottom="20mm" backleft="10mm" backright="10mm">
	<page_header> <!-- Define el header de la hoja -->


	<img src="../../assets/images/campus/hoja_arriba.png" style="width: 100%;" >

	<p style='text-align: center; font-size: 12px;'><b>REPORTE DE CALIFICACIONES</b></p>
		<table style='margin-left: 38px; margin-top: 5px;'>
			<tr>
				<td style="width: 80px; border-bottom: none; border-left: none; border-top: none; border-right: none;"><?php if($encabz[0]['TipoCiclo'] == 'C'){ echo "CUATRIMESTRE"; } else { echo "SEMESTRE"; } ?>:</td>
				<td style="width: 20px; text-align: center; border-left: none; border-top: none; border-right: none;"><?php echo $encabz[0]['Grado']; ?></td>
				<td style="width: 50px; text-align: right; border-bottom: none; border-left: none; border-top: none; border-right: none;">GRUPO:</td>
				<td style="width: 30px; text-align: center; border-left: none; border-top: none; border-right: none;"><?php echo $encabz[0]['Grupo']; ?></td>
				<td style="width: 100px; text-align: right; border-bottom: none; border-left: none; border-top: none; border-right: none;">MODALIDAD:</td>
				<td style="width: 144px; text-align: center; border-left: none; border-top: none; border-right: none;"><?php echo $encabz[0]['_Modalidad']; ?> - <?php echo $encabz[0]['_Dias']; ?></td>
				<td style="width: 80px; text-align: right; border-bottom: none; border-left: none; border-top: none; border-right: none;">NIVEL:</td>
				<td style="width: 120px; text-align: center; border-left: none; border-top: none; border-right: none;"><?php echo $encabz[0]['_Grado']; ?></td>
			</tr>
			<tr>
				<td style="width: 80px; border-bottom: none; border-left: none; border-top: none; border-right: none;">PROGRAMA:</td>
				<td colspan="7" style="border-right: none; width: 500px;"><?php echo $encabz[0]['Educativa']; ?></td>
			</tr>
			<tr>
				<td style="width: 80px; border-bottom: none; border-left: none; border-top: none; border-right: none;">MATERIA:</td>
				<td colspan="7" style="border-right: none; width: 500px;"><?php echo $encabz[0]['NombreMod']; ?></td>
			</tr>
			<tr>
				<td style="width: 80px; border-bottom: none; border-left: none; border-top: none; border-right: none;">DOCENTE:</td>
				<td colspan="7" style="border-right: none; width: 500px;"><?php echo $encabz[0]['Nombre'].' '.$encabz[0]['APaterno'].' '.$encabz[0]['AMaterno']; ?></td>
			</tr>
			<tr>
				<td colspan="3" style="width: 170px; border-bottom: none; border-left: none; border-top: none; border-right: none;">TUXTLA GUTIERRREZ, CHIAPAS; A </td>
				<td colspan="5" style="border-right: none; width: 300px;"><?php echo obt_fec_impresion($fecha); ?></td>
			</tr>


		</table>


	</page_header>

	<page_footer> <!-- Define el footer de la hoja -->

	<img src="../../assets/images/campus/hoja_abajo.png" style="width: 100%;" >

	</page_footer>

	<?php $x= 0; for ($i=0;$i< 1;$i++) { ?>  <!-- Define el cuerpo de la hoja -->
	<table style="font-size: 9px; margin-left: 4px;">
			<tr>
				<td style="width: 15px;"></td>
				<td rowspan='2' style="width: 50px; text-align: center;">NO. CONTROL</td>
				<td rowspan='2' style="width: 288px; text-align: center;">NOMBRE</td>
				<td style="width: 45px;"></td>
				<td style="width: 45px;"></td>
				<td colspan='2' style="width: 100px; text-align: center;">CALIFICACIÓN</td>
				<td style="width: 60px;"></td>
			</tr>
			<tr>
				<td style="width: 15px; text-align: center;">N/P</td>
				<td style="width: 55px; text-align: center;">ASISTENCIA</td>
				<td style="width: 50px; text-align: center;">FALTAS</td>
				<td style="width: 45px; text-align: center;">NÚMERO</td>
				<td style="width: 45px; text-align: center;">LETRA</td>
				<td style="width: 60px; text-align: center;">OBSERVACIÓN</td>
			</tr>
			<?php $colr=''; $prom = 0; for ($y=0;$y< sizeof($lstGrp);$y++) {
				$x = $x + 1; $prom = ($prom + $lstGrp[$y]['Promedio']);
				$_obs = "";
				if($vx == 0){
						if($lstGrp[$y]['E2']){ $_prom = $lstGrp[$y]['E2']; $_obs = "EX"; } elseif($lstGrp[$y]['E1']){ $_prom = $lstGrp[$y]['E1']; $_obs = "EX"; } else { $_prom = $lstGrp[$y]['Promedio']; $_obs = "";}
				} else {
					$_prom = $lstGrp[$y]['Promedio']; $_obs = "";
				}
				 if(($_prom == 5) || ($_prom == 'NP')){ $colr=" color: red;"; } else { $colr=""; }
				 ?>
				<tr>
					<td style="width: 15px; text-align: center;"><?php echo $x; ?>.</td>
					<td style="width: 50px;"><?php echo $lstGrp[$y]['Usuario']; ?></td>
					<td style="width: 288px"><?php echo $lstGrp[$y]['APaterno'].' '.$lstGrp[$y]['AMaterno'].' '.$lstGrp[$y]['Nombre']; ?></td>
					<td style="width: 55px; text-align: center;"><?php echo $lstGrp[$y]['A']; ?></td>
					<td style="width: 45px; text-align: center;"><?php echo $lstGrp[$y]['F']; ?></td>
					<td style="width: 45px; text-align: center; <?php echo $colr; ?>"><?php echo $_prom; ?></td>
					<td style="width: 50px; text-align: center; <?php echo $colr; ?>"><?php if($_prom == 'NP'){ echo 'NP'; } else { echo obtNumLetr($_prom); } ?></td>
					<td style="width: 60px; text-align: center;"><?php echo $_obs; ?></td>
				</tr><?php } $pro_grupo = ($prom / $x);
				$t->get_prom_grupo($IdAsignacion,number_format($pro_grupo, 1, '.', ','));
					$num = (45 - $x);

					for ($g=0;$g< $num;$g++) { $x = ($x + 1);
				 ?>
				 <tr>
 					<td style="width: 15px; text-align: center;"><?php echo $x; ?></td>
 					<td style="width: 50px;"><?php if($g == 0){ echo "************"; } ?></td>
 					<td style="width: 288px"><?php if($g == 0){ echo "************ ************ ************ ************ ************"; } ?></td>
 					<td style="width: 55px;"></td>
 					<td style="width: 45px;"></td>
 					<td style="width: 45px;"></td>
 					<td style="width: 50px;"></td>
 					<td style="width: 60px;"></td>
 				</tr><?php } ?>

	</table>
	<?php if($fx == 0){ ?> <br><br><br><br><br><?php } ?>
	<table style="margin-left: 43px;">
	    <?php if($fx == 1){ ?>
		<tr>
			<td style="width: 85px; text-align: center; border: none; "></td>
			<td style="width: 160px; text-align: center; border: none; "></td>
			<td style="width: 160px; text-align: center; border: none; "></td>
			<td style="width: 160px; text-align: center; border: none; "><img src="https://seuninnova.com/assets/firma/<?php echo $usx[0]['id_paquete']; ?>" style="height: 65px;"></td>
			<td style="width: 85px; text-align: center; border: none; "></td>
		</tr><?php } ?>
		<tr>
			<td style="width: 85px; text-align: center; border: none; "></td>
			<td style="width: 160px; text-align: center; border: none; ">___________________________</td>
			<td style="width: 160px; text-align: center; border: none; ">___________________________</td>
			<td style="width: 160px; text-align: center; border: none; ">___________________________</td>
			<td style="width: 85px; text-align: center; border: none; "></td>
		</tr>
		<tr>
			<td style="width: 85px; text-align: center; border: none; "></td>
			<td style="width: 160px; text-align: center; border: none; font-size: 8px;">Vo.Bo. SERVICIOS ESCOLARES</td>
			<td style="width: 160px; text-align: center; border: none; font-size: 8px;">Vo.Bo. COORDINACIÓN</td>
			<td style="width: 160px; text-align: center; border: none; font-size: 8px;">FIRMA DEL CATEDRÁTICO</td>
			<td style="width: 85px; text-align: center; border: none; "></td>
		</tr>

	</table>

	<!-- Fin del cuerpo de la hoja -->
	<?php } ?>

</page>
<?php } else {
	echo "<script type='text/javascript'>window.close();</script>";
} ?>
