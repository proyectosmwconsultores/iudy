<?php
  require('../php/clases/consulta_class.php');
  $t=new Consultas();
  $total = $t->get_sum_alumnos();
  $_nivel = $t->get_sum_alumnos_nivel();
  $_sexom = $t->get_sum_alumnos_sexo('M');
  $_sexof = $t->get_sum_alumnos_sexo('F');
  ?>
  <div class="col-md-5">
    <div class="box box-info">
      <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-pie-chart"></i> Gráfica de alumnos en la ENAPROC</h3>
      </div>
      <div class="box-body">
        <div id="datos_gral"></div>
      </div>
    </div>
  </div>
  <div class="col-md-7">
    <div class="box box-info">
      <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-fw fa-bar-chart"></i> Gráfica de alumnos por Plan de Estudios en la ENAPROC </h3>
      </div>
      <div class="box-body">
        <div id="plan_estudios"></div>
      </div>
    </div>
  </div>
  <div class="col-md-12">
    <div class="box box-info">
      <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-fw fa-bar-chart"></i> Gráfica de alumnos por sexo en la ENAPROC</h3>
      </div>
      <div class="box-body">
        <div id="alumnos_sexo"></div>
      </div>
    </div>
  </div>



<div class="col-md-6">

</div>
<div class="col-md-6">

</div>



<script>
Highcharts.chart('datos_gral', {
    chart: {
        type: 'pie',
        options3d: {
            enabled: true,
            alpha: 45,
            beta: 0
        }
    },
    title: {
        text: 'Alumnos activos en la ENAPROC'
    },
    accessibility: {
        point: {
            valueSuffix: '%'
        }
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            depth: 35,
            dataLabels: {
                enabled: true,
                format: '{point.name}'
            }
        }
    },
    series: [{
        type: 'pie',
        name: 'Porcentaje',
        data: [
          <?php for ($i=0;$i< sizeof($total);$i++) { if($i == 0){ ?>
          {
              name: '<?php echo $total[$i]['Descripcion']; ?> (<?php echo $total[$i]['Total']; ?>)',
              y: <?php echo $total[$i]['Total']; ?>,
              sliced: true,
              selected: true
          },<?php } else { ?>
            ['<?php echo $total[$i]['Descripcion']; ?> (<?php echo $total[$i]['Total']; ?>)', <?php echo $total[$i]['Total']; ?>],
            <?php } } ?>

        ]
    }]
});
</script>
<script type="text/javascript">
Highcharts.chart('plan_estudios', {
    chart: {
        type: 'pie',

    },
    title: {
        text: 'Alumnos activos en la ENAPROC'
    },
    accessibility: {
        point: {
            valueSuffix: '%'
        }
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            depth: 35,
            dataLabels: {
                enabled: true,
                format: '{point.name}'
            }
        }
    },
    series: [{
        type: 'pie',
        name: 'Porcentaje',
        data: [
          <?php for ($i=0;$i< sizeof($_nivel);$i++) { if($i == 0){ ?>
          {
              name: '<?php echo $_nivel[$i]['Nombre']; ?> (<?php echo $_nivel[$i]['Total']; ?>)',
              y: <?php echo $_nivel[$i]['Total']; ?>,
              sliced: true,
              selected: true
          },<?php } else { ?>
            ['<?php echo $_nivel[$i]['Nombre']; ?> (<?php echo $_nivel[$i]['Total']; ?>)', <?php echo $_nivel[$i]['Total']; ?>],
            <?php } } ?>

        ]
    }]
});


Highcharts.chart('alumnos_sexo', {
    chart: {
        type: 'bar'
    },
    title: {
        text: 'Alumnos activos por sexo en la ENAPROC'
    },
    xAxis: {
        categories: ['Doctorado', 'Maestría', 'Licenciatura'],
        title: {
            text: null
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Total alumnos',
            align: 'high'
        },
        labels: {
            overflow: 'justify'
        }
    },
    tooltip: {
        valueSuffix: ' '
    },
    plotOptions: {
        bar: {
            dataLabels: {
                enabled: true
            }
        }
    },
    legend: {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'top',
        x: -40,
        y: 80,
        floating: true,
        borderWidth: 1,
        backgroundColor:
            Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF',
        shadow: true
    },
    credits: {
        enabled: false
    },
    series: [{
        name: 'HOMBRES',
        data: [<?php echo $_sexom[0]['Total']; ?>, <?php echo $_sexom[1]['Total']; ?>, <?php echo $_sexom[2]['Total']; ?>]
    }, {
        name: 'MUJERES',
        data: [<?php echo $_sexof[0]['Total']; ?>, <?php echo $_sexof[1]['Total']; ?>, <?php echo $_sexof[2]['Total']; ?>]
    }]
});


</script>
