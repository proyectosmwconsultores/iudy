<?php
  session_start();
  $IdUsua = $_SESSION['IdUsua'];
  require('../../php/clases/class.System.php');
  require('../../hace.php');
  $db = new Conexion();
  $IdCiclo = $_POST['IdCiclo'];
  $IdGrupo = $_POST['IdGrupo'];


  $porciones = explode("_", $IdGrupo);
  $Grado =  $porciones[0]; // porción1
  $IdGrupo = $porciones[1]; // porción2

  $sql_lsta = $db->query("SELECT tblc_usuario.IdUsua, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.Usuario, tblc_usuario.AMaterno, tblc_usuario.Celular, tblc_usuario.Correo, tblc_usuario.IdEstatus, tblc_usuario.Sexo, tblp_educativa.IdGrado, tblc_usuario.IdOferta, tblp_educativa.Nombre AS NomEducativa, tblp_grupo.CveGrupo, tblc_estatus.Estatus, tblp_informacion.P_curp FROM tblc_usuario Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_usuario.IdGrupo Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_usuario.IdEstatus Left Join tblp_informacion ON tblp_informacion.IdUsua = tblc_usuario.IdUsua WHERE  tblc_usuario.IdGrupo = '$IdGrupo' AND tblc_usuario.IdEstatus= '8' ");

  $sql_cic = $db->query("SELECT tblc_ciclo.Ciclo FROM tblc_ciclo WHERE tblc_ciclo.IdCiclo = '$IdCiclo'");
  $db->rows($sql_cic);
  $_cic = $db->recorrer($sql_cic);

  $sql_grp = $db->query("SELECT tblp_grupo.CveGrupo, tblc_modalidad._Modalidad, tblc_dias_clases._Dias, tblp_grupo.TipoCiclo FROM tblp_grupo Left Join tblc_modalidad ON tblc_modalidad.`Mod` = tblp_grupo.Modalidad Left Join tblc_dias_clases ON tblc_dias_clases.Dia = tblp_grupo.Dia WHERE tblp_grupo.IdGrupo = '$IdGrupo'");
  $db->rows($sql_grp);
  $_grp = $db->recorrer($sql_grp);
  if($_grp['TipoCiclo'] == 'C') { $_txG = 'CUATRIMESTRE'; } else { $_txG = 'SEMESTRE'; }

  $sql_mat_asig = $db->query("SELECT
tblp_asignacion.IdAsignacion,
tblp_asignacion.IdEducativa,
tblp_asignacion.IdModulo,
tblp_asignacion.IdUsua,
tblp_asignacion.FecIni,
tblp_asignacion.FecFin,
tblp_asignacion.IdCiclo,
tblp_modulo.CodeModulo,
tblp_modulo.NombreMod,
tblp_modulo.Oferta,
tblp_modulo.Grado,
tblc_abreviatura.Abreviatura,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_estatus.IdEstatus,
tblc_estatus.Estatus
FROM
tblp_asignacion
Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo
Left Join tblc_abreviatura ON tblc_abreviatura.Id = tblp_modulo.Grado
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_asignacion.IdUsua
Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblp_asignacion.IdEstatus
WHERE tblp_asignacion.Tipo =  '2' AND tblp_asignacion.IdCiclo = '$IdCiclo' AND tblp_asignacion.IdGrupo ='$IdGrupo'
ORDER BY
tblp_asignacion.FecIni ASC");
  ?>

  <div class="box-body">
    <div class="bg-purple-active color-palette" style="padding: 8px;"><span style="color: yellow;"><b><i class="fa fa-fw fa-check-square-o"></i> PERIODO ESCOLAR: </b></span><?php echo $_cic["Ciclo"]; ?> (<?php echo $_txG; ?> - <?php echo $_grp['_Modalidad'] ?> - <?php echo $_grp['_Dias'] ?>)</div>
    <br>

    <table id="example" class="table table-striped table-bordered table-hover dataTables-example" style="font-size: 12px;" >
      <thead>
        <tr>
          <th>Ajustes</th>
          <th>Materia</th>
          <th>Fecha</th>
          <th>Docente</th>
          <th>Estatus</th>
        </tr>
      </thead>
      <tbody>
        <?php $col = ''; while($matx = $db->recorrer($sql_mat_asig)){ ?>
        <tr>
          <td>
            <button onclick="mostrar_seguimiento('<?php echo $matx["IdAsignacion"]; ?>')" title="Seguimiento de la planeación académica" type="button" class="btn bg-maroon btn-flat btn-sm" href="javascript:void(0);" style="float: center;"><i class="fa fa-eye"></i></button>
          </td>
          <td><?php echo $matx["CodeModulo"].' '.$matx["NombreMod"]; ?></td>
          <td><?php echo fecha_pago($matx["FecIni"]).' al '.fecha_pago($matx["FecFin"]); ?></td>
          <td><?php echo $matx["Nombre"].' '.$matx["APaterno"].' '.$matx["AMaterno"]; ?></td>
          <td><?php echo $matx["Estatus"]; ?></td>
        </tr>
        <?php } ?>
      </tfoot>
    </table>
  </div>
