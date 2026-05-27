<?php
if(isset($_POST["IdLibro"])){
  $output = '';
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdLibro = $_POST["IdLibro"];

  $sqlH = $db->query("SELECT * FROM tblp_libro WHERE tblp_libro.IdLibro = '$IdLibro'");
  $db->rows($sqlH);
  $datos81 = $db->recorrer($sqlH);

  ?>
  <form name="frm" id="frm" action="verLibro.php" method="POST" enctype="multipart/form-data">
    <button onClick="window.open('assets/docs/libro/<?php echo $datos81["Oferta"]; ?>/<?php echo $datos81["Link"]; ?>','_blank')" href="javascript:void(0);" style="cursor: pointer;" type="button" class="btn btn-block btn-success btn-sm"><i class="fa fa-fw fa-check-circle"></i> Clic para abrir en una nueva ventana</button>
    <embed src="assets/docs/libro/<?php echo $datos81["Oferta"]; ?>/<?php echo $datos81["Link"]; ?>#toolbar=0&navpanes=0&scrollbar=0" type="application/pdf" width="100%" height="500px" />
  </form>
  <?php
}
?>
