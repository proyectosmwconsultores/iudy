<?php
require('php/clases/class.php');
include("php/estructura/session.php");
$t=new Trabajo();
$IdForo = $_POST["IdForo"];
$ForoRespuestas1=$t->get_datosrespuestas1X($_SESSION['IdAsignacion'],$IdForo);
?>
<input id="Id" name="Id" value="<?php echo $_SESSION["IdAsignacion"]; ?>" type="hidden"/>
<div class="direct-chat-messages">
<?php for ($x=0;$x< sizeof($ForoRespuestas1);$x++) { $IdComentario = $ForoRespuestas1[$x]["IdForo"]; ?>
<div class="direct-chat-msg">
   <div class="direct-chat-info clearfix">
     <span class="direct-chat-name pull-left"><?php echo $ForoRespuestas1[$x]["Nombre"].' '.$ForoRespuestas1[$x]["APaterno"].' '.$ForoRespuestas1[$x]["AMaterno"]; ?></span>
     <span class="direct-chat-timestamp pull-right"><i class="fa fa-clock-o"></i> <?php echo $ForoRespuestas1[$x]["FecCap"]; ?></span>
   </div>
   <img class="direct-chat-img" src="assets/perfil/<?php echo $ForoRespuestas1[$x]["Foto"]; ?>" alt="Message User Image"><!-- /.direct-chat-img -->
   <div class="direct-chat-text">
     <div style="text-align: justify;">
       <p><?php echo $ForoRespuestas1[$x]["Mensaje"];  ?></p>
     </div>
   </div>
</div>
<?php } ?>
</div>
<?php if($x ==20){ ?>
<button id="btn2-<?php echo $IdForo; ?>" onclick="mostrarMas2(<?php echo $IdForo; ?>)" type="button" class="btn btn-block btn-primary btn-sm">Clic para cargar más comentarios.</button>

<div id="capa2-<?php echo $IdForo; ?>">
  <p style="text-align: center; padding: 10px;">
    <b>En este espacio podrás visualizar los demas comentarios.</b>
  </p>

</div>
<?php } ?>
