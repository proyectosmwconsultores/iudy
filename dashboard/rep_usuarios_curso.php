<?php
  session_start();
  $IdUsua = $_SESSION['IdUsua'];
  require('../php/clases/class.System.php');
  require('../hace.php');
  $db = new Conexion();

    $IdGrupo = $_POST['IdGrupo'];

    $IdPlan = $_POST['IdPlan'];

  $sql_lts_us = $db->query("SELECT
tblp_pagos.IdPago,
tblp_pagos.IdUsua,
tblp_pagos.Monto,
tblp_pagos.FecDesc,
tblp_pagos.Descuento,
tblp_pagos.IdEstatus,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_permiso._Permiso,
tblc_usuario.Tipo,
tblc_estatus.Estatus
FROM
tblp_pagos
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_pagos.IdUsua
Left Join tblc_permiso ON tblc_permiso.IdPermiso = tblc_usuario.Permisos
Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblp_pagos.IdEstatus
WHERE
tblp_pagos.IdGrupo =  '$IdGrupo' AND
tblp_pagos.IdCalendario =  '$IdPlan'
ORDER BY tblc_usuario.APaterno ASC

");

  ?>

  <table class="table table-striped" style="font-size: 12px;">
    <thead>
      <tr>
        <th>#</th>
        <th></th>
        <th>Nombre</th>
        <th>Tipo usuario</th>
        <th>Estatus</th>
        <th style="text-align: right;">Monto</th>
        <th style="text-align: right;">Descuento</th>
        <th style="text-align: right;">Total</th>
      </tr>
    </thead>
    <tbody>
      <?php $pagar = 0; $j=0; while($_us = $db->recorrer($sql_lts_us)){
        $pagar = ($_us['Monto'] - $_us['Descuento']); ?>
      <tr>
        <td><b><?php echo $j = ($j + 1); ?>.- </b></td>
        <td><?php if($_us['IdEstatus'] == 1) { ?><button onclick="del_pago_curx(<?php echo $_us['IdPago']; ?>)" type="button" title=" Eliminar pago del curso"class="btn bg-maroon btn-flat btn-xs"><i class="fa fa-trash"></i></button><?php } ?></td>
        <td><?php echo $_us['APaterno'].' '.$_us['AMaterno'].' '.$_us['Nombre']; ?></td>
        <td><?php echo $_us['_Permiso']; ?> <?php if($_us['Tipo']){ echo ' / '.$_us['Tipo']; } ?></td>
        <td><?php echo $_us['Estatus']; ?></td>
        <td style="text-align: right;">$ <?php echo number_format($_us['Monto'], 2, '.', ','); ?></td>
        <td style="text-align: right;">$ <?php echo number_format($_us['Descuento'], 2, '.', ','); ?></td>
        <td style="text-align: right;">$ <?php echo number_format($pagar, 2, '.', ','); ?></td>
      </tr>
      <?php } ?>
    </tfoot>
  </table>
