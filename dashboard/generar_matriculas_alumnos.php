<?php
  require('../php/clases/class.php');
  $t=new Trabajo();
  $IdCampus = $_POST['IdCampus'];
  $IdGrupo = $_POST['IdGrupo'];
  include('../hace.php');
  $sql_users=$t->get_lst_user($IdGrupo);
  $sql_grp=$t->get_lst_grp($IdGrupo);
  $get_mat=$t->get_matrLib($sql_users[0]['IdCampus'],$sql_users[0]['IdOferta']);
  $obt_mat=$t->get_obte_matr($IdGrupo,$sql_users[0]['IdCampus'],$sql_users[0]['IdOferta'],$get_mat[0]['IdSeriacion']);

  ?>
  <div class="box-header">
    <h3 class="box-title"><i class="fa fa-fw fa-toggle-right"></i> Reporte para generar matrículas en el grupo</h3>
  </div>
  <div class="bg-maroon-active color-palette" style="padding: 8px;"><span style="color: yellow;"><i class="fa fa-fw fa-bookmark"></i> <?php echo $sql_grp[0]["Nombre"].' - '.$sql_grp[0]["_Modalidad"].' - '.$sql_grp[0]["_Dias"]; ?> </span></div>

  <div class="box-body">
    <?php if((!$sql_users[0]['Usuario']) || ($sql_grp[0]['Grado'] == 1)){ ?>
    <table class="table table-striped" style="font-size: 12px;">
      <tbody>
        <tr>
          <td style="text-align: right; padding-top: 18px;"><b>CLAVE MATRÍCULA:</b></td>
          <td style="padding-top: 18px;"><?php echo $get_mat[0]['Matricula']; ?></td>
          <td style="text-align: right; padding-top: 18px;"><b>CONSECUTIVO ACTUAL:</b></td>
          <td style="padding-top: 18px;"><?php echo substr($obt_mat['Mat'], 6, 3); ?></td>
          <td style="text-align: right; padding-top: 18px;"><b>MATRÍCULA INICIAL:</b></td>
          <td style="padding-top: 18px;"><?php echo $obt_mat['Mat']; ?></td>
          <td style="text-align: right; padding-top: 18px;"><b>CONSECUTIVO ACTUAL:</b></td>
          <td><input type="text" class="form-control" name="txt_mat" id="txt_mat" value="<?php echo substr($obt_mat['Mat'], 6, 3); ?>"></td>
        </tr>
   </tbody></table>
   <br><?php } ?>
    <table class="table table-striped" style="font-size: 12px;">
      <tbody>
        <tr>
          <th style="width: 50px;">#</th>
          <th>NO. CONTROL</th>
          <th>APELLIDO PATERNO</th>
          <th>APELLIDO MATERNO</th>
          <th>NOMBRE DEL ALUMNO</th>
        </tr>
        <?php $c = 0;
        for ($x=0;$x< sizeof($sql_users);$x++) { ?>
        <tr>
          <td><b><?php echo $c = ($c + 1); ?>.- </b></td>
          <td><?php echo $sql_users[$x]['Usuario']; ?></td>
          <td><?php echo $sql_users[$x]['APaterno']; ?></td>
          <td><?php echo $sql_users[$x]['AMaterno']; ?></td>
          <td><?php echo $sql_users[$x]['Nombre']; ?></td>
        </tr><?php
       } ?>
   </tbody></table>
   <?php if((!$sql_users[0]['Usuario']) || ($sql_grp[0]['Grado'] == 1)){ ?>
   <br>
   <button type="button" onclick="genera_matrxx(<?php echo $get_mat[0]['IdSeriacion'].','.$IdGrupo.','.$sql_users[0]['IdCampus'].','.$sql_users[0]['IdOferta']; ?>)" class="btn btn-block btn-warning btn-flat"><i class="fa fa-fw fa-gear"></i> Generar matrículas del grupo</button>
  <?php } ?>
  </div>
