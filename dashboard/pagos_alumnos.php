<?php
  session_start();
  $IdUsua = $_SESSION['IdUsua'];
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdCiclo = $_POST['IdCiclo'];
  $IdGrupo = $_POST['IdGrupo'];


  $porciones = explode("_", $IdGrupo);
  $Grado =  $porciones[0]; // porción1
  $IdGrupo = $porciones[1]; // porción2

  $sql_lsta = $db->query("SELECT tblp_modulo.IdModulo, tblp_modulo.CodeModulo, tblp_modulo.Grado, tblp_modulo.NombreMod, tblp_grupo.IdGrupo, tblp_educativa.IdGrado FROM tblp_grupo Left Join tblp_modulo ON tblp_modulo.IdEducativa = tblp_grupo.IdOferta AND tblp_modulo.IdCampus = tblp_grupo.IdCampus Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_modulo.IdEducativa WHERE tblp_grupo.IdGrupo =  '$IdGrupo' AND tblp_modulo.Grado =  '$Grado' ORDER BY tblp_modulo.CodeModulo ASC ");

  $sql_cic = $db->query("SELECT tblc_ciclo.Ciclo FROM tblc_ciclo WHERE tblc_ciclo.IdCiclo = '$IdCiclo'");
  $db->rows($sql_cic);
  $_cic = $db->recorrer($sql_cic);


  ?>

  <div class="box-body">
    <div class="bg-purple-active color-palette" style="padding: 8px;"><span style="color: yellow;"><b><i class="fa fa-fw fa-check-square-o"></i> PERIODO ESCOLAR: </b></span><?php echo $_cic["Ciclo"]; ?></div>
    <table class="table table-striped" style="font-size: 12px;">
      <tbody>
        <tr style="background: #a6a6a6;">
          <th></th>
          <th>NOMBRE DE LA MATERIA</th>
          <th style="text-align: center;">CONFIGURACIÓN</th>
        </tr>
      <?php $g = 0; while($matx = $db->recorrer($sql_lsta)){ ?>
      <tr>
        <td><b><?php echo $g = ($g + 1); ?>.- </b></td>
        <td><?php echo $matx['CodeModulo'].' - '.$matx['NombreMod']; ?></td>
        <td style="text-align: center;">
          <?php if(($matx['IdGrado'] == 1) || ($matx['IdGrado'] == 2)){ ?>
          <button onclick="configurar_pagos_id(<?php echo $matx['IdModulo']; ?>,<?php echo $IdCiclo; ?>,<?php echo $IdGrupo; ?>)"  href="javascript:void(0);" title="Generar pago de la materia" type="button" class="btn bg-purple btn-flat btn-xs"><i class="fa fa-fw fa-cog"></i> Generar pago</button>
          <?php } ?>
        </td>
      </tr><?php } ?>
    </tbody></table>
    <br>
    <button onclick="configurar_otros_pagos(<?php echo $IdCiclo; ?>,<?php echo $IdGrupo; ?>)"  href="javascript:void(0);" title="Generar otros pagos" type="button" class="btn btn-danger btn-block"><i class="fa fa-fw fa-gears"></i> Generar pago</button>
  </div>
