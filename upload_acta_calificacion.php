<?php
 require('php/clases/class.System.php');
 $db = new Conexion();

 $IdAsignacion =  $_POST["IdAsignacion"];

 $sql8 = $db->query("SELECT tblp_asignacion.Plantel, tblp_asignacion.Anio FROM tblp_asignacion WHERE tblp_asignacion.IdAsignacion =  '$IdAsignacion'");
 $db->rows($sql8);
 $datos81 = $db->recorrer($sql8);
 $Anio = $datos81['Anio'];
 $Plantel = $datos81['Plantel'];

 if($Plantel) {
   $linkD = "assets/docs/adjunto/$Anio/$Plantel";
    unlink($linkD);
 }


$id_esta_tit = 0;
 $info = new SplFileInfo($_FILES["file1"]['name']);
 $tipox_t =  $info->getExtension();
 $archivo_tit = time().'.'.$tipox_t;
 if (move_uploaded_file($_FILES["file1"]["tmp_name"], "assets/docs/adjunto/$Anio/".$archivo_tit)) {
   $id_esta_tit = 1;
 } else { $id_esta_tit = 0; }


 $insertar = $db->query("UPDATE tblp_asignacion SET tblp_asignacion.Plantel = '$archivo_tit' WHERE tblp_asignacion.IdAsignacion = '$IdAsignacion' ");

 echo $id_esta_tit;
