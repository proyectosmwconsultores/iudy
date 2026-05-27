<?php
include('../../hace.php');
if(isset($_POST["IdAviso"])){
  $output = '';
  require('../../php/clases/class.System.php');
  $db = new Conexion();
  $IdAviso = $_POST["IdAviso"];
  $IdDetalle = $_POST["IdDetalle"];
  
  $sql9 = $db->query("SELECT * FROM tbla_aviso WHERE tbla_aviso.IdAviso = '$IdAviso'");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);
  $Tipo = $datos91["Tipo"];
  $Archivo = $datos91["Archivo"];

  $sql9 = $db->query("UPDATE tbla_aviso_detalle SET tbla_aviso_detalle.Fec_visto = NOW(), tbla_aviso_detalle.IdEstatus = '10' WHERE tbla_aviso_detalle.IdDetalle = '$IdDetalle'");


  ?>
  <form name="frm22" id="frm22" action="addRvoe.php" method="POST" enctype="multipart/form-data" class="form-horizontal">
    <!-- <button onClick="window.open('assets/images/avisos/<?php echo $Archivo; ?>','_blank')" href="javascript:void(0);" type="button" class="btn btn-block btn-success btn-sm">Abrir en una nueva pestaña</button> -->
    <?php if($Tipo == "jpg"){ ?>
        <img src="assets/images/avisos/<?php echo $Archivo; ?>" width="100%">
    <?php } elseif($Tipo == "pdf") { ?>
      <embed id="pdfdoc" src="assets/docs/avisos/<?php echo $Archivo; ?>" width="100%" height="500" alt="pdf" pluginspage="http://www.adobe.com/products/acrobat/readstep2.html">
    <?php } else { ?>
      <blockquote>
<p><?php echo $datos91["Texto"]; ?></p>
<small>Pubicado por el área de <?php echo $datos91["Area"]; ?></small>
</blockquote>
    <?php } ?>


  </form>


  <?php
}
?>
