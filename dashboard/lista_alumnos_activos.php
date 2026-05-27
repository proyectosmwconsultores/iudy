<?php
session_start();
  require('../php/clases/class.php');
  $t=new Trabajo();

  $sql_mat=$t->get_lst_alumnos_act($_SESSION['IdUsua']);

  ?>
  <div class="box-header">
    <h3 class="box-title"><i class="fa fa-fw fa-toggle-right"></i> Alumnos por plan de estudios y grupo</h3>
  </div>

  <div class="box-body">
    <table class="table table-striped" style="font-size: 12px;">
      <tbody>
        <tr>
          <th style="width: 10px;"></th>
          <th>PLAN DE ESTUDIOS</th>
          <th>GRUPO</th>
          <th>ESTATUS</th>
          <th style="text-align: center;">TOTAL ALUMNOS</th>
          <th style="text-align: center;"></th>
        </tr>
        <?php $_a = 0; $g_i = 0; $g_f = 0;
        for ($i=0;$i< sizeof($sql_mat);$i++) { $g_i =$sql_mat[$i]['IdGrado'];
          if($g_i <> $g_f){ ?>
            <tr>
              <td colspan="5"><b><?php echo $sql_mat[$i]['_Grado']; ?></b></td>
            </tr>
          <?php }  ?>
        <tr>
          <td><b><?php echo $_a = ($_a + 1); ?>.- </b></td>
          <td><?php echo $sql_mat[$i]['Nombre']; ?></td>
          <td><?php echo $sql_mat[$i]['Grado']; ?>° <?php echo $sql_mat[$i]['CveGrupo']; ?></td>
          <td><?php echo $sql_mat[$i]['Estatus']; ?></td>
          <td style="text-align: center;"><?php echo $sql_mat[$i]['Total']; ?></td>
          <td style="text-align: center;">
            <button onclick="ver_lista_alumnos(<?php echo $sql_mat[$i]['IdGrupo']; ?>)" type="button" class="btn bg-navy btn-xs" title="Evidencia de la actividad"><i class="fa fa-fw fa-cog"></i></button>
          </td>
        </tr>
        <?php $g_f =$sql_mat[$i]['IdGrado']; }   ?>
   </tbody></table>
 </div>
