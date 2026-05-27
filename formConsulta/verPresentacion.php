<?php
session_start();
require('../php/clases/class.System.php');
$db = new Conexion();
$IdSemanaDoc = $_POST["IdSemana"];


$sql9 = $db->query("SELECT tblp_semanadocente.Tipo, tblp_semanadocente.Nombre, tblp_semanadocente.Code FROM tblp_semanadocente WHERE tblp_semanadocente.IdSemanaDocente = '$IdSemanaDoc' ");
$db->rows($sql9);
$datos91 = $db->recorrer($sql9);


  ?>

  <form name="frm2s_Far" id="frm2s_Far" action="updSemana.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="nom_" id="nom_" value="<?php echo $datos91["Nombre"]; ?>">
    <div class="box box-primary" style="border-top: none;">
      <div class="box-body">
        <div class="col-md-12">
          <?php echo $datos91["Code"]; ?>
        </div>
      </div>
    </div>
  </form>
<script>
$(document).ready(function(){
  var nom_ = document.getElementById("nom_").value;
  document.getElementById('lbl_Pre').innerHTML = nom_;

});
</script>
