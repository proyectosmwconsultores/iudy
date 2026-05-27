<?php
  session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();

  $IdUsua = $_POST["IdUsua"];
  $IdTipo = $_POST["IdTipo"];

  $sql8 = $db->query("SELECT tblc_usuario.IdEstatus, tblc_usuario.IdUsua, tblp_grupo.TipoCiclo FROM tblc_usuario Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_usuario.IdGrupo WHERE tblc_usuario.IdUsua = '$IdUsua'");
  $db->rows($sql8);
  $datos81 = $db->recorrer($sql8);
  $_TipoCiclo = $datos81['TipoCiclo'];
  $_IdEstatus = $datos81['IdEstatus'];
  if($_TipoCiclo == 'C'){
    $tipoc = "CUATRIMESTRE";
  } else {
    $tipoc = "SEMESTRE";
  }

  if($IdTipo == 3){
    $cond_x = " WHERE tblc_ciclo.Tipo = '$tipoc' ";
  } else {
    $cond_x = " ";
  }

  $sql1 = $db->query("SELECT * FROM tblc_ciclo $cond_x ORDER BY tblc_ciclo.FInicio DESC");
  $sql2 = $db->query("SELECT tblh_bajausuario.IdBaja, tblh_bajausuario.Comentario, tblh_bajausuario.FecCap, tblc_ciclo.Ciclo, tblc_estatus.Estatus FROM tblh_bajausuario Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblh_bajausuario.IdCiclo Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblh_bajausuario.IdEstatus WHERE tblh_bajausuario.IdUsua = '$IdUsua' ORDER BY tblh_bajausuario.FecCap DESC ");

  ?>
  <form name="frm2xfYj" id="frm2xfYj" action="addNewPago.php" method="POST" enctype="multipart/form-data" class="form-horizontal">
    <input id="IdUsua" name="IdUsua" value="<?php echo $IdUsua; ?>" type="hidden"/>
    <?php if($_IdEstatus == 8){ ?>
    <div class="box-body">
          <div class="form-group">
            <label class="col-sm-6 control-label">Seleccione tipo de baja:</label>
            <div class="col-sm-6">
              <select class="form-control" name="txtEstatus" id="txtEstatus">
                <option value=""> - Seleccione - </option>
                <?php if($IdTipo == 3){ ?>
                <option value="20"> BAJA POR DESERCION</option>
                <option value="18"> BAJA POR REPROBACION</option>
                <?php } else { ?>
                <option value="9"> INACTIVO</option>
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
            <label class="col-sm-6 control-label">Fecha de baja:</label>
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
          <label class="control-label" style="color: red;"><i class="fa fa-times-circle-o"></i>
            Nota: Al dar de baja un alumno, automáticamente si tiene pagos pendientes se quedan en estatus de congelado.
          </label>

      </div>
    <div class="box-footer">
      <button type="button" class="btn btn-block btn-info btn" onClick="capBaja(<?php echo $IdUsua; ?>,<?php echo $IdTipo; ?>,<?php echo $_SESSION['IdUsua']; ?>)" > <i class="fa fa-save"></i> Guardar configuraci&oacute;n</button></td>
    </div>
    <hr><?php } ?>
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
function capBaja(IdUsua,IdTipo,IdAdmin){
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

    var TipoGuardar = "savBajaAlum";
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
             data:{TipoGuardar:TipoGuardar, Estatus:Estatus, Comentario:Comentario, Ciclo:Ciclo, IdUsua:IdUsua, IdTipo:IdTipo, Fecha:Fecha, IdAdmin:IdAdmin },
             success:function(data){

               $.ajax({
					 				 url:"formConsulta/bajasAlumno.php",
					 				 method:"POST",
					 				 data:{IdUsua:IdUsua, IdTipo:IdTipo},
					 				 success:function(data){
					 							$('#employee_Grp').html(data);
					 							$('#dataGrp').modal('show');
					 				 }
					 		});

             }
        })
      }
    });

}

function actAvCampsId(IdCampus,IdDocs,Valor){
  var TipoGuardar = "savCampsIdAss";

  $.ajax({
       url:"formConsulta/setting.php",
       method:"POST",
       data:{TipoGuardar:TipoGuardar, IdCampus:IdCampus, IdDocs:IdDocs, Valor:Valor},
       success:function(data){
         $.ajax({
             url:"formConsulta/calendarioCampus.php",
             method:"POST",
             data:{IdDocs:IdDocs},
             success:function(data){
                  $('#employee_Grp').html(data);
                  $('#dataGrp').modal('show');
             }
        });
       }
  })
}

</script>

<script>

  $(function () {

    $('#txtFecha').datepicker({
      autoclose: true
    })

  })
</script>
