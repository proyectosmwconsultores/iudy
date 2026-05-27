<?php
include('../hace.php');
if(isset($_POST["employee_id"])){
  $porciones = explode("-", $_POST["employee_id"]);
  $IdTarea = $porciones[0]; // porción1
  $IdUsua = $porciones[1]; // porción2
  $Tipo = $porciones[2]; // porción2
  $IdUsua_recibe = $porciones[3]; // porción2
  $IdActividadDoc = $porciones[4]; // porción2

  $output = '';
  require('../php/clases/class.System.php');
  $db = new Conexion();

  $sql9 = $db->query("SELECT tblp_tareas.IdTarea, tblp_tareas.Comentario, tblp_tareas.FecCap, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Foto FROM tblp_tareas Inner Join tblc_usuario ON tblc_usuario.IdUsua = tblp_tareas.IdAlumno WHERE tblp_tareas.IdTarea = '$IdTarea'");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);

  $sql8 = $db->query("SELECT tblp_tareas.IdTarea, tblp_tareas.Respuesta, tblp_tareas.LinkRespuesta, tblp_tareas.FecCapRespuesta, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Foto FROM tblp_tareas Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_tareas.IdUsuaRespuesta WHERE tblp_tareas.IdTarea = '$IdTarea'");
  $db->rows($sql8);
  $datos81 = $db->recorrer($sql8);


  $sql = $db->query("SELECT tblp_tareascomentarios.IdComentario, tblp_tareascomentarios.Tipo, tblp_tareascomentarios.Comentario, tblp_tareascomentarios.FecCap, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Foto FROM tblp_tareascomentarios Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_tareascomentarios.IdUsua WHERE tblp_tareascomentarios.IdTarea = '$IdTarea'");
?>

  <div class="table-responsive">


      <div class="box-body">
        <div class="direct-chat-messages">
        <?php if($datos91["Comentario"]) { ?>

          <div class="direct-chat-msg">
            <div class="direct-chat-info clearfix">
              <span class="direct-chat-name pull-left"><?php echo $datos91["Nombre"].' '.$datos91["APaterno"].' '.$datos91["AMaterno"]; ?></span>
              <span class="direct-chat-timestamp pull-right"><?php echo tiempo_transcurrido($datos91["FecCap"]); ?></span>
            </div>
            <img class="direct-chat-img" src="assets/perfil/<?php echo $datos91["Foto"]; ?> " alt="message user image">
            <div class="direct-chat-text"><?php echo $datos91["Comentario"]; ?></div>
          </div>
        <?php } if($datos81["Respuesta"]) { ?>
          <div class="direct-chat-msg right">
            <div class="direct-chat-info clearfix">
              <span class="direct-chat-name pull-right"><?php echo $datos81["Nombre"].' '.$datos81["APaterno"].' '.$datos81["AMaterno"]; ?></span>
              <span class="direct-chat-timestamp pull-left"><?php echo tiempo_transcurrido($datos81["FecCapRespuesta"]); ?></span>
            </div>
            <img class="direct-chat-img" src="assets/perfil/<?php echo $datos81["Foto"]; ?>" alt="message user image">
            <div class="direct-chat-text">
                    <?php echo $datos81["Respuesta"]; ?>
                  </div>
          </div>
        <?php }
        while($x = $db->recorrer($sql)){
          if($x["Tipo"] == "A") { ?>

        <div class="direct-chat-msg">
          <div class="direct-chat-info clearfix">
            <span class="direct-chat-name pull-left"><?php echo $x["Nombre"].' '.$x["APaterno"].' '.$x["AMaterno"]; ?></span>
            <span class="direct-chat-timestamp pull-right"><?php echo tiempo_transcurrido($x["FecCap"]); ?></span>
          </div>
          <img class="direct-chat-img" src="assets/perfil/<?php echo $x["Foto"]; ?>" alt="message user image">
          <div class="direct-chat-text"><?php echo $x["Comentario"]; ?></div>
        </div>
<?php }
if($x["Tipo"] == "D") { ?>

<div class="direct-chat-msg right">
<div class="direct-chat-info clearfix">
  <span class="direct-chat-name pull-right"><?php echo $x["Nombre"].' '.$x["APaterno"].' '.$x["AMaterno"]; ?></span>
  <span class="direct-chat-timestamp pull-left"><?php echo tiempo_transcurrido($x["FecCap"]); ?></span>
</div>
<img class="direct-chat-img" src="assets/perfil/<?php echo $x["Foto"]; ?>" alt="message user image">
<div class="direct-chat-text"><?php echo $x["Comentario"]; ?></div>
</div>
<?php }
      }
?>

        </div>
        <div class="box-footer">
              <form class="form-horizontal" name="frm" id="frm" action="viewComentarios.php" method="POST" enctype="multipart/form-data">
              <input id="IdTarea" name="IdTarea" value="<?php echo $_POST["employee_id"]; ?>" type="hidden"/>
              <input id="IdUsua" name="IdUsua" value="<?php echo $IdUsua; ?>" type="hidden"/>
              <input id="IdUsua_recibe" name="IdUsua_recibe" value="<?php echo $IdUsua_recibe; ?>" type="hidden"/>
              <input id="IdActividadDoc" name="IdActividadDoc" value="<?php echo $IdActividadDoc; ?>" type="hidden"/>
              <input id="Tipo" name="Tipo" value="<?php echo $Tipo; ?>" type="hidden"/>
              <input id="employee_id" name="employee_id" value="<?php echo $_POST['employee_id']; ?>" type="hidden"/>

                <p id='img_cargar' style="text-align: center; display: none;"><img src="assets/images/procesando.gif"></p>

                <div class="input-group" id='btn_envio'>
                  <input placeholder="Desea escribir algun mensaje..." class="form-control" type="text" name="txtMensaje" id="txtMensaje">
                      <span class="input-group-btn" >
                        <button type="button"  class="btn btn-primary pull-right" onClick="val_respuestaTarea()"><i class="fa fa-send"></i> Enviar </button>
                      </span>
                </div>
              </form>
            </div>
      </div>

  </div>
  <?php } ?>
