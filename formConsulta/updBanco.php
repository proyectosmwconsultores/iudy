<?php

  require('../php/clases/class.System.php');
  $db = new Conexion();
  $sql9 = $db->query("SELECT * FROM tblc_bancos WHERE tblc_bancos.IdBanco = '".$_POST["employee_id"]."'");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);
  ?>
  <form name="frm2" id="frm2" action="addBanco.php" method="POST" enctype="multipart/form-data">
    <input id="IdBanco" name="IdBanco" value="<?php echo $_POST["employee_id"]; ?>" type="hidden"/>
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
              <input type="text" class="form-control pull-right" id="txtNombre" name="txtNombre" value="<?php echo $datos91["Nombre"]; ?>">
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
              <input type="text" class="form-control pull-right" id="txtBanco" name="txtBanco" value="<?php echo $datos91["Banco"]; ?>">
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
              <input type="text" class="form-control pull-right" id="txtConvenio" name="txtConvenio" value="<?php echo $datos91["Convenio"]; ?>">
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
              <input type="text" class="form-control pull-right" id="txtCuenta"name="txtCuenta" value="<?php echo $datos91["NoCuenta"]; ?>">
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
              <input type="text" class="form-control pull-right" id="txtClabe" name="txtClabe" value="<?php echo $datos91["Clabe"]; ?>">
            </div>
          </div>
        </div></div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancelar</button>
          <?php if($datos91["IdEstatus"] == 8){ ?>
          <button type="button" class="btn btn-danger pull-left" onClick="EstatusBanco(9)">Dar de baja esta cuenta</button>
          <?php } else { ?>
            <button type="button" class="btn btn-success pull-left" onClick="EstatusBanco(8)">Activar esta cuenta</button>
          <?php }  ?>
          <button type="button" class="btn btn-primary" onClick="updateBanco()">Actualizar cuenta</button>
        </div>
      </div>
    </table>
  </div>

  </form>
