<?php session_start();
include('../../hace.php');
$IdUsua = $_SESSION["IdUsua"];
$output = '';
require('../../php/clases/class.System.php');
$db = new Conexion();
$IdCiclo = $_POST["IdCiclo"];
echo $IdGrupo = $_POST["IdGrupo"];
$Tipo = $_POST["Tipo"];
// $Grado = $_POST["Grado"];

$sql_user = $db->query("UPDATE tblc_alumnos SET tblc_alumnos.Valor = 1 WHERE tblc_alumnos.Valor IS NULL");

$sql_prom = $db->query("SELECT tblc_alumnos.IdActivo, tblc_alumnos.IdGrupo, tblc_alumnos.IdCiclo, tblc_alumnos.IdUsua, tblc_alumnos.Grado, tblc_alumnos.Tipo, tblc_usuario.IdEstatus FROM tblc_alumnos Left Join tblc_usuario ON tblc_usuario.IdUsua = tblc_alumnos.IdUsua WHERE tblc_alumnos.IdCiclo =  '$IdCiclo' AND tblc_alumnos.IdGrupo =  '$IdGrupo' AND tblc_alumnos.IdEstatus =  '8' ");
while ($x = $db->recorrer($sql_prom)) {
  $sql9 = $db->query("SELECT Avg(tblp_calificacion.Promedio) AS Promedio FROM tblp_calificacion WHERE tblp_calificacion.IdUsua =  '" . $x['IdUsua'] . "' AND tblp_calificacion.IdCiclo =  '$IdCiclo' AND tblp_calificacion.IdGrupo =  '$IdGrupo' AND tblp_calificacion.IdEstatus =  '10' ");
  $db->rows($sql9);
  $prom = $db->recorrer($sql9);
  $grado = $x['Grado'];
  if (isset($prom[0])) {
    $insertar = $db->query("UPDATE tblc_alumnos SET tblc_alumnos.Promedio = '" . $prom['Promedio'] . "' WHERE tblc_alumnos.IdActivo = '" . $x['IdActivo'] . "' ");
  }
  $insertar = $db->query("UPDATE tblc_alumnos SET tblc_alumnos.IdEstatus = '" . $x['IdEstatus'] . "' WHERE tblc_alumnos.IdActivo = '" . $x['IdActivo'] . "' ");
}

if($Tipo == 1){
  $sql_prom_activo = $db->query("SELECT tblc_alumnos.IdActivo, tblc_alumnos.Promedio FROM tblc_alumnos WHERE tblc_alumnos.IdCiclo =  '$IdCiclo' AND tblc_alumnos.IdGrupo =  '$IdGrupo' AND tblc_alumnos.IdEstatus =  '8' ");
  while ($_act = $db->recorrer($sql_prom_activo)) {
    $prom = $_act['Promedio'];
    if($prom <= 5){
      $insertar = $db->query("UPDATE tblc_alumnos SET tblc_alumnos.Valor = '2' WHERE tblc_alumnos.IdActivo = '" . $_act['IdActivo'] . "' ");
    }
    
  }

}


