<?php
 require('php/clases/class.System.php');
 $db = new Conexion();
 $IdUsua =  $_POST["IdUsua"];
 $Tipo =  $_POST["Tipo"];
 $IdUsua =  $_POST["IdUsua"];
 $IdPago =  $_POST["IdPago"];
 $TipoPago =  $_POST["TipoPago"];

 $Comentario =  $_POST["Comentario"];
 $filex = 'txt_file';
 if (is_array($_FILES) && count($_FILES) > 0) {
          $tipo = $_FILES['file']['type'];
          $archivo = $_FILES['file']['name'];
          if($archivo){
            $cad = $IdUsua.'_'.$IdPago.'_';

            $_anio = date("Y");
            $_aniomes = date("m");
            $info = new SplFileInfo($_FILES["file"]['name']);
            $tipox =  $info->getExtension();
            $archivo = $cad.time().'.'.$tipox;

            if (move_uploaded_file($_FILES["file"]["tmp_name"], "assets/docs/comprobantes/$_anio/$_aniomes/".$archivo)) {

              $insertar = $db->query("INSERT INTO tblh_detallepagos (IdUsua, IdPago, Comentario, Archivo, FecCap, Estatus, Visto, Anio, Mes, Tipo, Formato, TipoPago) VALUES ('$IdUsua','$IdPago','$Comentario','$archivo',NOW(),'2','1','$_anio','$_aniomes','$Tipo','$tipox','$TipoPago') ");
              if($TipoPago == 1){
                $insertar = $db->query("UPDATE tblp_pagos SET tblp_pagos._img = '1' WHERE tblp_pagos.IdPago = '$IdPago' ");
              }
              $db->close();
              echo $insertar;
              exit();
            }
          } else {
            echo 3;
          }
} else {
  $insertar = $db->query("INSERT INTO tblh_detallepagos (IdUsua, IdPago, FecCap, Estatus, Visto, Tipo, Comentario, TipoPago) VALUES ('$IdUsua','$IdPago',NOW(),'2','1','$Tipo','$Comentario', '$TipoPago') ");
  if($TipoPago == 1){
      $insertar = $db->query("UPDATE tblp_pagos SET tblp_pagos._img = '1' WHERE tblp_pagos.IdPago = '$IdPago' ");
  }
  echo 1;
  exit();
}
