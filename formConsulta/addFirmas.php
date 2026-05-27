<?php
include('../hace.php');
if(isset($_POST["employee_id"])){
  $output = '';
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdGrupo = $_POST["employee_id"];

  $sql6 = $db->query("SELECT * FROM tblp_grupo WHERE tblp_grupo.IdGrupo = '$IdGrupo' ");
  $db->rows($sql6);
  $datos61 = $db->recorrer($sql6);
  $IdCampus = $datos61["IdCampus"];
  $IdOferta = $datos61["IdOferta"];

  $sql5 = $db->query("SELECT tblp_educativa.IdGrado FROM tblp_educativa WHERE tblp_educativa.IdEducativa = '$IdOferta' ");
  $db->rows($sql5);
  $datos51 = $db->recorrer($sql5);
  $IdGrado = $datos51["IdGrado"];

  $sql8 = $db->query("SELECT * FROM tblc_firmas WHERE tblc_firmas.IdCampus = '$IdCampus' AND tblc_firmas.IdGrado = '$IdGrado' ");
  $db->rows($sql8);
  $datos81 = $db->recorrer($sql8);
  $IdFirma = $datos81["IdFirma"];


  if(!$IdFirma){
    $insertar = $db->query("INSERT INTO tblc_firmas (IdCampus, IdGrado) VALUES ('$IdCampus','$IdGrado')");
  }

  $sql9 = $db->query("SELECT
tblc_firmas.IdFirma,
tblc_firmas.IdCampus,
tblc_firmas.Rector,
tblc_firmas.Escolares_sep_cotejo,
tblc_firmas.Res_serv_esc_plantel,
tblc_firmas.Oficina,
tblc_firmas.Fecha,
tblc_firmas.Departamento,
tblc_firmas.Elaboro,
tblc_firmas.Educacion_superior,
tblc_firmas.Coordinadora,
tblc_firmas.Servicio,
tblc_campus.Campus
FROM
tblc_firmas
Left Join tblc_campus ON tblc_campus.IdCampus = tblc_firmas.IdCampus WHERE tblc_firmas.IdCampus = '$IdCampus' AND tblc_firmas.IdGrado = '$IdGrado'");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);


  ?>
  <form name="frm22" id="frm22" action="addFirmas.php" method="POST" enctype="multipart/form-data" class="form-horizontal">
    <input id="IdCampus" name="IdCampus" value="<?php echo $IdCampus; ?>" type="hidden"/>
              <div class="box-body">

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Campus:</label>
                  <div class="col-sm-8">
                    <input type="text" disabled class="form-control"  value="<?php echo $datos91["Campus"]; ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Director del plantel:</label>

                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="txtRector" name="txtRector" value="<?php echo $datos91["Rector"]; ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-4 control-label">Responsable de Servicios Escolares Plantel:</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="txtResponsable" name="txtResponsable" value="<?php echo $datos91["Res_serv_esc_plantel"]; ?>" >
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-4 control-label">Jefe de departamento Servicios Escolares Plantel:</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="txtDepartamento" name="txtDepartamento" value="<?php echo $datos91["Departamento"]; ?>" >
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-4 control-label">Servicios escolares SEP Cotejo:</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="txtEscolar" name="txtEscolar" value="<?php echo $datos91["Escolares_sep_cotejo"]; ?>" >
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-4 control-label">Jefe de oficina SEP:</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="txtOficina" name="txtOficina" value="<?php echo $datos91["Oficina"]; ?>" >
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-4 control-label">Elaboró:</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="txtElaboro" name="txtElaboro" value="<?php echo $datos91["Elaboro"]; ?>" >
                  </div>
                </div>
                <!-- <div class="form-group">
                  <label for="inputPassword3" class="col-sm-4 control-label">Fecha de impresión:</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="txtFecha" name="txtFecha" value="<?php echo $datos91["Fecha"]; ?>" >
                  </div>
                </div> -->
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-4 control-label">Director de educación superior:</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="txtEducacion" name="txtEducacion" value="<?php echo $datos91["Educacion_superior"]; ?>" >
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-4 control-label">Coordinadora de asuntos jurídicos de gobierno:</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="txtCoordindadora" name="txtCoordindadora" value="<?php echo $datos91["Coordinadora"]; ?>" >
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-4 control-label">Servicio social / Por la institución educativa:</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="txtServicio" name="txtServicio" value="<?php echo $datos91["Servicio"]; ?>" >
                  </div>
                </div>
                <div class="box-footer">
                <button data-dismiss="modal" class="btn btn-warning"> <i class="fa fa-close"></i> Cancelar</button>
                <button type="button" onclick="addFirma()" class="btn btn-primary pull-right"> <i class="fa fa-save"></i> Guardar</button>
              </div>
              </div>
        </form>
  <?php
}
?>
