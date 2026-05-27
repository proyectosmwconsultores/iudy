<?php
 require('php/clases/class.System.php');
 $db = new Conexion();
 $IdUsua =  $_POST["IdUsua"];
 $filex = 'txt_archivo';
if (is_array($_FILES) && count($_FILES) > 0) {
          $tipo = $_FILES['file']['type'];
          $archivo = $_FILES['file']['name']; 
          if($archivo){
            $info = new SplFileInfo($_FILES["file"]['name']);
            $tipox =  $info->getExtension();
            $archivo = time().'.'.$tipox;
            if (move_uploaded_file($_FILES["file"]["tmp_name"], "assets/perfil/".$archivo)) {
              $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.Foto = '$archivo' WHERE tblc_usuario.IdUsua = '$IdUsua'");

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
