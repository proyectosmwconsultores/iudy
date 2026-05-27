<?php
include('../hace.php');

  $output = '';
  require('../php/clases/class.System.php');
  $db = new Conexion();

  $IdAsignacion = $_POST["IdAsignacion"];

  $sqlH = $db->query("SELECT tblp_asignacion.IdAsignacion, tblp_educativa.Nombre, tblp_modulo.CodeModulo, tblp_modulo.NombreMod, tblp_grupo.CveGrupo FROM tblp_asignacion Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_asignacion.IdEducativa Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblp_asignacion.IdGrupo WHERE tblp_asignacion.IdAsignacion =  '$IdAsignacion' AND tblp_asignacion.Tipo =  '2' ");
  $db->rows($sqlH);
  $datos81 = $db->recorrer($sqlH);

  $sql_prom1 = $db->query("SELECT tblx_grafica_materia.IdPregunta, tblx_grafica_materia.Promedio, tblx_pregunta.Pregunta FROM tblx_grafica_materia Left Join tblx_pregunta ON tblx_pregunta.IdPregunta = tblx_grafica_materia.IdPregunta WHERE tblx_grafica_materia.IdAsignacion =  '$IdAsignacion' ");
  $sql_user = $db->query("SELECT tblp_moduloalumno.IdUsua, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblp_moduloalumno.A, tblp_moduloalumno.F, tblp_moduloalumno.R FROM tblp_moduloalumno Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_moduloalumno.IdUsua WHERE tblp_moduloalumno.IdAsignacion =  '$IdAsignacion' ORDER BY tblc_usuario.AMaterno ASC ");

?>
   <table class="table table-striped" style="font-size: 12px;">
         <tbody>
           <tr style="background: #003A70; color: white;">
             <td style="padding: 10px;"><b>MATERIA:</b> <?php echo $datos81["NombreMod"]; ?></td>
             <td style="padding: 10px;"><b>GRUPO:</b> <?php echo $datos81["CveGrupo"]; ?></td>
           </tr>
       </tbody>
</table>

<div class="bg-gray-active color-palette" style="padding: 10px;"><span style="color: black;"> <i class="fa fa-fw fa-check-circle"></i> REPORTE DE ASISTENCIA DEL GRUPO <?php echo $datos81["CveGrupo"]; ?></span></div>
<table id="datatable_us" class="table table-striped" style="font-size: 12px;">
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
        <div id="container_us"></div>
    </figure>

    <hr>
    <div class="bg-gray-active color-palette" style="padding: 10px;"><span style="color: black;"> <i class="fa fa-fw fa-check-circle"></i> GRÁFICA DE ASISTENCIA DEL GRUPO <?php echo $datos81["CveGrupo"]; ?></span></div>
    <figure class="highcharts-figure">
        <div id="container_por"></div>
    </figure>
<script>
var _a = document.getElementById("A").value;
var _p = document.getElementById("P").value;
var _f = document.getElementById("F").value;
Highcharts.chart('container_por', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Gráfica de asistencia en porcentaje'
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

Highcharts.chart('container_us', {
    data: {
        table: 'datatable_us'
    },
    chart: {
        type: 'column'
    },
    title: {
        text: 'Gráfica de asistencia del grupo'
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
