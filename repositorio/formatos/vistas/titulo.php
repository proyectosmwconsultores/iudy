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
<page backtop="18mm" backbottom="10mm" backleft="10mm" backright="10mm">
	<page_header> <!-- Define el header de la hoja -->

	</page_header>
	<page_footer>
		
	</page_footer>
	<table style="text-align: justify;">
	    <tr>
	        <td style='width: 220px;'></td>
	        <td style='width: 460px; height: 100px;  font-size: 42px; color: black; font-family: gabriola; font-weight: bold; text-align: center;'>Instituto Universitario de Yucatán</td>
	    </tr>
	    <tr>
	        <td></td>
	        <td style='width: 430px; height: 100px;  font-size: 42px; color: black; font-family: gabriola; font-weight: bold; text-align: center;'> Otorga a </td>
	    </tr>
	    <tr>
	        <td></td>
	        <td style='width: 430px; height: 80px; font-size: <?php echo $taman; ?>px; color: black; font-family: gabriola; font-weight: bold; text-align: center;'> <?php echo $titulo[0]['Nombre']; ?> <?php echo $titulo[0]['APaterno']; ?> <?php echo $titulo[0]['AMaterno']; ?> </td>
	    </tr>
	    <tr>
	        <td></td>
	        <td style='width: 430px; font-size: 40px; color: black; font-family: gabriola; font-weight: bold; text-align: center;'><?php if($titulo[0]['Grado'] == 3) { ?> El Título de <?php } else { ?> El Grado de  <?php } ?></td>
	    </tr>
	    <tr>
	        <td></td>
	        <td style='width: 430px; height: 80px; font-size: 40px; color: black; font-family: gabriola; font-weight: bold; text-align: center;'> <?php echo $titulo[0]['oferta']; ?> </td>
	    </tr>
	    <tr>
	        <td></td>
	        <td style='width: 430px; height: 80px; font-size: 31px; color: black; font-family: gabriola; font-weight: bold; '>
	            <div>
    	            <p style="text-align: justify; line-height: 40px;">
    	            Con &nbsp; reconocimiento &nbsp; &nbsp; de &nbsp; &nbsp; validez &nbsp; oficial &nbsp; de
    	            estudios &nbsp; de &nbsp; la &nbsp; Secretaría &nbsp; de &nbsp; Educación &nbsp; del 
    	            Gobierno del Estado de Tabasco, según Acuerdo 
    	            No. 1402351, en virtud de que &nbsp; demostró cumplir 
    	            con &nbsp; los &nbsp; estudios &nbsp; correspondientes &nbsp; y  &nbsp; aprobó 
    	            conforme &nbsp; a &nbsp; titulación &nbsp; &nbsp; por &nbsp; <?php echo $titulo[0]['Tipo2']; ?>, el día <?php echo fec_titulo($titulo[0]['t_fecha_examen']); ?>.
    	            </p>
	            </div>
	        </td>
	    </tr>
	    <tr>
	        <td></td>
	        <td style='width: 430px; height: 40px; font-size: 28px; color: black; font-family: gabriola; font-weight: bold; text-align: left;'> Centro, Tabasco a <?php echo fec_titulo($titulo[0]['t_impresion']); ?>.  </td>
	    </tr>
	    <tr>
	        <td></td>
	        <td style='width: 430px; height: 80px;  text-align: center;'><br><br><br><br>
	            _______________________________________ <br><br>
	            <b style='font-size: 28px; color: black; font-family: gabriola; font-weight: bold;'>Dr. Audiel Hipólito Durán<br>Rector</b>

	        </td>
	    </tr>
	</table>
	<table style="text-align: justify;">
	    <tr>
	        <td style='width: 460px; height: 40px; font-size: 42px; color: black; font-family: gabriola; font-weight: bold; text-align: center;'></td>
	        <td style='width: 220px;'></td>
	    </tr>
	    <tr>
	        <td style='width: 460px; height: 100px; font-size: 12px; color: black; text-align: left;'>
	            El presente título quedó registrado en el Libro No. <u> &nbsp; <?php echo $titulo[0]['t_no']; ?> &nbsp; </u> Foja No. <u> &nbsp; <?php echo $titulo[0]['t_foja']; ?> &nbsp; </u>
	            <br>
	            Centro, Tabasco a <u> &nbsp; <?php echo !empty($titulo[0]['t_impresion']) ? substr((string)$titulo[0]['t_impresion'], 8, 2) : '-'; ?> &nbsp; </u> de <u> &nbsp; <?php echo letra_mes_titulo($titulo[0]['t_impresion']); ?> &nbsp; </u> de <u> &nbsp; <?php echo !empty($titulo[0]['t_impresion']) ? substr((string)$titulo[0]['t_impresion'], 0, 4) : '-'; ?> &nbsp; </u> .
	        </td>
	        <td style='width: 220px;'></td>
	    </tr>
    </table><br><br><br><br><br><br><br>
    <table style="text-align: justify;">
	    <tr>
	        <td style='width: 270px;'></td>
	        <td style='width: 400px; height: 100px; font-size: 12px; color: black; text-align: left;'>
	           Se &nbsp; autentica &nbsp; con &nbsp; fundamento &nbsp; en el &nbsp; Artículo &nbsp; 14 de la Ley General de
	           Educación Superior y se registra en la Foja No. <u> <?php echo $titulo[0]['t_foja']; ?> </u> del Libro No. <u> <?php echo $titulo[0]['t_no']; ?> </u>.
	           <p style='text-align: center;'> Centro, Tabasco a _____ de ____________________ de ________.</p>
	           <p style='text-align: center;'> <br><br><br>
	           __________________________________________ <br>
                <?php echo $titulo[0]['t_control']; ?><br>
                Director de Control Escolar e Incorporación
	           </p>
	        </td>
	    </tr>
	    <tr>
	        <td style='width: 270px;'></td>
	        <td style='width: 400px; font-size: 12px; color: black; text-align: left;'>
	          
	        </td>
	    </tr>
    </table>
    <table style='border-collapse: collapse; width:242px;' cellspacing="0" cellpadding="0">

    <tr>
        <td style='padding:4px; border:1px solid black; font-size:9px; text-align:left;'>
            <b>Certificación de Antecedentes Académicos</b>
        </td>
    </tr>

    <tr>
        <td style='padding:4px; border-left:1px solid black; border-right:1px solid black; font-size:9px;'>

            <b>Profesionista</b><br>
            Nombre: <?php echo $titulo[0]['Nombre']; ?> <?php echo $titulo[0]['APaterno']; ?> <?php echo $titulo[0]['AMaterno']; ?><br>
            CURP: <?php echo $titulo[0]['Curp']; ?>

        </td>
    </tr>

    <tr>
        <td style='padding:4px; border-left:1px solid black; border-right:1px solid black; font-size:9px;'>

            <b>Estudios de Bachillerato</b><br>
            CCT: <?php echo $titulo[0]['CCT']; ?><br>
            Institución: <?php echo $titulo[0]['Institucion']; ?><br>
            Fecha de inicio: <?php echo $titulo[0]['Cer_inicio']; ?><br>
            Fecha de término: <?php echo $titulo[0]['Cer_final']; ?><br>
            Entidad Federativa: <?php echo $titulo[0]['Entidad']; ?>

        </td>
    </tr>

    <tr>
        <td style='padding:4px; border-left:1px solid black; border-right:1px solid black; font-size:9px;'>

            <b>Estudios Profesionales</b><br>
            Título: <?php echo $titulo[0]['Educativa']; ?><br>
            Clave de Institución (DGP): <?php echo $titulo[0]['Clave']; ?><br>
            Clave de Carrera (DGP): <?php echo $titulo[0]['Clave_dgp']; ?><br>
            Fecha de inicio: <?php echo $titulo[0]['t_inicio']; ?><br>
            Fecha de término: <?php echo $titulo[0]['t_final']; ?><br>
            Modalidad de Titulación: <?php echo $titulo[0]['Tipo1']; ?><br>
            Fecha de Examen Profesional: <?php echo $titulo[0]['t_fecha_examen']; ?>

        </td>
    </tr>

    <tr>
        <td style='padding:4px; border-left:1px solid black; border-right:1px solid black; font-size:9px; text-align:justify;'>

            Ha concluido el Servicio Social, de acuerdo a lo estipulado por los
            Artículos 15 de la Ley General de Educación Superior y 55 de la
            Ley Reglamentaria del Artículo 5° Constitucional; así como el
            Reglamento del Servicio Social de esta Institución.

        </td>
    </tr>

    <tr>
        <td style='padding:4px; border:1px solid black; font-size:9px; text-align:center;'>

            Centro, Tabasco a <?php echo fec_titulo($titulo[0]['t_impresion']); ?><br><br><br>

            _______________________<br>

            <?php echo $titulo[0]['t_gestion']; ?><br>

            Directora de Gestión Escolar<br>
            y Titulación

        </td>
    </tr>

</table>
	
</page>