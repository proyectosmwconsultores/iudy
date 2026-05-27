<?php
  require('php/clases/class.System.php');
  ob_start();
  $tipo = $_POST["IdTipo"];

    $IdUsua = $_POST["IdUsua"];
    $IdTarea = $_POST["IdTarea"];

    $IdActividadDoc = $_POST["IdActividadDoc"];
    $idAsignacion = $_POST["IdAsignacion"];

    if($_POST['chkLink1']) { $NoArchivo = "Link"; $Fec = "Fec1"; }
    if($_POST['chkLink2']) { $NoArchivo = "Link2"; $Fec = "Fec2"; }
    if($_POST['chkLink3']) { $NoArchivo = "Link3"; $Fec = "Fec3"; }

    $db = new Conexion();
    $sql1 = $db->query("SELECT tblp_tareas.$NoArchivo FROM tblp_tareas WHERE tblp_tareas.IdTarea ='$IdTarea' ");
    $db->rows($sql1);
    $datos11 = $db->recorrer($sql1);
    $link = $datos11["0"];


    $sql3 = $db->query("SELECT tblp_asignacion.Anio, tblp_asignacion.Mes FROM tblp_asignacion WHERE tblp_asignacion.IdAsignacion ='$idAsignacion' AND tblp_asignacion.Tipo = '2'");
    $db->rows($sql3);
    $datos31 = $db->recorrer($sql3);
    $AAnio = $datos31["Anio"];
    $MMes = $datos31["Mes"];

		if($link) {
			$linkD = "assets/trabajos/$AAnio/$MMes/$idAsignacion/tareas/$link";
			unlink($linkD);
		}


    $carpeta = "assets/trabajos/$AAnio/$MMes/$idAsignacion/tareas/"; //nombre de la carpeta en la que se guardaran los archivos (si es en el directorio ponga /)
    $archivo = $_FILES["archivo"]['name']; //nombre del archivo
    $info = new SplFileInfo($_FILES["archivo"]['name']);
    $tipox =  $info->getExtension();

    $archivo = time().'.'.$tipox; // Generamos un nombre de archivo Aleatorio para evitar conflictos entre los nombres.
    if(!move_uploaded_file($_FILES["archivo"]['tmp_name'], $carpeta.$archivo)){
      $_SESSION['Alerta']="0";
      echo "<script type='text/javascript'>window.location='miMateria.php?idAsignacion=$idAsignacion';</script>";
      exit();
    }

    $nombre_fichero = $carpeta.$archivo;
    $folio = $IdTarea;

    if ((file_exists($nombre_fichero)) && ($folio)) {
      $insertar = $db->query("UPDATE tblp_tareas SET $NoArchivo = '$archivo', FecCap = NOW(), $Fec = NOW()  WHERE tblp_tareas.IdTarea ='$IdTarea' ");

      $sql2 = $db->query("SELECT tblp_actividadesdocente.NomActividad FROM tblp_actividadesdocente WHERE tblp_actividadesdocente.IdActividadesDocente = '$IdActividadDoc'");
      $db->rows($sql2);
      $datos21 = $db->recorrer($sql2);
      $nomActividad = $datos21["NomActividad"];


      $sql3 = $db->query("SELECT tblc_usuario.Correo, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno FROM tblc_usuario WHERE tblc_usuario.IdUsua = '$IdUsua'");
      $db->rows($sql3);
      $datos31 = $db->recorrer($sql3);
      $correo3 = $datos31["Correo"];
      $alumno = $datos31["Nombre"].' '.$datos31["APaterno"].' '.$datos31["AMaterno"];

      $sql4 = $db->query("SELECT tblp_asignacion.IdAsignacion, tblp_educativa.Nombre, tblp_modulo.NombreMod, tblc_usuario.Nombre AS NombreDoc, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblp_asignacion.IdGrupo, tblc_usuario.Correo FROM tblp_asignacion Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_asignacion.IdEducativa Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo Inner Join tblc_usuario ON tblc_usuario.IdUsua = tblp_asignacion.IdUsua WHERE tblp_asignacion.Tipo =  '2' AND tblp_asignacion.IdAsignacion =  '$idAsignacion'");
      $db->rows($sql4);
      $datos41 = $db->recorrer($sql4);
      $oferta = $datos41["Nombre"];
      $modulo = $datos41["NoModulo"].' '.$datos41["NombreMod"];
      $correoDocente = $datos41["Correo"];
      $alumno = $datos31["Nombre"].' '.$datos31["APaterno"].' '.$datos31["AMaterno"];
      $destinatario = $correo3;

      $asunto = "$nomActividad respondida - Folio $folio";
      // if($Comentario){
      //   $insertar = $db->query("INSERT INTO tblp_tareascomentarios (IdTarea, Tipo, Comentario, IdUsua, FecCap) VALUES ('$folio','A','".$_POST["txtComentario"]."','".$_SESSION['IdUsua']."', NOW())");
      // }

      if($correo3){
        $destinatario = $correo3;
      } else {
        $destinatario = "pedro.goca@hotmail.com";
      }



      $sql2 = $db->query("SELECT * FROM tblp_educativa WHERE tblp_educativa.IdEducativa = '".$_POST["txtOferta"]."'");
      $db->rows($sql2);
      $datos3 = $db->recorrer($sql2);
      $OfertaEduca = $datos3["Nombre"];
      $sql22 = $db->query("SELECT * FROM tblp_configuracion WHERE tblp_configuracion.IdConfig = '17' ");
      $db->rows($sql22);
      $datos221 = $db->recorrer($sql22);
      $url = $datos221["Descripcion"];

      $linkLogo = $url.'assets/images/campus/logo_inicio.png';
      $cuerpo = "
      <html>
      <head>
         <title>Entrega de tarea</title>
      </head>
      <body>
        <table border='0' cellpadding='0' width='90%' style='border-collapse: collapse; font-family:Century Gothic,Arial; '>
          <tr style='background: #9f9f9f;'>
              <td colspan='3' height='100' align='center'>
              <b style='color:#FE9900; font-size:24px; text-align: center; font-family:Century Gothic,Arial;'>
                <img src= '$linkLogo' >
              </b></td>
          </tr>
          <tr>
              <td colspan='3' height='100' align='center'>
              <b style='color:#0b283e; font-size:24px; text-align: center; font-family:Century Gothic,Arial;'>
              Confirmaci&oacute;n de actividad respondida
              </b></td>
          </tr>
          <tr>
          <td colspan='3'>
            <table border='1' cellpadding='0' width='100%' style='border-collapse: collapse; font-family:Century Gothic,Arial; '>
              <tr>
                <td style=' text-align: right; padding: 10px;'>  Nombre de la actividad: </td><td style='padding: 10px;'> <b>  ";  $cuerpo .= $nomActividad." </b></td>
              </tr>
              <tr>
                <td style=' text-align: right; padding: 10px;'>  Alumno: </td><td style='padding: 10px;'> <b>  ";  $cuerpo .= $alumno." </b></td>
              </tr>
              <tr>
                <td style=' text-align: right; padding: 10px;'>  Oferta educativa: </td><td style='padding: 10px;'> <b>  ";  $cuerpo .= htmlentities($oferta)." </b></td>
              </tr>
              <tr>
                <td style=' text-align: right; padding: 10px;'>  Asignatura: </td><td style='padding: 10px;'> <b>  ";  $cuerpo .= htmlentities($modulo)." </b></td>
              </tr>
              <tr>
                <td style=' text-align: right; padding: 10px;'>  Folio: </td><td style='padding: 10px;'> <b>  ";  $cuerpo .= htmlentities($IdTarea)." </b></td>
              </tr>
            </table>
          </td>
          <tr>
              <td colspan='3' height='50' style='color:#363330; font-size:14px; text-align: left; font-family:Century Gothic,Arial; '>
              <p align='center'>
              A t e n t a m e n t e <br  /><br  />
              Sistema autom&aacute;tico<br />
              </p>
              </td>
          </tr>
          <tr>
              <td colspan='3' style='color:#363330; font-size:12px; text-align: left; font-family:Century Gothic,Arial; '><p align='center'>
              Para cualquier duda o aclaraci&oacute;n comunicate con tu asesor acad&eacute;mico</p></td>
          </tr>
        </table>";
      $headers = "MIME-Version: 1.0\r\n";
      $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
      $headers .= "From: Entrega de $nomActividad - Folio $folio <info@hotmail.com.mx>\r\n";
      $headers .= "Cc: $correoDocente\r\n";
      $headers .= "Bcc: pedroo.goca@gmail.com\r\n";
      mail($destinatario,$asunto,$cuerpo,$headers);
      if($insertar) {
        $_SESSION['SaveFile']="1";
        $_SESSION['Alerta']="GUARDAR"; $_SESSION['Variable']="TAREA";
        echo "<script type='text/javascript'>window.location='miMateria.php?idAsignacion=$idAsignacion';</script>";
      } else {
        $_SESSION['Alerta']="ERROR"; $_SESSION['Variable']=" ERROR AL SUBIR TAREA";
        echo "<script type='text/javascript'>window.location='miMateria.php?idAsignacion=$idAsignacion';</script>";
      }
    } else {
      return 0;
    }


?>
