<?php
require_once '../class_formatos.php';
include("../hace_fecha.php");
//include("hace.php");
$formx = new Formatos();
$Id = $_GET['idToks'];
//$IdCiclo = substr($_GET['idCiclo'], 10, 10);
$valor = 0;
if(isset($_GET['x'])){
    $valor = 1;
}


$datos = $formx->get_datos_constancia($Id);
$promedio = $formx->get_promedio_id($datos[0]['IdUsua']);
$firma = $formx->get_firma_gestion(708);
$lst = $formx->get_materias_activas($datos[0]['IdUsua'],$datos[0]['IdCiclo']);


if(!isset($datos[0]['IdUsua'])){
    header('Location: https://sciudy.com/');
}


?>


<!-- page define la hoja con los márgenes señalados -->
<?php if($datos[0]['IdVisto'] == 2){  ?>
<page backtop="40mm" backbottom="70mm" backleft="10mm" backright="10mm">
<?php } else { ?>
<page backtop="40mm" backbottom="10mm" backleft="10mm" backright="10mm">
<?php } ?>

	<page_header> <!-- Define el header de la hoja -->
	
	<img src="../../assets/images/campus/constancia.jpg" style="width: 100%;">	    

	
	</page_header>
	<page_footer>
		<table style="border-collapse: collapse; font-size: 11px; margin-left: 38px;">
			<tr>
				<td style="width: 533px;">
				    <p>
	        <div style='width: 350px;'>
	            <img src="../../assets/images/qr/<?php echo $datos[0]['Anio']; ?>/<?php echo $datos[0]['Mes']; ?>/<?php echo $Id; ?>.png" style="width: 80px;"><br>	    
	            
	        Cadena Original de Sello Digital:<br>
	        ||<?php echo obtFechMay($datos[0]['FecAprobado']); ?> |<?php echo $datos[0]['Usuario']; ?> |CONSTANCIA DE ESTUDIOS |RVOE <?php echo $datos[0]['Rvoe']; ?> ||
	        <br>
	        <p><b>C.c.p. Archivo</b></p>
	        <br><br>
	    </div>
	        
	    </p>
		</td>
				<td style="width: 160px; text-align: right;"><br><br><br><br><br><br><br></td>
			</tr>
		</table>
		<p style='text-align: right; font-size: 11px; margin-right: 35px;'>PÁGINA [[page_cu]] DE [[page_nb]]</p>
		<br><br><br><br><br>
	</page_footer><br>
	<p style='text-align: right;'>
	    <table>
	        <tr>
	            <td style='width: 356px;'></td>
	            <td style='text-align: center; width: 300px; border: 3px solid #254367; padding: 5px; border-radius: 5px;'>ASUNTO: CONSTANCIA DE ESTUDIOS</td>
	        </tr>
	    </table>
	    
	    </p>
	<p>
		<b>A QUIEN CORRESPONDA:</b>
	</p>
	<p style='text-align: justify; line-height: 25px;'>
	    La que suscribe, hace constar que según documentos que existen en el archivo escolar, el  C.  <b> <?php echo $datos[0]['Nombre']; ?> 
<?php echo $datos[0]['APaterno']; ?> <?php echo $datos[0]['AMaterno']; ?> </b> con matrícula <b> <?php echo $datos[0]['Usuario']; ?></b>, actualmente cursa el <u> <?php echo $datos[0]['Grado']; ?>°  CUATRIMESTRE </u> de
la <b> <u> <?php echo $datos[0]['Educativa']; ?></u></b>, con RVOE acuerdo

