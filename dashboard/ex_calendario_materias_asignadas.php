<?php
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Materias_asignadas.xls");
header("Pragma: no-cache");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Expires: 0");
  require('../php/clases/class.php');
  $t=new Trabajo();
  $IdCampus = $_GET['IdCampus'];
  $IdCiclo = $_GET['IdCiclo'];
  $IdCiclo = $_GET['IdCiclo'];
  $sql_mat=$t->get_calen_mat_asg($IdCampus,$IdCiclo,'T');

  ?>
  <meta charset="utf-8">
  <div class="box-header">
    <h3 class="box-title"> Reporte de materias asignadas a los docentes en un periodo escolar</h3>
  </div>
  <div class="box-body">
    <table class="table table-striped" style="font-size: 12px;">
      <tbody>
        <?php $_a = 0; $p_i = 0; $p_f = 0;
        for ($i=0;$i< sizeof($sql_mat);$i++) { $p_i = $sql_mat[$i]["IdGrupo"];
          if($p_i <> $p_f){ ?>
            <tr style="background: #00c0ef;">
              <th colspan="6" style="color: black; text-align: left;"><i class="fa fa-fw fa-check-circle"></i> <?php echo $sql_mat[$i]["Grado"]; ?> -  <?php echo htmlentities($sql_mat[$i]["Educativa"]); ?> - <?php echo $sql_mat[$i]["CveGrupo"]; ?> - <?php echo $sql_mat[$i]["_Modalidad"]; ?> - <?php echo $sql_mat[$i]["_Dias"]; ?></th>
            </tr>
            <tr>
              <th style="width: 40px;"></th>
              <th>NOMBRE DE LA MATERIA</th>
              <th>NOMBRE DEL DOCENTE</th>
              <th>INICIA</th>
              <th>FINALIZA</th>
              <th>ESTATUS</th>
            </tr>
          <?php } ?>
        <tr>
          <td><b><?php echo $_a = ($_a + 1); ?>.- </b></td>
          <td><?php echo htmlentities($sql_mat[$i]['NombreMod']); ?></td>
          <td><?php echo $sql_mat[$i]['APaterno'].' '.$sql_mat[$i]['AMaterno'].' '.$sql_mat[$i]['Nombre']; ?></td>
          <td><?php echo $sql_mat[$i]['FecIni']; ?></td>
          <td><?php echo $sql_mat[$i]['FecFin']; ?></td>
          <td><?php echo $sql_mat[$i]['Estatus']; ?></td>
        </tr>
        <?php $p_f = $sql_mat[$i]["IdGrupo"]; }  ?>
   </tbody></table>

  </div>
