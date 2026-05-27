<?php
  session_start();
  include('../hace.php');
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdUsua = $_POST["IdUsua"];
  $IdDocente = $_POST["IdDocente"];

  $sql_s = $db->query("SELECT * FROM tblc_tipo_seguimiento ");

  $sql_lst = $db->query("SELECT
tblp_seguimiento_docente.Fecha,
tblp_seguimiento_docente.FecCap,
tblp_seguimiento_docente.Comentario_control,
tblp_seguimiento_docente.Comentario_usuario,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_tipo_seguimiento.Seguimiento
FROM
tblp_seguimiento_docente
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_seguimiento_docente.IdUsua_admin
Left Join tblc_tipo_seguimiento ON tblc_tipo_seguimiento.IdTipoSeguimiento = tblp_seguimiento_docente.IdTipoSeguimiento
WHERE tblp_seguimiento_docente.IdUsua = '$IdDocente'
ORDER BY
tblp_seguimiento_docente.FecCap DESC");
  ?>
  <div class="box-body">
                <form role="form">
                  <div class="form-group">
                    <label>Tipo de seguimiento:</label>
                    <select class="form-control" name="txt_seg" id="txt_seg">
                      <option value=""> - Seleccione - </option>
                      <?php while($_seg = $db->recorrer($sql_s)){ ?>
                      <option value="<?php echo $_seg['IdTipoSeguimiento']; ?>"><?php echo $_seg['Seguimiento']; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                  <!-- textarea -->
                  <div class="form-group">
                    <label>Comentario del departamento:</label>
                    <textarea class="form-control" rows="3" name="txt_asesor" id="txt_asesor"></textarea>
                  </div>
                  <div class="form-group">
                    <label>Comentario del docente:</label>
                    <textarea class="form-control" rows="3" name="txt_alumno" id="txt_alumno"></textarea>
                  </div>
                  <div class="box-footer">
                    <button onclick="save_chat_usxd(<?php echo $IdUsua; ?>,<?php echo $IdDocente; ?>)" type="button" class="btn btn-info pull-right">Guardar seguimiento</button>
                  </div>
                </form>

                <table class="table table-striped" style="font-size: 12px;">
                  <tbody><tr>
                    <th style="width: 10px">#</th>
                    <th>Fec. captura</th>
                    <th>Responsable</th>
                    <th>Tipo seguimiento</th>
                    <th>Seguimiento</th>
                    <th>Respuesta</th>
                  </tr>
                  <?php $v = 0; while($_lst = $db->recorrer($sql_lst)){ ?>
                  <tr>
                    <td><b><?php echo $v = ($v + 1); ?>.- </b></td>
                    <td><?php echo $_lst['FecCap']; ?></td>
                    <td><?php echo $_lst['Nombre']; ?></td>
                    <td><?php echo $_lst['Seguimiento']; ?></td>
                    <td><?php echo $_lst['Comentario_control']; ?></td>
                    <td><?php echo $_lst['Comentario_usuario']; ?></td>
                  </tr>
                  <?php } ?>

                  </tbody></table>
              </div>


<script>
  function save_chat_usxd(IdUsua,IdDocente){
    var IdSeguimiento = document.getElementById("txt_seg").value;
    var Asesor = document.getElementById("txt_asesor").value;
    var Alumno = document.getElementById("txt_alumno").value;

    if (IdSeguimiento ==""){
        swal("Error al guardar", "Debe seleccionar el tipo de seguimiento.", "error");
        return 0;
    }
    if (Asesor ==""){
        swal("Error al guardar", "Debe ingresar el texto de seguimiento.", "error");
        return 0;
    }

    var TipoGuardar = "sav_seg_docente";
    swal({
      title: "\u00BFEst\u00E1 seguro que desea guardar este seguimiento de este docente?",
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
             data:{TipoGuardar:TipoGuardar, IdUsua:IdUsua, IdDocente:IdDocente, IdSeguimiento:IdSeguimiento, Asesor:Asesor, Alumno:Alumno},
             success:function(data){

             }
        })
        .done(function(data) {
          if(data==1){
            swal("Guardado correctamente", "El seguimiento del docente se ha guardado correctamente.", "success");
            $.ajax({
          			 url:"formConsulta/chat_seguimiento_docente.php",
          			 method:"POST",
          			 data:{IdUsua:IdUsua, IdDocente:IdDocente},
          			 success:function(data){
          						$('#employee_detailC').html(data);
          						$('#dataModalC').modal('show');
          			 }
          	});
  				}

  				if(data==0){
  					swal("Error al actualizar", "No se puede actualizar, verifique sus datos.", "error");
  				}
  			})
  			.error(function(data) {
  				swal("Error al agregar 0x130", "No se puede actualizar, comuniquese con el desarrollador.", "error");
  			});
        // .done(function(data) {
        //   if(data==1){
        //     swal("Guardado correctamente", "El seguimiento del alumno se ha guardado correctamente.", "success");
        //     // $('#dataModalC').modal('hide');
        //     cargar_segui(IdUsua,IdAlumno);
        //   }
        //
        //   if(data==0){
        //     swal("Error al guardar", "No se puede guardar los cambios solicitados.", "error");
        //   }
        // })

      }
    });

  }
</script>
