<?php
require('../../php/clases/class.System.php');
$db = new Conexion();
$IdUsua =  $_POST["IdUsua"];
$IdPractica =  $_POST["IdPractica"];
$Tipo =  $_POST["Tipo"];

$filex = 'txt_archivo';
if (is_array($_FILES) && count($_FILES) > 0) {
  $tipo = $_FILES['file']['type'];
  $archivo = $_FILES['file']['name'];
  $info = new SplFileInfo($_FILES["file"]['name']);
  $tipox =  $info->getExtension();
  $anio = date("Y");
  $mes = date("m");
  if ($archivo) {
    $archivo = time() . '_' . $archivo;
    if (move_uploaded_file($_FILES["file"]["tmp_name"], "../../assets/docs/files/$anio/$mes/$archivo")) {
      $ruta = "assets/docs/files/$anio/$mes/$archivo";
      $insertar = $db->query("INSERT INTO tblp_practica_docs (IdUsua, IdTipo, Ruta, IdEstatus, FecCap, Formato, IdPractica) VALUES ('$IdUsua','$Tipo','$ruta',2,NOW(),'$tipox','$IdPractica') ");
      $db->close();
      echo $insertar;
      exit();
    }
  } else {
    echo 0;
  }
} else {
  echo 0;
  exit();
}
