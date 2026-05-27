<?php
  require('../php/clases/class.php');
  $t=new Trabajo();
  $IdCampus = $_POST['IdCampus'];
  $IdGrupo = $_POST['IdGrupo'];
  include('../hace.php');
  $sql_correo=$t->get_correos_envi($IdGrupo);
  $sql_grp=$t->get_lst_grp($IdGrupo);
  ?>
  <div class="bg-maroon-active color-palette" style="padding: 8px;"><span style="color: yellow;"><i class="fa fa-fw fa-bookmark"></i> <?php echo $sql_grp[0]["Nombre"].' - '.$sql_grp[0]["_Modalidad"].' - '.$sql_grp[0]["_Dias"]; ?> </span></div>

  <div class="bg-gray-active color-palette" style="padding: 10px;"><span style="color: black;"> <i class="fa fa-fw fa-check-circle"></i> REPORTE DE CORREOS ENVIADOS AL GRUPO</span></div>

  <div class="box-body">

    <table class="table table-striped" style="font-size: 12px;">
      <tbody>
        <tr>
          <th style="width: 10px;">#</th>
          <th style="width: 100px;">FEC. CAPTURA</th>
          <th style="width: 200px;">ASUNTO</th>
          <th style="width: 200px;">ENVIADO POR</th>
          <th style="width: 100px; text-align: center;">#CORREOS ENVIADOS</th>
        </tr>
        <?php $c = 0;
        for ($x=0;$x< sizeof($sql_correo);$x++) { ?>
        <tr>
          <td><b><?php echo $c = ($c + 1); ?>.- </b></td>
          <td><?php echo $sql_correo[$x]['FecCap']; ?></td>
          <td><?php echo $sql_correo[$x]['Asunto']; ?></td>
          <td><?php echo $sql_correo[$x]['APaterno'].' '.$sql_correo[$x]['AMaterno'].' '.$sql_correo[$x]['Nombre']; ?></td>
          <td style="text-align: center;"><?php echo $sql_correo[$x]['Total']; ?></td>
        </tr><?php
       } ?>
   </tbody></table>
  </div>
