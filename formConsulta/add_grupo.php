<?php session_start();
include('../hace.php');
if(isset($_POST["IdOferta"])){
  $output = '';
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdOferta = $_POST["IdOferta"];
  $IdCampus = $_POST["IdCampus"];
  $sql_mod = $db->query("SELECT * FROM tblc_modalidad ");
  $sql_dias = $db->query("SELECT * FROM tblc_dias_clases ");
  $sql_ciclo = $db->query("SELECT * FROM tblc_ciclo WHERE tblc_ciclo.IdEstatus = '8' ORDER BY tblc_ciclo.FInicio ASC ");

  ?>
  <form name="frm22" id="frm22" action="updGrupo.php" method="POST" enctype="multipart/form-data" class="form-horizontal">
    <div class="box-body">
      <div class="form-group">
        <label for="inputEmail3" class="col-sm-4 control-label">Periodo escolar inicial:</label>
        <div class="col-sm-8">
          <select class="form-control" name="txt_ciclo" id="txt_ciclo">
            <option value="">- Seleccione -</option>
            <?php while($_ciclo = $db->recorrer($sql_ciclo)){ ?>
            <option value="<?php echo $_ciclo['IdCiclo']; ?>"> <?php echo $_ciclo['Ciclo']; ?> </option>
            <?php } ?>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">Modalidad:</label>
        <div class="col-sm-4">
          <select class="form-control" name="txt_modalidad" id="txt_modalidad">
            <option value="">- Seleccione -</option>
            <?php while($_mod = $db->recorrer($sql_mod)){ ?>
            <option value="<?php echo $_mod['Mod']; ?>"> <?php echo $_mod['Modalidad']; ?> </option>
            <?php } ?>
          </select>
        </div>
        <label for="inputEmail3" class="col-sm-2 control-label">Turno:</label>
        <div class="col-sm-4">
          <select class="form-control" name="txt_turno" id="txt_turno">
            <option value="">- Seleccione -</option>
            <option value="M"> Matutino </option>
            <option value="V"> Verpertino </option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-2 control-label">Días:</label>
        <div class="col-sm-4">
          <select class="form-control" name="txt_dia" id="txt_dia">
            <option value="">- Seleccione -</option>
            <?php while($_dias = $db->recorrer($sql_dias)){ ?>
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
        <button type="button" onclick="add_new_grupo(<?php echo $IdOferta.','.$IdCampus; ?>)" class="btn btn-primary pull-right" style="margin-right: 5px;"> <i class="fa fa-save"></i> Guardar</button>
    </div>
    </div>
</form>
<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script>
function add_new_grupo(IdOferta,IdCampus){
  var Modalidad = document.getElementById("txt_modalidad").value;
  var Turno = document.getElementById("txt_turno").value;
  var Ciclo = document.getElementById("txt_ciclo").value;
  var Dia = document.getElementById("txt_dia").value;
  var Inicio = document.getElementById("txtFeIni").value;
  var Final = document.getElementById("txtFeFin").value;
  var Grupo = document.getElementById("txt_grp").value;

  var TipoGuardar = "sav_cve_grupo";
  if (Ciclo==''){
    swal("Error al guardar", "Debe seleccionar el periodo escolar inicial.", "error");
    document.getElementById("txt_ciclo").focus();
    return 0;
  }
  if (Modalidad==''){
    swal("Error al guardar", "Debe seleccionar la modalidad.", "error");
    document.getElementById("txt_modalidad").focus();
    return 0;
  }
  if (Turno==''){
    swal("Error al guardar", "Debe seleccionar el turno.", "error");
    document.getElementById("txt_turno").focus();
    return 0;
  }

  if (Dia==''){
    swal("Error al guardar", "Debe seleccionar el tipo de dias de clases.", "error");
    document.getElementById("txt_dia").focus();
    return 0;
  }

  if (Grupo==''){
    swal("Error al guardar", "Debe seleccionar el grupo.", "error");
    document.getElementById("txt_grupo").focus();
    return 0;
  }
  if (Inicio==''){
    swal("Error al guardar", "Debe seleccionar la fecha inicial.", "error");
    document.getElementById("txtFeIni").focus();
    return 0;
  }
  if (Final==''){
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
  function (isConfirm) {
    if (isConfirm) {
      $(".confirm").attr('disabled', 'disabled');
      $.ajax({
        type:"POST",
        url:"formConsulta/guardar_datos.php",
        data:{TipoGuardar:TipoGuardar, IdOferta:IdOferta, IdCampus:IdCampus, Modalidad:Modalidad, Turno:Turno, Ciclo:Ciclo, Dia:Dia, Inicio:Inicio, Final:Final, Grupo:Grupo},
        success:function(data){

        }
      })
      .done(function(data) {
        if(data==1){
          swal("Guardado correctamente", "La actividad se ha guardado correctamente.", "success");
          $("#frm").submit();
        }
        if(data==2){
          swal("Error al guardar", "La clave de grupo ya fue dada de alta.", "error");
        }
      })
      .error(function(data) {
        swal("Error al mostrar 0x15", "No se puede agregar, comuniquese con el desarrollador", "error");
      });
    } else{
      document.getElementById("frm").reset();
    }
  });
}

$(function () {
  //Date picker
  $('#txtFeIni').datepicker({
    autoclose: true
  })

  $('#txtFeFin').datepicker({
    autoclose: true
  })
})
</script>
  <?php
}
?>
