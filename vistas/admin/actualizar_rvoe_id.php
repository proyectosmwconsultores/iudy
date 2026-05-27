<?php
if(isset($_POST["employee_id"])){
  $output = '';
  require('../../php/clases/class.System.php');
  $db = new Conexion();
  $IdRvoe = $_POST["employee_id"];

  $sql9 = $db->query("SELECT tblc_rvoe.IdRvoe, tblc_rvoe.clave_estadistica, tblc_rvoe._cct, tblc_rvoe._duracion, tblc_rvoe._ciclo, tblc_rvoe._anio, tblc_rvoe.Clave_rpe, tblc_rvoe.IdEducativa, tblc_rvoe.Educativa, tblc_rvoe.IdCampus, tblc_rvoe.Clave_dgp, tblc_rvoe.Rvoe, tblc_rvoe.Vigencia, tblc_rvoe.Turno, tblc_rvoe.Modalidad, tblc_rvoe.Escuela, tblc_rvoe.Localidad, tblc_rvoe.Clave, tblc_campus.Campus FROM tblc_rvoe Left Join tblc_campus ON tblc_campus.IdCampus = tblc_rvoe.IdCampus WHERE tblc_rvoe.IdRvoe = '$IdRvoe'");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);
  ?>
  <form name="frm22" id="frm22" action="addRvoe.php" method="POST" enctype="multipart/form-data" class="form-horizontal">

              <div class="box-body">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Campus:</label>
                  <div class="col-sm-8">
                    <input type="text" disabled class="form-control"  value="<?php echo $datos91["Campus"]; ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Oferta educativa:</label>
                  <div class="col-sm-8">
                    <input type="text" name="txt_oferta" id="txt_oferta" class="form-control"  value="<?php echo $datos91["Educativa"]; ?>">
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Rvoe:</label>

                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="txtRvoe" name="txtRvoe" value="<?php echo $datos91["Rvoe"]; ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-4 control-label">Ciclos:</label>
                  <div class="col-sm-8">
                    <select name="txt_ciclos" id="txt_ciclos" class="form-control">
                      <option value=""> - Seleccione -</option>
                      <option value="SEMESTRAL" <?php if ($datos91["_ciclo"] == "SEMESTRAL") { ?>selected="selected" <?php } ?>> SEMESTRAL </option>
                      <option value="CUATRIMESTRAL" <?php if ($datos91["_ciclo"] == "CUATRIMESTRAL") { ?>selected="selected" <?php } ?>> CUATRIMESTRAL </option>
                      <option value="MODULAR" <?php if ($datos91["_ciclo"] == "MODULAR") { ?>selected="selected" <?php } ?>> MODULAR </option>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-4 control-label">Año del plan de estudios:</label>
                  <div class="col-sm-8">
                    <input type="text" maxlength="4" class="form-control" id="txt_anio" name="txt_anio" value="<?php echo $datos91["_anio"]; ?>" >
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-4 control-label">Clave de la carrera (Estadística):</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="txtClave_estadistica" name="txtClave_estadistica" value="<?php echo $datos91["clave_estadistica"]; ?>" >
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-4 control-label">Clave de la carrera DGP:</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="txtClave_dgp" name="txtClave_dgp" value="<?php echo $datos91["Clave_dgp"]; ?>" >
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-4 control-label">CCT:</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="txt_cct" name="txt_cct" value="<?php echo $datos91["_cct"]; ?>" >
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-4 control-label">Fecha expedición del Rvoe (fecha):</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="txtVigencia" name="txtVigencia" value="<?php echo $datos91["Vigencia"]; ?>" >
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-4 control-label">Duración en años:</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="txt_duracion" name="txt_duracion" value="<?php echo $datos91["_duracion"]; ?>" >
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-4 control-label">Clave de registro del plan de estudios:</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="txtRegistro" name="txtRegistro" value="<?php echo $datos91["Clave_rpe"]; ?>" >
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
                <button type="button" onclick="sav_rvoe_id(<?php echo $IdRvoe; ?>)" class="btn btn-primary pull-right"> <i class="fa fa-save"></i> Guardar</button>
              </div>
              </div>
        </form>
  <?php
}
?>


<script>
  function sav_rvoe_id(IdRvoe) {
	var Oferta = document.getElementById("txt_oferta").value;
	var Rvoe = document.getElementById("txtRvoe").value;
	var Vigencia = document.getElementById("txtVigencia").value;
	var Turno = document.getElementById("txtTurno").value;
	var Modalidad = document.getElementById("txtModalidad").value;
	var Escuela = document.getElementById("txtEscuela").value;
	var Localidad = document.getElementById("txtLocalidad").value;
	var Clave_dgp = document.getElementById("txtClave_dgp").value;
	var Clave_rpe = document.getElementById("txtRegistro").value;
	
  var Ciclo = document.getElementById("txt_ciclos").value;
	var Anio = document.getElementById("txt_anio").value;
	var Duracion = document.getElementById("txt_duracion").value;
	var Cct = document.getElementById("txt_cct").value;
	var Clave_estadistica = document.getElementById("txtClave_estadistica").value;
	
	var TipoGuardar = "addRvoe";



	if (Rvoe == '') {
		swal("Error al guardar", "Debe escribir el Rvoe.", "error");
		document.getElementById("txtRvoe").focus();
		return 0;
	}
	if (Vigencia == '') {
		swal("Error al guardar", "Debe escribir la vigencia.", "error");
		document.getElementById("txtVigencia").focus();
		return 0;
	}
	if (Turno == '') {
		swal("Error al guardar", "Debe escribir el turno.", "error");
		document.getElementById("txtTurno").focus();
		return 0;
	}
	if (Modalidad == '') {
		swal("Error al guardar", "Debe escribir la modalidad.", "error");
		document.getElementById("txtModalidad").focus();
		return 0;
	}


	var datos = 'TipoGuardar=' + TipoGuardar + '&Cct=' + Cct +  '&Duracion=' + Duracion + '&Anio=' + Anio +'&Ciclo=' + Ciclo + '&Rvoe=' + Rvoe + '&Vigencia=' + Vigencia + '&Turno=' + Turno + '&Modalidad=' + Modalidad + '&IdRvoe=' + IdRvoe + '&Escuela=' + Escuela + '&Localidad=' + Localidad + '&Clave_dgp=' + Clave_dgp + '&Oferta=' + Oferta + '&Clave_rpe=' + Clave_rpe + '&Clave_estadistica='+Clave_estadistica;
	$.ajax({
		type: "POST",
		url: "insertar.php",
		data: datos,
		success: function (data) {

		}
	})
		.done(function (data) {
			if (data == 1) {
				swal("Guardado correctamente", "Datos del rvoe ha sido guardado correctamente.", "success");
			}

			if (data == 0) {
				swal("Error al guardar", "No se puede guardar, verifique sus datos.", "error");
			}
		})


}
</script>