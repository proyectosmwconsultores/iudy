<?php
require('php/clases/class.php');
include("php/estructura/session.php");
$t=new Trabajo();
$IdForo = $_POST["IdForo"];
$ForoRespuestas4=$t->get_datosrespuestas4X($_SESSION['IdAsignacion'],$IdForo);
?>
<input id="Id" name="Id" value="<?php echo $_SESSION["IdAsignacion"]; ?>" type="hidden"/>
<?php for ($w=0;$w< sizeof($ForoRespuestas4);$w++) { $IdComentario = $ForoRespuestas4[$w]["IdForo"]; ?>
<div class="box-body chat" id="chat-box" style="overflow: hidden; width: auto;">
    <div class="item">
      <img src="assets/perfil/<?php echo $ForoRespuestas4[$w]["Foto"]; ?>" alt="user image" class="online">

      <p class="message">
        <a href="#" class="name">
          <small class="text-muted pull-right"> <i class="fa fa-clock-o"></i> <?php echo $ForoRespuestas4[$w]["FecCap"]; ?> </small>
          <?php echo $ForoRespuestas4[$w]["Nombre"].' '.$ForoRespuestas4[$w]["APaterno"].' '.$ForoRespuestas4[$w]["AMaterno"]; ?>
        </a>
        <?php echo $ForoRespuestas4[$w]["Mensaje"];  ?>
      </p>
  </div>
</div>
<?php } ?>
