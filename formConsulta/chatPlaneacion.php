<?php
  session_start();
  include('../hace.php');
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdPlaneacion = $_POST["IdPlaneacion"];
  $IdAsignacion= $_POST["IdAsignacion"];
  $Tipo= $_POST["Tipo"];

  $sql = $db->query("SELECT
tblh_chatplaneacion.IdChatPlaneacion,
tblh_chatplaneacion.Tipo,
tblh_chatplaneacion.Chat,
tblh_chatplaneacion.FecCap,
tblh_chatplaneacion.Visto,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.Foto,
tblc_usuario.Cargo
FROM
tblh_chatplaneacion
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblh_chatplaneacion.IdUsua
 WHERE tblh_chatplaneacion.IdAsignacion = '$IdAsignacion' AND tblh_chatplaneacion.IdPlaneacion = '$IdPlaneacion' ");

  ?>
  <form name="frm2" id="frm2" action="addSemblanza.php" method="POST" enctype="multipart/form-data">
    <input id="IdUsua" name="IdUsua" value="<?php echo $_SESSION["IdUsua"]; ?>" type="hidden"/>
    <input id="Tipo" name="Tipo" value="<?php echo $Tipo ?>" type="hidden"/>
    <input id="IdAsignacion" name="IdAsignacion" value="<?php echo $IdAsignacion; ?>" type="hidden"/>
    <input id="IdPlaneacion" name="IdPlaneacion" value="<?php echo $IdPlaneacion; ?>" type="hidden"/>

  <div class="table-responsive">
    <table class="table table-bordered">
      <div class="col-md-12">
              <div class="box box-warning direct-chat direct-chat-warning">
                <div class="box-body">
                  <div class="direct-chat-messages">
                    <?php   while($x = $db->recorrer($sql)){ $dat = $x["Tipo"];
                      if($dat == "A"){
                        $btn1 = "";
                        $btn2 = "left";
                        $btn3 = "right";
                      } else {
                        $btn1 = " right";
                        $btn2 = "right";
                        $btn3 = "left";
                      }
                       ?>
                    <div class="direct-chat-msg<?php echo $btn1; ?>">
                      <div class="direct-chat-info clearfix">
                        <span class="direct-chat-name pull-<?php echo $btn2; ?>"><?php echo $x["Nombre"].' '.$x["APaterno"]; ?> / <?php echo $x["Cargo"]; ?></span>
                        <span class="direct-chat-timestamp pull-<?php echo $btn3; ?>"><?php echo tiempo_transcurrido($x["FecCap"]); ?></span>
                      </div>
                      <img class="direct-chat-img" src="assets/perfil/<?php echo $x["Foto"]; ?>" alt="message user image">
                      <div class="direct-chat-text">
                        <?php echo $x["Chat"]; ?>
                      </div>
                    </div>
                  <?php } ?>

                  </div>
                </div>
                <div class="box-footer">
                  <form action="#" method="post">
                    <div class="input-group">
                      <input name="txtChat" id="txtChat" placeholder="Escriba el mensaje a enviar ..." class="form-control" type="text">
                      <span class="input-group-btn">
                            <button onclick="chatPlaneacionCorp(<?php echo $_SESSION["IdUsua"]; ?>)" type="button" class="btn btn-warning btn-flat">Enviar</button>
                          </span>
                    </div>
                  </form>
                </div>
              </div>
            </div>
    </table>
  </div>

  </form>
