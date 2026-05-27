<?php
 require('php/clases/class.System.php');
 $db = new Conexion();
 $IdUsua =  $_POST["IdUsua"];
 $Tipo =  $_POST["Tipo"];
 $IdDocente =  $_POST["IdDocente"];
 $Fecha =  $_POST["Fecha"];
 $filex = 'txt_archivo';
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

              $insertar = $db->query("INSERT INTO tblp_reconocimiento (IdTipo, IdUsua, Fecha, FecCap, Anio, Mes, Archivo, IdUsuaCap, Formato) VALUES ('$Tipo','$IdDocente','$Fecha',NOW(),'$_anio','$_aniomes','$archivo','$IdUsua','$tipox') ");
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
