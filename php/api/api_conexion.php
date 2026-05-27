<?php
require('../clases/class.System.php');
$db = new Conexion();
header('Access-Control-Allow-Origin: *');
$url = $_POST['url'];
$code = $_POST['code'];

$insertar = $db->query("UPDATE tblp_configuracion SET tblp_configuracion.Descripcion = '$url', tblp_configuracion.Estatus = 'A', tblp_configuracion.Texto = '$code' WHERE tblp_configuracion.IdConfig = '37'");

$db->close();
echo $IdCalExt;

?>
