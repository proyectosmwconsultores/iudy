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
  $IdGrado = $_GET["IdG"];
  $IdCampus = $_GET["IdC"];
  $IdPlanCon = $_GET["IdP"];
  $pagoPend=$t->get_pagosPaTodos($IdGrado, $IdCampus,$IdPlanCon);

?>
<html>
  <head>
    <META HTTP-EQUIV= "Content-Type" CONTENT="text/html; charset=utf-8" />
    <META http-equiv="Content-Language" content="es" />
    <style type="text/css"> .uno{ text-align: center; } </style>
  </head>
  <body>
    <table style=" color: #0073b7; font-size: 16px; font-family: Arial Narrow, Century Gothic,sans-serif;">
      <tr><td style="text-align: center;" colspan="10"><b><?php echo $configuracion[0]["Descripcion"]; ?></b></td></tr>
      <tr><td style="text-align: center;" colspan="10"><b>Reporte de pagos pendientes</b></td></tr>
    </table>
    <br>
    <table border="1" style=" color: black; font-size: 12px; font-family: Arial Narrow,Century Gothic,sans-serif;">
      <tr style=" background: #D0D0D0;">
        <th>Nombre</th>
        <th>Oferta educativa</th>
        <th>Concepto</th>
        <th>Estatus</th>
        <th>Fec. Desc</th>
        <th>Monto</th>
        <th>Descuento</th>
        <th>Recargo</th>
        <th>Abono</th>
        <th>Total</th>
      </tr>
      <?php for ($i=0;$i< sizeof($pagoPend);$i++) {
        $xx=$t->get_chkPago($pagoPend[$i]["IdUsua"]);
        $xY=$t->get_beca($pagoPend[$i]["IdUsua"],$pagoPend[$i]["IdPago"]);
        $xZ=$t->get_recargo($pagoPend[$i]["IdUsua"],$pagoPend[$i]["IdPago"]);
          $sumX = ($pagoPend[$i]["Monto"] - $pagoPend[$i]["Descuento"] + $xZ[0]["Recargo"] - $pagoPend[$i]["TotalPagado"]);
          $sunv = ($sunv + $sumX); ?>
      <tr>
        <td> <?php echo $pagoPend[$i]["Nombre"].' '.$pagoPend[$i]["APaterno"].' '.$pagoPend[$i]["AMaterno"]; ?></td>
        <td><?php echo $pagoPend[$i]["Educativa"]; ?></td>
        <td><?php echo $pagoPend[$i]["NomPlan"]; ?></td>
        <td><?php echo $pagoPend[$i]["Estatus"]; ?></td>
        <td><?php echo $pagoPend[$i]["FecDesc"]; ?></td>
        <td style="width: 80px; text-align: right;">$ <?php echo number_format($pagoPend[$i]["Monto"], 2, '.', ',');  ?></td>
        <td style="width: 80px; text-align: right;">$ <?php echo number_format($pagoPend[$i]["Descuento"], 2, '.', ',');  ?></td>
        <td style="width: 80px; text-align: right;">$ <?php echo number_format($xZ[0]["Recargo"], 2, '.', ',');  ?></td>
        <td style="width: 80px; text-align: right;">$ <?php echo number_format($pagoPend[$i]["TotalPagado"], 2, '.', ',');  ?></td>
        <td style="width: 80px; text-align: right;">$ <?php echo number_format($sumX, 2, '.', ',');  ?></td>
      </tr>
    <?php  } ?>
    </table>
  </body>
</html>
