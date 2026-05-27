<?php
include('../hace.php');
if(isset($_POST["IdDescuento"])){
  $output = '';
  require('../php/clases/class.System.php');
  $db = new Conexion();



  $insertar = $db->query("UPDATE tblp_descuento SET tblp_descuento.Estatus = '11' WHERE tblp_descuento.IdDescuento = '".$_POST["IdDescuento"]."'");
  $db->close();


  if ($insertar) {
    $output =  1;
  } else {
    $output =  0;
  }

  echo $output;
}
?>
