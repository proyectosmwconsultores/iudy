<?php session_start();
include('../hace.php');
if(isset($_POST["employee_id"])){
  $output = '';
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $imagen = $_POST["employee_id"];
  $grado = $_POST["Oferta"];
  $tema = $_POST["Tema"];
  $moda = $_POST["Modalidad"];
  if($Modalidad){
    $directorio= "./assets/images/modulo/$grado/$tema/$moda/$imagen";
  } else {
    $directorio= "./assets/images/modulo/$grado/$tema/$moda/$imagen";
  }
  ?>
  <form name="frm22" id="frm22" action="updGrupo.php" method="POST" enctype="multipart/form-data" class="form-horizontal">

    <img src="<?php echo $directorio; ?>" style="width: 100%">
  </form>
  <?php
}
?>
