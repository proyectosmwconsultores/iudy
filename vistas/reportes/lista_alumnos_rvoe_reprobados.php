<?php
session_start();
require('../../php/clases/class.System.php');
$db = new Conexion();
$IdCampus = $_POST['IdCampus'];
$IdCiclo = $_POST['IdCiclo'];
$IdRvoe = $_POST['IdRvoe'];


$sql_lsta = $db->query("SELECT
tblc_alumnos.IdActivo,
tblc_usuario.IdEstatus,
tblc_usuario.Usuario,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_rvoe.Educativa,
tblc_rvoe.Rvoe,
tblc_campus.Campus,
tblc_rvoe.IdRvoe,
tblc_usuario._idRvoe,
tblp_calificacion.Promedio,
tblp_modulo.NombreMod,
tblc_estatus.Estatus
FROM tblc_alumnos Left Join tblc_usuario ON tblc_usuario.IdUsua = tblc_alumnos.IdUsua Left Join tblc_rvoe ON tblc_rvoe.IdRvoe = tblc_usuario._idRvoe Left Join tblc_campus ON tblc_campus.IdCampus = tblc_rvoe.IdCampus Left Join tblp_calificacion ON tblp_calificacion.IdUsua = tblc_alumnos.IdUsua AND tblp_calificacion.IdCiclo = tblc_alumnos.IdCiclo Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_calificacion.IdModulo Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_usuario.IdEstatus
WHERE
tblc_alumnos.IdCiclo =  '$IdCiclo' AND
tblc_usuario.IdCampus =  '$IdCampus' AND
tblp_calificacion.IdEstatus =  '10' AND
tblp_calificacion.Promedio <=  '5' AND
tblc_usuario._idRvoe =  '$IdRvoe'");


$sql_estatus = $db->query("SELECT
tblc_alumnos.IdActivo,
tblc_usuario.IdEstatus,
tblc_rvoe.Educativa,
tblc_rvoe.Rvoe,
tblc_rvoe.IdRvoe,
tblc_usuario._idRvoe,
tblp_calificacion.Promedio,
tblc_estatus.Estatus,
Count(tblc_usuario.IdUsua) AS Total
FROM
tblc_alumnos
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblc_alumnos.IdUsua
Left Join tblc_rvoe ON tblc_rvoe.IdRvoe = tblc_usuario._idRvoe
Left Join tblp_calificacion ON tblp_calificacion.IdUsua = tblc_alumnos.IdUsua AND tblp_calificacion.IdCiclo = tblc_alumnos.IdCiclo
Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_usuario.IdEstatus
WHERE tblc_alumnos.IdCiclo = '$IdCiclo' AND tblc_usuario.IdCampus = '$IdCampus' AND tblp_calificacion.IdEstatus = '10' AND tblp_calificacion.Promedio <= '5' AND tblc_usuario._idRvoe = '$IdRvoe'
GROUP BY
tblc_usuario.IdEstatus
");

?>

<div class="box-body">

  <table  class="table table-striped" style="font-size: 12px;">
    <thead>

    </thead>
    <tbody>
      <?php $c = 0;
      $cI = 0;
      $cF = 0;
      while ($matx = $db->recorrer($sql_lsta)) {
        $cI = $matx["IdRvoe"];
        if ($cI <> $cF) {
          $c = 0; ?>
          <tr style="background: #c8b9ff;">
            <td colspan="5"><b><?php echo $matx["Rvoe"]; ?> <?php echo $matx["Educativa"]; ?> - <?php echo $matx["Campus"]; ?></b></td>
          </tr>
          <tr>
            <th></th>
            <th>USUARIO</th>
            <th>NOMBRE DEL ALUMNO</th>
            <th>MATERIA</th>
            <th>ESTATUS</th>
          </tr>
        <?php }
        ?>
        <tr>
          <td><b><?php echo $c = ($c + 1); ?>.- </b></td>
          <td><?php echo $matx["Usuario"]; ?></td>
          <td><?php echo $matx["APaterno"] . ' ' . $matx["AMaterno"] . ' ' . $matx["Nombre"]; ?></td>
          <td><?php echo $matx["NombreMod"]; ?></td>
          <td><?php echo $matx["Estatus"]; ?></td>
        </tr>
      <?php $cF = $matx["IdRvoe"];
      } ?>
      </tfoot>
  </table>
  <br><br>
  <table  class="table table-striped" style="font-size: 12px;">
    <thead>
      <tr>
        <th></th>
        <th>ESTATUS</th>
        <th>TOTAL</th>
      </tr>
    </thead>
    <tbody>
      <?php $c = 0;
      while ($matx = $db->recorrer($sql_estatus)) {
      ?>
        <tr>
          <td><b><?php echo $c = ($c + 1); ?>.- </b></td>
          <td><?php echo $matx["Estatus"]; ?></td>
          <td><?php echo $matx["Total"]; ?></td>
        </tr>
      <?php } ?>
      </tfoot>
  </table>
</div>