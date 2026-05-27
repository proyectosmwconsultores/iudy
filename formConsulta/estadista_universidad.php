<?php
include('../hace.php');
$output = '';
require('../php/clases/class.System.php');
$db = new Conexion();
$IdCiclo = $_POST['IdCiclo'];
$IdCampus = 1;

$sql_camp = $db->query("SELECT tblc_campus.Campus FROM tblc_campus WHERE tblc_campus.IdCampus = '$IdCampus'");
$db->rows($sql_camp);
$_camp = $db->recorrer($sql_camp);

$sql_cicl = $db->query("SELECT tblc_ciclo.Ciclo FROM tblc_ciclo WHERE tblc_ciclo.IdCiclo = '$IdCiclo'");
$db->rows($sql_cicl);
$_cic = $db->recorrer($sql_cicl);

$sql_total = $db->query("SELECT Count(tblc_usuario.IdUsua) AS Total FROM tblc_ciclogrupo Left Join tblc_usuario ON tblc_usuario.IdGrupo = tblc_ciclogrupo.IdGrupo WHERE tblc_ciclogrupo.IdCiclo =  '$IdCiclo' AND tblc_usuario.IdEstatus = '8'");
$db->rows($sql_total);
$_total = $db->recorrer($sql_total);
$_total_us = $_total["Total"];
echo "SELECT Count(tblc_usuario.IdUsua) AS Total, tblc_usuario.Sexo FROM tblc_ciclogrupo Left Join tblc_usuario ON tblc_usuario.IdGrupo = tblc_ciclogrupo.IdGrupo WHERE tblc_ciclogrupo.IdCiclo =  '$IdCiclo' AND tblc_usuario.IdEstatus = '8' GROUP BY tblc_usuario.Sexo ORDER BY tblc_usuario.Sexo ASC ";

$sql_total_genero = $db->query("SELECT Count(tblc_usuario.IdUsua) AS Total, tblc_usuario.Sexo FROM tblc_ciclogrupo Left Join tblc_usuario ON tblc_usuario.IdGrupo = tblc_ciclogrupo.IdGrupo WHERE tblc_ciclogrupo.IdCiclo =  '$IdCiclo' AND tblc_usuario.IdEstatus = '8' GROUP BY tblc_usuario.Sexo ORDER BY tblc_usuario.Sexo ASC ");


$sql_nuevo = $db->query("SELECT Count(tblc_usuario.IdUsua) AS Nuevo FROM tblc_usuario WHERE tblc_usuario.IdCampus =  '1' AND tblc_usuario.id_ciclo_ini =  '$IdCiclo'");
$db->rows($sql_nuevo);
$_nuevo = $db->recorrer($sql_nuevo);
$_nuevo_us = $_nuevo["Nuevo"];

