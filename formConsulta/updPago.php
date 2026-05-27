<?php
require('../php/clases/class.System.php');
$db = new Conexion();

$html = '';
$id_usua = $_POST['valor'];
$id_numero = $_POST['numero'];
$insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.GPago = '$id_numero' WHERE tblc_usuario.IdUsua = '$id_usua'");
$db->close();

echo $html;
?>
