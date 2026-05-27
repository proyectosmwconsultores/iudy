<?php
session_start();
$IdUsua = $_SESSION['IdUsua'];
require('../php/clases/class.System.php');
$db = new Conexion();
$IdCiclo = $_POST['IdCiclo'];
$IdCampus = 1;


// $sql = $db->query("SELECT tblp_asignacion.IdAsignacion FROM tblp_asignacion WHERE tblp_asignacion.Tipo = '2' AND tblp_asignacion.Fecha_impresion IS NOt NULL ");
// while ($x = $db->recorrer($sql)) {
//   $insertar = $db->query("UPDATE tblp_calificacion SET tblp_calificacion.IdEstatus = '10' WHERE tblp_calificacion.IdAsignacion = '".$x['IdAsignacion']."'");
// }


$sql_lst = $db->query("SELECT
tblc_usuario.IdUsua,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.Celular,
tblc_usuario.Correo,
tblc_usuario.Usuario,
tblc_usuario.fecha_baja,
tblp_grupo.CveGrupo,
tblc_usuario.IdGrupo,
tblp_educativa.Nombre AS NomEducativa,
tblc_estatus.Estatus
FROM
tblc_usuario 
Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_usuario.IdGrupo
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta
Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_usuario.IdEstatus
WHERE tblc_usuario.Permisos = '3' AND tblc_usuario.id_ciclo_fin = '$IdCiclo' ");


$sql_ofe = $db->query("SELECT
Count(tblc_usuario.IdUsua) AS Total,
tblp_educativa.Nombre AS NomEducativa
FROM
tblc_usuario
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta
WHERE tblc_usuario.Permisos = '3' AND tblc_usuario.id_ciclo_fin = '$IdCiclo'
GROUP BY
tblc_usuario.IdOferta
ORDER BY
tblp_educativa.IdGrado ASC
 ");

$sql_cic = $db->query("SELECT tblc_modulousuario.IdModUsua FROM tblc_modulousuario WHERE tblc_modulousuario.IdUsua = '$IdUsua' AND tblc_modulousuario.IdModulo = '56'");
$db->rows($sql_cic);
$_cic = $db->recorrer($sql_cic);
$IdModUsua = $_cic['IdModUsua'];

$baj_plan = $db->query("SELECT Count(tblc_usuario.IdUsua) AS Total, tblp_educativa.Nombre FROM tblc_usuario Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta WHERE tblc_usuario.Permisos =  '3' AND ((tblc_usuario.IdEstatus = 14) || (tblc_usuario.IdEstatus = 18) || (tblc_usuario.IdEstatus = 20) || (tblc_usuario.IdEstatus = 15)) AND  tblc_usuario.id_ciclo_fin =  '$IdCiclo' GROUP BY tblc_usuario.IdOferta ");
$baj_plan2 = $db->query("SELECT Count(tblc_usuario.IdUsua) AS Total, tblp_educativa.Nombre FROM tblc_usuario Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta WHERE tblc_usuario.Permisos =  '3' AND ((tblc_usuario.IdEstatus = 14) || (tblc_usuario.IdEstatus = 18) || (tblc_usuario.IdEstatus = 20) || (tblc_usuario.IdEstatus = 15)) AND  tblc_usuario.id_ciclo_fin =  '$IdCiclo' GROUP BY tblc_usuario.IdOferta ");

$baj_esta1 = $db->query("SELECT Count(tblc_usuario.IdUsua) AS Total, tblc_estatus.Estatus FROM tblc_usuario Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_usuario.IdEstatus WHERE tblc_usuario.Permisos =  '3' AND ((tblc_usuario.IdEstatus = 14) || (tblc_usuario.IdEstatus = 18) || (tblc_usuario.IdEstatus = 20) || (tblc_usuario.IdEstatus = 15)) AND tblc_usuario.id_ciclo_fin =  '$IdCiclo' GROUP BY tblc_usuario.IdEstatus ORDER BY tblc_usuario.IdEstatus ASC ");
$baj_esta2 = $db->query("SELECT Count(tblc_usuario.IdUsua) AS Total, tblc_estatus.Estatus FROM tblc_usuario Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_usuario.IdEstatus WHERE tblc_usuario.Permisos =  '3' AND ((tblc_usuario.IdEstatus = 14) || (tblc_usuario.IdEstatus = 18) || (tblc_usuario.IdEstatus = 20) || (tblc_usuario.IdEstatus = 15)) AND tblc_usuario.id_ciclo_fin =  '$IdCiclo' GROUP BY tblc_usuario.IdEstatus ORDER BY tblc_usuario.IdEstatus ASC ");
$baj_esta3 = $db->query("SELECT Count(tblc_usuario.IdUsua) AS Total, tblc_estatus.Estatus FROM tblc_usuario Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_usuario.IdEstatus WHERE tblc_usuario.Permisos =  '3' AND ((tblc_usuario.IdEstatus = 14) || (tblc_usuario.IdEstatus = 18) || (tblc_usuario.IdEstatus = 20) || (tblc_usuario.IdEstatus = 15)) AND tblc_usuario.id_ciclo_fin =  '$IdCiclo' GROUP BY tblc_usuario.IdEstatus ORDER BY tblc_usuario.IdEstatus ASC ");
?>
<!-- <script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script> -->

<div class="row">
  <div class="col-lg-12 col-xs-12">
    <div class="bg-maroon-active color-palette" style="padding: 8px;"><span><i class="fa fa-fw fa-folder"></i> Porcentaje de baja por Programa de Estudio</span></div>
  </div>
  <div class="col-lg-8 col-xs-6">
    <figure class="highcharts-figure">
      <div id="porcente_bajas"></div>
    </figure>
  </div>

  <div class="col-lg-4 col-xs-6">
    <div class="box-body no-padding"><br><br><br><br>
      <table class="table table-striped">
        <tbody>
          <tr>
            <th>PROGRAMA DE ESTUDIOS</th>
            <th style="text-align: center;">TOTAL</th>
          </tr>
          <?php while ($_baj2 = $db->recorrer($baj_plan2)) {  ?>
            <tr>
              <td><?php echo $_baj2['Nombre']; ?></td>
              <td style="text-align: center;"><?php echo $_baj2['Total']; ?></td>
            </tr><?php } ?>
        </tbody>
      </table>
    </div>
  </div>
  <div class="col-lg-12 col-xs-12"><br>
    <div class="bg-maroon-active color-palette" style="padding: 8px;"><span><i class="fa fa-fw fa-folder"></i> Total por tipo de bajas</span></div>
  </div>
  <div class="col-lg-8 col-xs-6">
    <figure class="highcharts-figure">
      <div id="tipos_bjas"></div>
    </figure>
  </div>
  <div class="col-lg-4 col-xs-6">
  <div class="box-body no-padding"><br><br><br><br>
      <table class="table table-striped">
        <tbody>
          <tr>
            <th>TIPO DE BAJA</th>
            <th style="text-align: center;">TOTAL</th>
          </tr>
          <?php while ($_baj3 = $db->recorrer($baj_esta3)) {  ?>
            <tr>
              <td><?php echo $_baj3['Estatus']; ?></td>
              <td style="text-align: center;"><?php echo $_baj3['Total']; ?></td>
            </tr><?php } ?>
        </tbody>
      </table>
    </div>

    <div class="box-body no-padding" style="display: none;">
    <table id="datatable_bajas">
        <thead>
          <tr>
            <th></th>
            <?php while ($_esta1 = $db->recorrer($baj_esta1)) {  ?>
            <th><?php echo $_esta1['Estatus']; ?></th>
            <?php } ?>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th>BAJAS</th>
            <?php while ($_esta2 = $db->recorrer($baj_esta2)) {  ?>
            <td><?php echo $_esta2['Total']; ?></td>
            <?php } ?>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>


<div class="box-header">
  <h3 class="box-title"><i class="fa fa-fw fa-toggle-right"></i> Reporte de baja de alumnos del ciclo escolar</h3>
</div>
<div class="box-body">
  <table class="table table-striped" style="font-size: 12px;">
    <tbody>
      <tr>
        <th></th>
        <th>NOMBRE DEL ALUMNO</th>
        <th>CELULAR</th>
        <th>FECHA BAJA</th>
        <th>CORREO</th>
        <th>ESTATUS</th>
        <th></th>
      </tr>
      <?php $i = 0;
      $f = 0;
      $v = 0;
      while ($mat = $db->recorrer($sql_lst)) {  ?>
        <tr>
          <td><b><?php echo $v = ($v + 1); ?>.- </b></td>
          <td><?php echo $mat['APaterno'] . ' ' . $mat['AMaterno'] . ' ' . $mat['Nombre'];  ?></td>
          <td><?php echo $mat['Celular']; ?></td>
          <td><?php echo $mat['fecha_baja']; ?></td>
          <td><?php echo $mat['Correo']; ?></td>
          <td><?php echo $mat['Estatus']; ?></td>
          <!-- <td><?php if (isset($IdModUsua[0])) { ?><i onclick="del_alumnoIdx(<?php echo $mat['IdUsua']; ?>,<?php echo $IdCiclo; ?>, <?php echo $IdCampus; ?>)" href="javascript:void(0);" style="cursor: pointer; color: blue;" class="fa fa-fw fa-cog"></i><?php } ?></td> -->
        </tr><?php } ?>
    </tbody>
  </table>
  <div class="box-footer clearfix">
    <?php if ($v) { ?>
      <button onClick="window.open('repositorio/portafolio/bajas_grupo.php?idCiclo=<?php echo $IdCiclo; ?>&idCampus=<?php echo $IdCampus; ?>','_blank'), cargar_lista_alumnos()" href="javascript:void(0);" title="Acta de calificación del docente" type="button" class="pull-right btn bg-maroon btn-flat margin">Generar PDF <i class="fa fa-fw fa-file-pdf-o"></i></button>
    <?php } ?>
  </div>
</div>
<?php if ($v) { ?>
  <div class="box-header">
    <h3 class="box-title"><i class="fa fa-fw fa-toggle-right"></i> Reporte de baja de alumnos del ciclo escolar por plan de estudios</h3>
  </div>
  <div class="box-body">
    <table class="table table-striped">
      <tbody>
        <tr>
          <th>#</th>
          <th>Nombre del plan de estudios</th>
          <th style="text-align: center;">Total bajas</th>
        </tr>
        <?php $vx = 0;
        $_sb = 0;
        while ($ofe = $db->recorrer($sql_ofe)) { ?>
          <tr>
            <td><b><?php echo $vx = ($vx + 1); ?>.- </b></td>
            <td><?php echo $ofe['NomEducativa']; ?></td>
            <td style="text-align: center;"><?php echo $ofe['Total']; ?></td>
          </tr><?php $_sb = ($_sb + $ofe['Total']);
              } ?>
        <tr>
          <td colspan="2" style="text-align: right;"><b>TOTAL BAJAS: </b></td>
          <td style="text-align: center;"><b><?php echo $_sb; ?></b></td>
        </tr>
      </tbody>
    </table>
    <div class="box-footer clearfix">
      <?php if ($vx) { ?>
        <button onClick="window.open('repositorio/portafolio/bajas_plan.php?idCiclo=<?php echo $IdCiclo; ?>&idCampus=<?php echo $IdCampus; ?>','_blank'), cargar_lista_alumnos()" href="javascript:void(0);" title="Acta de calificación del docente" type="button" class="pull-right btn bg-maroon btn-flat margin">Generar PDF <i class="fa fa-fw fa-file-pdf-o"></i></button>
      <?php } ?>
    </div>
  </div>
<?php } else { ?>
  <img src="assets/images/alumnos_baja.jpg" style="width: 100%">
<?php } ?>

<script>
  Highcharts.chart('porcente_bajas', {
    chart: {
      plotBackgroundColor: null,
      plotBorderWidth: null,
      plotShadow: false,
      type: 'pie'
    },
    title: {
      text: 'Porcentaje de baja por Programa de Estudio',
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
            name: '<?php echo $_baj['Nombre']; ?>',
            y: <?php echo $_baj['Total']; ?>
          },
        <?php } ?>
      ]
    }]
  });

  Highcharts.chart('tipos_bjas', {
    data: {
      table: 'datatable_bajas'
    },
    chart: {
      type: 'column'
    },
    title: {
      text: 'Tipos de bajas'
    },
    xAxis: {
      type: 'Categoria'
    },
    yAxis: {
      allowDecimals: false,
      title: {
        text: 'Total'
      }
    },
    tooltip: {
      formatter: function() {
        return '<b>' + this.series.name + '</b><br/>' +
          this.point.y + ' ' + this.point.name.toLowerCase();
      }
    }
  });
</script>