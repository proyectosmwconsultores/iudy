<?php
$IdUsua = $_POST['IdUsua'];
require('../../php/clases/consultas_formatos.php');
require('../../hace.php');
$formatos = new Class_formatos();
$pagApro = $formatos->get_pagAprobados($IdUsua);

?>

<table class="table table-striped">
  <tbody>
    <tr style="background: #c1c5ffc4;">
      <th colspan="7"><i class="fa fa-fw fa-diamond"></i> Lista de pagos aprobados del alumno </th>
    </tr>
    <tr>
      <th class="text-blue">Ajuste</th>
      <th class="text-blue">Folio</th>
      <th class="text-blue">Estatus</th>
      <th class="text-blue">Fecha pago</th>
      <th class="text-blue">Fec. Captura</th>
      <th class="text-blue">Forma pago</th>
      <th class="text-blue" style="text-align: right;">Monto</th>
    </tr>
    <?php for ($a = 0; $a < sizeof($pagApro); $a++) { ?>
      <tr <?php if ($pagApro[$a]["IdEstatus"] == 11) { ?> style="text-decoration: line-through; color: red;" <?php } ?>>
        <td>
          <button type="button" class="btn btn-block btn-primary btn-xs" onclick="javascript:window.open('repositorio/pdf/comprobante.php?idToks=<?php echo time() . $pagApro[$a]["NoFolio"]; ?>');" href="javascript:void(0);" title="Descargar boucher de pago"><i class="fa fa-fw fa-print"></i></button>
        </td>
        <td><?php echo $pagApro[$a]["NoFolio"]; ?></td>
        <td><?php echo $pagApro[$a]["Estatus"]; ?></td>
        <td><?php echo $pagApro[$a]["FecPago"]; ?></td>
        <td><?php echo $pagApro[$a]["FecCap"]; ?></td>
        <td><?php echo $pagApro[$a]["Descripcion"]; ?></td>
        <td style="text-align: right;">$ <?php echo number_format($pagApro[$a]["Monto"], 2, '.', ','); ?></td>
      </tr>
    <?php } ?>
  </tbody>
</table>