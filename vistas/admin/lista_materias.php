<?php
require('../../php/clases/class.System.php');
$db = new Conexion();
$IdOferta  = $_POST['IdOferta'];

$sql_mat = $db->query("SELECT
tblp_modulo.IdModulo,
tblp_modulo.CodeModulo,
tblp_modulo.Grado,
tblp_modulo.NombreMod,
tblp_modulo.Creditos,
tblp_modulo.HraDoc,
tblp_modulo.HraInd,
tblc_campus.Campus,
tblp_modulo.IdCampus
FROM
tblp_modulo
Left Join tblc_campus ON tblc_campus.IdCampus = tblp_modulo.IdCampus
WHERE
tblp_modulo.IdEducativa =  '$IdOferta'
ORDER BY
tblp_modulo.IdCampus ASC,
tblp_modulo.Grado ASC,
tblp_modulo.CodeModulo ASC
");
  ?>

  <table class="table table-striped" style="font-size: 12px;">
  <tbody>

  <?php $v= 0; $ci = 0; $cf = 0; while($x = $db->recorrer($sql_mat)){ $ci = $x['IdCampus'];
      if($ci <> $cf){ ?>
        <tr>
          <td colspan="4" style="background: #dad3ff;"><b><i class="fa fa-fw fa-angle-double-right"></i> <?php echo $x['Campus']; ?></b></td>
        </tr>
        <tr>
          <th style="width: 10px">#</th>
          <th>CLAVE</th>
          <th>GRADO</th>
          <th>NOMBRE</th>
        </tr>
      <?php } ?>
      <tr>
        <td><b><?php echo $v= ($v + 1); ?>.- </b></td>
        <td><?php echo $x['CodeModulo']; ?></td>
        <td><?php echo $x['Grado']; ?>° </td>
        <td><?php echo $x['NombreMod']; ?></td>
      </tr><?php $cf = $x['IdCampus'];  } ?>
  </tbody></table>
