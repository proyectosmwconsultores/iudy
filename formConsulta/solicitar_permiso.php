<?php
  session_start();
  include('../hace.php');
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdAsistencia = $_POST["IdAsistencia"];
  $_val = 0;
  $_tex = '';
  $sql9 = $db->query("SELECT * FROM tblp_asistencia WHERE tblp_asistencia.IdAsistencia = '$IdAsistencia' ");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);
  $_val = $datos91['Valor'];
  if($_val == 1){
    $_dis = 1;
    $_tex = "En proceso de revisión";
  }elseif($_val == 2) {
    $_dis = 1;
    $_tex = "Documento no aprobado";
  }elseif($_val == 3){
    $_dis = 2;
    $_tex = "Documento aprobado";
  } else {
    $_dis = 1;
  }

  ?>
  <div class="box-body">
    <form class="form-horizontal">
    <div class="box-body">
      <div class="form-group">
        <label>Motivo de la solicitud de permiso:</label>
        <textarea id="txt_comen" name="txt_comen" class="form-control" rows="8" placeholder="Motivo de la solicitud de permiso ..."><?php echo $datos91['Comentario']; ?></textarea>
      </div>
    </div>
    <div class="box-footer">
      <button onclick="subir_permiso(<?php echo $IdAsistencia; ?>)" type="button" class="btn btn-info pull-right"><i class="fa fa-save"></i> Solicitar permiso</button>
    </div>
  </form>


</div>

<script>
  function subir_permiso(IdAsistencia){
    var Comentario = document.getElementById("txt_comen").value;

    if (Comentario ==""){
        swal("Error al guardar", "Debe escribir la solicitud del permiso.", "error");
        return 0;
    }


    swal({
      title: "\u00BFEst\u00E1 seguro que desea realizar la solicitud del permiso?",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: '#DD6B55',
      confirmButtonText: 'Aceptar',
      cancelButtonText: "Cancelar",
    },
    function (isConfirm) {
      if(isConfirm) {
			$(".confirm").attr('disabled', 'disabled');

      var formData = new FormData();

      formData.append('IdAsistencia',IdAsistencia);
      formData.append('Comentario',Comentario);

      $.ajax({
          url: 'upload_solicitud_permiso.php',
          type: 'post',
          data: formData,
          contentType: false,
          processData: false,
          success: function(response) {

          }
      })
      .done(function(response) {
        if(response==1){
          swal("Solicitado correctamente", "El permiso se ha solicitado correctamente.", "success");
          $.ajax({
               url:"formConsulta/solicitar_permiso.php",
               method:"POST",
               data:{IdAsistencia:IdAsistencia},
               success:function(data){
                    $('#employee_tar').html(data);
                    $('#dataTar').modal('show');
               }
          });
        }else{
          swal("Error al guardar", "No se puede guardar los datos.", "error");
        }
      })
      .error(function(data) {
        swal("Error al mostrar 0x15", "No se puede agregar, comuniquese con el desarrollador", "error");
      });


		}
    });

  }
</script>
