<?php session_start();
include('../../hace.php');
require('../../php/clases/class.System.php');
$anio = date("Y-m-d");
$db = new Conexion();
$IdCiclo = $_POST["IdCiclo"];
$IdOferta = $_POST["IdOferta"];
$IdCampus = $_POST["IdCampus"];
$sql_mod = $db->query("SELECT * FROM tblc_modalidad ");
$sql_dias = $db->query("SELECT * FROM tblc_dias_clases ");
$sql_ciclo = $db->query("SELECT * FROM tblc_ciclo WHERE tblc_ciclo.Anio >= '$anio' ORDER BY tblc_ciclo.FInicio DESC ");
$sql_campus = $db->query("SELECT * FROM tblc_campus");

$sql_oferta = $db->query("SELECT * FROM tblp_educativa ORDER BY tblp_educativa.IdGrado ASC, tblp_educativa.Nombre ASC");
$sql_rvoe = $db->query("SELECT tblc_rvoe_campus.Id_rvoe, tblc_rvoe_campus.IdEducativa, tblc_rvoe_campus.IdRvoe, tblc_rvoe.Educativa, tblc_rvoe.Rvoe, tblc_rvoe.IdCampus, tblc_campus.Campus FROM tblc_rvoe_campus Left Join tblc_rvoe ON tblc_rvoe.IdRvoe = tblc_rvoe_campus.IdRvoe Left Join tblc_campus ON tblc_campus.IdCampus = tblc_rvoe.IdCampus WHERE tblc_rvoe_campus.IdEducativa =  '$IdOferta' GROUP BY tblc_rvoe.Rvoe ORDER BY tblc_rvoe_campus.IdRvoe ASC");

$sql_cic = $db->query("SELECT tblc_ciclo.Tipo FROM tblc_ciclo WHERE tblc_ciclo.IdCiclo = '$IdCiclo'");
$db->rows($sql_cic);
$_cic = $db->recorrer($sql_cic);

