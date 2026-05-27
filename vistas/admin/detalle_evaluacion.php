<?php
session_start();
require('../../php/clases/class.System.php');
$db = new Conexion();

$IdAsignacion = $_POST["IdAsignacion"];
$sql_asig = $db->query("SELECT Count(tblx_evaluacion.IdEvaluacionX) AS Total, Avg(tblx_evaluacion.Promedio) AS Promedio FROM tblx_evaluacion WHERE tblx_evaluacion.IdAsignacion =  '$IdAsignacion' AND tblx_evaluacion.Tipo =  '2' AND tblx_evaluacion.IdEstatus =  '10' GROUP BY tblx_evaluacion.IdAsignacion ");
$db->rows($sql_asig); 
$_asig = $db->recorrer($sql_asig);


$sql2 = $db->query("SELECT
tblx_respuesta.IdPregunta,
Avg(tblx_respuesta.Respuesta) AS Promedio,
tblx_pregunta.Pregunta
FROM
tblx_respuesta
Left Join tblx_pregunta ON tblx_pregunta.IdPregunta = tblx_respuesta.IdPregunta
WHERE
tblx_respuesta.IdAsignacion =  '$IdAsignacion' AND
tblx_respuesta.IdEstatus =  '26' AND
tblx_pregunta.Permisos =  '2'
GROUP BY
tblx_respuesta.IdPregunta,
tblx_pregunta.Pregunta
");

$sql3 = $db->query("SELECT
tblx_respuesta.IdPregunta,
Avg(tblx_respuesta.Respuesta) AS Promedio,
tblx_pregunta.Pregunta
FROM
tblx_respuesta
Left Join tblx_pregunta ON tblx_pregunta.IdPregunta = tblx_respuesta.IdPregunta
WHERE
tblx_respuesta.IdAsignacion =  '$IdAsignacion' AND
tblx_respuesta.IdEstatus =  '26' AND
tblx_pregunta.Permisos =  '2'
GROUP BY
tblx_respuesta.IdPregunta,
tblx_pregunta.Pregunta
");

?>

<form name="frm2xfYj" id="frm2xfYj" action="addNewPago.php" method="POST" enctype="multipart/form-data" class="form-horizontal">
<input type="hidden" name="docente2" id="docente2" value="DOCENTE:" >

 
  
  <table class="table table-striped" style="font-size: 12px;" >
    <tbody>
      <tr>
        <th style="width: 10px">#</th>
        <th>Pregunta</th>
        <th style="text-align: center;">Promedio</th>
      </tr>
      <?php $h = 0;
      while ($y = $db->recorrer($sql2)) { ?>
        <tr>
          <td><b><?php echo $h = $h + 1; ?>.- </b></td>
          <td><?php echo $y["Pregunta"]; ?></td>
          <td style="text-align: center;"><b><?php echo round($y["Promedio"], 2); ?></b></td>
        </tr>
      <?php } ?>
      <tr>
          <td colspan="2"><b>PROMEDIO:</b></td>
          <td style="text-align: center; background: yellow;"><b><?php echo round($_asig['Promedio'], 2); ?></b></td>
        </tr>
    </tbody>
  </table>
  <table class="table table-striped" style="font-size: 12px; display: none;" id="datatable_mod2">
    <tbody>
      <tr>
        <th>Pregunta</th>
        <th style="text-align: center;">Promedio</th>
      </tr>
      <?php $h = 0;
      while ($y = $db->recorrer($sql3)) { ?>
        <tr>
          <td><?php echo $y["Pregunta"]; ?></td>
          <td style="text-align: center;"><?php echo round($y["Promedio"], 2); ?></td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
  <div id="container_mod2" style="width: 100%;"></div>
</form>

<script>
var Docente = 'hola';
Highcharts.chart('container_mod2', {
data: {
  table: 'datatable_mod2'
},
chart: {
  type: 'column',
  options3d: {
    enabled: true,
    alpha: 10,
    beta: 25,
    depth: 70
  }
},
title: {
  text: 'RESULTADO DE LA EVALUACIÓN DOCENTE'
},
yAxis: {
  allowDecimals: false,
  title: {
    text: 'Promedio alcanzado'
  }
},
tooltip: {
  formatter: function () {
    return '<b>Promedio: </b> ' + this.point.y;
  }
}
});

</script>
