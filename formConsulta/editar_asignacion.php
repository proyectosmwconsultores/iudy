<?php
include('../hace.php');
if(isset($_POST["employee_id"])){
  $output = '';
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdAsignacion = $_POST["employee_id"];

  $sql6 = $db->query("SELECT tblp_asignacion.IdAsignacion, tblp_asignacion.FecIni, tblp_asignacion.FecFin, tblp_asignacion.IdGrupo, tblp_asignacion.IdUsua, tblc_ciclo.Ciclo, tblp_modulo.CodeModulo, tblp_modulo.NombreMod FROM tblp_asignacion Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblp_asignacion.IdCiclo Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo WHERE tblp_asignacion.IdAsignacion = '$IdAsignacion' AND tblp_asignacion.Tipo = '2' ");
  $db->rows($sql6);
  $datos61 = $db->recorrer($sql6);

  $sql7 = $db->query("SELECT tblp_asignacion.IdUsua FROM tblp_asignacion WHERE tblp_asignacion.IdAsignacion = '$IdAsignacion' AND tblp_asignacion.Tipo = '4' ");
  $db->rows($sql7);
  $datos71 = $db->recorrer($sql7);


  $sql_docente = $db->query("SELECT tblc_usuario.IdUsua, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno FROM tblc_usuario WHERE tblc_usuario.Permisos = '2' ORDER BY tblc_usuario.Nombre ASC");
  $sql_coordi = $db->query("SELECT tblc_usuario.IdUsua, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno FROM tblc_usuario WHERE tblc_usuario.IdEstatus= '8' AND ((tblc_usuario.Permisos = '9') || (tblc_usuario.Permisos = '5')) ORDER BY tblc_usuario.Nombre ASC");

  ?>
  <form name="frm2" id="frm2" action="addActividad.php" method="POST" enctype="multipart/form-data" class="form-horizontal">
    <input id="IdAsignacion" name="IdAsignacion" value="<?php echo $IdAsignacion; ?>" type="hidden"/>
              <div class="box-body">
                <div class="form-group">
                  <label class="col-sm-4 control-label">Periodo escolar:</label>
                  <div class="col-sm-8">
                    <input disabled type="text" class="form-control" value="<?php echo $datos61["Ciclo"]; ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-4 control-label">Materia:</label>
                  <div class="col-sm-8">
                    <input disabled type="text" class="form-control" value="<?php echo $datos61["NombreMod"]; ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-4 control-label">Nombre del docente:</label>
                  <div class="col-sm-8">
                    <select class="form-control" name="txt_IdUsua" id="txt_IdUsua">
                      <option value=""> - Seleccione docente - </option>
                    <?php while($_docente = $db->recorrer($sql_docente)){ ?>
                    <option value="<?php echo $_docente['IdUsua']; ?>" <?php if($datos61["IdUsua"]==$_docente['IdUsua']){ ?>selected="selected"<?php } ?>> <?php echo $_docente['Nombre'].' '.$_docente['APaterno'].' '.$_docente['AMaterno']; ?> </option>
                    <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-4 control-label">Coordinador académico:</label>
                  <div class="col-sm-8">
                    <select class="form-control" name="txt_coordi" id="txt_coordi">
                      <option value=""> - Seleccione coordinador académico - </option>
                    <?php while($_coordi = $db->recorrer($sql_coordi)){ ?>
                    <option value="<?php echo $_coordi['IdUsua']; ?>" <?php if($datos71["IdUsua"]==$_coordi['IdUsua']){ ?>selected="selected"<?php } ?>> <?php echo $_coordi['Nombre'].' '.$_coordi['APaterno'].' '.$_coordi['AMaterno']; ?> </option>
                    <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-8 control-label">Fecha inicial:</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" id="datepicker1x" name="datepicker1x" value="<?php echo $datos61["FecIni"]; ?>" >
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-8 control-label">Fecha final:</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" id="datepicker2x" name="datepicker2x" value="<?php echo $datos61["FecFin"]; ?>" >
                  </div>
                </div>
                <div class="box-footer">
                <button data-dismiss="modal" class="btn btn-warning"> <i class="fa fa-close"></i> Cancelar</button>
                <button type="button" onclick="upd_asignacion_id('<?php echo $IdAsignacion; ?>')" class="btn btn-primary pull-right"> <i class="fa fa-refresh"></i> Actualizar</button>
              </div>
              </div>
        </form>
        <script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
        <script>
          $(function () {
            //Date picker
            $('#datepicker1x').datepicker({
              autoclose: true
            })
          //Date picker
            $('#datepicker2x').datepicker({
              autoclose: true
            })

          })
        </script>
  <?php
}
?>
