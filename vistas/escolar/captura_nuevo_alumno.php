<?php
session_start();
require('../../php/clases/class.System.php');
$db = new Conexion();


$Tipo = $_POST["Tipo"];
$IdCiclo = $_POST["IdCiclo"];
$IdCampus = $_POST["IdCampus"];
$anio = date("Y");

$sql_campus = $db->query("SELECT * FROM tblc_campus WHERE tblc_campus._visible = '1'");
$sql_ciclo = $db->query("SELECT * FROM tblc_ciclo WHERE tblc_ciclo.Anio = '$anio' ORDER BY tblc_ciclo.FInicio ASC");

if($Tipo == 'R'){
$sql_grupo = $db->query("SELECT
tblc_ciclogrupo.IdCicloGrupo,
tblp_grupo.CveGrupo,
tblc_ciclogrupo.Grado,
tblc_ciclogrupo.IdGrupo,
tblp_educativa.Nombre,
tblc_dias_clases._Dias
FROM
tblc_ciclogrupo
Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_ciclogrupo.IdGrupo
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_grupo.IdOferta
Left Join tblc_dias_clases ON tblc_dias_clases.Dia = tblp_grupo.Dia
WHERE
tblc_ciclogrupo.IdCiclo =  '$IdCiclo' AND
tblp_grupo.IdCampus =  '$IdCampus'
ORDER BY
tblp_grupo.IdOferta ASC,
tblc_ciclogrupo.Grado ASC
");
} else {
  $sql_grupo = $db->query("SELECT
  tblc_ciclogrupo.IdCicloGrupo,
  tblp_grupo.CveGrupo,
  tblc_ciclogrupo.Grado,
  tblc_ciclogrupo.IdGrupo,
  tblp_educativa.Nombre,
  tblc_dias_clases._Dias,
  tblc_ciclogrupo.IdCiclo
  FROM
  tblc_ciclogrupo
  Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_ciclogrupo.IdGrupo
  Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_grupo.IdOferta
  Left Join tblc_dias_clases ON tblc_dias_clases.Dia = tblp_grupo.Dia
  WHERE
  tblp_grupo.IdCampus =  '$IdCampus' AND
  tblp_grupo.Dia =  'P'
  ORDER BY
  tblp_grupo.IdOferta ASC,
  tblc_ciclogrupo.Grado ASC
  
");
}
?>
<div class="box box-info">
  <div class="box-header with-border">
    <h3 class="box-title"><i class="fa fa-fw fa-folder-open"></i> Captura de nuevo usuario en la plataforma</h3>
  </div>
  <form class="form-horizontal">
    <div class="box-body">
      <div class="form-group">
        <label class="col-sm-3 control-label">Tipo alumno:</label>
        <div class="col-sm-9">
          <select class="form-control" name="txt_tipo" id="txt_tipo" onchange="sel_tipo()">
            <option value=""> - Seleccione - </option>
              <option value="R" <?php if ($Tipo == 'R') { ?>selected="selected" <?php } ?>> ALUMNO REGULAR </option>
              <option value="P" <?php if ($Tipo == 'P') { ?>selected="selected" <?php } ?>> ALUMNO HORARIO PERSONALIZADO </option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-3 control-label">Campus:</label>
        <div class="col-sm-9">
          <select class="form-control" name="txt_campus" id="txt_campus" onchange="sel_campus(<?php echo $IdCiclo; ?>,'<?php echo $Tipo; ?>')">
            <option value=""> - Seleccione - </option>
            <?php while ($_cam = $db->recorrer($sql_campus)) { ?>
              <option value="<?php echo $_cam["IdCampus"]; ?>" <?php if ($_cam["IdCampus"] == $IdCampus) { ?>selected="selected" <?php } ?>> <?php echo $_cam["Campus"]; ?> </option>
            <?php } ?>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-3 control-label">Periodos escolares disponibles:</label>
        <div class="col-sm-9">
          <select class="form-control" name="txt_ciclo" id="txt_ciclo" onchange="sel_ciclo(<?php echo $IdCampus; ?>,'<?php echo $Tipo; ?>')">
            <option value=""> - Seleccione - </option>
            <?php while ($_cic = $db->recorrer($sql_ciclo)) { ?>
              <option value="<?php echo $_cic["IdCiclo"]; ?>" <?php if ($_cic["IdCiclo"] == $IdCiclo) { ?>selected="selected" <?php } ?>> <?php echo $_cic["Ciclo"]; ?> </option>
            <?php } ?>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-3 control-label">Grupos disponibles:</label>
        <div class="col-sm-9">
          <select class="form-control" name="txt_grupo" id="txt_grupo">
            <option value=""> - Seleccione - </option>
            <?php while ($_grp = $db->recorrer($sql_grupo)) { ?>
              <option value="<?php echo $_grp["IdGrupo"]; ?>"> <?php echo $_grp["Grado"].'° '.$_grp["CveGrupo"].' ('.$_grp["_Dias"].') '.$_grp["Nombre"]; ?> </option>
            <?php } ?>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-6 control-label">Matrícula:</label>
        <div class="col-sm-6">
          <input type="text" class="form-control" name="txt_matricula" id="txt_matricula">
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
        <label class="col-sm-6 control-label">Correo institucional:</label>
        <div class="col-sm-6">
          <input type="text" class="form-control" name="txt_correo" id="txt_correo">
        </div>
      </div>
    </div>
    <div class="box-footer">
      <button onclick="sav_nuevo_alumno(<?php echo $IdCampus; ?>,<?php echo $IdCiclo; ?>, '<?php echo $Tipo; ?>')" type="button" class="btn btn-danger pull-right"><i class="fa fa-fw fa-check-circle-o"></i> Guardar alumno nuevo</button>
    </div>
  </form>
</div>



<script>


  function sav_nuevo_alumno(IdCampus, IdCiclo, Tipo) {
    var IdGrupo = document.getElementById("txt_grupo").value;
    var Matricula = document.getElementById("txt_matricula").value;
    var Nombre = document.getElementById("txt_nombre").value;
    var Paterno = document.getElementById("txt_paterno").value;
    var Materno = document.getElementById("txt_materno").value;
    var Correo = document.getElementById("txt_correo").value;
    
    if (IdGrupo == "") {
      swal("Error al guardar", "Debe seleccionar el grupo.", "error");
      document.getElementById("txt_grupo").focus();
      return 0;
    }
    if (Matricula == "") {
      swal("Error al guardar", "Debe escribir la matricula.", "error");
      document.getElementById("txt_matricula").focus();
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
    if (Correo == "") {
      swal("Error al guardar", "Debe escribir el correo institucional del alumno.", "error");
      document.getElementById("txt_materno").focus();
      return 0;
    }

    var TipoGuardar = "sav_new_alumno_id";
    swal({
        title: "\u00BFEst\u00E1 seguro que desea guardar los datos de este nuevo alumno?",
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
              url: "vistas/escolar/guardar_datos_escolar.php",
              method: "POST",
              data: {
                TipoGuardar: TipoGuardar,
                IdCampus: IdCampus,
                IdCiclo: IdCiclo,
                Tipo: Tipo,
                IdGrupo: IdGrupo,
                Matricula: Matricula,
                Nombre: Nombre,
                Paterno: Paterno,
                Materno: Materno,
                Correo: Correo
              },
              success: function(data) {
                
              }
            })
            .done(function(data) {
              if (data == 0) {
                swal("Error al guardar", "Este proceso no se pudo realizar favor de revisar.", "error");
              }
              if (data == 1) {
                swal("Guardado correctamente", "Los datos del alumno se han guardado correctamente.", "success");
                var idPeriodo = 0;
                load_user_lista(0,0,'X');
              }
              if (data == 3) {
                swal("Error al guardar", "Favor de verificar el pago de reinscripción.", "error");
              }
              if (data == 2) {
                swal("Error al guardar", "Favor de verificar el pago de las mensualidades.", "error");
              }
              if (data == 4) {
                swal("Error al guardar", "El periodo escolar seleccionado ya se encuentra inicializado.", "error");
              }

              if (data == 5) {
                swal("Error al guardar", "La matricula del alumno ya se encuentra registrada en el sistema SCIUDY.", "error");
              }

            })
            .error(function(data) {
              swal("Error al agregar 0x130", "No se puede actualizar, comuniquese con el desarrollador.", "error");
            });
        }
      });
  }
</script>