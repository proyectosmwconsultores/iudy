<?php
include("../php/estructura/session.php");
include("../php/estructura/validationlogin.php");
require('../php/clases/class.php');
$t=new Trabajo();

$lstLista=$t->get_lstSugerencia(substr($_GET["idCa"], 10, 10),substr($_GET["idCi"], 10, 10));
$lstCa=$t->get_lstCam(substr($_GET["idCa"], 10, 10));
$lstCi=$t->get_lstCic(substr($_GET["idCi"], 10, 10));
$campus = $lstCa[0]["Campus"].'_';
  $Fecha=date("Y-m-d");
  header("Content-type: application/vnd.ms-excel");
  header("Content-Disposition: attachment; filename=$campus$Fecha.xls");
  header("Pragma: no-cache");
  header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
  header("Expires: 0");



?>
<html>
  <head>
    <META HTTP-EQUIV= "Content-Type" CONTENT="text/html; charset=utf-8" />
    <META http-equiv="Content-Language" content="es" />
    <style type="text/css"> .uno{ text-align: center; } </style>
  </head>
  <body>
    <table style=" width: 500px; color: #0073b7; font-size: 16px; font-family: Arial, Century Gothic,sans-serif;">
      <tr><td style="text-align: center;" colspan="4"><b>UNIVERSIDAD DEL SURESTE</b></td></tr>
      <tr><td style="text-align: center;" colspan="4"><b>EVALUACIÓN DOCENTE</b></td></tr>
      <tr><td style="text-align: center;" colspan="4"><b>SUGERENCIAS PARA MEJORAR A UDS</b></td></tr>

    </table>
    <br>
    <table style="font-size: 12px; font-family: Arial,Century Gothic,sans-serif;">
  		<tr>
  			<td style="width: 130px; border-right: none; border-bottom: none; "><b>CAMPUS:</b></td>
  			<td style="width: 200px; border-right: none;"><?php echo $lstCa[0]["Campus"]; ?></td>
  			<td style="width: 180px; text-align: right; border-right: none; border-bottom: none;"><b>CUATRIMESTRE:</b></td>
  			<td style="width: 130px; "><?php echo $lstCi[0]["Ciclo"]; ?></td>
  		</tr>
  	</table>
    <br>
    <table border="1" style=" color: black; font-size: 12px; font-family: Arial,Century Gothic,sans-serif;">
      <tr style=" background: #D0D0D0;">
        <th>NO</th>
        <th colspan="3">SUGERENCIAS:</th>
      </tr>
      <?php for ($i=0;$i< sizeof($lstLista);$i++) { ?>
  		<tr>
  			<td style="width: 30px; text-align: center;"><?php echo $v = $v + 1; ?></td>
  			<td colspan="3" style="width: 439px; text-align: left;"><?php echo $lstLista[$i]["Texto"]; ?></td>
  		</tr>
  		<?php } ?>

    </table>
  </body>
</html>
