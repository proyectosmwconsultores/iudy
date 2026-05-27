<?php
session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();
  ?>
  <form name="frm2" id="frm2" action="addBanco.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="IdCampus" id="IdCampus" value="<?php echo $_SESSION['IdCampus']; ?>">
  <div class="table-responsive">
    <table class="table table-bordered">
      <div class="box box-primary" style="border-top: none;">
        <div class="box-body">
        <div class="col-md-12">
          <div class="form-group">
            <label>Nombre:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-black-tie"></i>
              </div>
              <input type="text" class="form-control pull-right" id="txtNombre" name="txtNombre" >
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="form-group">
            <label>Nombre del banco:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-cc-diners-club"></i>
              </div>
              <input type="text" class="form-control pull-right" id="txtBanco" name="txtBanco">
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>Convenio:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-cc-diners-club"></i>
              </div>
              <input type="text" class="form-control pull-right" id="txtConvenio" name="txtConvenio">
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="form-group">
            <label>No. Cuenta</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-qrcode"></i>
              </div>
              <input type="text" class="form-control pull-right" id="txtCuenta"name="txtCuenta">
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="form-group">
            <label>Clabe interbancaria:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-qrcode"></i>
              </div>
              <input type="text" class="form-control pull-right" id="txtClabe" name="txtClabe">
            </div>
          </div>
        </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-primary" onClick="saveBanco()">Guardar cuenta</button>
        </div>
      </div>
    </table>
  </div>

  </form>
