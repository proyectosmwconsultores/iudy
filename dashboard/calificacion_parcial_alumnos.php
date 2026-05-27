<?php
  require('../php/clases/class.php');
  include('../hace.php');
  $t=new Trabajo();
  $IdCiclo = $_POST['IdCiclo'];
  $IdGrupo = $_POST['IdGrupo'];
  $IdAsignacion = $_POST['IdAsignacion'];
  $porciones = explode("_", $IdGrupo);
  $grado = $porciones[0];
  $IdGrupo =  $porciones[1];
  $nP = 0;
  $sql_user=$t->get_lista_us($IdAsignacion);
  $sql_asig=$t->get_fech_emis($IdAsignacion);
  $sql_grp=$t->get_lst_grp($IdGrupo);

  if($sql_grp[0]['Modalidad'] == 'E'){
    $_doxs = "_escolar";
    $nP = 3;
  } else {
    $_doxs = "_ejecutiva";
    $nP = 2;
  }

  ?>
  <div class="box-header">
    <h3 class="box-title"><i class="fa fa-fw fa-toggle-right"></i> Reporte de trayectoria de los alumnos</h3>
  </div>
  <div class="bg-maroon-active color-palette" style="padding: 8px;"><span style="color: yellow;"><i class="fa fa-fw fa-bookmark"></i> <?php echo $sql_grp[0]["Nombre"].' - '.$sql_grp[0]["_Modalidad"].' - '.$sql_grp[0]["_Dias"]; ?> </span></div>

  <div class="box-body">
    <div class="bg-gray-active color-palette" style="padding: 10px;"><span style="color: black;"> <i class="fa fa-fw fa-book"></i> <?php echo $sql_asig[0]['CodeModulo'].' - '.$sql_asig[0]['NombreMod']; ?> </span></div>
    <table class="table table-striped" style="font-size: 12px;">
      <tbody>
        <tr>
          <th style="width: 10px;"><br>#</th>
          <th style="width: 50px;"><br>NO. CONTROL</th>
          <th style="width: 200px;"><br>NOMBRE DEL ALUMNO</th>
          <th style="width: 10px; text-align: center;">
            PARCIAL 1
            <br><?php if(isset($sql_asig[0]['Fec_emi_bim1'])){ echo obtenerFechaCorta($sql_asig[0]['Fec_emi_bim1']);  ?>
            <br>
            <button onclick="javascript:window.open('repositorio/portafolio/acta_licenciatura<?php echo $_doxs; ?>.php?tokenId=<?php echo $IdAsignacion; ?>&tok=1');" href="javascript:void(0);" type="button" class="btn bg-olive btn-flat btn-xs"><i class='fa fa-fw fa-download'></i> Acta Parcial 1</button>
            <?php } ?>
            <button onclick="cal_parcial_add(1,<?php echo $nP; ?>,'<?php echo $IdAsignacion; ?>')" href="javascript:void(0);" type="button" class="btn bg-navy btn-flat btn-xs"><i class='fa fa-fw fa-cog'></i></button>
          </th>
          <th style="width: 10px; text-align: center;">
            PARCIAL 2
            <br><?php if(isset($sql_asig[0]['Fec_emi_bim2'])){ echo obtenerFechaCorta($sql_asig[0]['Fec_emi_bim2']);  ?>
            <br><button onclick="javascript:window.open('repositorio/portafolio/acta_licenciatura<?php echo $_doxs; ?>.php?tokenId=<?php echo $IdAsignacion; ?>&tok=2');" href="javascript:void(0);" type="button" class="btn bg-olive btn-flat btn-xs"><i class='fa fa-fw fa-download'></i> Acta Parcial 2</button>
            <?php } ?>
            <button onclick="cal_parcial_add(2,<?php echo $nP; ?>,'<?php echo $IdAsignacion; ?>')" href="javascript:void(0);" type="button" class="btn bg-navy btn-flat btn-xs"><i class='fa fa-fw fa-cog'></i></button>
          </th>
          <?php if($sql_grp[0]['Modalidad'] == 'E'){ ?>
          <th style="width: 10px; text-align: center;">
            PARCIAL 3
            <br><?php if(isset($sql_asig[0]['Fec_emi_bim3'])){ obtenerFechaCorta($sql_asig[0]['Fec_emi_bim3']);  ?>
            <br><button onclick="javascript:window.open('repositorio/portafolio/acta_licenciatura<?php echo $_doxs; ?>.php?tokenId=<?php echo $IdAsignacion; ?>&tok=3');" href="javascript:void(0);" type="button" class="btn bg-olive btn-flat btn-xs"><i class='fa fa-fw fa-download'></i> Acta Parcial 3</button>
            <?php } ?>
            <button onclick="cal_parcial_add(3,<?php echo $nP; ?>,'<?php echo $IdAsignacion; ?>')" href="javascript:void(0);" type="button" class="btn bg-navy btn-flat btn-xs"><i class='fa fa-fw fa-cog'></i></button>
          </th>
          <?php } ?>
          <th style=" width: 10px; text-align: center;"><br>PROM.</th>
          <th style=" width: 10px; text-align: center;"><br>PROM.<br>FINAL</th>
        </tr>
        <?php $cx = 0; $s_a = 0; $s_r = 0; $s_f = 0; $alu = 0; $c = 0;
        for ($x=0;$x< sizeof($sql_user);$x++) { ?>
        <tr>
          <td><b><?php echo $c = ($c + 1); ?>.- </b></td>
          <td><?php echo $sql_user[$x]['Usuario']; ?></td>
          <td><?php echo $sql_user[$x]['APaterno'].' '.$sql_user[$x]['AMaterno'].' '.$sql_user[$x]['Nombre']; ?></td>
          <td style="text-align: center; "><?php if(isset($sql_asig[0]['Fec_emi_bim1'])){ echo $sql_user[$x]['ParcialF1']; } else { echo '----'; } ?></td>
          <td style="text-align: center; "><?php if(isset($sql_asig[0]['Fec_emi_bim1'])){ echo $sql_user[$x]['ParcialF2']; } else { echo '----'; } ?></td>
          <?php if($sql_grp[0]['Modalidad'] == 'E'){ ?>
          <td style="text-align: center; "><?php if(isset($sql_asig[0]['Fec_emi_bim1'])){ echo $sql_user[$x]['ParcialF3']; } else { echo '----'; } ?></td>
          <?php } ?>
          <td style="text-align: center;"><?php echo $sql_user[$x]['Promedio']; ?></td>
          <td style="text-align: center;"><?php echo $sql_user[$x]['Promedio_final']; ?></td>
        </tr><?php
       } ?>
   </tbody></table>
  </div>
