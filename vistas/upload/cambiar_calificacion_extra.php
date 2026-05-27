<?php
require('../../php/clases/class.System.php');
$db = new Conexion();


$AnteriorPromedio = $_POST["AnteriorPromedio"];
$IdCalificacion = $_POST["IdCalificacion"];
$IdUsua = $_POST["IdUsua"];
$IdAdmin = $_POST["IdAdmin"];
$Promedio = $_POST["Promedio"];
$Motivo = $_POST["Motivo"];
$IdCiclo = $_POST["IdCiclo"];

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

      $insertar = $db->query("INSERT INTO tblp_calificacion_cambios (IdCalificacion, IdUsua, PromedioAnterior, PromedioNuevo, Motivo, FecCap, Evidencia) VALUES ('$IdCalificacion','$IdAdmin','$AnteriorPromedio','$Promedio','$Motivo',NOW(),'$ruta')");

      $insertar = $db->query("UPDATE tblp_calificacion SET tblp_calificacion.Promedio = '$Promedio', tblp_calificacion._obs = 'E', tblp_calificacion.Observacion = 'E', tblp_calificacion._idCiclo = '$IdCiclo' WHERE tblp_calificacion.IdCalificacion = '$IdCalificacion'");
      
      $db->close();
      echo $insertar;
      exit();
    }
  } else {
    echo 0;
  }
} else {
  $insertar = $db->query("INSERT INTO tblp_calificacion_cambios (IdCalificacion, IdUsua, PromedioAnterior, PromedioNuevo, Motivo, FecCap) VALUES ('$IdCalificacion','$IdAdmin','$AnteriorPromedio','$Promedio','$Motivo',NOW())");

  $insertar = $db->query("UPDATE tblp_calificacion SET tblp_calificacion.Promedio = '$Promedio', tblp_calificacion._obs = 'E', tblp_calificacion.Observacion = 'EXTRAORDINARIO', tblp_calificacion._idCiclo = '$IdCiclo' WHERE tblp_calificacion.IdCalificacion = '$IdCalificacion'");
  

  echo $insertar; 
  exit();
}


