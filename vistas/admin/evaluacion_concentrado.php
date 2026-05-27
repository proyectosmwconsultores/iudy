<?php
session_start();
require('../../php/clases/class.System.php');
$db = new Conexion();

$IdAsignacion = $_POST["IdAsignacion"];
$sql_asig = $db->query("SELECT Count(tblx_evaluacion.IdEvaluacionX) AS Total, Avg(tblx_evaluacion.Promedio) AS Promedio FROM tblx_evaluacion WHERE tblx_evaluacion.IdAsignacion =  '$IdAsignacion' AND tblx_evaluacion.IdEstatus =  '10' GROUP BY tblx_evaluacion.IdAsignacion ");
$db->rows($sql_asig);
$_asig = $db->recorrer($sql_asig);


$sql_doc = $db->query("SELECT tblp_asignacion.IdAsignacion,  tblp_asignacion.pro_coo, tblp_asignacion.pro_alum, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Foto, tblp_modulo.CodeModulo, tblp_modulo.NombreMod FROM tblp_asignacion Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_asignacion.IdUsua Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo WHERE tblp_asignacion.IdAsignacion =  '$IdAsignacion' AND tblp_asignacion.Tipo =  '2'");
$db->rows($sql_doc);
$_doc = $db->recorrer($sql_doc);




$sql2 = $db->query("SELECT
tblx_respuesta.IdPregunta,
Avg(tblx_respuesta.Respuesta) AS Promedio,
tblx_pregunta.Pregunta,
tblx_modulo.Nombre_mod,
tblx_pregunta.IdMod
FROM
tblx_respuesta
Left Join tblx_pregunta ON tblx_pregunta.IdPregunta = tblx_respuesta.IdPregunta
Left Join tblx_modulo ON tblx_modulo.IdMod = tblx_pregunta.IdMod
WHERE tblx_respuesta.IdAsignacion = '$IdAsignacion' AND tblx_respuesta.IdEstatus = '26' GROUP BY
tblx_modulo.IdMod
");

$sql3 = $db->query("SELECT
tblx_respuesta.IdPregunta,
Avg(tblx_respuesta.Respuesta) AS Promedio,
tblx_pregunta.Pregunta,
tblx_modulo.Nombre_mod,
tblx_pregunta.IdMod
FROM
tblx_respuesta
Left Join tblx_pregunta ON tblx_pregunta.IdPregunta = tblx_respuesta.IdPregunta
Left Join tblx_modulo ON tblx_modulo.IdMod = tblx_pregunta.IdMod
WHERE tblx_respuesta.IdAsignacion = '$IdAsignacion' AND tblx_respuesta.IdEstatus = '26' GROUP BY
tblx_modulo.IdMod
");

?>

<div class="row">
  <div class="col-md-12">
    <div class="box box-primary">


      <table class="table table-striped" style="font-size: 12px;">
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
              <td><?php echo $y["Nombre_mod"]; ?></td>
              <td style="text-align: center;"><b><?php echo round($y["Promedio"], 2); ?></b></td>
            </tr>
          <?php } ?>
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
              <td><?php echo $y["Nombre_mod"]; ?></td>
              <td style="text-align: center;"><?php echo round($y["Promedio"], 2); ?></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>

      </form>
      <div class="box box-widget widget-user">

        <div class="widget-user-header bg-aqua-active">
          <h3 class="widget-user-username"><?php echo $_doc['Nombre'] . ' ' . $_doc['APaterno'] . ' ' . $_doc['AMaterno']; ?></h3>
          <h5 class="widget-user-desc"><?php echo $_doc['CodeModulo'] . ' ' . $_doc['NombreMod']; ?></h5>
        </div><BR>
        <div class="widget-user-image">
          <img style="width: 80px; height: 80px;" src="assets/perfil/<?php echo $_doc['Foto']; ?>" class="img-circle" alt="User Image">
        </div>
        <div class="box-footer">
          <div class="row">
            <div class="col-sm-4 border-right">
              <div class="description-block">
                <span class="description-text">Opinión estudiantil</span><br>
                <span class="description-text"><b><?php echo $_doc['pro_alum']; ?></b></span><br><br>
                <h5 class="description-header">
                    <?php echo $promA = ($_doc['pro_alum'] * 6); ?>%
                    <br>
                    
                    </h5>
                    <br>
                    <span class="description-text">[<?php echo $promA; ?>% de 60%]</span><br>

              </div>

            </div>

            <div class="col-sm-4 border-right">
              <div class="description-block">
                <span class="description-text">Por cumplimiento académico/administrativo</span><br>
                <span class="description-text"><b><?php echo $_doc['pro_coo']; ?></b></span><br><br>
                <h5 class="description-header"><?php echo $promC = ($_doc['pro_coo'] * 4); ?>%</h5>
                <br>
                <span class="description-text">[<?php echo $promC; ?>% de 40%]</span><br>
              </div>

            </div>

            <div class="col-sm-4">
              <div class="description-block">
                <span class="description-text">PROMEDIO<br>OBTENIDO</span><br><br><br>
                <h5 class="description-header" style="font-size: 25px;"><?php echo $promT = ($promA + $promC); ?>%</h5>

              </div>

            </div>

          </div>

        </div>
      </div>
    </div>
  </div>
</div>

<?php
$sql_asig = $db->query("UPDATE tblp_asignacion SET tblp_asignacion._promedio = '$promT' WHERE tblp_asignacion.IdAsignacion = '$IdAsignacion'");
?>
