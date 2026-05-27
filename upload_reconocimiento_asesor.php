<?php
 require('php/clases/class.System.php');
 $db = new Conexion();
 $IdAsignacion =  $_POST["IdAsignacion"];
 $Fecha =  $_POST["Fecha"];
 $filex = 'txt_archivo';
if (is_array($_FILES) && count($_FILES) > 0) {
          $tipo = $_FILES['file']['type'];
          $archivo = $_FILES['file']['name'];
          if($archivo){
            $archivo = time().'_'.$archivo;
            $info = new SplFileInfo($_FILES["file"]['name']);
            $tipox =  $info->getExtension();
            $sql9 = $db->query("SELECT tblp_asignacion.Anio, tblp_asignacion.Mes, tblp_asignacion.IdUsua FROM tblp_asignacion WHERE tblp_asignacion.IdAsignacion =  '$IdAsignacion' AND tblp_asignacion.Tipo = '2'");
            $db->rows($sql9);
            $datos91 = $db->recorrer($sql9);
            $_anio = $datos91['Anio'];
            $_aniomes = $datos91['Mes'];
            $_IdUsua = $datos91['IdUsua'];

            $sql8 = $db->query("SELECT tblp_reconocimiento.IdReconocimiento FROM tblp_reconocimiento WHERE tblp_reconocimiento.IdAsignacion =  '$IdAsignacion'");
            $db->rows($sql8);
            $datos81 = $db->recorrer($sql8);
            $_IdReconocimiento = $datos81['IdReconocimiento'];


            if (move_uploaded_file($_FILES["file"]["tmp_name"], "assets/docs/files/$_anio/$_aniomes/".$archivo)) {

              if($_IdReconocimiento){
                $insertar = $db->query("UPDATE tblp_reconocimiento SET tblp_reconocimiento.Formato = '$info', tblp_reconocimiento.Archivo = '$archivo', tblp_reconocimiento.Fecha = '$Fecha' WHERE tblp_reconocimiento.IdReconocimiento = '$_IdReconocimiento'");
              } else {
                $insertar = $db->query("INSERT INTO tblp_reconocimiento (IdTipo, IdUsua, Fecha, FecCap, Anio, Mes, IdAsignacion, Archivo, Formato) VALUES ('1','$_IdUsua','$Fecha',NOW(),'$_anio','$_aniomes','$IdAsignacion','$archivo','$info') ");
              }
              $insertar = $db->query("UPDATE tblp_asignacion SET tblp_asignacion.Reconocimiento = '$archivo', tblp_asignacion.Fec_reconocimiento = '$Fecha' WHERE tblp_asignacion.IdAsignacion = '$IdAsignacion' ");

              $db->close();
              echo $insertar;
              exit();
            }
          } else {
            echo 3;
          }
} else {
  echo 2;
  exit();
}
