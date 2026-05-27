<?php
  session_start();
  $IdUsua = $_SESSION['IdUsua'];
  require('../php/clases/class.System.php');
  $db = new Conexion();

  $IdCiclo = $_POST['IdCiclo'];
  $IdGrupo = $_POST['IdGrupo'];
  $porciones = explode("_", $IdGrupo);
  $grado = $porciones[0];
  $IdGrupo=  $porciones[1];

  $sql_mat_lsta = $db->query("SELECT tblc_usuario.IdUsua, tblc_usuario.Usuario, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno FROM tblc_usuario WHERE tblc_usuario.IdGrupo = '$IdGrupo' AND tblc_usuario.IdEstatus = '8' ORDER BY tblc_usuario.APaterno ASC, tblc_usuario.AMaterno ASC");

  $sql_asig = $db->query("SELECT tblp_asignacion.IdAsignacion FROM tblp_asignacion WHERE tblp_asignacion.IdCiclo =  '$IdCiclo' AND tblp_asignacion.IdGrupo =  '$IdGrupo' LIMIT 1");
  $db->rows($sql_asig);
  $_asig = $db->recorrer($sql_asig);
  $IdAsig = $_asig['IdAsignacion'];

  $sql_cic = $db->query("SELECT tblc_ciclo.Ciclo FROM tblc_ciclo WHERE tblc_ciclo.IdCiclo = '$IdCiclo'");
  $db->rows($sql_cic);
  $_cic = $db->recorrer($sql_cic);

  $sql_grp = $db->query("SELECT tblp_grupo.Modalidad, tblp_grupo.IdCampus, tblp_grupo.CveGrupo, tblp_grupo.IdOferta, tblp_grupo.TipoCiclo, tblp_educativa.IdGrado FROM tblp_grupo Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_grupo.IdOferta WHERE tblp_grupo.IdGrupo = '$IdGrupo'");
  $db->rows($sql_grp);
  $_grp = $db->recorrer($sql_grp);
  $IdOferta = $_grp['IdOferta'];
  $IdCampus = $_grp['IdCampus'];
  $_mod = $_grp['Modalidad'];
  $_idGra = $_grp['IdGrado'];
  if($_idGra == 3){
    if($_mod == 'E'){
      $_link = "boleta_calificacion_alumno";
    } else {
      $_link = "boleta_calificacion_alumno_eje";
    }
  } else {
    $_link = "boleta_calificacion_alumno_pos";
  }

  if($_grp['TipoCiclo'] == 'C') { $_txG = 'CUATRIMESTRE'; } elseif($_grp['TipoCiclo'] == 'S') { $_txG = 'SEMESTRE'; } else { $_txG = 'TRIMESTRE'; }

  $sql_list1 = $db->query("SELECT tblp_modulo.IdModulo, tblp_modulo.CodeModulo, tblp_modulo.NombreMod FROM tblp_modulo WHERE tblp_modulo.IdEducativa =  '$IdOferta' AND tblp_modulo.IdCampus = '$IdCampus' AND tblp_modulo.Grado =  '$grado' ORDER BY tblp_modulo.CodeModulo ASC");
  $sql_sum = $db->query("SELECT Count(tblp_modulo.IdModulo) AS Total FROM tblp_modulo WHERE tblp_modulo.IdEducativa =  '$IdOferta' AND tblp_modulo.Grado =  '$grado' AND tblp_modulo.Tipo =  '1'");
  $db->rows($sql_sum);
  $_sum = $db->recorrer($sql_sum);
  $_all = $_sum['Total'];
  ?>
  <div class="box-body">
    <div class="bg-purple-active color-palette" style="padding: 8px;"><span style="color: yellow;"><b><i class="fa fa-fw fa-check-square-o"></i> PERIODO ESCOLAR: </b></span><?php echo $_cic["Ciclo"]; ?> (<?php echo $grado; ?>° <?php echo $_txG; ?>)</div>
    <table class="table table-striped" style="font-size: 12px;">
      <tbody>
        <tr style="background: #a6a6a6;">
          <th>MATRÍCULA</th>
          <th>NOMBRE DEL ALUMNO</th>
          <?php while($_lst1 = $db->recorrer($sql_list1)){ ?>
          <th style="text-align: center;"><?php echo $_lst1['CodeModulo']; ?></th>
          <?php } ?>
          <th>PROMEDIO</th>
          <th>IMPRIMIR</th>
        </tr>
      <?php $_promx = 0; $_sumP = 0; $gx = 0; while($matx = $db->recorrer($sql_mat_lsta)){
        $sql_list2 = $db->query("SELECT tblp_modulo.IdModulo, tblp_modulo.CodeModulo, tblp_modulo.NombreMod FROM tblp_modulo WHERE tblp_modulo.IdEducativa =  '$IdOferta' AND tblp_modulo.IdCampus = '$IdCampus' AND tblp_modulo.Grado =  '$grado' ORDER BY tblp_modulo.CodeModulo ASC");
        ?>
      <tr>
        <td><?php echo $matx['Usuario']; ?></td>
        <td><?php echo $matx['APaterno']; ?> <?php echo $matx['AMaterno']; ?> <?php echo $matx['Nombre']; ?></td>
        <?php $_tx = '';  while($_lst2 = $db->recorrer($sql_list2)){
          $gx = ($gx + 1);
          $sql_cal = $db->query("SELECT tblp_calificacion.E1, tblp_calificacion.IdAsignacion, tblp_calificacion.E2, tblp_calificacion.Promedio FROM tblp_calificacion WHERE tblp_calificacion.IdUsua = '".$matx['IdUsua']."' AND tblp_calificacion.IdModulo = '".$_lst2['IdModulo']."'");
          $db->rows($sql_cal);
          $_cal = $db->recorrer($sql_cal);
          $prom = $_cal['Promedio'];
          if($_cal['E1']){
            $prom = $_cal['E1'];
            $_tx = ' Ex1';
          }elseif($_cal['E2']){
            $prom = $_cal['E2'];
            $_tx = ' Ex2';
          }else{
            $prom = $_cal['Promedio'];
            $_tx = '';
          } ?>
        <td style="text-align: center;"><?php echo $prom.$_tx; ?></td>
        <?php
        if(is_numeric($prom)){
           $_sumP = ($_sumP + $prom);
        }

      } ?>
        <td style="text-align: center;"><b>
          <?php if($_sumP) {
           echo $px = round(($_sumP / $_all), 2);
           $_sumP = 0; } ?>
         </b>
        </td>
        <td onclick="window.open('repositorio/portafolio/<?php echo $_link; ?>.php?idToks=<?php echo $matx['IdUsua'].'_'.$porciones[0].'_'.$IdGrupo.'_'.$IdAsig; ?>','_blank')"  href="javascript:void(0);">Imprimir</td>
      </tr><?php } ?>
    </tbody></table>
    <hr>
    <div class="box-footer clearfix">
      <div class="btn-group" style="float: right;">
        <button onclick="window.open('repositorio/portafolio/control_general.php?idToks=<?php echo $IdCiclo.'_'.$IdGrupo.'_'.$porciones[0].'_'.$IdAsig; ?>','_blank')"  href="javascript:void(0);" title="Acta de calificación del docente" type="button" class="pull-right btn bg-navy btn-flat margin">Concentrado de calificaciones<i class="fa fa-fw fa-file-pdf-o"></i></button>
      </div>
    </div>
  </div>
