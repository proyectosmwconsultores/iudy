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


      </form>
      <div class="box box-widget widget-user">

        <div class="widget-user-header bg-aqua-active">
          <h3 class="widget-user-username"><?php echo $_doc['Nombre'] . ' ' . $_doc['APaterno'] . ' ' . $_doc['AMaterno']; ?></h3>
          <h5 class="widget-user-desc"><?php echo $_doc['CodeModulo'] . ' ' . $_doc['NombreMod']; ?></h5>
        </div><BR>
        <div class="widget-user-image">
          <img style="width: 80px; height: 80px;" src="assets/perfil/<?php echo $_doc['Foto']; ?>" class="img-circle" alt="User Image">
        </div>
        <?php 
         $_doc['pro_alum']; 
         $promA = ($_doc['pro_alum'] * 6);

         $_doc['pro_coo'];
        $promC = ($_doc['pro_coo'] * 4);
        
        ?>
        <div class="box-footer">
          <div class="row">
           

            <div class="col-sm-12">
              <div class="description-block">
                <span class="description-text">PROMEDIO OBTENIDO EN LA MATERIA</span><br><br><br>
                <h5 class="description-header" style="font-size: 55px;"><?php echo $promT = ($promA + $promC); ?>%</h5>

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
