<?php
  require('../php/clases/class.System.php');
  $db = new Conexion();

  $tipoGuardar = $_POST["TipoGuardar"];

  if($tipoGuardar == "add_asistencia"){
    $Fecha = $_POST["Fecha"];
    $IdAsignacion = $_POST["IdAsignacion"];
    $IdUsua = $_POST["IdUsua"];

    $insertar = $db->query("ALTER TABLE tblp_lista ADD COLUMN $Fecha date NULL");
    $db->close();

    echo $insertar;
  }

  if($tipoGuardar == "savGrupoAv"){
    $IdAviso = $_POST["IdAviso"];
    $IdGrupo = $_POST["IdGrupo"];
    $Valor = $_POST["Valor"];

    if($Valor == 1){
      $insertar = $db->query("INSERT INTO tblc_avisodetalle (IdAviso, IdGrupo) VALUES ('$IdAviso','$IdGrupo')");
    } else {
      $insertar = $db->query("DELETE FROM tblc_avisodetalle WHERE tblc_avisodetalle.IdGrupo = '$IdGrupo' AND tblc_avisodetalle.IdAviso = '$IdAviso'");
    }
    $db->close();
    echo $insertar;
  }

  if($tipoGuardar == "delHorario"){
    $IdAsignacion = $_POST['IdAsignacion'];
    $IdHorario = $_POST['IdHorario'];
    $insertar = $db->query("UPDATE tblp_horario SET tblp_horario.HraIni = NULL, tblp_horario.MinIni = NULL, tblp_horario.HraFin = NULL, tblp_horario.MinFin = NULL, tblp_horario.Total = NULL WHERE tblp_horario.IdAsignacion = '$IdAsignacion' AND tblp_horario.IdHorario ='$IdHorario'");

    $db->close();
    echo $insertar;

  }

  if($tipoGuardar == "addComent"){
    $IdForo = $_POST['IdForo'];
    $Msj = $_POST['Msj'];
    $IdUsua = $_POST['IdUsua'];

    $sqle3 = $db->query("SELECT Count(tblp_foro_detalle.IdForoDetalle) AS Total FROM tblp_foro_detalle WHERE tblp_foro_detalle.IdForo =  '$IdForo'");
    $db->rows($sqle3);
    $datose31 = $db->recorrer($sqle3);
    $Total = $datose31['Total'] + 1;

    $insertar = $db->query("INSERT INTO tblp_foro_detalle (IdForo, Mensaje, IdUsua, FecCap) VALUES ('$IdForo', '$Msj', '$IdUsua', NOW())");
    $insertar = $db->query("UPDATE tblp_foro SET tblp_foro.Total = '$Total' WHERE tblp_foro.IdForo = '$IdForo'");

    $db->close();
    echo $insertar;

  }

  if($tipoGuardar == "savPubAvisoT"){
    $IdAviso = $_POST["IdAviso"];
    $IdCampus = $_POST["IdCampus"];
    $IdOferta = $_POST["IdOferta"];
    $sqly = $db->query("SELECT tblp_grupo.IdGrupo FROM tblp_grupo WHERE tblp_grupo.IdCampus = '$IdCampus' AND tblp_grupo.IdOferta = '$IdOferta' AND ((tblp_grupo.IdEstatus = '8') || (tblp_grupo.IdEstatus = '12'))");
    while($z = $db->recorrer($sqly)){
       $IdG = $z["IdGrupo"];
       $sqle3 = $db->query("SELECT tblc_avisodetalle.IdAvisoD FROM tblc_avisodetalle WHERE tblc_avisodetalle.IdGrupo = '$IdG' AND tblc_avisodetalle.IdAviso = '$IdAviso'");
       $db->rows($sqle3);
       $datose31 = $db->recorrer($sqle3);
       $IdAvss = $datose31['IdAvisoD'];
       if(!$IdAvss){
        $insertar = $db->query("INSERT INTO tblc_avisodetalle (IdAviso, IdGrupo) VALUES ('$IdAviso','$IdG')");
       }
    }


    $db->close();
    echo $insertar;
  }

?>