?>
<form name="frm22" id="frm22" action="crea_grupo.php" method="POST" enctype="multipart/form-data" class="form-horizontal">
  <div class="box-body">
    <div class="form-group">
      <label class="col-sm-4 control-label">Campus alta:</label>
      <div class="col-sm-8">
        <select class="form-control" name="txt_campus" id="txt_campus" onchange="sel_campus_grp(<?php echo $IdCiclo; ?>)">
          <option value="">- Seleccione -</option>
          <?php while ($_campus = $db->recorrer($sql_campus)) { ?>
            <option value="<?php echo $_campus['IdCampus']; ?>" <?php if ($_campus["IdCampus"] == $IdCampus) { ?>selected="selected" <?php } ?>> <?php echo $_campus['Campus']; ?> </option>
          <?php } ?>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-4 control-label">Plan de estudios:</label>
      <div class="col-sm-8">
        <select class="form-control" name="txt_oferta" id="txt_oferta" onchange="sel_oferta_grp(<?php echo $IdCiclo; ?>)">
          <option value="">- Seleccione -</option>
          <?php while ($_oferta = $db->recorrer($sql_oferta)) { ?>
            <option value="<?php echo $_oferta['IdEducativa']; ?>" <?php if ($_oferta["IdEducativa"] == $IdOferta) { ?>selected="selected" <?php } ?>> <?php echo $_oferta['Nombre']; ?> </option>
          <?php } ?>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-4 control-label">Rvoe a utilizar:</label>
      <div class="col-sm-8">
        <select class="form-control" name="txt_rvoe" id="txt_rvoe">
          <option value="">- Seleccione -</option>
          <?php while ($_rvoe = $db->recorrer($sql_rvoe)) { ?>
            <option value="<?php echo $_rvoe['IdRvoe']; ?>"> <?php echo $_rvoe['Rvoe'] . ' - ' . $_rvoe['Campus']; ?> </option>
          <?php } ?>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label">Modalidad:</label>
      <div class="col-sm-4">
        <select class="form-control" name="txt_modalidad" id="txt_modalidad">
          <option value="">- Seleccione -</option>
          <?php while ($_mod = $db->recorrer($sql_mod)) { ?>
            <option value="<?php echo $_mod['Mod']; ?>"> <?php echo $_mod['Modalidad']; ?> </option>
          <?php } ?>
        </select>
      </div>
      <label class="col-sm-2 control-label">Turno:</label>
      <div class="col-sm-4">
        <select class="form-control" name="txt_turno" id="txt_turno">
          <option value="">- Seleccione -</option>
          <option value="O"> Online </option>
          <option value="M"> Mixto </option>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label">Días:</label>
      <div class="col-sm-4">
        <select class="form-control" name="txt_dia" id="txt_dia">
          <option value="">- Seleccione -</option>
          <?php while ($_dias = $db->recorrer($sql_dias)) { ?>
            <option value="<?php echo $_dias['Dia']; ?>"> <?php echo $_dias['_Dias']; ?> </option>
          <?php } ?>
        </select>
      </div>
      <label class="col-sm-2 control-label">Grupo:</label>
      <div class="col-sm-4">
        <select class="form-control" name="txt_grp" id="txt_grp">
          <option value="">- Seleccione -</option>
          <option value="A"> Grupo A </option>
          <option value="B"> Grupo B </option>
          <option value="C"> Grupo C </option>
          <option value="D"> Grupo D </option>
          <option value="E"> Grupo E </option>
          <option value="F"> Grupo F </option>
          <option value="G"> Grupo G </option>
          <option value="H"> Grupo H </option>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label">Ingreso:</label>
      <div class="col-sm-4">
        <input type="text" name="txtFeIni" id="txtFeIni" class="form-control">
      </div>
      <label class="col-sm-2 control-label">Egreso:</label>
      <div class="col-sm-4">
        <input type="text" name="txtFeFin" id="txtFeFin" class="form-control">
      </div>
    </div>

    <div class="box-footer">
    <label class="col-sm-4 control-label">Aplica para inglés:</label>
      <div class="col-sm-3">
        <select class="form-control" name="txt_ingles" id="txt_ingles">
          <option value=""> - Seleccione -</option>
          <option value="SI"> SI </option>
          <option value="NO"> NO </option>
        </select>
      </div>
      <button type="button" onclick="add_new_grupo(<?php echo $IdCiclo; ?>,'<?php echo $_cic['Tipo']; ?>')" class="btn btn-primary pull-right" style="margin-right: 5px;"> <i class="fa fa-save"></i> Guardar</button>
    </div>
  </div>
