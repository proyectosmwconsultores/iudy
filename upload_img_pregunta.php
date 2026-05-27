<?php
 require('php/clases/class.System.php');
 $db = new Conexion();
 $IdAsignacion =  $_POST["IdAsignacion"];
 $Tipo =  $_POST["Tipo"];
 $Pregunta =  $_POST["Pregunta"];
 $IdActividadDoc =  $_POST["IdActividadDoc"];
 $IdParcialDoc =  $_POST["IdParcialDoc"];
 $IdUsua =  $_POST["IdUsua"];
 if($Tipo == 'A'){
   $IdEstatus = 8;
 } else {
   $IdEstatus = 31;
 }

 $filex = 'txt_file';
 if (is_array($_FILES) && count($_FILES) > 0) {
          $tipo = $_FILES['file']['type'];
          $archivo = $_FILES['file']['name'];
          if($archivo){
            $_anio = date("Y");
            $_aniomes = date("m");
            $info = new SplFileInfo($_FILES["file"]['name']);
            $tipox =  $info->getExtension();
            $archivo = 'E_'.time().'.'.$tipox;

            if (move_uploaded_file($_FILES["file"]["tmp_name"], "assets/docs/files/$_anio/$_aniomes/".$archivo)) {
              $insertar = $db->query("INSERT INTO tblp_exampregunta (IdAsignacion, IdActividadesDocente, IdParcialDocente, IdUsua, Pregunta, FecCap, Tipo, Imagen, Anio, Mes, Formato, IdEstatus) VALUES ('$IdAsignacion','$IdActividadDoc','$IdParcialDoc','$IdUsua','$Pregunta',NOW(),'$Tipo','$archivo', '$_anio', '$_aniomes', '$tipox','$IdEstatus')");

              $db->close();
              echo $insertar;
              exit();
            }
          } else {
            echo 3;
          }
} else {
  $insertar = $db->query("INSERT INTO tblp_exampregunta (IdAsignacion, IdActividadesDocente, IdParcialDocente, IdUsua, Pregunta, FecCap, Tipo, IdEstatus) VALUES ('$IdAsignacion','$IdActividadDoc','$IdParcialDoc','$IdUsua','$Pregunta',NOW(),'$Tipo','$IdEstatus')");
  echo 1;
  exit();
}
