<?php
  session_start();
  $IdUsua = $_SESSION['IdUsua'];
  require('../php/clases/class.System.php');
  $db = new Conexion();

  $IdGrupo = $_POST['IdGrupo'];
  $IdModulo = $_POST['IdModulo'];

  $sql_cic = $db->query("SELECT tblp_asignacion.IdAsignacion, tblp_asignacion.IdCiclo FROM tblp_asignacion WHERE tblp_asignacion.IdGrupo =  '$IdGrupo' AND tblp_asignacion.IdModulo = '$IdModulo' LIMIT 1");
  $db->rows($sql_cic);
  $_cic = $db->recorrer($sql_cic);
  $IdCiclo = $_cic['IdCiclo'];
  $IdAsignacion = $_cic['IdAsignacion'];

  $sql_mod = $db->query("SELECT tblp_modulo.CodeModulo, tblp_modulo.NombreMod, tblp_modulo.IdEducativa FROM tblp_modulo WHERE tblp_modulo.IdModulo = '$IdModulo'");
  $db->rows($sql_mod);
  $_mod = $db->recorrer($sql_mod);

  $sql_grp = $db->query("SELECT tblp_grupo.CveGrupo FROM tblp_grupo WHERE tblp_grupo.IdGrupo = '$IdGrupo'");
  $db->rows($sql_grp);
  $_grp = $db->recorrer($sql_grp);
  $cve_grupo = $_grp['CveGrupo'];

  $sql_mat = $db->query("SELECT
tblc_usuario.IdUsua,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.Usuario,
tblc_usuario.IdCampus,
tblp_grupo.IdGrupo,
tblc_campus.Campus
FROM
tblc_usuario
Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_usuario.IdGrupo
Left Join tblc_campus ON tblc_campus.IdCampus = tblc_usuario.IdCampus
WHERE
tblc_usuario.Permisos =  '3' AND
tblc_usuario.IdGrupo =  '$IdGrupo'
ORDER BY
tblc_usuario.IdCampus ASC,
tblc_usuario.APaterno ASC
");

  ?>
  <div class="box-header">
    <h3 class="box-title"><i class="fa fa-fw fa-toggle-right"></i> Calificación final de los alumnos</h3>

  </div>
  <div class="box-body">
    <div class="bg-yellow color-palette" style="padding: 8px;"><span style="color: black;"><i class="fa fa-fw fa-bookmark"></i> <?php echo $_mod["NombreMod"]; ?> </span></div>
    <table class="table table-striped">
      <tbody>

      <?php $v = 0; $i = 0; $f = 0; while($mat = $db->recorrer($sql_mat)){  $i = $mat['IdCampus'];
        if($i <> $f){ $v = 0; ?>
          <tr style="background: #cbd3ff;">
            <th colspan="4"><?php echo $mat['Campus']; ?></th>
          </tr>
          <tr style="background: #f0f4ff;">
            <th>#</th>
            <th>NO.CONTROL</th>
            <th>NOMBRE DEL ALUMNO</th>
            <th style="width: 150px; text-align: center;">PROMEDIO</th>
          </tr>
        <?php }

        $sql_prom = $db->query("SELECT tblp_calificacion.IdCalificacion, tblp_calificacion.Promedio, tblp_modulo.CodeModulo FROM tblp_calificacion Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_calificacion.IdModulo WHERE tblp_calificacion.IdUsua =  '".$mat['IdUsua']."' AND tblp_modulo.CodeModulo =  '".$_mod['CodeModulo']."' AND tblp_calificacion.IdOferta =  '".$_mod['IdEducativa']."'");
        $db->rows($sql_prom);
        $_prx = $db->recorrer($sql_prom);
        $_idcal = $_prx['IdCalificacion'];

        if(isset($_idcal)){
          $_prom = $_prx['Promedio'];
          $_idcal = $_prx['IdCalificacion'];
        } else {
          $_prom = '';
          $_idcal = 0;
        }

        $_idUs = $mat['IdUsua'];
         ?>
      <tr>
        <td><b><?php echo $v = ($v + 1); ?>.- </b></td>
        <td><?php echo $mat['Usuario']; ?></td>
        <td><?php echo $mat['APaterno'].' '.$mat['AMaterno'].' '.$mat['Nombre'];  ?></td>
        <td style="text-align: center;">

        <div class="input-group input-group-sm">
          <input type="text" style="text-align: center;" class="form-control" name="txtFolio-<?php echo $_idUs; ?>" id="txtFolio-<?php echo $_idUs; ?>" value="<?php if($_prom == 'NP'){ echo 'NP'; } else { echo $_prom; }?>" >
            <span class="input-group-btn">
              <button title="Guardar calificación final" onclick="save_cal_all(<?php echo $_idcal; ?>, <?php echo $_idUs; ?>, <?php echo $IdCiclo; ?>)" type="button" class="btn btn-info btn-flat"><i class="fa fa-fw fa-save"></i></button>
              <?php if($_idcal){ ?>
              <button title="Actualizar calificaciones" onclick="upd_cal_all(<?php echo $_idcal; ?>)" type="button" class="btn btn-danger btn-flat"><i class="fa fa-fw fa-gear"></i></button>
              <?php } ?>
            </span>
          </div>
        </td>
      </tr><?php $f = $mat['IdCampus']; } ?>
    </tbody></table>
    <div class="box-footer clearfix">
      <button onclick="window.open('repositorio/portafolio/acta_calificacion.php?tokenId=<?php echo $_cic['IdAsignacion']; ?>','_blank')" href="javascript:void(0);" title="Acta de calificación del docente" type="button" class="btn bg-maroon btn-flat">Generar acta de calificación <i class="fa fa-fw fa-file-pdf-o"></i></button>
    </div>
  </div>
