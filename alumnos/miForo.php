<?php session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $idAsignacion = $_POST["idAsignacion"];
  $IdParcial = $_POST["IdParcial"];
  $IdActividad = $_POST["IdActividad"];
  $IdUsua = $_SESSION["IdUsua"];

  $sql_act = $db->query("SELECT tblp_actividadesdocente.NomActividad, tblp_actividadesdocente.IdEstatus, tblp_actividadesdocente.NomActividad, tblp_actividadesdocente.DesActividad FROM tblp_actividadesdocente WHERE tblp_actividadesdocente.IdActividadesDocente = '$IdActividad'");
  $db->rows($sql_act);
  $datos_act = $db->recorrer($sql_act);

  $sql_chat = $db->query("SELECT tblp_foro.IdForo, tblp_foro.Total, tblp_foro.Mensaje, tblp_foro.FecCap, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Foto FROM tblp_foro Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_foro.IdUsua WHERE tblp_foro.IdActividad = '$IdActividad' AND tblp_foro.IdAsignacion = '$idAsignacion' ORDER BY tblp_foro.FecCap");

  $sql8 = $db->query("SELECT tblp_tareas.IdTarea FROM tblp_tareas WHERE tblp_tareas.IdAsignacion = '$idAsignacion' AND tblp_tareas.IdActividadesDocente = '$IdActividad' AND tblp_tareas.IdAlumno= '$IdUsua'");
  $db->rows($sql8);
  $datos81 = $db->recorrer($sql8);
  $IdTarea = $datos81["IdTarea"];
  if(!$IdTarea){
    $insertar = $db->query("INSERT INTO tblp_tareas (IdAsignacion, IdAlumno, IdActividadesDocente, IdParcialDocente, FecCap) VALUES ('$idAsignacion','$IdUsua','$IdActividad','$IdParcial',NOW())");
  }

  ?>
  <form name="frm" id="frm" action="doSelActa.php" method="POST" enctype="multipart/form-data">
    <input id="idAsignacion" name="idAsignacion" value="<?php echo $_POST["idAsignacion"]; ?>" type="hidden"/>
    <input id="IdActividad-<?php echo $IdActividad; ?>" name="IdActividad-<?php echo $IdActividad; ?>" value="<?php echo $_POST["IdActividad"]; ?>" type="hidden"/>
    <input id="IdUsua" name="IdUsua" value="<?php echo $_SESSION["IdUsua"]; ?>" type="hidden"/>
    <input id="IdParcial-<?php echo $IdActividad; ?>" name="IdParcial-<?php echo $IdActividad; ?>" value="<?php echo $_POST["IdParcial"]; ?>" type="hidden"/>

    <div class="box-body">
      <?php if($datos_act['IdEstatus'] == 8){ ?>
      <div class="form-group">
        <textarea name="txtChat-<?php echo $IdActividad; ?>" id="txtChat-<?php echo $IdActividad; ?>" class="textarea" placeholder="Escriba su comentario..." style="width: 100%; height: 150px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
        <button type="button" onclick="addResponder(<?php echo $IdActividad; ?>)" class="btn btn-info pull-right">Comentar</button>
      </div><br><?php } ?>
      <div class="direct-chat-messages">
        <?php while($chat_ = $db->recorrer($sql_chat)){ ?>
          <div class="direct-chat-msg">
            <div class="direct-chat-info clearfix">
              <span class="direct-chat-name pull-left"><?php echo $chat_['Nombre'].' '.$chat_['APaterno'].' '.$chat_['AMaterno']; ?></span>
              <span class="direct-chat-timestamp pull-right"><?php echo $chat_['FecCap']; ?> <!--23 Jan 2:00 pm--></span>
            </div>
            <img class="direct-chat-img" src="assets/perfil/<?php echo $chat_['Foto']; ?>" alt="Message User Image"><!-- /.direct-chat-img -->
            <div class="direct-chat-text">
              <div style="text-align: justify;">
                <?php echo $chat_['Mensaje']; ?>
              </div>
              <button onclick="newRespuesta(<?php echo $chat_['IdForo']; ?>)" type="button" class="btn btn-default btn-xs"><i class="fa fa-wechat"></i> <?php echo $chat_["Total"];  ?> Comentarios</button>
            </div>


            <!-- <span class="pull-right text-muted"> <span class="label label-info" style="margin-left: 5px;"><i class="fa fa-fw fa-wechat"></i> 2 comentarios</span></span>
            <span class="pull-right text-muted"><span style="cursor: pointer;" onclick="addRes_comen(<?php echo $IdActividad; ?>)" class="label label-success" style="margin-left: 5px;"><i class="fa fa-fw fa-mail-reply-all"></i> Responder</span></span> -->
          </div>
      <?php } ?>
      </div>
  </div>
</form>

<script src="bower_components/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script>

function addResponder(IdActividad){
  var Chat = document.getElementById("txtChat-"+IdActividad).value;
  var IdAsignacion = document.getElementById("idAsignacion").value;
  var IdUsua = document.getElementById("IdUsua").value;
  var IdParcial = document.getElementById("IdParcial-"+IdActividad).value;

  var TipoGuardar = "add_chat";
  if (Chat == ""){
    swal("Error al comentar", "Debe escribir su comentario.", "error");
    document.getElementById(Texto).focus();
    return 0;
  }
    $.ajax({
      type:"POST",
      url:"alumnos/setting.php",
      data:{Chat:Chat,IdUsua:IdUsua,IdAsignacion:IdAsignacion,IdActividad:IdActividad, TipoGuardar:TipoGuardar},
      success:function(data){
      }
    })
    .done(function(data) {
      if(data==1){
        swal("Comentario publicado", "Su comentario ha sido publicado correctamente.", "success");
        cargarForo();
      }else{
        swal("Error al comentar", "No se puede publicar su comentario.", "error");
      }
    })


}


$(function () {

  //bootstrap WYSIHTML5 - text editor
  $('.textarea').wysihtml5()
})

</script>
