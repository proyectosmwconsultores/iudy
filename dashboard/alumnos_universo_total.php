<?php
session_start();
$IdUsua = $_SESSION['IdUsua'];
require('../php/clases/class.System.php');
$db = new Conexion();

$alumnos_campus1 = $db->query("SELECT Count(tblc_usuario.IdUsua) AS Total, tblc_campus.Campus FROM tblc_usuario Left Join tblc_campus ON tblc_campus.IdCampus = tblc_usuario.IdCampus WHERE tblc_usuario.IdEstatus = '8' AND tblc_usuario.Permisos =  '3' GROUP BY tblc_usuario.IdCampus ");
$alumnos_campus2 = $db->query("SELECT Count(tblc_usuario.IdUsua) AS Total, tblc_campus.Campus FROM tblc_usuario Left Join tblc_campus ON tblc_campus.IdCampus = tblc_usuario.IdCampus WHERE tblc_usuario.IdEstatus = '8' AND tblc_usuario.Permisos =  '3' GROUP BY tblc_usuario.IdCampus ");


$baj_plan = $db->query("SELECT Count(tblc_usuario.IdUsua) AS Total, tblc_usuario.IdEstatus, tblc_estatus.Estatus FROM tblc_usuario Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_usuario.IdEstatus WHERE tblc_usuario.Permisos =  '3' GROUP BY tblc_usuario.IdEstatus ORDER BY Total DESC ");
$baj_plan2 = $db->query("SELECT Count(tblc_usuario.IdUsua) AS Total, tblc_usuario.IdEstatus, tblc_estatus.Estatus FROM tblc_usuario Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_usuario.IdEstatus WHERE tblc_usuario.Permisos =  '3' GROUP BY tblc_usuario.IdEstatus ORDER BY Total DESC ");

$alumnos_nivel1 = $db->query("SELECT Count(tblc_usuario.IdUsua) AS Total, tblc_grado.Descripcion FROM tblc_usuario Left Join tblc_grado ON tblc_grado.IdGrado = tblc_usuario.Grado WHERE tblc_usuario.Permisos =  '3' AND tblc_usuario.IdEstatus = '8' GROUP BY tblc_usuario.Grado ORDER BY tblc_grado.IdGrado ASC ");
$alumnos_nivel2 = $db->query("SELECT Count(tblc_usuario.IdUsua) AS Total, tblc_grado.Descripcion FROM tblc_usuario Left Join tblc_grado ON tblc_grado.IdGrado = tblc_usuario.Grado WHERE tblc_usuario.Permisos =  '3' AND tblc_usuario.IdEstatus = '8' GROUP BY tblc_usuario.Grado ORDER BY tblc_grado.IdGrado ASC ");


