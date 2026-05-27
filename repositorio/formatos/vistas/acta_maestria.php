<?php
require_once '../class_formatos.php';
include("../hace_fecha.php");
//include("hace.php");
$formx = new Formatos();
$code = $_GET['idToks'];

$titulo = $formx->obtener_datos_titulo($code);
$rvoe = $formx->get_datos_campus_rvoe($titulo[0]['IdUsua']);

$numero = strlen($titulo[0]['Nombre'].' '.$titulo[0]['APaterno'].' '.$titulo[0]['AMaterno']);

if($numero <= 30){
    $taman = 35;
} else {
    $taman = 28;
}




if(!isset($titulo[0]['IdUsua'])){
	echo "<script type='text/javascript'>window.close();</script>";
    exit();
	}
	
?>


<!-- page define la hoja con los márgenes señalados -->
<page backtop="20mm" backbottom="10mm" backleft="10mm" backright="10mm">
	<page_header> <!-- Define el header de la hoja -->

	</page_header>
	<page_footer>
		
	</page_footer>
	<table style="text-align: justify;">
	    <tr>
	        <td style='width: 200px;'></td>
	        <td style='width: 480px; height: 30px;  font-size: 16px; color: black; font-family: Arial; font-weight: bold; text-align: center;'>ACTA DE GRADO </td>
	    </tr>
	    <tr>
	        <td style='width: 200px;'></td>
	        <td style='width: 480px; height: 150px; line-height: 20px; font-size: 16px; color: black; font-family: Arial; text-align: justify;'>
	            En Centro, Tabasco, a las <?php echo horaEnLetra($titulo[0]['acta_hora']); ?> del <?php echo fechaEnLetra($titulo[0]['acta_fecha']); ?>, de conformidad con el Artículo 401, 403, en relación al Artículo 410 establecido  en el reglamento institucional vigente, se procede a expedir la presente acta para obtener el título de: 
	        </td>
	    </tr>
	    <tr>
	        <td style='width: 200px;'></td>
	        <td style='width: 480px; height: 100px; line-height: 20px; font-size: 16px; color: black; font-family: Arial; font-weight: bold; text-align: center;'>
	            <?php $sexo = substr($titulo[0]['P_curp'], 10, 1); if($sexo == "H"){ echo "MAESTRO";} else { echo "MAESTRA"; } ?> <?php echo $titulo[0]['_imprimir']; ?>
	        </td>
	    </tr>
	    <tr>
	        <td style='width: 200px;'></td>
	        <td style='width: 480px; height: 150px; line-height: 20px; font-size: 16px; color: black; font-family: Arial; text-align: justify;'>
	            Con Reconocimiento de Validez Oficial de la Secretaría de Educación del Gobierno del Estado de Tabasco, según Acuerdo No. <?php echo $titulo[0]['Rvoe']; ?> de fecha <?php echo mb_strtolower($titulo[0]['Vigencia']); ?>, a favor de:
	        </td>
	    </tr>
	    <tr>
	        <td style='width: 200px;'></td>
	        <td style='width: 480px; height: 80px; line-height: 20px; font-size: 16px; color: black; font-family: Arial; font-weight: bold; text-align: center;'>
	            <?php echo $titulo[0]['Nombre'].' '.$titulo[0]['APaterno'].' '.$titulo[0]['AMaterno']; ?>
	        </td>
	    </tr>
	    <tr>
	        <td style='width: 200px;'></td>
	        <td style='width: 480px; height: 80px; line-height: 20px; font-size: 16px; color: black; font-family: Arial; text-align: justify;'>
	            Quien demostró cumplir con los estudios correspondientes y aprobó conforme a <?php echo $titulo[0]['acta_aprobo']; ?>. 
	        </td>
	    </tr>
	    <tr>
	        <td style='width: 200px;'></td>
	        <td style='width: 480px; height: 60px; line-height: 20px; font-size: 16px; color: black; font-family: Arial; text-align: justify;'>
	            En virtud de lo anterior se procedió a tomar la protesta de ley.
	        </td>
	    </tr>
	    <tr>
	        <td style='width: 200px;'></td>
	        <td style='width: 480px; height: 100px; line-height: 20px; font-size: 14px; color: black; text-align: center;'>
	            <b>Vo. Bo.<br>RECTOR</b>
	        </td>
	    </tr>
	    <tr>
	        <td style='width: 200px;'></td>
	        <td style='width: 480px; height: 80px; line-height: 20px; font-size: 14px; color: black; text-align: center;'>
	        </td>
	    </tr>
	    <tr>
	        <td style='width: 200px;'></td>
	        <td style='width: 480px; height: 30px; line-height: 20px; font-size: 14px; color: black; text-align: center;'>
	            ____________________________<br><b>Dr. Audiel Hipólito Durán</b>
	        </td>
	    </tr>
	    
	    
	</table>
	
</page>