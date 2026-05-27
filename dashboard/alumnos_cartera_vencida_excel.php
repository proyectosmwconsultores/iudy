<?php
session_start();
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=cartera_vencida.xls");
header("Pragma: no-cache");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Expires: 0");


$IdUsua = $_SESSION['IdUsua'];
require('../php/clases/class.System.php');
$db = new Conexion();
$IdCampus = $_GET['IdCampus'];
$hoy = date("Y-m-d");
$baj_plan2 = $db->query("SELECT
Count(tblp_pagos.IdPago) AS Total,
tblp_pagos.IdUsua,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.Usuario,
tblp_educativa.Nombre AS Educativa,
tblc_estatus.Estatus
FROM
tblp_pagos
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_pagos.IdUsua
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta
Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_usuario.IdEstatus
WHERE
tblp_pagos.IdCampus =  '$IdCampus' AND
tblp_pagos.IdEstatus =  '1' AND tblp_pagos.Fecha < '$hoy'
GROUP BY
tblp_pagos.IdUsua ORDER BY Total ASC ");
?>
<meta charset="utf-8">
<table class="table table-striped" style="font-size: 12px;">
        <tbody>
        <tr>
            <th colspan="6"  style="text-align: center;">REPORTE CON CORTE DE <?php echo date("Y-m-d");?></th>
          </tr>

          <tr>
            <th></th>
            <th>USUARIO</th>
            <th>NOMBRE</th>
            <th>PLAN DE ESTUDIOS</th>
            <th>ESTATUS</th>
            <th  style="text-align: center;">PAGOS PENDIENTES</th>
          </tr>
          <?php $c = 0; while ($_baj2 = $db->recorrer($baj_plan2)) { if($_baj2['Total'] > 2){ $c = ($c + 1); ?>
            <tr>
              <td><b><?php echo $c; ?>.- </b></td>
              <td><?php echo $_baj2['Usuario']; ?></td>
              <td><?php echo $_baj2['APaterno']; ?> <?php echo $_baj2['AMaterno']; ?> <?php echo $_baj2['Nombre']; ?></td>
              <td><?php echo $_baj2['Educativa']; ?></td>
              <td><?php echo $_baj2['Estatus']; ?></td>
              <td style="text-align: center;"><?php echo $_baj2['Total']; ?></td>
            </tr><?php }  } ?>
        </tbody>
      </table>
