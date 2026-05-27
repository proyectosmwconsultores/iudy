<?php
session_start();
require('../../php/clases/class.System.php');
$db = new Conexion();
$sql_lsta = $db->query("SELECT
  tblc_usuario.IdUsua,
  tblc_usuario.Nombre,
  tblc_usuario.APaterno,
  tblc_usuario.AMaterno,
  tblc_usuario.id_ciclo_ini,
  tblp_educativa.Nombre AS Educativa,
  tblc_ciclo.Ciclo,
  tblc_usuario.GPago,
  tblc_campus.Campus
  FROM
  tblc_usuario
  Left Join tblc_campus ON tblc_campus.IdCampus = tblc_usuario.IdCampus
  Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta
  Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblc_usuario.id_ciclo_ini
  WHERE
  tblc_usuario.IdEstatus =  '12'
  ORDER BY
  tblc_usuario.id_ciclo_ini ASC,
  tblc_usuario.IdCampus ASC,
  tblc_usuario.IdOferta ASC,
  tblc_usuario.APaterno ASC
   ");

?>

<div class="box-body">

  <table id="example" class="table table-striped" style="font-size: 12px;">
    <thead>

    </thead>
    <tbody>
      <?php $c = 0;
      $cI = 0;
      $cF = 0;
      while ($matx = $db->recorrer($sql_lsta)) {
        $cI = $matx["id_ciclo_ini"];
        if ($cI <> $cF) {
          $c = 0; ?>
          <tr style="background: #c8b9ff;">
            <td colspan="5"><b><?php echo $matx["Ciclo"]; ?></b></td>
          </tr>
          <tr>
            <th colspan="2">NOMBRE DEL ALUMNO</th>
            <th>PAGO</th>
            <th>CAMPUS</th>
            <th>PLAN DE ESTUDIOS</th>
          </tr>
        <?php }
        ?>
        <tr>
          <td><b><?php echo $c = ($c + 1); ?>.- </b></td>
          <td><?php echo $matx["APaterno"] . ' ' . $matx["AMaterno"] . ' ' . $matx["Nombre"]; ?></td>
          <td><?php echo $matx["GPago"]; ?></td>
          <td><?php echo $matx["Campus"]; ?></td>
          <td><?php echo $matx["Educativa"]; ?></td>
        </tr>
      <?php $cF = $matx["id_ciclo_ini"];
      } ?>
      </tfoot>
  </table>
</div>