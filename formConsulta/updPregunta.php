<?php
session_start();
require('../php/clases/class.System.php');
$db = new Conexion();
$IdPregunta = $_POST["IdPregunta"];

$sql9 = $db->query("SELECT * FROM tblx_pregunta WHERE tblx_pregunta.IdPregunta = '$IdPregunta' ");
$db->rows($sql9);
$datos91 = $db->recorrer($sql9);

  ?>
  <form name="frm2sr" id="frm2sr" action="updCampus.php" method="POST" enctype="multipart/form-data">
    <input id="IdPregunta" name="IdPregunta" value="<?php echo $IdPregunta; ?>" type="hidden"/>
    <input id="Tipo" name="Tipo" value="<?php echo $datos91["Tipo"]; ?>" type="hidden"/>
    <input id="TipoGuardar" name="TipoGuardar" value="updPreguts" type="hidden"/>


  <div class="table-responsive">
    <table class="table table-bordered">
      <div class="box box-primary" style="border-top: none;">
        <div class="box-body">
          <div class="col-md-12">
            <div class="form-group">
              <label>Nombre de la pregunta:</label>
              <textarea name="txtPregunta" id="txtPregunta" class="form-control" rows="3" placeholder="Enter ..."><?php echo $datos91["Pregunta"]; ?></textarea>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label>Estatus:</label>
              <select class="form-control" name="txtEstatus" id="txtEstatus">
                <option value="8" <?php if($datos91["IdEstatus"] == 8){ ?>selected="selected"<?php } ?>> Activo </option>
                <option value="9" <?php if($datos91["IdEstatus"] == 9){ ?>selected="selected"<?php } ?>> Inactivo </option>
              </select>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fa fa-fw fa-times-circle"></i> Cancelar</button>
          <button type="button" class="btn btn-primary pull-right" onClick="updEPregs()"> <i class="fa fa-fw fa-refresh"></i> Actualizar</button>
        </div>
      </div>
    </table>
  </div>

  </form>
