<?php
  session_start();
  require('php/clases/class.System.php');
  if($_SESSION['IdUsua']){
  $tipo = $_POST["IdTipo"];

    $IdUsua = $_POST["IdUsua"];
    $IdTarea = $_POST["IdTarea"];

    $IdActividadDoc = $_POST["IdActividadDoc"];
    $idAsignacion = $_POST["IdAsignacion"];
    // $NoArchivo = $_POST["NoArchivo"];
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

      $sql2 = $db->query("SELECT * FROM tblp_actividadesdocente WHERE tblp_actividadesdocente.IdActividadesDocente = '$IdActividadDoc'");
      $db->rows($sql2);
      $datos21 = $db->recorrer($sql2);
      $nomActividad = $datos21["NomActividad"];


      $sqlmate = $db->query("SELECT tblp_asignacion.IdAsignacion, tblp_modulo.NombreMod FROM tblp_asignacion Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo WHERE tblp_asignacion.IdAsignacion =  '$idAsignacion' AND tblp_asignacion.Tipo =  '2'");
      $db->rows($sqlmate);
      $datos_mat = $db->recorrer($sqlmate);
      $Pagina = "Ingresado a la materia -> ".$datos_mat["NombreMod"];
      $actv = "Tarea subida -> actividad -> ".$datos21['NomActividad'];


      $insertar = $db->query("INSERT INTO tblh_ingresos (IdUsua, Pagina, FecCap, _accion, _modulo, _valor, _idUsua, _idActividad)  
      VALUES ('$IdUsua', '$Pagina',NOW(),'Tarea subida con éxito','$actv','$idAsignacion','$IdUsua','$IdActividadDoc')");



      
    } else {
      return 0;
    }

  } else {
    return 0;
  }
?>
