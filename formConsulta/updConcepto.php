<?php

$IdConcepto= $_POST["valor"];
$numero= $_POST["numero"];


  $output = '';
  require('../php/clases/class.System.php');
  $db = new Conexion();

  $insertar = $db->query("UPDATE tblc_conceptos SET tblc_conceptos.Solicitud = '$numero' WHERE tblc_conceptos.IdConcepto = '$IdConcepto' ");
  $db->close();

  if ($insertar) {
    $output =  1;
  } else {
    $output =  0;
  }

  echo $output;

?>
