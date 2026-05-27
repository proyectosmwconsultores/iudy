<?php
$url = $_GET['url'];
$nombre = $_GET['idToks'];
$nombre = $nombre.'.xml';

$url_xml  = "../assets/docs/factura/".$url."/".$nombre;

header('Content-Type: text/xml');
header("Content-Disposition:attachment ; filename=$nombre");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
    ob_clean();
    flush();

    echo file_get_contents("$url_xml");
    // echo file_get_contents("http://localhost/mwc/enaproc/assets/docs/factura/2022/08/177_100.xml");

    exit;
?>
