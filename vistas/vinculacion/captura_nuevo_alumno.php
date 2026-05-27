<?php
session_start();
require('../../php/clases/class.System.php');
$db = new Conexion();


$sql_campus = $db->query("SELECT * FROM tblc_campus WHERE tblc_campus._visible = '1'");


$sql_oferta = $db->query("SELECT * FROM tblp_educativa WHERE tblp_educativa.IdGrado = '7'");

?>
<div class="box box-info">
  <div class="box-header with-border">
    <h3 class="box-title"><i class="fa fa-fw fa-folder-open"></i> Captura de nuevo usuario en la plataforma</h3>
  </div>
  <form class="form-horizontal">
    <div class="box-body">
      <div class="form-group">
        <label class="col-sm-6 control-label">Tipo alumno:</label>
        <div class="col-sm-6">
          <select class="form-control" name="txt_tipo" id="txt_tipo">
            <option value=""> - Seleccione - </option>
              <option value="13"> EXALUMNO </option>
              <option value="14"> DOCENTE </option>
              <option value="15"> PUBLICO EN GENERAL </option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-6 control-label">¿Que desea estudiar?:</label>
        <div class="col-sm-6">
          <select class="form-control" name="txt_grado" id="txt_grado">
            <option value=""> - Seleccione - </option>
              <!--<option value="8"> CURSO </option>-->
              <option value="7"> DIPLOMADO </option>
              <!-- <option value="9"> CERTIFICACION </option> -->
          </select>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-6 control-label">Campus:</label>
        <div class="col-sm-6">
          <select class="form-control" name="txt_campus" id="txt_campus">
            <option value=""> - Seleccione - </option>
            <?php while ($_cam = $db->recorrer($sql_campus)) { ?>
              <option value="<?php echo $_cam["IdCampus"]; ?>"> <?php echo $_cam["Campus"]; ?> </option>
            <?php } ?>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-6 control-label">Nombre del diplomado:</label>
        <div class="col-sm-6">
          <select class="form-control" name="txt_diplomado" id="txt_diplomado">
            <option value=""> - Seleccione - </option>
            <?php while ($_dip = $db->recorrer($sql_oferta)) { ?>
              <option value="<?php echo $_dip["IdEducativa"]; ?>"> <?php echo $_dip["Nombre"]; ?> </option>
            <?php } ?>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-6 control-label">Nombre:</label>
        <div class="col-sm-6">
          <input type="text" class="form-control" name="txt_nombre" id="txt_nombre">
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-6 control-label">Apellido paterno:</label>
        <div class="col-sm-6">
          <input type="text" class="form-control" name="txt_paterno" id="txt_paterno">
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-6 control-label">Apellido materno:</label>
        <div class="col-sm-6">
          <input type="text" class="form-control" name="txt_materno" id="txt_materno">
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-6 control-label">Correo:</label>
        <div class="col-sm-6">
          <input type="text" class="form-control" name="txt_correo" id="txt_correo">
        </div>
      </div>
    </div>
    <div class="box-footer">
      <button onclick="sav_nuevo_usuario()" type="button" class="btn btn-danger pull-right"><i class="fa fa-fw fa-check-circle-o"></i> Guardar usuario</button>
    </div>
  </form>
</div>



<script>


  function sav_nuevo_usuario() {
    var IdTipo = document.getElementById("txt_tipo").value;
    var IdCampus = document.getElementById("txt_campus").value;
    var IdGrado = document.getElementById("txt_grado").value;
    var Nombre = document.getElementById("txt_nombre").value;
    var Paterno = document.getElementById("txt_paterno").value;
    var Materno = document.getElementById("txt_materno").value;
    var Correo = document.getElementById("txt_correo").value;
    var IdOferta = document.getElementById("txt_diplomado").value;
    
    if (IdTipo == "") {
      swal("Error al guardar", "Debe seleccionar el tipo de usuario.", "error");
      document.getElementById("txt_tipo").focus();
      return 0;
    }
    if (IdGrado == "") {
      swal("Error al guardar", "Debe seleccionar el grado de estudio.", "error");
      document.getElementById("txt_grado").focus();
      return 0;
    }
    if (IdCampus == "") {
      swal("Error al guardar", "Debe seleccionar el campus de alta.", "error");
      document.getElementById("txt_campus").focus();
      return 0;
    }
    if (Nombre == "") {
      swal("Error al guardar", "Debe escribir la nombre del alumno.", "error");
      document.getElementById("txt_nombre").focus();
      return 0;
    }
    if (Paterno == "") {
      swal("Error al guardar", "Debe escribir la apellido paterno del alumno.", "error");
      document.getElementById("txt_paterno").focus();
      return 0;
    }
    if (Materno == "") {
      swal("Error al guardar", "Debe escribir la apellido materno del alumno.", "error");
      document.getElementById("txt_materno").focus();
      return 0;
    }

    var TipoGuardar = "sav_new_alumno_id";
    swal({
        title: "\u00BFEst\u00E1 seguro que desea guardar los datos de este nuevo usuario?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Aceptar',
        cancelButtonText: "Cancelar",
      },
      function(isConfirm) {
        if (isConfirm) {
          $(".confirm").attr('disabled', 'disabled');
          $.ajax({
              url: "vistas/vinculacion/guardar_datos_vinculacion.php",
              method: "POST",
              data: {
                TipoGuardar: TipoGuardar,
                IdCampus: IdCampus,
                IdTipo: IdTipo,
                Nombre: Nombre,
                Paterno: Paterno,
                Materno: Materno,
                Correo: Correo,
                IdGrado:IdGrado,
                IdOferta:IdOferta
              },
              success: function(data) {
              }
            })
            .done(function(data) {
              if (data == 0) {
                swal("Error al guardar", "Este proceso no se pudo realizar favor de revisar.", "error");
              }
              if (data == 1) {
                swal("Guardado correctamente", "Los datos del usuario se han guardado correctamente.", "success");
                load_user_lista();
              }


              if (data == 5) {
                swal("Error al guardar", "El usuario ya se encuentra registrado en el sistema SCIUDY.", "error");
              }

            })
            .error(function(data) {
              swal("Error al agregar 0x130", "No se puede actualizar, comuniquese con el desarrollador.", "error");
            });
        }
      });
  }
</script>