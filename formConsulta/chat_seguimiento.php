<?php
  session_start();
  include('../hace.php');
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdUsua = $_POST["IdUsua"];
  $IdAlumno = $_POST["IdAlumno"];
  $_tp = $_POST["Cic"];
  $anio = date("Y");

  $sql_c = $db->query("SELECT * FROM tblc_ciclo WHERE tblc_ciclo.Tipo = '$_tp' ORDER BY tblc_ciclo.FInicio DESC LIMIT 5 ");
  $sql_s = $db->query("SELECT * FROM tblc_tipo_seguimiento ");
  ?>
  <div class="box-body">
                <form role="form">
                  <div class="form-group">
                    <label>Periodo escolar:</label>
                    <select class="form-control" name="txt_cic" id="txt_cic">
                      <option value=""> - Seleccione - </option>
                      <?php while($_cic = $db->recorrer($sql_c)){ ?>
                      <option value="<?php echo $_cic['IdCiclo']; ?>"><?php echo $_cic['Ciclo']; ?></option>
                      <?php } ?>
                    </select>
                  </div>
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
                    <label>Comentario del asesor:</label>
                    <textarea class="form-control" rows="3" name="txt_asesor" id="txt_asesor"></textarea>
                  </div>
                  <div class="form-group">
                    <label>Comentario del alumno:</label>
                    <textarea class="form-control" rows="3" name="txt_alumno" id="txt_alumno"></textarea>
                  </div>
                  <div class="box-footer">
                    <button onclick="save_chat_usx(<?php echo $IdUsua; ?>,<?php echo $IdAlumno; ?>)" type="button" class="btn btn-info pull-right">Guardar seguimiento</button>
                  </div>
                </form>
              </div>


<script>
  function save_chat_usx(IdUsua,IdAlumno){
    var IdCiclo = document.getElementById("txt_cic").value;
    var IdSeguimiento = document.getElementById("txt_seg").value;
    var Asesor = document.getElementById("txt_asesor").value;
    var Alumno = document.getElementById("txt_alumno").value;

    if (IdCiclo ==""){
        swal("Error al guardar", "Debe seleccionar el Periodo Escolar.", "error");
        return 0;
    }
    if (IdSeguimiento ==""){
        swal("Error al guardar", "Debe seleccionar el tipo de seguimiento.", "error");
        return 0;
    }
    if (Asesor ==""){
        swal("Error al guardar", "Debe ingresar el texto de seguimiento por parte del asesor.", "error");
        return 0;
    }

    var TipoGuardar = "sav_seg_alumno";
    swal({
      title: "\u00BFEst\u00E1 seguro que desea guardar este seguimiento de este alumno?",
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
             data:{TipoGuardar:TipoGuardar, IdUsua:IdUsua, IdAlumno:IdAlumno, IdCiclo:IdCiclo, IdSeguimiento:IdSeguimiento, Asesor:Asesor, Alumno:Alumno},
             success:function(data){

             }
        })
        .done(function(data) {
          if(data==1){
            swal("Guardado correctamente", "El seguimiento del alumno se ha guardado correctamente.", "success");
            $('#dataModalC').modal('hide');
            cargar_segui(IdUsua,IdAlumno);
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
