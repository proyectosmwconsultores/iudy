<?php
session_start();
require('../php/clases/class.System.php');
$db = new Conexion();

$IdUsua = $_POST["IdUsua"];
// $IdTipo = $_POST["IdTipo"];

$sql8 = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.IdUsua = '$IdUsua'");
$db->rows($sql8);
$datos81 = $db->recorrer($sql8);


// $sql1 = $db->query("SELECT * FROM tblc_ciclo ORDER BY tblc_ciclo.FInicio DESC");
// $sql2 = $db->query("SELECT tblh_bajausuario.IdBaja, tblh_bajausuario.Comentario, tblh_bajausuario.FecCap, tblc_ciclo.Ciclo, tblc_estatus.Estatus FROM tblh_bajausuario Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblh_bajausuario.IdCiclo Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblh_bajausuario.IdEstatus WHERE tblh_bajausuario.IdUsua = '$IdUsua' ORDER BY tblh_bajausuario.FecCap DESC ");

?>
<form name="frm2xfYj" id="frm2xfYj" action="addNewPago.php" method="POST" enctype="multipart/form-data" class="form-horizontal">
  <input id="IdUsua" name="IdUsua" value="<?php echo $IdUsua; ?>" type="hidden" />

  <div class="box-body">
    <div class="form-group">
      <label class="col-sm-6 control-label">CURP:</label>
      <div class="col-sm-6">
        <input type="text" maxlength="18" autocomplete="off" oninput="validarCURP(this)" class="form-control" name="txt_curpx" id="txt_curpx" value="<?php echo $datos81['Curp']; ?>">
        <p id="mensaje"></p>
      </div>
    </div>
    <div class="box-footer">
      <button id="botongenerar" type="button" class="btn btn-info pull-right" onClick="cap_curp_id(<?php echo $IdUsua; ?>)"> <i class="fa fa-save"></i> Guardar curp</button></td>
    </div>
  <hr>
    <div class="form-group">
      <label class="col-sm-6 control-label">Prefijo:</label>
      <div class="col-sm-6">
        <select class="form-control" name="txt_prefijo" id="txt_prefijo">
          <option> - Seleccione </option>
          <?php if($datos81['Sexo'] == "H") { ?>
            <option value="DR" <?php if($datos81["_prefijo"]=="DR"){ ?>selected="selected"<?php } ?>>  DR </option>
          <option value="MTRO" <?php if($datos81["_prefijo"]=="MTRO"){ ?>selected="selected"<?php } ?>>  MTRO </option>
          <?php } ?>
          <?php if($datos81['Sexo'] == "M") { ?>
            <option value="DRA" <?php if($datos81["_prefijo"]=="DRA"){ ?>selected="selected"<?php } ?>>  DRA </option>
            <option value="MTRA" <?php if($datos81["_prefijo"]=="MTRA"){ ?>selected="selected"<?php } ?>>  MTRA </option>
          <?php } ?>      
          <option value="ARQ" <?php if($datos81["_prefijo"]=="ARQ"){ ?>selected="selected"<?php } ?>>  ARQ </option>
          <option value="LIC" <?php if($datos81["_prefijo"]=="LIC"){ ?>selected="selected"<?php } ?>>  LIC </option>
          <option value="CP" <?php if($datos81["_prefijo"]=="CP"){ ?>selected="selected"<?php } ?>>  CP </option>
          <option value="ING" <?php if($datos81["_prefijo"]=="ING"){ ?>selected="selected"<?php } ?>>  ING </option>
          <option value="CAP" <?php if($datos81["_prefijo"]=="CAP"){ ?>selected="selected"<?php } ?>>  CAP </option>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label">Nacionalidad:</label>
      <div class="col-sm-6">
        <input type="text" class="form-control" id="txt_nacionalidad" name="txt_nacionalidad" value="<?php echo $datos81['_nacionalidad']; ?>">
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label">Nacido en:</label>
      <div class="col-sm-6">
        <input type="text" class="form-control" id="txt_nacimiento" name="txt_nacimiento" value="<?php echo $datos81['_nacimiento']; ?>">
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label">Escolaridad:</label>
      <div class="col-sm-6">
        <input type="text" class="form-control" id="txt_escolaridad" name="txt_escolaridad" value="<?php echo $datos81['_escolaridad']; ?>">
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label">Clave de elector:</label>
      <div class="col-sm-6">
        <input type="text" class="form-control" id="txt_elector" name="txt_elector" value="<?php echo $datos81['_elector']; ?>">
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label">RFC:</label>
      <div class="col-sm-6">
        <input type="text" class="form-control" id="txt_rfc" name="txt_rfc" value="<?php echo $datos81['_rfc']; ?>" maxlength="13">
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label">Banco:</label>
      <div class="col-sm-6">
        <input type="text" class="form-control" id="txt_banco" name="txt_banco" value="<?php echo $datos81['_banco']; ?>">
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label">Cuenta:</label>
      <div class="col-sm-6">
        <input type="text" class="form-control" id="txt_cuenta" name="txt_cuenta" value="<?php echo $datos81['_cuenta']; ?>">
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-3 control-label">Domicilio:</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" id="txt_domicilio" name="txt_domicilio" value="<?php echo $datos81['_domicilio']; ?>">
      </div>
    </div>
    <div class="box-footer">
      <button id="botongenerar2" type="button" class="btn btn-primary pull-right" onClick="sav_datos_docente_id(<?php echo $IdUsua; ?>)"> <i class="fa fa-save"></i> Guardar datos</button></td>
    </div>

  </div>


</form>
<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

