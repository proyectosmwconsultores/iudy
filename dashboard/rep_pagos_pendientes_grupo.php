<?php
  session_start();
  $IdUsua = $_SESSION['IdUsua'];
  require('../php/clases/class.System.php');
  require('../hace.php');
  $db = new Conexion();

  $IdCiclo = $_POST['IdCiclo'];
  $IdGrupo = $_POST['IdGrupo'];

$porciones = explode("_", $IdGrupo);
$grado = $porciones[0]; // porción1
$IdGrupo=  $porciones[1]; // porción2
$mto = 0;
$Hoy = date("Y-m-d");
$sql = $db->query("SELECT tblp_pagos.MesRecargo, tblp_pagos.FecDesc, tblp_pagos.FecBase, tblp_pagos.FecLim, tblp_pagos.IdPago, tblp_pagos.IdCiclo, tblp_pagos.IdUsua, tblp_pagos.Monto, tblp_pagos.IdConceptoPlan, tblp_pagos.IdConcepto FROM tblp_pagos WHERE tblp_pagos.IdGrupo = '$IdGrupo' AND tblp_pagos.IdCiclo = '$IdCiclo' AND tblp_pagos.IdEstatus <> '4'");
while($x = $db->recorrer($sql)){
  $IdPago = $x["IdPago"];
  $IdPlan = $x["IdConcepto"];
  $Monto = $x["Monto"];
  $_IdUsua = $x["IdUsua"];
  $_IdCiclo = $x["IdCiclo"];
  $MesRecargo = $x["MesRecargo"];
  $sqlx9 = $db->query("SELECT * FROM tblp_beca WHERE tblp_beca.IdConcepto = '$IdPlan' AND tblp_beca.IdUsua = '$_IdUsua' AND tblp_beca.IdCiclo = '$_IdCiclo' AND tblp_beca.IdEstatus = '8' ");
  $db->rows($sqlx9);
  $datosx91 = $db->recorrer($sqlx9);
  $IdBeca = $datosx91['IdBeca'];
  $Porcentaje = $datosx91['Porcentaje'];

  if($Porcentaje){
    $deta = ($Monto / 100);
    $descP = ($deta * $Porcentaje);
    $descP = $descP - $mto;

    $insertar = $db->query("UPDATE tblp_pagos SET tblp_pagos.Descuento = '$descP', tblp_pagos.IdBeca = '$IdBeca' WHERE tblp_pagos.IdPago= '$IdPago' ");
  } else {
    $insertar = $db->query("UPDATE tblp_pagos SET tblp_pagos.Descuento = '0' WHERE tblp_pagos.IdPago= '$IdPago' ");
  }


  // if(!$MesRecargo){
  //   $rec = 0;
  //   $recF = 0;
  //   $IdPago = $x["IdPago"];
  //   $IdConPlan = $x["IdConceptoPlan"];
  //   $FecDes = $x["FecDesc"];
  //   $FecBas = $x["FecBase"];
  //   $FecLim = $x["FecLim"];
  //   if($Hoy < $FecDes){
  //     $IdE = 32; $FecLimP = $x["FecDesc"];
  //   }elseif($Hoy == $FecDes){
  //     $IdE = 33; $FecLimP = $Hoy;
  //   } elseif($Hoy == $FecBas){ $rec = 1;
  //     $IdE = 34; $FecLimP = $Hoy;
  //   } elseif($Hoy == $FecLim){ $rec = 1;
  //     $IdE = 35; $FecLimP = $Hoy;
  //   } elseif($Hoy > $FecLim){ $rec = 1;
  //     $IdE = 36;
  //     $sql7 = $db->query("SELECT * FROM tblp_recargos WHERE tblp_recargos.IdUsua = '$_IdUsua' AND tblp_recargos.IdPago = '$IdPago' AND tblp_recargos.IdEstatus =  '8' ORDER BY tblp_recargos.FechaLim DESC");
  //     $db->rows($sql7);
  //     $datos71 = $db->recorrer($sql7);
  //     $FecLimP = $datos71["FechaLim"];
  //   }
  //
  //   if($rec == 1){
  //     $AnioMes = date("Y-m");
  //     $sql9 = $db->query("SELECT * FROM tblp_recargos WHERE tblp_recargos.IdUsua =  '$_IdUsua' AND tblp_recargos.AnioMes= '$AnioMes' AND tblp_recargos.IdPago = '$IdPago' AND tblp_recargos.IdEstatus =  '8'");
  //     $db->rows($sql9);
  //     $datos91 = $db->recorrer($sql9);
  //     $IdR = $datos91["IdRecargo"];
  //     if(!$IdR){
  //
  //       $sql8 = $db->query("SELECT * FROM tblc_conceptosplanes WHERE tblc_conceptosplanes.IdConceptoPlanes =  '$IdConPlan'");
  //       $db->rows($sql8);
  //       $datos81 = $db->recorrer($sql8);
  //       $Recar = $datos81["Recargo"];
  //
  //        $anio = substr($FecDes, 0, 4);
  //        $mes = substr($FecDes, 5, 2);
  //        $dia = substr($FecDes, 8, 2);
  //        $mes = ($mes + 1);
  //        if($mes > 12){
  //          $mes = 1;
  //          $anio = ($anio + 1);
  //        }
  //        $FecLimP = $anio.'-'.$mes.'-'.$dia;
  //        $insertar = $db->query("INSERT INTO tblp_recargos (IdPago, IdUsua, AnioMes, Monto, IdEstatus, FechaLim, FecCap, Filtro) VALUES ('$IdPago','$_IdUsua','$AnioMes','$Recar','8','$FecLimP',NOW(),'1')");
  //        $Mses = date("m");
  //        $insertar = $db->query("UPDATE tblp_pagos SET tblp_pagos.MesRecargo = '$Mses' WHERE tblp_pagos.IdPago = '$IdPago'");
  //     }
  //   }
  //
  //   $insertar = $db->query("UPDATE tblp_pagos SET  tblp_pagos._idEstatus = '$IdE', tblp_pagos.FecLimPago = '$FecLimP' WHERE tblp_pagos.IdPago = '$IdPago'");
  //
  // }
}


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


  <div class="box-body">
    <div class="bg-aqua-active color-palette" style="padding: 8px; text-align: center;"><span style="color: white; text-align: center;"><b><i class="fa fa-fw fa-calendar-o"></i> PAGOS PENDIENTES CON CORTE AL DIA DE HOY <?php echo obtenerFechaCorta_May(date("Y-m-d")); ?></b></span></div>
    <br>
    <div class="bg-purple-active color-palette" style="padding: 8px;"><span style="color: yellow;"><b><i class="fa fa-fw fa-check-square-o"></i> PERIODO ESCOLAR: </b></span><?php echo $_cic["Ciclo"]; ?></div>
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



   <button onClick="window.open('dashboard/rep_pagos_pendientes_grupo_ex.php?IdCiclo=<?php echo $_POST['IdCiclo']; ?>&IdGrupo=<?php echo $_POST['IdGrupo']; ?>','_self')" href="javascript:void(0);" type="button" class="btn btn-block btn-danger btn-xs"><i class="fa fa-fw fa-cloud-download"></i> Descargar excel</button>
 
