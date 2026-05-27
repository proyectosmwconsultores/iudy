<?php
require('php/clases/class.System.php');
$db = new Conexion();
$IdAviso =  $_POST["IdAviso"];
$Tipo =  $_POST["Tipo"];

if (is_array($_FILES) && count($_FILES) > 0) {
  $archivo = $_FILES['file']['name'];
  $fecha = date("Y-m-d-H-m-s") . '_' . time();
  $nombre_archivo = $fecha . $archivo;
  $ruta = "assets/docs/ServicioSocial/$nombre_archivo";

  if (move_uploaded_file($_FILES["file"]["tmp_name"], "assets/docs/ServicioSocial/$nombre_archivo")) {
    $insertar = $db->query("INSERT INTO tbla_aviso_docs (IdAviso, Tipo, Archivo, FecCap) VALUES ('$IdAviso','$Tipo','$ruta',NOW()) ");
    $db->close();
    echo $insertar;
    exit();
  }
} else {
  echo 0;
  exit();
}