<script>
  function validarCURP(input) {
    const curp = input.value.toUpperCase(); // Convertir a mayúsculas
    input.value = curp; // Mantener el formato en mayúsculas

    const regexCurp = /^[A-Z]{4}\d{6}[HM]{1}[A-Z]{2}[B-DF-HJ-NP-TV-Z]{3}[0-9A-Z]{1}\d{1}$/;

    if (regexCurp.test(curp)) {
      input.classList.remove("invalid");
      input.classList.add("valid");
      document.getElementById("mensaje").innerText = "CURP válida";
      document.getElementById("mensaje").style.color = "green";
      document.getElementById("botongenerar").disabled = false;
      document.getElementById("botongenerar2").disabled = false;
    } else {
      input.classList.remove("valid");
      input.classList.add("invalid");
      document.getElementById("mensaje").innerText = "CURP inválida";
      document.getElementById("mensaje").style.color = "red";
      document.getElementById("botongenerar").disabled = true;
      document.getElementById("botongenerar2").disabled = true;
    }
  }


  function cap_curp_id(IdUsua) {
    var Curp = document.getElementById("txt_curpx").value;

    if (Curp == "") {
      swal("Error al guardar", "Debe escribir la CURP.", "error");
      document.getElementById("txt_curpx").focus();
      return 0;
    }
    

    var TipoGuardar = 'sav_curp_id';
		swal({
				title: "\u00BFEst\u00E1 seguro que guardar esta CURP?",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: '#DD6B55',
				confirmButtonText: 'Aceptar',
			},
			function(isConfirm) {
				if (isConfirm) {
					$(".confirm").attr('disabled', 'disabled');
					$.ajax({
							type: "POST",
							url: "formConsulta/setting.php",
							data: {
								TipoGuardar: TipoGuardar,
								IdUsua: IdUsua,
                Curp: Curp
							},
							success: function(data) {

							}
						})
						.done(function(data) {
							swal("Agregado correctamente", "La curp ha si guardado correctamente.", "success");
              $.ajax({
					url: "formConsulta/informacionDocente.php",
					method: "POST",
					data: {
						IdUsua: IdUsua
					},
					success: function(data) {
						$('#employee_info').html(data);
						$('#dataInfo').modal('show');
					}
				});
						})
						.error(function(data) {
							swal("Error al agregar 0x130", "No se puede agregar, comuniquese con el desarrollador.", "error");
						});
				}

			});


  }


  function sav_datos_docente_id(IdUsua) {
    var Nacionalidad = document.getElementById("txt_nacionalidad").value;
    var Nacimiento = document.getElementById("txt_nacimiento").value;
    var Escolaridad = document.getElementById("txt_escolaridad").value;
    var Elector = document.getElementById("txt_elector").value;
    var Rfc = document.getElementById("txt_rfc").value;
    var Banco = document.getElementById("txt_banco").value;
    var Cuenta = document.getElementById("txt_cuenta").value;
    var Prefijo = document.getElementById("txt_prefijo").value;
    var Domicilio = document.getElementById("txt_domicilio").value;
    
    if (Nacionalidad == "") {
      swal("Error al guardar", "Debe escribir la nacionalidad.", "error");
      document.getElementById("txt_nacionalidad").focus();
      return 0;
    }
    

    var TipoGuardar = 'sav_datos_docente_id';
		swal({
				title: "\u00BFEst\u00E1 seguro que guardar los datos de este docente?",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: '#DD6B55',
				confirmButtonText: 'Aceptar',
			},
			function(isConfirm) {
				if (isConfirm) {
					$(".confirm").attr('disabled', 'disabled');
					$.ajax({
							type: "POST",
							url: "formConsulta/setting.php",
							data: {
								TipoGuardar: TipoGuardar,
								IdUsua: IdUsua,
                Nacionalidad: Nacionalidad,
                Nacimiento: Nacimiento,
                Escolaridad: Escolaridad,
                Elector: Elector,
                Rfc: Rfc,
                Banco: Banco,
                Cuenta: Cuenta, Prefijo:Prefijo, Domicilio:Domicilio
							},
							success: function(data) {

							}
						})
						.done(function(data) {
							swal("Guardado correctamente", "Los datos del docente se han guardado correctamente.", "success");
              $.ajax({
					url: "formConsulta/informacionDocente.php",
					method: "POST",
					data: {
						IdUsua: IdUsua
					},
					success: function(data) {
						$('#employee_info').html(data);
						$('#dataInfo').modal('show');
					}
				});
						})
						.error(function(data) {
							swal("Error al agregar 0x130", "No se puede agregar, comuniquese con el desarrollador.", "error");
						});
				}

			});


  }



  $(function() {
    var curp = document.getElementById("txt_curpx").value;

    const regexCurp = /^[A-Z]{4}\d{6}[HM]{1}[A-Z]{2}[B-DF-HJ-NP-TV-Z]{3}[0-9A-Z]{1}\d{1}$/;

    if (regexCurp.test(curp)) {
      // input.classList.remove("invalid");
      // input.classList.add("valid");
      document.getElementById("mensaje").innerText = "CURP válida";
      document.getElementById("mensaje").style.color = "green";
      document.getElementById("botongenerar").disabled = false;
      document.getElementById("botongenerar2").disabled = false;
    } else {
      // input.classList.remove("valid");
      // input.classList.add("invalid");
      document.getElementById("mensaje").innerText = "CURP inválida";
      document.getElementById("mensaje").style.color = "red";
      document.getElementById("botongenerar").disabled = true;
      document.getElementById("botongenerar2").disabled = true;
    }


    $('#txtFecha').datepicker({
      autoclose: true
    })

  })
</script>