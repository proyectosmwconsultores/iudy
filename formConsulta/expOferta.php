<?php
  header("Content-type: application/vnd.ms-excel");
  header("Content-Disposition: attachment; filename=RepOfertaEducativa.xls");
  header("Pragma: no-cache");
  header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
  header("Expires: 0");
  include("../php/estructura/session.php");
  include("../php/estructura/validationlogin.php");
  require('../php/clases/class.php');
  $t=new Trabajo();
  $configuracion=$t->get_configuracion();
  $ofertaE=$t->get_OfertaE();

?>
<html>
  <head>
    <META HTTP-EQUIV= "Content-Type" CONTENT="text/html; charset=utf-8" />
    <META http-equiv="Content-Language" content="es" />
    <style type="text/css"> .uno{ text-align: center; } </style>
  </head>
  <body>
    <table style=" color: #0073b7; font-size: 16px; font-family: Arial Narrow, Century Gothic,sans-serif;">
      <tr><td style="text-align: center;" colspan="9"><b><?php echo $configuracion[0]["Descripcion"]; ?></b></td></tr>
      <tr><td style="text-align: center;" colspan="9"><b>Reporte de las ofertas educativas</b></td></tr>
    </table>
    <br>
    <table border="1" style=" color: black; font-size: 12px; font-family: Arial Narrow,Century Gothic,sans-serif;">
      <tr style=" background: #D0D0D0;">
        <th>CLAVE</th>
        <th>TIPO</th>
        <th>NOMBRE</th>
        <th>MODALIDAD</th>
        <th>TIPO CICLO</th>
        <th>DURACIÓN</th>
        <th>FEC.CAP</th>
        <th>CRÉDITOS</th>
        <th>RVOE</th>
      </tr>
      <?php for ($i=0;$i< sizeof($ofertaE);$i++) { ?>
      <tr>
        <td><?php echo $ofertaE[$i]["Clave"]; ?></td>
        <td><?php echo $ofertaE[$i]["Tipo"]; ?></td>
        <td><?php echo $ofertaE[$i]["Nombre"]; ?></td>
        <td><?php echo $ofertaE[$i]["Modalidad"]; ?></td>
        <td><?php echo $ofertaE[$i]["Ciclo"]; ?></td>
        <td><?php echo $ofertaE[$i]["Duracion"].' '.$oferta[$i]["Ciclo"]; ?></td>
        <td><?php echo $ofertaE[$i]["FecCap"]; ?></td>
        <td><?php echo $ofertaE[$i]["Creditos"]; ?></td>
        <td><?php echo $ofertaE[$i]["Rvoe"]; ?></td>
      </tr>
      <?php } ?>
    </table>
  </body>
</html>
