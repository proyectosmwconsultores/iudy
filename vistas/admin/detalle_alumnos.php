<?php
session_start();
require('../../php/clases/class.System.php');
$db = new Conexion();

$IdAsignacion = $_POST["IdAsignacion"];

$sql_asig = $db->query("SELECT Count(tblx_evaluacion.IdEvaluacionX) AS Total, Avg(tblx_evaluacion.Promedio) AS Promedio FROM tblx_evaluacion WHERE tblx_evaluacion.IdAsignacion =  '$IdAsignacion' AND tblx_evaluacion.Tipo =  '2' AND tblx_evaluacion.IdEstatus =  '10' GROUP BY tblx_evaluacion.IdAsignacion ");
$db->rows($sql_asig); 
$_asig = $db->recorrer($sql_asig);

$insertar = $db->query("UPDATE tblp_asignacion SET tblp_asignacion.pro_alum = '".$_asig['Promedio']."', tblp_asignacion._alum = '".$_asig['Total']."' WHERE tblp_asignacion.IdAsignacion = '$IdAsignacion'");



$sql2 = $db->query("SELECT
tblx_respuesta.IdPregunta,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_estatus.Estatus,
tblx_evaluacion.FecIni,
tblx_evaluacion.FecFin,
tblx_evaluacion.Ini,
tblx_evaluacion.Fin
FROM
tblx_respuesta
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblx_respuesta.IdUsua
Left Join tblx_pregunta ON tblx_pregunta.IdPregunta = tblx_respuesta.IdPregunta
Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblx_respuesta.IdEstatus
Left Join tblx_evaluacion ON tblx_evaluacion.IdEvaluacionX = tblx_respuesta.IdEvaluacion
WHERE
tblx_respuesta.IdAsignacion =  '$IdAsignacion' AND
tblx_pregunta.Permisos =  '2'
GROUP BY
tblx_respuesta.IdUsua
ORDER BY
tblx_respuesta.IdEstatus ASC
");

?>

<form name="frm2xfYj" id="frm2xfYj" action="addNewPago.php" method="POST" enctype="multipart/form-data" class="form-horizontal">
<input type="hidden" name="docente2" id="docente2" value="DOCENTE:" >

 
  
  <table class="table table-striped" style="font-size: 12px;" >
    <tbody>
      <tr>
        <th style="width: 10px">#</th>
        <th>Nombre del alumno</th>
        <th style="text-align: center;">Hora de realización</th>
        <th style="text-align: center;">Estatus</th>
      </tr>
      <?php $h = 0;
      while ($y = $db->recorrer($sql2)) { ?>
        <tr>
          <td><b><?php echo $h = $h + 1; ?>.- </b></td>
          <td><?php echo $y["Nombre"].' '.$y["APaterno"].' '.$y["AMaterno"]; ?></td>
          <td style="text-align: center;"><?php if(isset($y["Ini"])) { echo $y["Ini"].' - '.substr($y["Fin"], 10,10); } else { echo "--";} ?></td>
          <td style="text-align: center;"><?php echo $y["Estatus"]; ?></td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
  
</form>
