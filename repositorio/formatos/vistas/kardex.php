<?php
require_once '../class_formatos.php';
include("../hace_fecha.php");
//include("hace.php");
$formx = new Formatos();
$IdUsua = substr($_GET['idToks'], 10, 10);
//$IdCiclo = substr($_GET['idCiclo'], 10, 10);


$cal = $formx->obtener_lista_materias($IdUsua);
$rvoe = $formx->get_datos_campus_rvoe($IdUsua);
$user = $formx->get_alumno_id($IdUsua);


$_cert = $formx->obtener_datos_certificado($IdUsua);
$dispo = 0;

if($_cert[0]['IdCiclo'] > 0){
   $kardex = $formx->get_kardex_alumno_id_especial($IdUsua);    
   $dispo = 1;
} else {
   $kardex = $formx->get_kardex_alumno_id($IdUsua);
}



$creditos = $formx->get_total_creditos($rvoe[0]['IdOferta'],$rvoe[0]['id_campus'],$user[0]['Termino']);
$promedio = $formx->get_promedio_alumno_id($IdUsua);

// $user = $formx->get_boleta_id($IdUsua,$IdCiclo);
if($kardex[0]['TipoCiclo'] == 'S'){ $tp = 'SEMESTRE'; } elseif($kardex[0]['TipoCiclo'] == 'C'){ $tp = 'CUATRIMESTRE'; } else { $tp = 'TRIMESTRE'; }
if($rvoe[0]['_logoPdf']){
	$imagen = $rvoe[0]['_logoPdf'];
} else {
	$imagen = "logo_pdf_1.png";
}

if(!isset($cal[0]['IdUsua'])){
	echo "<script type='text/javascript'>window.close();</script>";
    exit();
	}
	
	
?>


<!-- page define la hoja con los márgenes señalados -->
<page backtop="40mm" backbottom="10mm" backleft="10mm" backright="10mm">
	<page_header> <!-- Define el header de la hoja -->
	<img src="../../assets/images/campus/<?php echo $imagen; ?>" style="width: 140px; position: absolute; margin-top: 30px; margin-left: 30px;">
	<table style="position: absolute; margin-left:36px; margin-top: 30px; font-size: 9px; text-align: center; font-weight: bold;">
		<tr>
			<td style="width: 690px; font-size: 14px;">
				<?php echo $rvoe[0]['_titulo']; ?><br>
				<b style="font-size: 12px; margin-top: 1px;">DIRECCIÓN DE SERVICIOS ESCOLARES</b><br>
				<b style="font-size: 12px; margin-top: 1px;">KARDEX DE CALIFICACIONES</b>
			</td>
		</tr>
	</table><br>
	<table style="margin-left:38px; font-size: 10px; border-collapse: collapse;">
		<tr>
			<td style="border: 0.5px solid #1d3462; width: 50px; text-align: left; padding: 5px; border-right: none; border-bottom: none;"><b>NOMBRE:</b></td>
			<td style="border: 0.5px solid #1d3462; width: 374px; text-align: left; padding: 5px; border-right: none; "><?php echo $user[0]['APaterno'].' '.$user[0]['AMaterno'].' '.$user[0]['Nombre']; ?></td>
			<td style="border: 0.5px solid #1d3462; width: 90px; text-align: right; padding: 5px; border-right: none; border-bottom: none; "><b>MATRICULA:</b> </td>
			<td style="border: 0.5px solid #1d3462; width: 100px; text-align: left; padding: 5px;"><?php echo $user[0]['Usuario']; ?></td>
		</tr>
		<tr>
			<td style="border: 0.5px solid #1d3462; width: 50px; text-align: left; padding: 5px; border-right: none; "><b>CARRERA:</b></td>
			<td style="border: 0.5px solid #1d3462; width: 374px; text-align: left; padding: 5px; border-right: none;"><?php echo $rvoe[0]['Educativa']; ?></td>
			<td style="border: 0.5px solid #1d3462; width: 90px; text-align: right; padding: 5px; border-right: none;"><b>MODALIDAD:</b> </td>
			<td style="border: 0.5px solid #1d3462; width: 100px; text-align: left; padding: 5px;"><?php echo $rvoe[0]['Modalidad']; ?></td>
		</tr>
	</table>

		<!-- <img src="../../assets/images/campus/fondo.jpg" style="width:100%" ;> -->
