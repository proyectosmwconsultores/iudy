<?php
require('php/clases/class.System.php');
$db = new Conexion();
$Fecha = date("Y-m-d");

#TODOS LOS GRADUADOS YA DEBEN DE TENER EL 100 % DE CREDITOS
// $sssql_us = $db->query("SELECT * FROM tblc_usuario WHERE ((tblc_usuario.IdEstatus = 61) || (tblc_usuario.IdEstatus = 62) || (tblc_usuario.IdEstatus = 55))");
$sql_us = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.IdEstatus = 55 ");
while ($us = $db->recorrer($sql_us)) {
  $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.porcentaje = '100' WHERE tblc_usuario.IdUsua = '" . $us['IdUsua'] . "' ");
}

#Practicas profesionales / agregado desde trayectoria
$sql_ppt = $db->query("SELECT * FROM tblp_trayectoria_alumno WHERE tblp_trayectoria_alumno.IdTipo = 21");
while ($ppt = $db->recorrer($sql_ppt)) {
  $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.idpp = '65' WHERE tblc_usuario.IdUsua = '" . $ppt['IdUsua'] . "' ");
}


#Servicio social / agregado desde trayectoria
$sql_sst = $db->query("SELECT * FROM tblp_trayectoria_alumno WHERE tblp_trayectoria_alumno.IdTipo = 22");
while ($sst = $db->recorrer($sql_sst)) {
  $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.idss = '65' WHERE tblc_usuario.IdUsua = '" . $sst['IdUsua'] . "' ");
}


$sql_users = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.Permisos = 3 AND tblc_usuario.IdEstatus = 8 ");
while ($users = $db->recorrer($sql_users)) {
  $Termino = $users['Termino'];
  $IdOferta = $users['IdOferta'];
  $IdCampus = $users['_idCampus'];
  $IdUsua = $users['IdUsua'];

  $sql_grado = $db->query("SELECT tblp_educativa.IdGrado FROM tblp_educativa WHERE tblp_educativa.IdEducativa = '$IdOferta'  ");
  $db->rows($sql_grado);
  $_grado = $db->recorrer($sql_grado);
  $IdGrado = $_grado['IdGrado'];
  if($IdGrado == 7){ $IdCampus = 6; }

  if ($Termino > 1) {
    $cond = " AND ((tblp_modulo.NoModulo = 1) || (tblp_modulo.NoModulo = $Termino))";
  } else {
    $cond = "";
  }

  $sql_total_creditos = $db->query("SELECT Sum(tblp_modulo.Creditos) AS Total FROM tblp_modulo WHERE tblp_modulo.IdEducativa =  '$IdOferta' AND tblp_modulo.IdCampus =  '$IdCampus' $cond");
  $db->rows($sql_total_creditos);
  $total_creditos = $db->recorrer($sql_total_creditos);

  $sql_actual = $db->query("SELECT Sum(tblp_modulo.Creditos) AS Total FROM tblp_calificacion Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_calificacion.IdModulo WHERE tblp_calificacion.IdUsua =  '$IdUsua' AND tblp_calificacion.IdEstatus =  '10' AND tblp_calificacion.Promedio >  '5' ");
  $db->rows($sql_actual);
  $total_creditos_actual = $db->recorrer($sql_actual);

  if ($IdOferta == 30) {
    if ($Termino > 1) {
      $cred = $total_creditos['Total'];
    } else {
      $cred = 0;
    }
  } else {
    $cred = $total_creditos['Total'];
  }

  if ($IdOferta == 30) {
    $cred = 456;
  }
  if ($cred == 0) {
    $cred = 456;
    $divi = (100 / 456);
    $porceActual = intval($divi * $total_creditos_actual['Total']);
  } else {
    $divi = (100 / $cred);
    $porceActual = intval($divi * $total_creditos_actual['Total']);
  }

  $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.porcentaje = '$porceActual' WHERE tblc_usuario.IdUsua = '$IdUsua'");

  if ($porceActual == 100) {
    
    if($IdGrado == 1){ $idEstatus = 62; $idEstatusTrayectoria = 18; }
    if($IdGrado == 2){ $idEstatus = 62; $idEstatusTrayectoria = 19; }
    if($IdGrado == 3) { $idEstatus = 61; $idEstatusTrayectoria = 20; }
    if($IdGrado == 4) { $idEstatus = 55; $idEstatusTrayectoria = 23; }
    if($IdGrado == 7) { $idEstatus = 55; $idEstatusTrayectoria = 24; }

    $sqlH = $db->query("SELECT * FROM tblp_trayectoria_alumno WHERE tblp_trayectoria_alumno.IdUsua =  '$IdUsua' AND tblp_trayectoria_alumno.IdTipo = '$idEstatusTrayectoria'");
    $db->rows($sqlH);
    $datos81 = $db->recorrer($sqlH);
    if (!isset($datos81['IdTrayectoria'])) {
      $Fecha = date("Y-m-d");
      $insertar = $db->query("INSERT INTO tblp_trayectoria_alumno (IdUsua, IdTipo, Fecha, FecCap, IdEstatus, Nota) VALUES ('$IdUsua','$idEstatusTrayectoria','$Fecha',NOW(),'8','Proceso automático de cierre por plataforma IUDY, por haber completado el 100% de los créditos.') ");
    }

    $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.IdEstatus = '$idEstatus', tblc_usuario.IdTrayectoria = '$idEstatusTrayectoria' WHERE tblc_usuario.IdUsua = '$IdUsua'");
  }
}
