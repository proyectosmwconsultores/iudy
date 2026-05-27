<?php
 require('php/clases/class.System.php');
 $db = new Conexion();
 $IdUsua =  $_POST["IdUsua"];
 
 $filex = 'txt_archivo';
if (is_array($_FILES) && count($_FILES) > 0) {
          $tipo = $_FILES['file']['type'];
          $archivo = $_FILES['file']['name'];
          if($archivo){
            $archivo = time().'_'.$archivo;
            
            if (move_uploaded_file($_FILES["file"]["tmp_name"], "assets/docs/Alumnos/$archivo")) {

              $insertar = $db->query("UPDATE tblc_datosfactura SET tblc_datosfactura.Archivo = '$archivo' WHERE tblc_datosfactura.IdUsua = '$IdUsua' ");
              $db->close();
              echo $insertar;
              exit();
            }
          } else {
            echo 0;
          }
} else {
  echo 0;
  exit();
}
