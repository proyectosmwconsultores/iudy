<?php
  require('../php/clases/class.php');
  $t=new Trabajo();

  $IdCampus = $_POST['IdCampus'];
  $IdGrupo = $_POST['IdGrupo'];
  include('../hace.php');
  $sql_us=$t->get_lst_alumx($IdGrupo);
  $sql_grp=$t->get_lst_grp($IdGrupo);
  ?>
  <div class="box-header">
    <h3 class="box-title"><i class="fa fa-fw fa-toggle-right"></i> Reporte de seguimiento de los alumnos</h3>
  </div>
  <div class="bg-gray-active color-palette" style="padding: 10px;"><span style="color: black;"><i class="fa fa-fw fa-bookmark"></i> <?php echo $sql_grp[0]["Nombre"].' - '.$sql_grp[0]["_Modalidad"].' - '.$sql_grp[0]["_Dias"]; ?></span></div>

  <div class="box-body">

    <table class="table table-striped" style="font-size: 12px;">
      <tbody>
        <tr style="background: #e1dede; color: black;">
          <th></th>
          <th>NO.CONTROL</th>
          <th>NOMBRE DE ALUMNO</th>
          <th>ESTATUS</th>
          <th style="text-align: center;">FORMA TITULACIÓN</th>
          <th style="text-align: center;">INSCRIPCIÓN DE TITULACIÓN</th>
          <th style="text-align: center;">ACTA PROFESIONAL</th>
          <th style="text-align: center;">CERTIFICADO DE GRADO</th>

        </tr>
        <?php $v = 0;
        for ($x=0;$x< sizeof($sql_us);$x++) {
          $ins = $sql_grp[0]['IdGrado'].'6';
          $act = $sql_grp[0]['IdGrado'].'2';
          $cer = $sql_grp[0]['IdGrado'].'1';
          $_dxt_ins=$t->get_docs_alum($sql_us[$x]['IdUsua'],$ins);
          $_dxt_acta=$t->get_docs_alum($sql_us[$x]['IdUsua'],$act);
          $_dxt_cert=$t->get_docs_alum($sql_us[$x]['IdUsua'],$cer);
           ?>
        <tr>
          <td><b><?php echo $v = ($v + 1); ?>.- </b></td>
          <td><?php echo $sql_us[$x]['Usuario']; ?></td>
          <td><?php echo $sql_us[$x]['APaterno'].' '.$sql_us[$x]['AMaterno'].' '.$sql_us[$x]['Nombre']; ?></td>
          <td><?php echo $sql_us[$x]['Estatus']; ?></td>
          <td style="text-align: center;">****</td>
          <td style="text-align: center;"><?php if(isset($_dxt_ins[0])){ echo $_dxt_ins[0]['Fecha']; } else { echo "---";} ?></td>
          <td style="text-align: center;"><?php if(isset($_dxt_acta[0])){ echo $_dxt_acta[0]['Fecha']; } else { echo "---";} ?></td>
          <td style="text-align: center;"><?php if(isset($_dxt_cert[0])){ echo $_dxt_cert[0]['Fecha']; } else { echo "---";} ?></td>
        </tr><?php

       } ?>
   </tbody></table>

  </div>
