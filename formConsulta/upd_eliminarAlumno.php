<?php
  session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();

  $IdUsua = $_POST["IdUsua"];

  $sql8 = $db->query("SELECT tblc_usuario.IdEstatus, tblc_usuario.IdUsua, tblp_grupo.TipoCiclo FROM tblc_usuario Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_usuario.IdGrupo WHERE tblc_usuario.IdUsua = '$IdUsua'");
  $db->rows($sql8);
  $datos81 = $db->recorrer($sql8);
  $_TipoCiclo = $datos81['TipoCiclo'];
  $_IdEstatus = $datos81['IdEstatus'];


  $sql1 = $db->query("SELECT * FROM tblc_ciclo ORDER BY tblc_ciclo.FInicio DESC");
  $sql2 = $db->query("SELECT tblh_bajausuario.IdBaja, tblh_bajausuario.Comentario, tblh_bajausuario.FecCap, tblc_ciclo.Ciclo, tblc_estatus.Estatus FROM tblh_bajausuario Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblh_bajausuario.IdCiclo Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblh_bajausuario.IdEstatus WHERE tblh_bajausuario.IdUsua = '$IdUsua' ORDER BY tblh_bajausuario.FecCap DESC ");

  ?>
  <form name="frm2xfYj" id="frm2xfYj" action="addNewPago.php" method="POST" enctype="multipart/form-data" class="form-horizontal">
    <input id="IdUsua" name="IdUsua" value="<?php echo $IdUsua; ?>" type="hidden"/>
    <div class="box-body">
          <div class="form-group">
            <label class="col-sm-6 control-label">Seleccione tipo:</label>
            <div class="col-sm-6">
              <select class="form-control" name="txtEstatus" id="txtEstatus">
                <option value=""> - Seleccione - </option>
                <?php if($_IdEstatus == 14){ ?>
                  <option value="14" <?php if($_IdEstatus == 14){ ?>selected="selected"<?php } ?>> BAJA TEMPORAL</option>
                <?php } else { ?>
                  <option value="20" <?php if($_IdEstatus == 20){ ?>selected="selected"<?php } ?>> BAJA POR DESERCION</option>
                  <option value="18" <?php if($_IdEstatus == 18){ ?>selected="selected"<?php } ?>> BAJA POR REPROBACION</option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-6 control-label">Periodo en el que se de baja:</label>
            <div class="col-sm-6">
              <select class="form-control" name="txtCiclo" id="txtCiclo">
                <option value=""> - Seleccione - </option>
                <?php while($x = $db->recorrer($sql1)){ ?>
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
            Nota al ejecutar el guardado: <ul>
                  <li>Al dar de <b>baja un alumno</b>, automáticamente si tiene pagos pendientes se quedan en estatus de congelado y se verá reflejado la baja en el Registro de Escolaridad.</li>
                  <li>Al dar de <b>baja temporal</b> el alumno se le congela los pagos que tenga pendientes y no va aparecer en el registro de escolaridad.</li>
                </ul>
          </p>

      </div>
    <div class="box-footer">
      <button type="button" class="btn btn-block btn-info btn" onClick="ejecutar_bajax(<?php echo $IdUsua; ?>,<?php echo $_SESSION['IdUsua']; ?>,<?php echo $_POST["IdCiclo"]; ?>,<?php echo $_POST["IdCampus"]; ?>)" > <i class="fa fa-save"></i> Guardar configuraci&oacute;n</button></td>
    </div>
    <hr>
    <table class="table table-striped" style="font-size: 12px;">
                <tbody><tr>
                  <th style="width: 10px">#</th>
                  <th>Comentario</th>
                  <th>Periodo</th>
                  <th>Estatus</th>
                  <th>FecCap</th>
                </tr>
                <?php $h = 0; while($y = $db->recorrer($sql2)){ ?>
                <tr>
                  <td><b><?php echo $h = $h + 1; ?>.- </b></td>
                  <td><?php echo $y["Comentario"]; ?></td>
                  <td><?php echo $y["Ciclo"]; ?></td>
                  <td><?php echo $y["Estatus"]; ?></td>
                  <td><?php echo $y["FecCap"]; ?></td>
                </tr>
                <?php } ?>
              </tbody></table>



  </form>
<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

<script>
function ejecutar_bajax(IdUsua,IdAdmin,IdCiclo,IdCampus){
  var Estatus = document.getElementById("txtEstatus").value;
  var Comentario = document.getElementById("txtComentario").value;
  var Fecha = document.getElementById("txtFecha").value;
	var Ciclo = document.getElementById("txtCiclo").value;

  if (Estatus==""){
		swal("Error al guardar", "Debe seleccionar el tipo de baja.", "error");
        document.getElementById("txtEstatus").focus();
        return 0;
  }
  if (Ciclo==""){
		swal("Error al guardar", "Debe seleccionar el periodo en el que se da de baja.", "error");
        document.getElementById("txtCiclo").focus();
        return 0;
  }
  if (Ciclo==""){
		swal("Error al guardar", "Debe indicar la fecha de baja.", "error");
        document.getElementById("txtCiclo").focus();
        return 0;
  }
	if (Comentario==""){
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
    function (isConfirm) {
      if(isConfirm) {
        $(".confirm").attr('disabled', 'disabled');
        $.ajax({
             url:"formConsulta/setting.php",
             method:"POST",
             data:{TipoGuardar:TipoGuardar, Estatus:Estatus, Comentario:Comentario, Ciclo:Ciclo, IdUsua:IdUsua, Fecha:Fecha, IdAdmin:IdAdmin },
             success:function(data){
               cargar_lista_bajas();
               $('#dataModal_del').modal('hide');

             }
        })
      }
    });

}


</script>

<script>

  $(function () {

    $('#txtFecha').datepicker({
      autoclose: true
    })

  })
</script>