<!-- <div style="background: red; width: 100px; height: 100px; margin-top: -970px;">
hola
</div> -->
	</page_header>
	<page_footer>
		<table style="border-collapse: collapse; font-size: 11px; margin-left: 38px;">
			<tr>
				<td style="width: 533px;">FECHA DE IMPRESIÓN: <?php echo obtFechMay(date("Y-m-d")); ?> </td>
				<td style="width: 160px; text-align: right;">PÁGINA [[page_cu]] de [[page_nb]]</td>
			</tr>
		</table><br><br>
	</page_footer>
	

	

	<table style="margin-left: 0px; margin-top: 20px; font-size: 10px; border-collapse: collapse;">
		
		<?php $sumCred = 0; $ci = 0; $cf = 0; for ($i=0;$i< sizeof($kardex);$i++) { 
		    if($dispo == 0){ $ci = $kardex[$i]['IdCiclo']; } else { $ci = $kardex[$i]['Grado'];  }
		    //$ci = $kardex[$i]['IdCiclo']; 
		
		    if($kardex[$i]['Promedio'] >=6){
			    $cred = $kardex[$i]['Creditos'];
			} else {
			    $cred = 0;
			}
			$descr = '';
			
			if($kardex[$i]['Observacion'] == "R"){ $descr = 'RECURSADO';  }
			if($kardex[$i]['Observacion'] == "E"){ $descr = 'E.E.';  }
			if($kardex[$i]['_obs'] == "E"){ $descr = 'E.E.';  }
			
			if($kardex[$i]['Promedio'] <= 5 ){ $descr = 'REPROBADO'; $cred = 0; } 
			
		$sumCred = ($sumCred + $cred);
		
		
			if($ci <> $cf){ 
			
			
			
			
			
			
			?>
		<tr>
			<td colspan="4" style="border: 0.5px solid #1d3462; width: 600px; text-align: center; padding: 5px;"><b><?php echo $tp; ?> 
			<?php if($dispo == 1){
			$cicx = $formx->obtener_ciclo_impresion($_cert[0]['IdCiclo'],$ci);
			echo $cicx[0]['Ciclo'];
			?>
			
			<?php } else { ?>
			
			<?php echo $kardex[$i]['Ciclo']; ?>
			
			<?php } ?>
			
			
			
			</b></td>
		</tr>
		<tr style="background: #ccc4c4;">
			<td style="border: 0.5px solid #1d3462; width: 390px; text-align: left; padding: 5px;"><b>NOMBRE DE LA MATERIA</b></td>
			<td style="border: 0.5px solid #1d3462; width: 80px; text-align: center; padding: 5px;"><b>CALIFICACION</b></td>
			<td style="border: 0.5px solid #1d3462; width: 40px; text-align: center; padding: 5px;"><b>CREDITOS</b></td>
			<td style="border: 0.5px solid #1d3462; width: 100px; text-align: center; padding: 5px;"><b>OBSERVACIONES</b></td>
		</tr>
			<?php }
			?>
			<tr>
			<td style="border: 0.5px solid #1d3462; width: 390px; text-align: left; padding: 5px;"><?php echo $kardex[$i]['CodeModulo']; ?> <?php echo $kardex[$i]['NombreMod']; ?></td>
			<td style="border: 0.5px solid #1d3462; width: 80px; text-align: center; padding: 5px;"><?php echo $kardex[$i]['Promedio']; ?>.0</td>
			<td style="border: 0.5px solid #1d3462; width: 40px; text-align: center; padding: 5px;"><?php echo $cred; ?></td>
			<td style="border: 0.5px solid #1d3462; width: 100px; text-align: center; padding: 5px;"><?php echo $descr; ?></td>
		</tr>
		<?php  if($dispo == 0){ $cf = $kardex[$i]['IdCiclo']; } else { $cf = $kardex[$i]['Grado'];  }   } ?>
		<tr>
			<td colspan="4" style="border-left: none; border-right: none; width: 600px; text-align: right; padding: 5px;"></td>
		</tr>
		<tr>
			<td colspan="4" style="border: none; width: 600px; text-align: right; padding: 5px; font-size: 12px;">
			    <?php if($user[0]['IdOferta'] == 30){ ?>
			    <b><?php if($user[0]['Termino'] > 1){ echo $sumCred.' CRÉDITOS DE UN TOTAL DE '.$creditos[0]['Total']; } else { echo "<b style='color: red;'>  CRÉDITOS NO DISPONIBLES, DEBE DE INDICAR LA TERMINACIÓN DE LA CARRERA.</b>";} ?> </b>
			    <?php } else { ?>
			    <b><?php echo $sumCred; ?> CRÉDITOS DE UN TOTAL DE   <?php echo $creditos[0]['Total']; ?> </b>
			    <?php } ?>
			    
		    </td>
		</tr>
		<tr>
			<td colspan="4" style="border: none; width: 600px; text-align: right; padding: 5px; font-size: 12px;">
			    <b>PROMEDIO FINAL: <?php echo bcdiv($promedio[0]['Promedio'], 1, 1); ?> </b>
			    
		    </td>
		</tr>
	</table>
	<p style="font-size: 12px; margin-top: -30px;">
	    <b>Válida:</b><br><br>

_____________________________________<br>
<b>Rosaura Ramón de la Fuente<br>
Directora de Gestión Escolar y Titulación</b>

	</p>
</page>