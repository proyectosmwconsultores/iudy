<?php

  require('php/clases/class.System.php');
  ob_start();
  $anio = date("Y");
  $ubicacion = $anio.'/';
  $IdUsuaRecibe = $_POST["IdUsuaRecibe"];
  $IdUsuaEnvia = $_POST["IdUsuaEnvia"];

    $Nombre = $_POST["txtNombreF"];

    $db = new Conexion();

    $carpeta = "assets/docs/adjunto/".$ubicacion; //nombre de la carpeta en la que se guardaran los archivos (si es en el directorio ponga /)
    $archivo = $_FILES["archivo"]['name']; //nombre del archivo
    $tipo = $_FILES["archivo"]['type']; //tamaño del archivo
    $nombreImg = explode(".", $archivo);
    $nombreImg[1]; // Extención de la imagen
    $tipo = $nombreImg[1];
    $archivo = time().'.'.$tipo; // Generamos un nombre de archivo Aleatorio para evitar conflictos entre los nombres.
    if(!move_uploaded_file($_FILES["archivo"]['tmp_name'], $carpeta.$archivo)){
      echo "<script type='text/javascript'>window.location='messages.php';</script>";
      exit();
    }

    $nombre_fichero = $carpeta.$archivo;

    if (file_exists($nombre_fichero)) {
      $IdUsuaEnvia = $_POST["IdUsuaEnvia"];
      $IdUsuaRecibe = $_POST["IdUsuaRecibe"];
      $Comentario = $_POST["txtNombreF"];
      $IdUnico = ($IdUsuaEnvia * $IdUsuaRecibe);

      $insertar = $db->query("INSERT INTO tblp_buzon (IdUsua, Mensaje, FecCap, IdUnico, IdUsuaEnvia, IdUsuaRecibe, Archivo, Visto) VALUES ('$IdUsuaEnvia','$Comentario',NOW(),'$IdUnico','$IdUsuaEnvia','$IdUsuaRecibe','$archivo','1') ");
      $insertar2 = $db->query("UPDATE tblp_buzon SET tblp_buzon.FecUltimo = NOW() WHERE tblp_buzon.IdUnico = '$IdUnico' ");
      // $insertar = $db->query("INSERT INTO tblp_recurso (Recurso, FecCap, IdActividad, Tipo, Anio, Mes, Archivo) VALUES ('$Nombre',NOW(),'$IdActividad','$tipo','$anio','$mes','$archivo')");
    }



?>
