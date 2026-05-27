<?php
require('../php/clases/class.php');
$t = new Trabajo();

$IdCampus = $_POST['IdCampus'];
$IdGrupo = $_POST['IdGrupo'];
include('../hace.php');
$sql_lista_mat = $t->get_lst_mat_asig($IdCampus, $IdGrupo);
$sql_lista = $t->get_lst_mat_asig($IdCampus, $IdGrupo);
$sql_grp = $t->get_lst_grp($IdGrupo);


?>
<div class="box-header">
  <h3 class="box-title"><i class="fa fa-fw fa-toggle-right"></i> Reporte de asistencia del grupo</h3>
</div>

<div class="bg-maroon-active color-palette" style="padding: 8px;"><span style="color: yellow;"><i class="fa fa-fw fa-bookmark"></i> <?php echo $sql_grp[0]["Nombre"] . ' - ' . $sql_grp[0]["_Modalidad"] . ' - ' . $sql_grp[0]["_Dias"]; ?> </span></div>


<table class="table table-striped">
  <tbody>
    <tr>
      <th>DOCENTE</th>
      <th>NOMBRE DE LA MATERIA</th>
      <th>FECHA</th>
      <th></th>
    </tr>
    <?php $p_i = 0; $p_f = 0; for ($i = 0; $i < sizeof($sql_lista); $i++) { $p_i = $sql_lista[$i]["IdCiclo"]; ?>
      <?php if ($p_i <> $p_f) { ?>
        <tr style="background: #c1c1ff;">
          <td colspan="4"><b>PERIODO ESCOLAR:</b><?php echo $sql_lista[$i]['Ciclo']; ?></td>
        </tr>
      <?php } ?>
    <tr>
      <td><?php echo $sql_lista[$i]['Nombre'].' '.$sql_lista[$i]['APaterno'].' '.$sql_lista[$i]['AMaterno']; ?></td>
      <td><?php echo $sql_lista[$i]['CodeModulo'].' '.$sql_lista[$i]['NombreMod']; ?></td>
      <td><?php echo fecha_pago($sql_lista[$i]['FecIni']).' al '.fecha_pago($sql_lista[$i]['FecFin']); ?></td>
      <td><button type="button" class="btn bg-orange btn-flat" onclick="mostrar_grafica(<?php echo $IdCampus; ?>,<?php echo $IdGrupo; ?>,'<?php echo $sql_lista[$i]['IdAsignacion'];  ?>')"  href="javascript:void(0);" title="Generar gráfica de asistencia"><i class="fa fa-fw fa-bar-chart"></i> Reporte</button></td>
    </tr><?php $p_f = $sql_lista[$i]["IdCiclo"]; } ?>
  </tbody>
</table>