$alumnos_all = $db->query("SELECT
Count(tblc_usuario.IdUsua) AS Total,
tblc_campus.IdCampus,
tblc_campus.Campus,
tblp_educativa.Nombre
FROM
tblc_usuario
Left Join tblc_campus ON tblc_campus.IdCampus = tblc_usuario.IdCampus
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta
WHERE
tblc_usuario.Permisos =  '3' AND tblc_usuario.IdEstatus = '8'
GROUP BY
tblc_usuario.IdOferta
ORDER BY
tblc_usuario.IdCampus ASC,
tblp_educativa.IdGrado ASC
");

?>

<div class="row">
  <div class="col-lg-12 col-xs-12">
    <div class="bg-maroon-active color-palette" style="padding: 8px;"><span><i class="fa fa-fw fa-folder"></i> Universo de alumnos en IUDY por Estatus</span></div>
  </div>
  <div class="col-lg-8 col-xs-6">
    <figure class="highcharts-figure">
      <div id="universo_alumnos_all"></div>
    </figure>
  </div>
  <div class="col-lg-4 col-xs-6">
    <div class="box-body no-padding">
      <table class="table table-striped">
        <tbody>
          <tr>
            <th>ESTATUS</th>
            <th style="text-align: center;">TOTAL</th>
          </tr>
          <?php while ($_baj2 = $db->recorrer($baj_plan2)) {  ?>
            <tr style="cursor: pointer;" onclick="mostrar_alumno_id(<?php echo $_baj2['IdEstatus']; ?>)">
              <td><?php echo $_baj2['Estatus']; ?></td>
              <td style="text-align: center;"><?php echo $_baj2['Total']; ?></td>
            </tr><?php } ?>
        </tbody>
      </table>
    </div>
  </div>




  <div class="col-lg-12 col-xs-12">
    <div class="bg-maroon-active color-palette" style="padding: 8px;"><span><i class="fa fa-fw fa-folder"></i> Total alumnos <b>Activos por Campus</b> </span></div>
  </div>
  <div class="col-lg-8 col-xs-6">
    <figure class="highcharts-figure">
      <div id="activos_alumnos_all"></div>
    </figure>
  </div>
  <div class="col-lg-4 col-xs-6">
    <div class="box-body no-padding">
      <table class="table table-striped">
        <tbody>
          <tr>
            <th>NOMBRE DEL CAMPUS</th>
            <th style="text-align: center;">TOTAL</th>
          </tr>
          <?php $sa = 0; while ($_campus1 = $db->recorrer($alumnos_campus1)) { $sa = ($sa + $_campus1['Total']); ?>
            <tr>
              <td><?php echo $_campus1['Campus']; ?></td>
              <td style="text-align: center;"><?php echo $_campus1['Total']; ?></td>
            </tr><?php } ?>
            <tr>
              <td style="text-align: right;"><b>TOTAL:</b></td>
              <td style="text-align: center; background: yellow;"><b><?php echo $sa; ?></b></td>
            </tr>
        </tbody>
      </table>
    </div>
  </div>





  <div class="col-lg-12 col-xs-12">
    <div class="bg-maroon-active color-palette" style="padding: 8px;"><span><i class="fa fa-fw fa-folder"></i> Total alumnos por <b>Grado de estudio</b> </span></div>
  </div>
  <div class="col-lg-8 col-xs-6">
    <figure class="highcharts-figure">
      <div id="nivel_alumnos_all"></div>
    </figure>
  </div>
  <div class="col-lg-4 col-xs-6">
    <div class="box-body no-padding">
      <table class="table table-striped">
        <tbody>
          <tr>
            <th>GRADO DE ESTUDIO</th>
            <th style="text-align: center;">TOTAL</th>
          </tr>
          <?php $sa1 = 0; while ($_nivel1 = $db->recorrer($alumnos_nivel1)) { $sa1 = ($sa1 + $_nivel1['Total']); ?>
            <tr>
              <td><?php echo $_nivel1['Descripcion']; ?></td>
              <td style="text-align: center;"><?php echo $_nivel1['Total']; ?></td>
            </tr><?php } ?>
            <tr>
              <td style="text-align: right;"><b>TOTAL:</b></td>
              <td style="text-align: center; background: yellow;"><b><?php echo $sa1; ?></b></td>
            </tr>
        </tbody>
      </table>
    </div>
  </div>

</div>

<script>
  Highcharts.chart('universo_alumnos_all', {
    chart: {
      plotBackgroundColor: null,
      plotBorderWidth: null,
      plotShadow: false,
      type: 'pie'
    },
    title: {
      text: 'Total alumnos en IUDY por Estatus',
      align: 'left'
    },
    tooltip: {
      pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    accessibility: {
      point: {
        valueSuffix: '%'
      }
    },
    plotOptions: {
      pie: {
        allowPointSelect: true,
        cursor: 'pointer',
        dataLabels: {
          enabled: true,
          format: '<b>{point.name}</b>: {point.percentage:.1f} %'
        }
      }
    },
    series: [{
      name: 'Brands',
      colorByPoint: true,
      data: [
        <?php $c = 0;
        while ($_baj = $db->recorrer($baj_plan)) {
          $c = ($c + 1); ?> {
            name: '<?php echo $_baj['Estatus']; ?>',
            y: <?php echo $_baj['Total']; ?>
          },
        <?php } ?>
      ]
    }]
  });


  Highcharts.chart('activos_alumnos_all', {
    chart: {
      plotBackgroundColor: null,
      plotBorderWidth: null,
      plotShadow: false,
      type: 'pie'
    },
    title: {
      text: 'Total alumnos Activos por Campus',
      align: 'left'
    },
    tooltip: {
      pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    accessibility: {
      point: {
        valueSuffix: '%'
      }
    },
    plotOptions: {
      pie: {
        allowPointSelect: true,
        cursor: 'pointer',
        dataLabels: {
          enabled: true,
          format: '<b>{point.name}</b>: {point.percentage:.1f} %'
        }
      }
    },
    series: [{
      name: 'Brands',
      colorByPoint: true,
      data: [
        <?php $c = 0;
        while ($_campus2 = $db->recorrer($alumnos_campus2)) {
          $c = ($c + 1); ?> {
            name: '<?php echo $_campus2['Campus']; ?>',
            y: <?php echo $_campus2['Total']; ?>
          },
        <?php } ?>
      ]
    }]
  });


  Highcharts.chart('nivel_alumnos_all', {
    chart: {
      plotBackgroundColor: null,
      plotBorderWidth: null,
      plotShadow: false,
      type: 'pie'
    },
    title: {
      text: 'Total alumnos por Grado de Estudios',
      align: 'left'
    },
    tooltip: {
      pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    accessibility: {
      point: {
        valueSuffix: '%'
      }
    },
    plotOptions: {
      pie: {
        allowPointSelect: true,
        cursor: 'pointer',
        dataLabels: {
          enabled: true,
          format: '<b>{point.name}</b>: {point.percentage:.1f} %'
        }
      }
    },
    series: [{
      name: 'Brands',
      colorByPoint: true,
      data: [
        <?php $c = 0;
        while ($_nivel2 = $db->recorrer($alumnos_nivel2)) {
          $c = ($c + 1); ?> {
            name: '<?php echo $_nivel2['Descripcion']; ?>',
            y: <?php echo $_nivel2['Total']; ?>
          },
        <?php } ?>
      ]
    }]
  });

  
</script>