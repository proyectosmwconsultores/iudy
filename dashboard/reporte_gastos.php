<?php
  require('../php/clases/consulta_class.php');
  $t=new Consultas();
  $Anio = $_POST['Anio'];

  include('../hace.php');
  $lst_gasto=$t->get_gastos_lst($Anio);
  $sum_concep=$t->get_sum_concep($Anio);
  $sum_oferta=$t->get_sum_oferta($Anio);
  $sum_partida=$t->get_sum_partida($Anio);

  $anioMes = date("Y-m");
  ?>
<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <div class="bg-maroon-active color-palette" style="padding: 5px;"><span><i class="fa fa-fw fa-bookmark-o"></i> Reporte de gastos en general del año: <?php echo $Anio; ?></span></div>
  <br>
  <table id="example1" class="table table-bordered table-striped" style="font-size: 12px;">
    <thead>
      <tr>
        <th>TIPO DE GASTO</th>
        <th>BENEFICIARIO</th>
        <!-- <th>DESCRIPCIÓN</th> -->
        <th>CHEQUE</th>
        <th>PARTIDA</th>
        <th>FECHA</th>
        <th style="width: 85px;">DOCTORADO</th>
        <th style="width: 85px;">MAESTRÍA</th>
        <th style="width: 85px;">LICENCIATURA</th>
        <th style="width: 85px;">DIPLOMADO</th>
        <th style="width: 85px;">CURSO</th>
        <th style="text-align: right; width: 90px;">IMPORTE</th>
      </tr>
    </thead>
    <tbody>
      <?php $bi=0; $bf=0; $s = 0;
      for ($x=0;$x< sizeof($lst_gasto);$x++) {
          $val1=$t->get_sum_gas_nivel($lst_gasto[$x]['IdGasto'],1);
          $val2=$t->get_sum_gas_nivel($lst_gasto[$x]['IdGasto'],2);
          $val3=$t->get_sum_gas_nivel($lst_gasto[$x]['IdGasto'],3);
          $val4=$t->get_sum_gas_nivel($lst_gasto[$x]['IdGasto'],4);
          $val5=$t->get_sum_gas_nivel($lst_gasto[$x]['IdGasto'],5);
        ?>
        <!-- <button onclick="javascript:window.open('repositorio/pdf/comprobante_gasto.php?idToks=<?php echo time().$lst_gasto[$x]['IdGasto']; ?>');" href="javascript:void(0);" title="Imprimir comprobante de gasto" type="button" class="btn bg-purple btn-flat btn-sm"><i class="fa fa-file-pdf-o"></i></button> -->
      <tr <?php if($lst_gasto[$x]['IdEstatus'] == 10){ echo "style='color: red; '"; } else { echo ""; } ?>>
        <td><?php echo $lst_gasto[$x]['Nombre_gasto2']; ?></td>
        <td><?php echo $lst_gasto[$x]['Beneficiario']; ?></td>
        <!-- <td><?php //echo $lst_gasto[$x]['Descripcion']; ?></td> -->
        <td><?php echo $lst_gasto[$x]['Cheque']; ?></td>
        <td><?php echo $lst_gasto[$x]['Partida']; ?></td>
        <td><?php echo $lst_gasto[$x]['Fecha']; ?></td>
        <td style="text-align: right;">$ <?php echo number_format($val1[0]['Total'], 2, '.', ','); ?></td>
        <td style="text-align: right;">$ <?php echo number_format($val2[0]['Total'], 2, '.', ','); ?></td>
        <td style="text-align: right;">$ <?php echo number_format($val3[0]['Total'], 2, '.', ','); ?></td>
        <td style="text-align: right;">$ <?php echo number_format($val4[0]['Total'], 2, '.', ','); ?></td>
        <td style="text-align: right;">$ <?php echo number_format($val5[0]['Total'], 2, '.', ','); ?></td>
        <td style="text-align: right;">$ <?php echo number_format($lst_gasto[$x]['Importe'], 2, '.', ','); ?></td>
      </tr>
      <?php } ?>
  </tbody></table>

<br><br>
<div class="row">
  <div class="col-md-6">
    <table class="table table-striped" style="font-size: 12px;">
      <tbody>
        <tr style="background: #345980; color: white;">
          <td colspan="2"><i class="fa fa-fw fa-tachometer"></i> Suma de gastos por tipo de concepto de gasto</td>
        </tr>
        <?php $sw = 0;
        for ($w=0;$w< sizeof($sum_concep);$w++) { ?>
        <tr>
          <td style="text-align: right;"><?php echo $sum_concep[$w]['Nombre_gasto']; ?>:</td>
          <td style="text-align: right; width: 150px;">$ <?php echo number_format($sum_concep[$w]['Suma'], 2, '.', ','); ?></td>
        </tr>
        <?php $sw = ($sw + $sum_concep[$w]['Suma']); } ?>
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
          <?php for ($_c=0;$_c< sizeof($sum_concep);$_c++) { ?>
          <th><?php echo $sum_concep[$_c]['Nombre_gasto']; ?></th><?php } ?>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th>Pesos</th>
          <?php for ($_c=0;$_c< sizeof($sum_concep);$_c++) { ?>
          <td><?php echo $sum_concep[$_c]['Suma']; ?></td><?php } ?>
        </tr>

      </tbody>
    </table>
    <div id="container_concepto"></div>
  </div>
