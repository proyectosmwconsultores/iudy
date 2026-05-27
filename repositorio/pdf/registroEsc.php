<?php
session_start();
if($_SESSION['Permisos']){
	$nombre = "registroEscolaridad_".time().".pdf";
	//ob_start guardará en un búfer lo que esté
	//en la ruta del include.
	date_default_timezone_set('America/Mexico_City');
	ob_start();
    include(dirname(__FILE__).'/vistas/registroEsc.php');
    //En una variable llamada $content se obtiene lo que tenga la ruta especificada
    //NOTA: Se usa ob_get_clean porque trae SOLO el contenido
    //Evitará este error tan común en FPDF:
    //FPDF error: Some data has already been output, can't send PDF
    $content = ob_get_clean();

    //Se obtiene la librería
    require_once(dirname(__FILE__).'/../html2pdf.class.php');
    /* Las lineas siguientes siempre serán las mismas
     * A mi parecer no hay mucho que explicar. Se explican
     * por sí solas :D
     * */
    try
    {
        //$html2pdf = new HTML2PDF('L', array(500,200), 'es', true, 'UTF-8', 3); //Configura la hoja
				$html2pdf = new HTML2PDF('L', 'Legal', 'es', true, 'UTF-8', 3); //Configura la hoja
        $html2pdf->pdf->SetDisplayMode('fullpage'); //Ver otros parámetros para SetDisplaMode
        $html2pdf->writeHTML($content); //Se escribe el contenido
        $html2pdf->Output($nombre); //Nombre default del PDF
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
    }
    else{
    echo "<script type='text/javascript'>window.location='../../php/estructura/destroy.php';</script>";

    }
?>
