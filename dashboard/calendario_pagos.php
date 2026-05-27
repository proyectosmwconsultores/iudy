<?php
  require('../php/clases/class.php');
  $t=new Trabajo();
  $Inicio = $_POST['Inicio'];
  $Final = $_POST['Final'];
  $sql_mat=$t->get_calen_pagos($Inicio,$Final);

  ?>
  <div class="box-header">
    <h3 class="box-title"><i class="fa fa-fw fa-toggle-right"></i> Reporte de calendario de pagos</h3>
  </div>
  <div class="box-body">
    <table class="table table-striped" style="font-size: 12px;">
      <tbody>
        <tr>
          <th style="width: 10px;"></th>
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
        </tr>
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

 </div><br>
 <?php if($_a){ ?>
  <button onClick="window.open('dashboard/calendario_pagos_ex.php?Inicio=<?php echo $Inicio; ?>&Final=<?php echo $Final; ?>','_self')" href="javascript:void(0);" type="button" class="btn btn-block btn-danger btn-xs"><i class="fa fa-fw fa-cloud-download"></i> Descargar excel</button>
<?php } ?>
