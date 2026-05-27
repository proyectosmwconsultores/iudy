<?php
include('../hace.php');
if(isset($_POST["IdAviso"])){
  $output = '';
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdAviso = $_POST["IdAviso"];
  $sql9 = $db->query("SELECT * FROM tblc_aviso WHERE tblc_aviso.IdAviso = '$IdAviso'");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);
  $Tipo = $datos91["Tipo"];
  $Archivo = $datos91["Archivo"];


  ?>
  <form name="frm22" id="frm22" action="addRvoe.php" method="POST" enctype="multipart/form-data" class="form-horizontal">
    <button onClick="window.open('assets/images/avisos/<?php echo $Archivo; ?>','_blank')" href="javascript:void(0);" type="button" class="btn btn-block btn-success btn-sm">Abrir en una nueva pestaña</button>
    <?php if($Tipo == "I"){ ?>
        <img src="assets/images/avisos/<?php echo $Archivo; ?>" width="100%">
    <?php } else { ?>
      <embed id="pdfdoc" src="assets/images/avisos/<?php echo $Archivo; ?>" width="100%" height="500" alt="pdf" pluginspage="http://www.adobe.com/products/acrobat/readstep2.html">
    <?php } ?>


  </form>


  <?php
}
?>
