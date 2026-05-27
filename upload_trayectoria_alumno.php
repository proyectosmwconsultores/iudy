<?php
require('php/clases/class.System.php');
$db = new Conexion();
$IdUsua =  $_POST["IdUsua"];
$IdTipo =  $_POST["IdTipo"];
$Fecha =  $_POST["Fecha"];
$IdEstatusUs =  $_POST["IdEstatus"];
$Comentario =  $_POST["Comentario"];
$filex = 'txt_archivo';

$sql_tipo = $db->query("SELECT * FROM tblc_trayectoria WHERE tblc_trayectoria.IdTipoTrayectoria = '$IdTipo'");
$db->rows($sql_tipo);
$_tipo = $db->recorrer($sql_tipo);
$IdEstatus = $_tipo['Tipo'];


$sqlH = $db->query("SELECT * FROM tblp_trayectoria_alumno WHERE tblp_trayectoria_alumno.IdUsua =  '$IdUsua' AND tblp_trayectoria_alumno.IdTipo = '$IdTipo'");
$db->rows($sqlH);
$datos81 = $db->recorrer($sqlH);
$idTra = isset($datos81['IdTrayectoria']);
if ($idTra) {
  echo 2;
  exit();
}
# Se valida si es practica o servicio social
$esp = 0;
if ($IdTipo == 21) {
  $esp = 1;
  $textoEstatus = "idpp";
  if ($IdEstatusUs == 10) {
    $idEstx = "65";
  } else {
    $idEstx = "64";
  }
}

if ($IdTipo == 22) {
  $esp = 1;
  $textoEstatus = "idss";
  if ($IdEstatusUs == 10) {
    $idEstx = "65";
  } else {
    $idEstx = "64";
  }
}

if (is_array($_FILES) && count($_FILES) > 0) {
  $tipo = $_FILES['file']['type'];
  $archivo = $_FILES['file']['name'];
  if ($archivo) {
    $archivo = time() . '_' . $archivo;
    $_anio = date("Y");
    $_aniomes = date("m");
    $info = new SplFileInfo($_FILES["file"]['name']);
    $tipox =  $info->getExtension();

    if (move_uploaded_file($_FILES["file"]["tmp_name"], "assets/docs/files/$_anio/$_aniomes/" . $archivo)) {

      $insertar = $db->query("INSERT INTO tblp_trayectoria_alumno (IdUsua, IdTipo, Fecha, Archivo, FecCap, IdEstatus, Nota, Anio, Mes) VALUES ('$IdUsua','$IdTipo','$Fecha','$archivo',NOW(),'$IdEstatusUs','$Comentario','$_anio','$_aniomes') ");
      $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.IdEstatus = '$IdEstatus', tblc_usuario.IdTrayectoria = '$IdTipo' WHERE tblc_usuario.IdUsua = '$IdUsua'");
      if ($esp == 1) {
        $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.$textoEstatus = '$idEstx' WHERE tblc_usuario.IdUsua = '$IdUsua'");
      }

      $db->close();
      echo $insertar;
      exit();
    }
  } else {
    echo 3;
  }
} else {
  $insertar = $db->query("INSERT INTO tblp_trayectoria_alumno (IdUsua, IdTipo, Fecha, FecCap, IdEstatus, Nota) VALUES ('$IdUsua','$IdTipo','$Fecha',NOW(),'$IdEstatusUs','$Comentario') ");
  $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.IdEstatus = '$IdEstatus', tblc_usuario.IdTrayectoria = '$IdTipo' WHERE tblc_usuario.IdUsua = '$IdUsua'");
  if ($esp == 1) {
    $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.$textoEstatus = '$idEstx' WHERE tblc_usuario.IdUsua = '$IdUsua'");
  }

  $db->close();
  echo $insertar;
  exit();
}
