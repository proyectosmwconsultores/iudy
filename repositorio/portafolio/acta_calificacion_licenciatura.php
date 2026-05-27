<?php
session_start();
require_once dirname(__FILE__) . '/../autoload.php';

use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;

if ($_SESSION['Permisos']) {
    try {
        ob_start();
        include dirname(__FILE__) . '/vistas/acta_calificacion_licenciatura.php';
        $content = ob_get_clean();

        $html2pdf = new Html2Pdf('P', 'A4', 'fr', true, 'UTF-8', array(5, 5, 15, 5));
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content);
        $html2pdf->output('acta_calificacion.pdf');
    } catch (Html2PdfException $e) {
        $html2pdf->clean();

        $formatter = new ExceptionFormatter($e);
        echo $formatter->getHtmlMessage();
    }
} else {
    echo "<script type='text/javascript'>window.location='../../php/estructura/destroy.php';</script>";
}
