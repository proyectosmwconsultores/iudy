<?php
require('../php/clases/class.php');
$t = new Trabajo();

$IdCampus = $_POST['IdCampus'];
$IdGrupo = $_POST['IdGrupo'];
$IdAsignacion = $_POST['IdAsignacion'];
include('../hace.php');
$sql_lista_mat = $t->get_lst_mat_asig_id($IdCampus, $IdGrupo,$IdAsignacion);


?>
<div class="bg-purple color-palette" style="padding: 8px;"><span style="color: yellow;"><i class="fa fa-fw fa-book"></i> <?php echo $sql_lista_mat[0]["NombreMod"]; ?> </span></div>


<?php $_as = 0; 
$p_i = 0;
$p_f = 0;
for ($i = 0; $i < sizeof($sql_lista_mat); $i++) { ?>
  <blockquote>
    <small><?php echo $sql_lista_mat[$i]["Nombre"] . ' ' . $sql_lista_mat[$i]["APaterno"] . ' ' . $sql_lista_mat[$i]["AMaterno"]; ?></small>
  </blockquote>
  <div class="box-body">
    <?php
    $IdAsignacion = $sql_lista_mat[$i]['IdAsignacion'];
    $_total_dias = $t->get_total_dias($IdAsignacion);
    $_total = $_total_dias[0]['NoDias'];
    $AnioMes = 0;

    $_dias = $t->get_dias_clases($IdAsignacion, $AnioMes);
    $_user = $t->get_user_lista($IdAsignacion);
    ?>

    <table class="table table-striped" style="font-size: 12px;">
      <tbody>
        <tr style="background: #003A70;">
          <th style="color: white;">NOMBRE DEL ALUMNO</th>
          <?php $no = 0;
          for ($d = 0; $d < sizeof($_dias); $d++) {
            $no = ($no + 1); ?>
            <th style="text-align: center; background: #b3d3fb;">
              <a class="dropdown-toggle" style="cursor: pointer; color: #333 ">
                <i class="fa fa-calendar"></i> <?php echo obtener_dia($_dias[$d]['Fecha']); ?>
              </a>
            </th>
          <?php } ?>
          <th style="width: 10px; background: white; text-align: center;">A</th>
          <th style="width: 10px; background: white; text-align: center;">P</th>
          <th style="width: 10px; background: white; text-align: center;">F</th>
        </tr>
        <?php $cx = 0;
        $s_a = 0;
        $s_r = 0;
        $s_f = 0;
        $alu = 0;
        for ($x = 0; $x < sizeof($_user); $x++) {
          $alu = ($alu + 1);
          $_as = 1; ?>
          <tr>
            <td>
              <?php echo $_user[$x]['APaterno'] . ' ' . $_user[$x]['AMaterno'] . ' ' . $_user[$x]['Nombre']; ?>
            </td>
            <?php $a = 0;
            $r = 0;
            $f = 0;
            for ($y = 0; $y < sizeof($_dias); $y++) {
              $_asis = $t->get_valos_asis($IdAsignacion, $_user[$x]['IdUsua'], $_dias[$y]['Fecha']); ?>
              <td style="text-align: center;"><?php echo $_asis[0]['Letra']; ?></td>
            <?php
              if ($_asis[0]['IdTipo'] == 2) {
                $a = ($a + 1);
              }
              if ($_asis[0]['IdTipo'] == 3) {
                $r = ($r + 1);
              }
              if ($_asis[0]['IdTipo'] == 4) {
                $f = ($f + 1);
              }
            } ?>
            <td style="text-align: center; "><?php echo $a; ?></td>
            <td style="text-align: center; "><?php echo $r; ?></td>
            <td style="text-align: center; "><?php echo $f; ?></td>
          </tr><?php

              } ?>
      </tbody>
    </table>
    <?php if ($_as == 1) { ?>
      <button style="float: right; " type="button" class="btn bg-navy btn-flat margin view_grafica_id" id="<?php echo $sql_lista_mat[$i]["IdAsignacion"]; ?>" href="javascript:void(0);" title="Generar gráfica de asistencia"><i class="fa fa-fw fa-bar-chart"></i> Generar gráfica</button>
    <?php } ?>

  </div>
<?php }  ?>