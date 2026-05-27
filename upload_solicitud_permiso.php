<?php
 require('php/clases/class.System.php');
 $db = new Conexion();
 $IdAsistencia =  $_POST["IdAsistencia"];
 $Comentario =  $_POST["Comentario"];


 $insertar = $db->query("UPDATE tblp_asistencia SET tblp_asistencia.Comentario = '$Comentario', tblp_asistencia.Fec_comentario = NOW(), tblp_asistencia.Valor ='1' WHERE tblp_asistencia.IdAsistencia = '$IdAsistencia'");
 $db->close();
 echo $insertar;
 exit();
