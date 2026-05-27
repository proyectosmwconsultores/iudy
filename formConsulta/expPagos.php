<?php
  header("Content-type: application/vnd.ms-excel");
  header("Content-Disposition: attachment; filename=Reporte_de_pagos_generados.xls");
  header("Pragma: no-cache");
  header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
  header("Expires: 0");
  include("../php/estructura/session.php");
  include("../php/estructura/validationlogin.php");
  require('../php/clases/class.php');
  $t=new Trabajo();
  $configuracion=$t->get_configuracion();
  $datos=$t->get_calendarioId(substr($_GET["IdC"], 10,10));

?>
<html>
  <head>
    <META HTTP-EQUIV= "Content-Type" CONTENT="text/html; charset=utf-8" />
    <META http-equiv="Content-Language" content="es" />
    <style type="text/css"> .uno{ text-align: center; } </style>
  </head>
  <body>
    <table style=" color: #0073b7; font-size: 16px; font-family: Arial Narrow, Century Gothic,sans-serif;">
      <tr><td style="text-align: center;" colspan="5"><b><?php echo $configuracion[0]["Descripcion"]; ?></b></td></tr>
      <tr><td style="text-align: center;" colspan="5"><b>Reporte de pagos generados</b></td></tr>
      <tr><td style="text-align: center;" colspan="5"><b><?php echo $datos[0]["NomPlan"]; ?></b></td></tr>
    </table>
    <br>
    <table border="1" style=" color: black; font-size: 12px; font-family: Arial Narrow,Century Gothic,sans-serif;">
      <tr style=" background: #D0D0D0;">
        <th>#</th>
        <th>MATRICULA</th>
        <th>NOMBRE</th>
        <th>OFERTA EDUCATIVA</th>
        <th>MONTO</th>
      </tr>
      <?php for ($i=0;$i< sizeof($datos);$i++) { ?>
      <tr>
        <td><?php echo $x = $x + 1; ?></td>
        <td><?php echo $datos[$i]["Usuario"]; ?></td>
        <td><?php echo $datos[$i]["Nombre"].' '.$datos[$i]["APaterno"].' '.$datos[$i]["AMaterno"]; ?></td>
        <td><?php echo $datos[$i]["Educativa"]; ?></td>
        <td>$ <?php echo number_format($datos[$i]["Monto"], 2, '.', ','); ?></td>
      </tr>
      <?php } ?>
    </table>
  </body>
</html>
