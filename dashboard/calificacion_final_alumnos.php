<?php
  session_start();
  $IdUsua = $_SESSION['IdUsua'];
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdCiclo = $_POST['IdCiclo'];
  $IdCampus = $_POST['IdCampus'];
  $IdGrupo = $_POST['IdGrupo'];
  $IdModulo = $_POST['IdModulo'];

  $sql_mat_lsta = $db->query("SELECT
tblp_asignacion.IdAsignacion,
tblp_modulo.CodeModulo,
tblp_modulo.NombreMod,
tblp_modulo.Grado,
tblp_asignacion.Promedio
FROM
tblp_asignacion
Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo
WHERE
tblp_asignacion.IdCiclo =  '$IdCiclo' AND
tblp_asignacion.IdGrupo =  '$IdGrupo' AND
tblp_asignacion.Tipo =  '2'
ORDER BY
tblp_modulo.CodeModulo ASC
");

  $sql_cic = $db->query("SELECT tblc_ciclo.Ciclo FROM tblc_ciclo WHERE tblc_ciclo.IdCiclo = '$IdCiclo'");
  $db->rows($sql_cic);
  $_cic = $db->recorrer($sql_cic);

  $sql_mod = $db->query("SELECT tblp_modulo.NombreMod FROM tblp_modulo WHERE tblp_modulo.IdModulo = '$IdModulo'");
  $db->rows($sql_mod);
  $_mod = $db->recorrer($sql_mod);



  $sql_mat = $db->query("SELECT tblp_calificacion.IdCalificacion, tblp_calificacion.IdAsignacion, tblp_calificacion.Usuario, tblp_calificacion.Promedio, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblp_calificacion.IdTipo FROM tblp_calificacion Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_calificacion.IdUsua WHERE tblp_calificacion.IdCiclo =  '$IdCiclo' AND tblc_usuario.IdCampus =  '$IdCampus' AND tblc_usuario.IdGrupo =  '$IdGrupo' AND tblp_calificacion.IdModulo =  '$IdModulo' ORDER BY tblc_usuario.APaterno ASC");

  $sql2 = $db->query("SELECT tblc_modulousuario.IdModUsua FROM tblc_modulousuario WHERE tblc_modulousuario.IdUsua = '$IdUsua' AND tblc_modulousuario.IdModulo = '51'");
  $db->rows($sql2);
  $datos21 = $db->recorrer($sql2);
  $_mod51 = $datos21["IdModUsua"];
  ?>
  <div class="box-header">
    <h3 class="box-title"><i class="fa fa-fw fa-toggle-right"></i> Calificación final de los alumnos</h3>

  </div>
  <div class="box-body">
    <div class="bg-maroon-active color-palette" style="padding: 8px;"><span style="color: yellow;"><i class="fa fa-fw fa-bookmark"></i> <?php echo $_mod["NombreMod"]; ?> </span></div>
    <table class="table table-striped">
      <tbody>
        <tr style="background: #a6a6a6;">
          <th>#</th>
          <th>USUARIO</th>
          <th>NOMBRE DEL ALUMNO</th>
          <th style="width: 150px; text-align: center;">PROMEDIO</th>
        </tr>

      <?php $idAsig = ''; $idTipo = 0; $v = 0; $i = 0; $f = 0; while($mat = $db->recorrer($sql_mat)){ $idAsig = $mat['IdAsignacion']; $idTipo = $mat['IdTipo']; ?>
      <tr>
        <td><b><?php echo $v = ($v + 1); ?>.- </b></td>
        <td><?php echo $mat['Usuario']; ?></td>
        <td><?php echo $mat['APaterno'].' '.$mat['AMaterno'].' '.$mat['Nombre'];  ?></td>
        <td style="text-align: center;">
        <?php if(isset($_mod51)){ ?>
        <div class="input-group input-group-sm">
          <input type="number" style="text-align: center;" class="form-control" name="txtFolio-<?php echo $mat["IdCalificacion"]; ?>" id="txtFolio-<?php echo $mat["IdCalificacion"]; ?>" value="<?php if(isset($mat["Promedio"])){ echo $mat["Promedio"]; }?>" >
            <span class="input-group-btn">
              <button onclick="saveFolio(<?php echo $mat["IdCalificacion"]; ?>, 1)" type="button" class="btn btn-info btn-flat"><i class="fa fa-fw fa-save"></i></button>
            </span>
          </div><?php } else { ?>
            <input type="text" style="text-align: center;" class="form-control" disabled value="<?php echo $mat["Promedio"]; ?>" >
          <?php } ?>
        </td>
      </tr><?php } ?>
    </tbody></table>
    <div class="box-footer clearfix">
      <input id="IdAsignacion" name="IdAsignacion" value="<?php echo $idAsig;?>" type="hidden"/>
      <button onClick="window.open('repositorio/portafolio/reporte_acta.php?tokenId=<?php echo $idAsig; ?>','_blank'), cargar_lista_alumnos()" href="javascript:void(0);" title="Acta de calificación del docente" type="button" class="pull-right btn bg-maroon btn-flat margin">Acta de calificación <i class="fa fa-fw fa-file-pdf-o"></i></button>
      <button onClick="window.open('repositorio/portafolio/actaPromedio.php?tokenId=<?php echo $idAsig; ?>','_blank'), cargar_lista_alumnos()" href="javascript:void(0);" title="Acta de calificación del docente" type="button" class="pull-right btn bg-purple btn-flat margin">Acta con promedio<i class="fa fa-fw fa-file-pdf-o"></i></button>
      <?php //if($idTipo == 3){ ?>
        <button onclick="cargar_lista_asistencia()" href="javascript:void(0);" title="Vista del pase de lista" type="button" class="pull-right btn bg-navy btn-flat margin">Asistencia <i class="fa fa-fw fa-edit"></i></button>
      <?php //} ?>
    </div>
  </div>
  <div class="box-header">
    <h3 class="box-title"><i class="fa fa-fw fa-map-signs"></i> Promedio general por materia del grupo</h3>
  </div>
  <div class="box-body">
    <div class="bg-purple-active color-palette" style="padding: 8px;"><span style="color: yellow;"><b><i class="fa fa-fw fa-check-square-o"></i> CICLO ESCOLAR: </b></span><?php echo $_cic["Ciclo"]; ?></div>
    <table class="table table-striped">
      <tbody>
        <tr style="background: #a6a6a6;">
          <th>SIGLA</th>
          <th>NOMBRE DE LA MATERIA</th>
          <th style="text-align: center;">PROMEDIO</th>
        </tr>

      <?php $sx = 0; $vx = 0; while($matx = $db->recorrer($sql_mat_lsta)){ $vx = ($vx + 1); ?>
      <tr>
        <td><?php echo $matx['CodeModulo']; ?></td>
        <td><?php echo $matx['NombreMod']; ?></td>
        <td style="text-align: center;"><?php echo $matx['Promedio'];  ?></td>
      </tr><?php $sx = ($sx + $matx['Promedio']); } $promx = ($sx / $vx); ?>
      <tr>
        <td colspan="2" style="text-align: right;"><b>PROMEDIO GENERAL DEL GRUPO EN EL CICLO ESCOLAR:</b></td>
        <td style="text-align: center;"><b><?php echo number_format($promx, 1, '.', ',');  ?></b></td>
      <tr>
    </tbody></table>
    <div class="box-footer clearfix">
      <?php $_px = number_format($promx, 1, '.', ',');
      $insertar = $db->query("UPDATE tblc_ciclogrupo SET tblc_ciclogrupo.Promedio = '$_px' WHERE tblc_ciclogrupo.IdCiclo = '$IdCiclo' AND tblc_ciclogrupo.IdGrupo = '$IdGrupo'"); ?>
        <button onClick="window.open('repositorio/portafolio/promedioGrupo.php?idCiclo=<?php echo $IdCiclo; ?>&idGrupo=<?php echo $IdGrupo; ?>','_blank')" href="javascript:void(0);" title="Acta de calificación del docente" type="button" class="pull-right btn bg-maroon btn-flat margin">Imprimir <i class="fa fa-fw fa-file-pdf-o"></i></button>
    </div>
  </div>
