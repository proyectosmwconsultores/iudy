<?php
include('../hace.php');

  $output = '';
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $code = $_POST["IdCiclo"];
  $pieces = explode("_", $code);
  $IdCiclo = $pieces[0]; // piece1
  $IdGrupo = $pieces[1]; // piece2

  $sqlH = $db->query("SELECT tblc_ciclo.Ciclo FROM tblc_ciclo WHERE tblc_ciclo.IdCiclo =  '$IdCiclo'");
  $db->rows($sqlH);
  $datos81 = $db->recorrer($sqlH);

  $sqlG = $db->query("SELECT
tblp_grupo.CveGrupo,
tblp_grupo.IdGrupo,
tblp_educativa.Nombre,
tblc_modalidad._Modalidad
FROM
tblp_grupo
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_grupo.IdOferta
Left Join tblc_modalidad ON tblc_modalidad.Mod = tblp_grupo.Modalidad

 WHERE tblp_grupo.IdGrupo =  '$IdGrupo'");
  $db->rows($sqlG);
  $datos91 = $db->recorrer($sqlG);


  $sql_user = $db->query("SELECT
tblp_asignacion.IdAsignacion,
tblp_moduloalumno.IdUsua,
Sum(tblp_moduloalumno.A) AS A,
Sum(tblp_moduloalumno.F) AS F,
Sum(tblp_moduloalumno.R) AS R,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno
FROM
tblp_asignacion
Left Join tblp_moduloalumno ON tblp_moduloalumno.IdAsignacion = tblp_asignacion.IdAsignacion
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_moduloalumno.IdUsua
WHERE
tblp_asignacion.IdCiclo =  '$IdCiclo' AND
tblp_asignacion.IdGrupo =  '$IdGrupo' AND
tblp_asignacion.Tipo =  '2'
GROUP BY
tblp_moduloalumno.IdUsua
 ");

 $sql_mod = $db->query("SELECT
tblp_asignacion.IdAsignacion,
tblp_modulo.NombreMod,
tblp_asignacion.IdModulo
FROM
tblp_asignacion
Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo
WHERE tblp_asignacion.IdCiclo = '$IdCiclo' AND tblp_asignacion.IdGrupo = '$IdGrupo' AND tblp_asignacion.Tipo = '2'
");

?>
   <table class="table table-striped" style="font-size: 12px;">
     <input type="hidden" name="_per" id="_per" value="<?php echo $datos81["Ciclo"]; ?>">
     <input type="hidden" name="_cve" id="_cve" value="<?php echo $datos91["CveGrupo"]; ?>">
         <tbody>
           <tr>
             <td colspan="2" style="padding: 10px;"><b><?php echo $datos91["Nombre"]; ?> - <?php echo $datos91["_Modalidad"]; ?></b></td>
           </tr>
           <tr>
             <td style="padding: 10px;"><b>PERIODO ESCOLAR:</b> <?php echo $datos81["Ciclo"]; ?></td>
             <td style="padding: 10px;"><b>GRUPO:</b> <?php echo $datos91["CveGrupo"]; ?></td>
           </tr>
       </tbody>
</table>

<div class="bg-gray-active color-palette" style="padding: 10px;"><span style="color: black;"><i class="fa fa-fw fa-check-circle"></i> REPORTE DE ASISTENCIA POR ALUMNO EN EL PERIODO ESCOLAR <?php echo $datos81["Ciclo"]; ?></span></div>
<table id="datatable_usx" class="table table-striped" style="font-size: 12px;">
        <thead>
            <tr>
                <th></th>
                <th style="text-align: center;">ASISTENCIA</th>
                <th style="text-align: center;">PERMISO</th>
                <th style="text-align: center;">FALTA</th>
            </tr>
        </thead>
        <tbody>
          <?php $a=0; $p=0; $f=0; while($x = $db->recorrer($sql_user)){ ?>
            <tr>
              <th><?php echo $x['APaterno'].' '.$x['AMaterno'].' '.$x['Nombre']; ?></th>
              <th style="text-align: center;"><?php echo $x['A']; ?></th>
              <th style="text-align: center;"><?php echo $x['R']; ?></th>
              <th style="text-align: center;"><?php echo $x['F']; ?></th>

            </tr><?php $a = ($a + $x['A']); $p = ($p + $x['R']); $f = ($f + $x['F']); } ?>
        </tbody>
    </table>
    <input type="hidden" name="A" id="A" value="<?php echo $a; ?>">
    <input type="hidden" name="P" id="P" value="<?php echo $p; ?>">
    <input type="hidden" name="F" id="F" value="<?php echo $f; ?>">
    <figure class="highcharts-figure">
        <div id="container_usx"></div>
    </figure>
<hr>
<div class="bg-gray-active color-palette" style="padding: 10px;"><span style="color: black;"><i class="fa fa-fw fa-check-circle"></i> REPORTE DE ASISTENCIA POR MATERIA EN EL PERIODO ESCOLAR <?php echo $datos81["Ciclo"]; ?></span></div>
<table id="datatable_mod" class="table table-striped" style="font-size: 12px;">
        <thead>
            <tr>
                <th></th>
                <th style="text-align: center;">ASISTENCIA</th>
                <th style="text-align: center;">PERMISO</th>
                <th style="text-align: center;">FALTA</th>
            </tr>
        </thead>
        <tbody>
          <?php while($y = $db->recorrer($sql_mod)){ $IdM = $y['IdModulo'];
            $sql_mx = $db->query("SELECT tblp_asignacion.IdAsignacion, Sum(tblp_moduloalumno.A) AS A, Sum(tblp_moduloalumno.F) AS F, Sum(tblp_moduloalumno.R) AS R FROM tblp_asignacion Left Join tblp_moduloalumno ON tblp_moduloalumno.IdAsignacion = tblp_asignacion.IdAsignacion WHERE tblp_asignacion.IdCiclo =  '$IdCiclo' AND tblp_asignacion.IdGrupo =  '$IdGrupo' AND tblp_asignacion.Tipo =  '2' AND tblp_asignacion.IdModulo =  '$IdM' GROUP BY tblp_moduloalumno.IdModulo");
            $db->rows($sql_mx);
            $_mod = $db->recorrer($sql_mx);
             ?>
            <tr>
              <th><?php echo $y['NombreMod']; ?></th>
              <th style="text-align: center;"><?php echo $_mod['A']; ?></th>
              <th style="text-align: center;"><?php echo $_mod['R']; ?></th>
              <th style="text-align: center;"><?php echo $_mod['F']; ?></th>
            </tr><?php  } ?>
        </tbody>
    </table>
    <figure class="highcharts-figure">
        <div id="container_mod"></div>
    </figure>
    <hr>
    <div class="bg-gray-active color-palette" style="padding: 10px;"><span style="color: black;"> <i class="fa fa-fw fa-check-circle"></i> GRÁFICA DE ASISTENCIA EN PORCETAJE EN EL PERIODO ESCOLAR <?php echo $datos81["Ciclo"]; ?></span></div>
    <figure class="highcharts-figure">
        <div id="container_grp"></div>
    </figure>
<script>
var Ciclo = document.getElementById("_per").value;
var Grupo = document.getElementById("_cve").value;
Highcharts.chart('container_grp', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'GRÁFICA DE ASISTENCIA DEL PERIODO ESCOLAR: ' + Ciclo + ' DEL GRUPO : ' + Grupo
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
        name: 'Porcentaje',
        colorByPoint: true,
        data: [{
            name: 'Asistencia',
            y: <?php echo $a; ?>,
            sliced: true,
            selected: true
        }, {
            name: 'Permiso',
            y: <?php echo $p; ?>
        }, {
            name: 'Falta',
            y: <?php echo $f; ?>
        }]
    }]
});

Highcharts.chart('container_usx', {
    data: {
        table: 'datatable_usx'
    },
    chart: {
        type: 'column'
    },
    title: {
        text: 'GRÁFICA DE ASISTENCIA EN EL PERIODO ESCOLAR: ' + Ciclo + ' DEL GRUPO : ' + Grupo
    },
    yAxis: {
        allowDecimals: false,
        title: {
            text: 'Total asistencia'
        }
    },
    tooltip: {
        formatter: function () {
            return '<b>' + this.series.name + ': ' + this.point.y + '</b><br/> ' + this.point.name;
        }
    }
});

Highcharts.chart('container_mod', {
    data: {
        table: 'datatable_mod'
    },
    chart: {
        type: 'column'
    },
    title: {
        text: 'GRÁFICA DE ASISTENCIA EN EL PERIODO ESCOLAR: ' + Ciclo + ' DEL GRUPO : ' + Grupo
    },
    yAxis: {
        allowDecimals: false,
        title: {
            text: 'Total asistencia'
        }
    },
    tooltip: {
        formatter: function () {
            return '<b>' + this.series.name + ': ' + this.point.y + '</b><br/> ' + this.point.name;
        }
    }
});
</script>
