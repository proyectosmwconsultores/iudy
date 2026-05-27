<?php
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=calendario_pagos.xls");
header("Pragma: no-cache");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Expires: 0");

  require('../php/clases/class.php');
  $t=new Trabajo();
  $Inicio = $_GET['Inicio'];
  $Final = $_GET['Final'];
  $sql_mat=$t->get_calen_pagos($Inicio,$Final);

  ?>
  <meta charset="utf-8">
  <div class="box-header">
    <h3 class="box-title"><i class="fa fa-fw fa-toggle-right"></i> </h3>
  </div>
  <div class="box-body">
    <table class="table table-striped" style="font-size: 12px; font-family: Arial, Helvetica, sans-serif;">
      <tbody>
        <tr>
          <td colspan="11" style="text-align: center; font-size: 14px;"><b>REPORTE DE CALENDARIO DE PAGOS CON RANGO DE FECHA DEL <?php echo $Inicio; ?> AL <?php echo $Final; ?></b></td>
        </tr>
        <th style="width: 20px;"></th>
        <th>PLAN DE ESTUDIOS</th>
        <th>NOMBRE DE LA MATERIA</th>
        <th>NOMBRE DEL DOCENTE</th>
        <th>GRUPO</th>
        <th>DÍA</th>
        <th>FECHA PAGO PROX</th>
        <th style="text-align: right;">MONTO</th>
        <th>ESTATUS</th>
        <th>FEC. PAGADO</th>
        <th style="text-align: right;">MONTO PAGADO</th>
        <?php $_a = 0; $sum = 0; $sp = 0;
        for ($i=0;$i< sizeof($sql_mat);$i++) { ?>
        <tr>
          <td><b><?php echo $_a = ($_a + 1); ?>.- </b></td>
          <td><?php echo $sql_mat[$i]['Educativa']; ?></td>
          <td><?php echo $sql_mat[$i]['NombreMod']; ?></td>
          <td><?php echo $sql_mat[$i]['APaterno'].' '.$sql_mat[$i]['AMaterno'].' '.$sql_mat[$i]['Nombre']; ?></td>
          <td><?php echo $sql_mat[$i]['CveGrupo']; ?></td>
          <td><?php echo $sql_mat[$i]['_Dias']; ?></td>
          <td><?php echo $sql_mat[$i]['Fec_pago']; ?></td>
          <td style="width: 100px; text-align: right;">$ <?php echo number_format($sql_mat[$i]['Monto'], 2, '.', ','); ?></td>
          <td <?php if($sql_mat[$i]['_idEstatus'] == 60){ echo "style='color: blue; '"; } else { echo "style='color: red; '"; } ?>><?php echo $sql_mat[$i]['Estatus']; ?></td>
          <td><?php echo $sql_mat[$i]['_fecPago']; ?></td>
          <td style="width: 100px; text-align: right;">$ <?php echo number_format($sql_mat[$i]['_monto'], 2, '.', ','); ?></td>
        </tr>
        <?php $sum = ($sum + $sql_mat[$i]['Monto']); $sp = ($sp + $sql_mat[$i]['_monto']); }  ?>
        <tr>
          <td colspan="7" style="text-align: right;"><b>Suma total por pagar:</b></td>
          <td style="text-align: right;"><b>$ <?php echo number_format($sum, 2, '.', ','); ?></b></td>
          <td colspan="2" style="text-align: right;"><b>Suma total pagado:</b></td>
          <td style="text-align: right;"><b>$ <?php echo number_format($sp, 2, '.', ','); ?></b></td>
        </tr>
   </tbody></table>

 </div>
