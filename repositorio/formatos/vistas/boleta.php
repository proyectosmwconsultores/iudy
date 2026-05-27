<?php
require_once '../class_formatos.php';
include("../hace_fecha.php");
//include("hace.php");
$formx = new Formatos();
$IdUsua = substr($_GET['idToks'], 10, 10);
$IdCiclo = substr($_GET['idCiclo'], 10, 10);


$cal = $formx->obtener_lista_materias($IdUsua);
$rvoe = $formx->get_datos_campus_rvoe($IdUsua);
$user = $formx->get_boleta_id($IdUsua,$IdCiclo);
if($user[0]['TipoCiclo'] == 'S'){ $tp = 'SEMESTRE'; } elseif($user[0]['TipoCiclo'] == 'C'){ $tp = 'CUATRIMESTRE'; } else { $tp = 'TRIMESTRE'; }

?>


<!-- page define la hoja con los márgenes señalados -->
<page backtop="10mm" backbottom="10mm" backleft="10mm" backright="10mm">
	<page_header> <!-- Define el header de la hoja -->
		<img src="../../assets/images/campus/fondo.jpg" style="width:101%" ;>

	</page_header>
	<page_footer>
		
	</page_footer>
	<table style="margin-left: 0px; margin-top: 0px; font-size: 9px; text-align: center; font-weight: bold;">
		<tr>
			<td style="width: 140px; font-size: 16px; text-align: left; border: none;">
				<img src="../../assets/images/campus/<?php echo $rvoe[0]['_logoPdf']; ?>" style="width: 140px;">
			</td>
			<td style="width: 509px; font-size: 17px; border: none;">
				<?php echo $rvoe[0]['_titulo']; ?><br><br>
				<b style="font-size: 14px;">BOLETA DE CALIFICACIÓN FINAL</b>
			</td>
		</tr>
	</table>

	<table style="margin-left: 0px; margin-top: 10px; font-size: 10px; border-collapse: collapse;">
		<tr>
			<td colspan="2" style="border: 0.5px solid #1d3462; width: 540px; text-align: left; padding: 5px;"><b><?php echo $rvoe[0]['Educativa']; ?></b></td>
		</tr>
		<tr>
			<td style="border: 0.5px solid #1d3462; width: 440px; text-align: left; padding: 5px;"><b>NOMBRE:</b> <?php echo $user[0]['APaterno'].' '.$user[0]['AMaterno'].' '.$user[0]['Nombre']; ?></td>
			<td style="border: 0.5px solid #1d3462; width: 185px; text-align: left; padding: 5px;"><b>MATRICULA:</b> <?php echo $user[0]['Usuario']; ?></td>
		</tr>
		<tr>
			<td style="border: 0.5px solid #1d3462; width: 440px; text-align: left; padding: 5px;"><b>PERIODO ESCOLAR:</b> <?php echo $user[0]['Ciclo']; ?></td>
			<td style="border: 0.5px solid #1d3462; width: 185px; text-align: left; padding: 5px;"><?php echo $user[0]['Grado']; ?>° <?php echo $tp; ?></td>
		</tr>
	</table>

	<table style="margin-left: 0px; margin-top: 20px; font-size: 10px; border-collapse: collapse;">
		<tr style="background: #ccc4c4;">
			<td rowspan="2" style="border: 0.5px solid #1d3462; width: 363px; text-align: left; padding: 5px;"><b>NOMBRE DE LA MATERIA</b></td>
			<td colspan="2" style="border: 0.5px solid #1d3462; width: 110px; text-align: center; padding: 5px;"><b>CALIFICACIONES</b></td>
			<td rowspan="2" style="border: 0.5px solid #1d3462; width: 100px; text-align: center; padding: 5px;"><b>OBSERVACIONES</b></td>
		</tr>
		<tr style="background: #ccc4c4;">
			<td style="border: 0.5px solid #1d3462; width: 60px; text-align: center; padding: 5px;"><b>CIFRA</b></td>
			<td style="border: 0.5px solid #1d3462; width: 60px; text-align: center; padding: 5px;"><b>LETRA</b></td>
		</tr>
		<?php $cs1 = 0; $v = 0; $cxl1 = 0; for ($i=0;$i< sizeof($user);$i++) {  $cs1 = ($cs1+1); 
			$p1 = $user[$i]["Promedio"];
			$p1 = intval($p1);
			if($p1 <= 5){
			   $v = 1;
			}
			?>
		<tr>
			<td style="border: 0.5px solid #1d3462; width: 363px; text-align: left; padding: 5px;"><?php echo $user[$i]['NombreMod']; ?></td>
			<td style="border: 0.5px solid #1d3462; width: 60px; text-align: center; padding: 5px;"><?php echo $user[$i]['Promedio']; ?></td>
			<td style="border: 0.5px solid #1d3462; width: 60px; text-align: center; padding: 5px;"><?php echo obtener_prom_letra($user[$i]['Promedio']); ?></td>
			<td style="border: 0.5px solid #1d3462; width: 100px; text-align: center; padding: 5px;"><?php echo $user[$i]['Observacion']; ?></td>
		</tr>
		<?php $cxl1 = ($p1 + $cxl1); } ?>
	</table>
	<?php 
	$px = 0;
	if($cxl1){ $prom = ($cxl1/$cs1); }
	?>
	<table style="margin-left: 213px; font-size: 12px; border-collapse: collapse;">
		<tr>
			<td style="border: 0.5px solid #1d3462; width: 150px; text-align: right; padding: 5px;"><b>PROMEDIO GENERAL:</b></td>
			<td style="border: 0.5px solid #1d3462; width: 263px; text-align: center; padding: 5px;"><b>
			<?php
			if($v == 0){
		echo $px = number_format($prom, 1, '.', ',');
			echo ' ('.promedio_letra_grp_nuevo($px).')';
			} else { echo "<b style='color: red;'>----------</b>";}
			 ?>
			</b></td>
		</tr>
	</table>


	<p style="margin-top: 30px; font-size: 12px;">
	Este documento no es válido si presenta raspaduras o enmendaduras. La escala de calificaciones es de 6 a 10 calificación
mínima aprobatoria: 6.
	</p>



	<!-- Fin del cuerpo de la hoja -->




</page>