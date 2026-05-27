<?php
  header("Content-type: application/vnd.ms-excel");
  header("Content-Disposition: attachment; filename=Reporte_de_ingresos_banco.xls");
  header("Pragma: no-cache");
  header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
  header("Expires: 0");

  require('../clases/class.System.php');
    require('../../hace.php');
    $db = new Conexion();
    $fecha1 = $_GET['Fecha1'];
    $fecha2 = $_GET['Fecha2'];
    $IdBanco = $_GET['IdBanco'];
    $condx = "";
    if($IdBanco == 9999){
      $cond_x = "";
    } else {
      $cond_x = "AND tblp_foliospago.IdBanco =  '$IdBanco'";
    }

    $sql_ingresos = $db->query("SELECT
  tblp_foliospago.IdFolio,
  tblp_foliospago.NoFolio,
  tblp_foliospago.IdPago,
  tblp_foliospago.Estatus,
  tblp_foliospago.FecCap,
  tblp_foliospago.FecPago,
  tblp_foliospago.Monto,
  tblp_foliospago.Folio,
  tblp_foliospago.IdUsua,
  tblp_foliospago.IdEstatus,
  tblp_pagos.FecDesc,
  tblp_pagos.IdOferta,
  tblc_conceptosplanes.NomPlan,
  tblc_formapago.Descripcion,
  tblc_bancos.Banco,
  tblp_educativa.Nombre AS Educativa,
  tblc_usuario.Nombre,
  tblc_usuario.APaterno,
  tblc_usuario.AMaterno
  FROM
  tblp_foliospago
  Left Join tblp_pagos ON tblp_pagos.IdPago = tblp_foliospago.IdPago
  Left Join tblc_conceptosplanes ON tblc_conceptosplanes.IdConceptoPlanes = tblp_pagos.IdConceptoPlan
  Left Join tblc_formapago ON tblc_formapago.IdFormaPago = tblp_foliospago.IdForma
  Left Join tblc_bancos ON tblc_bancos.IdBanco = tblp_foliospago.IdBanco
  Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_pagos.IdOferta
  Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_foliospago.IdUsua
  WHERE tblp_foliospago.FecPago BETWEEN '$fecha1 00:00:00' AND '$fecha2 23:59:59' $cond_x
  ORDER BY tblp_pagos.IdOferta ASC, tblp_foliospago.FecCap ");
  $datos = $db->recorrer($sql_ingresos);
  $banc = $datos["Banco"];

    $sql_dat = $db->query("SELECT * FROM tblp_configuracion WHERE tblp_configuracion.IdConfig = '2'  ");
    $datos81 = $db->recorrer($sql_dat);
    $uni = $datos81["Descripcion"];


?>
<html>
  <head>
    <META HTTP-EQUIV= "Content-Type" CONTENT="text/html; charset=utf-8" />
    <META http-equiv="Content-Language" content="es" />
  </head>
  <body>
    <table style=" color: #0073b7; font-size: 16px; ">
      <tr><td style="text-align: center;" colspan="11"><b><?php echo $uni; ?></b></td></tr>
    </table>
    <br>
    <table style="font-size: 12px;">
      <thead>
        <tr>
            <td colspan='10' style="text-align: center; "><b>REPORTES DE INGRESOS <?php if($IdBanco == 9999){ echo " DE TODOS LOS BANCOS"; } else { echo "DE ".$banc;} ?> <br>
            Con fecha <?php echo obtenerFechaEnLetra($fecha1); ?> al <?php echo obtenerFechaEnLetra($fecha2); ?></b><br>
            </td>
        </tr>
        <tr style="background: #5a284f; color: #fbeb00;">
          <th>#</th>
          <th>Fec. Captura</th>
          <th>Folio</th>
          <th>Fec.Pago</th>
          <th>Usuario</th>
          <th>Plan de estudios</th>
          <th>Plan de pago</th>
          <th>Forma pago</th>
          <th>Banco</th>
          <th style='width: 90px; text-align: right;'>Monto</th>
        </tr>
      </thead>
      <tbody>
        <?php $o_i = 0; $o_f = 0; $_sum = 0; $x = 0;
         while($_ingresos = $db->recorrer($sql_ingresos)){ $o_i = $_ingresos["IdOferta"];
           if($o_i <> $o_f){ ?>
             <tr style="background: #003A70; color: white;">
               <td colspan="2"><b>PLAN DE ESTUDIOS:</b></td>
               <td colspan="8"><?php echo $_ingresos["Educativa"]; ?></td>
             </tr>
           <?php } ?>
        <tr>
          <td><b><?php echo $x = $x + 1; ?>.- </b></td>
          <td><?php echo $_ingresos["FecCap"]; ?></td>
          <td><?php echo $_ingresos["NoFolio"]; ?></td>
          <td><?php echo $_ingresos["FecPago"]; ?></td>
          <td><?php echo $_ingresos["Nombre"].' '.$_ingresos["APaterno"].' '.$_ingresos["AMaterno"]; ?></td>
          <td><?php echo $_ingresos["Educativa"]; ?></td>
          <td><?php echo $_ingresos["NomPlan"]; ?><br><?php echo obtenerAnioMes($_ingresos["FecDesc"]); ?> </td>
          <td><?php echo $_ingresos["Descripcion"];  ?></td>
          <td><?php echo $_ingresos["Banco"];  ?></td>
          <td style='text-align: right;'>$ <?php echo number_format($_ingresos["Monto"], 2, '.', ','); ?></td>
        </tr>
        <?php $_sum = ($_sum + $_ingresos["Monto"]); $o_f = $_ingresos["IdOferta"]; } ?>
        <tr style="background: #e6e6e6; color: black;">
          <th colspan='9' style='text-align: right;'>Total ingreso:</th>
          <th style='width: 90px; text-align: right;'>$ <?php echo number_format($_sum, 2, '.', ','); ?></th>
        </tr>
      </tbody>
    </table>
  </body>
</html>
