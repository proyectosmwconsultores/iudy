<?php
  session_start();
  $IdUsua = $_SESSION['IdUsua'];
  require('../php/clases/class.System.php');
  $db = new Conexion();
   $IdCiclo = $_POST['IdCiclo'];
   $IdCampus = $_POST['IdCampus'];

  $sql_lst = $db->query("SELECT
  tblp_pagos.IdPago,
  tblp_pagos.IdUsua,
  tblc_campus.Campus,
  tblp_educativa.Nombre AS Educativa,
  tblc_usuario.IdOferta,
  tblc_usuario.Nombre,
  tblc_usuario.APaterno,
  tblc_usuario.AMaterno,
  tblc_usuario._hace,
  tblc_usuario.Usuario,
  tblc_usuario.IdEstatus,
  tblp_grupo.CveGrupo,
  tblc_dias_clases._Dias,
  tblc_estatus.Estatus
  FROM
  tblp_pagos
  Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_pagos.IdUsua
  Left Join tblc_campus ON tblc_campus.IdCampus = tblc_usuario.IdCampus
  Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta
  Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_usuario.IdGrupo
  Left Join tblc_dias_clases ON tblc_dias_clases.Dia = tblp_grupo.Dia
  Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_usuario.IdEstatus
  WHERE
  tblp_pagos.IdCiclo =  '$IdCiclo' AND
  tblc_usuario.IdCampus =  '$IdCampus' AND
  tblp_pagos.IdEstatus =  '4'
  GROUP BY
  tblp_pagos.IdUsua
  ORDER BY
  tblc_usuario.IdCampus ASC,
  tblc_usuario.IdOferta ASC,
  tblc_usuario.IdGrupo ASC");

  ?>
  <div class="box-header">
    <h3 class="box-title"><i class="fa fa-fw fa-toggle-right"></i> Reporte de baja de alumnos del ciclo escolar</h3>
  </div>
  <div class="box-body">
    <table class="table table-striped">
      <tbody>
        <tr>
          <th></th>
          <th>USUARIO</th>
          <th>NOMBRE DEL ALUMNO</th>
          <th>GRUPO</th>
          <th>ESTATUS</th>
          <th>ULTIMO INGRESO</th>
        </tr>
      <?php $ing = 0; $vx = 0; $sux = 0; $i = 0; $f = 0; $v = 0; 
      $idEsta8 = 0;
      $idEsta12 = 0;
      $idEsta55 = 0;
      $idEstaAll = 0;

      while($mat = $db->recorrer($sql_lst)){ $vx = 0; $i = $mat['IdOferta'];
        if($mat['IdEstatus'] == 12){
          $idEsta12 = ($idEsta12 + 1);
        }
        if($mat['IdEstatus'] == 8){
          $idEsta8 = ($idEsta8 + 1);
        }
        if($mat['IdEstatus'] == 55){
          $idEsta55 = ($idEsta55 + 1);
        }

      if($mat['_hace']){
        $ing = ($ing + 1);
      }
      if($i <> $f){ ?>
    <tr>
          <th colspan="5"><b><?php echo $mat['Educativa'];  ?></b></th>
        </tr>
      <?php }
        ?>
      <tr>
        <td><b><?php echo $v = ($v + 1); ?>.- </b></td>
        <td><?php echo $mat['Usuario'];  ?></td>
        <td><?php echo $mat['Nombre'].' '.$mat['APaterno'].' '.$mat['AMaterno'];  ?></td>
        <td><?php echo $mat['CveGrupo'].' / '.$mat['_Dias'];  ?></td>
        <td><?php echo $mat['Estatus'];  ?></td>
        <td><?php echo $mat['_hace'];  ?></td>
      </tr><?php $f = $mat['IdOferta']; } ?>
      <tr>
          <th style="text-align: right;" colspan="6"></th>
      </tr>
      <tr>
        <td style="text-align: right;" colspan="5">TOTAL ALUMNOS:</td>
        <td style="text-align: center;"><b><?php echo $v; ?></b></td>
      </tr>
      <tr>
        <td style="text-align: right;" colspan="5">TOTAL ALUMNOS INGRESARON: </td>
        <td style="text-align: center;"><b><?php echo $ing; ?></b></td>
      </tr>
      <tr>
          <th style="text-align: right;" colspan="6"></th>
      </tr>
      <tr>
        <td style="text-align: right;" colspan="5">TOTAL ALUMNOS ACTIVOS:</td>
        <td style="text-align: center;"><b><?php echo $idEsta8; ?></b></td>
      </tr>
      <tr>
        <td style="text-align: right;" colspan="5">TOTAL ALUMNOS EN PROCESO:</td>
        <td style="text-align: center;"><b><?php echo $idEsta12; ?></b></td>
      </tr>
      <tr>
        <td style="text-align: right;" colspan="5">TOTAL GRADUADOS:</td>
        <td style="text-align: center;"><b><?php echo $idEsta55; ?></b></td>
      </tr>
    </tbody></table>

  </div>