</div>
<div class="row">
  <div class="col-md-6">
    <table class="table table-striped" style="font-size: 12px;">
      <tbody>
        <tr style="background: #345980; color: white;">
          <td colspan="2"><i class="fa fa-fw fa-tachometer"></i> Suma de gastos por Número de Partida</td>
        </tr>
        <?php $sw = 0;
        for ($w=0;$w< sizeof($sum_partida);$w++) { ?>
        <tr>
          <td style="text-align: right;"><?php echo $sum_partida[$w]['Partida']; ?> - <?php echo $sum_partida[$w]['Descripcion']; ?>:</td>
          <td style="text-align: right; width: 150px;">$ <?php echo number_format($sum_partida[$w]['Total'], 2, '.', ','); ?></td>
        </tr>
        <?php $sw = ($sw + $sum_partida[$w]['Total']); } ?>
        <tr>
          <td style="text-align: right;"><b>TOTAL:</b></td>
          <td style="text-align: right;"><b>$ <?php echo number_format($sw, 2, '.', ','); ?></b></td>
        </tr>
    </tbody></table>
  </div>
  <div class="col-md-6">
    <table id="datatable_oferta" style="display: none;">
      <thead>
        <tr>
          <th></th>
          <?php for ($_c=0;$_c< sizeof($sum_partida);$_c++) { ?>
          <th><?php echo $sum_partida[$_c]['Partida']; ?></th><?php } ?>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th>Pesos</th>
          <?php for ($_c=0;$_c< sizeof($sum_partida);$_c++) { ?>
          <td><?php echo $sum_partida[$_c]['Total']; ?></td><?php } ?>
        </tr>

      </tbody>
    </table>
    <div id="container_partida"></div>
  </div>
</div>
<div class="row">
  <div class="col-md-6">
    <table class="table table-striped" style="font-size: 12px;">
      <tbody>
        <tr style="background: #345980; color: white;">
          <td colspan="2"><i class="fa fa-fw fa-tachometer"></i> Suma de gastos por Número de Partida</td>
        </tr>
        <?php $sw = 0;
        for ($w=0;$w< sizeof($sum_oferta);$w++) { ?>
        <tr>
          <td style="text-align: right;"><?php echo $sum_oferta[$w]['Nombre']; ?>:</td>
          <td style="text-align: right; width: 150px;">$ <?php echo number_format($sum_oferta[$w]['Total'], 2, '.', ','); ?></td>
        </tr>
        <?php $sw = ($sw + $sum_oferta[$w]['Total']); } ?>
        <tr>
          <td style="text-align: right;"><b>TOTAL:</b></td>
          <td style="text-align: right;"><b>$ <?php echo number_format($sw, 2, '.', ','); ?></b></td>
        </tr>
    </tbody></table>
  </div>
  <div class="col-md-6">
    <table id="datatable_oferta" style="display: none;">
      <thead>
        <tr>
          <th></th>
          <?php for ($_c=0;$_c< sizeof($sum_oferta);$_c++) { ?>
          <th><?php echo $sum_oferta[$_c]['Nombre']; ?></th><?php } ?>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th>Pesos</th>
          <?php for ($_c=0;$_c< sizeof($sum_oferta);$_c++) { ?>
          <td><?php echo $sum_oferta[$_c]['Total']; ?></td><?php } ?>
        </tr>

      </tbody>
    </table>
    <div id="container_oferta"></div>
  </div>
</div>



   <button onClick="window.open('dashboard/reporte_gastos_ex.php?Anio=<?php echo $Anio; ?>','_self')" href="javascript:void(0);" type="button" class="btn btn-block btn-danger btn-xs"><i class="fa fa-fw fa-cloud-download"></i> Descargar excel</button>



 <!-- DataTables -->
 <script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
 <script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<script>

$(function () {
	$('#example1').DataTable()
})

Highcharts.chart('container_concepto', {
  data: {
    table: 'datatable_concepto'
  },
  chart: {
    type: 'column'
  },
  title: {
    text: ' Suma de gastos por tipo de concepto'
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

Highcharts.chart('container_oferta', {
  data: {
    table: 'datatable_oferta'
  },
  chart: {
    type: 'column'
  },
  title: {
    text: ' Suma de gastos por tipo de Plan de Estudios'
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

Highcharts.chart('container_partida', {
  data: {
    table: 'datatable_oferta'
  },
  chart: {
    type: 'column'
  },
  title: {
    text: ' Suma de gastos por número de partida'
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


<script>
function del_gastox(IdGasto){

  var TipoGuardar = "del_gastoxy";
  swal({
    title: "\u00BFEst\u00E1 seguro que desea eliminar este gasto?",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: '#DD6B55',
    confirmButtonText: 'Aceptar',
    cancelButtonText: "Cancelar",
  },
  function (isConfirm) {
    if(isConfirm) {
      $(".confirm").attr('disabled', 'disabled');
      $.ajax({
           url:"formConsulta/setting.php",
           method:"POST",
           data:{TipoGuardar:TipoGuardar, IdGasto:IdGasto},
           success:function(data){

           }
      })
      .done(function(data) {
        if(data==1){
          swal("Eliminado correctamente", "El gasto se ha eliminado correctamente.", "success");
          cargar_gastos();
        }
      })
      .error(function(data) {
        swal("Error al guardar", "No se puede guardar, comuniquese con el desarrollador.", "error");
      });

    }
  });
}
</script>
