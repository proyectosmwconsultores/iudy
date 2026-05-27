<?php session_start();
include('../../hace.php');
require('../../php/clases/class.System.php');
$anio = date("Y-m-d");
$db = new Conexion();
$IdUsua = $_POST['IdUsua'];
$IdActividadDoc = $_POST["IdActividadDoc"];
$IdRubrica = $_POST["IdRubrica"];

$act = $db->query("SELECT * FROM tblc_rubrica_detalle_cal WHERE tblc_rubrica_detalle_cal.IdActividadDocente = '$IdActividadDoc' AND tblc_rubrica_detalle_cal.IdUsua = '$IdUsua' AND tblc_rubrica_detalle_cal.IdRubrica = '$IdRubrica'");
$db->rows($act);
$x_act = $db->recorrer($act);
$_Detalle = $x_act['IdDetalle'];
if (!$_Detalle) {
  $sql_rubx = $db->query("SELECT * FROM tblc_rubrica_detalle WHERE tblc_rubrica_detalle.IdRubrica = '$IdRubrica'");
  while ($_det = $db->recorrer($sql_rubx)) {
    $db->query("INSERT INTO tblc_rubrica_detalle_cal (IdDetalle, IdRubrica, IdUsua, IdActividadDocente)  VALUES ('" . $_det['IdDetalle'] . "', '$IdRubrica', '$IdUsua', '$IdActividadDoc')");
  }
}

$sql_rub_det = $db->query("SELECT tblc_rubrica_detalle.IdDetalle, tblc_rubrica_detalle.IdRubrica, tblc_rubrica_detalle.Texto, tblc_rubrica_detalle.Cal1, tblc_rubrica_detalle.Cal2, tblc_rubrica_detalle.Cal3, tblc_rubrica_detalle.Cal4, tblc_rubrica_detalle.Cal5, tblc_rubrica.IdEstatus FROM tblc_rubrica_detalle Left Join tblc_rubrica ON tblc_rubrica.IdRubrica = tblc_rubrica_detalle.IdRubrica WHERE tblc_rubrica_detalle.IdRubrica = '$IdRubrica' ");


$activ = $db->query("SELECT tblp_actividadesdocente.IdAsignacion, tblp_actividadesdocente.Porcentaje FROM tblp_actividadesdocente WHERE tblp_actividadesdocente.IdActividadesDocente = '$IdActividadDoc'");
$db->rows($activ);
$x_activx = $db->recorrer($activ);


