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

  $IdCiclo = $_GET['IdCiclo'];
  $IdGrupo = $_GET['IdGrupo'];

$porciones = explode("_", $IdGrupo);
$grado = $porciones[0]; // porción1
$IdGrupo=  $porciones[1]; // porción2

  $sql_mat_lsta = $db->query("SELECT
tblp_pagos.IdPago,
tblp_pagos.IdUsua,
tblc_usuario.Usuario,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno
FROM
tblp_pagos
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_pagos.IdUsua
WHERE
tblp_pagos.IdCiclo =  '$IdCiclo' AND
tblp_pagos.IdGrupo =  '$IdGrupo'
GROUP BY
tblp_pagos.IdUsua ORDER BY tblc_usuario.APaterno ASC

");

  $sql_cic = $db->query("SELECT tblc_ciclo.Ciclo FROM tblc_ciclo WHERE tblc_ciclo.IdCiclo = '$IdCiclo'");
  $db->rows($sql_cic);
  $_cic = $db->recorrer($sql_cic);

  $sql_grp = $db->query("SELECT tblp_grupo.CveGrupo, tblp_grupo.TipoCiclo FROM tblp_grupo WHERE tblp_grupo.IdGrupo = '$IdGrupo'");
  $db->rows($sql_grp);
  $_grp = $db->recorrer($sql_grp);
  if($_grp['TipoCiclo'] == 'C') { $_txG = 'CUATRIMESTRE'; } else { $_txG = 'SEMESTRE'; }

  $sql_pagx = $db->query("SELECT tblp_pagos.IdCalendario, tblc_conceptos.NomConcepto, tblp_pagos.FecDesc FROM tblp_pagos Left Join tblc_conceptos ON tblc_conceptos.IdConcepto = tblp_pagos.IdConcepto WHERE tblp_pagos.IdCiclo =  '$IdCiclo' AND tblp_pagos.IdGrupo =  '$IdGrupo' GROUP BY tblp_pagos.IdCalendario ORDER BY tblp_pagos.FecDesc ASC");
  $sql_pagz = $db->query("SELECT tblp_pagos.IdCalendario, tblc_conceptos.NomConcepto, tblp_pagos.FecDesc FROM tblp_pagos Left Join tblc_conceptos ON tblc_conceptos.IdConcepto = tblp_pagos.IdConcepto WHERE tblp_pagos.IdCiclo =  '$IdCiclo' AND tblp_pagos.IdGrupo =  '$IdGrupo' GROUP BY tblp_pagos.IdCalendario ORDER BY tblp_pagos.FecDesc ASC");
  $sql_pagw = $db->query("SELECT tblp_pagos.IdCalendario, tblc_conceptos.NomConcepto, tblp_pagos.FecDesc FROM tblp_pagos Left Join tblc_conceptos ON tblc_conceptos.IdConcepto = tblp_pagos.IdConcepto WHERE tblp_pagos.IdCiclo =  '$IdCiclo' AND tblp_pagos.IdGrupo =  '$IdGrupo' GROUP BY tblp_pagos.IdCalendario ORDER BY tblp_pagos.FecDesc ASC");

  $hoy = date("Y-m-d");

  $sql_pag_lsta = $db->query("SELECT
    tblc_usuario.IdUsua,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.Usuario,
tblp_pagos.IdPago,
tblp_pagos.IdUsua,
tblp_pagos.Monto,
tblp_pagos.Pagar,
tblp_pagos.FecDesc,
tblp_pagos.Recargos,
tblp_pagos.Descuento,
tblp_pagos.Descuento2,
tblp_pagos.IdCalendario,
tblc_conceptosplanes.NomPlan
FROM
tblp_pagos
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_pagos.IdUsua
Left Join tblp_calendario ON tblp_calendario.IdCalendario = tblp_pagos.IdCalendario
Left Join tblc_conceptosplanes ON tblc_conceptosplanes.IdConceptoPlanes = tblp_calendario.IdConceptosPlanes AND tblc_conceptosplanes.IdConceptoPlanes = tblp_pagos.IdConceptoPlan
WHERE
tblp_pagos.IdEstatus <>  '4' AND
tblp_pagos.IdCiclo =  '$IdCiclo' AND
tblp_pagos.IdGrupo =  '$IdGrupo' AND
tblp_pagos.FecDesc <  '$hoy'
ORDER BY
tblp_pagos.IdConceptoPlan ASC

");

  ?>

<meta charset="utf-8">
  <div class="box-body">
    <div class="bg-purple-active color-palette" style="padding: 8px;"><span style="color: blue;"><b><i class="fa fa-fw fa-check-square-o"></i> PERIODO ESCOLAR: </b></span><?php echo $_cic["Ciclo"]; ?></div>
    <table class="table table-striped" style="font-size: 12px;">
      <tbody>
        <tr style="background: #a6a6a6;">
          <td>NO.CONTROL</td>
          <td>NOMBRE DEL ALUMNO</td>
          <td>FECHA DE PAGO</td>
          <td>MONTO</td>
        </tr>
      <?php $p_i=0; $p_f=0; $sux = 0; while($maty = $db->recorrer($sql_pag_lsta)){ $p_i=$maty['IdCalendario'];
        $sql8 = $db->query("SELECT Sum(tblp_recargos.Monto) AS Recargo FROM tblp_recargos WHERE tblp_recargos.IdUsua = '".$maty['IdUsua']."' AND tblp_recargos.IdPago = '".$maty['IdPago']."' AND tblp_recargos.IdEstatus = '8'");
        $db->rows($sql8);
        $datos81 = $db->recorrer($sql8);
        $recargo = $datos81["Recargo"];
        $montox = ($maty["Monto"] + $recargo - $maty["Descuento"] - $maty["Descuento2"]);

        if($p_i <> $p_f){ if($p_f <> 0){ ?>
          <tr>
            <td colspan="3" style="text-align: right;"><b>TOTAL:</b></td>
            <td style="background: yellow;"><b>$ <?php echo number_format($sux, 2, '.', ','); ?></b></td>
          </tr><?php } ?>
          <tr style="background: #d6e1ff;">
            <td colspan="4"><b>PLAN DE PAGO:</b> <?php echo $maty['NomPlan'].' '.obtener_MesMAY($maty['FecDesc']); ?></td>
          </tr>
        <?php $sux = 0; } $sux = ($sux + $montox);
         ?>
      <tr>
        <td><?php echo $maty['Usuario']; ?></td>
        <td><?php echo $maty['Nombre'].' '.$maty['APaterno'].' '.$maty['AMaterno']; ?></td>
        <td><?php echo $maty['FecDesc']; ?></td>
        <td>$ <?php echo number_format($montox, 2, '.', ','); ?></td>
      </tr><?php $p_f=$maty['IdCalendario']; } ?>
      <tr>
        <td colspan="3" style="text-align: right;"><b>TOTAL:</b></td>
        <td style="background: yellow;"><b>$ <?php echo number_format($sux, 2, '.', ','); ?></b></td>
      </tr>


    </tbody></table>
  </div>
