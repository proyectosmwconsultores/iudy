<?php
session_start();
$IdUsua = $_SESSION['IdUsua'];
require('../php/clases/class.System.php');
$db = new Conexion();
$IdCampus = $_POST['IdCampus'];
$IdCiclo = $_POST['IdCiclo'];


$sql_all = $db->query("SELECT
tblp_asignacion.IdAsignacion,
tblp_asignacion.IdEducativa,
tblp_asignacion.IdGrupo,
tblp_asignacion._grado,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblp_modulo.CodeModulo,
tblp_modulo.NombreMod,
tblp_educativa.Nombre AS Educativa,
tblp_asignacion.FecIni,
tblp_asignacion.FecFin,
tblp_asignacion.IdEstatus,
tblp_grupo.CveGrupo
FROM
tblp_asignacion
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_asignacion.IdUsua
Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_asignacion.IdEducativa
Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblp_asignacion.IdGrupo
WHERE
tblp_asignacion.IdCiclo =  '$IdCiclo' AND
tblp_asignacion.IdCampus =  '$IdCampus' AND
tblp_asignacion._estatus =  'V' AND
tblp_asignacion.Tipo =  '2'
ORDER BY
tblp_educativa.IdGrado ASC,
tblp_asignacion.IdEducativa ASC,
tblp_asignacion._grado ASC,
tblp_grupo.CveGrupo ASC
");

?>
<div class="box-header">
  <button onclick="generar_invitacion(<?php echo $IdCampus; ?>,<?php echo $IdCiclo; ?>,'0_0')" type="button" class="btn btn-block btn-info btn-sm"><i class="fa fa-fw fa-send"></i> Generar invitación</button>
</div>
<table class="table">
  <tbody>
    <?php $ei = 0; $ef = 0; $gi = 0; $gf = 0;
    while ($all = $db->recorrer($sql_all)) { $ei = $all['IdEducativa']; $gi = $all['IdGrupo'];
      if ($ei <> $ef) { ?>
        <tr style="background: yellow;">
          <th colspan="6"><?php echo $all['Educativa']; ?></th>
        </tr>
      <?php } 
      if ($gi <> $gf) { ?>
        <tr style="background: #cec9f4;">
          <th  style="width: 10px;"></th>
          <th colspan="5"><?php echo $all['_grado']; ?>° <?php echo $all['CveGrupo']; ?></th>
        </tr>
      <?php } ?>
      <tr>
        <td colspan="2"><?php echo $all['Nombre']; ?> <?php echo $all['APaterno']; ?> <?php echo $all['AMaterno']; ?> </td>
        <td><?php echo $all['NombreMod']; ?></td>
        <td><?php echo $all['FecIni']; ?></td>
        <td><?php echo $all['FecFin']; ?></td>
        <td><?php if ($all['IdEstatus'] == 1) { echo "PENDIENTE"; } else { echo "ACEPTADO"; } ?></td>
      </tr>
    <?php $ef = $all['IdEducativa']; $gf = $all['IdGrupo']; } ?>
  </tbody>
</table>