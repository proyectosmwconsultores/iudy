<?php
//LA URL DEL ARCHIVO DEBE SER CON CONEXION FTP EN POCAS PALABRAS /home/userFTP/carpeta/documento

$nombre_ficherox = $_GET['link'];
$nombre_fichero = 'https://sciudy.com/'.$nombre_ficherox;
$_nombre = date("Y_m_d");
$_nombre_file = 'file_xml_'.$_nombre.'.xml';
header('Content-Type: text/xml charset=utf-8');
header("Content-Disposition:attachment ; filename=$_nombre_file");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");


$fichero_texto = fopen($nombre_fichero, "r");
$contenido_fichero = fpassthru($fichero_texto);


readfile($contenido_fichero);
?>