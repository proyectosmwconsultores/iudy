<?php

$IdTipoDocs= $_POST["valor"];
$numero= $_POST["numero"];
$grado= $_POST["Grado"];

  $output = '';
  require('../php/clases/class.System.php');
  $db = new Conexion();
// echo "UPDATE tblh_tipodocumento SET tblh_tipodocumento.IdEstatus = '$numero' WHERE tblh_tipodocumento.IdTipoDocumento = '$IdTipoDocs' ";

  // $insertar = $db->query("UPDATE tblc_tipodocumento SET tblc_tipodocumento.Grado$grado = '$numero' WHERE tblc_tipodocumento.IdTipoDocumento = '$IdTipoDocs' ");
  $insertar = $db->query("UPDATE tblh_tipodocumento SET tblh_tipodocumento.Solicitado = '$numero' WHERE tblh_tipodocumento.IdTipoDoc = '$IdTipoDocs' ");
  $db->close();

  if ($insertar) {
    $output =  1;
  } else {
    $output =  0;
  }

  echo $output;

?>