$sql_nuevo_genero = $db->query("SELECT
  Count(tblc_usuario.IdUsua) AS Nuevo,
  tblc_usuario.Sexo
  FROM
  tblc_usuario
  WHERE
  tblc_usuario.IdCampus =  '1' AND
  tblc_usuario.id_ciclo_ini =  '$IdCiclo'
  GROUP BY tblc_usuario.Sexo
  ORDER BY tblc_usuario.Sexo ASC
  ");


$sql_bajas = $db->query("SELECT tblc_ciclogrupo.IdCicloGrupo, Count(tblc_usuario.IdUsua) AS Bajas FROM tblc_ciclogrupo Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_ciclogrupo.IdGrupo AND tblp_grupo.IdCicloIni = tblc_ciclogrupo.IdCiclo Left Join tblc_usuario ON tblc_usuario.IdGrupo = tblc_ciclogrupo.IdGrupo WHERE tblc_ciclogrupo.IdCiclo =  '$IdCiclo' AND tblc_usuario.IdCampus = '$IdCampus' AND tblc_usuario.id_ciclo_fin = '$IdCiclo' ");
$db->rows($sql_bajas);
$_bajas = $db->recorrer($sql_bajas);
$_total_bajas = $_bajas["Bajas"];

$sql_bajas_temprana = $db->query("SELECT Count(tblc_usuario.IdUsua) AS Total FROM tblc_usuario WHERE tblc_usuario.Permisos =  '3' AND tblc_usuario.id_ciclo_fin =  '$IdCiclo' AND tblc_usuario.IdEstatus =  '14'");
$sql_bajas_reprobacion = $db->query("SELECT Count(tblc_usuario.IdUsua) AS Total FROM tblc_usuario WHERE tblc_usuario.Permisos =  '3' AND tblc_usuario.id_ciclo_fin =  '$IdCiclo' AND tblc_usuario.IdEstatus =  '18'");
$sql_bajas_ausencia = $db->query("SELECT Count(tblc_usuario.IdUsua) AS Total FROM tblc_usuario WHERE tblc_usuario.Permisos =  '3' AND tblc_usuario.id_ciclo_fin =  '$IdCiclo' AND tblc_usuario.IdEstatus =  '19'");
$sql_bajas_desercion = $db->query("SELECT Count(tblc_usuario.IdUsua) AS Total FROM tblc_usuario WHERE tblc_usuario.Permisos =  '3' AND tblc_usuario.id_ciclo_fin =  '$IdCiclo' AND tblc_usuario.IdEstatus =  '20'");


$sql_user_oferta = $db->query("SELECT
tblc_ciclogrupo.IdCicloGrupo,
tblp_grupo.IdGrupo,
tblp_grupo.CveGrupo,
tblp_grupo.IdOferta,
tblc_ciclogrupo.Grado,
tblp_educativa.Nombre
FROM
tblc_ciclogrupo
Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_ciclogrupo.IdGrupo
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_grupo.IdOferta
WHERE
tblc_ciclogrupo.IdCiclo =  '$IdCiclo'
ORDER BY
tblp_grupo.IdOferta ASC,
tblc_ciclogrupo.Grado ASC
");
$sql_user_oferta2 = $db->query("SELECT tblc_ciclogrupo.IdCicloGrupo, tblc_usuario.IdOferta, tblp_educativa.Nombre FROM tblc_ciclogrupo Left Join tblc_usuario ON tblc_usuario.IdGrupo = tblc_ciclogrupo.IdGrupo Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta WHERE tblc_ciclogrupo.IdCiclo =  '$IdCiclo' AND tblc_usuario.IdCampus =  '$IdCampus' AND tblc_usuario.IdEstatus =  '8' GROUP BY tblc_usuario.IdOferta ");

?>
<div class="bg-navy color-palette" style="padding: 10px; text-align: center; border-radius: 20px;"><span><?php echo $_camp["Campus"]; ?><br><?php echo $_cic["Ciclo"]; ?></span></div>
<br>
<div class="row">


  
  <div class="col-md-4 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-aqua"><i class="fa fa-users"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Total alumnos</span>
        <span class="info-box-number"><?php echo $_total_us; ?></span>
      </div>
    </div>
  </div>
  <?php while ($total_genero = $db->recorrer($sql_total_genero)) {
    if ($total_genero['Sexo'] == 'H') {
      $_gen = 'Hombres';
      $_col = 'yellow';
      $_ico = 'male';
    }
    if ($total_genero['Sexo'] == 'M') {
      $_gen = 'Mujeres';
      $_col = 'red';
      $_ico = 'female';
    }
  ?>
    <div class="col-md-4 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-<?php echo $_col; ?>"><i class="fa fa-<?php echo $_ico; ?>"></i></span>
        <div class="info-box-content">
          <span class="info-box-text"><?php echo $_gen; ?></span>
          <span class="info-box-number"><?php echo $total_genero['Total']; ?></span>
        </div>
      </div>
    </div><?php } ?>
</div>
<div class="row">
  <div class="col-md-4 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-green"><i class="fa fa-fw fa-arrow-circle-up"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Nuevo ingreso</span>
        <span class="info-box-number"><?php echo $_nuevo_us; ?></span>
      </div>
    </div>
  </div>
  <?php while ($nuevo_genero = $db->recorrer($sql_nuevo_genero)) {
    if ($nuevo_genero['Sexo'] == 'M') {
      $_gen = 'Hombres';
      $_col = 'yellow';
      $_ico = 'male';
    }
    if ($nuevo_genero['Sexo'] == 'F') {
      $_gen = 'Mujeres';
      $_col = 'red';
      $_ico = 'female';
    }
  ?>
    <div class="col-md-4 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-<?php echo $_col; ?>"><i class="fa fa-<?php echo $_ico; ?>"></i></span>
        <div class="info-box-content">
          <span class="info-box-text"><?php echo $_gen; ?></span>
          <span class="info-box-number"><?php echo $nuevo_genero['Nuevo']; ?></span>
        </div>
      </div>
    </div><?php } ?>
</div>
<div class="row">
<div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-info"><i class="fa fa-chevron-down"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Baja temprana</span>
        <span class="info-box-text">
          <?php 
          $totalT = 0;
          while ($_baja_temprana = $db->recorrer($sql_bajas_temprana)) {
            $totalT = $_baja_temprana['Total'];  
          } ?>
          <i class='fa fa-times-circle'></i>  <?php echo $totalT; ?>
        </span>
      </div>
    </div>
  </div>
  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-purple"><i class="fa fa-chevron-circle-down"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Baja reprobación</span>
        <span class="info-box-text">
        <?php 
          $total = 0;
          while ($_baja_repro = $db->recorrer($sql_bajas_reprobacion)) {
            $total = $_baja_repro['Total'];  
          } ?>
          <i class='fa fa-times-circle'></i>  <?php echo $total; ?>
        </span>
      </div>
    </div>
  </div>
  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-info"><i class="fa fa-chevron-down"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Baja por deserción</span>
        <span class="info-box-text">
        <?php 
          $total = 0;
          while ($_baja_desercion = $db->recorrer($sql_bajas_desercion)) {
            $total = $_baja_desercion['Total'];  
          } ?>
          <i class='fa fa-times-circle'></i>  <?php echo $total; ?>
        </span>
      </div>
    </div>
  </div>
  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-black"><i class="fa fa-fw fa-arrow-circle-down"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Bajas por ausencia</span>
        <span class="info-box-text">
        <?php 
          $total = 0;
          while ($_baja_ausencia = $db->recorrer($sql_bajas_ausencia)) {
            $total = $_baja_ausencia['Total'];  
          } ?>
          <i class='fa fa-times-circle'></i>  <?php echo $total; ?>
        </span>
      </div>
    </div>
  </div>
</div>
<br>
<!-- <div class="bg-navy color-palette" style="padding: 10px; text-align: center;"><span>TOTAL ALUMNOS POR PLANES DE ESTUDIOS</span></div> -->
<div class="row" id="root">
  <div class="col-md-12 col-sm-6 col-xs-12">
    <div class="info-box">
      <div class="box-header with-border" style="background: #8f9ebf !important;">
        <h3 class="box-title" style="font-size: 14px; color: black;"><span><i style="color: white;" class="fa fa-users"></i> TOTAL ALUMNOS POR PLANES DE ESTUDIOS DEL PERIODO ESCOLAR <?php echo $_cic["Ciclo"]; ?></span></h3>

        <div class="box-tools pull-right">
          <div class="btn-group">

            <!-- <button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i style="color: blue;" class="fa fa-fw fa-file-excel-o"></i></button> -->
            <!-- <button title="Descargar en formato PDF" onclick="testImprimir()" href="javascript:void(0);" type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i style="color: white;" class="fa fa-fw fa-file-pdf-o"></i></button> -->
          </div>
        </div>
      </div>
      <table class="table table-striped" style="font-size: 12px;">
        <tbody>
          <tr style="background: #b5bbc8 !important;">
            <th style="width: 10px" rowspan="2"><br><i class="fa fa-fw fa-sort-numeric-asc"></i></th>
            <th rowspan="2"><br>Plan de estudios</th>
            <th rowspan="2" style="text-align: center;">Grupo</th>
            <th colspan='2' style="text-align: center;">Bajas</th>
            <th rowspan="2" style="text-align: center;">Total bajas</th>
            <th colspan='2' style="text-align: center;">Activos</th>
            <th rowspan="2" style="text-align: center;">Total activos</th>
          </tr>
          <tr style="background: #b5bbc8 !important;">
            <th style="text-align: center;">Hombres</th>
            <th style="text-align: center;">Mujeres</th>
            <th style="text-align: center;">Hombres</th>
            <th style="text-align: center;">Mujeres</th>
          </tr>
          <?php $no = 0;
          $suma_total = 0;
          $mx_b = 0;
          $mx_a = 0;
          $tx_h = 0;
          $tx_m = 0;
          $sumx = 0;
          while ($user_oferta = $db->recorrer($sql_user_oferta)) {
            $idOferta = $user_oferta['IdOferta'];
            $idGrupo = $user_oferta['IdGrupo'];

            $sql_g = $db->query("SELECT Count(tblc_ciclogrupo.IdGrupo) AS Total, tblp_grupo.IdGrupo FROM tblc_ciclogrupo Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_ciclogrupo.IdGrupo WHERE tblp_grupo.IdOferta = '$idOferta' AND tblc_ciclogrupo.IdCiclo = '$IdCiclo' GROUP BY tblc_ciclogrupo.IdCiclo");
            $db->rows($sql_g);
            $_grp = $db->recorrer($sql_g);
            $_grptotal = $_grp["Total"];

            $sql_us_oferta = $db->query("SELECT tblc_ciclogrupo.IdCicloGrupo, Count(tblc_usuario.IdUsua) AS Total, tblc_usuario.Sexo FROM tblc_ciclogrupo Left Join tblc_usuario ON tblc_usuario.IdGrupo = tblc_ciclogrupo.IdGrupo WHERE tblc_ciclogrupo.IdCiclo =  '$IdCiclo' AND tblc_usuario.IdGrupo = '$idGrupo' AND  tblc_usuario.IdCampus =  '$IdCampus' AND tblc_usuario.IdEstatus =  '8' AND tblc_usuario.IdOferta =  '$idOferta' GROUP BY tblc_usuario.Sexo ");
            $h_a = 0;
            $m_a = 0;
            $sum_a = 0;
            while ($us_oferta = $db->recorrer($sql_us_oferta)) {
              if ($us_oferta['Sexo'] == 'M') {
                $h_a = $us_oferta['Total'];
              }
              if ($us_oferta['Sexo'] == 'F') {
                $m_a = $us_oferta['Total'];
              }
            }
            $sum_a = ($h_a + $m_a);

            $sql_us_oferta2 = $db->query("SELECT Count(tblc_usuario.IdUsua) AS Total, tblc_usuario.Sexo FROM tblc_ciclogrupo Left Join tblc_usuario ON tblc_usuario.IdGrupo = tblc_ciclogrupo.IdGrupo WHERE tblc_ciclogrupo.IdCiclo =  '$IdCiclo' AND tblc_usuario.IdGrupo = '$idGrupo' AND tblc_usuario.id_ciclo_fin =  '$IdCiclo' AND ((tblc_usuario.IdEstatus =  '14') || (tblc_usuario.IdEstatus =  '18') || (tblc_usuario.IdEstatus =  '19') || (tblc_usuario.IdEstatus =  '20')) GROUP BY tblc_usuario.Sexo ");
            $h_b = 0;
            $m_b = 0;
            $sum_b = 0;
            while ($us_ofertab = $db->recorrer($sql_us_oferta2)) {
              if ($us_ofertab['Sexo'] == 'M') {
                $h_b = $us_ofertab['Total'];
              }
              if ($us_ofertab['Sexo'] == 'F') {
                $m_b = $us_ofertab['Total'];
              }
            }
            $sum_b = ($h_b + $m_b);
          ?>
            <tr>
              <td><b><?php echo $no = ($no + 1); ?>.- </b></td>
              <td><?php echo $user_oferta['Nombre']; ?></td>
              <td style="text-align: center;"><?php echo $user_oferta['Grado'].'° '.$user_oferta['CveGrupo']; ?></td>
              <td style="text-align: center;"><?php echo $h_b; ?></td>
              <td style="text-align: center;"><?php echo $m_b; ?></td>
              <td style="text-align: center;"><?php echo $sum_b; ?></td>
              <td style="text-align: center;"><?php echo $h_a; ?></td>
              <td style="text-align: center;"><?php echo $m_a; ?></td>
              <td style="text-align: center;"><?php echo $sum_a; ?></td>
              

            </tr><?php $suma_total = ($suma_total + $sum_a);
                  $mx_b = ($mx_b + $sum_b);
                  $mx_a = ($mx_a + $sum_a);
                  $sumx = ($sumx + $tx_h + $tx_m);
                } ?>
          <tr>
            <td colspan="5" style="text-align: right;"><b>Total alumnos baja:</b></td>
            <td style="text-align: center; color: red;"><b><?php echo $mx_b; ?></b></td>
            <td colspan="2" style="text-align: right;"><b>Total activos:</b></td>
            <td style="text-align: center; color: blue;"><b><?php echo $mx_a; ?></b></td>
          </tr>
          <tr>
            <th colspan='5' style="text-align: right;">+ Bajas tempranas:</th>
            <th style="text-align: center;"><b><?php echo $totalT; $bax = ($mx_b + $totalT); ?></th>
            <th rowspan="3" style="text-align: center;"></th>
          </tr>
          <tr>
            <th colspan='5' style="text-align: right;">Total bajas:</th>
            <th style="text-align: center; background:yellow;"><b><?php echo $bax; ?></th>
            <th rowspan="2" style="text-align: center;">Total alumnos activos</th>
            <th style="text-align: center; background:yellow;"><b><?php echo ($mx_a - $bax); ?></b></th>
          </tr>
          

        </tbody>
      </table>
      <br><br>

      <!-- <figure class="highcharts-figure">
        <div id="container" style="width: 100%"></div>

        <table id="datatable" style="display: none;">
          <thead>
            <tr>
              <th></th>
              <th>Hombres</th>
              <th>Mujeres</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = 0;
            $suma_total = 0;
            while ($user_oferta = $db->recorrer($sql_user_oferta2)) {
              $idOferta = $user_oferta['IdOferta'];
              $sql_us_oferta = $db->query("SELECT tblc_ciclogrupo.IdCicloGrupo, Count(tblc_usuario.IdUsua) AS Total, tblc_usuario.Sexo FROM tblc_ciclogrupo Left Join tblc_usuario ON tblc_usuario.IdGrupo = tblc_ciclogrupo.IdGrupo WHERE tblc_ciclogrupo.IdCiclo =  '$IdCiclo' AND tblc_usuario.IdCampus =  '$IdCampus' AND tblc_usuario.IdEstatus =  '8' AND tblc_usuario.IdOferta =  '$idOferta' GROUP BY tblc_usuario.Sexo ");
              $h = 0;
              $m = 0;
              $sum = 0;
              while ($us_oferta = $db->recorrer($sql_us_oferta)) {
                if ($us_oferta['Sexo'] == 'M') {
                  $h = $us_oferta['Total'];
                }
                if ($us_oferta['Sexo'] == 'F') {
                  $m = $us_oferta['Total'];
                }
              }
              $sum = ($h + $m);
            ?>
              <tr>
                <th><?php echo $user_oferta['Nombre']; ?></th>
                <td><?php echo $h; ?></td>
                <td><?php echo $m; ?></td>
              </tr><?php } ?>
          </tbody>
        </table>
      </figure> -->
    </div>
  </div>
</div>
<script>
  Highcharts.chart('container', {
    data: {
      table: 'datatable'
    },
    chart: {
      type: 'column'
    },
    title: {
      text: 'Total alumnos por género y plan de estudios'
    },
    yAxis: {
      allowDecimals: false,
      title: {
        text: 'Total alumnos'
      }
    },
    tooltip: {
      formatter: function() {
        return '<b>' + this.point.name + '</b><br/>' +
          this.point.y + ' ' + this.series.name;
      }
    }
  });
</script>
<script>
  function testImprimir() {
    var Nombre = 'Universidad_en_numeros';
    // Get the element.
    var element = document.getElementById('root');

    // Generate the PDF.
    html2pdf().from(element).set({
      margin: 1,
      filename: Nombre + '.pdf',
      html2canvas: {
        scale: 3
      },
      jsPDF: {
        orientation: 'landscape',
        unit: 'in',
        format: 'a3',
        compressPDF: true
      }
    }).save();
  }
  
</script>