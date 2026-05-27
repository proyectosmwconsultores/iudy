<?php
session_start();
require('../php/clases/class.System.php');
$db = new Conexion();
$IdTipo = $_POST["IdTipo"];

$sql9 = $db->query("SELECT * FROM tblc_tipoevaluacion WHERE tblc_tipoevaluacion.IdTipoEvaluacion = '$IdTipo' ");
$db->rows($sql9);
$datos91 = $db->recorrer($sql9);

  ?>
  <form name="frm2srx" id="frm2srx" action="updCampus.php" method="POST" enctype="multipart/form-data">
    <input id="IdTipo" name="IdTipo" value="<?php echo $IdTipo; ?>" type="hidden"/>
    <input id="TipoGuardar" name="TipoGuardar" value="updEvals" type="hidden"/>


  <div class="table-responsive">
    <table class="table table-bordered">
      <div class="box box-primary" style="border-top: none;">
        <div class="box-body">
          <div class="col-md-12">
            <div class="form-group">
              <label>Nombre de la evaluación:</label>
                <input type="text" name="txtTipo" id="txtTipo" class="form-control" value="<?php echo $datos91["Evaluacion"]; ?>">
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label>Evaluación para:</label>
              <select class="form-control" name="txtPermiso" id="txtPermiso">
                <option value="1" <?php if($datos91["Cve"] == 1){ ?>selected="selected"<?php } ?>> Encuesta de satisfacción académica </option>
                <option value="2" <?php if($datos91["Cve"] == 2){ ?>selected="selected"<?php } ?>> Encuesta de egreso </option>
              </select>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label>Estatus:</label>
              <select class="form-control" name="txtEstatus" id="txtEstatus">
                <option value="8" <?php if($datos91["IdEstatus"] == 8){ ?>selected="selected"<?php } ?>> ACTIVO </option>
                <option value="9" <?php if($datos91["IdEstatus"] == 9){ ?>selected="selected"<?php } ?>> INACTIVO </option>
              </select>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fa fa-fw fa-times-circle"></i> Cancelar</button>
          <button type="button" class="btn btn-primary pull-right" onClick="updEvals()"> <i class="fa fa-fw fa-refresh"></i> Actualizar</button>
        </div>
      </div>
    </table>
  </div>

  </form>
