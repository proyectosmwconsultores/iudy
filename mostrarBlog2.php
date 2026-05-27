<?php
require('php/clases/class.php');
include("php/estructura/session.php");
$t=new Trabajo();
$IdForo = $_POST["IdForo"];
$ForoRespuestas2=$t->get_datosrespuestas2X($_SESSION['IdAsignacion'],$IdForo);
?>
<input id="Id" name="Id" value="<?php echo $_SESSION["IdAsignacion"]; ?>" type="hidden"/>
<?php for ($y=0;$y< sizeof($ForoRespuestas2);$y++) { $IdComentario = $ForoRespuestas2[$y]["IdForo"]; ?>
<div class="box-body chat" id="chat-box" style="overflow: hidden; width: auto;">
    <div class="item">
      <img src="assets/perfil/<?php echo $ForoRespuestas2[$y]["Foto"]; ?>" alt="user image" class="online">

      <p class="message">
        <a href="#" class="name">
          <small class="text-muted pull-right"> <i class="fa fa-clock-o"></i> <?php echo $ForoRespuestas2[$y]["FecCap"]; ?> </small>
          <?php echo $ForoRespuestas2[$y]["Nombre"].' '.$ForoRespuestas2[$y]["APaterno"].' '.$ForoRespuestas2[$y]["AMaterno"]; ?>
        </a>
        <?php echo $ForoRespuestas2[$y]["Mensaje"];  ?>
      </p>
  </div>
</div>
<?php } ?>

<?php if($y ==20){ ?>
<button id="btn3-<?php echo $IdForo; ?>" onclick="mostrarMas3(<?php echo $IdForo; ?>)" type="button" class="btn btn-block btn-primary btn-sm">Clic para cargar más comentarios.</button>
<div id="capa3-<?php echo $IdForo; ?>">
  <p style="text-align: center; padding: 10px;">
    <b>En este espacio podrás visualizar los demas comentarios.</b>
  </p>
</div>
<?php } ?>
