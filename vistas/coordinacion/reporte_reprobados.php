<?php
session_start();
$IdUsua = $_SESSION['IdUsua'];
require('../../php/clases/class.System.php');
$db = new Conexion();
$IdCiclo = $_POST['IdCiclo'];

$sql_lst = $db->query("SELECT
tblp_calificacion.IdCalificacion,
tblp_calificacion.Promedio,
tblc_usuario.Usuario,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.IdOferta,
tblc_usuario.IdCampus,
tblc_campus.Campus,
tblp_educativa.Nombre AS Educativa,
tblp_modulo.CodeModulo,
tblp_modulo.NombreMod,
tblc_estatus.Estatus,
tblc_usuario.IdEstatus,
tblp_asignacion.IdGrupo,
tblc_ciclogrupo.Grado,
tblp_grupo.CveGrupo,
tblc_dias_clases._Dias
FROM
tblp_calificacion
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_calificacion.IdUsua
Left Join tblc_campus ON tblc_campus.IdCampus = tblc_usuario.IdCampus
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta
Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_calificacion.IdModulo
Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_usuario.IdEstatus
Left Join tblp_asignacion ON tblp_asignacion.IdAsignacion = tblp_calificacion.IdAsignacion
Left Join tblc_ciclogrupo ON tblc_ciclogrupo.IdCiclo = tblp_asignacion.IdCiclo AND tblc_ciclogrupo.IdGrupo = tblp_asignacion.IdGrupo
Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblp_asignacion.IdGrupo
Left Join tblc_dias_clases ON tblc_dias_clases.Dia = tblp_grupo.Dia
WHERE
tblp_calificacion.IdCiclo =  '$IdCiclo' AND
tblp_calificacion.Promedio <=  '5' AND
tblp_calificacion.IdEstatus =  '10' AND
tblc_usuario.IdEstatus = '8' AND
tblp_asignacion.Tipo =  '2'
ORDER BY tblc_usuario.IdCampus ASC, tblc_usuario.IdOferta ASC, tblc_ciclogrupo.Grado ASC");


$sql_total = $db->query("SELECT
Count(tblp_calificacion.IdCalificacion) AS Total,
tblp_calificacion.Promedio,
tblc_usuario.Usuario,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.IdOferta,
tblc_usuario.IdCampus,
tblc_campus.Campus,
tblp_educativa.Nombre AS Educativa,
tblc_estatus.Estatus,
tblc_usuario.IdEstatus
FROM
tblp_calificacion
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_calificacion.IdUsua
Left Join tblc_campus ON tblc_campus.IdCampus = tblc_usuario.IdCampus
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta
Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_usuario.IdEstatus
WHERE
tblp_calificacion.IdCiclo =  '$IdCiclo' AND
tblp_calificacion.Promedio <=  '5' AND
tblp_calificacion.IdEstatus =  '10' AND
tblc_usuario.IdEstatus = '8'
GROUP BY
tblp_calificacion.IdUsua
ORDER BY
tblc_usuario.IdCampus ASC,
tblc_usuario.IdOferta ASC
");


?>

<table class="table table-striped" style="font-size: 12px;">
  <tbody>

    <?php $ci = 0;
    $cf = 0;
    $oi = 0;
    $of = 0;
    $v = 0; $idEs = 8;
    while ($mat = $db->recorrer($sql_lst)) {
      $ci = $mat['IdCampus'];
      $oi = $mat['IdOferta'];
      $idEs = $mat['IdEstatus'];
      if($idEs == 8){
        $col = '';
      } else { $col = "style='color: red;'"; }
      if ($ci <> $cf) { ?>
        <tr style="background: #e3baff;">
          <th colspan="7"><b><i class="fa fa-fw fa-folder-open"></i> <?php echo $mat['Campus']; ?></b></th>
        </tr>
      <?php } if ($oi <> $of) { ?>
        <tr>
          <th></th>
          <th colspan="6"><b><i class="fa fa-fw fa-book"></i> <?php echo $mat['Educativa']; ?></b></th>
        </tr>
        <tr>
          <th></th>
          <th>MATRICULA</th>
          <th>NOMBRE DEL ALUMNO</th>
          <th>ESTATUS</th>
          <th>GRUPO</th>
          <th>MATERIA</th>
          <th style="text-align: center;">PROMEDIO</th>
        </tr>
      <?php }
      ?>
      <tr <?php echo $col; ?>>
        <td><b><?php echo $v = ($v + 1); ?>.- </b></td>
        <td><?php echo $mat['Usuario']; ?></td>
        <td><?php echo $mat['APaterno'] . ' ' . $mat['AMaterno'] . ' ' . $mat['Nombre'];  ?></td>
        <td><?php echo $mat['Estatus']; ?></td>
        <td><?php echo $mat['Grado'].'° '.$mat['CveGrupo'].' '.$mat['_Dias']; ?></td>
        <td><?php echo $mat['CodeModulo'] . ' - ' . $mat['NombreMod']; ?></td>
        <td style="text-align: center;"><?php echo $mat['Promedio']; ?></td>
      </tr><?php $cf = $mat['IdCampus']; $of = $mat['IdOferta']; } ?>
  </tbody>
</table>

<br>
<table class="table table-striped" style="font-size: 12px;">
  <tbody>
  <tr style="background: #1d3462;">
    <th colspan="5"><b style="color: white;"><i class="fa fa-fw fa-folder-open"></i> Materias reprobadas por alumno</b></th>
  </tr>
    <?php $ci = 0;
    $cf = 0;
    $oi = 0;
    $of = 0;
    $v = 0; $idEs = 8;
    while ($mat = $db->recorrer($sql_total)) {
      $ci = $mat['IdCampus'];
      $oi = $mat['IdOferta'];
      $idEs = $mat['IdEstatus'];
      if($idEs == 8){
        $col = '';
      } else { $col = "style='color: red;'"; }
      if ($ci <> $cf) { ?>
        <tr style="background: #e3baff;">
          <th colspan="5"><b><i class="fa fa-fw fa-folder-open"></i> <?php echo $mat['Campus']; ?></b></th>
        </tr>
      <?php } if ($oi <> $of) { ?>
        <tr>
          <th></th>
          <th colspan="4"><b><i class="fa fa-fw fa-book"></i> <?php echo $mat['Educativa']; ?></b></th>
        </tr>
        <tr>
          <th></th>
          <th>MATRICULA</th>
          <th>NOMBRE DEL ALUMNO</th>
          <th>ESTATUS</th>
          <th style="text-align: center;">MAT. REPROBADAS</th>
        </tr>
      <?php }
      ?>
      <tr <?php echo $col; ?>>
        <td><b><?php echo $v = ($v + 1); ?>.- </b></td>
        <td><?php echo $mat['Usuario']; ?></td>
        <td><?php echo $mat['APaterno'] . ' ' . $mat['AMaterno'] . ' ' . $mat['Nombre'];  ?></td>
        <td><?php echo $mat['Estatus']; ?></td>
        <td style="text-align: center;"><?php echo $mat['Total']; ?></td>
      </tr><?php $cf = $mat['IdCampus']; $of = $mat['IdOferta']; } ?>
  </tbody>
</table>