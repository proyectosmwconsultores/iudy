<?php
 require('php/clases/class.System.php');
 $db = new Conexion();
 $IdTrayectoria =  $_POST["IdTrayectoria"];
 $IdUsua =  $_POST["IdUsua"];
 $IdTipo =  $_POST["IdTipo"];
 $Fecha =  $_POST["Fecha"];
 $IdEstatusUs =  $_POST["IdEstatus"];
 $Comentario =  $_POST["Comentario"];
 $filex = 'txt_archivo_2';

 $sql_tipo = $db->query("SELECT * FROM tblc_trayectoria WHERE tblc_trayectoria.IdTipoTrayectoria = '$IdTipo'");
 $db->rows($sql_tipo);
 $_tipo = $db->recorrer($sql_tipo);
 $IdEstatus = $_tipo['Tipo'];

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
          if($archivo){
            $archivo = time().'_'.$archivo;
            $_anio = date("Y");
            $_aniomes = date("m");
            $info = new SplFileInfo($_FILES["file"]['name']);
            $tipox =  $info->getExtension();

            if (move_uploaded_file($_FILES["file"]["tmp_name"], "assets/docs/files/$_anio/$_aniomes/".$archivo)) {
              $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.IdEstatus = '$IdEstatus' WHERE tblc_usuario.IdUsua = '$IdUsua'");
              $insertar = $db->query("UPDATE tblp_trayectoria_alumno SET tblp_trayectoria_alumno.Fecha = '$Fecha', tblp_trayectoria_alumno.Archivo = '$archivo', tblp_trayectoria_alumno.FecCap = NOW(), tblp_trayectoria_alumno.IdEstatus = '$IdEstatusUs', tblp_trayectoria_alumno.Nota = '$Comentario', tblp_trayectoria_alumno.Anio = '$_anio', tblp_trayectoria_alumno.Mes = '$_aniomes' WHERE tblp_trayectoria_alumno.IdTrayectoria = '$IdTrayectoria'");
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
  $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.IdEstatus = '$IdEstatus' WHERE tblc_usuario.IdUsua = '$IdUsua'");
  $insertar = $db->query("UPDATE tblp_trayectoria_alumno SET tblp_trayectoria_alumno.Fecha = '$Fecha', tblp_trayectoria_alumno.FecCap = NOW(), tblp_trayectoria_alumno.IdEstatus = '$IdEstatusUs', tblp_trayectoria_alumno.Nota = '$Comentario' WHERE tblp_trayectoria_alumno.IdTrayectoria = '$IdTrayectoria'");
  if ($esp == 1) {
    $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.$textoEstatus = '$idEstx' WHERE tblc_usuario.IdUsua = '$IdUsua'");
  }
  $db->close();
  echo $insertar;
  exit();
}
