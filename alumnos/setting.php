<?php
  require('../php/clases/class.System.php');
  $db = new Conexion();

  $tipoGuardar = $_POST["TipoGuardar"];

  if($tipoGuardar == "add_chat"){
    $Chat = $_POST["Chat"];
    $IdUsua = $_POST["IdUsua"];
    $IdActividad = $_POST["IdActividad"];
    $IdAsignacion = $_POST["IdAsignacion"];

    $text1 =  str_replace('img','img style="width: 100%;"',$Chat);

    $insertar = $db->query("INSERT INTO tblp_foro (IdActividad, Mensaje, IdUsua, FecCap, IdAsignacion) VALUES ('$IdActividad','$text1','$IdUsua',NOW(),'$IdAsignacion')");
    $db->close();

    echo $insertar;
  }

  if($tipoGuardar == "validar_tarea"){
    $IdTarea = $_POST["IdTarea"];
    $IdAsignacion = $_POST["IdAsignacion"];
    $NoLink = $_POST["NoLink"];

    $sql3 = $db->query("SELECT tblp_asignacion.Anio, tblp_asignacion.Mes FROM tblp_asignacion WHERE tblp_asignacion.IdAsignacion ='$IdAsignacion' AND tblp_asignacion.Tipo = '2'");
    $db->rows($sql3);
    $datos31 = $db->recorrer($sql3);
    $AAnio = $datos31["Anio"];
    $MMes = $datos31["Mes"];



    $sql2 = $db->query("SELECT * FROM tblp_tareas WHERE tblp_tareas.IdTarea ='$IdTarea'");
    $db->rows($sql2);
    $datos21 = $db->recorrer($sql2);
    if($NoLink == 1){
        $link = $datos21["Link"];
    } elseif($NoLink == 2){
      $link = $datos21["Link2"];
    }elseif($NoLink == 3){
      $link = $datos21["Link3"];
    }

    if($link){
      $nombre_fichero = "../assets/trabajos/$AAnio/$MMes/$IdAsignacion/tareas/$link";
      if(file_exists($nombre_fichero)) {
          echo 1;
      } else {
        echo 0;
      }
    } else {
      echo 0;
    }

  }

  if($tipoGuardar == "savRespuetsaExs"){
    $IdResultado = $_POST["IdResultado"];
    $Respuesta = $_POST["Respuesta"];


    $insertar = $db->query("UPDATE tblp_examresultado SET tblp_examresultado.Valor = '0', tblp_examresultado.Respuesta = '$Respuesta', tblp_examresultado.FecCap = NOW() WHERE tblp_examresultado.IdResultado = '$IdResultado'");
    $db->close();

    echo $insertar;
  }

  if($tipoGuardar == "savExamenRes"){
    $IdResultado = $_POST["IdResultado"];
    $IdRespuesta = $_POST["IdRespuesta"];

    $sqlf = $db->query("SELECT Valor FROM tblp_examrespuesta WHERE tblp_examrespuesta.IdRespuesta = '$IdRespuesta' AND tblp_examrespuesta.IdRespuesta = '$IdRespuesta'");
    $db->rows($sqlf);
    $datos2f = $db->recorrer($sqlf);
    $valorE = $datos2f["Valor"];

    $insertar = $db->query("UPDATE tblp_examresultado SET tblp_examresultado.IdRespuesta = '$IdRespuesta', tblp_examresultado.Valor = '$valorE', tblp_examresultado.FecCap = NOW() WHERE tblp_examresultado.IdResultado ='$IdResultado'");
    $db->close();

    echo $insertar;
  }
?>
