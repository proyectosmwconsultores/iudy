<?php
  session_start();
  $IdUsua = $_SESSION['IdUsua'];
  require('../../php/clases/consultas_formatos.php');
  $formato = new Class_formatos();
  $IdAsignacion = $_POST['IdAsignacion'];
  $tareas = $formato->lista_tareas_creadas($IdAsignacion);
  $mat = $formato->materia_finalizada_id($IdAsignacion);

  ?>
<input type="hidden" id="_materia" value="<?php echo $mat[0]['NombreMod']; ?>">
<input type="hidden" id="_docente" value="<?php echo $mat[0]['Nombre'].' '.$mat[0]['APaterno'].' '.$mat[0]['AMaterno']; ?>">
  <figure class="highcharts-figure">
    <div id="container"></div>
    <table id="datatable" style="display: none;">
        <thead>
            <tr>
                <th></th>
                <th>Entregado</th>
                <th>Calificado</th>
            </tr>
        </thead>
        <tbody>
            <?php for ($i = 0; $i < sizeof($tareas); $i++) {
              $ent = $formato->tareas_entregdas($IdAsignacion,$tareas[$i]['IdActividadesDocente']);
              $cal = $formato->tareas_calificadas($IdAsignacion,$tareas[$i]['IdActividadesDocente']);
              ?>
            <tr>
                <th><?php echo $tareas[$i]['NomActividad']; ?> (<?php echo $tareas[$i]['Porcentaje']; ?>%)</th>
                <td><?php echo $ent[0]['Entregadas']; ?></td>
                <td><?php echo $cal[0]['Calificado']; ?></td>
            </tr><?php } ?>
        </tbody>
    </table>

    <table class="table table-striped" style="font-size: 12px;">
        <thead>
            <tr>
                <th colspan="2">NOMBRE DE LA ACTIVIDAD</th>
                <th style="text-align: center;">PORCENTAJE</th>
                <th style="text-align: center;">ENTREGADO</th>
                <th style="text-align: center;">CALIFICADO</th>
            </tr>
        </thead>
        <tbody>
            <?php $c = 0; for ($i = 0; $i < sizeof($tareas); $i++) {
              $ent = $formato->tareas_entregdas($IdAsignacion,$tareas[$i]['IdActividadesDocente']);
              $cal = $formato->tareas_calificadas($IdAsignacion,$tareas[$i]['IdActividadesDocente']);
              ?>
            <tr>
                <th><b><?php echo $c = ($c + 1); ?>.- </b></th>
                <th style="cursor: pointer;" onclick="vst_lista_tareas_alumno('<?php echo $IdAsignacion; ?>',<?php echo $tareas[$i]['IdActividadesDocente']; ?>)"><?php echo $tareas[$i]['TipoActividad']; ?> - <?php echo $tareas[$i]['NomActividad']; ?></th>
                <td style="text-align: center;"><?php echo $tareas[$i]['Porcentaje']; ?> %</td>
                <td style="text-align: center;"><?php echo $ent[0]['Entregadas']; ?></td>
                <td style="text-align: center;"><?php echo $cal[0]['Calificado']; ?></td>
            </tr><?php } ?>
        </tbody>
    </table>

    <div class="btn-group">
        <button type="button" onclick="javascript:window.open('repositorio/portafolio/acta_calificacion_final.php?tokenId=<?php echo $IdAsignacion; ?>');" href="javascript:void(0);" class="btn btn-info"><i class="fa fa-print"></i> Acta de calificación</button>
        <button style="margin-left: 15px;" onclick="javascript:window.open('repositorio/portafolio/asistencia_licenciatura_ejecutiva.php?tokenId=<?php echo $IdAsignacion; ?>');" href="javascript:void(0);" type="button" class="btn btn-success"><i class="fa fa-edit"></i> Lista de asistencia</button>
    </div>
</figure>

<script>
  var Materia = document.getElementById("_materia").value;
  var Docente = document.getElementById("_docente").value;
  
  Highcharts.chart('container', {
    data: {
        table: 'datatable'
    },
    chart: {
        type: 'column'
    },
    title: {
        text: Materia
    },
    subtitle: {
        text:
            'DOCENTE: ' + Docente
    },
    xAxis: {
        type: 'category'
    },
    yAxis: {
        allowDecimals: false,
        title: {
            text: 'Total'
        }
    },
    tooltip: {
        formatter: function () {
            return '<b>' + this.series.name + '</b><br/>' +
                this.point.y + ' ' + this.point.name.toLowerCase();
        }
    }
});

</script>

