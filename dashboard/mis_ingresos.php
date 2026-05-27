<?php
require('../php/clases/consulta_class.php');
$con=new Consultas();
$fecha1 = $_POST['Inicio'];
$fecha2 = $_POST['Final'];
$IdPlan = $_POST['IdPlan'];
include('../hace.php');
$lst_ingreso=$con->get_ingresos_lst($fecha1,$fecha2,$IdPlan);

$sum_banco=$con->get_ing_banco($fecha1,$fecha2,$IdPlan);
$sum_concep=$con->get_ing_concep($fecha1,$fecha2,$IdPlan);
$sum_oferta=$con->get_ing_oferta($fecha1,$fecha2,$IdPlan);
$sum_grado=$con->get_ing_grado($fecha1,$fecha2,$IdPlan);

$sum_banco_campus=$con->get_ing_banco_campus($fecha1,$fecha2,$IdPlan);
$sum_concep_campus=$con->get_ing_concep_campus($fecha1,$fecha2,$IdPlan);
$sum_oferta_campus=$con->get_ing_oferta_campus($fecha1,$fecha2,$IdPlan);


 $lst_folios=$con->get_ingresos_folios($fecha1,$fecha2,$IdPlan);
 $pag_pend=$con->get_pagos_pendientes_all($fecha1,$fecha2,$IdPlan);


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
                <th>Campus</th>
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
              foreach($lst_ingreso as $lista){ $o_i = $lista["IdOferta"];
                 if($o_i <> $o_f){ ?>
                   <tr style="background: #003A70; color: white;">
                     <td colspan="3"><b>PLAN DE ESTUDIOS:</b></td>
                     <td colspan="8"><?php echo $lista["Educativa"]; ?></td>
                   </tr>
                 <?php } ?>
              <tr>
                <td><b><?php echo $x = $x + 1; ?>.- </b></td>
                <td><?php echo $lista["FecCap"]; ?></td>
                <td><?php echo $lista["NoFolio"]; ?></td>
                <td><?php echo $lista["Fecha"]; ?></td>
                <td><?php echo $lista["Campus"];  ?></td>
                <td><?php echo $lista["Usuario"];  ?></td>
                <td><?php echo $lista["Nombre"].' '.$lista["APaterno"].' '.$lista["AMaterno"]; ?></td>
                <td><?php echo $lista["NomPlan"]; ?> <?php echo obtener_AnioMesMAY($lista["Fecha"]); ?> </td>
                <td><?php echo $lista["Descripcion"];  ?></td>
                <td><?php echo $lista["NomBanco"];  ?></td>
                <td style='text-align: right;'>$ <?php echo number_format($lista["Monto"], 2, '.', ','); ?></td>
              </tr>
              <?php $_sum = ($_sum + $lista["Monto"]); $o_f = $lista["IdOferta"]; } ?>
              <tr style="background: #e6e6e6; color: black; font-size: 12px;">
                <th colspan='10' style='text-align: right;'>Total ingreso:</th>
                <th style='width: 90px; text-align: right; background: yellow;'>$ <?php echo number_format($_sum, 2, '.', ','); ?></th>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="col-md-12">
        <p style="text-align: center; font-size: 16px; padding: 10px;"><b>DESGLOSE DE INGRESOS IUDY</b></p>
      </div>

      <div class="col-md-12">
        <table class="table table-striped" style="font-size: 12px;">
          <tbody>
            <tr style="background: #345980; color: white;">
              <td colspan="3"><i class="fa fa-fw fa-qrcode"></i> Folios generados por usuario</td>
            </tr>
            <tr>
              <td><b>Nombre</b></td>
              <td style="text-align: center;"><b>Folio</b></td>
              <td style="text-align: right;"><b>Importe</b></td>
            </tr>
            <?php $sx = 0; $fo = 0; foreach($lst_folios as $foliosx){ ?>
            <tr>
              <td><?php echo $foliosx['Nombre']; ?> <?php echo $foliosx['APaterno']; ?> <?php echo $foliosx['AMaterno']; ?></td>
              <td style="text-align: center;"><?php echo $foliosx['Total']; ?></td>
              <td style="text-align: right;">$ <?php echo number_format($foliosx['Monto'], 2, '.', ','); ?></td>
            </tr>
            <?php $fo = ($fo + $foliosx['Total']); $sx = ($sx + $foliosx['Monto']);  } ?>
            <tr>
              <td style="text-align: right;"><b>TOTAL:</b></td>
              <td style="text-align: center; width: 150px;"><b> <?php echo $fo; ?></b></td>
              <td style="text-align: right; width: 150px;"><b>$ <?php echo number_format($sx, 2, '.', ','); ?></b></td>
            </tr>
        </tbody></table>
      </div>


      <div class="col-md-6">
        <table class="table table-striped" style="font-size: 12px;">
          <tbody>
            <tr style="background: #345980; color: white;">
              <td colspan="2"><i class="fa fa-fw fa-bank"></i> Suma de ingresos por banco</td>
            </tr>
            <?php $sx = 0; foreach($sum_banco as $lista){ ?>
            <tr>
              <td style="text-align: right;"><?php echo $lista['Nombre']; ?>:</td>
              <td style="text-align: right;">$ <?php echo number_format($lista['Suma'], 2, '.', ','); ?></td>
            </tr>
            <?php $sx = ($sx + $lista['Suma']); } ?>
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
              <?php foreach($sum_banco as $lista){  ?>
              <th><?php echo $lista['Banco']; ?></th><?php } ?>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th>Pesos</th>
              <?php foreach($sum_banco as $lista){ ?>
              <td><?php echo $lista['Suma']; ?></td><?php } ?>
            </tr>

          </tbody>
        </table>
        <div id="container_banco"></div>
      </div>
      <div class="col-md-6">
        <table class="table table-striped" style="font-size: 12px;">
          <tbody>
            <tr style="background: #345980; color: white;">
              <td colspan="2"><i class="fa fa-fw fa-tachometer"></i> Suma de ingresos por tipo de concepto</td>
            </tr>
            <?php $sw = 0; foreach($sum_concep as $lista){ ?>
            <tr>
              <td style="text-align: right;"><?php echo $lista['NomPlan']; ?>:</td>
              <td style="text-align: right; width: 150px;">$ <?php echo number_format($lista['Suma'], 2, '.', ','); ?></td>
            </tr>
            <?php $sw = ($sw + $lista['Suma']); } ?>
            <tr>
              <td style="text-align: right;"><b>TOTAL:</b></td>
              <td style="text-align: right;"><b>$ <?php echo number_format($sw, 2, '.', ','); ?></b></td>
            </tr>
        </tbody></table>
      </div>
      <div class="col-md-6">
        <table id="datatable_concepto" style="display: none;">
          <thead>
            <tr>
              <th></th>
              <?php foreach($sum_concep as $lista){ ?>
              <th><?php echo $lista['NomPlan']; ?></th><?php } ?>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th>Pesos</th>
              <?php foreach($sum_concep as $lista){ ?>
              <td><?php echo $lista['Suma']; ?></td><?php } ?>
            </tr>

          </tbody>
        </table>
        <div id="container_concepto"></div>
      </div>
      <div class="col-md-12">
        <table class="table table-striped" style="font-size: 12px;">
          <tbody>
            <tr style="background: #345980; color: white;">
              <td colspan="2"><i class="fa fa-fw fa-tachometer"></i> Suma de ingresos por oferta educativa</td>
            </tr>
            <?php $sw = 0; foreach($sum_oferta as $lista){ ?>
            <tr>
              <td style="text-align: right;"><?php echo $lista['Educativa']; ?>:</td>
              <td style="text-align: right; width: 150px;">$ <?php echo number_format($lista['Suma'], 2, '.', ','); ?></td>
            </tr>
            <?php $sw = ($sw + $lista['Suma']); } ?>
            <tr>
              <td style="text-align: right;"><b>TOTAL:</b></td>
              <td style="text-align: right;"><b>$ <?php echo number_format($sw, 2, '.', ','); ?></b></td>
            </tr>
        </tbody></table>
      </div>
      <div class="col-md-12">
        <table class="table table-striped" style="font-size: 12px;">
          <tbody>
            <tr style="background: #345980; color: white;">
              <td colspan="2"><i class="fa fa-fw fa-tachometer"></i> Suma de ingresos por grado de estudio</td>
            </tr>
            <?php $sw = 0; foreach($sum_grado as $lista){ ?>
            <tr>
              <td style="text-align: right;"><?php echo $lista['_Grado']; ?>:</td>
              <td style="text-align: right; width: 150px;">$ <?php echo number_format($lista['Suma'], 2, '.', ','); ?></td>
            </tr>
            <?php $sw = ($sw + $lista['Suma']); } ?>
            <tr>
              <td style="text-align: right;"><b>TOTAL:</b></td>
              <td style="text-align: right;"><b>$ <?php echo number_format($sw, 2, '.', ','); ?></b></td>
            </tr>
        </tbody></table>
      </div>

      <div class="col-md-12">
        <p style="text-align: center; font-size: 16px; padding: 10px;"><b>DESGLOSE DE INGRESOS POR CAMPUS</b></p>
      </div>

      <div class="col-md-12">
        <table class="table table-striped" style="font-size: 12px;">
          <tbody>
            <tr style="background: #345980; color: white;">
              <td colspan="3"><i class="fa fa-fw fa-bank"></i> SUMA DE INGRESOS POR BANCO Y CAMPUS</td>
            </tr>
            <?php $sumT = 0; $bi = 0; $bf = 0; $sx = 0; foreach($sum_banco_campus as $lista){ $bi = $lista['IdCampus'];

              if($bi <> $bf){ if($bf <> 0){  ?>
                <tr>
                  <td colspan="2" style="text-align: right;"><b>TOTAL INGRESO CAMPUS:</b></td>
                  <td style="text-align: right; width: 100px;"><b>$ <?php echo number_format($sumT, 2, '.', ','); ?></b></td>
                </tr><?php } ?>
                <tr>
                  <td colspan="3" style="text-align: left; color: #1d3462;"><b><i class="fa fa-fw fa-industry"></i> <?php echo $lista['Campus']; ?></b></td>
                </tr>

              <?php  $sumT = 0; }  $sumT = ($sumT + $lista['Suma']); ?>
            <tr>
              <td style="text-align: right;"></td>
              <td style="text-align: right;"><?php echo $lista['Nombre']; ?>:</td>
              <td style="text-align: right;">$ <?php echo number_format($lista['Suma'], 2, '.', ','); ?></td>
            </tr>
            <?php $sx = ($sx + $lista['Suma']);  $bf = $lista['IdCampus']; } ?>
            <tr>
              <td colspan="2" style="text-align: right;"><b>TOTAL INGRESO CAMPUS:</b></td>
              <td style="text-align: right; width: 100px;"><b>$ <?php echo number_format($sumT, 2, '.', ','); ?></b></td>
            </tr>
            <tr>
              <td colspan="2" style="text-align: right; color: #1d3462;"><b>TOTAL CONCENTRADO:</b></td>
              <td style="text-align: right; width: 100px; background: yellow;"><b>$ <?php echo number_format($sx, 2, '.', ','); ?></b></td>
            </tr>
        </tbody></table>
      </div>
      <div class="col-md-12">
        <table class="table table-striped" style="font-size: 12px;">
          <tbody>
            <tr style="background: #345980; color: white;">
              <td colspan="3"><i class="fa fa-fw fa-tachometer"></i> SUMA DE INGRESOS POR TIPO DE CONCEPTO Y CAMPUS</td>
            </tr>
            <?php $sumT = 0; $bi = 0; $bf = 0; $sw = 0; foreach($sum_concep_campus as $lista){ $bi = $lista['IdCampus'];
            if($bi <> $bf){ if($bf <> 0){  ?>
              <tr>
                <td colspan="2" style="text-align: right;"><b>TOTAL INGRESO CAMPUS:</b></td>
                <td style="text-align: right; width: 100px;"><b>$ <?php echo number_format($sumT, 2, '.', ','); ?></b></td>
              </tr><?php } ?>
              <tr>
                <td colspan="3" style="text-align: left; color: #1d3462;"><b><i class="fa fa-fw fa-industry"></i> <?php echo $lista['Campus']; ?></b></td>
              </tr>

            <?php  $sumT = 0; }  $sumT = ($sumT + $lista['Suma']); ?>
            <tr>
              <td style="text-align: right;"></td>
              <td style="text-align: right;"><?php echo $lista['NomPlan']; ?>:</td>
              <td style="text-align: right; width: 150px;">$ <?php echo number_format($lista['Suma'], 2, '.', ','); ?></td>
            </tr>
            <?php $sw = ($sw + $lista['Suma']); $bf = $lista['IdCampus']; } ?>
            <tr>
              <td colspan="2" style="text-align: right;"><b>TOTAL INGRESO CAMPUS:</b></td>
              <td style="text-align: right; width: 100px;"><b>$ <?php echo number_format($sumT, 2, '.', ','); ?></b></td>
            </tr>
            <tr>
              <td colspan="2" style="text-align: right; color: #1d3462;"><b>TOTAL CONCENTRADO:</b></td>
              <td style="text-align: right; background: yellow;"><b>$ <?php echo number_format($sw, 2, '.', ','); ?></b></td>
            </tr>
        </tbody></table>
      </div>
      <div class="col-md-12">

      </div>
      <div class="col-md-12">
        <table class="table table-striped" style="font-size: 12px;">
          <tbody>
            <tr style="background: #345980; color: white;">
              <td colspan="3"><i class="fa fa-fw fa-tachometer"></i> SUMA DE INGRESOS POR PLAN DE ESTUDIOS Y CAMPUS</td>
            </tr>
            <?php  $sumT = 0; $bi = 0; $bf = 0; $sw = 0; foreach($sum_oferta_campus as $lista){ $bi = $lista['IdCampus'];

              if($bi <> $bf){ if($bf <> 0){  ?>
                <tr>
                  <td colspan="2" style="text-align: right;"><b>TOTAL INGRESO CAMPUS:</b></td>
                  <td style="text-align: right; width: 100px;"><b>$ <?php echo number_format($sumT, 2, '.', ','); ?></b></td>
                </tr><?php } ?>
                <tr>
                  <td colspan="3" style="text-align: left; color: #1d3462;"><b><i class="fa fa-fw fa-industry"></i> <?php echo $lista['Campus']; ?></b></td>
                </tr>

              <?php  $sumT = 0; }  $sumT = ($sumT + $lista['Suma']); ?>
            <tr>
              <td style="text-align: right;"></td>
              <td style="text-align: right;"><?php echo $lista['Educativa']; ?>:</td>
              <td style="text-align: right; width: 150px;">$ <?php echo number_format($lista['Suma'], 2, '.', ','); ?></td>
            </tr>
            <?php $sw = ($sw + $lista['Suma']); $bf = $lista['IdCampus']; } ?>
            <tr>
              <td colspan="2" style="text-align: right;"><b>TOTAL INGRESO CAMPUS:</b></td>
              <td style="text-align: right; width: 100px;"><b>$ <?php echo number_format($sumT, 2, '.', ','); ?></b></td>
            </tr>
            <tr>
              <td colspan="2" style="text-align: right;"><b>TOTAL CONCENTRADO:</b></td>
              <td style="text-align: right; background: yellow;"><b>$ <?php echo number_format($sw, 2, '.', ','); ?></b></td>
            </tr>
        </tbody></table>
      </div>
      <div class="col-md-12">

      </div>
      <div class="col-md-12">
        <table class="table table-striped" style="font-size: 12px;">
          <tbody>
            <tr style="background: #ff9a19; color: black;">
              <td colspan="3"><i class="fa fa-fw fa-tachometer"></i> SUMA DE PAGOS PENDIENTES</td>
            </tr>
            <tr>
              <td colspan="3"><b>NOTA:</b> En este reporte se toma en cuenta: Inscripción, reinscripcion, mensualidades, asi como los recargos y abonos en caso de que existiera en los pagos pendientes.</td>
            </tr>
            <?php  $sumT = 0; $bi = 0; $bf = 0; $sw = 0; foreach($pag_pend as $listapag){ $bi = $listapag['IdCampus'];

              if($bi <> $bf){ if($bf <> 0){  ?>
                <tr>
                  <td colspan="2" style="text-align: right;"><b>MONTO POR  CAMPUS:</b></td>
                  <td style="text-align: right; width: 100px;"><b>$ <?php echo number_format($sumT, 2, '.', ','); ?></b></td>
                </tr><?php } ?>
                <tr>
                  <td colspan="3" style="text-align: left; color: #1d3462;"><b><i class="fa fa-fw fa-industry"></i> <?php echo $listapag['Campus']; ?></b></td>
                </tr>

              <?php  $sumT = 0; }  $sumT = ($sumT + $listapag['Total']); ?>
            <tr>
              <td style="text-align: right;"></td>
              <td style="text-align: right;"><?php echo $listapag['Nombre']; ?>:</td>
              <td style="text-align: right; width: 150px;">$ <?php echo number_format($listapag['Total'], 2, '.', ','); ?></td>
            </tr>
            <?php $sw = ($sw + $listapag['Total']); $bf = $listapag['IdCampus']; } ?>
            <tr>
              <td colspan="2" style="text-align: right;"><b>TOTAL PENDIENTE DEL CAMPUS:</b></td>
              <td style="text-align: right; width: 100px;"><b>$ <?php echo number_format($sumT, 2, '.', ','); ?></b></td>
            </tr>
            <tr>
              <td colspan="2" style="text-align: right;"><b>TOTAL CONCENTRADO PENDIENTE:</b></td>
              <td style="text-align: right; background: yellow;"><b>$ <?php echo number_format($sw, 2, '.', ','); ?></b></td>
            </tr>
        </tbody></table>
      </div>

      
      

  </div>
  <button onClick="window.open('formConsulta/exp_ingresos.php?IdPlan=<?php echo $IdPlan; ?>&Fecha1=<?php echo $fecha1; ?>&Fecha2=<?php echo $fecha2; ?>','_self')" href="javascript:void(0);" type="button" class="btn btn-block btn-danger btn-xs"><i class="fa fa-fw fa-cloud-download"></i> Descargar excel</button>

<script>
Highcharts.chart('container_banco', {
  data: {
    table: 'datatable_banco'
  },
  chart: {
    type: 'column'
  },
  title: {
    text: 'Suma de ingresos por banco'
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

Highcharts.chart('container_concepto', {
  data: {
    table: 'datatable_concepto'
  },
  chart: {
    type: 'column'
  },
  title: {
    text: ' Suma de ingresos por tipo de concepto'
  },
  yAxis: {
    allowDecimals: false,
    title: {
      text: 'Pesos'
    }
  },
  tooltip: {
    formatter: function () {
      return '<b>' + this.series.name + '</b><br/> $' +
        this.point.y + ' ' + this.point.name.toLowerCase();
    }
  }
});


</script>
