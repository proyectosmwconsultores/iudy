<?php
session_start();
require('../php/clases/class.System.php');
$db = new Conexion();
$st = $_POST['Tipo'];
$IdMod = $_POST['IdMod'];
$sql_mod = $db->query("SELECT * FROM tblx_modulo WHERE tblx_modulo.IdTipoEva = '$st'");
// $sql_bloq = $db->query("SELECT * FROM tblx_bloque WHERE tblx_bloque.IdMod = '$IdMod'");
  ?>
  <form name="frm2sFr" id="frm2sFr" action="updFuente.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="TipoGuardar" id="TipoGuardar" value="addPreguts">
    <input type="hidden" name="Tipo" id="Tipo" value="<?php echo $_POST['Tipo']; ?>">

  <div class="table-responsive">
    <table class="table table-bordered">
      <div class="box box-primary" style="border-top: none;">
        <div class="box-body">
          <div class="col-md-12">
            <div class="form-group">
              <label>Seleccione el módulo:</label>
              <select name="txt_modx" id="txt_modx" class="form-control">
                <option value="">- Seleccione - </option>
                <?php while($mod = $db->recorrer($sql_mod)){ ?>
                <option value="<?php echo $mod['IdMod']; ?>" <?php if($IdMod==$mod['IdMod']){ ?>selected="selected"<?php } ?>><?php echo $mod['Nombre_mod']; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label>Escriba la pregunta:</label>
              <input name="txtNombre" id="txtNombre" class="form-control">
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label>Tipo de pregunta:</label>
              <select class="form-control" name="txtTipoP" id="txtTipoP">
                <option value=""> - Seleccione - </option>
                <option value="1"> Opción múltiple </option>
                <option value="2"> Abierto </option>
              </select>
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fa fa-fw fa-times-circle"></i> Cancelar</button>
          <button type="button" class="btn btn-primary pull-right" onClick="addPregtsx_id()"> <i class="fa fa-fw fa-save"></i> Guardar</button>
        </div>
      </div>
    </table>
  </div>

  </form>
