<?php
session_start();
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=rep_pagos_pendientes_grupo.xls");
header("Pragma: no-cache");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Expires: 0");


  $IdUsua = $_SESSION['IdUsua'];
  require('../php/clases/class.System.php');
  require('../hace.php');
  $db = new Conexion();

  $IdCampus = $_GET['IdCampus'];
  $IdOferta = $_GET['IdOferta'];
  $hoy = date("Y-m-d");

  $sql_mat_lsta = $db->query("SELECT
tblp_pagos.IdPago,
tblp_pagos.Descuento,
Sum((tblp_pagos.Monto + tblp_pagos.Recargos - tblp_pagos.TotalPagado - tblp_pagos.Descuento)) AS Total,
tblp_pagos.IdGrupo,
tblp_grupo.CveGrupo,
tblp_grupo.TipoCiclo,
tblp_grupo.Grado,
tblc_modalidad._Modalidad,
tblc_dias_clases._Dias
FROM
tblp_pagos
Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblp_pagos.IdGrupo
Left Join tblc_modalidad ON tblc_modalidad.`Mod` = tblp_grupo.Modalidad
Left Join tblc_dias_clases ON tblc_dias_clases.Dia = tblp_grupo.Dia
WHERE
tblp_pagos.IdOferta =  '$IdOferta' AND
tblp_pagos.IdCampus =  '$IdCampus' AND
tblp_pagos.FecDesc <  '$hoy' AND
tblp_pagos.IdEstatus <>  '4'
GROUP BY
tblp_pagos.IdGrupo
ORDER BY
tblp_grupo.Oferta ASC,
tblp_grupo.Grado ASC
");

$sql_plan_lsta = $db->query("SELECT
tblp_pagos.IdPago,
tblp_pagos.Descuento,
Sum((tblp_pagos.Monto + tblp_pagos.Recargos - tblp_pagos.TotalPagado - tblp_pagos.Descuento)) AS Total,
tblp_pagos.IdCalendario,
tblc_conceptosplanes.NomPlan,
tblp_calendario.FecDescuento
FROM
tblp_pagos
Left Join tblp_calendario ON tblp_calendario.IdCalendario = tblp_pagos.IdCalendario
Left Join tblc_conceptosplanes ON tblc_conceptosplanes.IdConceptoPlanes = tblp_calendario.IdConceptosPlanes
WHERE
tblp_pagos.IdOferta =  '$IdOferta' AND
tblp_pagos.IdCampus =  '$IdCampus' AND
tblp_pagos.FecDesc <  '$hoy' AND
tblp_pagos.IdEstatus <>  '4'
GROUP BY
tblp_pagos.IdCalendario
ORDER BY
tblp_calendario.FecDescuento ASC

");

$sql_cic_lsta = $db->query("SELECT
tblp_pagos.IdPago,
tblp_pagos.Descuento,
Sum((tblp_pagos.Monto + tblp_pagos.Recargos - tblp_pagos.TotalPagado - tblp_pagos.Descuento)) AS Total,
tblp_pagos.IdCalendario,
tblp_pagos.IdCiclo,
tblc_ciclo.Ciclo
FROM
tblp_pagos
Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_pagos.IdCiclo
WHERE
tblp_pagos.IdOferta =  '$IdOferta' AND
tblp_pagos.IdCampus =  '$IdCampus' AND
tblp_pagos.FecDesc <  '$hoy' AND
tblp_pagos.IdEstatus <>  '4'
GROUP BY
tblp_pagos.IdCiclo
ORDER BY
tblc_ciclo.MesIni ASC


");


  ?>



<meta charset="utf-8">
  <div class="box-body">
    <div class="bg-aqua-active color-palette" style="padding: 8px; text-align: center;"><span style="color: red; text-align: center;"><b><i class="fa fa-fw fa-calendar-o"></i> PAGOS PENDIENTES CON CORTE AL DIA DE HOY <?php echo obtenerFechaCorta_May(date("Y-m-d")); ?></b></span></div>
    <br>
    <div class="bg-gray-active color-palette" style="padding: 8px;"><span style="color: black;"><b><i class="fa fa-fw fa-check-square-o"></i> PAGOS PENDIENTES POR GRUPO</b></span></div>
    <table class="table table-striped" style="font-size: 12px;">
      <tbody>
        <tr>
          <th></th>
          <th>GRUPO</th>
          <th>GRADO</th>
          <th>MODALIDAD</th>
          <th>($) MONTO</th>
        </tr>
      <?php $sux = 0; $g= 0; while($maty = $db->recorrer($sql_mat_lsta)){ ?>
      <tr>
        <td><b><?php echo $g = ($g + 1); ?>.- </b></td>
        <td><?php echo $maty['CveGrupo']; ?></td>
        <td><?php echo $maty['Grado']; ?>° <?php if($maty['TipoCiclo'] == 'C'){ echo "CUATRIMESTRE"; } else { echo "SEMESTRE"; } ?></td>
        <td><?php echo $maty['_Modalidad'].' '.$maty['_Dias']; ?></td>
        <td>$ <?php echo number_format($maty['Total'], 2, '.', ','); ?></td>
      </tr><?php $sux = ($sux + $maty['Total']); } ?>
      <tr>
        <td colspan="4" style="text-align: right;"><b>TOTAL:</b></td>
        <td style="background: yellow;"><b>$ <?php echo number_format($sux, 2, '.', ','); ?></b></td>
      </tr>


    </tbody></table>
  </div>


  <div class="box-body">
    <div class="bg-gray-active color-palette" style="padding: 8px;"><span style="color: black;"><b><i class="fa fa-fw fa-check-square-o"></i> PAGOS PENDIENTES POR PLAN DE PAGO</b></span></div>
    <table class="table table-striped" style="font-size: 12px;">
      <tbody>
        <tr>
          <th></th>
          <th>NOMBRE DEL PLAN DE PAGO</th>
          <th>($) MONTO</th>
        </tr>
      <?php $s_plan = 0; $g= 0; while($plan = $db->recorrer($sql_plan_lsta)){ ?>
      <tr>
        <td><b><?php echo $g = ($g + 1); ?>.- </b></td>
        <td><?php echo $plan['NomPlan'].' '.obtener_AnioMesMAY($plan['FecDescuento']); ?></td>
        <td>$ <?php echo number_format($plan['Total'], 2, '.', ','); ?></td>
      </tr><?php $s_plan = ($s_plan + $plan['Total']); } ?>
      <tr>
        <td colspan="2" style="text-align: right;"><b>TOTAL:</b></td>
        <td style="background: yellow;"><b>$ <?php echo number_format($s_plan, 2, '.', ','); ?></b></td>
      </tr>
    </tbody></table>
  </div>

  <div class="box-body">
    <div class="bg-gray-active color-palette" style="padding: 8px;"><span style="color: black;"><b><i class="fa fa-fw fa-check-square-o"></i> PAGOS PENDIENTES POR PERIODO ESCOLAR</b></span></div>
    <table class="table table-striped" style="font-size: 12px;">
      <tbody>
        <tr>
          <th></th>
          <th>NOMBRE DEL PERIODO ESCOLAR</th>
          <th>($) MONTO</th>
        </tr>
      <?php $s_cic = 0; $g= 0; while($cic = $db->recorrer($sql_cic_lsta)){ ?>
      <tr>
        <td><b><?php echo $g = ($g + 1); ?>.- </b></td>
        <td><?php echo $cic['Ciclo']; ?></td>
        <td>$ <?php echo number_format($cic['Total'], 2, '.', ','); ?></td>
      </tr><?php $s_cic = ($s_cic + $cic['Total']); } ?>
      <tr>
        <td colspan="2" style="text-align: right;"><b>TOTAL:</b></td>
        <td style="background: yellow;"><b>$ <?php echo number_format($s_cic, 2, '.', ','); ?></b></td>
      </tr>
    </tbody></table>
  </div>
