<?php
  session_start();
  include('../hace.php');
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdUsua = $_POST["IdUsua"];
  $IdAdmin = $_POST["IdAdmin"];

  $sql = $db->query("SELECT tblh_chat_notificacion.IdNotificacion, tblh_chat_notificacion.IdUsua, tblh_chat_notificacion.Chat, tblh_chat_notificacion.FecCap, tblh_chat_notificacion.IdAdmin, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Cargo, tblc_usuario.Foto FROM tblh_chat_notificacion Left Join tblc_usuario ON tblc_usuario.IdUsua = tblh_chat_notificacion.IdAdmin WHERE tblh_chat_notificacion.IdUsua = '$IdUsua'");


  ?>

  <form name="frm2" id="frm2" action="addSemblanza.php" method="POST" enctype="multipart/form-data">
  <div class="table-responsive">
    <div class="box-body">
      <div class="box-footer box-comments">
        <?php while($x2 = $db->recorrer($sql)){ ?>
        <div class="box-comment">
          <img class="img-circle img-sm" src="assets/perfil/<?php echo $x2['Foto']; ?>" alt="User Image">

          <div class="comment-text">
            <span class="username">
              <?php echo $x2['Nombre'].' '.$x2['APaterno'].' '.$x2['AMaterno'].' - '.$x2['Cargo']; ?>
              <span class="text-muted pull-right"><?php echo $x2['FecCap']; ?></span>
            </span>
            <?php echo $x2['Chat']; ?>
          </div>
        </div><?php } ?>
      </div>
    </div>
    <div class="box-footer">
      <form action="#" method="post">
        <div class="input-group">
          <input name="txtChat" id="txtChat" placeholder="Escriba el mensaje a enviar ..." class="form-control" type="text">
          <span class="input-group-btn">
                <button onclick="chat_not_user(<?php echo $IdUsua; ?>,<?php echo $_SESSION["IdUsua"]; ?>)" type="button" class="btn btn-warning btn-flat">Enviar</button>
              </span>
        </div>
      </form>
    </div>
  </div>

  </form>

<script>
  function chat_not_user(IdUsua,IdAdmin){
    var Chat = document.getElementById("txtChat").value;

    if (Chat ==""){
        swal("Error al guardar", "Debe escribir su comentario a enviar.", "error");
        return 0;
    }

    var TipoGuardar = "sav_not_mensaje";
    swal({
      title: "\u00BFEst\u00E1 seguro que desea enviar este mensaje?",
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
             data:{TipoGuardar:TipoGuardar, IdUsua:IdUsua, IdAdmin:IdAdmin, Chat:Chat},
             success:function(data){
               
             }
        })
        .done(function(data) {
          if(data==1){
            swal("Mensaje enviado", "El mensaje se ha enviado correctamente al prospecto.", "success");
            $.ajax({
        				 url:"formConsulta/chat_notificacion.php",
        				 method:"POST",
        				 data:{IdUsua:IdUsua, IdAdmin:IdAdmin},
        				 success:function(data){
        							$('#employee_detail2').html(data);
        							$('#dataModal2').modal('show');
        				 }
        		});
          }

          if(data==0){
            swal("Error al guardar", "No se puede guardar los cambios solicitados.", "error");
          }
        })

      }
    });

  }
</script>
