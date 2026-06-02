<?php
session_start();
require('../php/clases/class.System.php');
$db = new Conexion();

 $IdUsua = substr($_POST["Token"], 10, 10);
$IdTipo = 3;

$sql8 = $db->query("SELECT tblc_usuario.IdEstatus, tblc_usuario.IdUsua, tblp_grupo.TipoCiclo FROM tblc_usuario Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_usuario.IdGrupo WHERE tblc_usuario.IdUsua = '$IdUsua'");
$db->rows($sql8);
$datos81 = $db->recorrer($sql8);
$_TipoCiclo = $datos81['TipoCiclo'];
$_IdEstatus = $datos81['IdEstatus'];
if ($_TipoCiclo == 'C') {
  $tipoc = "CUATRIMESTRE";
} elseif ($_TipoCiclo == 'T') {
  $tipoc = "TRIMESTRE";
} else {
  $tipoc = "SEMESTRE";
}

if ($IdTipo == 3) {
  $cond_x = " AND tblc_ciclo.Tipo = '$tipoc' ";
} else {
  $cond_x = " ";
}

$_anio = date("Y");
$_hoy = date("Y-m-d");
$_hoy = date("Y-m-d",strtotime($_hoy."- 12 month"));

$sql1 = $db->query("SELECT tblc_alumnos.IdActivo, tblc_alumnos.IdCiclo, tblc_ciclo.Ciclo FROM tblc_alumnos Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblc_alumnos.IdCiclo WHERE tblc_alumnos.IdUsua =  '$IdUsua' ORDER BY tblc_ciclo.FInicio DESC LIMIT 3");
// $sql1 = $db->query("SELECT
// tblc_ciclo.IdCiclo,
// tblc_ciclo.Ciclo
// FROM
// tblc_ciclo
// WHERE
// tblc_ciclo.Tipo =  '$tipoc' AND tblc_ciclo.FInicio >= '$_hoy'
// ORDER BY
// tblc_ciclo.FInicio ASC LIMIT 5
// ");

$sql2 = $db->query("SELECT tblh_bajausuario.IdBaja, tblh_bajausuario.Comentario, tblh_bajausuario.IdEstatus, tblh_bajausuario.FecCap, tblc_ciclo.Ciclo, tblc_estatus.Estatus FROM tblh_bajausuario Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblh_bajausuario.IdCiclo Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblh_bajausuario.IdEstatus WHERE tblh_bajausuario.IdUsua = '$IdUsua' ORDER BY tblh_bajausuario.FecCap DESC ");