</form>
<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script>
  function add_new_grupo(Ciclo, Tipo) {
    var IdCampus = document.getElementById("txt_campus").value;
    var IdOferta = document.getElementById("txt_oferta").value;
    var IdRvoe = document.getElementById("txt_rvoe").value;
    var Modalidad = document.getElementById("txt_modalidad").value;
    var Turno = document.getElementById("txt_turno").value;
    var Dia = document.getElementById("txt_dia").value;
    var Inicio = document.getElementById("txtFeIni").value;
    var Final = document.getElementById("txtFeFin").value;
    var Grupo = document.getElementById("txt_grp").value;
    var Ingles = document.getElementById("txt_ingles").value;

    var TipoGuardar = "sav_cve_grupo_new";
    if (IdCampus == '') {
      swal("Error al guardar", "Debe seleccionar el campus.", "error");
      document.getElementById("txt_campus").focus();
      return 0;
    }
    if (IdOferta == '') {
      swal("Error al guardar", "Debe seleccionar el plan de estudios.", "error");
      document.getElementById("txt_oferta").focus();
      return 0;
    }
    if (IdRvoe == '') {
      swal("Error al guardar", "Debe seleccionar el rvoe del plan de estudios.", "error");
      document.getElementById("txt_rvoe").focus();
      return 0;
    }
    if (Ciclo == '') {
      swal("Error al guardar", "Debe seleccionar el periodo escolar inicial.", "error");
      document.getElementById("txt_ciclo").focus();
      return 0;
    }
    if (Modalidad == '') {
      swal("Error al guardar", "Debe seleccionar la modalidad.", "error");
      document.getElementById("txt_modalidad").focus();
      return 0;
    }
    if (Turno == '') {
      swal("Error al guardar", "Debe seleccionar el turno.", "error");
      document.getElementById("txt_turno").focus();
      return 0;
    }

    if (Dia == '') {
      swal("Error al guardar", "Debe seleccionar el tipo de dias de clases.", "error");
      document.getElementById("txt_dia").focus();
      return 0;
    }

    if (Grupo == '') {
      swal("Error al guardar", "Debe seleccionar el grupo.", "error");
      document.getElementById("txt_grupo").focus();
      return 0;
    }
    if (Inicio == '') {
      swal("Error al guardar", "Debe seleccionar la fecha inicial.", "error");
      document.getElementById("txtFeIni").focus();
      return 0;
    }
    if (Final == '') {
      swal("Error al guardar", "Debe seleccionar la fecha de egreso.", "error");
      document.getElementById("txtFeFin").focus();
      return 0;
    }

    swal({
        title: "\u00BFEst\u00E1 seguro que desea agregar esta nueva clave de grupo?",
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
              type: "POST",
              url: "vistas/escolar/guardar_datos_escolar.php",
              data: {
                TipoGuardar: TipoGuardar,
                IdOferta: IdOferta,
                IdCampus: IdCampus,
                IdRvoe: IdRvoe,
                Modalidad: Modalidad,
                Turno: Turno,
                Ciclo: Ciclo,
                Dia: Dia,
                Inicio: Inicio,
                Final: Final,
                Grupo: Grupo,
                Ingles:Ingles
              },
              success: function(data) {

              }
            })
            .done(function(data) {
              if (data == 1) {
                swal("Guardado correctamente", "El grupo se ha guardado correctamente.", "success");
                $('#dataDocsx').modal('hide');
                cargar_grupo_reg(Tipo, Ciclo);
              }
              if (data == 2) {
                swal("Error al guardar", "La clave de grupo ya fue dada de alta.", "error");
              }
            })
            .error(function(data) {
              swal("Error al mostrar 0x15", "No se puede agregar, comuniquese con el desarrollador", "error");
            });
        } else {
          document.getElementById("frm").reset();
        }
      });
  }

  $(function() {
    //Date picker
    $('#txtFeIni').datepicker({
      autoclose: true
    })

    $('#txtFeFin').datepicker({
      autoclose: true
    })
  })

  function sel_campus_grp(IdCiclo) {
    var IdCampus = document.getElementById("txt_campus").value;
    var IdOferta = document.getElementById("txt_oferta").value;
    $.ajax({
      url: "vistas/escolar/crea_grupo.php",
      method: "POST",
      data: {
        IdCampus: IdCampus,
        IdOferta: IdOferta,
        IdCiclo: IdCiclo
      },
      success: function(data) {
        $('#employee_docsx').html(data);
        $('#dataDocsx').modal('show');
      }
    });
  }

  function sel_oferta_grp(IdCiclo) {
    var IdCampus = document.getElementById("txt_campus").value;
    var IdOferta = document.getElementById("txt_oferta").value;
    $.ajax({
      url: "vistas/escolar/crea_grupo.php",
      method: "POST",
      data: {
        IdCampus: IdCampus,
        IdOferta: IdOferta,
        IdCiclo: IdCiclo
      },
      success: function(data) {
        $('#employee_docsx').html(data);
        $('#dataDocsx').modal('show');
      }
    });
  }
</script>