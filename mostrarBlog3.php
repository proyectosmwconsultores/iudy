<?php
require('php/clases/class.php');
include("php/estructura/session.php");
$t=new Trabajo();
$IdForo = $_POST["IdForo"];
$ForoRespuestas3=$t->get_datosrespuestas3X($_SESSION['IdAsignacion'],$IdForo);
?>
<input id="Id" name="Id" value="<?php echo $_SESSION["IdAsignacion"]; ?>" type="hidden"/>
<?php for ($z=0;$z< sizeof($ForoRespuestas3);$z++) { $IdComentario = $ForoRespuestas3[$z]["IdForo"]; ?>
<div class="box-body chat" id="chat-box" style="overflow: hidden; width: auto;">
    <div class="item">
      <img src="assets/perfil/<?php echo $ForoRespuestas3[$z]["Foto"]; ?>" alt="user image" class="online">

      <p class="message">
        <a href="#" class="name">
          <small class="text-muted pull-right"> <i class="fa fa-clock-o"></i> <?php echo $ForoRespuestas3[$z]["FecCap"]; ?> </small>
          <?php echo $ForoRespuestas3[$z]["Nombre"].' '.$ForoRespuestas3[$z]["APaterno"].' '.$ForoRespuestas3[$z]["AMaterno"]; ?>
        </a>
        <?php echo $ForoRespuestas3[$z]["Mensaje"];  ?>
      </p>
  </div>
</div>
<?php } ?>
<?php if($z ==20){ ?>
<button id="btn4-<?php echo $IdForo; ?>" onclick="mostrarMas4(<?php echo $IdForo; ?>)" type="button" class="btn btn-block btn-primary btn-sm">Clic para cargar más comentarios.</button>
<div id="capa4-<?php echo $IdForo; ?>">
  <p style="text-align: center; padding: 10px;">
    <b>En este espacio podrás visualizar los demas comentarios.</b>
  </p>
</div>
<?php } ?>