?>
<form name="frm2xfYj" id="frm2xfYj" action="addNewPago.php" method="POST" enctype="multipart/form-data" class="form-horizontal">
  <input id="IdUsua" name="IdUsua" value="<?php echo $IdUsua; ?>" type="hidden" />
  <?php if (($_IdEstatus == 8) || ($_IdEstatus == 14) || ($_IdEstatus == 15)) { ?>
    <div class="box-body">
      <div class="form-group">
        <label class="col-sm-6 control-label">Seleccione tipo:</label>
        <div class="col-sm-6">
          <select class="form-control" name="txtEstatus" id="txtEstatus" onchange="sel_estatus()">
            <option value=""> - Seleccione - </option>
            <?php if ($_IdEstatus == 8) { ?>
              <option value="14"> BAJA TEMPORAL</option>
              <option value="15"> BAJA DEFINITIVA</option>
            <?php } else { ?>
              <option value="14"> BAJA TEMPORAL</option>
              <option value="15"> BAJA DEFINITIVA</optio>
            <?php } ?>
          </select>
        </div>
      </div>
      <div style="display: none;" id="div_estatus">
        <div class="form-group">
          <label class="col-sm-6 control-label">Seleccione motivo:</label>
          <div class="col-sm-6">
            <select class="form-control" name="txtMotivo" id="txtMotivo">
              <option value=""> - Seleccione - </option>
              <option value="16"> VOLUNTARIA</option>
              <option value="17"> ACADEMICA</option>
              <option value="18"> ADMINISTRATIVA</option>
            </select>
          </div>
        </div>
      </div>
      
      <div class="form-group">
        <label class="col-sm-6 control-label">Periodo escolar:</label>
        <div class="col-sm-6">
          <select class="form-control" name="txtCiclo_baja" id="txtCiclo_baja">
            <option value=""> - Seleccione - </option>
            <?php while ($x = $db->recorrer($sql1)) { ?>
              <option value="<?php echo $x["IdCiclo"]; ?>"> <?php echo $x["Ciclo"]; ?> </option>
            <?php } ?>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-6 control-label">Fecha:</label>
        <div class="col-sm-6">
          <input type="text" class="form-control" id="txtFecha" name="txtFecha">
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-3 control-label">Comentario:</label>
        <div class="col-sm-9">
          <textarea class="form-control" rows="3" name="txtComentario" id="txtComentario" placeholder="Escriba un mensaje al usuario ..."></textarea>
        </div>
      </div>
      <p class="control-label" style="color: red; text-align: left;"><i class="fa fa-warning"></i>
        Nota al ejecutar el guardado:
      <ul>
        <li>Al dar de <b>baja un alumno</b>, automáticamente si tiene pagos pendientes se quedan en estatus de congelado.</li>
      </ul>
      </p>

    </div>
    <div class="box-footer">
      <button type="button" class="btn btn-block btn-info btn" onClick="ejecutar_baja(<?php echo $IdUsua; ?>,<?php echo $_SESSION['IdUsua']; ?>)"> <i class="fa fa-save"></i> Guardar configuraci&oacute;n</button></td>
    </div>
    <hr><?php } ?>
  <table class="table table-striped" style="font-size: 12px;">
    <tbody>
      <tr>
        <th style="width: 10px">#</th>
        <th>Comentario</th>
        <th>Periodo</th>
        <th>Estatus</th>
        <th>FecCap</th>
        <th></th>
      </tr>
      <?php $h = 0;
      while ($y = $db->recorrer($sql2)) { ?>
        <tr>
          <td><b><?php echo $h = $h + 1; ?>.- </b></td>
          <td><?php echo $y["Comentario"]; ?></td>
          <td><?php echo $y["Ciclo"]; ?></td>
          <td><?php echo $y["Estatus"]; ?></td>
          <td><?php echo $y["FecCap"]; ?></td>
          <td>
          <?php if(($y["IdEstatus"] == 14) || (($y["IdEstatus"] == 15))){ ?>
          <button type="button" class="btn bg-teal btn-flat" onclick="javascript:window.open('repositorio/formatos/formato_baja.php?idToks=<?php echo time().$y["IdBaja"]; ?>');" href="javascript:void(0);"><i class="fa fa-file-pdf-o"></i></button>
          <?php } ?>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>



</form>
<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

<script>

function sel_estatus(){
  var IdEstatus = document.getElementById("txtEstatus").value;
  if(IdEstatus == 55){
    document.getElementById("div_estatus").style.display = 'none';
  }
  else {
    document.getElementById("div_estatus").style.display = 'block';
  }
}


  function ejecutar_baja(IdUsua, IdAdmin) {
    var Estatus = document.getElementById("txtEstatus").value;
    var Motivo = document.getElementById("txtMotivo").value;
    var Comentario = document.getElementById("txtComentario").value;
    var Fecha = document.getElementById("txtFecha").value;
    var Ciclo = document.getElementById("txtCiclo_baja").value;

    if (Estatus == "") {
      swal("Error al guardar", "Debe seleccionar el tipo de baja.", "error");
      document.getElementById("txtEstatus").focus();
      return 0;
    }

    if (Motivo == "") {
      swal("Error al guardar", "Debe seleccionar el motivo de baja.", "error");
      document.getElementById("txtMotivo").focus();
      return 0;
    }
    if (Ciclo == "") {
      swal("Error al guardar", "Debe indicar la fecha de baja.", "error");
      document.getElementById("txtCiclo_baja").focus();
      return 0;
    }
    if (Comentario == "") {
      swal("Error al guardar", "Debe escribir un comentario.", "error");
      document.getElementById("txtComentario").focus();
      return 0;
    }

    var TipoGuardar = "del_alumno_x";
    swal({
        title: "\u00BFEst\u00E1 seguro que desea guardar estos cambios?",
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
            url: "formConsulta/setting.php",
            method: "POST",
            data: {
              TipoGuardar: TipoGuardar,
              Estatus: Estatus,
              Comentario: Comentario,
              Ciclo: Ciclo,
              IdUsua: IdUsua,
              Fecha: Fecha,
              IdAdmin: IdAdmin,
              Motivo: Motivo
            },
            success: function(data) {

              parent.location.href = 'perfil.php?token=1653615028' + IdUsua; //direcciona la pagina madre

            }
          })
        }
      });

  }

  
</script>

<script>
  $(function() {

    $('#txtFecha').datepicker({
      autoclose: true
    })

  })
</script>