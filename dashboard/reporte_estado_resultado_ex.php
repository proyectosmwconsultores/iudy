<?php
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=estado_resutado.xls");
header("Pragma: no-cache");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Expires: 0");

  require('../php/clases/class.php');
  $t=new Trabajo();
  $AnioMes = $_GET['AnioMes'];

  include('../hace.php');

  $ingreso=$t->get_ingreso($AnioMes);
  $egreso=$t->get_egresos($AnioMes);

  ?>
  <meta charset="utf-8">
  <div class="bg-aqua color-palette" style="padding: 5px;"><span style="color: black;"><i class="fa fa-fw fa-bookmark-o"></i> Estado de resultado del mes de <?php echo obtenerAnioMes($AnioMes); ?></span></div>
  <table class="table table-striped" style="font-size: 12px;">
    <tbody>
      <tr style="background: #39CCCC; color: black;">
        <td colspan="3"><i class="fa fa-fw fa-exchange"></i> INGRESOS</td>
      </tr>
      <?php $ing = 0;
      for ($z=0;$z< sizeof($ingreso);$z++) { ?>
      <tr>
        <td style="text-align: left; width: 30px;"></td>
        <td style="text-align: left;"><?php echo $ingreso[$z]['NomConcepto']; ?></td>
        <td style="text-align: left;">$ <?php echo number_format($ingreso[$z]['Total'], 2, '.', ','); ?></td>
      </tr>
      <?php $ing = ($ing + $ingreso[$z]['Total']); } ?>
      <tr>
        <td style="text-align: left; width: 30px;"></td>
        <td style="text-align: left;"><b>TOTAL INGRESO</b></td>
        <td style="text-align: left; width: 150px;"><b>$ <?php echo number_format($ing, 2, '.', ','); ?></b></td>
      </tr>
  </tbody></table>
  <table class="table table-striped" style="font-size: 12px;">
    <tbody>
      <tr style="background: #39CCCC; color: black;">
        <td colspan="3"><i class="fa fa-fw fa-exchange"></i> EGRESOS</td>
      </tr>
      <?php $sz = 0;
      for ($z=0;$z< sizeof($egreso);$z++) { ?>
      <tr>
        <td style="text-align: left; width: 30px;"></td>
        <td style="text-align: left;"><?php echo $egreso[$z]['_Permiso']; ?></td>
        <td style="text-align: left;">$ <?php echo number_format($egreso[$z]['Suma'], 2, '.', ','); ?></td>
      </tr>
      <?php $sz = ($sz + $egreso[$z]['Suma']); } ?>
      <tr>
        <td style="text-align: left; width: 30px;"></td>
        <td style="text-align: left;"><b>TOTAL EGRESO</b></td>
        <td style="text-align: left; width: 150px;"><b>$ <?php echo number_format($sz, 2, '.', ','); ?></b></td>
      </tr>
  </tbody></table>
  <br>
  <?php $_res = ($ing - $sz); ?>
  <table class="table table-striped" style="font-size: 12px;">
    <tbody>

      <tr style="background: #39CCCC; color: black;">
        <td colspan="2"><i class="fa fa-fw fa-balance-scale"></i> UTILIDAD NETA</td>
        <td style="text-align: left; width: 150px;"><b>$ <?php echo number_format($_res, 2, '.', ','); ?></td>
      </tr>
  </tbody></table>
