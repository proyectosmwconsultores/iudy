<?php
session_start();
$IdUsua = $_SESSION['IdUsua'];
require('../../php/clases/class.System.php');
require('../../hace.php');
$db = new Conexion();


// $sql_us = $db->query("SELECT * FROM tblh_conciliar_pagos WHERE tblh_conciliar_pagos.idestatus = '8'");
// while ($_us = $db->recorrer($sql_us)) {
//   $sql_ux = $db->query("SELECT tblc_usuario.IdUsua FROM tblc_usuario WHERE tblc_usuario._alfanumerica = '" . $_us['alfanumerica'] . "'");
//   $db->rows($sql_ux);
//   $_userx = $db->recorrer($sql_ux);
//   $_IdUsua = $_userx["IdUsua"];
//   if ($_IdUsua) {
//     $insertar = $db->query("UPDATE tblh_temporal_conciliar SET tblh_temporal_conciliar._IdUsua = '$_IdUsua', tblh_temporal_conciliar._idestatus = '10' WHERE tblh_temporal_conciliar.IdTemporal = '" . $_us['IdTemporal'] . "' ");
//   }
// }


$sql_pend = $db->query("SELECT
tblh_conciliar_pagos.IdTemporal,
tblh_conciliar_pagos.Matricula,
tblh_conciliar_pagos.Descripcion,
tblh_conciliar_pagos.Importe,
tblh_conciliar_pagos.IdUsua,
tblh_conciliar_pagos._idestatus,
tblh_conciliar_pagos._idUsua,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_campus.Campus
FROM
tblh_conciliar_pagos
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblh_conciliar_pagos._idUsua
Left Join tblc_campus ON tblc_campus.IdCampus = tblc_usuario.IdCampus
WHERE tblh_conciliar_pagos._idestatus <> '10'
ORDER BY
tblh_conciliar_pagos._idestatus DESC,
tblc_usuario.IdCampus ASC
 ");


?>


<!-- Paso de conciliar para alumnos sin reconocer automaticamente -->
<div class="box-header">
  <h3 class="box-title"><i class="fa fa-fw fa-bookmark"></i> Pagos de alumnos para realizar el proceso de conciliar de manera personalizada.</h3>
</div>
<div class="box-body">
  <table class="table table-bordered table-striped" style="font-size: 12px;">
    <thead>
      <tr>
        <th>#</th>
        <th>MATRICULA</th>
        <th>DESCRIPCIÓN</th>
        <th>ALUMNO</th>
        <th>CAMPUS</th>
        <th>IMPORTE</th>
      </tr>
    </thead>
    <tbody>
      <?php $sum_pend = 0;
      $i3 = 0;
      while ($_pendix = $db->recorrer($sql_pend)) {  ?>
        <tr>
          <td><?php echo $i3 = $i3 + 1; ?>.- </td>
          <td><?php echo $_pendix["Matricula"]; ?></td>
          <td><?php echo $_pendix["Descripcion"]; ?></td>
          <td><?php echo $_pendix["Nombre"].' '.$_pendix["APaterno"].' '.$_pendix["AMaterno"]; ?></td>
          <td><?php echo $_pendix["Campus"]; ?></td>
          <td style="cursor: pointer; color: blue;" onclick="proceso_cobrar_pag(<?php echo $_pendix["IdTemporal"]; ?>,<?php echo $_pendix["_idUsua"]; ?>)">$ <?php echo number_format($_pendix["Importe"], 2, '.', ','); ?> </td>
        </tr>
      <?php $sum_pend = ($sum_pend + $_pendix["Importe"]);
      } ?>
      <tr>
        <td colspan="5" style="text-align: right;"><b>TOTAL:</b></td>
        <td style="background: yellow;"><b>$ <?php echo number_format($sum_pend, 2, '.', ','); ?></b> </td>
      </tr>
      </tfoot>
  </table>
</div>
