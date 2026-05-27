<?php
//session_start();
$IdForo = $_GET['Buscar'];
require('php/clases/class.php');
include("php/estructura/session.php");
$t=new Trabajo();
$ForoRespuestas=$t->get_datosrespuestas($_SESSION['IdAsignacion'],$IdForo);
$foro=$t->get_datosForoAlumnoId($_SESSION['IdAsignacion'],$IdForo);
$IdEs = $foro[0]['IdEstatus'];
?>
<input id="Id" name="Id" value="<?php echo $_SESSION["IdAsignacion"]; ?>" type="hidden"/>

<div class="direct-chat-messages">
  <?php if($IdEs == 8){ ?>
  <div class="form-group">
    <textarea name="txtMensaje-<?php echo $IdForo; ?>" id="txtMensaje-<?php echo $IdForo; ?>" class="textarea" placeholder="Escriba su comentario..." style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
    <button type="button" onclick="val_viewForo(<?php echo $IdForo; ?>, <?php echo $_SESSION['IdUsua']; ?>)" class="btn btn-info pull-right">Comentar</button>
  </div><br><?php } ?>

  <?php for ($i=0;$i< sizeof($ForoRespuestas);$i++) { $IdComentario = $ForoRespuestas[$i]["IdForo"]; ?>
   <div class="direct-chat-msg">
      <div class="direct-chat-info clearfix">
        <span class="direct-chat-name pull-left"><?php echo $ForoRespuestas[$i]["Nombre"].' '.$ForoRespuestas[$i]["APaterno"].' '.$ForoRespuestas[$i]["AMaterno"]; ?></span>
        <span class="direct-chat-timestamp pull-right"><i class="fa fa-clock-o"></i> <?php echo $ForoRespuestas[$i]["FecCap"]; ?></span>
      </div>
      <img class="direct-chat-img" src="assets/perfil/<?php echo $ForoRespuestas[$i]["Foto"]; ?>" alt="Message User Image"><!-- /.direct-chat-img -->
      <div class="direct-chat-text">
        <div style="text-align: justify;">
          <p><?php echo $ForoRespuestas[$i]["Mensaje"];  ?></p>
        </div>
        <button onclick="newRespuesta(<?php echo $IdComentario; ?>)" type="button" class="btn btn-success btn-xs"><i class="fa fa-wechat"></i> <?php echo $ForoRespuestas[$i]["Total"];  ?> Comentarios</button>
        <button onclick="delMensaje(<?php echo $IdComentario; ?>)" type="button" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Eliminar</button>
      </div>

   </div>
   <?php } ?>
</div>


<?php  if($i == 10){ ?>
<button id="btn1-<?php echo $IdForo; ?>" onclick="mostrarMas1(<?php echo $IdForo; ?>)" type="button" class="btn btn-block btn-primary btn-sm">Clic para cargar más comentarios.</button>

<div id="capa1-<?php echo $IdForo; ?>">
  <p style="text-align: center; padding: 10px;">
    <b>En este espacio podrás visualizar los demas comentarios.</b>
  </p>

</div>
<?php } ?>