$sql_user = $db->query("SELECT
tblc_alumnos.IdActivo,
tblc_alumnos.IdUsua,
tblc_alumnos.Valor,
tblc_alumnos.Promedio,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.Usuario
FROM
tblc_alumnos
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblc_alumnos.IdUsua
WHERE
tblc_alumnos.IdCiclo =  '$IdCiclo' AND
tblc_alumnos.IdGrupo =  '$IdGrupo' AND
tblc_alumnos.IdEstatus =  '8'
ORDER BY
tblc_usuario.APaterno ASC,
tblc_usuario.AMaterno ASC,
tblc_usuario.Nombre ASC
");

$sql_mig = $db->query("SELECT * FROM tblc_ciclogrupo WHERE tblc_ciclogrupo.IdGrupo = '$IdGrupo' AND tblc_ciclogrupo.IdCiclo =  '$IdCiclo'");
$db->rows($sql_mig);
$_migr = $db->recorrer($sql_mig);

?>
<form name="frm22" id="frm22" action="updGrupo.php" method="POST" enctype="multipart/form-data" class="form-horizontal">
  <table class="table table-striped" style="font-size: 12px;">
    <tbody>
      <tr>
        <th></th>
        <th>MATRICULA</th>
        <th>ALUMNO</th>
        <th style="text-align: center;">PROMEDIO</th>
        <th style="text-align: center;">MIGRACION</th>
      </tr>
      <?php $v = 0; $color = "color: black;"; $sx = 0;
      while ($x = $db->recorrer($sql_user)) {
        if($x['Promedio'] < 6){
          $color = "color: red;";
        } else {
          $color = "color: black;";
        }
      ?>
        <tr>
          <td style="width: 10px;"><b><?php echo $v = ($v + 1); ?>.- </b></td>
          <td><?php echo $x['Usuario']; ?></td>
          <td><?php echo $x['APaterno'] . ' ' . $x['AMaterno'] . ' ' . $x['Nombre']; ?></td>
          <td style="text-align: center; <?php echo $color; ?>"><?php echo $x['Promedio']; ?></td>
          <td style="text-align: center;">
            <?php if ($x['Valor'] == 1) { $sx  = $sx + 1;?>
              <button onclick="sel_alumno_id(<?php echo $x['IdActivo']; ?>,<?php echo $IdGrupo; ?>,2)" type="button" title="Disponible para migrar" class="btn bg-purple btn-flat btn-xs"><i class="fa fa-fw fa-check-circle"></i></button>
            <?php } ?>
            <?php if ($x['Valor'] == 2) { ?>
              <button onclick="sel_alumno_id(<?php echo $x['IdActivo']; ?>,<?php echo $IdGrupo; ?>,1)" type="button" title="No migrar" class="btn bg-orange btn-flat btn-xs"><i class="fa fa-fw fa-times-circle"></i></button>
            <?php } ?>
            <?php if ($x['Valor'] == 3) { ?>
              <button type="button" title="Alumno migrado correctamente" class="btn bg-navy btn-flat btn-xs"><i class="fa fa-fw fa-check-circle"></i></button>
            <?php } ?>
            <?php if ($x['Valor'] == 4) { ?>
              <button onclick="migrar_alumno_id(<?php echo $x['IdUsua']; ?>,<?php echo $IdGrupo; ?>)" type="button" title="Disponible para migrar" class="btn bg-maroon btn-flat btn-xs"><i class="fa fa-fw fa-warning"></i></button>
              <button onclick="enlazar_grpx_especial_id(<?php echo $x['IdUsua']; ?>,<?php echo $IdGrupo; ?>,<?php echo $grado; ?>)" type="button" title="Migrado especial" class="btn bg-info btn-flat btn-xs"><i class="fa fa-fw fa-eye"></i></button>
            <?php } ?>
          </td>
        </tr><?php } ?>
    </tbody>
  </table>
  <?php if($sx > 0){ if ($_migr['Migrado'] == 1) { ?>
    <div class="bg-purple-active color-palette" style="padding: 8px; text-align: center;"><span style="color: yellow;"><b><i class="fa fa-fw fa-check-square-o"></i> EL GRUPO HA SIDO MIGRADO CORRECTAMENTE</b></span></div>
  <?php } else { ?>
    <button onclick="enlazar_grpx(<?php echo $IdGrupo; ?>,<?php echo $grado; ?>)" type="button" class="btn btn-block btn-info btn-flat"><i class="fa fa-fw fa-send"></i> Procesar migración de grupo</button>
  <?php } } ?>
  </div>
</form>

<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script>
  $(function() {
    $('#txt_fecha_insc').datepicker({
      autoclose: true
    })
  })
</script>