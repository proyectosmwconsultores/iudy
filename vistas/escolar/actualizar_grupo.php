<?php session_start();
include('../../hace.php');
if(isset($_POST["employee_id"])){
  $output = '';
  require('../../php/clases/class.System.php');
  $db = new Conexion();
  $IdGrupo = $_POST["employee_id"];
  $total = 0;

  $sql6 = $db->query("SELECT tblp_grupo.IdGrupo, tblp_grupo.Disponible, tblp_grupo.CveGrupo, tblp_grupo.Estatus, tblp_grupo.FechaIni, tblp_grupo.FechaFin, tblp_grupo.Turno, tblp_grupo.Grupo, tblp_grupo.Modalidad, tblp_grupo.Periodo, tblp_grupo.IdEstatus, tblp_educativa.Nombre, tblc_campus.Campus, tblc_ciclo.Tipo, tblc_ciclo.Ciclo, tblc_dias_clases._Dias, tblc_modalidad._Modalidad FROM tblp_grupo Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_grupo.IdOferta Left Join tblc_campus ON tblc_campus.IdCampus = tblp_grupo.IdCampus Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_grupo.IdCicloIni Left Join tblc_dias_clases ON tblc_dias_clases.Dia = tblp_grupo.Dia Left Join tblc_modalidad ON tblc_modalidad.Mod = tblp_grupo.Modalidad WHERE tblp_grupo.IdGrupo = '$IdGrupo' ");
  $db->rows($sql6);
  $datos61 = $db->recorrer($sql6);
  $estatus = $datos61["Estatus"];
  $CveGrupo = $datos61["CveGrupo"];

  $sql5 = $db->query("SELECT Count(tblc_usuario.IdUsua) AS Total FROM tblc_usuario WHERE tblc_usuario.IdGrupo =  '$IdGrupo' GROUP BY tblc_usuario.IdGrupo ");
  $db->rows($sql5);
  $datos51 = $db->recorrer($sql5);
  $total = isset($datos51["Total"]);
  if($total){ $total= $total; } else { $total = 0; }

  $_ide = $datos61["IdEstatus"];


$sql_user = $db->query("SELECT
tblc_usuario.IdUsua,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.Usuario,
tblc_estatus.Estatus,
tblc_campus.Campus,
tblp_grupo.CveGrupo
FROM
tblc_usuario
Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_usuario.IdEstatus
Left Join tblc_campus ON tblc_campus.IdCampus = tblc_usuario.IdCampus
Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_usuario.IdGrupo
WHERE
tblc_usuario.IdGrupo =  '$IdGrupo '
ORDER BY
tblc_usuario.APaterno ASC, tblc_usuario.AMaterno ASC
");

  ?>
  <form name="frm22" id="frm22" action="updGrupo.php" method="POST" enctype="multipart/form-data" class="form-horizontal">

    <input id="IdGrupo" name="IdGrupo" value="<?php echo $IdGrupo; ?>" type="hidden"/>
              <div class="box-body">
                <div class="form-group">
                  <label class="col-sm-4 control-label">Oferta educativa:</label>
                  <div class="col-sm-8">
                    <input type="text" disabled class="form-control"  value="<?php echo $datos61["Nombre"]; ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-4 control-label">Campus:</label>
                  <div class="col-sm-8">
                    <input type="text" disabled class="form-control"  value="<?php echo $datos61["Campus"]; ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-4 control-label">Periodo inicial:</label>
                  <div class="col-sm-8">
                    <input type="text" disabled class="form-control"  value="<?php echo $datos61["Tipo"].' - '.$datos61["Ciclo"]; ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-4 control-label">Disponible para inscripción:</label>
                  <div class="col-sm-8">
                    <select class="form-control" name="txtDisponible" id="txtDisponible">
                      <option value="SI" <?php if($datos61["Disponible"] == 'SI' ){ ?>selected="selected"<?php } ?>> SI </option>
                      <option value="NO" <?php if($datos61["Disponible"] == 'NO' ){ ?>selected="selected"<?php } ?>> NO </option>
                    </select>
                  </div>
                </div>
                <div class="bg-navy-active color-palette" style="padding: 5px;"><span><i class="fa fa-fw fa-bookmark-o"></i> <?php echo $datos61["CveGrupo"]; ?> - <?php echo $datos61["_Modalidad"]; ?> - <?php echo $datos61["_Dias"]; ?></span></div>
                <br>
                <div class="form-group">
                  <label class="col-sm-2 control-label">Generación:</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" id="txtPeriodoX" name="txtPeriodoX" value="<?php echo $datos61["Periodo"]; ?>" >
                  </div>
                  <label class="col-sm-2 control-label">Estatus:</label>
                  <div class="col-sm-4">
                    <select class="form-control" name="txtEstatus" id="txtEstatus">
                      <option>- Seleccione -</option>
                      <?php if($_ide == 12){ ?>
                        <option value="12" <?php if($datos61["IdEstatus"] == 12 ){ ?>selected="selected"<?php } ?>> En captura </option>
                      <option value="8" <?php if($datos61["IdEstatus"] == 8 ){ ?>selected="selected"<?php } ?>> Activo </option>
                      <?php } ?>
                      <?php if($_ide == 8){ ?>
                      <option value="8" <?php if($datos61["IdEstatus"] == 8 ){ ?>selected="selected"<?php } ?>> Activo </option>
                      <option value="55" <?php if($datos61["IdEstatus"] == 55 ){ ?>selected="selected"<?php } ?>> Graduado </option>
                      <?php } ?>
                      <?php if($_ide == 55){ ?>
                      <option value="55" <?php if($datos61["IdEstatus"] == 55 ){ ?>selected="selected"<?php } ?>> Graduado </option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">Ingreso:</label>
                  <div class="col-sm-4">
                    <input type="text" name="txtFeInix" id="txtFeInix" class="form-control" value="<?php echo $datos61["FechaIni"]; ?>">
                  </div>
                  <label class="col-sm-2 control-label">Egreso:</label>
                  <div class="col-sm-4">
                    <input type="text" name="txtFeFinx" id="txtFeFinx" class="form-control" value="<?php echo $datos61["FechaFin"]; ?>">
                  </div>
                </div>

                <div class="box-footer">
                  <button type="button" onclick="javascript:window.open('repositorio/portafolio/alumnosGrupo.php?tokenId=<?php echo time().$IdGrupo; ?>');" href="javascript:void(0);" title="Descargar lista de alumnos del grupo" class="btn btn-success pull-left"> <i class="fa fa-table"></i> Lista de alumnos</button>
                    <?php if($total == 0){ ?><button type="button" style="margin-left: 5px;" onclick="delGrupoId(<?php echo $IdGrupo; ?>)" href="javascript:void(0);" title="Eliminar grupo" class="btn btn-danger pull-left"> <i class="fa fa-trash"></i> Eliminar grupo</button> <?php } ?>
                    <button type="button" onclick="updGrupoP()" class="btn btn-primary pull-right" style="margin-right: 5px;"> <i class="fa fa-save"></i> Guardar</button>
                <br><br>

              </div>

              <div class="bg-navy color-palette" style="padding: 5px;"><span><i class="fa fa-fw fa-user-plus"></i> Lista de alumnos capturados en el grupo.</span></div>

              <table class="table table-striped" style="font-size: 12px;">
                <tbody>
                  <tr>
                    <th>#</th>
                    <th>No.CONTROL</th>
                    <th>NOMBRE</th>
                    <th>ESTATUS</th>
                  </tr>
                <?php $v = 0; while($x = $db->recorrer($sql_user)){ ?>
                <tr>
                  <td><b><?php echo $v = ($v + 1); ?>.- </b></td>
                  <td><?php echo $x['Usuario']; ?></td>
                  <td><?php echo $x['APaterno'].' '.$x['AMaterno'].' '.$x['Nombre']; ?></td>
                  <td><?php echo $x['Estatus']; ?></td>
                </tr><?php } ?>
              </tbody></table>


              </div>
        </form>
        <script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
        <script>
        $(function () {
          //Date picker
          $('#txtFeInix').datepicker({
            autoclose: true
          })

          $('#txtFeFinx').datepicker({
            autoclose: true
          })
        })
        </script>
  <?php
}
?>
