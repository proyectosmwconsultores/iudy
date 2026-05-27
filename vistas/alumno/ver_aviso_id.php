<?php session_start();
$IdAvis = $_POST['Id'];
require('../../php/clases/consultas_formatos.php');
$formatos = new Class_formatos();
$_aviso = $formatos->obtener_aviso_id($IdAvis, $_SESSION['IdUsua']);

?>
<img src="assets/images/avisos/_slider1.png" style="width: 100%;">