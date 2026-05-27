<?php
include('../hace.php');
if(isset($_POST["Id"])){
  $output = '';
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdPago = $_POST["Id"];
  $IdUsua = $_POST["Idxrf"];

  $insertar = $db->query("DELETE FROM tblp_pagos WHERE tblp_pagos.IdUsua = '$IdUsua' AND tblp_pagos.IdPago = '$IdPago' AND tblp_pagos.TipoSolicitud = '2'");
  $db->close();


  if ($insertar) {
    $output =  1;
  } else {
    $output =  0;
  }

  echo $output;
}
?>