?>
<form method="POST" enctype="multipart/form-data" class="form-horizontal">
  <div class="box-body">
    <div id="div_lista">
      <table class="table table-striped" style="font-size: 12px;">
        <tbody>
          <tr>
            <th style="width: 10px"></th>
            <th>Criterios de evaluación</th>
            <th style="text-align: center;">Excelente</th>
            <th style="text-align: center;">Muy_bien</th>
            <th style="text-align: center;">Satisfactorio</th>
            <th style="text-align: center;">Requiere mejora</th>
            <th style="text-align: center;">Inadecuado</th>
          </tr>
          <?php $v = 0; $sum = 0;
          while ($_det = $db->recorrer($sql_rub_det)) {
            $calx = $db->query("SELECT * FROM tblc_rubrica_detalle_cal WHERE tblc_rubrica_detalle_cal.IdDetalle = '" . $_det['IdDetalle'] . "' AND  tblc_rubrica_detalle_cal.IdActividadDocente = '$IdActividadDoc' AND tblc_rubrica_detalle_cal.IdUsua = '$IdUsua' AND tblc_rubrica_detalle_cal.IdRubrica = '$IdRubrica'");
            $db->rows($calx);
            $x_act = $db->recorrer($calx);
            $_calk = $x_act['Cal'];
            $IdDesglose = $x_act['IdDesglose'];
            $sum = ($sum + $x_act['Cal']);
          ?>
            <tr>
              <td><b><?php echo $v = ($v + 1); ?>.- </b></td>
              <td><?php echo $_det['Texto']; ?></td>
              <td style="text-align: center;"><button onclick="sav_cal_rub(<?php echo $IdDesglose; ?>,<?php echo $IdUsua; ?>,<?php echo $IdActividadDoc; ?>,<?php echo $IdRubrica; ?>, <?php echo $_det['Cal1']; ?>)" style="width: 50px;" type="button" class="btn btn-<?php if ($_calk == $_det['Cal1']) { echo "warning"; } else { echo "info"; } ?>"><?php echo $_det['Cal1']; ?></button></td>
              <td style="text-align: center;"><button onclick="sav_cal_rub(<?php echo $IdDesglose; ?>,<?php echo $IdUsua; ?>,<?php echo $IdActividadDoc; ?>,<?php echo $IdRubrica; ?>, <?php echo $_det['Cal2']; ?>)" style="width: 50px;" type="button" class="btn btn-<?php if ($_calk == $_det['Cal2']) { echo "warning"; } else { echo "info"; } ?>"><?php echo $_det['Cal2']; ?></button></td>
              <td style="text-align: center;"><button onclick="sav_cal_rub(<?php echo $IdDesglose; ?>,<?php echo $IdUsua; ?>,<?php echo $IdActividadDoc; ?>,<?php echo $IdRubrica; ?>, <?php echo $_det['Cal3']; ?>)" style="width: 50px;" type="button" class="btn btn-<?php if ($_calk == $_det['Cal3']) { echo "warning"; } else { echo "info"; } ?>"><?php echo $_det['Cal3']; ?></button></td>
              <td style="text-align: center;"><button onclick="sav_cal_rub(<?php echo $IdDesglose; ?>,<?php echo $IdUsua; ?>,<?php echo $IdActividadDoc; ?>,<?php echo $IdRubrica; ?>, <?php echo $_det['Cal4']; ?>)" style="width: 50px;" type="button" class="btn btn-<?php if ($_calk == $_det['Cal4']) { echo "warning"; } else { echo "info"; } ?>"><?php echo $_det['Cal4']; ?></button></td>
              <td style="text-align: center;"><button onclick="sav_cal_rub(<?php echo $IdDesglose; ?>,<?php echo $IdUsua; ?>,<?php echo $IdActividadDoc; ?>,<?php echo $IdRubrica; ?>, <?php echo $_det['Cal5']; ?>)" style="width: 50px;" type="button" class="btn btn-<?php if ($_calk == $_det['Cal5']) { echo "warning"; } else { echo "info"; } ?>"><?php echo $_det['Cal5']; ?></button></td>
            </tr><?php } ?>
        </tbody>
      </table>
      <br>
      <?php 
      $total = (10 * $v);
      $puntos = ($x_activx['Porcentaje'] / $total);
      $sumP = ($puntos * $sum);

      $cal = (10 / $x_activx['Porcentaje']);
      $calProm = ($cal * $sumP);
      $calProm = number_format($calProm, 2, '.', ' ');
      if($sumP){
        $db->query("UPDATE tblp_tareas SET tblp_tareas.Calificacion = '$sumP', tblp_tareas.Porcentaje = '$sumP' WHERE  tblp_tareas.IdAsignacion = '".$x_activx['IdAsignacion']."' AND tblp_tareas.IdAlumno = '$IdUsua' AND tblp_tareas.IdActividadesDocente = '$IdActividadDoc' ");
      }
      ?>
      <table class="table table-striped">
        <tbody>
          <tr>
            <td style="text-align: right;"><b>Porcentaje de la actividad:</b></td>
            <td><?php echo $x_activx['Porcentaje']; ?>%</td>
          </tr>
          <tr>
            <td style="text-align: right;"><b>Porcentaje obtenido:</b></td>
            <td><?php echo $sumP; ?>%</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</form>