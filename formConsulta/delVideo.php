<?php
include('../hace.php');
if(isset($_POST["Id"])){
  $output = '';
  require('../php/clases/class.System.php');
  $db = new Conexion();

  $sql9 = $db->query("SELECT Link FROM tblp_videos WHERE tblp_videos.IdVideo = '".$_POST["Id"]."'");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);
  $rwLink = $datos91["Link"];

  $delDoc = "../assets/docs/Videos/$rwLink";

if(file_exists($delDoc)){
  unlink($delDoc);
}


  $insertar = $db->query("DELETE FROM tblp_videos WHERE tblp_videos.IdVideo = '".$_POST["Id"]."'");
  $db->close();


  if ($insertar) {
    $output =  1;
  } else {
    $output =  0;
  }

  echo $output;
}
?>
