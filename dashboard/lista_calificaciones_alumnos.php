<?php
session_start();
require('../php/clases/consulta_class.php');
$t = new Consultas();
$IdUsua = $_POST['IdUsua'];
$IdAdmin = $_SESSION['IdUsua'];

$user = $t->get_calificacion_user_id($IdUsua);

?>
<div class="box-body">
  <div class="table-responsive">
    <table class="table table-striped table-bordered table-hover dataTables-example" style="font-size: 12px;">
      <tbody>
        <?php $ci = 0;
        $cf = 0;
        for ($i = 0; $i < sizeof($user); $i++) {
          $ci = $user[$i]['IdPeriodo'];
          if ($ci <> $cf) { ?>
            <tr>
              <th colspan="4" style="background: #d8bcff;"><?php echo $user[$i]['Ciclo']; ?></th>
            </tr>
          <?php } ?>
          <tr>
            <td><?php echo $user[$i]['CodeModulo']; ?></td>
            <td><?php echo $user[$i]['NombreMod']; ?></td>
            <td><?php echo $user[$i]['Promedio']; ?></td>
            <td style="width: 80px;">
            <button onclick="mover_materia(<?php echo $user[$i]['IdProm']; ?>,<?php echo $user[$i]['IdPeriodo']; ?>,<?php echo $IdUsua; ?>,0)" type="button" class="btn bg-navy btn-flat btn-xs"><i class="fa fa-fw fa-arrow-up"></i></button>
            <button onclick="mover_materia(<?php echo $user[$i]['IdProm']; ?>,<?php echo $user[$i]['IdPeriodo']; ?>,<?php echo $IdUsua; ?>,1)" type="button" class="btn bg-orange btn-flat btn-xs"><i class="fa fa-fw fa-arrow-circle-down"></i></button>
            </td>
          </tr><?php $cf = $user[$i]['IdPeriodo'];
              } ?>
      </tbody>
    </table>
  </div>
</div>
<button onclick="sav_calificacion_gral(<?php echo $IdUsua; ?>,<?php echo $IdAdmin; ?>)" type="button" class="btn bg-purple btn-flat"><i class="fa fa-save"></i> Guardar calificaciones</button>
