<?php
 require('php/clases/class.System.php');
 $db = new Conexion();
 $IdServicio =  $_POST["IdServicio"];
 $filex = 'txt_constancia';
if (is_array($_FILES) && count($_FILES) > 0) {
          $tipo = $_FILES['file']['type'];
          $archivo = $_FILES['file']['name'];
          if($archivo){
            $archivo = time().'_'.$archivo;

            if (move_uploaded_file($_FILES["file"]["tmp_name"], "assets/docs/ServicioSocial/".$archivo)) {

              $insertar = $db->query("UPDATE tblp_servicio SET tblp_servicio.Documento = '$archivo' WHERE tblp_servicio.IdServicio = '$IdServicio' ");

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
