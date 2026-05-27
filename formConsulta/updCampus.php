<?php
session_start();
require('../php/clases/class.System.php');
$db = new Conexion();
$IdCampus = $_POST["IdCampus"];

$sql9 = $db->query("SELECT * FROM tblc_campus WHERE tblc_campus.IdCampus = '$IdCampus' ");
$db->rows($sql9);
$datos91 = $db->recorrer($sql9);

  ?>
  <form name="frm2sr" id="frm2sr" action="updCampus.php" method="POST" enctype="multipart/form-data">
    <input id="IdCampus" name="IdCampus" value="<?php echo $IdCampus; ?>" type="hidden"/>
    <input id="TipoGuardar" name="TipoGuardar" value="updCampuss" type="hidden"/>


  <div class="table-responsive">
    <table class="table table-bordered">
      <div class="box box-primary" style="border-top: none;">
        <div class="box-body">
          <div class="col-md-12">
            <div class="form-group">
              <label>Nombre del campus:</label>
                <input type="text" name="txCampus" id="txCampus" class="form-control" value="<?php echo $datos91["Campus"]; ?>">
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label>Nombre público del campus:</label>
                <input type="text" name="txDireccion" id="txDireccion" class="form-control" value="<?php echo $datos91["Texto"]; ?>">
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
          <button type="button" class="btn bg-maroon btn-flat pull-right" onClick="upddCampus()"> <i class="fa fa-fw fa-refresh"></i> Actualizar</button>
        </div>
      </div>
    </table>
  </div>

  </form>
  <script>
  $(function () {

    //bootstrap WYSIHTML5 - text editor
    $('.textarea').wysihtml5()
  })
  </script>
