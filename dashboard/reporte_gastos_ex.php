<?php
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=gastos_generados.xls");
header("Pragma: no-cache");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Expires: 0");
  require('../php/clases/consulta_class.php');
  $t=new Consultas();
  $Anio = $_GET['Anio'];

  include('../hace.php');
  $lst_gasto=$t->get_gastos_lst($Anio);
//  $sum_area=$t->get_sum_area($Inicio,$Final);
//  $sum_concep=$t->get_sum_concep($Inicio,$Final);
//  $anioMes = date("Y-m");

  ?>
<meta charset="utf-8">
  <div class="bg-maroon-active color-palette" style="padding: 5px; font-family: arial; font-size: 14px;"><span><i class="fa fa-fw fa-bookmark-o"></i> Reporte de gastos en general del año: <?php echo $Anio;  ?></span></div>
  <br>

  <table class="table table-striped" style="font-size: 10px; font-family: arial;">
    <tbody>
      <tr>
        <th style="background: #c9ff67;">CHEQUE</th>
        <th style="background: #c9ff67;">FECHA</th>
        <th style="background: #c9ff67;">BENEFICIARIO</th>
        <th style="background: #c9ff67;">IMPORTE</th>
        <th style="background: #c9ff67;">CONCEPTO</th>
        <th style="background: #c9ff67;">DESCRIPCION</th>
        <th style="background: #c9ff67;">PARTIDA</th>
        <th style="width: 85px; background: #c6afaf;">DOCTORADO</th>
        <th style="width: 85px; background: #72a600;">MAESTRÍA</th>
        <th style="width: 85px; background: #98adff;">LICENCIATURA</th>
        <th style="width: 85px; background: #a293b0;">DIPLOMADO</th>
        <th style="width: 85px; background: #ea7878;">CURSO</th>
        <th style="text-align: right; width: 90px; background: yellow;">IMPORTE</th>
      </tr>
      <tbody>
        <?php $bi=0; $bf=0; $s = 0;
        for ($x=0;$x< sizeof($lst_gasto);$x++) {
            $val1=$t->get_sum_gas_nivel($lst_gasto[$x]['IdGasto'],1);
            $val2=$t->get_sum_gas_nivel($lst_gasto[$x]['IdGasto'],2);
            $val3=$t->get_sum_gas_nivel($lst_gasto[$x]['IdGasto'],3);
            $val4=$t->get_sum_gas_nivel($lst_gasto[$x]['IdGasto'],4);
            $val5=$t->get_sum_gas_nivel($lst_gasto[$x]['IdGasto'],5);
          ?>
        <tr <?php if($lst_gasto[$x]['IdEstatus'] == 10){ echo "style='color: red; '"; } else { echo ""; } ?>>
          <td style="border: 1px solid #f4f4f4; text-align: left;"><?php echo $lst_gasto[$x]['Cheque']; ?></td>
          <td style="border: 1px solid #f4f4f4;"><?php echo $lst_gasto[$x]['Fecha']; ?></td>
          <td style="border: 1px solid #f4f4f4;"><?php echo $lst_gasto[$x]['Beneficiario']; ?></td>
          <td style="text-align: right; border: 1px solid #f4f4f4;">$ <?php echo number_format($lst_gasto[$x]['Importe'], 2, '.', ','); ?></td>
          <td style="border: 1px solid #f4f4f4;"><?php echo $lst_gasto[$x]['Nombre_gasto2']; ?></td>
          <td style="border: 1px solid #f4f4f4;"><?php echo $lst_gasto[$x]['Descripcion']; ?></td>
          <td style="border: 1px solid #f4f4f4;"><?php echo $lst_gasto[$x]['Partida']; ?></td>
          <td style="text-align: right; border: 1px solid #f4f4f4;">$ <?php echo number_format($val1[0]['Total'], 2, '.', ','); ?></td>
          <td style="text-align: right; border: 1px solid #f4f4f4;">$ <?php echo number_format($val2[0]['Total'], 2, '.', ','); ?></td>
          <td style="text-align: right; border: 1px solid #f4f4f4;">$ <?php echo number_format($val3[0]['Total'], 2, '.', ','); ?></td>
          <td style="text-align: right; border: 1px solid #f4f4f4;">$ <?php echo number_format($val4[0]['Total'], 2, '.', ','); ?></td>
          <td style="text-align: right; border: 1px solid #f4f4f4;">$ <?php echo number_format($val5[0]['Total'], 2, '.', ','); ?></td>
          <td style="text-align: right; border: 1px solid #f4f4f4;">$ <?php echo number_format($lst_gasto[$x]['Importe'], 2, '.', ','); ?></td>
        </tr>
        <?php } ?>
    </tbody></table>
    <br>
