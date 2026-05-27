<?php
  $Fecha=date("Y-m-d");
  header("Content-type: application/vnd.ms-excel");
  header("Content-Disposition: attachment; filename=saldosPendientes-$Fecha.xls");
  header("Pragma: no-cache");
  header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
  header("Expires: 0");
  include("../php/estructura/session.php");
  include("../php/estructura/validationlogin.php");
  require('../php/clases/class.php');
  $t=new Trabajo();
  $configuracion=$t->get_configuracion();
  $pagoPend=$t->get_pagosPend();
?>
<html>
  <head>
    <META HTTP-EQUIV= "Content-Type" CONTENT="text/html; charset=utf-8" />
    <META http-equiv="Content-Language" content="es" />
    <style type="text/css"> .uno{ text-align: center; } </style>
  </head>
  <body>
    <table style=" width: 500px; color: #0073b7; font-size: 16px; font-family: Arial, Century Gothic,sans-serif;">
      <tr><td style="text-align: center;" colspan="10"><b><?php echo $configuracion[0]["Descripcion"]; ?></b></td></tr>
      <tr><td style="text-align: center;" colspan="10"><b>Reporte de pagos pendientes</b></td></tr>
    </table>
    <br>
    <table border="1" style=" color: black; font-size: 12px; font-family: Arial,Century Gothic,sans-serif;">
      <tr style=" background: gray;">

          <th>Referencia</th>
          <th>Nombre</th>
          <th>Estatus</th>
          <th>Oferta educativa</th>
          <th>Concepto</th>
          <th>Fecha l&iacute;mite de pago</th>
          <th>Descuento</th>
          <th>Nombre del descuento</th>
          <th>Total</th>
          <th>Recargo</th>
          <th>Monto descuento</th>
          <th>Total a pagar</th>

      </tr>
      <?php for ($i=0;$i< sizeof($pagoPend);$i++) {
        $suma = $pagoPend[$i]["Pagar"] + $pagoPend[$i]["Recargos"];
        $rect = $pagoPend[$i]["Recargos"];
        $fecLimite = $pagoPend[$i]["FecLimPago"];
        $IdDescuento = $pagoPend[$i]["IdDescuento"];
        $descM = 0;
        $descuentoE = $pagoPend[$i]["estatusDescuentoActivo"];
        if($descuentoE == 11){ $condEs = "style='color: red;'"; $desc = 'Descuento de '.$pagoPend[$i]["NomDescuento"].' '.$pagoPend[$i]["estatusDescuento"];  }
        if($descuentoE == 22){ $condEs = "style='color: green;'"; $desc = 'Descuento de '.$pagoPend[$i]["NomDescuento"].' '.$pagoPend[$i]["estatusDescuento"];  }
        if($descuentoE == ""){ $condEs = "style='color: black;'"; $desc = 'No existe descuento';}

        if($descuentoE == 8){ $condEs = "style='color: blue;'"; $desc = 'Descuento de '.$pagoPend[$i]["NomDescuento"].' '.$pagoPend[$i]["estatusDescuento"];
          $descuento=$t->get_descuentoXa($IdDescuento);
          $recargos = $pagoPend[$i]["Recargos"];
          $totalPagar = $recargos + $pagoPend[$i]["Pagar"];
          $suma = $totalPagar -  + $descuento[0]["Descuento"];
          $fecLimite = $descuento[0]["FecDescuento"];
          $descM = $descuento[0]["Descuento"];
         }




         $mod1Pagar = $pagoPend[$i]["Pagar"] + $mod1Pagar;
         $mod2Recarg = $pagoPend[$i]["Recargos"] + $mod2Recarg;
         $mod3Descu = $descM + $mod3Descu;
         $sumTotal = $sumTotal + $suma;


          ?>
      <tr>
        <td><?php echo $pagoPend[$i]["Referencia"]; ?></td>
        <td> <i <?php echo $condEs; ?> class="fa fa-fw fa-circle"></i> <?php echo $pagoPend[$i]["Nombre"].' '.$pagoPend[$i]["APaterno"].' '.$pagoPend[$i]["AMaterno"]; ?></td>
        <td><?php echo $pagoPend[$i]["Estatus"]; ?></td>
        <td><?php echo $pagoPend[$i]["NomEducativa"]; ?></td>
        <td><?php echo $pagoPend[$i]["NomConcepto"]; ?></td>
        <td><?php echo $fecLimite; ?></td>


        <td><b <?php echo $condEs; ?>><?php echo $pagoPend[$i]["NomDescuento"]; ?></b></td>
        <td><b <?php echo $condEs; ?>><?php if($pagoPend[$i]["estatusDescuento"]){ echo $pagoPend[$i]["estatusDescuento"]; }  else { echo "No existe descuento"; }?></b></td>


        <td>$ <?php echo number_format($pagoPend[$i]["Pagar"], 2, '.', ',');  ?></td>
        <td style="color: red;"> $ <?php echo number_format($pagoPend[$i]["Recargos"], 2, '.', ',');  ?></td>
        <td><b <?php echo $condEs; ?>> $ <?php if($descM){ echo " - "; }  echo number_format($descM, 2, '.', ',');  ?></b></td>
        <td style="width: 80px; text-align: right;"><b style="color: green;">$<?php echo number_format($suma, 2, '.', ',');  ?></b> </td>

      </tr>
    <?php  } ?>
      <tr style=" background: #D0D0D0;">
        <th colspan="8" style="text-align: right;">Total:</th>
        <th style="text-align: right;">$ <?php echo number_format($mod1Pagar, 2, '.', ','); ?></th>
        <th style="text-align: right;">$ <?php echo number_format($mod2Recarg, 2, '.', ','); ?></th>
        <th style="text-align: right;">$ <?php echo number_format($mod3Descu, 2, '.', ','); ?></th>
        <th style="text-align: right;">$ <?php echo number_format($sumTotal, 2, '.', ','); ?></th>
      </tr>
    </table>
  </body>
</html>
