<?php
include('../hace.php');
if(isset($_POST["employee_id"])){
  $output = '';
  require('../php/clases/class.System.php');
  $db = new Conexion();

  $sql9 = $db->query("SELECT * FROM tblp_biblioteca WHERE tblp_biblioteca.IdBiblioteca = '".$_POST["employee_id"]."'");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);
 $link = $datos91["Link"];
$porciones = explode("=", $link);
$lik =  $porciones[1]; // porción2

?>

  <div class="modal-header" style="background: #292b33; color: white; font-size: 16px;">
       <button type="button" class="close" data-dismiss="modal">&times;</button>
       <h4 class="modal-title"><?php echo $datos91["Nombre"]; ?></h4>
  </div>
  <div class="table-responsive">
    <table class="table table-bordered">
      <div class="box box-primary" style="border-top: none;">
        <div class="box-body">
          <?php echo $datos91['Link']; ?>
        <!-- <iframe width="100%" height="315" src="https://www.youtube.com/embed/<?php echo $lik;  ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe> -->
        </div>
      </div>
    </table>
  </div>
<?php } ?>
