<?php
include('../hace.php');
if(isset($_POST["employee_id"])){
  $output = '';
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdRvoe = $_POST["employee_id"];

  $sql9 = $db->query("SELECT
tblp_rvoe.IdRvoe,
tblp_rvoe.IdEducativa,
tblp_rvoe.IdCampus,
tblp_rvoe.Rvoe,
tblp_rvoe.Vigencia,
tblp_rvoe.Turno,
tblp_rvoe.Clave,
tblp_rvoe.Modalidad,
tblp_rvoe.Escuela,
tblp_rvoe.Localidad,
tblp_rvoe.Clave_dgp,
tblp_educativa.Nombre,
tblc_campus.Campus
FROM
tblp_rvoe
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_rvoe.IdEducativa
Left Join tblc_campus ON tblc_campus.IdCampus = tblp_rvoe.IdCampus WHERE tblp_rvoe.IdRvoe = '$IdRvoe'");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);
  $Vigencia = $datos91["Vigencia"];
  $Turno = $datos91["Turno"];
  $Modalidad = $datos91["Modalidad"];
  $Nombre = $datos91["Nombre"];
  $Campus = $datos91["Campus"];

  ?>
  <form name="frm22" id="frm22" action="addRvoe.php" method="POST" enctype="multipart/form-data" class="form-horizontal">

              <div class="box-body">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Oferta educativa:</label>
                  <div class="col-sm-8">
                    <input type="text" disabled class="form-control"  value="<?php echo $Nombre; ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Campus:</label>
                  <div class="col-sm-8">
                    <input type="text" disabled class="form-control"  value="<?php echo $Campus; ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Rvoe:</label>

                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="txtRvoe" name="txtRvoe" value="<?php echo $datos91["Rvoe"]; ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-4 control-label">Clave Superior:</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="txtClave" name="txtClave" value="<?php echo $datos91["Clave"]; ?>" >
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-4 control-label">Clave DGP:</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="txtClave_dgp" name="txtClave_dgp" value="<?php echo $datos91["Clave_dgp"]; ?>" >
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-4 control-label">Vigencia:</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="txtVigencia" name="txtVigencia" value="<?php echo $datos91["Vigencia"]; ?>" >
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-4 control-label">Turno:</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="txtTurno" name="txtTurno" value="<?php echo $datos91["Turno"]; ?>" >
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-4 control-label">Modalidad:</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="txtModalidad" name="txtModalidad" value="<?php echo $datos91["Modalidad"]; ?>" >
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-4 control-label">Escuela:</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="txtEscuela" name="txtEscuela" value="<?php echo $datos91["Escuela"]; ?>" >
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-4 control-label">Localidad:</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="txtLocalidad" name="txtLocalidad" value="<?php echo $datos91["Localidad"]; ?>" >
                  </div>
                </div>
                <div class="box-footer">
                <button data-dismiss="modal" class="btn btn-warning"> <i class="fa fa-close"></i> Cancelar</button>
                <button type="button" onclick="addRvoe(<?php echo $IdRvoe; ?>)" class="btn btn-primary pull-right"> <i class="fa fa-save"></i> Guardar</button>
              </div>
              </div>
        </form>
  <?php
}
?>