<u> <?php echo $datos[0]['Rvoe']; ?> </u> , en el período comprendido de
<?php echo obtFechConst($datos[0]['FInicio']); ?>  al <?php echo obtFechConst($datos[0]['FFinal']); ?>,  <?php if(isset($datos[0]['Vacacional'])){ echo $datos[0]['Vacacional'].', '; } ?> 
sumando promedio general de <?php echo bcdiv($promedio[0]['Promedio'], 1, 1); ?>.
	</p>
	<p style='text-align: justify; line-height: 25px;'>
	    <?php if($datos[0]['IdVisto'] == 2){ echo "A continuación, en página 2 se mencionan las materias cursadas.<br><br>"; } ?>
	    
	    <?php 
	    $_dia = letra_dia(substr($datos[0]['FecAprobado'], 8, 2));
	 $_mes = letra_mes($datos[0]['FecAprobado']);
	 $_anio = letra_anio(substr($datos[0]['FecAprobado'], 0, 4));
	 
	 
	    ?>
	    Se extiende la presente en la ciudad de Villahermosa, Tabasco a los 
	    <?php echo strtolower($_dia); ?> días del mes <?php echo strtolower($_mes); ?>
	    del año <?php echo strtolower($_anio); ?>, para los fines que convengan a (el)la interesado(a).  
	</p>

	<table style="margin-left: 0px; margin-top: 50px; font-size: 13px; border-collapse: collapse; line-height: 18px;">
		
		<tr>
			<td style="text-align: center; width: 640px; padding: 5px;">
			<b>ATENTAMNENTE</b><br>
			“<i>EDUCACIÓN CON VALOR</i>”<br><br><br><br><br><br>
			<b>
			<?php echo $firma[0]['Nombre'].' '.$firma[0]['APaterno'].' '.$firma[0]['AMaterno']; ?><br><?php echo $firma[0]['Cargo']; ?><br><i>Campus Tabasco</i>
			
			</b>
			
			</td>
		</tr>
		<?php if($valor == 0){ ?>
		<tr>
			<td style="text-align: center; width: 640px; padding: 5px;">
				<img src="../../assets/images/campus/sello.png" style="width:150px; margin-top: -150px; margin-left: 350px;" ;>
			</td>
		</tr>
		<tr>
			<td style="text-align: center; width: 640px; padding: 5px;">
				<?php if($firma[0]['id_paquete']){ ?>
					<img src="../../assets/firma/<?php echo $firma[0]['id_paquete']; ?>" style="width:200px; margin-top: -160px;" ;>
				<?php }?>
				
			</td>
		</tr><?php } ?>
	</table>
	<p>
	    
	    
	    <?php
	    if($datos[0]['IdVisto'] == 2){
	        
	        
	    $IdUsua = $datos[0]['IdUsua']; 
	    $IdCiclo = $datos[0]['IdCiclo']; 
	    
	    if($datos[0]['Tipo'] == 'N'){
	        $kardex = $formx->get_kardex_alumno_id($IdUsua);    
	    } else {
	        $kardex = $formx->get_kardex_alumno_personz_id($IdUsua);
	    }
	    

$creditos = $formx->get_total_creditos($datos[0]['IdOferta'],$datos[0]['IdCampus']);
$promedio = $formx->get_promedio_alumno_id($IdUsua);

 $user = $formx->get_boleta_id($IdUsua,$IdCiclo);
if($kardex[0]['TipoCiclo'] == 'S'){ $tp = 'SEMESTRE'; } elseif($kardex[0]['TipoCiclo'] == 'C'){ $tp = 'CUATRIMESTRE'; } else { $tp = 'TRIMESTRE'; }
if($rvoe[0]['_logoPdf']){
	$imagen = $rvoe[0]['_logoPdf'];
} else {
	$imagen = "logo_pdf_1.png";
}
	    
	    ?>
	    
	    
	    <p>
	        <br>
	        
	        <table style="margin-left:0px;  font-size: 9px; text-align: center; font-weight: bold;">
		<tr>
			<td style="width: 690px; font-size: 14px;">
				<?php echo $rvoe[0]['_titulo']; ?><br>
				<b style="font-size: 12px; margin-top: 1px;">DIRECCIÓN DE SERVICIOS ESCOLARES</b><br>
				<b style="font-size: 12px; margin-top: 1px;">KARDEX DE CALIFICACIONES</b>
			</td>
		</tr>
	</table><br>
	<table style="margin-left:0px; font-size: 10px; border-collapse: collapse;">
		<tr>
			<td style="border: 0.5px solid #1d3462; width: 50px; text-align: left; padding: 5px; border-right: none; border-bottom: none;"><b>NOMBRE:</b></td>
			<td style="border: 0.5px solid #1d3462; width: 374px; text-align: left; padding: 5px; border-right: none; "><?php echo $datos[0]['Nombre']; ?> <?php echo $datos[0]['APaterno']; ?> <?php echo $datos[0]['AMaterno']; ?></td>
			<td style="border: 0.5px solid #1d3462; width: 90px; text-align: right; padding: 5px; border-right: none; border-bottom: none; "><b>MATRICULA:</b> </td>
			<td style="border: 0.5px solid #1d3462; width: 100px; text-align: left; padding: 5px;"><?php echo $datos[0]['Usuario']; ?></td>
		</tr>
		<tr>
			<td style="border: 0.5px solid #1d3462; width: 50px; text-align: left; padding: 5px; border-right: none; "><b>CARRERA:</b></td>
			<td style="border: 0.5px solid #1d3462; width: 374px; text-align: left; padding: 5px; border-right: none;"><?php echo $datos[0]['Educativa']; ?></td>
			<td style="border: 0.5px solid #1d3462; width: 90px; text-align: right; padding: 5px; border-right: none;"> </td>
			<td style="border: 0.5px solid #1d3462; width: 100px; text-align: left; padding: 5px;"></td>
		</tr>
	</table>
	
	        
	        
	        <table style="margin-left: 0px; margin-top: 20px; font-size: 10px; border-collapse: collapse;">
		
		<?php $sumCred = 0; $ci = 0; $cf = 0; for ($i=0;$i< sizeof($kardex);$i++) { $ci = $kardex[$i]['IdCiclo']; 
		
		    if($kardex[$i]['Promedio'] >=6){
			    $cred = $kardex[$i]['Creditos'];
			} else {
			    $cred = 0;
			}
			$descr = '';
			
			if($kardex[$i]['Observacion'] == "R"){ $descr = 'RECURSADO';  }
			if($kardex[$i]['Observacion'] == "E"){ $descr = 'EXTRAORDINARIO';  }
			
			if($kardex[$i]['Promedio'] <= 5 ){ $descr = 'REPROBADO'; $cred = 0; } 
			
		$sumCred = ($sumCred + $cred);
		
		
			if($ci <> $cf){ 
			
			
			
			
			
			
			?>
		<tr>
			<td colspan="4" style="border: 0.5px solid #1d3462; width: 600px; text-align: center; padding: 5px;"><b><?php if($datos[0]['Tipo'] == 'N'){ ?><?php echo $tp; ?> <?php echo $kardex[$i]['Ciclo']; ?> <?php } else { ?> <?php echo $tp; ?> <?php echo $kardex[$i]['IdCiclo']; ?>° <?php echo $tp; ?>  <?php } ?></b></td>
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
			<td style="border: 0.5px solid #1d3462; width: 80px; text-align: center; padding: 5px;"><?php echo $kardex[$i]['Promedio']; ?></td>
			<td style="border: 0.5px solid #1d3462; width: 40px; text-align: center; padding: 5px;"><?php echo $cred; ?></td>
			<td style="border: 0.5px solid #1d3462; width: 100px; text-align: center; padding: 5px;"><?php echo $descr; ?></td>
		</tr>
		<?php $cf = $kardex[$i]['IdCiclo']; } ?>
		<tr>
			<td colspan="4" style="border-left: none; border-right: none; width: 600px; text-align: right; padding: 5px;"></td>
		</tr>
		<?php if($sumCred > 0){ ?>
		<tr>
			<td colspan="4" style="border: none; width: 600px; text-align: right; padding: 5px; font-size: 12px;">
			    <?php if($user[0]['IdOferta'] == 30){ ?>
			    <b><?php echo $sumCred; ?>CRÉDITOS DE UN TOTAL DE 456 </b>
			    <?php } else { ?>
			    <b><?php echo $sumCred; ?> CRÉDITOS DE UN TOTAL DE   <?php echo $creditos[0]['Total']; ?> </b>
			    <?php } ?>
			    
		    </td>
		</tr>
		<tr>
			<td colspan="4" style="border: none; width: 600px; text-align: right; padding: 5px; font-size: 12px;">
			    <b>PROMEDIO FINAL:  <?php echo bcdiv($promedio[0]['Promedio'], 1, 1); ?>  </b>
			    
		    </td>
		</tr>
		<?php } ?>
	</table>
	

	
	    </p>    
	        <?php } ?>
	    
	    
	    
	</p>
</page>