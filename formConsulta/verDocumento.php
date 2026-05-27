<?php
session_start();
require('../php/clases/class.System.php');
$db = new Conexion();
$IdBiblioteca = $_POST["IdBiblioteca"];


$sql9 = $db->query("SELECT * FROM tblp_biblioteca WHERE tblp_biblioteca.IdBiblioteca = '$IdBiblioteca' ");
$db->rows($sql9);
$datos91 = $db->recorrer($sql9);
$var = 0;

?>

<form name="frm2s_Far" id="frm2s_Far" action="updSemana.php" method="POST" enctype="multipart/form-data">
  <input type="hidden" name="nom_" id="nom_" value="<?php echo $datos91["Nombre"]; ?>">
  <?php if ($datos91["servidor"] == 1) {

   if (($datos91["IdTema"] == 7) || ($datos91["IdTema"] == 8)) {
    $var = 1; ?>
    <?php echo $datos91["Link"]; ?>
  <?php } ?>
  <?php if ($datos91["Tipo"] == 'pdf') {
    $var = 1; ?>
    <embed src="assets/biblioteca/<?php echo $datos91["Anio"]; ?>/<?php echo $datos91["Mes"]; ?>/<?php echo $datos91["Link"]; ?>#toolbar=0&navpanes=0&scrollbar=0" type="application/pdf" width="100%" height="500px" />
  <?php } ?>
  <?php if ($var == 0) { ?>
    <img onClick="window.open('assets/biblioteca/<?php echo $datos91["Anio"]; ?>/<?php echo $datos91["Mes"]; ?>/<?php echo $datos91["Link"]; ?>','_blank')" href="javascript:void(0);" src="assets/images/abrir_archivo.jpg" style="width: 100%; cursor: pointer;">
  <?php } ?>
  <?php } else { 
       if (($datos91["IdTema"] == 7) || ($datos91["IdTema"] == 8)) {
        $var = 1; ?>
        <?php echo $datos91["Link"]; ?>
      <?php } ?>
      <?php if ($datos91["Tipo"] == 'pdf') {
        $var = 1; ?>
        <embed src="<?php echo $datos91["Link"]; ?>#toolbar=0&navpanes=0&scrollbar=0" type="application/pdf" width="100%" height="500px" />
      <?php } ?>
      <?php if ($var == 0) { ?>
        <img onClick="window.open('<?php echo $datos91["Link"]; ?>','_blank')" href="javascript:void(0);" src="assets/images/abrir_archivo.jpg" style="width: 100%; cursor: pointer;">
      <?php } ?>

  <?php } ?>
</form>
<script>
  $(document).ready(function() {
    var nom_ = document.getElementById("nom_").value;
    document.getElementById('lbl_bib').innerHTML = nom_;
  });
</script>