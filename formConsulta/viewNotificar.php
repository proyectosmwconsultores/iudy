<?php
ob_start();
include('../hace.php');
if(isset($_POST["employee_id"])){

  $IdUsua = $_POST["employee_id"];
  $IdEncargado = $_POST["IdEncargado"];
  require('../php/clases/class.System.php');
  $db = new Conexion();

  $sql = $db->query("SELECT tblh_notificar.IdNotificar, tblh_notificar.IdUsua, tblh_notificar.Comentario, tblh_notificar.FecCap, tblh_notificar.IdPermiso, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Foto FROM tblh_notificar Left Join tblc_usuario ON tblc_usuario.IdUsua = tblh_notificar.IdCaptura WHERE tblh_notificar.IdUsua = '$IdUsua' ");

?>

  <div class="modal-header" style="background: #449F43; color: white; font-size: 16px;">
       <button type="button" class="close" data-dismiss="modal">&times;</button>
       <h4 class="modal-title">Comentarios de seguimiento</h4>
  </div>
  <div class="table-responsive">
      <div class="box-body">
        <div class="direct-chat-messages">
          <?php while($x = $db->recorrer($sql)){ ?>
          <div class="direct-chat-msg <?php if($x["IdPermiso"] == 3) { echo "right"; } ?>">
            <div class="direct-chat-info clearfix">
              <span class="direct-chat-name pull-<?php if($x["IdPermiso"] == 3) { echo "right"; } else { echo "left"; } ?>"><?php echo $x["Nombre"].' '.$x["APaterno"]; ?></span>
              <span class="direct-chat-timestamp pull-<?php if($x["IdPermiso"] == 3) { echo "left"; } else { echo "right"; } ?>"><?php echo tiempo_transcurrido($x["FecCap"]) ?></span>
            </div>
            <img class="direct-chat-img" src="assets/perfil/<?php echo $x["Foto"]; ?>" alt="message user image">
            <div class="direct-chat-text"><?php echo $x["Comentario"]; ?></div>
          </div>
        <?php } ?>

        </div>
        <div class="box-footer">
              <form class="form-horizontal" name="frm" id="frm" action="viewNotificar.php" method="POST" enctype="multipart/form-data">
                <input id="IdUsua" name="IdUsua" value="<?php echo $IdUsua; ?>" type="hidden"/>
                <input id="IdEncargado" name="IdEncargado" value="<?php echo $IdEncargado; ?>" type="hidden"/>
                <div class="input-group">
                  <input placeholder="Desea escribir algun mensaje..." class="form-control" type="text" name="txtMensaje" id="txtMensaje">
                      <span class="input-group-btn">
                        <button type="button" class="btn btn-info pull-right" onClick="val_addNotificacion()"> Enviar </button>
                      </span>
                </div>
              </form>
            </div>
      </div>
  </div>
<?php } ?>
