<?php
include('../hace.php');
if(isset($_POST["IdUsua"])){
  $output = '';
  require('../php/clases/class.System.php');
  $db = new Conexion();

  $sql9 = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.IdUsua = '".$_POST["IdUsua"]."'");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);
  $foto = $datos91["Estado"];
?>
  <div class="table-responsive">
    <table class="table table-bordered">
      <div class="box-body">
        <div class="btn-group">
          <button onclick="val_img_p(<?php echo $_POST["IdUsua"]; ?>,1)" type="button" class="btn btn-info"><i class="fa fa-fw fa-check-circle"></i> Aceptar foto de perfil</button>
          <button onclick="val_img_p(<?php echo $_POST["IdUsua"]; ?>,0)" type="button" class="btn btn-danger" style="margin-left: 10px;"><i class="fa fa-fw fa-times-circle"></i> No aceptar foto de perfil</button>
        </div><br>
        <img src="assets/perfil/<?php echo $datos91['Estado']; ?>" style="width: 100%;">
      </div>
    </table>
  </div>
<?php } ?>
