<?php
include('../hace.php');
$Id= $_POST["Id"];
$IdForo= $_POST["IdForo"];
$IdUsua= $_POST["IdUsua"];
$Mensaje= $_POST["Mensaje"];
  $output = '';
  require('../php/clases/class.System.php');
  $db = new Conexion();

  $insertar = $db->query("INSERT INTO tblp_detalleforo (IdForo, Mensaje,IdUsua,FecCap,IdActividad) VALUES ('$IdForo','$Mensaje','$IdUsua',NOW(),'$Id')");
  $db->close();

  if ($insertar) {
    $output =  1;
  } else {
    $output =  0;
  }

  echo $output;

?>
