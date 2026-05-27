<?php
 require('php/clases/class.System.php');
 $db = new Conexion();
 $IdUsua =  $_POST["IdUsua"];
 $Tipo =  $_POST["Tipo"];
 $Titulo =  $_POST["Titulo"];
 $IdCiclo =  $_POST["IdCiclo"];
 $Texto =  $_POST["Texto"];
 $filex = 'txt_archivo';

 $sql9 = $db->query("SELECT tblc_usuario.IdUsua,tblc_permiso.Permiso FROM tblc_usuario Left Join tblc_permiso ON tblc_permiso.IdPermiso = tblc_usuario.Permisos WHERE tblc_usuario.IdUsua =  '$IdUsua'");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);
  $area = $datos91['Permiso'];
if (is_array($_FILES) && count($_FILES) > 0) {
          $tipo = $_FILES['file']['type'];
          $archivo = $_FILES['file']['name'];
          $info = new SplFileInfo($_FILES["file"]['name']);
          $tipox_t =  $info->getExtension();
          $vx = 0;
          if(($tipox_t == 'pdf') || ($tipox_t == 'PDF') || ($tipox_t == 'jpg') || ($tipox_t == 'JPG') || ($tipox_t == 'png') || ($tipox_t == 'PNG')){
            $vx = 1;
            
          } else {
            echo 3;
            exit();
          }
          if(($archivo) && ($vx == 1)){
            $archivo = time().'_'.$archivo;
            if (move_uploaded_file($_FILES["file"]["tmp_name"], "assets/docs/avisos/$archivo")) {

              $insertar = $db->query("INSERT INTO tbla_aviso (IdUsua, Mensaje, Archivo, FecCap, Tipo, IdCiclo, Area)  VALUES ('$IdUsua','$Titulo','$archivo',NOW(),'$Tipo','$IdCiclo','$area') ");
              $db->close();
              echo $insertar;
              exit();
            }
          } else {
            echo 2;
          }
} else {
  if($Tipo == 'txt'){
    $insertar = $db->query("INSERT INTO tbla_aviso (IdUsua, Mensaje, Texto, FecCap, Tipo, IdCiclo, Area)  VALUES ('$IdUsua','$Titulo','$Texto',NOW(),'$Tipo','$IdCiclo','$area') ");
    $db->close();
    echo $insertar;
    exit();
  } else {
    echo 4;
    exit();
  }
}
