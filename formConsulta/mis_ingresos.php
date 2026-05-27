<?php
require('../php/clases/class.System.php');
  require('../hace.php');
  $db = new Conexion();
  $fecha1 = $_POST['Inicio'];
  $fecha2 = $_POST['Final'];
  $IdPlan = $_POST['IdPlan'];
  $condx = "";
  if($IdPlan == 9999){
    $condx = "";
  } else {
    $condx = "AND tblp_pagos.IdConceptoPlan =  '$IdPlan'";
  }

echo "SELECT tblp_foliospago.IdFolio, tblp_foliospago.NoFolio, tblp_foliospago.IdPago, tblp_foliospago.Estatus, tblp_foliospago.FecCap, tblp_foliospago.FecPago, tblp_foliospago.Monto, tblp_foliospago.Folio, tblp_foliospago.IdUsua, tblp_foliospago.IdEstatus, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Usuario, tblp_pagos.FecDesc, tblp_pagos.IdOferta, tblc_conceptosplanes.NomPlan, tblc_formapago.Descripcion, tblc_bancos.Banco, tblp_educativa.Nombre AS Educativa FROM tblp_foliospago Left Join tblp_pagos ON tblp_pagos.IdPago = tblp_foliospago.IdPago Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_pagos.IdUsua Left Join tblc_conceptosplanes ON tblc_conceptosplanes.IdConceptoPlanes = tblp_pagos.IdConceptoPlan Left Join tblc_formapago ON tblc_formapago.IdFormaPago = tblp_foliospago.IdForma  Left Join tblc_bancos ON tblc_bancos.IdBanco = tblp_foliospago.IdBanco Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_pagos.IdOferta WHERE tblp_foliospago.FecPago BETWEEN  '$fecha1 00:00:00' AND '$fecha2 23:59:59' $condx ORDER BY tblp_pagos.IdOferta ASC, tblp_foliospago.FecCap ";
  $sql_ingresos = $db->query("SELECT tblp_foliospago.IdFolio, tblp_foliospago.NoFolio, tblp_foliospago.IdPago, tblp_foliospago.Estatus, tblp_foliospago.FecCap, tblp_foliospago.FecPago, tblp_foliospago.Monto, tblp_foliospago.Folio, tblp_foliospago.IdUsua, tblp_foliospago.IdEstatus, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Usuario, tblp_pagos.FecDesc, tblp_pagos.IdOferta, tblc_conceptosplanes.NomPlan, tblc_formapago.Descripcion, tblc_bancos.Banco, tblp_educativa.Nombre AS Educativa FROM tblp_foliospago Left Join tblp_pagos ON tblp_pagos.IdPago = tblp_foliospago.IdPago Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_pagos.IdUsua Left Join tblc_conceptosplanes ON tblc_conceptosplanes.IdConceptoPlanes = tblp_pagos.IdConceptoPlan Left Join tblc_formapago ON tblc_formapago.IdFormaPago = tblp_foliospago.IdForma  Left Join tblc_bancos ON tblc_bancos.IdBanco = tblp_foliospago.IdBanco Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_pagos.IdOferta WHERE tblp_foliospago.FecPago BETWEEN  '$fecha1 00:00:00' AND '$fecha2 23:59:59' $condx ORDER BY tblp_pagos.IdOferta ASC, tblp_foliospago.FecCap ");

  $sql_banco = $db->query("SELECT
tblp_foliospago.IdFolio,
Sum(tblp_foliospago.Monto) AS Suma,
tblc_bancos.Banco
FROM
tblp_foliospago
Left Join tblc_bancos ON tblc_bancos.IdBanco = tblp_foliospago.IdBanco
WHERE tblp_foliospago.FecPago BETWEEN  '$fecha1 00:00:00' AND '$fecha2 23:59:59' $condx
GROUP BY
tblp_foliospago.IdBanco
ORDER BY
tblp_foliospago.FecCap ASC

");

  ?>
  <div class="row">
      <div class="col-md-12">
        <div class="box-body no-padding">
          <table id="datatable" class="table table-striped" style="font-size: 12px;">
            <thead>
              <tr>
                  <td colspan='10' style="text-align: center; font-family: 'Source Sans Pro',sans-serif"><b>REPORTES DE INGRESOS<br>
                  Con fecha <?php echo obtenerFechaEnLetra($_POST["Inicio"]); ?> al <?php echo obtenerFechaEnLetra($_POST["Final"]); ?></b><br>
                  </td>
              </tr>
              <tr style="background: #5a284f; color: #fbeb00;">
                <th>#</th>
                <th>Fec. Captura</th>
                <th>Folio</th>
                <th>Fec.Pago</th>
                <th>Usuario</th>
                <th>Alumno</th>
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
                <td><?php echo $_ingresos["Usuario"];  ?></td>
                <td><?php echo $_ingresos["Nombre"].' '.$_ingresos["APaterno"].' '.$_ingresos["AMaterno"]; ?></td>
                <td><?php echo $_ingresos["NomPlan"]; ?><br><?php echo obtenerAnioMes($_ingresos["FecDesc"]); ?> </td>
                <td><?php echo $_ingresos["Descripcion"];  ?></td>
                <td><?php echo $_ingresos["Banco"];  ?></td>
                <td style='text-align: right;'>$ <?php echo number_format($_ingresos["Monto"], 2, '.', ','); ?></td>
              </tr>
              <?php $_sum = ($_sum + $_ingresos["Monto"]); $o_f = $_ingresos["IdOferta"]; } ?>
              <tr style="background: #e6e6e6; color: black;">
                <th colspan='2' style='text-align: center;'>
                  <button onClick="window.open('formConsulta/exp_ingresos.php?IdPlan=<?php echo $IdPlan; ?>&Fecha1=<?php echo $fecha1; ?>&Fecha2=<?php echo $fecha2; ?>','_self')" href="javascript:void(0);" type="button" class="btn btn-block btn-danger btn-xs"><i class="fa fa-fw fa-cloud-download"></i> Descargar excel</button>
                </th>
                <th colspan='7' style='text-align: right;'>Total ingreso:</th>
                <th style='width: 90px; text-align: right;'>$ <?php echo number_format($_sum, 2, '.', ','); ?></th>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <div class="col-md-6">
        <table class="table table-striped" style="font-size: 12px;">
          <tbody>
            <tr style="background: #345980; color: white;">
              <td colspan="2"><i class="fa fa-fw fa-bank"></i> Suma de gastos por banco</td>
            </tr>
            <?php $sx = 0;
            while($_banco = $db->recorrer($sql_banco)){ ?>
            <tr>
              <td style="text-align: right;"><?php echo $_banco['Banco']; ?>:</td>
              <td style="text-align: right;">$ <?php echo number_format($_banco['Suma'], 2, '.', ','); ?></td>
            </tr>
            <?php $sx = ($sx + $_banco['Suma']); } ?>
            <tr>
              <td style="text-align: right;"><b>TOTAL:</b></td>
              <td style="text-align: right; width: 150px;"><b>$ <?php echo number_format($sx, 2, '.', ','); ?></b></td>
            </tr>
        </tbody></table>
      </div>
      <div class="col-md-6">
        <table id="datatable_banco" style="display: none;">
          <thead>
            <tr>
              <th></th>
              <?php while($_bancox = $db->recorrer($sql_banco)){ ?>
              <th><?php echo $_bancox['Banco']; ?></th><?php } ?>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th>Pesos</th>
              <?php while($_bancox = $db->recorrer($sql_banco)){ ?>
              <td><?php echo $_bancoy['Suma']; ?></td><?php } ?>
            </tr>

          </tbody>
        </table>
        <div id="container_banco"></div>
      </div>
  </div>

<script>
Highcharts.chart('container_banco', {
  data: {
    table: 'datatable_banco'
  },
  chart: {
    type: 'column'
  },
  title: {
    text: 'Suma de gastos por banco'
  },
  yAxis: {
    allowDecimals: false,
    title: {
      text: 'Pesos'
    }
  },
  tooltip: {
    formatter: function () {
      return '<b>' + this.series.name + '</b><br/>$ ' +
        this.point.y + ' ' + this.point.name.toLowerCase();
    }
  }
});
</script>
