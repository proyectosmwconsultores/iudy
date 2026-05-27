<?php
session_start();
require('../php/clases/class.System.php');
$db = new Conexion();
$IdParcialDoc = $_POST["IdParcial"];


$sql9 = $db->query("SELECT * FROM tblp_parcialdocente WHERE tblp_parcialdocente.IdParcialDocente = '$IdParcialDoc' ");
$db->rows($sql9);
$datos91 = $db->recorrer($sql9);
$IdAs =  $datos91["IdAsignacion"];

  ?>
  <form name="frm2" id="frm2" action="addAsignatura.php" method="POST" enctype="multipart/form-data">
    <input id="IdUsua" name="IdUsua" value="<?php echo $_SESSION["IdUsua"]; ?>" type="hidden"/>
    <input id="IdPermiso" name="IdPermiso" value="<?php echo $_SESSION["Permisos"]; ?>" type="hidden"/>

  <div class="table-responsive">
    <table class="table table-bordered">
      <div class="box box-primary" style="border-top: none;">
        <div class="box-body">
        <div class="col-md-12">
          <div class="form-group">
            <label>IdAsignatura:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-qrcode"></i>
              </div>
              <input type="text" class="form-control pull-right" id="txtCodeModulo" name="txtCodeModulo">
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="form-group">
            <label>Nombre de la asignatura:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-cc-diners-club"></i>
              </div>
              <input type="text" class="form-control pull-right" id="txtAsignatura" name="txtAsignatura">
            </div>
          </div>
        </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-primary" onClick="addAsignaturaT()">Agregar</button>
        </div>
      </div>
    </table>
  </div>

  </form>
