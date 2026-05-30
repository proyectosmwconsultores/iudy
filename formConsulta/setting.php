<?php
require('../php/clases/class.System.php');
$db = new Conexion();
date_default_timezone_set('America/Mexico_City');

$tipoGuardar = $_POST["TipoGuardar"];
if ($tipoGuardar == "configCoordinador") {
  $IdOferta = $_POST["IdOferta"];
  $IdUsua = $_POST["IdUsua"];
  $insertar = $db->query("INSERT INTO tblp_coordinador (IdUsua, IdOferta, FecCap, IdEstatus) VALUES ('$IdUsua','$IdOferta',NOW(),'8')");
  $db->close();

  echo $insertar;
}

if ($tipoGuardar == "sav_calificacion_tarea_id") {
  $IdUsua = $_POST["IdUsua"];
  $Calificacion = $_POST["Calificacion"];
  $IdTarea = $_POST["IdTarea"];
  $Equipo = $_POST["Equipo"];
  $IdActividad = $_POST["IdActividad"];

  $insertar = $db->query("UPDATE tblp_tareas SET tblp_tareas.Calificacion = '$Calificacion', tblp_tareas.Porcentaje = '$Calificacion' WHERE tblp_tareas.IdTarea = '$IdTarea' ");

  if($Equipo > 0){
    $sql_tar = $db->query("SELECT tblp_tareas.IdTarea FROM tblp_tareas LEFT JOIN tblp_moduloalumno ON tblp_tareas.IdAlumno = tblp_moduloalumno.IdUsua AND tblp_tareas.IdAsignacion = tblp_moduloalumno.IdAsignacion WHERE tblp_tareas.IdActividadesDocente = '$IdActividad' AND tblp_moduloalumno.Equipo = '$Equipo' ");
    while ($x = $db->recorrer($sql_tar)) {
      $insertar = $db->query("UPDATE tblp_tareas SET tblp_tareas.Calificacion = '$Calificacion', tblp_tareas.Porcentaje = '$Calificacion' WHERE tblp_tareas.IdTarea = '".$x['IdTarea']."' ");
    }
    $db->close();
    echo json_encode(['status' => 'success', 'message' => 'Calificación guardada correctamente.']);
  }
}


if ($tipoGuardar == "usuario_docente") {
  $IdCampus = $_POST["IdCampus"];
  $anio = date("Y");
  $mes = date("m");
  $mes = ($mes * 1);

  $_anio = substr($anio, 2, 2);
  if (($mes == 1) || ($mes == 2) || ($mes == 3) || ($mes == 4)) {
    $_mes = "01";
  }
  if (($mes == 5) || ($mes == 6) || ($mes == 7) || ($mes == 8)) {
    $_mes = "02";
  }
  if (($mes == 9) || ($mes == 10) || ($mes == 11) || ($mes == 12)) {
    $_mes = "03";
  }
  $_campus = "0" . $IdCampus;

  $sql1 = $db->query("SELECT tblc_usuario.IdUsua, tblc_usuario.Usuario FROM tblc_usuario WHERE tblc_usuario.Permisos =  '2' ORDER BY tblc_usuario.FecCap DESC LIMIT 1");
  $db->rows($sql1);
  $datos2 = $db->recorrer($sql1);
  $Usuario = $datos2["Usuario"];

  $r_anio = substr($Usuario, 0, 2);
  $r_consecutivo = substr($Usuario, 6, 3);

  if ($_anio = $r_anio) {
    $r_consecutivo = ($r_consecutivo + 1);
  } else {
    $r_consecutivo = 1;
  }
  $code = str_pad($r_consecutivo, 3, "0", STR_PAD_LEFT);
  echo $usuario = $_anio . $_mes . $_campus . $code;
}

if ($tipoGuardar == "add_calendario_esc") {
  $IdCiclo = $_POST["IdCiclo"];
  $Nombre = $_POST["Nombre"];
  $Mod = $_POST["Mod"];

  $insertar = $db->query("INSERT INTO tble_calendario (IdCiclo, Nombre, FecCap, Modalidad) VALUES ('$IdCiclo','$Nombre',NOW(), '$Mod')");
  $db->close();

  echo $insertar;
}

if ($tipoGuardar == "upd_asignacion") {
  $IdAsignacion = $_POST["IdAsignacion"];

  $sql8 = $db->query("SELECT * FROM tblp_asignacion WHERE tblp_asignacion.IdAsignacion = '$IdAsignacion' ");
  $db->rows($sql8);
  $datos81 = $db->recorrer($sql8);
  $IdGrupo = $datos81["IdGrupo"];
  $IdOferta = $datos81["IdEducativa"];
  $IdMod = $datos81["IdModulo"];
  $Grp = $datos81["Grupo"];
  $Estatus = $datos81["Estatus"];

  $sql_user = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.IdGrupo = '$IdGrupo' AND tblc_usuario.IdEstatus = '8'");
  while ($x = $db->recorrer($sql_user)) {
    $sql_mpd = $db->query("SELECT * FROM tblp_moduloalumno WHERE tblp_moduloalumno.IdAsignacion = '$IdAsignacion' AND tblp_moduloalumno.IdUsua = '".$x['IdUsua']."' ");
    $db->rows($sql_mpd);
    $_mod = $db->recorrer($sql_mpd);
      if(!isset($_mod["IdModuloAlumno"])){
        $insertar = $db->query("INSERT INTO tblp_moduloalumno (IdEducativa, IdModulo, Grupo, IdUsua, Estatus, FecCap, IdAsignacion, IdGrupo) VALUES ('$IdOferta','$IdMod','$Grp','".$x['IdUsua']."','$Estatus',NOW(),'$IdAsignacion','$IdGrupo')");
      }
    }

    
  
  echo $insertar;
}

if ($tipoGuardar == "add_fecha_cal_esc") {
  $IdCalendario = $_POST["IdCalendario"];
  $Parcial = $_POST["Parcial"];
  $Fecha1 = $_POST["Fecha1"];
  $Fecha2 = $_POST["Fecha2"];

  $sql1 = $db->query("SELECT * FROM tble_fecha WHERE tble_fecha.IdCalendario =  '$IdCalendario' AND tble_fecha.Parcial =  '$Parcial'");
  $db->rows($sql1);
  $datos2 = $db->recorrer($sql1);
  $rwCG = $datos2["IdFecha"];
  if ($rwCG) {
    echo 2;
    exit();
  }
  $insertar = $db->query("INSERT INTO tble_fecha (IdCalendario, Parcial, FechaIni, FechaFin, FecCap) VALUES ('$IdCalendario','$Parcial','$Fecha1','$Fecha2',NOW())");
  $db->close();

  echo $insertar;
}

if ($tipoGuardar == "upd_fecha_cal_esc") {
  $IdFecha = $_POST["IdFecha"];
  $Fecha1 = $_POST["Fecha1"];
  $Fecha2 = $_POST["Fecha2"];

  $insertar = $db->query("UPDATE tble_fecha SET tble_fecha.FechaIni = '$Fecha1', tble_fecha.FechaFin = '$Fecha2' WHERE tble_fecha.IdFecha = '$IdFecha' ");
  $db->close();

  echo $insertar;
}

if ($tipoGuardar == "asig_fecha_grp") {
  $IdCalendario = $_POST["IdCalendario"];
  $IdGrupo = $_POST["IdGrupo"];
  $IdCiclo = $_POST["IdCiclo"];
  $Valor = $_POST["Valor"];

  if ($Valor == 1) {
    $sql1 = $db->query("SELECT * FROM tble_calendario_grupo WHERE tble_calendario_grupo.IdCiclo =  '$IdCiclo' AND tble_calendario_grupo.IdGrupo =  '$IdGrupo'");
    $db->rows($sql1);
    $datos2 = $db->recorrer($sql1);
    $rwCG = $datos2["IdDisponible"];
    if ($rwCG) {
      echo 2;
      exit();
    }
    $insertar = $db->query("INSERT INTO tble_calendario_grupo(IdCalendario, IdCiclo, IdGrupo) VALUES ('$IdCalendario','$IdCiclo','$IdGrupo') ");
  } else {
    $insertar = $db->query("DELETE FROM tble_calendario_grupo WHERE tble_calendario_grupo.IdCalendario = '$IdCalendario' AND tble_calendario_grupo.IdGrupo = '$IdGrupo' AND tble_calendario_grupo.IdCiclo = '$IdCiclo' ");
  }


  $db->close();

  echo $insertar;
}

if ($tipoGuardar == "upd_calendario_esc") {
  $IdCiclo = $_POST["IdCiclo"];
  $Nombre = $_POST["Nombre"];
  $IdCalendario = $_POST["IdCalendario"];
  $Mod = $_POST["Mod"];
  $insertar = $db->query("UPDATE tble_calendario SET tble_calendario.Modalidad = '$Mod', tble_calendario.IdCiclo = '$IdCiclo', tble_calendario.Nombre = '$Nombre' WHERE tble_calendario.IdCalendario = '$IdCalendario' ");
  $db->close();

  echo $insertar;
}

if ($tipoGuardar == "sav_enlaza_grp") {
  $IdCiclo = $_POST["IdCiclo"];
  $IdGrupo = $_POST["IdGrupo"];
  $Grado = $_POST["Grado"];
  $_vax = 0;
  $db = new Conexion();
  $grado_nuevo = $Grado + 1;

  $sql_cx = $db->query("SELECT * FROM tblc_ciclo WHERE tblc_ciclo.IdCiclo =  '$IdCiclo'");
  $db->rows($sql_cx);
  $_cicx = $db->recorrer($sql_cx);
  $rwTipo = $_cicx["Tipo"];
  $rwNumero = $_cicx["Numero"] + 1;
  $_grado = $rwNumero;

  #Id del plan de estudios
  $sql_ofer = $db->query("SELECT tblp_grupo.IdOferta, tblp_grupo.IdCampus FROM tblp_grupo WHERE tblp_grupo.IdGrupo =  '$IdGrupo'");
  $db->rows($sql_ofer);
  $_oferta = $db->recorrer($sql_ofer);
  $IdOferta = $_oferta["IdOferta"];
  $IdCampus = $_oferta["IdCampus"];

  #Ciclo nuevo
  $sql_cicl = $db->query("SELECT * FROM tblc_ciclo WHERE tblc_ciclo.Numero =  '$rwNumero' AND tblc_ciclo.Tipo = '$rwTipo' ");
  $db->rows($sql_cicl);
  $_ciclo = $db->recorrer($sql_cicl);
  $rwIdCiclo = $_ciclo["IdCiclo"];

  #Verificamos que exista el pago reinscripcion
  $sql_cicl = $db->query("SELECT tblc_conceptosdetalle.IdConceptoDetalle, tblc_costos_ciclo.IdCosto FROM tblc_conceptosdetalle Left Join tblc_costos_ciclo ON tblc_costos_ciclo.IdPlan = tblc_conceptosdetalle.IdConceptoPlan WHERE tblc_conceptosdetalle.IdOferta =  '$IdOferta' AND tblc_conceptosdetalle.IdConcepto =  '3' AND tblc_costos_ciclo.IdCiclo =  '$rwIdCiclo'");
  $db->rows($sql_cicl);
  $_ciclo = $db->recorrer($sql_cicl);
  $rwIdConceptoCol = $_ciclo["IdConceptoDetalle"];

  if (!$rwIdConceptoCol) {
    echo 3;
    exit();
  }
  //echo "SELECT tblc_conceptosdetalle.IdConceptoDetalle, tblc_conceptosdetalle.IdConceptoPlan, tblc_costos_ciclo.Monto, tblc_costos_ciclo.Fecha, tblc_costos_ciclo.Numero, tblc_costos_ciclo.IdCosto FROM tblc_conceptosdetalle Left Join tblc_costos_ciclo ON tblc_costos_ciclo.IdPlan = tblc_conceptosdetalle.IdConceptoPlan WHERE tblc_conceptosdetalle.IdOferta =  '$IdOferta' AND tblc_conceptosdetalle.IdConcepto =  '2' AND tblc_costos_ciclo.IdCiclo =  '$rwIdCiclo'"; die();
  #Verificamos que exista el pago colegiatura
  $sql_cicl = $db->query("SELECT tblc_conceptosdetalle.IdConceptoDetalle, tblc_conceptosdetalle.IdConceptoPlan, tblc_costos_ciclo.Monto, tblc_costos_ciclo.Fecha, tblc_costos_ciclo.Numero, tblc_costos_ciclo.IdCosto FROM tblc_conceptosdetalle Left Join tblc_costos_ciclo ON tblc_costos_ciclo.IdPlan = tblc_conceptosdetalle.IdConceptoPlan WHERE tblc_conceptosdetalle.IdOferta =  '$IdOferta' AND tblc_conceptosdetalle.IdConcepto =  '2' AND tblc_costos_ciclo.IdCiclo =  '$rwIdCiclo'");
  $db->rows($sql_cicl);
  $_ciclo = $db->recorrer($sql_cicl);
  $rwIdConceptoCol = $_ciclo["IdConceptoDetalle"];
  $rwMonto = $_ciclo["Monto"];
  $rwNumero = $_ciclo["Numero"];
  $rwFecha = $_ciclo["Fecha"];
  $rwIdConceptoPlan = $_ciclo["IdConceptoPlan"];

  if (!$rwIdConceptoCol) {
    echo 2;
    exit();
  }


  #Generamos los pagos de reinscripci贸n
  $sql_reins = $db->query("SELECT tblc_conceptosdetalle.IdConceptoDetalle, tblc_costos_ciclo.IdCosto, tblc_costos_ciclo.Monto, tblc_costos_ciclo.Fecha, tblc_costos_ciclo.Numero, tblc_conceptosdetalle.IdConceptoPlan FROM tblc_conceptosdetalle Left Join tblc_costos_ciclo ON tblc_costos_ciclo.IdPlan = tblc_conceptosdetalle.IdConceptoPlan WHERE tblc_conceptosdetalle.IdOferta =  '$IdOferta' AND tblc_conceptosdetalle.IdConcepto =  '3' AND tblc_costos_ciclo.IdCiclo =  '$rwIdCiclo'");
  while ($_reins = $db->recorrer($sql_reins)) {
    $sql_user1 = $db->query("SELECT tblc_usuario.IdUsua FROM tblc_usuario WHERE tblc_usuario.IdEstatus = '8' AND tblc_usuario.IdGrupo = '$IdGrupo'");
    while ($_user1 = $db->recorrer($sql_user1)) {
      $anio = substr($_reins['Fecha'], 0, 4);
      $insertar = $db->query("INSERT INTO tblp_pagos (IdUsua,Monto,IdEstatus,IdOferta,FecCap,Fecha,IdCiclo,Anio,IdConceptoPlan,IdCampus, Facturar,TipoSolicitud, Capturado, _idEstatus, IdConcepto, TotalPagado, Recargos, Descuento, IdGrupo) VALUES('" . $_user1['IdUsua'] . "','" . $_reins['Monto'] . "','1','$IdOferta',NOW(),'" . $_reins['Fecha'] . "','$rwIdCiclo','$anio','" . $_reins['IdConceptoPlan'] . "','$IdCampus','NO-F6','2','1','32','3',0,0,0,'$IdGrupo')");
      $insertar = $db->query("INSERT INTO tblc_docalumnos (IdUsua, IdTipoDocumento, Estatus, IdCiclo, Doc, IdGrupo) VALUES ('" . $_user1['IdUsua'] . "','103','1','$rwIdCiclo','T','$IdGrupo')");
      $insertar = $db->query("INSERT INTO tblc_docalumnos (IdUsua, IdTipoDocumento, Estatus, IdCiclo, Doc, IdGrupo) VALUES ('" . $_user1['IdUsua'] . "','105','1','$rwIdCiclo','T','$IdGrupo')");
      $insertar = $db->query("INSERT INTO tblp_beca (IdUsua, IdConcepto, Porcentaje, FecCap, IdUsuaCap, IdEstatus, IdConvenio, IdCiclo, Promedio, Importe, Descuento, Total)  VALUES ('" . $_user1['IdUsua'] . "','3','0',NOW(),'1','1','1000','$rwIdCiclo','0','".$_reins['Monto']."', 0, '".$_reins['Monto']."')");
      $insertar = $db->query("INSERT INTO tblp_beca (IdUsua, IdConcepto, Porcentaje, FecCap, IdUsuaCap, IdEstatus, IdConvenio, IdCiclo, Promedio, Importe, Descuento, Total)  VALUES ('" . $_user1['IdUsua'] . "','2','0',NOW(),'1','1','1000','$rwIdCiclo','0','$rwMonto', 0, '$rwMonto')");
      $insertar = $db->query("INSERT INTO tblp_personalizado (IdUsua, IdCiclo, IdOferta, FecCap, Tipo, Grado, IdGrupo) VALUES ('" . $_user1['IdUsua'] . "','$rwIdCiclo','$IdOferta',NOW(),'R','$grado_nuevo','$IdGrupo')");
      $insertar = $db->query("INSERT INTO tblc_alumnos (IdGrupo, IdCiclo, IdUsua, Grado, Tipo, IdEstatus, FecCap, Valor, aut)  VALUES ('$IdGrupo','$rwIdCiclo','" . $_user1['IdUsua'] . "','$grado_nuevo','R','8',NOW(),'1','1')");
    }
  }
  $mont = 0;
  $fecha_actual = $rwFecha;
  for ($i = 1; $i <= $rwNumero; $i++) {
    $anio = substr($fecha_actual, 0, 4);

    $sql_user2 = $db->query("SELECT tblc_usuario.IdUsua FROM tblc_usuario WHERE tblc_usuario.IdEstatus = '8' AND tblc_usuario.IdGrupo = '$IdGrupo'");
    while ($_user2 = $db->recorrer($sql_user2)) {
      $mont = 0;
      $insertar = $db->query("INSERT INTO tblp_pagos (IdUsua,Monto,IdEstatus,IdOferta,FecCap,Fecha,IdCiclo,Anio,IdConceptoPlan,IdCampus, Facturar,TipoSolicitud, Capturado, _idEstatus, IdConcepto, TotalPagado, Recargos, Descuento, IdGrupo) VALUES('" . $_user2['IdUsua'] . "','$rwMonto','1','$IdOferta',NOW(),'$fecha_actual','$rwIdCiclo','$anio','$rwIdConceptoPlan','$IdCampus','NO-F7','2','1','32','2',0,0,0,'$IdGrupo')");
    }
    $fecha_actual = date("Y-m-d", strtotime($fecha_actual . "+ 1 month"));
  }
  

  $insertar = $db->query("INSERT INTO tblc_ciclogrupo (IdCiclo, IdGrupo, FecCap, Grado) VALUES ('$rwIdCiclo','$IdGrupo',NOW(),'$grado_nuevo')");
  $insertar = $db->query("UPDATE tblc_ciclogrupo SET tblc_ciclogrupo.Migrado = '1' WHERE tblc_ciclogrupo.IdGrupo = '$IdGrupo' AND tblc_ciclogrupo.IdCiclo = '$IdCiclo'");
  $insertar = $db->query("UPDATE tblp_grupo SET tblp_grupo.Grado = '$Grado' WHERE tblp_grupo.IdGrupo = '$IdGrupo'");


  if ($insertar) {
    echo $insertar;
  } else {
    echo 0;
  }
}

if ($tipoGuardar == "sav_mod_enc") {
  $Mod = $_POST["Mod"];
  $Tipo = $_POST["Tipo"];
  $insertar = $db->query("INSERT INTO tblx_modulo (Nombre_mod, IdTipoEva) VALUES ('$Mod','$Tipo')");
  $db->close();

  echo $insertar;
}

if ($tipoGuardar == "sav_bloq_enc") {
  $IdMod = $_POST["IdMod"];
  $Bloq = $_POST["Bloq"];
  $Tipo = $_POST["Tipo"];
  $insertar = $db->query("INSERT INTO tblx_bloque (IdMod, Bloque, IdTipoEva) VALUES ('$IdMod','$Bloq','$Tipo')");
  $db->close();

  echo $insertar;
}

if ($tipoGuardar == "precio_titulo") {
  $IdCalendario = $_POST["IdCalendario"];
  $sql_nivel = $db->query("SELECT tblp_calendario.Monto FROM tblp_calendario WHERE tblp_calendario.IdCalendario =  '$IdCalendario'");
  $db->rows($sql_nivel);
  $_nivel = $db->recorrer($sql_nivel);
  $_monto = $_nivel["Monto"];

  $db->close();

  echo $_monto;
}

if ($tipoGuardar == "gen_pase_lista") {
  $IdAsignacion = $_POST["IdAsignacion"];


  $db = new Conexion();

  $hc = 0;
  $_d1 = 0;
  $_d2 = 0;
  $_d3 = 0;
  $_d4 = 0;
  $sql = $db->query("SELECT tblp_horario.IdHorario, tblp_horario.IdDia FROM tblp_horario WHERE tblp_horario.IdAsignacion =  '$IdAsignacion' AND tblp_horario.Total IS NOT NULL ");
  while ($x = $db->recorrer($sql)) {
    $hc = ($hc + 1);
    if ($hc == 1) {
      $_d1 = $x['IdDia'];
    }
    if ($hc == 2) {
      $_d2 = $x['IdDia'];
    }
    if ($hc == 3) {
      $_d3 = $x['IdDia'];
    }
  }

  $sql1 = $db->query("SELECT tblp_asignacion.IdAsignacion, tblp_asignacion.FecIni, tblp_asignacion.FecFin FROM tblp_asignacion WHERE tblp_asignacion.IdAsignacion =  '$IdAsignacion' AND tblp_asignacion.Tipo =  '2'");
  $db->rows($sql1);
  $datos2 = $db->recorrer($sql1);

  $dia = substr($datos2["FecFin"], 8, 2) + 1;
  if ($dia < 10) {
    $dia = "0" . $dia;
  }

  $_ini = substr($datos2["FecIni"], 8, 2) . '-' . substr($datos2["FecIni"], 5, 2) . '-' . substr($datos2["FecIni"], 0, 4);
  $_fin = $dia . '-' . substr($datos2["FecFin"], 5, 2) . '-' . substr($datos2["FecFin"], 0, 4);


  $fechaInicio = strtotime($_ini);
  $fechaFin = strtotime($_fin);
  $dx = 0;

  for ($i = $fechaInicio; $i <= $fechaFin; $i += 86400) {
    $dia = dias_semana(date("Y-m-d", $i));


    if (($dia == $_d1) || ($dia == $_d2) || ($dia == $_d3)) {
      $fec = date("Y-m-d", $i);
      $dx = ($dx + 1);

      $sql_us = $db->query("SELECT tblp_moduloalumno.IdUsua FROM tblp_moduloalumno WHERE tblp_moduloalumno.IdAsignacion = '$IdAsignacion'");
      while ($u = $db->recorrer($sql_us)) {
        $IdUsua = $u["IdUsua"];
        $anioM = substr($fec, 0, 7);

        $sql_ls = $db->query("SELECT tblp_asistencia.IdAsistencia FROM tblp_asistencia WHERE tblp_asistencia.Fecha = '$fec' AND tblp_asistencia.IdAsignacion =  '$IdAsignacion' AND tblp_asistencia.IdUsua =  '$IdUsua'");
        $db->rows($sql_ls);
        $_list = $db->recorrer($sql_ls);
        $Id_asis = $_list['IdAsistencia'];
        if (!$Id_asis) {
          $insertar = $db->query("INSERT INTO tblp_asistencia(IdUsua, IdAsignacion, Fecha, IdTipo, AnioMes) VALUES ('$IdUsua','$IdAsignacion','$fec','1','$anioM')");
        }
      }
    }
  }

  $insertar = $db->query("UPDATE tblp_asignacion SET tblp_asignacion.NoDias = '$dx' WHERE tblp_asignacion.IdAsignacion = '$IdAsignacion'");
  echo 1;
}



if ($tipoGuardar == "upd_acta_profesional") {
  $Folio = $_POST["Folio"];
  $No = $_POST["No"];
  $Autorizacion = $_POST["Autorizacion"];
  $Ciudad = $_POST["Ciudad"];
  $Hora = $_POST["Hora"];
  $Dia = $_POST["Dia"];
  $Mes = $_POST["Mes"];
  $Auditorio = $_POST["Auditorio"];
  $Escuela = $_POST["Escuela"];
  $Presidente = $_POST["Presidente"];
  $Secretario = $_POST["Secretario"];
  $Vocal = $_POST["Vocal"];
  $Tipo = $_POST["Tipo"];
  $Estatus = $_POST["Estatus"];
  $Profesion = $_POST["Profesion"];
  $IdUsua = $_POST["IdUsua"];
  $Anio = $_POST["Anio"];
  $Cedula1 = $_POST["Cedula1"];
  $Cedula2 = $_POST["Cedula2"];
  $Cedula3 = $_POST["Cedula3"];
  $FGrado = $_POST["FGrado"];
  $FCertificado = $_POST["FCertificado"];
  $FConstancia = $_POST["FConstancia"];

  $sqle3 = $db->query("SELECT tblc_usuario.Grado FROM tblc_usuario WHERE tblc_usuario.IdUsua = '$IdUsua'");
  $db->rows($sqle3);
  $datose31 = $db->recorrer($sqle3);
  $Grado = $datose31['Grado'];
  if ($FGrado) {
    $idDocs = $Grado . '2';
    $sql_ex = $db->query("SELECT tblp_alumnos_docs.IdDocs_alumno FROM tblp_alumnos_docs WHERE tblp_alumnos_docs.IdUsua = '$IdUsua' AND tblp_alumnos_docs.IdDocumento = '$idDocs'");
    $db->rows($sql_ex);
    $ex_1 = $db->recorrer($sql_ex);
    $IdDoc = $ex_1['IdDocs_alumno'];
    if (!$IdDoc) {
      $insertar = $db->query("INSERT INTO tblp_alumnos_docs (IdUsua, IdDocumento, Fecha, FecCap) VALUES ('$IdUsua', '$idDocs', '$FGrado', NOW()) ");
      $insertar = $db->query("UPDATE tblp_acta SET tblp_acta.F_grado = '$FGrado' WHERE tblp_acta.IdUsua = '$IdUsua'");
    }
  }
  if ($FCertificado) {
    $idDocs = $Grado . '1';
    $sql_ce = $db->query("SELECT tblp_alumnos_docs.IdDocs_alumno FROM tblp_alumnos_docs WHERE tblp_alumnos_docs.IdUsua = '$IdUsua' AND tblp_alumnos_docs.IdDocumento = '$idDocs'");
    $db->rows($sql_ce);
    $ce_1 = $db->recorrer($sql_ce);
    $IdDoc = $ce_1['IdDocs_alumno'];
    if (!$IdDoc) {
      $insertar = $db->query("INSERT INTO tblp_alumnos_docs (IdUsua, IdDocumento, Fecha, FecCap) VALUES ('$IdUsua', '$idDocs', '$FCertificado', NOW()) ");
      $insertar = $db->query("UPDATE tblp_acta SET tblp_acta.F_certificado = '$FCertificado' WHERE tblp_acta.IdUsua = '$IdUsua'");
    }
  }
  if ($FConstancia) {
    $idDocs = $Grado . '4';
    $sql_co = $db->query("SELECT tblp_alumnos_docs.IdDocs_alumno FROM tblp_alumnos_docs WHERE tblp_alumnos_docs.IdUsua = '$IdUsua' AND tblp_alumnos_docs.IdDocumento = '$idDocs'");
    $db->rows($sql_co);
    $co_1 = $db->recorrer($sql_co);
    $IdDoc = $co_1['IdDocs_alumno'];
    if (!$IdDoc) {
      $insertar = $db->query("INSERT INTO tblp_alumnos_docs (IdUsua, IdDocumento, Fecha, FecCap) VALUES ('$IdUsua', '$idDocs', '$FConstancia', NOW()) ");
      $insertar = $db->query("UPDATE tblp_acta SET tblp_acta.F_constancia = '$FConstancia' WHERE tblp_acta.IdUsua = '$IdUsua'");
    }
  }

  $insertar = $db->query("UPDATE tblp_acta SET tblp_acta.Folio = '$Folio', tblp_acta.No = '$No', tblp_acta.Autorizacion = '$Autorizacion', tblp_acta.Ciudad = '$Ciudad', tblp_acta.Hora = '$Hora', tblp_acta.Dia = '$Dia', tblp_acta.Mes = '$Mes', tblp_acta.Auditorio = '$Auditorio', tblp_acta.Escuela = '$Escuela', tblp_acta.Presidente = '$Presidente', tblp_acta.Secretario = '$Secretario',  tblp_acta.Vocal = '$Vocal',  tblp_acta.Anio = '$Anio', tblp_acta.Tipo = '$Tipo', tblp_acta.Estatus = '$Estatus', tblp_acta.Profesion = '$Profesion', tblp_acta.Cedula1 = '$Cedula1', tblp_acta.Cedula2 = '$Cedula2', tblp_acta.Cedula3 = '$Cedula3' WHERE tblp_acta.IdUsua = '$IdUsua'");

  echo 1;
}

if ($tipoGuardar == "sav_prom_gral") {
  $IdCal = $_POST["IdCal"];
  $Promedio = $_POST["Promedio"];
  $IdCiclo = $_POST["IdCiclo"];
  $IdGrupo = $_POST["IdGrupo"];

  $insertar = $db->query("UPDATE tblp_calificacion SET tblp_calificacion.IdCiclo = '$IdCiclo', tblp_calificacion.IdGrupo= '$IdGrupo', tblp_calificacion.Promedio = '$Promedio' WHERE tblp_calificacion.IdCalificacion = '$IdCal'");

  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "sav_prom_zgral_all_cps") {
  $IdCal = $_POST["IdCal"];
  $Promedio = $_POST["Promedio"];
  $IdCiclo = $_POST["IdCiclo"];
  $IdModulo = $_POST["IdModulo"];
  $IdGrupoAx = $_POST["IdGrupo"];

  $IdUsua = $_POST["IdUsua"];
  $sql9 = $db->query("SELECT tblc_usuario.Usuario, tblc_usuario.IdCampus, tblc_usuario.IdOferta, tblc_usuario.IdGrupo FROM tblc_usuario WHERE tblc_usuario.IdUsua = '$IdUsua'");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);
  $user = $datos91["Usuario"];
  $_idGrupo = $datos91["IdGrupo"];
  $_idOferta = $datos91["IdOferta"];
  $_idCampus = $datos91["IdCampus"];

  if ($IdCal == 0) {
    $sql_m = $db->query("SELECT tblp_modulo.IdModulo, tblp_modulo.CodeModulo FROM tblp_modulo WHERE tblp_modulo.IdModulo = '$IdModulo'");
    $db->rows($sql_m);
    $_mod = $db->recorrer($sql_m);
    $_codeModulo = $_mod["CodeModulo"];

    // $sql8 = $db->query("SELECT tblp_modulo.IdModulo FROM tblp_modulo WHERE tblp_modulo.IdCampus = '$_idCampus' AND tblp_modulo.CodeModulo = '$_codeModulo'");
    // $db->rows($sql8);
    // $datos81 = $db->recorrer($sql8);
    // $_idModulo = $datos81["IdModulo"];
    // if(!$_idModulo){
    //   $db->close();
    //   echo 2;
    //   exit();
    // }

    $sql_prom = $db->query("SELECT tblp_calificacion.IdCalificacion, tblp_calificacion.Promedio, tblp_modulo.CodeModulo FROM tblp_calificacion Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_calificacion.IdModulo WHERE tblp_calificacion.IdUsua =  '$IdUsua' AND tblp_modulo.IdModulo =  '$IdModulo' AND tblp_calificacion.IdOferta =  '$_idOferta'");
    $db->rows($sql_prom);
    $_prx = $db->recorrer($sql_prom);
    $_idcal = $_prx['IdCalificacion'];
    if ($_idcal) {
      $insertar = $db->query("UPDATE tblp_calificacion SET tblp_calificacion.IdCiclo = '$IdCiclo', tblp_calificacion.IdGrupo= '$_idGrupo', tblp_calificacion.Promedio = '$Promedio' WHERE tblp_calificacion.IdCalificacion = '$_idcal'");
      $db->close();
      echo 1;
      exit();
    }

    $sql_a = $db->query("SELECT tblp_asignacion.IdAsignacion FROM tblp_asignacion WHERE tblp_asignacion.IdModulo = '$IdModulo' AND tblp_asignacion.IdGrupo = '$_idGrupo' AND tblp_asignacion.IdCiclo = '$IdCiclo'");
    $db->rows($sql_a);
    $_asig = $db->recorrer($sql_a);
    $IdAsig = $_asig["IdAsignacion"];
    if (!$IdAsig) {
      $sql_xa = $db->query("SELECT tblp_asignacion.Anio, tblp_asignacion.Mes, tblp_asignacion.Fecha_impresion FROM tblp_asignacion WHERE tblp_asignacion.IdModulo = '$IdModulo' AND tblp_asignacion.IdCiclo = '$IdCiclo' AND tblp_asignacion.IdGrupo = '$IdGrupoAx'");
      $db->rows($sql_xa);
      $_xasig = $db->recorrer($sql_xa);
      $_Anio = $_xasig["Anio"];
      $_Mes = $_xasig["Mes"];
      $_Fecha_impresion = $_xasig["Fecha_impresion"];

      $caracteres_permitidos = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $longitud = 15;
      $IdAsig =  substr(str_shuffle($caracteres_permitidos), 0, $longitud);
      $insertar = $db->query("INSERT INTO tblp_asignacion (IdAsignacion,IdEducativa, IdModulo, Estatus, FecCap,Tipo,IdGrupo, IdCiclo, IdEstatus, IdCampus, Anio, Mes, Fondo, _texto, Fecha_impresion) VALUES ('$IdAsig','$_idOferta','$IdModulo','Finalizado',NOW(),'2','$_idGrupo','$IdCiclo','26','$_idCampus','$_Anio','$_Mes','----','----','$_Fecha_impresion')");
      $IdAsig = $db->insert_id;
    }

    $insertar = $db->query("INSERT INTO tblp_calificacion (IdUsua, Usuario, IdOferta, IdModulo, FecCap, IdCiclo, IdGrupo, IdTipo, IdEstatus, IdAsignacion, Promedio) VALUES ('$IdUsua','$user','$_idOferta','$IdModulo',NOW(),'$IdCiclo','$_idGrupo','2','8','$IdAsig','$Promedio')");
  } else {

    $insertar = $db->query("UPDATE tblp_calificacion SET tblp_calificacion.IdCiclo = '$IdCiclo', tblp_calificacion.IdGrupo= '$_idGrupo', tblp_calificacion.Promedio = '$Promedio' WHERE tblp_calificacion.IdCalificacion = '$IdCal'");
  }

  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "sav_prom_id") {
  $IdCal = $_POST["IdCal"];
  $Promedio = $_POST["Promedio"];
  $Asis = $_POST["Asis"];
  $Falt = $_POST["Falt"];

  $insertar = $db->query("UPDATE tblp_calificacion SET tblp_calificacion.F = '$Falt', tblp_calificacion.A = '$Asis', tblp_calificacion.E1 = '$Promedio' WHERE tblp_calificacion.IdCalificacion = '$IdCal'");

  if ($Promedio) {
    $sql_xa = $db->query("SELECT tblp_calificacion.IdUsua, tblp_calificacion.IdGrupo, tblp_calificacion.IdCiclo FROM tblp_calificacion WHERE tblp_calificacion.IdCalificacion = '$IdCal'");
    $db->rows($sql_xa);
    $_xasig = $db->recorrer($sql_xa);
    $IdUsua = $_xasig["IdUsua"];
    $IdGrupo = $_xasig["IdGrupo"];
    $IdCiclo = $_xasig["IdCiclo"];

    $n = 0;
    $val = 0;
    $_bxa = '';
    $_bxb = '';
    $_bxc = '';
    $sql = $db->query("SELECT tblp_calificacion.IdCalificacion, tblp_calificacion.E1, tblp_modulo.Code FROM tblp_calificacion Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_calificacion.IdModulo WHERE tblp_calificacion.IdUsua = '$IdUsua' AND tblp_calificacion.IdGrupo = '$IdGrupo' AND tblp_calificacion.IdCiclo = '$IdCiclo' AND tblp_calificacion.E1 IS NOT NULL ORDER BY tblp_modulo.CodeModulo ASC ");
    while ($x = $db->recorrer($sql)) {
      $n = ($n + 1);
      $_cod = $x["Code"];
      $_e1 = $x["E1"];
      $val = substr($_cod, -1);
      if ($n == 1) {
        if ($val == 1) {
          $_bxa = "A-" . $_e1;
        }
        if ($val == 2) {
          $_bxa = "B-" . $_e1;
        }
        if ($val == 3) {
          $_bxa = "C-" . $_e1;
        }
        if ($val == 4) {
          $_bxa = "D-" . $_e1;
        }
        if ($val == 5) {
          $_bxa = "E-" . $_e1;
        }
        if ($val == 6) {
          $_bxa = "F-" . $_e1;
        }
        if ($val == 7) {
          $_bxa = "G-" . $_e1;
        }
        if ($val == 8) {
          $_bxa = "H-" . $_e1;
        }
        if ($val == 9) {
          $_bxa = "I-" . $_e1;
        }
      }
      if ($n == 2) {
        if ($val == 1) {
          $_bxb = "A-" . $_e1;
        }
        if ($val == 2) {
          $_bxb = "B-" . $_e1;
        }
        if ($val == 3) {
          $_bxb = "C-" . $_e1;
        }
        if ($val == 4) {
          $_bxb = "D-" . $_e1;
        }
        if ($val == 5) {
          $_bxb = "E-" . $_e1;
        }
        if ($val == 6) {
          $_bxb = "F-" . $_e1;
        }
        if ($val == 7) {
          $_bxb = "G-" . $_e1;
        }
        if ($val == 8) {
          $_bxb = "H-" . $_e1;
        }
        if ($val == 9) {
          $_bxb = "I-" . $_e1;
        }
      }
      if ($n == 3) {
        if ($val == 1) {
          $_bxc = "A-" . $_e1;
        }
        if ($val == 2) {
          $_bxc = "B-" . $_e1;
        }
        if ($val == 3) {
          $_bxc = "C-" . $_e1;
        }
        if ($val == 4) {
          $_bxc = "D-" . $_e1;
        }
        if ($val == 5) {
          $_bxc = "E-" . $_e1;
        }
        if ($val == 6) {
          $_bxc = "F-" . $_e1;
        }
        if ($val == 7) {
          $_bxc = "G-" . $_e1;
        }
        if ($val == 8) {
          $_bxc = "H-" . $_e1;
        }
        if ($val == 9) {
          $_bxc = "I-" . $_e1;
        }
      }
    }

    $insertar = $db->query("UPDATE tblp_calificacion SET tblp_calificacion._A = '$_bxa', tblp_calificacion._B = '$_bxb', tblp_calificacion._C = '$_bxc' WHERE tblp_calificacion.IdUsua = '$IdUsua' AND tblp_calificacion.IdCiclo = '$IdCiclo' AND tblp_calificacion.IdCalificacion = '$IdCal'");
  }



  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "sav_nivel_class") {
  $IdUsua = $_POST["IdUsua"];
  $IdNivel = $_POST["IdNivel"];
  $Valor = $_POST["Valor"];
  if ($Valor == 1) {
    $insertar = $db->query("INSERT INTO tblc_nivel_clases (IdUsua, IdGrado, FecCap) VALUES ('$IdUsua','$IdNivel',NOW())");
  } else {
    $insertar = $db->query("DELETE FROM tblc_nivel_clases WHERE tblc_nivel_clases.IdUsua = '$IdUsua' AND tblc_nivel_clases.IdGrado = '$IdNivel'");
  }

  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "renov_beca") {
  $IdCiclo = $_POST["IdCiclo"];
  $IdGrupo = $_POST["IdGrupo"];
  $IdUsCap = $_POST["IdUsua"];

  $sqly = $db->query("SELECT tblc_usuario.IdUsua FROM tblc_usuario WHERE tblc_usuario.IdGrupo = '$IdGrupo' AND ((tblc_usuario.IdEstatus = '8') || (tblc_usuario.IdEstatus = '50'))");
  while ($z = $db->recorrer($sqly)) {
    $prom = 0;
    $IdEst = 1;
    $IdUs = $z["IdUsua"];

    $sql_col = $db->query("SELECT tblp_beca.Porcentaje, tblp_beca.IdConvenio FROM tblp_beca WHERE tblp_beca.IdConcepto = '2' AND tblp_beca.IdUsua = '$IdUs' ORDER BY tblp_beca.FecCap DESC");
    $db->rows($sql_col);
    $_col = $db->recorrer($sql_col);
    $colegiatura = $_col['Porcentaje'];
    $idConvenio = $_col['IdConvenio'];

    // $sql_col = $db->query("SELECT Count(tblp_calificacion.IdCalificacion) AS Materias, Sum(tblp_calificacion.Promedio) AS Total FROM tblp_calificacion WHERE tblp_calificacion.IdUsua =  '$IdUs' AND tblp_calificacion.IdCiclo =  '$_IdCiclo'");
    // $db->rows($sql_col);
    // $_col = $db->recorrer($sql_col);
    // $Materias = $_col['Materias'];
    // $Total = $_col['Total'];
    // if($Total){
    //   $prom = ($Total/$Materias);
    // }
    //
    // if($prom >= 9){
    //   $IdEst = 8;
    // }
    //
    // if(!$Inscripcion){ $Inscripcion = 0; }
    // if(!$colegiatura){ $colegiatura = 0; }

    // $insertar = $db->query("INSERT INTO tblp_beca (IdUsua, IdConcepto, Porcentaje, FecCap, IdUsuaCap, IdEstatus, IdConvenio, IdCiclo, Promedio) VALUES ('$IdUs','1','$Inscripcion',NOW(),'$IdUsCap','$IdEst','1','$IdCiclo','$prom')");
    $insertar = $db->query("INSERT INTO tblp_beca (IdUsua, IdConcepto, Porcentaje, FecCap, IdUsuaCap, IdEstatus, IdConvenio, IdCiclo, Promedio) VALUES ('$IdUs','2','$colegiatura',NOW(),'$IdUsCap','$IdEst','$idConvenio','$IdCiclo','$prom')");
    $insertar = $db->query("UPDATE tblp_beca SET tblp_beca.IdEstatus = '22' WHERE tblp_beca.IdUsua = '$IdUs' AND tblp_beca.IdCiclo <> '$IdCiclo'");
  }

  $db->close();
  echo $insertar;
}


if ($tipoGuardar == "eliminar_pago_id") {
  $IdDetallePagos = $_POST["IdDetallePagos"];
  $IdPago = $_POST["IdPago"];

  $insertar = $db->query("DELETE FROM tblh_detallepagos WHERE tblh_detallepagos.IdDetallePagos = '$IdDetallePagos' ");

  $sql_col = $db->query("SELECT Count(tblh_detallepagos.IdDetallePagos) AS Total FROM tblh_detallepagos WHERE tblh_detallepagos.IdPago =  '$IdPago'");
  $db->rows($sql_col);
  $_col = $db->recorrer($sql_col);
  $Total = $_col['Total'];
  if ($Total == 0) {
    $insertar = $db->query("UPDATE tblp_pagos SET tblp_pagos._img = NULL WHERE tblp_pagos.IdPago = '$IdPago'");
  }

  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "renov_beca_grp") {
  $IdCiclo = $_POST["IdCiclo"];
  $IdGrupo = $_POST["IdGrupo"];
  $IdUsCap = $_POST["IdUsua"];
  $IdConcepto = $_POST["IdConcepto"];
  $Porcentaje = $_POST["Porcentaje"];



  $sqly = $db->query("SELECT tblp_beca.IdBeca, tblp_beca.IdConcepto FROM tblp_beca Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_beca.IdUsua WHERE tblp_beca.IdCiclo =  '$IdCiclo' AND tblc_usuario.IdGrupo =  '$IdGrupo' AND tblp_beca.IdConcepto =  '$IdConcepto'");
  while ($z = $db->recorrer($sqly)) {
    $IdBeca = $z["IdBeca"];
    $insertar = $db->query("UPDATE tblp_beca SET tblp_beca.FecCap = NOW(), tblp_beca.IdUsuaCap = '$IdUsCap', tblp_beca.Porcentaje = '$Porcentaje', tblp_beca.IdEstatus = '8' WHERE tblp_beca.IdBeca = '$IdBeca'");
  }

  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "gen_beca_grp") {
  $IdSeriacion = $_POST["IdSeriacion"];
  $IdGrupo = $_POST["IdGrupo"];
  $IdCampus = $_POST["IdCampus"];
  $IdOferta = $_POST["IdOferta"];
  $numero = intval($_POST["Consecutivo"]);

  $sql_g = $db->query("SELECT tblp_grupo.FechaIni FROM tblp_grupo WHERE tblp_grupo.IdGrupo = '$IdGrupo'");
  $db->rows($sql_g);
  $_grp = $db->recorrer($sql_g);
  $anio = substr($_grp["FechaIni"], 0, 4);
  $anioo = substr($_grp["FechaIni"], 2, 2);

  $sql5 = $db->query("SELECT * FROM tblc_seriacion WHERE  tblc_seriacion.IdSeriacion = '$IdSeriacion'");
  $db->rows($sql5);
  $datos51 = $db->recorrer($sql5);
  $Mat = $datos51["Matricula"];
  $_Tipo = $datos51["Matricula"];

  // $code = str_pad($numero,3,"0",STR_PAD_LEFT);
  // $matCom = $Mat.$anioo.$code;

  $sqly = $db->query("SELECT tblc_usuario.IdUsua FROM tblc_usuario WHERE tblc_usuario.IdGrupo = '$IdGrupo' AND tblc_usuario.IdEstatus = '8' ORDER BY tblc_usuario.APaterno ASC, tblc_usuario.AMaterno ASC, tblc_usuario.Nombre ASC ");
  while ($z = $db->recorrer($sqly)) {
    $IdUsua = $z['IdUsua'];

    $code = str_pad($numero, 3, "0", STR_PAD_LEFT);
    $matricula = $Mat . $anioo . $code;

    $insertar = $db->query("DELETE FROM tblc_matricula WHERE tblc_matricula.IdUsua = '$IdUsua' ");
    $insertar = $db->query("INSERT INTO tblc_matricula (Anio, Numero, Matricula, IdUsua, IdOferta, IdGrupo, Tipo) VALUES ('$anio','$numero','$matricula','$IdUsua','$IdOferta','$IdGrupo','$Mat')");
    $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.Usuario = '$matricula', tblc_usuario.Matricula = '$matricula' WHERE tblc_usuario.IdUsua = '$IdUsua'");
    $numero = $numero + 1;
  }
  // echo "DELETE FROM tblc_matricula WHERE tblc_matricula.Tipo = '$_Tipo' AND tblc_matricula.Anio = '$anio' AND tblc_matricula.Numero >= '$numero' ";

  $insertar = $db->query("DELETE FROM tblc_matricula WHERE tblc_matricula.Tipo = '$_Tipo' AND tblc_matricula.Anio = '$anio' AND tblc_matricula.Numero >= '$numero' ");

  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "sav_datos_cedula") {
  $IdUsua = $_POST["IdUsua"];
  $IdEvaluacionX = $_POST["IdEvaluacionX"];

  $sql7 = $db->query("SELECT tblp_informacion.IdUsua FROM tblp_informacion WHERE tblp_informacion.IdUsua = '$IdUsua'");
  $db->rows($sql7);
  $datos71 = $db->recorrer($sql7);
  $IdUsuaIn = $datos71["IdUsua"];

  $sql2 = $db->query("SELECT tblc_usuario.IdUsua, tblp_educativa.IdGrado, tblc_usuario.IdOferta FROM tblc_usuario Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta WHERE tblc_usuario.IdUsua = '$IdUsua'");
  $db->rows($sql2);
  $datos21 = $db->recorrer($sql2);
  $IdGra = $datos21["IdGrado"];
  $IdOfe = $datos21["IdOferta"];

  if ($IdOfe == 9) {
    $valor = 2;
  } else {
    $valor = 1;
  }

  if (!$IdUsuaIn) {
    $insertar = $db->query("INSERT INTO tblp_informacion (IdUsua) VALUES ('$IdUsua')");

    $sql = $db->query("SELECT * FROM tblh_tipodocumento WHERE tblh_tipodocumento.Grado = '$IdGra' AND tblh_tipodocumento.Valor = '$valor'");
    while ($x = $db->recorrer($sql)) {
      $IdTDc = $x["IdTipoDoc"];
      $insertar = $db->query("INSERT INTO tblp_documentos (IdUsua, IdTipoDocumento, FecCap)VALUES ('$IdUsua','$IdTDc',NOW())");
    }
  }


  $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.Correo = '" . $_POST["Corr"] . "', tblc_usuario.Telefono = '" . $_POST["Tele"] . "', tblc_usuario.Celular = '" . $_POST["Celu"] . "' WHERE tblc_usuario.IdUsua = '$IdUsua'");
  $insertar = $db->query("UPDATE tblp_informacion SET tblp_informacion.D_direccion = '" . $_POST["Dire"] . "', tblp_informacion.Ocupacion = '" . $_POST["Ocup"] . "', tblp_informacion.Trabaja = '" . $_POST["Trab"] . "', tblp_informacion.Tel_trabajo = '" . $_POST["TelTra"] . "', tblp_informacion.P_civil = '" . $_POST["Civil"] . "' WHERE tblp_informacion.IdUsua = '$IdUsua'");
  $insertar = $db->query("UPDATE tblp_informacion SET tblp_informacion.Facebook = '" . $_POST["Face"] . "', tblp_informacion.Twitter = '" . $_POST["Twitter"] . "', tblp_informacion.E_escuela_procedencia = '" . $_POST["Egre"] . "', tblp_informacion.E_estudio = '" . $_POST["Curs"] . "', tblp_informacion.E_titulo = '" . $_POST["Titu"] . "' WHERE tblp_informacion.IdUsua = '$IdUsua'");
  $insertar = $db->query("UPDATE tblp_informacion SET tblp_informacion.E_opcion_titulacion = '" . $_POST["Otit"] . "', tblp_informacion.E_promedio = '" . $_POST["Prom"] . "' WHERE tblp_informacion.IdUsua = '$IdUsua'");
  $insertar = $db->query("UPDATE tblp_informacion SET tblp_informacion.ENombre = '" . $_POST["Nom1"] . "', tblp_informacion.EParentesco = '" . $_POST["Paren1"] . "', tblp_informacion.EDireccion = '" . $_POST["Dire1"] . "',tblp_informacion.ECelular = '" . $_POST["Cel1"] . "', tblp_informacion.ETelefono = '" . $_POST["Tel1"] . "', tblp_informacion.ETelTrabajo = '" . $_POST["Tra1"] . "' WHERE tblp_informacion.IdUsua = '$IdUsua'");
  $insertar = $db->query("UPDATE tblp_informacion SET tblp_informacion.ENombre = '" . $_POST["Nom1"] . "', tblp_informacion.EParentesco = '" . $_POST["Paren1"] . "', tblp_informacion.EDireccion = '" . $_POST["Dire1"] . "',tblp_informacion.ECelular = '" . $_POST["Cel1"] . "', tblp_informacion.ETelefono = '" . $_POST["Tel1"] . "', tblp_informacion.ETelTrabajo = '" . $_POST["Tra1"] . "' WHERE tblp_informacion.IdUsua = '$IdUsua'");
  $insertar = $db->query("UPDATE tblp_informacion SET tblp_informacion.ENombre2 = '" . $_POST["Nom2"] . "', tblp_informacion.EParentesco2 = '" . $_POST["Paren2"] . "', tblp_informacion.EDireccion2 = '" . $_POST["Dire2"] . "',tblp_informacion.ECelular2 = '" . $_POST["Cel2"] . "', tblp_informacion.ETelefono2 = '" . $_POST["Tel2"] . "', tblp_informacion.ETelTrabajo2 = '" . $_POST["Tra2"] . "' WHERE tblp_informacion.IdUsua = '$IdUsua'");

  $sqle3 = $db->query("SELECT tblp_informacion.No_egreso FROM tblp_informacion ORDER BY tblp_informacion.No_egreso DESC LIMIT 1");
  $db->rows($sqle3);
  $datose31 = $db->recorrer($sqle3);
  $no_egreso = $datose31['No_egreso'] + 1;
  $code = str_pad($no_egreso, 4, "0", STR_PAD_LEFT);
  $folio = "C-PRE-" . $code;
  $insertar = $db->query("UPDATE tblp_informacion SET tblp_informacion.Fecha_impresion = NOW(), tblp_informacion.Folio_egreso = '$folio', tblp_informacion.No_egreso = '$no_egreso' WHERE tblp_informacion.IdUsua = '$IdUsua'");

  $insertar = $db->query("UPDATE tblx_evaluacion SET tblx_evaluacion.Fin = NOW(), tblx_evaluacion.IdEstatus = '10' WHERE tblx_evaluacion.IdEvaluacionX = '$IdEvaluacionX'");
  $idDocs = $IdGra . "5";
  $hoy = date("Y-m-d");

  $insertar = $db->query("INSERT INTO tblp_alumnos_docs (IdUsua, IdDocumento, Fecha, FecCap) VALUES ('$IdUsua', '$idDocs', '$hoy', NOW()) ");
  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "load_mat_prom") {
  $IdModulo = $_POST["IdModulo"];
  $IdCiclo = $_POST["IdCiclo"];
  $IdGrupo = $_POST["IdGrupo"];
  $IdOferta = $_POST["IdOferta"];

  $caracteres_permitidos = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $longitud = 15;
  $IdAsig =  substr(str_shuffle($caracteres_permitidos), 0, $longitud);
  $IdCam = 0;
  $sqly = $db->query("SELECT tblc_usuario.IdUsua, tblc_usuario.Usuario, tblc_usuario.IdCampus FROM tblc_usuario WHERE tblc_usuario.IdGrupo = '$IdGrupo' AND tblc_usuario.IdEstatus = '8'");
  while ($z = $db->recorrer($sqly)) {
    $IdUs = $z["IdUsua"];
    $Us = $z["Usuario"];
    $IdCam = $z["IdCampus"];
    $insertar = $db->query("INSERT INTO tblp_calificacion (IdUsua, Usuario, IdOferta, IdModulo, IdCiclo, IdGrupo, IdTipo, IdAsignacion, IdEstatus) VALUES ('$IdUs','$Us','$IdOferta','$IdModulo','$IdCiclo','$IdGrupo','1','$IdAsig','8')");
  }
  $anio = date("Y");
  $mes = date("m");

  $insertar = $db->query("INSERT INTO tblp_asignacion (IdAsignacion,IdEducativa, IdModulo, Estatus, FecCap,Tipo,IdGrupo, IdCiclo, IdEstatus, IdCampus, Anio, Mes, Fondo, _texto) VALUES ('$IdAsig','$IdOferta','$IdModulo','Finalizado',NOW(),'2','$IdGrupo','$IdCiclo','26','$IdCam','$anio','$mes','----','----')");

  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "mod_beca_usua") {
  $IdConvenio = $_POST["IdConvenio"];
  $Col = $_POST["Col"];
  $IdEstatus = $_POST["IdEstatus"];
  $IdCol = $_POST["IdCol"];
  $IdAdmin = $_POST["IdAdmin"];
  $IdCiclo = $_POST["IdCiclo"];
  $IdUsua = $_POST["IdUsua"];
  $Comentario = $_POST["Comentario"];



  if ($IdCol == 0) {
    $insertar = $db->query("INSERT INTO tblp_beca (IdUsua,IdConcepto, Porcentaje, FecCap, IdUsuaCap, IdEstatus, IdConvenio, IdCiclo) VALUES ('$IdUsua','2','$Col',NOW(),'$IdAdmin','$IdEstatus','$IdConvenio','$IdCiclo')");
  } else {
    $insertar = $db->query("UPDATE tblp_beca SET tblp_beca.Comentario = '$Comentario', tblp_beca.Porcentaje = '$Col', tblp_beca.FecCap = NOW(), tblp_beca.IdUsuaCap = '$IdAdmin', tblp_beca.IdEstatus = '$IdEstatus', tblp_beca.IdConvenio = '$IdConvenio' WHERE tblp_beca.IdBeca = '$IdCol'");
  }



  $db->close();
  echo $insertar;
}


if ($tipoGuardar == "gen_pago_materia") {
  $IdConceptoPlan = $_POST["IdPlan"];
  $IdAdmin = $_POST["IdAdmin"];
  $IdCiclo = $_POST["IdCiclo"];
  $IdModulo = $_POST["IdModulo"];
  $IdGrupo = $_POST["IdGrupo"];
  $Fecha = $_POST["Fecha"];

  $sqle2 = $db->query("SELECT tblc_conceptosplanes.IdConcepto, tblc_conceptosplanes.Costo, tblc_conceptosplanes.IdGrado FROM tblc_conceptosplanes WHERE tblc_conceptosplanes.IdConceptoPlanes = '$IdConceptoPlan'");
  $db->rows($sqle2);
  $datose21 = $db->recorrer($sqle2);
  $IdConcepto = $datose21['IdConcepto'];
  $Costo = $datose21['Costo'];
  $IdGrado = $datose21['IdGrado'];

  $insertar = $db->query("INSERT INTO tblp_calendario (IdGrado, IdConceptosPlanes, FecDescuento, FecBase, FecLimite, Monto, IdUsua, FecCap, IdEstatus, IdCiclo, IdCampus, IdCicloPago, IdGrupo, IdModulo) VALUES ('$IdGrado','$IdConceptoPlan','$Fecha','$Fecha','$Fecha','$Costo','$IdAdmin',NOW(),'32','$IdCiclo','1','$IdCiclo','$IdGrupo', '$IdModulo') ");
  $IdCalendario = $db->insert_id;
  $anioHoy = date("Y");

  $sqlx = $db->query("SELECT tblc_usuario.IdUsua, tblc_usuario.Usuario, tblc_usuario.IdOferta, tblc_usuario.IdCampus FROM tblc_usuario WHERE tblc_usuario.IdGrupo = '$IdGrupo' AND ((tblc_usuario.IdEstatus = '8') || (tblc_usuario.IdEstatus = '50')) ");
  while ($x = $db->recorrer($sqlx)) {
    $insertar = $db->query("INSERT INTO tblp_pagos (IdCalendario,IdUsua,IdConceptoPlan,Monto,IdEstatus,FecCap,FecDesc, FecBase,FecLim, FecLimPago,Facturar,TipoSolicitud, Anio, IdOferta, Referencia, Filtro, IdCiclo,IdCampus,IdGrupo,_idEstatus, IdConcepto,TotalPagado, Recargos, Descuento, IdModulo)VALUES ('$IdCalendario','" . $x["IdUsua"] . "','$IdConceptoPlan','$Costo','1',NOW(),'$Fecha','$Fecha','$Fecha','$Fecha','NO-F8','1','$anioHoy','" . $x["IdOferta"] . "','" . $x["Usuario"] . "','1','$IdCiclo','" . $x["IdCampus"] . "','$IdGrupo','32','$IdConcepto',0,0,0, '$IdModulo')");
  }

  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "otro_pago_materia") {
  $IdConceptoPlan = $_POST["IdPlan"];
  $IdAdmin = $_POST["IdAdmin"];
  $IdCiclo = $_POST["IdCiclo"];
  $IdGrupo = $_POST["IdGrupo"];
  $Fecha = $_POST["Fecha"];

  $sqle2 = $db->query("SELECT tblc_conceptosplanes.IdConcepto, tblc_conceptosplanes.Costo, tblc_conceptosplanes.IdGrado FROM tblc_conceptosplanes WHERE tblc_conceptosplanes.IdConceptoPlanes = '$IdConceptoPlan'");
  $db->rows($sqle2);
  $datose21 = $db->recorrer($sqle2);
  $IdConcepto = $datose21['IdConcepto'];
  $Costo = $datose21['Costo'];
  $IdGrado = $datose21['IdGrado'];

  $insertar = $db->query("INSERT INTO tblp_calendario (IdGrado, IdConceptosPlanes, FecDescuento, FecBase, FecLimite, Monto, IdUsua, FecCap, IdEstatus, IdCiclo, IdCampus, IdCicloPago, IdGrupo) VALUES ('$IdGrado','$IdConceptoPlan','$Fecha','$Fecha','$Fecha','$Costo','$IdAdmin',NOW(),'32','$IdCiclo','1','$IdCiclo','$IdGrupo') ");
  $IdCalendario = $db->insert_id;
  $anioHoy = date("Y");

  $sqlx = $db->query("SELECT tblc_usuario.IdUsua, tblc_usuario.Usuario, tblc_usuario.IdOferta, tblc_usuario.IdCampus FROM tblc_usuario WHERE tblc_usuario.IdGrupo = '$IdGrupo' AND ((tblc_usuario.IdEstatus = '8') || (tblc_usuario.IdEstatus = '50')) ");
  while ($x = $db->recorrer($sqlx)) {
    $insertar = $db->query("INSERT INTO tblp_pagos (IdCalendario,IdUsua,IdConceptoPlan,Monto,IdEstatus,FecCap,FecDesc, FecBase,FecLim, FecLimPago,Facturar,TipoSolicitud, Anio, IdOferta, Referencia, Filtro, IdCiclo,IdCampus,IdGrupo,_idEstatus, IdConcepto,TotalPagado, Recargos, Descuento)VALUES ('$IdCalendario','" . $x["IdUsua"] . "','$IdConceptoPlan','$Costo','1',NOW(),'$Fecha','$Fecha','$Fecha','$Fecha','NO-F9','1','$anioHoy','" . $x["IdOferta"] . "','" . $x["Usuario"] . "','1','$IdCiclo','" . $x["IdCampus"] . "','$IdGrupo','32','$IdConcepto',0,0,0)");
  }

  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "upd_gen_pago_materia") {
  $IdCalendario = $_POST["IdCalendario"];
  $Fecha = $_POST["Fecha"];

  $insertar = $db->query("UPDATE tblp_pagos SET tblp_pagos.FecDesc = '$Fecha', tblp_pagos.FecBase = '$Fecha', tblp_pagos.FecLim = '$Fecha', tblp_pagos.FecLimPago = '$Fecha' WHERE tblp_pagos.IdCalendario = '$IdCalendario'");
  $insertar = $db->query("UPDATE tblp_calendario SET tblp_calendario.FecDescuento = '$Fecha', tblp_calendario.FecBase = '$Fecha', tblp_calendario.FecLimite = '$Fecha' WHERE tblp_calendario.IdCalendario = '$IdCalendario'");

  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "upd_gen_pago_xmateria") {
  $IdCalendario = $_POST["IdCalendario"];
  $Fecha = $_POST["Fecha"];

  $insertar = $db->query("UPDATE tblp_pagos SET tblp_pagos.FecDesc = '$Fecha', tblp_pagos.FecBase = '$Fecha', tblp_pagos.FecLim = '$Fecha', tblp_pagos.FecLimPago = '$Fecha' WHERE tblp_pagos.IdCalendario = '$IdCalendario'");
  $insertar = $db->query("UPDATE tblp_calendario SET tblp_calendario.FecDescuento = '$Fecha', tblp_calendario.FecBase = '$Fecha', tblp_calendario.FecLimite = '$Fecha' WHERE tblp_calendario.IdCalendario = '$IdCalendario'");

  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "mod_beca_usua_x") {
  $Col = $_POST["Col"];
  $Ins = $_POST["Ins"];
  $IdEstatus = $_POST["IdEstatus"];
  $IdBecaIns = $_POST["IdBecaIns"];
  $IdBecaCol = $_POST["IdBecaCol"];
  $IdAdmin = $_POST["IdAdmin"];
  $IdUsua = $_POST["IdUsua"];
  $Comentario = $_POST["Comentario"];

  $insertar = $db->query("UPDATE tblp_beca SET tblp_beca.Comentario = '$Comentario', tblp_beca.CRM = NULL, tblp_beca.Porcentaje = '$Col', tblp_beca.FecCap = NOW(), tblp_beca.IdUsuaCap = '$IdAdmin', tblp_beca.IdEstatus = '$IdEstatus' WHERE tblp_beca.IdBeca = '$IdBecaCol'");
  $insertar = $db->query("UPDATE tblp_beca SET tblp_beca.Comentario = '$Comentario', tblp_beca.CRM = NULL, tblp_beca.Porcentaje = '$Ins', tblp_beca.FecCap = NOW(), tblp_beca.IdUsuaCap = '$IdAdmin', tblp_beca.IdEstatus = '$IdEstatus' WHERE tblp_beca.IdBeca = '$IdBecaIns'");

  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "mod_beca_usua_x_inscr") {
  $Inscripcion = $_POST["Inscripcion"];
  $IdBeca = $_POST["IdBecaIns"];
  $Importe = $_POST["Importe"];
  $IdAdmin = $_POST["IdAdmin"];
  $desc = ($Importe - $Inscripcion);
  
  $_porx = ($Inscripcion / $Importe);
  $_col = ($_porx * 100);
  $cal1 = (100 - $_col);
  $cal1 = substr($cal1, 0, 5);

  $insertar = $db->query("UPDATE tblp_beca SET tblp_beca.Total = '$Inscripcion', tblp_beca.Descuento = '$desc', tblp_beca.Importe = '$Importe', tblp_beca.CRM = NULL, tblp_beca.Porcentaje = '$cal1', tblp_beca.FecCap = NOW(), tblp_beca.IdUsuaCap = '$IdAdmin' WHERE tblp_beca.IdBeca = '$IdBeca'");
  
  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "mod_inscripcion_alumno") {
  $IdUsua = $_POST["IdUsua"];
  $IdCampus = $_POST["IdCampus"];
  $IdOferta = $_POST["IdOferta"];
  $IdCiclo = $_POST["IdCiclo"];
  $Motivo = $_POST["Comentario"];
  $IdAdmin = $_POST["IdAdmin"];
  $Nota = $_POST["Nota"];

  $sq_user = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.IdUsua = '$IdUsua' ");
  $db->rows($sq_user);
  $_user = $db->recorrer($sq_user);
  $_usuario = $_user['Usuario'];
  $_idCiclAnt = $_user['id_ciclo_ini'];

  

  $insertar = $db->query("UPDATE tblc_docalumnos SET tblc_docalumnos.IdCiclo = '$IdCiclo' WHERE tblc_docalumnos.IdUsua = '$IdUsua' ");
  // $insertar = $db->query("UPDATE tblp_beca SET tblp_beca.IdCiclo = '$IdCiclo' WHERE tblp_beca.IdUsua = '$IdUsua' AND tblp_beca.IdCiclo = '$_idCiclAnt' ");


  #Verificamos que exista el pago reinscripcion
  // $sql_cicl = $db->query("SELECT tblc_conceptosdetalle.IdConceptoDetalle, tblc_costos_ciclo.IdCosto FROM tblc_conceptosdetalle Left Join tblc_costos_ciclo ON tblc_costos_ciclo.IdPlan = tblc_conceptosdetalle.IdConceptoPlan WHERE tblc_conceptosdetalle.IdOferta =  '$IdOferta' AND tblc_conceptosdetalle.IdConcepto =  '1' AND tblc_costos_ciclo.IdCiclo =  '$IdCiclo'");
  // $db->rows($sql_cicl);
  // $_ciclo = $db->recorrer($sql_cicl);
  // $rwIdConceptoCol = $_ciclo["IdConceptoDetalle"];

  // if (!$rwIdConceptoCol) {
  //   echo 3;
  //   exit();
  // }

  // $sql_cicl = $db->query("SELECT tblc_conceptosdetalle.IdConceptoDetalle, tblc_costos_ciclo.IdCosto FROM tblc_conceptosdetalle Left Join tblc_costos_ciclo ON tblc_costos_ciclo.IdPlan = tblc_conceptosdetalle.IdConceptoPlan WHERE tblc_conceptosdetalle.IdOferta =  '$IdOferta' AND tblc_conceptosdetalle.IdConcepto =  '2' AND tblc_costos_ciclo.IdCiclo =  '$IdCiclo'");
  // $db->rows($sql_cicl);
  // $_ciclo = $db->recorrer($sql_cicl);
  // $rwIdConceptoCol = $_ciclo["IdConceptoDetalle"];

  // if (!$rwIdConceptoCol) {
  //   echo 2;
  //   exit();
  // }

  // $sum = 0;
  // $sqly = $db->query("SELECT tblp_pagos.IdPago, tblp_pagos.IdUsua, tblp_pagos.IdEstatus, tblp_pagos.TotalPagado, tblp_pagos.IdConcepto FROM tblp_pagos WHERE tblp_pagos.IdUsua = '$IdUsua' AND ((tblp_pagos.IdConcepto =  '1') || (tblp_pagos.IdConcepto =  '2')) ORDER BY tblp_pagos.IdConcepto ASC, tblp_pagos.Fecha ASC");
  // while($z = $db->recorrer($sqly)){
  //   $idPag = $z['IdPago'];
  //   $idE = $z['IdEstatus'];
  //   $pag = $z['TotalPagado'];
  //   if(($idE == 4) || (($pag <> 0))){
  //     $sum = ($sum + 1);
  //   } else {
  //     $insertar = $db->query("DELETE FROM tblp_pagos WHERE tblp_pagos.IdPago = '$idPag'");
  //   }
  // }

  // if($sum >= 1){
  //   $_x = 0;
  //   $sql_g_pag = $db->query("SELECT tblp_calendario.IdCalendario, tblp_calendario.FecDescuento, tblp_calendario.Monto, tblc_conceptosdetalle.IdConceptoPlan, tblc_conceptosplanes.IdConcepto, tblc_conceptosplanes.Costo FROM tblp_calendario Left Join tblc_conceptosdetalle ON tblc_conceptosdetalle.IdConceptoPlan = tblp_calendario.IdConceptosPlanes Left Join tblc_conceptosplanes ON tblc_conceptosplanes.IdConceptoPlanes = tblc_conceptosdetalle.IdConceptoPlan WHERE tblp_calendario.IdCiclo =  '$IdCiclo' AND tblc_conceptosdetalle.IdOferta =  '$IdOferta' AND ((tblc_conceptosplanes.IdConcepto =  '1') || (tblc_conceptosplanes.IdConcepto =  '2')) ORDER BY tblp_calendario.FecDescuento ASC");
  //     while($x = $db->recorrer($sql_g_pag)){ $_x = ($_x+ 1);
  //       if($_x > $sum){
  //       $IdActividad = 0;
  //       $IdCal = $x['IdCalendario'];
  //       $IdConcepto = $x['IdConcepto'];
  //       $Monto = $x['Monto'];
  //       $Fec = $x['FecDescuento'];
  //       $anio = substr($x['FecDescuento'], 0, 4);
  //       $IdPlan = $x['IdConceptoPlan'];
  //       $insertar = $db->query("INSERT INTO tblp_pagos (IdCalendario,IdUsua,Monto,IdEstatus,IdOferta,FecCap,Fecha,FecDesc, FecBase,FecLim, FecLimPago,IdCiclo,Anio,IdConceptoPlan,IdCampus, Facturar,TipoSolicitud, Capturado, Tipo, IdActividad, _idEstatus, IdConcepto, TotalPagado, Recargos, Descuento) VALUES('$IdCal','$IdUsua','$Monto','1','$IdOferta',NOW(),'$Fec', '$Fec','$Fec','$Fec','$Fec','$IdCiclo','$anio','$IdPlan','$IdCampus','NO-F10','2','1','1','$IdActividad','32','$IdConcepto',0,0,0)");
  //       $insertar = $db->query("UPDATE tblp_beca SET tblp_beca.Importe = '$Monto', tblp_beca.Descuento = '0', tblp_beca.Total = '$Monto', tblp_beca.Porcentaje = '0',  tblp_beca.IdCiclo = '$IdCiclo' WHERE tblp_beca.IdUsua = '$IdUsua' AND tblp_beca.IdConcepto = '$IdConcepto'");
  //     }
  //     }
  // } else {
  //   $insertar = $db->query("DELETE FROM tblp_pagos WHERE tblp_pagos.IdUsua = '$IdUsua' AND ((tblp_pagos.IdConcepto =  '1') || (tblp_pagos.IdConcepto =  '2')) ");
  //   $_x = 0;
    
  //   $sql_g_pag = $db->query("SELECT tblp_calendario.IdCalendario, tblp_calendario.FecDescuento, tblp_calendario.Monto, tblc_conceptosdetalle.IdConceptoPlan, tblc_conceptosplanes.IdConcepto, tblc_conceptosplanes.Costo FROM tblp_calendario Left Join tblc_conceptosdetalle ON tblc_conceptosdetalle.IdConceptoPlan = tblp_calendario.IdConceptosPlanes Left Join tblc_conceptosplanes ON tblc_conceptosplanes.IdConceptoPlanes = tblc_conceptosdetalle.IdConceptoPlan WHERE tblp_calendario.IdCiclo =  '$IdCiclo' AND tblc_conceptosdetalle.IdOferta =  '$IdOferta' AND ((tblc_conceptosplanes.IdConcepto =  '1') || (tblc_conceptosplanes.IdConcepto =  '2')) ORDER BY tblp_calendario.FecDescuento ASC");
  //     while($x = $db->recorrer($sql_g_pag)){ $_x = ($_x+ 1);
  //       $IdActividad = 0;
  //       $IdCal = $x['IdCalendario'];
  //       $IdConcepto = $x['IdConcepto'];
  //       $Monto = $x['Monto'];
  //       $Fec = $x['FecDescuento'];
  //       $anio = substr($x['FecDescuento'], 0, 4);
  //       $IdPlan = $x['IdConceptoPlan'];
  //       $insertar = $db->query("INSERT INTO tblp_pagos (IdCalendario,IdUsua,Monto,IdEstatus,IdOferta,FecCap, Fecha, FecDesc, FecBase,FecLim, FecLimPago,IdCiclo,Anio,IdConceptoPlan,IdCampus, Facturar,TipoSolicitud, Capturado, Tipo, IdActividad, _idEstatus, IdConcepto, TotalPagado, Recargos, Descuento) VALUES('$IdCal','$IdUsua','$Monto','1','$IdOferta',NOW(),'$Fec','$Fec','$Fec','$Fec','$Fec','$IdCiclo','$anio','$IdPlan','$IdCampus','NO-F11','2','1','1','$IdActividad','32','$IdConcepto',0,0,0)");

  //       $insertar = $db->query("UPDATE tblp_beca SET tblp_beca.Importe = '$Monto', tblp_beca.Descuento = '0', tblp_beca.Total = '$Monto', tblp_beca.Porcentaje = '0',  tblp_beca.IdCiclo = '$IdCiclo' WHERE tblp_beca.IdUsua = '$IdUsua' AND tblp_beca.IdConcepto = '$IdConcepto'");

  //     }
  // }

  $insertar = $db->query("UPDATE tblp_beca SET tblp_beca.IdCiclo = '$IdCiclo' WHERE tblp_beca.IdUsua = '$IdUsua' ");
  $Fecha = date("Y-m-d");
  $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.Semblanza = '$Nota', tblc_usuario.id_ciclo_ini = '$IdCiclo',  tblc_usuario.IdOferta = '$IdOferta', tblc_usuario.IdCampus = '$IdCampus' WHERE tblc_usuario.IdUsua = '$IdUsua'");
  $insertar = $db->query("UPDATE tblp_pagos SET tblp_pagos.IdCampus = '$IdCampus', tblp_pagos.IdCiclo = '$IdCiclo', tblp_pagos.IdOferta = '$IdOferta' WHERE tblp_pagos.IdUsua = '$IdUsua' ");
  $insertar = $db->query("INSERT INTO tblp_seguimiento (IdUsua, IdCiclo, Fecha, FecCap, Comentario_control, IdTipoSeguimiento, IdUsua_admin)  VALUES ('$IdUsua','$IdCiclo','$Fecha',NOW(),'$Motivo','1','$IdAdmin')");

  $insertar = $db->query("DELETE FROM tblp_moduloalumno WHERE tblp_moduloalumno.IdUsua = '$IdUsua' ");
  $insertar = $db->query("DELETE FROM tblp_asistencia WHERE tblp_asistencia.IdUsua = '$IdUsua' "); 

  $db->close();
  echo $insertar;
}


if ($tipoGuardar == "cancelar_inscripcion_id") {
  $IdUsua = $_POST["IdUsua"];
  $Motivo = $_POST["Comentario"];
  $IdAdmin = $_POST["IdAdmin"];

  $sq_user = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.IdUsua = '$IdUsua' ");
  $db->rows($sq_user);
  $_user = $db->recorrer($sq_user);
  $IdCiclo = $_user['id_ciclo_ini'];

  $Fecha = date("Y-m-d");
  $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.IdEstatus = '19',  tblc_usuario.fecha_baja = '$Fecha' WHERE tblc_usuario.IdUsua = '$IdUsua'");
  
  $insertar = $db->query("INSERT INTO tblp_seguimiento (IdUsua, IdCiclo, Fecha, FecCap, Comentario_control, IdTipoSeguimiento, IdUsua_admin)  VALUES ('$IdUsua','$IdCiclo','$Fecha',NOW(),'$Motivo','1','$IdAdmin')");

  $insertar = $db->query("DELETE FROM tblp_pagos WHERE tblp_pagos.IdUsua = '$IdUsua' AND tblp_pagos.IdEstatus = '1' AND tblp_pagos.TotalPagado = '0' ");
  $insertar = $db->query("UPDATE tblp_pagos SET tblp_pagos.IdEstatus = '58' WHERE tblp_pagos.IdUsua = '$IdUsua' AND tblp_pagos.IdEstatus = '1' ");

  $db->close();
  echo $insertar;
}


if ($tipoGuardar == "mod_beca_usua_x_mensua") {
  $Inscripcion = $_POST["Inscripcion"];
  $IdBeca = $_POST["IdBecaIns"];
  $Importe = $_POST["Importe"];
  $IdAdmin = $_POST["IdAdmin"];
  $desc = ($Importe - $Inscripcion);
  
  $_porx = ($Inscripcion / $Importe);
  $_col = ($_porx * 100);
  $cal1 = (100 - $_col);
  $cal1 = substr($cal1, 0, 5);

  $insertar = $db->query("UPDATE tblp_beca SET tblp_beca.Total = '$Inscripcion', tblp_beca.Descuento = '$desc', tblp_beca.Importe = '$Importe', tblp_beca.CRM = NULL, tblp_beca.Porcentaje = '$cal1', tblp_beca.FecCap = NOW(), tblp_beca.IdUsuaCap = '$IdAdmin' WHERE tblp_beca.IdBeca = '$IdBeca'");
  
  $db->close();
  echo $insertar;
}


if ($tipoGuardar == "mod_beca_usua_x_reinscripcion") {
  $Inscripcion = $_POST["Inscripcion"];
  $IdBeca = $_POST["IdBecaIns"];
  $Importe = $_POST["Importe"];
  $IdAdmin = $_POST["IdAdmin"];
  $desc = ($Importe - $Inscripcion);
  
  $_porx = ($Inscripcion / $Importe);
  $_col = ($_porx * 100);
  $cal1 = (100 - $_col);
  $cal1 = substr($cal1, 0, 5);

  $insertar = $db->query("UPDATE tblp_beca SET tblp_beca.Total = '$Inscripcion', tblp_beca.Descuento = '$desc', tblp_beca.Importe = '$Importe', tblp_beca.CRM = NULL, tblp_beca.Porcentaje = '$cal1', tblp_beca.FecCap = NOW(), tblp_beca.IdUsuaCap = '$IdAdmin' WHERE tblp_beca.IdBeca = '$IdBeca'");
  
  $db->close();
  echo $insertar;
}


if ($tipoGuardar == "mod_beca_usua_x_admin") {
  $IdAdmin = $_POST["IdAdmin"];
  
  $IdEstatus = $_POST["IdEstatus"];
  $Importe = $_POST["Importe"];
  $Monto = $_POST["Monto"];
  $Comentario = $_POST["Comentario"];
  $IdBeca = $_POST["IdBeca"];
  
  $_porx = $Importe / $Monto;
  $_col = ($_porx * 100);
  $cal1 = (100 - $_col);
  $cal1 = substr($cal1, 0, 8);

  $Descuento = ($Monto - $Importe);

  $insertar = $db->query("UPDATE tblp_beca SET tblp_beca.Importe = '$Monto', tblp_beca.Total = '$Importe', tblp_beca.Descuento = '$Descuento',  tblp_beca.Comentario = '$Comentario', tblp_beca.Porcentaje = '$cal1', tblp_beca.FecCap = NOW(), tblp_beca.IdUsuaCap = '$IdAdmin', tblp_beca.IdEstatus = '$IdEstatus' WHERE tblp_beca.IdBeca = '$IdBeca'");
  
  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "configCoordinadorDesc") {
  $IdOferta = $_POST["IdOferta"];
  $IdUsua = $_POST["IdUsua"];
  $insertar = $db->query("UPDATE tblp_coordinador SET tblp_coordinador.FecBaja = NOW(), tblp_coordinador.IdEstatus = '11' WHERE tblp_coordinador.IdCoordinador = '$IdOferta'");
  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "del_docs_doce") {
  $Code = $_POST["Code"];
  $IdUsua = $_POST["IdUsua"];
  $insertar = $db->query("DELETE FROM tblc_docdocentes WHERE tblc_docdocentes.IdUsua = '$IdUsua' AND tblc_docdocentes.Code = '$Code'");
  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "savBimestre") {
  $IdParcialDoc = $_POST["IdParcialDoc"];
  $numero = $_POST["numero"];
  $insertar = $db->query("UPDATE tblp_parcialdocente SET tblp_parcialdocente.Bimestre = '$numero' WHERE tblp_parcialdocente.IdParcialDocente = '$IdParcialDoc'");
  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "savDescuento2") {
  $IdPago = $_POST["IdPago"];
  $descuento = $_POST["Desc"];
  $motivo = $_POST["Motivo"];
  $insertar = $db->query("UPDATE tblp_pagos SET tblp_pagos._motivo = '$motivo', tblp_pagos.Descuento2 = '$descuento', tblp_pagos.FechaDesc = NOW() WHERE tblp_pagos.IdPago = '$IdPago'");
  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "upd_foto_perfil") {
  $IdUsua = $_POST["IdUsua"];
  $Valor = $_POST["Valor"];

  if ($Valor == 1) {

    $sqle3 = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.IdUsua = '$IdUsua' ");
    $db->rows($sqle3);
    $datose31 = $db->recorrer($sqle3);
    $foto = $datose31['Estado'];


    $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.Foto = '$foto', tblc_usuario.Estado = NULL WHERE tblc_usuario.IdUsua = '$IdUsua'");
  } else {
    $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.Estado = NULL WHERE tblc_usuario.IdUsua = '$IdUsua'");
  }


  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "savChangeGrp") {
  $IdUsua = $_POST["IdUsua"];
  $IdAdmin = $_POST["IdAdmin"];
  $IdGrupo = $_POST["IdGrupo"];
  $IdCampus = $_POST["IdCampus"];
  $IdOferta = $_POST["IdOferta"];
  $IdCiclo = $_POST["IdCiclo"];
  $Comentario = $_POST["Comentario"];

  $sql_usx = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.IdUsua =  '$IdUsua'");
  $db->rows($sql_usx);
  $_userx = $db->recorrer($sql_usx);
  $_idCampusAnterior = $_userx["IdCampus"];


  #Verificamos que exista el pago reinscripcion
  $sql_cicl = $db->query("SELECT tblc_conceptosdetalle.IdConceptoDetalle, tblc_costos_ciclo.IdCosto FROM tblc_conceptosdetalle Left Join tblc_costos_ciclo ON tblc_costos_ciclo.IdPlan = tblc_conceptosdetalle.IdConceptoPlan WHERE tblc_conceptosdetalle.IdOferta =  '$IdOferta' AND tblc_conceptosdetalle.IdConcepto =  '3' AND tblc_costos_ciclo.IdCiclo =  '$IdCiclo'");
  $db->rows($sql_cicl);
  $_ciclo = $db->recorrer($sql_cicl);
  $rwIdConceptoCol = $_ciclo["IdConceptoDetalle"];

  if (!$rwIdConceptoCol) {
    echo 3;
    exit();
  }

  #Verificamos que exista el pago colegiatura
  
  $sql_cicl = $db->query("SELECT tblc_conceptosdetalle.IdConceptoDetalle, tblc_conceptosdetalle.IdConceptoPlan, tblc_costos_ciclo.Monto, tblc_costos_ciclo.Fecha, tblc_costos_ciclo.Numero, tblc_costos_ciclo.IdCosto FROM tblc_conceptosdetalle Left Join tblc_costos_ciclo ON tblc_costos_ciclo.IdPlan = tblc_conceptosdetalle.IdConceptoPlan WHERE tblc_conceptosdetalle.IdOferta =  '$IdOferta' AND tblc_conceptosdetalle.IdConcepto =  '2' AND tblc_costos_ciclo.IdCiclo =  '$IdCiclo'");
  $db->rows($sql_cicl);
  $_ciclo = $db->recorrer($sql_cicl);
  $rwIdConceptoCol = $_ciclo["IdConceptoDetalle"];
  $rwMonto = $_ciclo["Monto"];
  $rwNumero = $_ciclo["Numero"];
  $rwFecha = $_ciclo["Fecha"];
  $rwIdConceptoPlan = $_ciclo["IdConceptoPlan"];

  if (!$rwIdConceptoCol) {
    echo 2;
    exit();
  }

  $sql_pag = $db->query("SELECT tblp_pagos.IdPago FROM tblp_pagos WHERE tblp_pagos.IdUsua = '$IdUsua' AND tblp_pagos.IdCiclo = '$IdCiclo'");
  $db->rows($sql_pag);
  $_pag = $db->recorrer($sql_pag);
  
  if(!isset($_pag["IdPago"])){

  #Generamos los pagos de reinscripci贸n
  $sql_reins = $db->query("SELECT tblc_conceptosdetalle.IdConceptoDetalle, tblc_costos_ciclo.IdCosto, tblc_costos_ciclo.Monto, tblc_costos_ciclo.Fecha, tblc_costos_ciclo.Numero, tblc_conceptosdetalle.IdConceptoPlan FROM tblc_conceptosdetalle Left Join tblc_costos_ciclo ON tblc_costos_ciclo.IdPlan = tblc_conceptosdetalle.IdConceptoPlan WHERE tblc_conceptosdetalle.IdOferta =  '$IdOferta' AND tblc_conceptosdetalle.IdConcepto =  '3' AND tblc_costos_ciclo.IdCiclo =  '$IdCiclo'");
  while ($_reins = $db->recorrer($sql_reins)) {
    $sql_user1 = $db->query("SELECT tblc_usuario.IdUsua FROM tblc_usuario WHERE tblc_usuario.IdUsua = '$IdUsua'");
    while ($_user1 = $db->recorrer($sql_user1)) {
      $anio = substr($_reins['Fecha'], 0, 4);
      $insertar = $db->query("INSERT INTO tblp_pagos (IdUsua,Monto,IdEstatus,IdOferta,FecCap,Fecha,IdCiclo,Anio,IdConceptoPlan,IdCampus, Facturar,TipoSolicitud, Capturado, _idEstatus, IdConcepto, TotalPagado, Recargos, Descuento, IdGrupo) VALUES('$IdUsua','" . $_reins['Monto'] . "','1','$IdOferta',NOW(),'" . $_reins['Fecha'] . "','$IdCiclo','$anio','" . $_reins['IdConceptoPlan'] . "','$IdCampus','NO','2','1','32','3',0,0,0,'$IdGrupo')");
      $insertar = $db->query("INSERT INTO tblc_docalumnos (IdUsua, IdTipoDocumento, Estatus, IdCiclo, Doc, IdGrupo) VALUES ('$IdUsua','103','1','$IdCiclo','T','$IdGrupo')");
      $insertar = $db->query("INSERT INTO tblc_docalumnos (IdUsua, IdTipoDocumento, Estatus, IdCiclo, Doc, IdGrupo) VALUES ('$IdUsua','105','1','$IdCiclo','T','$IdGrupo')");
      $insertar = $db->query("INSERT INTO tblp_beca (IdUsua, IdConcepto, Porcentaje, FecCap, IdUsuaCap, IdEstatus, IdConvenio, IdCiclo, Promedio, Importe, Descuento, Total)  VALUES ('$IdUsua','3','0',NOW(),'1','1','1000','$IdCiclo','0','" . $_reins['Monto'] . "',0,'" . $_reins['Monto'] . "')");
      $insertar = $db->query("INSERT INTO tblp_beca (IdUsua, IdConcepto, Porcentaje, FecCap, IdUsuaCap, IdEstatus, IdConvenio, IdCiclo, Promedio, Importe, Descuento, Total)  VALUES ('$IdUsua','2','0',NOW(),'1','1','1000','$IdCiclo','0','$rwMonto',0,'$rwMonto')");
    }
  }


    $fecha_actual = $rwFecha;
    for ($i = 1; $i <= $rwNumero; $i++) {
      $anio = substr($fecha_actual, 0, 4);
  
      $sql_user2 = $db->query("SELECT tblc_usuario.IdUsua FROM tblc_usuario WHERE tblc_usuario.IdUsua = '$IdUsua'");
      while ($_user2 = $db->recorrer($sql_user2)) {
  
        $insertar = $db->query("INSERT INTO tblp_pagos (IdUsua,Monto,IdEstatus,IdOferta,FecCap,Fecha,IdCiclo,Anio,IdConceptoPlan,IdCampus, Facturar,TipoSolicitud, Capturado, _idEstatus, IdConcepto, TotalPagado, Recargos, Descuento, IdGrupo) VALUES('$IdUsua','$rwMonto','1','$IdOferta',NOW(),'$fecha_actual','$IdCiclo','$anio','$rwIdConceptoPlan','$IdCampus','NO','2','1','32','2',0,0,0,'$IdGrupo')");
      }
      $fecha_actual = date("Y-m-d", strtotime($fecha_actual . "+ 1 month"));
    }  
  }

  $sql_gpa = $db->query("SELECT tblc_usuario.SemCua, tblc_usuario.IdGrupo FROM tblc_usuario WHERE tblc_usuario.IdUsua =  '$IdUsua'");
  $db->rows($sql_gpa);
  $_gpx = $db->recorrer($sql_gpa);
  $_idGrupo = $_gpx["IdGrupo"];

  $sql_vAsi = $db->query("SELECT tblp_asignacion.IdAsignacion FROM tblp_asignacion WHERE tblp_asignacion.IdGrupo =  '$_idGrupo' AND tblp_asignacion.IdCiclo =  '$IdCiclo' AND tblp_asignacion.Tipo =  '2' ");
  while ($_vAsig = $db->recorrer($sql_vAsi)) {
    $sqlx = $db->query("DELETE FROM tblp_moduloalumno WHERE tblp_moduloalumno.IdUsua = '$IdUsua' AND tblp_moduloalumno.IdAsignacion = '".$_vAsig['IdAsignacion']."' ");
    $sqly = $db->query("DELETE FROM tblp_asistencia WHERE tblp_asistencia.IdUsua = '$IdUsua' AND tblp_asistencia.IdAsignacion = '".$_vAsig['IdAsignacion']."' ");
    
  }

  $sql_asig = $db->query("SELECT * FROM tblp_asignacion WHERE tblp_asignacion.IdCiclo =  '$IdCiclo' AND tblp_asignacion.IdGrupo = '$IdGrupo' AND tblp_asignacion.Tipo = '2' ");
  while ($_asig = $db->recorrer($sql_asig)) {
    $IdAsignacion = $_asig["IdAsignacion"];
    $IdOferta = $_asig["IdEducativa"];
    $IdModulo = $_asig["IdModulo"];
    $grupo = $_asig["Grupo"];
    $estatus = $_asig["Estatus"];

    $insertar = $db->query("INSERT INTO tblp_moduloalumno (IdEducativa, IdModulo, Grupo, IdUsua, Estatus, FecCap, IdAsignacion, IdGrupo, Activo, IdCiclo) VALUES ('$IdOferta','$IdModulo','$grupo','$IdUsua','$estatus',NOW(),'$IdAsignacion','$IdGrupo', 1, '$IdCiclo')");

    $anio = date("Y");
    $mes = date("m");
    $sqly = $db->query("SELECT tblp_tareas.IdTarea, tblp_tareas.IdAsignacion, tblp_tareas.IdAlumno, tblp_tareas.IdActividadesDocente, tblp_tareas.IdParcialDocente, tblp_actividadesdocente.IdTipoActividad FROM tblp_tareas Left Join tblp_actividadesdocente ON tblp_actividadesdocente.IdActividadesDocente = tblp_tareas.IdActividadesDocente WHERE tblp_tareas.IdAsignacion =  '$IdAsignacion' GROUP BY tblp_tareas.IdActividadesDocente");
    while ($z = $db->recorrer($sqly)) {
      $IdTipoA = $z["IdTipoActividad"];
      $IdActividad = $z["IdActividadesDocente"];
      $IdParcial = $z["IdParcialDocente"];
      $sql1e = $db->query("INSERT INTO tblp_tareas (IdAsignacion, IdAlumno, IdActividadesDocente, IdParcialDocente)  VALUES ('$IdAsignacion','$IdUsua','$IdActividad','$IdParcial')");
      $IdTx = $db->insert_id;
      if ($IdTipoA == 1) {
        $sql2 = $db->query("INSERT INTO tblp_examusuario (IdTarea, IdAsignacion, IdParcialDocente, IdActividadesDocente, IdUsua, IdEstatus) VALUES('$IdTx','$IdAsignacion','$IdParcial','$IdActividad','$IdUsua','12')");
      }
    }
  }
  $Fecha = date("Y-m-d");
  $insertar = $db->query("INSERT INTO tblp_seguimiento (IdUsua, IdCiclo, Fecha, FecCap, Comentario_control, IdTipoSeguimiento, IdUsua_admin)  VALUES ('$IdUsua','$IdCiclo','$Fecha',NOW(),'$Comentario','5','$IdAdmin')");
  $notx = 0;
  if($_idCampusAnterior <> $IdCampus){
    $notx = 1;
  }

  $insertarx = $db->query("INSERT INTO tblp_cambio_grupo (IdUsua, IdCiclo, IdCampusAnterior, IdOfertaAnterior, IdGrupoAnterior, IdCampusNuevo, IdOfertaNuevo, IdGrupoNuevo, Comentario, Notificar, FecCap) VALUES ('$IdUsua', '$IdCiclo','".$_userx["IdCampus"]."','".$_userx["IdOferta"]."','".$_userx["IdGrupo"]."','$IdCampus','$IdOferta','$IdGrupo','$Comentario','$notx',NOW())");  


  $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.IdOferta = '$IdOferta', tblc_usuario.IdCampus = '$IdCampus', tblc_usuario.IdGrupo = '$IdGrupo' WHERE tblc_usuario.IdUsua = '$IdUsua'");

  

  $sql9 = $db->query("SELECT * FROM tblp_grupo WHERE tblp_grupo.IdGrupo = '$IdGrupo' ");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);
  $IdOferta = $datos91["IdOferta"];
  $IdCampus = $datos91["IdCampus"];
  $Dia = $datos91["Dia"];
  if($Dia == 'P'){
    $_diax1 = ",Horario";
    $_diax2 = ",'P'";
    $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario._horario = 'P' WHERE tblc_usuario.IdUsua = '$IdUsua'");
  } else{
    $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario._horario = '' WHERE tblc_usuario.IdUsua = '$IdUsua'");
    $_diax1 = "";
    $_diax2 = "";
  }

  $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.IdOferta = '$IdOferta', tblc_usuario.IdCampus = '$IdCampus', tblc_usuario.IdGrupo = '$IdGrupo' WHERE tblc_usuario.IdUsua = '$IdUsua'");
  
  $sql_del = $db->query("SELECT tblc_alumnos.IdActivo, tblc_alumnos.IdCiclo FROM tblc_alumnos WHERE tblc_alumnos.IdUsua =  '$IdUsua' ORDER BY tblc_alumnos.FecCap DESC LIMIT 1 ");
  $db->rows($sql_del);
  $_del = $db->recorrer($sql_del);
  $IdCiclox = $_del["IdCiclo"];

  $insertar = $db->query("DELETE FROM tblc_alumnos WHERE tblc_alumnos.IdUsua = '$IdUsua' AND tblc_alumnos.IdCiclo = '$IdCiclo'");
  // $insertar = $db->query("DELETE FROM tblc_alumnos WHERE tblc_alumnos.IdUsua = '$IdUsua' AND tblc_alumnos.IdCiclo = '$IdCiclox'");
 
  
  $_grados = $_gpx["SemCua"];
  $insertarx = $db->query("INSERT INTO tblc_alumnos (IdGrupo, IdCiclo, IdUsua, Grado, Tipo, IdEstatus, FecCap, Valor $_diax1) VALUES ('$IdGrupo','$IdCiclo','$IdUsua','$_grados','R',8,NOW(),1 $_diax2)");  

  // $sqlyv = $db->query("SELECT * FROM tblp_beca WHERE tblp_beca.IdUsua = '$IdUsua' AND tblp_beca.IdCiclo = '$IdCiclo'");
  // while($zv = $db->recorrer($sqlyv)){
  //   $IdConcepto = $zv['IdConcepto'];
  //   #Verificamos la beca anterior
  //   $pag_vaca = $db->query("SELECT * FROM tblp_beca WHERE tblp_beca.IdConcepto = '$IdConcepto' AND tblp_beca.IdUsua = '$IdUsua' AND tblp_beca.IdCiclo = '$IdCiclox' ");
  //   $db->rows($pag_vaca);
  //   $pago_vaca = $db->recorrer($pag_vaca);    
  //   if(isset($pago_vaca['IdBeca'])){
  //     $Total = $pago_vaca['Total'];
  //     $IdUsuaCap = $pago_vaca['IdUsuaCap'];
  //     $Importe = $zv['Importe'];
      
  //     $descuento = ($Importe - $Total);
  
  //     $_porx = $Total / $Importe;
  //     $_col = ($_porx * 100);
  //     $cal1 = (100 - $_col);
  //     $cal1 = substr($cal1, 0, 8);
  //     $comentario = $pago_vaca['Comentario'].'- MIGRACION';
  
  //     if($cal1 < 90){
  //       $IdEstatus = 8;
  //     } else {
  //       $IdEstatus = 1;
  //     }
  //     $insertar = $db->query("UPDATE tblp_beca SET tblp_beca.IdEstatus = '$IdEstatus', tblp_beca.IdUsuaCap = '$IdUsuaCap', tblp_beca.Descuento = '$descuento', tblp_beca.Total = '$Total', tblp_beca.Porcentaje = '$cal1',  tblp_beca.Comentario = '$comentario' WHERE tblp_beca.IdBeca = '".$zv['IdBeca']."' ");
      
  //   }
    
  // }





  $db->close();
  echo $insertar;
}


if ($tipoGuardar == "cambiar_plantel_grupo") {
  $IdUsua = $_POST["IdUsua"];
  $IdAdmin = $_POST["IdAdmin"];
  $IdGrupo = $_POST["IdGrupo"];
  $IdCampus = $_POST["IdCampus"];
  $IdOferta = $_POST["IdOferta"];
  $IdCiclo = $_POST["IdCiclo"];
  $Comentario = $_POST["Comentario"];

  $sql_usx = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.IdUsua =  '$IdUsua'");
  $db->rows($sql_usx);
  $_userx = $db->recorrer($sql_usx);
  $_idCampusAnterior = $_userx["IdCampus"];


  #Verificamos que exista el pago reinscripcion
  $sql_cicl = $db->query("SELECT tblc_conceptosdetalle.IdConceptoDetalle, tblc_costos_ciclo.IdCosto FROM tblc_conceptosdetalle Left Join tblc_costos_ciclo ON tblc_costos_ciclo.IdPlan = tblc_conceptosdetalle.IdConceptoPlan WHERE tblc_conceptosdetalle.IdOferta =  '$IdOferta' AND tblc_conceptosdetalle.IdConcepto =  '3' AND tblc_costos_ciclo.IdCiclo =  '$IdCiclo'");
  $db->rows($sql_cicl);
  $_ciclo = $db->recorrer($sql_cicl);
  $rwIdConceptoCol = $_ciclo["IdConceptoDetalle"];

  if (!$rwIdConceptoCol) {
    echo 3;
    exit();
  }

  #Verificamos que exista el pago colegiatura
  
  $sql_cicl = $db->query("SELECT tblc_conceptosdetalle.IdConceptoDetalle, tblc_conceptosdetalle.IdConceptoPlan, tblc_costos_ciclo.Monto, tblc_costos_ciclo.Fecha, tblc_costos_ciclo.Numero, tblc_costos_ciclo.IdCosto FROM tblc_conceptosdetalle Left Join tblc_costos_ciclo ON tblc_costos_ciclo.IdPlan = tblc_conceptosdetalle.IdConceptoPlan WHERE tblc_conceptosdetalle.IdOferta =  '$IdOferta' AND tblc_conceptosdetalle.IdConcepto =  '2' AND tblc_costos_ciclo.IdCiclo =  '$IdCiclo'");
  $db->rows($sql_cicl);
  $_ciclo = $db->recorrer($sql_cicl);
  $rwIdConceptoCol = $_ciclo["IdConceptoDetalle"];
  $rwMonto = $_ciclo["Monto"];
  $rwNumero = $_ciclo["Numero"];
  $rwFecha = $_ciclo["Fecha"];
  $rwIdConceptoPlan = $_ciclo["IdConceptoPlan"];

  if (!$rwIdConceptoCol) {
    echo 2;
    exit();
  }

  $sql_pag = $db->query("SELECT tblp_pagos.IdPago FROM tblp_pagos WHERE tblp_pagos.IdUsua = '$IdUsua' AND tblp_pagos.IdCiclo = '$IdCiclo'");
  $db->rows($sql_pag);
  $_pag = $db->recorrer($sql_pag);
  $_IdPago = $_pag["IdPago"];
  
  if(!$_IdPago){

  #Generamos los pagos de reinscripci贸n
  $sql_reins = $db->query("SELECT tblc_conceptosdetalle.IdConceptoDetalle, tblc_costos_ciclo.IdCosto, tblc_costos_ciclo.Monto, tblc_costos_ciclo.Fecha, tblc_costos_ciclo.Numero, tblc_conceptosdetalle.IdConceptoPlan FROM tblc_conceptosdetalle Left Join tblc_costos_ciclo ON tblc_costos_ciclo.IdPlan = tblc_conceptosdetalle.IdConceptoPlan WHERE tblc_conceptosdetalle.IdOferta =  '$IdOferta' AND tblc_conceptosdetalle.IdConcepto =  '3' AND tblc_costos_ciclo.IdCiclo =  '$IdCiclo'");
  while ($_reins = $db->recorrer($sql_reins)) {
    $sql_user1 = $db->query("SELECT tblc_usuario.IdUsua FROM tblc_usuario WHERE tblc_usuario.IdUsua = '$IdUsua'");
    while ($_user1 = $db->recorrer($sql_user1)) {
      $anio = substr($_reins['Fecha'], 0, 4);
      $insertar = $db->query("INSERT INTO tblp_pagos (IdUsua,Monto,IdEstatus,IdOferta,FecCap,Fecha,IdCiclo,Anio,IdConceptoPlan,IdCampus, Facturar,TipoSolicitud, Capturado, _idEstatus, IdConcepto, TotalPagado, Recargos, Descuento, IdGrupo) VALUES('$IdUsua','" . $_reins['Monto'] . "','1','$IdOferta',NOW(),'" . $_reins['Fecha'] . "','$IdCiclo','$anio','" . $_reins['IdConceptoPlan'] . "','$IdCampus','NO-F14','2','1','32','3',0,0,0,'$IdGrupo')");
      $insertar = $db->query("INSERT INTO tblc_docalumnos (IdUsua, IdTipoDocumento, Estatus, IdCiclo, Doc, IdGrupo) VALUES ('$IdUsua','103','1','$IdCiclo','T','$IdGrupo')");
      $insertar = $db->query("INSERT INTO tblc_docalumnos (IdUsua, IdTipoDocumento, Estatus, IdCiclo, Doc, IdGrupo) VALUES ('$IdUsua','105','1','$IdCiclo','T','$IdGrupo')");
      $insertar = $db->query("INSERT INTO tblp_beca (IdUsua, IdConcepto, Porcentaje, FecCap, IdUsuaCap, IdEstatus, IdConvenio, IdCiclo, Promedio)  VALUES ('$IdUsua','3','0',NOW(),'1','1','1000','$IdCiclo','0')");
      $insertar = $db->query("INSERT INTO tblp_beca (IdUsua, IdConcepto, Porcentaje, FecCap, IdUsuaCap, IdEstatus, IdConvenio, IdCiclo, Promedio)  VALUES ('$IdUsua','2','0',NOW(),'1','1','1000','$IdCiclo','0')");
    }
  }


    $fecha_actual = $rwFecha;
    for ($i = 1; $i <= $rwNumero; $i++) {
      $anio = substr($fecha_actual, 0, 4);
  
      $sql_user2 = $db->query("SELECT tblc_usuario.IdUsua FROM tblc_usuario WHERE tblc_usuario.IdUsua = '$IdUsua'");
      while ($_user2 = $db->recorrer($sql_user2)) {
  
        $insertar = $db->query("INSERT INTO tblp_pagos (IdUsua,Monto,IdEstatus,IdOferta,FecCap,Fecha,IdCiclo,Anio,IdConceptoPlan,IdCampus, Facturar,TipoSolicitud, Capturado, _idEstatus, IdConcepto, TotalPagado, Recargos, Descuento, IdGrupo) VALUES('$IdUsua','$rwMonto','1','$IdOferta',NOW(),'$fecha_actual','$IdCiclo','$anio','$rwIdConceptoPlan','$IdCampus','NO-F15','2','1','32','2',0,0,0,'$IdGrupo')");
      }
      $fecha_actual = date("Y-m-d", strtotime($fecha_actual . "+ 1 month"));
    }  
  }

  $sql_gpa = $db->query("SELECT tblc_usuario.SemCua, tblc_usuario.IdGrupo FROM tblc_usuario WHERE tblc_usuario.IdUsua =  '$IdUsua'");
  $db->rows($sql_gpa);
  $_gpx = $db->recorrer($sql_gpa);
  $_idGrupo = $_gpx["IdGrupo"];

  $sql_vAsi = $db->query("SELECT tblp_asignacion.IdAsignacion FROM tblp_asignacion WHERE tblp_asignacion.IdGrupo =  '$_idGrupo' AND tblp_asignacion.IdCiclo =  '$IdCiclo' AND tblp_asignacion.Tipo =  '2' ");
  while ($_vAsig = $db->recorrer($sql_vAsi)) {
    $sqlx = $db->query("DELETE FROM tblp_moduloalumno WHERE tblp_moduloalumno.IdUsua = '$IdUsua' AND tblp_moduloalumno.IdAsignacion = '".$_vAsig['IdAsignacion']."' ");
    $sqly = $db->query("DELETE FROM tblp_asistencia WHERE tblp_asistencia.IdUsua = '$IdUsua' AND tblp_asistencia.IdAsignacion = '".$_vAsig['IdAsignacion']."' ");
    
  }

  $sql_asig = $db->query("SELECT * FROM tblp_asignacion WHERE tblp_asignacion.IdCiclo =  '$IdCiclo' AND tblp_asignacion.IdGrupo = '$IdGrupo' AND tblp_asignacion.Tipo = '2' ");
  while ($_asig = $db->recorrer($sql_asig)) {
    $IdAsignacion = $_asig["IdAsignacion"];
    $IdOferta = $_asig["IdEducativa"];
    $IdModulo = $_asig["IdModulo"];
    $grupo = $_asig["Grupo"];
    $estatus = $_asig["Estatus"];

    $insertar = $db->query("INSERT INTO tblp_moduloalumno (IdEducativa, IdModulo, Grupo, IdUsua, Estatus, FecCap, IdAsignacion, IdGrupo, Activo, IdCiclo) VALUES ('$IdOferta','$IdModulo','$grupo','$IdUsua','$estatus',NOW(),'$IdAsignacion','$IdGrupo', 1, '$IdCiclo')");

    $anio = date("Y");
    $mes = date("m");
    $sqly = $db->query("SELECT tblp_tareas.IdTarea, tblp_tareas.IdAsignacion, tblp_tareas.IdAlumno, tblp_tareas.IdActividadesDocente, tblp_tareas.IdParcialDocente, tblp_actividadesdocente.IdTipoActividad FROM tblp_tareas Left Join tblp_actividadesdocente ON tblp_actividadesdocente.IdActividadesDocente = tblp_tareas.IdActividadesDocente WHERE tblp_tareas.IdAsignacion =  '$IdAsignacion' GROUP BY tblp_tareas.IdActividadesDocente");
    while ($z = $db->recorrer($sqly)) {
      $IdTipoA = $z["IdTipoActividad"];
      $IdActividad = $z["IdActividadesDocente"];
      $IdParcial = $z["IdParcialDocente"];
      $sql1e = $db->query("INSERT INTO tblp_tareas (IdAsignacion, IdAlumno, IdActividadesDocente, IdParcialDocente)  VALUES ('$IdAsignacion','$IdUsua','$IdActividad','$IdParcial')");
      $IdTx = $db->insert_id;
      if ($IdTipoA == 1) {
        $sql2 = $db->query("INSERT INTO tblp_examusuario (IdTarea, IdAsignacion, IdParcialDocente, IdActividadesDocente, IdUsua, IdEstatus) VALUES('$IdTx','$IdAsignacion','$IdParcial','$IdActividad','$IdUsua','12')");
      }
    }
  }
  $Fecha = date("Y-m-d");
  $insertar = $db->query("INSERT INTO tblp_seguimiento (IdUsua, IdCiclo, Fecha, FecCap, Comentario_control, IdTipoSeguimiento, IdUsua_admin)  VALUES ('$IdUsua','$IdCiclo','$Fecha',NOW(),'$Comentario','5','$IdAdmin')");
  $notx = 0;
  if($_idCampusAnterior <> $IdCampus){
    $notx = 1;
  }

  $insertarx = $db->query("INSERT INTO tblp_cambio_grupo (IdUsua, IdCiclo, IdCampusAnterior, IdOfertaAnterior, IdGrupoAnterior, IdCampusNuevo, IdOfertaNuevo, IdGrupoNuevo, Comentario, Notificar, FecCap) VALUES ('$IdUsua', '$IdCiclo','".$_userx["IdCampus"]."','".$_userx["IdOferta"]."','".$_userx["IdGrupo"]."','$IdCampus','$IdOferta','$IdGrupo','$Comentario','$notx',NOW())");  


  $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.IdOferta = '$IdOferta', tblc_usuario.IdCampus = '$IdCampus', tblc_usuario.IdGrupo = '$IdGrupo' WHERE tblc_usuario.IdUsua = '$IdUsua'");

  

  $sql9 = $db->query("SELECT * FROM tblp_grupo WHERE tblp_grupo.IdGrupo = '$IdGrupo' ");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);
  $IdOferta = $datos91["IdOferta"];
  $IdCampus = $datos91["IdCampus"];
  $Dia = $datos91["Dia"];
  if($Dia == 'P'){
    $_diax1 = ",Horario";
    $_diax2 = ",'P'";
  } else{
    $_diax1 = "";
    $_diax2 = "";
  }

  $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.IdOferta = '$IdOferta', tblc_usuario.IdCampus = '$IdCampus', tblc_usuario.IdGrupo = '$IdGrupo' WHERE tblc_usuario.IdUsua = '$IdUsua'");
  
  $sql_del = $db->query("SELECT tblc_alumnos.IdActivo, tblc_alumnos.IdCiclo FROM tblc_alumnos WHERE tblc_alumnos.IdUsua =  '$IdUsua' ORDER BY tblc_alumnos.FecCap DESC LIMIT 1 ");
  $db->rows($sql_del);
  $_del = $db->recorrer($sql_del);
  $IdCiclox = $_del["IdCiclo"];

  $insertar = $db->query("DELETE FROM tblc_alumnos WHERE tblc_alumnos.IdUsua = '$IdUsua' AND tblc_alumnos.IdCiclo = '$IdCiclox'");
 
  
  $_grados = $_gpx["SemCua"];
  $insertarx = $db->query("INSERT INTO tblc_alumnos (IdGrupo, IdCiclo, IdUsua, Grado, Tipo, IdEstatus, FecCap, Valor $_diax1)  VALUES ('$IdGrupo','$IdCiclo','$IdUsua','$_grados','R',8,NOW(),1 $_diax2)");  


  $db->close();
  echo $insertar;
}


if ($tipoGuardar == "cambiar_plantel_grupo_diplomado") {
  $IdUsua = $_POST["IdUsua"];
  $IdAdmin = $_POST["IdAdmin"];
  $IdGrupo = $_POST["IdGrupo"];
  $IdCampus = $_POST["IdCampus"];
  $IdOferta = $_POST["IdOferta"];
  $IdCiclo = $_POST["IdCiclo"];
  $Comentario = $_POST["Comentario"];

  $sql_usx = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.IdUsua =  '$IdUsua'");
  $db->rows($sql_usx);
  $_userx = $db->recorrer($sql_usx);
  $_idCampusAnterior = $_userx["IdCampus"];



  $sql_gpa = $db->query("SELECT tblc_usuario.SemCua, tblc_usuario.IdGrupo FROM tblc_usuario WHERE tblc_usuario.IdUsua =  '$IdUsua'");
  $db->rows($sql_gpa);
  $_gpx = $db->recorrer($sql_gpa);
  $_idGrupo = $_gpx["IdGrupo"];
 
  $Fecha = date("Y-m-d");
  $insertar = $db->query("INSERT INTO tblp_seguimiento (IdUsua, IdCiclo, Fecha, FecCap, Comentario_control, IdTipoSeguimiento, IdUsua_admin) VALUES ('$IdUsua','$IdCiclo','$Fecha',NOW(),'$Comentario','5','$IdAdmin')");

  $insertarx = $db->query("INSERT INTO tblp_cambio_grupo (IdUsua, IdCiclo, IdCampusAnterior, IdOfertaAnterior, IdGrupoAnterior, IdCampusNuevo, IdOfertaNuevo, IdGrupoNuevo, Comentario, FecCap) VALUES ('$IdUsua', '$IdCiclo','".$_userx["IdCampus"]."','".$_userx["IdOferta"]."','".$_userx["IdGrupo"]."','$IdCampus','$IdOferta','$IdGrupo','$Comentario',NOW())");  

  $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.IdOferta = '$IdOferta', tblc_usuario.IdCampus = '$IdCampus', tblc_usuario.IdGrupo = '$IdGrupo' WHERE tblc_usuario.IdUsua = '$IdUsua'");

  $sql_del = $db->query("SELECT tblc_alumnos.IdActivo, tblc_alumnos.IdCiclo FROM tblc_alumnos WHERE tblc_alumnos.IdUsua =  '$IdUsua' ORDER BY tblc_alumnos.FecCap DESC LIMIT 1 ");
  $db->rows($sql_del);
  $_del = $db->recorrer($sql_del);
  $IdCiclox = $_del["IdCiclo"];

  $insertar = $db->query("DELETE FROM tblc_alumnos WHERE tblc_alumnos.IdUsua = '$IdUsua' AND tblc_alumnos.IdCiclo = '$IdCiclox'");
 
  
  $_grados = $_gpx["SemCua"];
  $insertarx = $db->query("INSERT INTO tblc_alumnos (IdGrupo, IdCiclo, IdUsua, Grado, Tipo, IdEstatus, FecCap, Valor)  VALUES ('$IdGrupo','$IdCiclo','$IdUsua','$_grados','R',8,NOW(),1)");  


  $db->close();
  echo $insertar;
}


if ($tipoGuardar == "savPubAvisoT") {
  $IdAviso = $_POST["IdAviso"];
  $IdCampus = $_POST["IdCampus"];
  $IdOferta = $_POST["IdOferta"];
  $sqly = $db->query("SELECT tblp_grupo.IdGrupo FROM tblp_grupo WHERE tblp_grupo.IdCampus = '$IdCampus' AND tblp_grupo.IdOferta = '$IdOferta' AND ((tblp_grupo.IdEstatus = '8') || (tblp_grupo.IdEstatus = '12'))");
  while ($z = $db->recorrer($sqly)) {
    $IdG = $z["IdGrupo"];
    $sqle3 = $db->query("SELECT tblc_avisodetalle.IdAvisoD FROM tblc_avisodetalle WHERE tblc_avisodetalle.IdGrupo = '$IdG' AND tblc_avisodetalle.IdAviso = '$IdAviso'");
    $db->rows($sqle3);
    $datose31 = $db->recorrer($sqle3);
    $IdAvss = $datose31['IdAvisoD'];
    if (!$IdAvss) {
      $insertar = $db->query("INSERT INTO tblc_avisodetalle (IdAviso, IdGrupo) VALUES ('$IdAviso','$IdG')");
    }
  }


  $db->close();
  echo $insertar;
}





if ($tipoGuardar == "savPubAsesor") {
  $IdAviso = $_POST["IdAviso"];

  $sqly = $db->query("SELECT tblc_campus.IdCampus FROM tblc_campus ");
  while ($z = $db->recorrer($sqly)) {
    $IdC = $z["IdCampus"];
    $sqle3 = $db->query("SELECT tblc_avisoasesor.IdAvisoD FROM tblc_avisoasesor WHERE tblc_avisoasesor.IdCampus = '$IdC' AND tblc_avisoasesor.IdAviso = '$IdAviso'");
    $db->rows($sqle3);
    $datose31 = $db->recorrer($sqle3);
    $IdAvss = $datose31['IdAvisoD'];
    if (!$IdAvss) {
      $insertar = $db->query("INSERT INTO tblc_avisoasesor (IdAviso, IdCampus) VALUES ('$IdAviso','$IdC')");
    }
  }
  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "savPubCampusC") {
  $IdDocs = $_POST["IdDocs"];

  $sqly = $db->query("SELECT tblc_campus.IdCampus FROM tblc_campus ");
  while ($z = $db->recorrer($sqly)) {
    $IdC = $z["IdCampus"];
    $sqle3 = $db->query("SELECT tblp_docscampus.IdDocsC FROM tblp_docscampus WHERE tblp_docscampus.IdCampus = '$IdC' AND tblp_docscampus.IdDocs = '$IdDocs'");
    $db->rows($sqle3);
    $datose31 = $db->recorrer($sqle3);
    $IdAvss = $datose31['IdDocsC'];
    if (!$IdAvss) {
      $insertar = $db->query("INSERT INTO tblp_docscampus (IdDocs, IdCampus) VALUES ('$IdDocs','$IdC')");
    }
  }
  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "savBajaAlum") {
  $IdUsua = $_POST["IdUsua"];
  $IdCiclo = $_POST["Ciclo"];
  $IdEstatus = $_POST["Estatus"];
  $Comentario = $_POST["Comentario"];
  $IdTipo = $_POST["IdTipo"];
  $Fecha = $_POST["Fecha"];
  $IdAdmin = $_POST["IdAdmin"];



  if ($IdTipo == 3) {
    if ($IdEstatus == 8) {
      $IdCiclo = 0;
      $insertar = $db->query("UPDATE tblp_pagos SET tblp_pagos.IdEstatus = '1' WHERE tblp_pagos.IdUsua = '$IdUsua' AND tblp_pagos.IdEstatus = '58' ");
    } else {
      $insertar = $db->query("UPDATE tblp_pagos SET tblp_pagos.IdEstatus = '58' WHERE tblp_pagos.IdUsua = '$IdUsua' AND tblp_pagos.IdEstatus = '1' ");
    }
  }

  $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.fecha_baja = '$Fecha', tblc_usuario.id_ciclo_fin = '$IdCiclo', tblc_usuario.IdEstatus = '$IdEstatus' WHERE tblc_usuario.IdUsua = '$IdUsua'");

  $insertar = $db->query("INSERT INTO tblh_bajausuario (IdUsua, IdEstatus, Comentario, FecCap, IdCiclo) VALUES ('$IdUsua','$IdEstatus','$Comentario',NOW(),'$IdCiclo')");
  $insertar = $db->query("INSERT INTO tblp_seguimiento (IdUsua, IdCiclo, Fecha, FecCap, Comentario_control, IdTipoSeguimiento, IdUsua_admin) VALUES ('$IdUsua','$IdCiclo','$Fecha',NOW(),'$Comentario','1','$IdAdmin')");

  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "sav_baja_doc") {
  $IdUsua = $_POST["IdUsua"];
  $IdCiclo = $_POST["Ciclo"];
  $IdEstatus = $_POST["Estatus"];
  $Comentario = $_POST["Comentario"];
  $IdTipo = $_POST["IdTipo"];
  $Fecha = $_POST["Fecha"];
  $IdAdmin = $_POST["IdAdmin"];

  $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.fecha_baja = '$Fecha', tblc_usuario.IdEstatus = '$IdEstatus' WHERE tblc_usuario.IdUsua = '$IdUsua'");

  $insertar = $db->query("INSERT INTO tblh_bajausuario (IdUsua, IdEstatus, Comentario, FecCap, IdCiclo) VALUES ('$IdUsua','$IdEstatus','$Comentario',NOW(),'$IdCiclo')");
  $insertar = $db->query("INSERT INTO tblp_seguimiento (IdUsua, IdCiclo, Fecha, FecCap, Comentario_control, IdTipoSeguimiento, IdUsua_admin) VALUES ('$IdUsua','$IdCiclo','$Fecha',NOW(),'$Comentario','1','$IdAdmin')");

  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "del_alumno_x") {
  $IdUsua = $_POST["IdUsua"];
  $IdCiclo = $_POST["Ciclo"];
  $IdEstatus = $_POST["Estatus"];
  $IdMotivo = $_POST["Motivo"];
  $Comentario = $_POST["Comentario"];
  $Fecha = $_POST["Fecha"];
  $IdAdmin = $_POST["IdAdmin"];

  if($IdEstatus == 55){
    $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.fecha_grad = '$Fecha', tblc_usuario.id_ciclo_fin = '$IdCiclo', tblc_usuario.IdEstatus = '$IdEstatus' WHERE tblc_usuario.IdUsua = '$IdUsua'");

    $insertar = $db->query("INSERT INTO tblh_bajausuario (IdUsua, IdEstatus, Comentario, FecCap, IdCiclo) VALUES ('$IdUsua','$IdEstatus','$Comentario',NOW(),'$IdCiclo')");
    $insertar = $db->query("INSERT INTO tblp_seguimiento (IdUsua, IdCiclo, Fecha, FecCap, Comentario_control, IdTipoSeguimiento, IdUsua_admin) VALUES ('$IdUsua','$IdCiclo','$Fecha',NOW(),'$Comentario','3','$IdAdmin')");
  } else {
    $insertar = $db->query("UPDATE tblp_pagos SET tblp_pagos.IdEstatus = '58' WHERE tblp_pagos.IdUsua = '$IdUsua' AND tblp_pagos.IdEstatus = '1' ");
    $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.fecha_baja = '$Fecha', tblc_usuario.id_ciclo_fin = '$IdCiclo', tblc_usuario.IdEstatus = '$IdEstatus', tblc_usuario.IdMotivo = '$IdMotivo' WHERE tblc_usuario.IdUsua = '$IdUsua'");

    $insertar = $db->query("INSERT INTO tblh_bajausuario (IdUsua, IdEstatus, Comentario, FecCap, IdCiclo, IdMotivo) VALUES ('$IdUsua','$IdEstatus','$Comentario',NOW(),'$IdCiclo','$IdMotivo')");
    $insertar = $db->query("INSERT INTO tblp_seguimiento (IdUsua, IdCiclo, Fecha, FecCap, Comentario_control, IdTipoSeguimiento, IdUsua_admin) VALUES ('$IdUsua','$IdCiclo','$Fecha',NOW(),'$Comentario','3','$IdAdmin')");
  }

  $insertar = $db->query("UPDATE tblc_alumnos SET tblc_alumnos.IdEstatus = '$IdEstatus' WHERE tblc_alumnos.IdUsua = '$IdUsua' AND tblc_alumnos.IdCiclo = '$IdCiclo' ");
  

  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "recursar_mater_id") {
  $IdUsua = $_POST["IdUsua"];
  $IdGrupo = $_POST["IdGrupo"];
  $IdModulo = $_POST["IdModulo"];
  $IdCiclo = $_POST["IdCiclo"];

  $porciones = explode("_", $IdModulo);
  $IdModulo = $porciones[0];
  $IdAsignacion =  $porciones[1];


  $sql9 = $db->query("SELECT * FROM tblp_asignacion WHERE tblp_asignacion.IdAsignacion =  '$IdAsignacion' LIMIT 1");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);
  $IdOferta = $datos91["IdEducativa"];
  $grupo = $datos91["Grupo"];
  $estatus = $datos91["Estatus"];

  $insertar = $db->query("INSERT INTO tblp_moduloalumno (IdEducativa, IdModulo, Grupo, IdUsua, Estatus, FecCap, IdAsignacion, IdGrupo, Activo) VALUES ('$IdOferta','$IdModulo','$grupo','$IdUsua','$estatus',NOW(),'$IdAsignacion','$IdGrupo', 1)");

  $anio = date("Y");
  $mes = date("m");
  $sqly = $db->query("SELECT tblp_tareas.IdTarea, tblp_tareas.IdAsignacion, tblp_tareas.IdAlumno, tblp_tareas.IdActividadesDocente, tblp_tareas.IdParcialDocente, tblp_actividadesdocente.IdTipoActividad FROM tblp_tareas Left Join tblp_actividadesdocente ON tblp_actividadesdocente.IdActividadesDocente = tblp_tareas.IdActividadesDocente WHERE tblp_tareas.IdAsignacion =  '$IdAsignacion' GROUP BY tblp_tareas.IdActividadesDocente");
  while ($z = $db->recorrer($sqly)) {
    $IdTipoA = $z["IdTipoActividad"];
    $IdActividad = $z["IdActividadesDocente"];
    $IdParcial = $z["IdParcialDocente"];
    $sql1e = $db->query("INSERT INTO tblp_tareas (IdAsignacion, IdAlumno, IdActividadesDocente, IdParcialDocente)  VALUES ('$IdAsignacion','$IdUsua','$IdActividad','$IdParcial')");
    $IdTx = $db->insert_id;
    if ($IdTipoA == 1) {
      $sql2 = $db->query("INSERT INTO tblp_examusuario (IdTarea, IdAsignacion, IdParcialDocente, IdActividadesDocente, IdUsua, IdEstatus) VALUES('$IdTx','$IdAsignacion','$IdParcial','$IdActividad','$IdUsua','12')");
    }
  }
  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "del_asignacion_materia_id") {
  $IdUsua = $_POST["IdUsua"];
  $IdModulo = $_POST["IdModulo"];

  $sql_gx = $db->query("SELECT * FROM tblp_moduloalumno WHERE tblp_moduloalumno.IdModuloAlumno = '$IdModulo'");
  $db->rows($sql_gx);
  $_grox = $db->recorrer($sql_gx);
  $IdAsignacion = $_grox['IdAsignacion'];
  
  $insertar = $db->query("DELETE FROM tblp_asistencia WHERE tblp_asistencia.IdAsignacion = '$IdAsignacion' AND tblp_asistencia.IdUsua = '$IdUsua' ");

  $insertar = $db->query("DELETE FROM tblp_moduloalumno WHERE tblp_moduloalumno.IdModuloAlumno = '$IdModulo' ");


  $db->close();
  echo $insertar;
}


if ($tipoGuardar == "savGrupoAv") {
  $IdAviso = $_POST["IdAviso"];
  $IdGrupo = $_POST["IdGrupo"];
  $Valor = $_POST["Valor"];

  if ($Valor == 1) {
    $insertar = $db->query("INSERT INTO tblc_avisodetalle (IdAviso, IdGrupo) VALUES ('$IdAviso','$IdGrupo')");
  } else {
    $insertar = $db->query("DELETE FROM tblc_avisodetalle WHERE tblc_avisodetalle.IdGrupo = '$IdGrupo' AND tblc_avisodetalle.IdAviso = '$IdAviso'");
  }
  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "savGenPagox") {
  $IdCiclo = $_POST["IdCiclo"];
  $IdCalendario = $_POST["IdCalendario"];
  $IdConceptoPlan = $_POST["IdConceptoPlan"];
  $IdGrupo = $_POST["IdGrupo"];
  $Valor = $_POST["Valor"];

  if ($Valor == 1) {
    $sql_cp = $db->query("SELECT tblc_conceptosplanes.IdConcepto FROM tblc_conceptosplanes WHERE tblc_conceptosplanes.IdConceptoPlanes = '$IdConceptoPlan'");
    $db->rows($sql_gx);
    $_grox = $db->recorrer($sql_gx);
    $_IdConcepto = $_grox['IdConcepto'];

    $sql_gx = $db->query("SELECT tblp_grupo.IdCicloIni FROM tblp_grupo WHERE tblp_grupo.IdGrupo = '$IdGrupo'");
    $db->rows($sql_gx);
    $_grox = $db->recorrer($sql_gx);
    $_idCicloIni = $_grox['IdCicloIni'];

    if (($_IdConcepto == 1) || ($_IdConcepto == 2) || ($_IdConcepto == 3)) {
      $sql_cic = $db->query("SELECT * FROM tblc_costos_ciclo WHERE tblc_costos_ciclo.IdCiclo = '$_idCicloIni' AND tblc_costos_ciclo.IdPlan = '$IdConceptoPlan'");
      $db->rows($sql_cic);
      $_cic = $db->recorrer($sql_cic);
      $monto = $_cic['Monto'];
      $_idCosto = $_cic['IdCosto'];
      if (!$_idCosto) {
        echo 3;
        die();
      }
    }

    $sqle2 = $db->query("SELECT tblc_conceptosplanes.IdConcepto FROM tblc_conceptosplanes WHERE tblc_conceptosplanes.IdConceptoPlanes = '$IdConceptoPlan'");
    $db->rows($sqle2);
    $datose21 = $db->recorrer($sqle2);
    $IdConcepto = $datose21['IdConcepto'];

    $sqle3 = $db->query("SELECT * FROM tblp_calendario WHERE tblp_calendario.IdCalendario = '$IdCalendario'");
    $db->rows($sqle3);
    $datose31 = $db->recorrer($sqle3);
    $monto = $datose31['Monto'];
    $FecDesc = $datose31['FecDescuento'];
    $FecBase = $datose31['FecBase'];
    $FecLim = $datose31['FecLimite'];
    $anioHoy = date("Y");

    $sqlx = $db->query("SELECT tblc_usuario.IdUsua, tblc_usuario.Usuario, tblc_usuario.IdOferta, tblc_usuario.IdCampus FROM tblc_usuario WHERE tblc_usuario.IdGrupo = '$IdGrupo' AND ((tblc_usuario.IdEstatus = '8') || (tblc_usuario.IdEstatus = '50')) ");
    while ($x = $db->recorrer($sqlx)) {
      $insertar = $db->query("INSERT INTO tblp_pagos (IdCalendario,IdUsua,IdConceptoPlan,Monto,IdEstatus,FecCap,FecDesc, FecBase,FecLim, FecLimPago,Facturar,TipoSolicitud, Anio, IdOferta, Referencia, Filtro, IdCiclo,IdCampus,IdGrupo,_idEstatus, IdConcepto,TotalPagado, Recargos, Descuento)VALUES ('$IdCalendario','" . $x["IdUsua"] . "','$IdConceptoPlan','$monto','1',NOW(),'$FecDesc','$FecBase','$FecLim','$FecDesc','NO-F16','1','$anioHoy','" . $x["IdOferta"] . "','" . $x["Usuario"] . "','1','$IdCiclo','" . $x["IdCampus"] . "','$IdGrupo','32','$IdConcepto',0,0,0)");
    }
  } else {
    $insertar = $db->query("DELETE FROM tblp_pagos WHERE tblp_pagos.IdGrupo = '$IdGrupo' AND tblp_pagos.IdCalendario = '$IdCalendario' AND tblp_pagos.IdConceptoPlan = '$IdConceptoPlan'");
  }
  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "pubPagosG") {
  $IdCiclo = $_POST["IdCiclo"];
  $IdCalendario = $_POST["IdCalendario"];
  $IdConceptoPlan = $_POST["IdConceptoPlan"];
  $IdCampus = $_POST["IdCampus"];

  $sqle3 = $db->query("SELECT * FROM tblp_calendario WHERE tblp_calendario.IdCalendario = '$IdCalendario'");
  $db->rows($sqle3);
  $datose31 = $db->recorrer($sqle3);
  $monto = $datose31['Monto'];
  $FecDesc = $datose31['FecDescuento'];
  $FecBase = $datose31['FecBase'];
  $FecLim = $datose31['FecLimite'];
  $anioHoy = date("Y");

  $sqlx = $db->query("SELECT
tblc_conceptosdetalle.IdConceptoDetalle,
tblc_conceptosdetalle.IdConceptoPlan,
tblp_grupo.IdGrupo,
tblc_usuario.IdUsua,
tblc_usuario.Usuario,
tblc_usuario.IdOferta,
tblc_usuario.IdCampus
FROM
tblc_conceptosdetalle
Left Join tblp_grupo ON tblp_grupo.IdOferta = tblc_conceptosdetalle.IdOferta
Left Join tblc_usuario ON tblc_usuario.IdGrupo = tblp_grupo.IdGrupo
WHERE
tblc_conceptosdetalle.IdConceptoPlan =  '$IdConceptoPlan' AND
tblp_grupo.IdCampus =  '$IdCampus' AND ((tblc_usuario.IdEstatus =  '8') || (tblc_usuario.IdEstatus =  '50'))

ORDER BY tblp_grupo.IdCampus ASC, tblp_grupo.CveGrupo ASC");
  // $sqlx = $db->query("SELECT tblc_usuario.IdUsua, tblc_usuario.Usuario, tblc_usuario.IdOferta, tblc_usuario.IdCampus FROM tblc_usuario WHERE tblc_usuario.IdGrupo = '$IdGrupo' AND tblc_usuario.IdEstatus = '8'");
  while ($x = $db->recorrer($sqlx)) {


    $insertar = $db->query("INSERT INTO tblp_pagos (IdCalendario,IdUsua,IdConceptoPlan,Monto,IdEstatus,FecCap,FecDesc, FecBase,FecLim, FecLimPago,Facturar,TipoSolicitud, Anio, IdOferta, Referencia, Filtro, IdCiclo,IdCampus,IdGrupo, _idEstatus, TotalPagado, Recargos, Descuento)VALUES ('$IdCalendario','" . $x["IdUsua"] . "','$IdConceptoPlan','$monto','1',NOW(),'$FecDesc','$FecBase','$FecLim','$FecDesc','NO-F17','1','$anioHoy','" . $x["IdOferta"] . "','" . $x["Usuario"] . "','1','$IdCiclo','" . $x["IdCampus"] . "','" . $x["IdGrupo"] . "','32',0,0,0)");
  }


  $db->close();
  echo $insertar;
}


if ($tipoGuardar == "savGrupoAss") {
  $IdAviso = $_POST["IdAviso"];
  $IdCampus = $_POST["IdCampus"];
  $Valor = $_POST["Valor"];

  if ($Valor == 1) {
    $insertar = $db->query("INSERT INTO tblc_avisoasesor (IdAviso, IdCampus) VALUES ('$IdAviso','$IdCampus')");
  } else {
    $insertar = $db->query("DELETE FROM tblc_avisoasesor WHERE tblc_avisoasesor.IdCampus = '$IdCampus' AND tblc_avisoasesor.IdAviso = '$IdAviso'");
  }
  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "savCampsIdAss") {
  $IdDocs = $_POST["IdDocs"];
  $IdCampus = $_POST["IdCampus"];
  $IdGrupo = $_POST["IdGrupo"];
  $Valor = $_POST["Valor"];

  if ($Valor == 1) {
    $insertar = $db->query("INSERT INTO tblp_docs_grupo (IdDocs, IdCampus, IdGrupo) VALUES ('$IdDocs','$IdCampus','$IdGrupo')");
  } else {
    $insertar = $db->query("DELETE FROM tblp_docs_grupo WHERE tblp_docs_grupo.IdCampus = '$IdCampus' AND tblp_docs_grupo.IdDocs = '$IdDocs' AND tblp_docs_grupo.IdGrupo = '$IdGrupo'");
  }
  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "addSaveCal") {
  $IdCalificacion = $_POST["IdCalificacion"];
  $sql9 = $db->query("SELECT tblp_calificacion.IdUsua, tblp_calificacion.IdOferta, tblp_calificacion.IdModulo, tblp_calificacion.IdAsignacion FROM tblp_calificacion WHERE tblp_calificacion.IdCalificacion = '$IdCalificacion'");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);
  $IdUsua = $datos91["IdUsua"];
  $IdOferta = $datos91["IdOferta"];
  $IdModulo = $datos91["IdModulo"];
  $IdAsignacion = $datos91["IdAsignacion"];

  $Tipo = $_POST["Tipo"];
  $Cal = $_POST["Cal"];
  $insertar = $db->query("UPDATE tblp_calificacion SET tblp_calificacion.$Tipo = '$Cal' WHERE tblp_calificacion.IdCalificacion = '$IdCalificacion'");
  if ($IdAsignacion) {
    $insertar = $db->query("UPDATE tblp_moduloalumno SET tblp_moduloalumno.$Tipo = '$Cal' WHERE tblp_moduloalumno.IdUsua = '$IdUsua' AND tblp_moduloalumno.IdModulo = '$IdModulo' AND tblp_moduloalumno.IdEducativa = '$IdOferta' AND tblp_moduloalumno.IdAsignacion = '$IdAsignacion'");
  }

  $db->close();
  echo $insertar;
}


if ($tipoGuardar == "busmenu_id") {
  $IdMenu = $_POST["IdMenu"];
  $sql9 = $db->query("SELECT tblc_menu.Link FROM tblc_menu WHERE tblc_menu.IdMenu = '$IdMenu'");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);
  $Link = $datos91["Link"];

  $db->close();
  echo $Link;
}

if ($tipoGuardar == "addSaveCicl") {
  $IdGrado = $_POST["IdGrado"];
  $Usuario = $_POST["Usuario"];
  $IdOferta = $_POST["IdOferta"];
  $Ciclo = $_POST["Ciclo"];

  $sqly = $db->query("SELECT tblp_calificacion.IdCalificacion FROM tblp_calificacion Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_calificacion.IdModulo WHERE tblp_calificacion.Usuario = '$Usuario' AND tblp_modulo.Grado = '$IdGrado'");
  while ($z = $db->recorrer($sqly)) {
    $IdCal = $z["IdCalificacion"];
    $insertar = $db->query("UPDATE tblp_calificacion SET tblp_calificacion.IdCiclo = '$Ciclo' WHERE tblp_calificacion.IdCalificacion = '$IdCal'");
  }

  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "configMenu") {
  $IdMenu = $_POST["IdMenu"];
  $IdUsua = $_POST["IdUsua"];
  $Movimiento = $_POST["Movimiento"];
  if ($Movimiento == 1) {
    $insertar = $db->query("INSERT INTO tblc_menuusuario (IdMenu,IdUsua, FecCap) VALUES('$IdMenu','$IdUsua', NOW())");
  } else {
    $insertar = $db->query("DELETE FROM tblc_menuusuario WHERE tblc_menuusuario.IdMenu = '$IdMenu' AND tblc_menuusuario.IdUsua = '$IdUsua'");
  }
  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "actCampusMov") {
  $IdOferta = $_POST["IdOferta"];
  $IdUsua = $_POST["IdUsua"];
  $Movimiento = $_POST["Movimiento"];
  $IdCoo = $_POST["IdCoo"];
  $IdCampus = $_POST["IdCampus"];
  if ($Movimiento == 1) {
    $insertar = $db->query("INSERT INTO tblp_coordinador (IdOferta,IdUsua, FecCap,IdEstatus, IdCampus) VALUES('$IdOferta','$IdUsua', NOW(),'8','$IdCampus')");
  } else {
    $insertar = $db->query("DELETE FROM tblp_coordinador WHERE tblp_coordinador.IdCoordinador = '$IdCoo' AND tblp_coordinador.IdUsua = '$IdUsua'");
  }
  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "add_planAsig") {
  $IdPlan = $_POST["IdPlan"];
  $IdTema = $_POST["IdTema"];
  $IdModulo = $_POST["IdModulo"];
  $insertar = $db->query("INSERT INTO tblp_planasignatura (IdPlan,IdTema,IdModulo, FecCap) VALUES('$IdPlan','$IdTema','$IdModulo',NOW())");

  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "del_comentario") {
  $IdForo = $_POST["IdComentario"];

  $insertar = $db->query("DELETE FROM tblp_foro_detalle WHERE tblp_foro_detalle.IdForo = '$IdForo' ");
  $insertar = $db->query("DELETE FROM tblp_foro WHERE tblp_foro.IdForo = '$IdForo' ");

  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "add_FolioCer") {
  $IdUsua = $_POST["IdUsua"];
  $Folio = $_POST["Folio"];

  $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.Folio = '$Folio' WHERE tblc_usuario.IdUsua = '$IdUsua'");

  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "del_planAsig") {
  $IdAsignatura = $_POST["IdAsignatura"];
  $insertar = $db->query("DELETE FROM tblp_planasignatura WHERE tblp_planasignatura.IdAsignatura = '$IdAsignatura'");

  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "mov_eva") {
  $IdEvaluacion = $_POST["IdEvaluacion"];
  $Tipo = $_POST["Tipo"];
  $IdTipo = $_POST["IdTipo"];
  $insertar = $db->query("UPDATE tblp_evaluacion SET tblp_evaluacion.Valor_$IdTipo = '$Tipo'WHERE tblp_evaluacion.IdEvaluacion = '$IdEvaluacion'");

  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "add_etapa") {
  $IdPlan = $_POST["IdPlan"];
  $IdTema = $_POST["IdTema"];
  $Etapa = $_POST["Etapa"];
  $insertar = $db->query("INSERT INTO tblp_planetapa (IdPlan,IdTema,Etapa, FecCap) VALUES('$IdPlan','$IdTema','$Etapa',NOW())");

  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "del_etapa") {
  $IdEtapa = $_POST["IdEtapa"];
  $insertar = $db->query("DELETE FROM tblp_planetapa WHERE tblp_planetapa.IdEtapa = '$IdEtapa'");

  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "add_grupoPlan") {
  $IdPlan = $_POST["IdPlan"];
  $IdGrupo = $_POST["IdGrupo"];
  $insertar = $db->query("UPDATE tblp_grupo SET tblp_grupo.IdPlan = '$IdPlan' WHERE tblp_grupo.IdGrupo = '$IdGrupo'");

  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "del_grupoPlan") {
  $IdGrupo = $_POST["IdGrupo"];
  $insertar = $db->query("UPDATE tblp_grupo SET tblp_grupo.IdPlan = '' WHERE tblp_grupo.IdGrupo = '$IdGrupo'");

  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "add_cerrarPlan") {
  $IdPlan = $_POST["IdPlan"];
  $IdUsua = $_POST["IdUsua"];
  $insertar = $db->query("UPDATE tblp_plan SET tblp_plan.IdEstatus = '4', tblp_plan.IdUsuaAprob = '$IdUsua', tblp_plan.FecAProb = NOW() WHERE tblp_plan.IdPlan = '$IdPlan'");

  $db->close();
  echo $insertar;
}

// if($tipoGuardar == "loadMaters"){
//   $IdGrado = $_POST["IdGrado"];
//   $IdUsua = $_POST["IdUsua"];
//   $IdOferta = $_POST["IdOferta"];
//   $IdCampus = $_POST["IdCampus"];
//   $Mat = $_POST["Mat"];
//
//   $sqly = $db->query("SELECT tblp_modulo.IdModulo FROM tblp_modulo WHERE tblp_modulo.IdEducativa = '$IdOferta' AND tblp_modulo.Grado = '$IdGrado' AND tblp_modulo.IdCampus = '$IdCampus'");
//   while($z = $db->recorrer($sqly)){
//     $IdMod = $z["IdModulo"];
//
//     $insertar = $db->query("INSERT INTO tblp_calificacion (IdUsua, Usuario, IdOferta, IdModulo) VALUES ('$IdUsua','$Mat','$IdOferta','$IdMod')");
//   }
//   $db->close();
//   echo $insertar;
// }

if ($tipoGuardar == "delFinalM") {
  $IdCalificacion = $_POST["IdCalificacion"];

  $insertar = $db->query("DELETE FROM tblp_calificacion WHERE tblp_calificacion.IdCalificacion = '$IdCalificacion' ");
  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "copiarPlanStudio") {

  $IdCampus = $_POST["IdCampus"];
  $IdOferta = $_POST["IdOferta"];
  $IdNewCampus = $_POST["IdNewCampus"];

  $sql9 = $db->query("SELECT tblp_modulo.IdModulo FROM tblp_modulo WHERE tblp_modulo.IdEducativa = '$IdOferta' AND tblp_modulo.IdCampus = '$IdNewCampus'");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);
  $IdModulo = $datos91["IdModulo"];
  if ($IdModulo) {
    $db->close();
    echo 0;
    exit();
  } else {
    $sqly = $db->query("SELECT * FROM tblp_modulo WHERE tblp_modulo.IdEducativa = '$IdOferta' AND tblp_modulo.IdCampus = '$IdCampus'");
    while ($z = $db->recorrer($sqly)) {
      $codeMod = substr($z["CodeModulo"], 0, 6);
      $grado = $z["Grado"];
      $nomMod = $z["NombreMod"];
      $creditos = $z["Creditos"];
      $code = $z["Code"];
      $oferta = $z["Oferta"];
      $codeModd = $codeMod;

      $insertar = $db->query("INSERT INTO tblp_modulo (CodeModulo, IdEducativa, Grado, NombreMod, Estatus, Creditos, Code, Oferta, IdCampus, FecCap) VALUES ('$codeModd','$IdOferta','$grado','$nomMod','Activo','$creditos','$code','$oferta','$IdNewCampus',NOW())");
      // $IdTx = $db->insert_id;
      // $insertar = $db->query("INSERT INTO tblp_modulodatos (IdEducativa, IdModulo) VALUES ('$IdOferta','$IdTx')");

    }
    $db->close();
    echo 1;
    exit();
  }
}

if ($tipoGuardar == "addMatDispo") {
  $IdModulo = $_POST["IdModulo"];
  $IdUsua = $_POST["IdUsua"];
  $IdOferta = $_POST["IdOferta"];
  $IdCampus = $_POST["IdCampus"];
  $Grado = $_POST["Grado"];
  $Valor = $_POST["Valor"];
  if ($Valor == 1) {
    $insertar = $db->query("INSERT INTO tblk_disponible (IdUsua, IdCampus, IdOferta, IdModulo, FecCap, Grado) VALUES ('$IdUsua','$IdCampus','$IdOferta','$IdModulo',NOW(),'$Grado')");
  } else {
    $insertar = $db->query("DELETE FROM tblk_disponible WHERE tblk_disponible.IdUsua = '$IdUsua' AND tblk_disponible.IdOferta = '$IdOferta' AND tblk_disponible.IdModulo = '$IdModulo'");
  }


  $db->close();
  echo $insertar;
}



if ($tipoGuardar == "actCurso") {
  $IdPlaneacion = $_POST["IdPlaneacion"];
  $IdAsignacion = $_POST["IdAsignacion"];
  $IdUsua = $_POST["IdUsua"];


  $insertar = $db->query("UPDATE tblp_asignacion SET tblp_asignacion.IdEstatus = '8' WHERE tblp_asignacion.IdAsignacion = '$IdAsignacion'");
  $insertar = $db->query("UPDATE tblp_parcialdocente SET tblp_parcialdocente.IdEstatus = '4' WHERE tblp_parcialdocente.IdAsignacion = '$IdAsignacion'");
  $insertar = $db->query("UPDATE tblp_planeacion SET tblp_planeacion.IdEstatus = '4', tblp_planeacion.FecAprobado = NOW(), tblp_planeacion.IdUsuaAprob = '$IdUsua' WHERE tblp_planeacion.IdPlaneacion = '$IdPlaneacion'");


  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "del_actividad_id") {
  $IdActividadesDocente = $_POST["IdActividadesDocente"];
  $IdParcial = $_POST["IdParcial"];
  $IdSemana = $_POST["IdSemana"];


  $insertar = $db->query("DELETE FROM tblp_actividadesdocente WHERE tblp_actividadesdocente.IdActividadesDocente = '$IdActividadesDocente' ");
  $sql9 = $db->query("SELECT Count(tblp_actividadesdocente.IdActividadesDocente) AS Total FROM tblp_actividadesdocente WHERE tblp_actividadesdocente.IdSemanaDocente =  '$IdSemana'");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);
  $Total = $datos91["Total"];

  $insertarx = $db->query("UPDATE tblp_semanadocente SET tblp_semanadocente.NoLeccion = '$Total' WHERE tblp_semanadocente.IdSemanaDocente = '$IdSemana' ");


  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "add_asigReprobado") {
  $Id = $_POST["employee_id"];
  $IdAsigAnt = $_POST["IdAsigAnt"];

  $porciones = explode("-", $Id);
  $IdAsignacion = $porciones[0];
  $IdModulo = $porciones[1];
  $IdUsua = $porciones[2];

  $sql9 = $db->query("SELECT * FROM tblp_moduloalumno WHERE tblp_moduloalumno.IdModulo =  '$IdModulo' AND tblp_moduloalumno.IdAsignacion = '$IdAsignacion'");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);
  $IdOferta = $datos91["IdEducativa"];
  $grupo = $datos91["Grupo"];
  $IdGrupo = $datos91["IdGrupo"];

  $code = md5(rand() * time());
  $Id = $code;



  $insertar = $db->query("INSERT INTO tblp_moduloalumno (IdEducativa, IdModulo, Grupo, IdUsua, Estatus, FecCap, IdAsignacion, IdGrupo) VALUES ('$IdOferta','$IdModulo','$grupo','$IdUsua','Activo',NOW(),'$IdAsignacion','$IdGrupo')");

  $anio = date("Y");
  $mes = date("m");
  $sqly = $db->query("SELECT tblp_tareas.IdTarea, tblp_tareas.IdAsignacion, tblp_tareas.IdAlumno, tblp_tareas.IdActividadesDocente, tblp_tareas.IdParcialDocente, tblp_actividadesdocente.IdTipoActividad FROM tblp_tareas Left Join tblp_actividadesdocente ON tblp_actividadesdocente.IdActividadesDocente = tblp_tareas.IdActividadesDocente WHERE tblp_tareas.IdAsignacion =  '$IdAsignacion' GROUP BY tblp_tareas.IdActividadesDocente");
  while ($z = $db->recorrer($sqly)) {
    $IdTipoA = $z["IdTipoActividad"];
    $IdActividad = $z["IdActividadesDocente"];
    $IdParcial = $z["IdParcialDocente"];

    $sql1e = $db->query("INSERT INTO tblp_tareas (IdAsignacion, IdAlumno, Visto, IdEditor, IdActividadesDocente, IdParcialDocente)  VALUES ('$IdAsignacion','$IdUsua','1','$IdT','$IdActividad','$IdParcial')");
    $IdTx = $db->insert_id;
    if ($IdTipoA == 1) {
      $sql2 = $db->query("INSERT INTO tblp_examusuario (IdTarea, IdAsignacion, IdParcialDocente, IdActividadesDocente, IdUsua, IdEstatus) VALUES('$IdTx','$IdAsignacion','$IdParcial','$IdActividad','$IdUsua','12')");
    } else {
      $sql2 = $db->query("INSERT INTO tblp_editor (IdTarea, IdActividadesDocente, IdParcialDocente, IdUsua, IdPermiso, IdAsignacion, Anio, Mes, IdEstatus) VALUES ('$IdTx','$IdActividad','$IdParcial','$IdUsua','3','$IdAsignacion','$anio','$mes','12')");
    }
  }

  $sql2 = $db->query("UPDATE tblp_moduloalumno SET tblp_moduloalumno.Activo = '1' WHERE tblp_moduloalumno.IdAsignacion ='$IdAsigAnt' AND tblp_moduloalumno.IdUsua = '$IdUsua' AND tblp_moduloalumno.IdModulo = '$IdModulo'");

  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "del_usuario") {
  $IdUsua = $_POST["IdUsua"];
  //Aca escribimos la condicion

  $insertar = $db->query("INSERT INTO tblc_usuario_del SELECT * FROM tblc_usuario WHERE tblc_usuario.IdUsua = '$IdUsua' ");
  $insertar = $db->query("DELETE FROM tblc_usuario WHERE tblc_usuario.IdUsua = '$IdUsua' ");

  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "del_reconoxy") {
  $IdReconocimiento = $_POST["IdReconocimiento"];
  $insertar = $db->query("DELETE FROM tblp_reconocimiento WHERE tblp_reconocimiento.IdReconocimiento = '$IdReconocimiento' ");

  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "del_reconocimiento") {
  $IdReconocimiento = $_POST["IdReconocimiento"];

  $sql9 = $db->query("SELECT tblp_reconocimiento.IdAsignacion FROM tblp_reconocimiento WHERE tblp_reconocimiento.IdReconocimiento =  '$IdReconocimiento' ");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);
  $IdAsignacion = $datos91["IdAsignacion"];
  if ($IdAsignacion) {

    $insertar = $db->query("UPDATE tblp_asignacion SET tblp_asignacion.Reconocimiento = '', tblp_asignacion.Fec_reconocimiento = NULL WHERE tblp_asignacion.IdAsignacion = '$IdAsignacion' ");
  }

  $insertar = $db->query("DELETE FROM tblp_reconocimiento WHERE tblp_reconocimiento.IdReconocimiento = '$IdReconocimiento' ");

  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "chang_estatus") {
  $IdDocs = $_POST["IdDocs"];
  $Valor = $_POST["Valor"];


  $insertar = $db->query("UPDATE tblc_docdocentes SET tblc_docdocentes.Estatus = '$Valor' WHERE tblc_docdocentes.IdDocDocente = '$IdDocs' ");

  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "ocultar_asis") {
  $IdUsua = $_POST["IdUsua"];


  $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.Visto = '0' WHERE tblc_usuario.IdUsua = '$IdUsua' ");

  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "add_comentario") {
  $IdUsuaEnvia = $_POST["IdUsuaEnvia"];
  $IdUsuaRecibe = $_POST["IdUsuaRecibe"];
  $Comentario = $_POST["Comentario"];
  $IdUnico = ($IdUsuaEnvia * $IdUsuaRecibe);

  $insertar = $db->query("INSERT INTO tblp_buzon (IdUsua, Mensaje, FecCap, IdUnico, IdUsuaEnvia, IdUsuaRecibe, Visto) VALUES ('$IdUsuaEnvia','$Comentario',NOW(),'$IdUnico','$IdUsuaEnvia','$IdUsuaRecibe','1') ");
  $insertar2 = $db->query("UPDATE tblp_buzon SET tblp_buzon.FecUltimo = NOW() WHERE tblp_buzon.IdUnico = '$IdUnico' ");
  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "buscar_User") {
  $Code = $_POST["Code"];
  $valor = '0-0';
  $sql9 = $db->query("SELECT tblc_usuario.IdUsua, tblc_usuario.Permisos FROM tblc_usuario WHERE tblc_usuario.Usuario =  '$Code' ");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);
  $IdUsua = $datos91["IdUsua"];
  $Tipo = $datos91["Permisos"];

  if ($IdUsua) {
    if (($Tipo == 2) || ($Tipo == 3)) {
      $valor = $Tipo . '-' . time() . $IdUsua;
    } else {
      $valor = '1-' . time() . $IdUsua;
    }
  } else {
    $valor = '0-0';
  }



  $db->close();
  echo $valor;
}

if ($tipoGuardar == "del_grupoId") {
  $IdGrupo = $_POST["IdGrupo"];

  $insertar = $db->query("DELETE FROM tblp_evaluacion WHERE tblp_evaluacion.IdGrupo = '$IdGrupo' ");
  $insertar = $db->query("DELETE FROM tblc_ciclogrupo WHERE tblc_ciclogrupo.IdGrupo = '$IdGrupo' ");
  $insertar = $db->query("DELETE FROM tblp_grupo WHERE tblp_grupo.IdGrupo = '$IdGrupo' ");

  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "add_NewFwechaEn") {
  $IdTarea = $_POST["IdTarea"];
  $Fecha = $_POST["Fecha"];

  $insertar = $db->query("UPDATE tblp_tareas SET tblp_tareas.FecFinal = '$Fecha' WHERE tblp_tareas.IdTarea = '$IdTarea'");

  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "add_actNewEva") {
  $IdExamenUsua = $_POST["IdExamenUsua"];
  $Valor = $_POST["Valor"];

  $insertar = $db->query("UPDATE tblp_examusuario SET tblp_examusuario.Valor = '$Valor' WHERE tblp_examusuario.IdExamenUsua = '$IdExamenUsua'");

  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "exa_reiniciar") {
  $IdExamenUsua = $_POST["IdExamenUsua"];

  $insertar = $db->query("DELETE FROM tblp_examresultado WHERE tblp_examresultado.IdExamenUsuario = '$IdExamenUsua' ");


  $insertar = $db->query("UPDATE tblp_examusuario SET tblp_examusuario.FecIni = NULL, tblp_examusuario.FecFin = NULL, tblp_examusuario.IdEstatus = '12' WHERE tblp_examusuario.IdExamenUsua = '$IdExamenUsua' ");

  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "exa_nota_ls") {
  $IdAsistencia = $_POST["IdAsistencia"];
  $Nota = $_POST["Nota"];

  $insertar = $db->query("UPDATE tblp_asistencia SET tblp_asistencia.Observaciones = '$Nota', tblp_asistencia.FecObservaciones = NOW() WHERE tblp_asistencia.IdAsistencia = '$IdAsistencia' ");

  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "vre_permiso") {
  $IdAsistencia = $_POST["IdAsistencia"];

  $sql9 = $db->query("SELECT tblp_asistencia.Comentario FROM tblp_asistencia WHERE tblp_asistencia.IdAsistencia = '$IdAsistencia' ");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);
  $Comentario = $datos91["Comentario"];

  $db->close();
  echo $Comentario;
}

if ($tipoGuardar == "obten_grado_id") {
  $IdUsua = $_POST["IdUsua"];
  $IdTitulacion = $_POST["IdTitulacion"];
  $IdPeriodo = $_POST["IdPeriodo"];
  $IdCiclo = $_POST["IdCiclo"];
  $Fecha = $_POST["Fecha"];
  $Monto = $_POST["Monto"];
  $IdCalendario = $_POST["IdCalendario"];

  $sql9 = $db->query("SELECT tblc_usuario.IdUsua, tblc_usuario.IdOferta, tblp_informacion.IdPago, tblp_informacion.IdCalendario FROM tblc_usuario Left Join tblp_informacion ON tblp_informacion.IdUsua = tblc_usuario.IdUsua WHERE tblp_informacion.IdUsua = '$IdUsua' ");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);
  $IdOferta = $datos91["IdOferta"];
  $IdCalendariox = $datos91["IdCalendario"];
  $_idPago = $datos91["IdPago"];

  if ($IdCalendariox) {
    $sql_g_pag = $db->query("SELECT tblp_calendario.FecDescuento, tblc_conceptosdetalle.IdConceptoPlan, tblc_conceptosplanes.IdConcepto, tblc_conceptosplanes.Costo FROM tblp_calendario Left Join tblc_conceptosdetalle ON tblc_conceptosdetalle.IdConceptoPlan = tblp_calendario.IdConceptosPlanes Left Join tblc_conceptosplanes ON tblc_conceptosplanes.IdConceptoPlanes = tblc_conceptosdetalle.IdConceptoPlan WHERE tblp_calendario.IdCalendario =  '$IdCalendario' GROUP BY tblp_calendario.IdCalendario");
    while ($x = $db->recorrer($sql_g_pag)) {
      $IdConcepto = $x['IdConcepto'];
      $Fec = $x['FecDescuento'];
      $IdPlan = $x['IdConceptoPlan'];
      $anio = substr($Fec, 0, 4);

      $insertar = $db->query("UPDATE tblp_pagos SET tblp_pagos.IdCalendario = '$IdCalendario', tblp_pagos.Monto = '$Monto', tblp_pagos.FecDesc = '$Fec', tblp_pagos.FecBase = '$Fec', tblp_pagos.FecLim = '$Fec', tblp_pagos.FecLimPago = '$Fec', tblp_pagos.IdCiclo = '$IdCiclo', tblp_pagos.Anio = '$anio' WHERE tblp_pagos.IdPago = '$_idPago'");

      $insertar = $db->query("UPDATE tblp_informacion SET tblp_informacion.IdCalendario = '$IdCalendario' WHERE tblp_informacion.IdUsua = '$IdUsua' ");
    }
  } else {

    $sql_g_pag = $db->query("SELECT tblp_calendario.FecDescuento, tblc_conceptosdetalle.IdConceptoPlan, tblc_conceptosplanes.IdConcepto, tblc_conceptosplanes.Costo FROM tblp_calendario Left Join tblc_conceptosdetalle ON tblc_conceptosdetalle.IdConceptoPlan = tblp_calendario.IdConceptosPlanes Left Join tblc_conceptosplanes ON tblc_conceptosplanes.IdConceptoPlanes = tblc_conceptosdetalle.IdConceptoPlan WHERE tblp_calendario.IdCalendario =  '$IdCalendario' GROUP BY tblp_calendario.IdCalendario");
    while ($x = $db->recorrer($sql_g_pag)) {
      $IdConcepto = $x['IdConcepto'];
      $Fec = $x['FecDescuento'];
      $IdPlan = $x['IdConceptoPlan'];
      $anio = substr($Fec, 0, 4);
      $insertar = $db->query("INSERT INTO tblp_pagos (IdCalendario,IdUsua,Monto,IdEstatus,IdOferta,FecCap,FecDesc, FecBase,FecLim, FecLimPago,IdCiclo,Anio,IdConceptoPlan,IdCampus, Facturar,TipoSolicitud, Capturado, _idEstatus, IdConcepto, TotalPagado, Recargos, Descuento) VALUES('$IdCalendario','$IdUsua','$Monto','1','$IdOferta',NOW(),'$Fec','$Fec','$Fec','$Fec','$IdCiclo','$anio','$IdPlan','1','NO-F18','2','1','32','$IdConcepto',0,0,0)");
      $idPag = $db->insert_id;
      $insertar = $db->query("UPDATE tblp_informacion SET tblp_informacion.IdCalendario = '$IdCalendario', tblp_informacion.IdPago = '$idPag' WHERE tblp_informacion.IdUsua = '$IdUsua' ");
    }
  }

  $insertar = $db->query("UPDATE tblp_informacion SET tblp_informacion.IdTitulacion = '$IdTitulacion', tblp_informacion.Fecha_titulacion = '$Fecha', tblp_informacion.Monto = '$Monto', tblp_informacion.IdCiclo_egreso = '$IdCiclo', tblp_informacion.IdPeriodo_egreso = '$IdPeriodo', tblp_informacion.Fec_tit_cap = NOW() WHERE tblp_informacion.IdUsua = '$IdUsua' ");



  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "unirseClase") {
  $IdAsignacion = $_POST["Code"];
  $IdUsua = $_POST["IdUsua"];

  $sql9 = $db->query("SELECT tblp_asignacion.IdAsignacion, tblp_asignacion.IdEducativa, tblp_asignacion.IdModulo, tblp_asignacion.IdGrupo FROM tblp_asignacion WHERE tblp_asignacion.IdAsignacion = '$IdAsignacion' ");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);
  $_IdAsignacion = $datos91["IdAsignacion"];

  if ($_IdAsignacion) {

    $sql8 = $db->query("SELECT tblp_moduloalumno.IdModuloAlumno FROM tblp_moduloalumno WHERE tblp_moduloalumno.IdAsignacion = '$IdAsignacion' AND tblp_moduloalumno.IdUsua = '$IdUsua' ");
    $db->rows($sql8);
    $datos81 = $db->recorrer($sql8);
    $_IdModAlum = $datos81["IdModuloAlumno"];

    if ($_IdModAlum) {
      echo 2;
      exit();
    } else {
      $_IdOferta = $datos91["IdEducativa"];
      $_IdModulo = $datos91["IdModulo"];
      $_IdGrupo = $datos91["IdGrupo"];

      $code = md5(rand() * time());
      $insertar = $db->query("INSERT INTO tblp_moduloalumno (IdEducativa, IdModulo, Grupo, IdUsua, Estatus, FecCap, IdAsignacion, IdGrupo) VALUES ('$_IdOferta','$_IdModulo','$_IdGrupo',$IdUsua,'Activo',NOW(),'$IdAsignacion','$_IdGrupo')");

      $sqly = $db->query("SELECT tblp_actividadesdocente.IdActividadesDocente, tblp_actividadesdocente.IdParcialDocente, tblp_actividadesdocente.IdTipoActividad FROM tblp_actividadesdocente WHERE tblp_actividadesdocente.IdAsignacion = '$IdAsignacion' AND tblp_actividadesdocente.IdEstatus <> '12' ");
      while ($z = $db->recorrer($sqly)) {
        $rwIdTipo = $z['IdTipoActividad'];
        $sql1 = $db->query("INSERT INTO tblp_tareas (IdAsignacion, IdAlumno, IdActividadesDocente, IdParcialDocente) VALUES ('$IdAsignacion','$IdUsua','" . $z["IdActividadesDocente"] . "','" . $z["IdParcialDocente"] . "')");
        $IdT = $db->insert_id;
        if ($rwIdTipo == 1) {
          $sql2 = $db->query("INSERT INTO tblp_examusuario (IdTarea, IdAsignacion, IdParcialDocente, IdActividadesDocente, IdUsua, IdEstatus)VALUES('$IdT','$IdAsignacion','" . $z["IdParcialDocente"] . "','" . $z["IdActividadesDocente"] . "','$IdUsua','12')");
        }
      }

      $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.IdGrupo = '$_IdGrupo' WHERE tblc_usuario .IdUsua = '$IdUsua' ");

      echo 3;
      exit();
    }
  } else {
    echo 1;
    exit();
  }


  $db->close();
}

if ($tipoGuardar == "solDocss") {
  $IdPlan = $_POST["IdPlan"];
  $IdUsua = $_POST["IdUsua"];
  $IdCiclo = $_POST["IdCiclo"];

  $sql4 = $db->query("SELECT tblc_usuario.IdGrupo, tblc_usuario.IdOferta, tblc_usuario._horario, tblc_usuario.Usuario, tblc_usuario.IdCampus FROM tblc_usuario WHERE tblc_usuario.IdUsua =  '$IdUsua' ");
  $db->rows($sql4);
  $datos41 = $db->recorrer($sql4);
  $user = $datos41["Usuario"];
  $IdCampus = $datos41["IdCampus"];
  $IdOferta = $datos41["IdOferta"];
  $IdGrupo = $datos41["IdGrupo"];
  $horario = $datos41["_horario"];
  if($horario == 'P'){
    $Grado = 0;
  } else {
    $sql4 = $db->query("SELECT tblc_alumnos.Grado FROM tblc_alumnos WHERE tblc_alumnos.IdUsua =  '$IdUsua' AND tblc_alumnos.IdCiclo =  '$IdCiclo' ");
    $db->rows($sql4);
    $datos41 = $db->recorrer($sql4);
    $Grado = $datos41["Grado"];
  }



  $sql3 = $db->query("SELECT tblc_conceptosplanes.Code, tblc_conceptosplanes.NomPlan, tblc_conceptosplanes.Costo FROM tblc_conceptosplanes WHERE tblc_conceptosplanes.IdConceptoPlanes =  '$IdPlan'");
  $db->rows($sql3);
  $datos31 = $db->recorrer($sql3);
  $Monto = $datos31["Costo"];

  $cadena_de_texto = $datos31["NomPlan"];
  $cadena_buscada   = 'SIMPLE';
  $posicion_coincidencia = strpos($cadena_de_texto, $cadena_buscada);
  
  if ($posicion_coincidencia === false) {
  $Valor = 2;
  } else {
    $Valor = 1;
  }

  $anio = date('Y');
  $mes = date('m');
  $fecha_actual = date("d-m-Y");

  $fch_ = date("Y-m-d", strtotime($fecha_actual . "+ 5 days"));
  $insertar = $db->query("INSERT INTO tblp_pagos (IdCalendario,IdUsua,Monto,IdEstatus,IdOferta,FecCap,Fecha,IdCiclo,IdGrupo,Anio,Referencia,IdConceptoPlan,IdCampus, Facturar,TipoSolicitud, IdConcepto, _idEstatus, TotalPagado, Recargos, Descuento, Capturado) VALUES(0,'$IdUsua','$Monto','1','$IdOferta',NOW(),'$fch_','$IdCiclo','$IdGrupo','$anio','$user','$IdPlan','$IdCampus','NO-F19','1','10','32',0,0,0,5)");
  $id_pago = $db->insert_id;

  require '../assets/qrcode/qrlib.php';
  $dir = '../assets/images/qr/' . $anio . '/' . $mes . '/';

  if (!file_exists($dir))
    mkdir($dir);

  $sql_camp = $db->query("SELECT * FROM tblc_campus WHERE tblc_campus.IdCampus = '$IdCampus'");
  $db->rows($sql_camp);
  $_camp = $db->recorrer($sql_camp);
  $url = $_camp["Link"];

  $caracteres_permitidos = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $longitud = 20;
  $cad =  substr(str_shuffle($caracteres_permitidos), 0, $longitud);

  $insertar = $db->query("INSERT INTO tblp_docs_solicitados (IdPago,IdEstatus,IdCampus,IdUsua,IdOferta,IdCiclo,IdGrupo,FecCap,Anio,Mes, Fecha, IdConcepto, IdConceptoPlan, qrCode, IdVisto, Grado) VALUES ('$id_pago','1','$IdCampus','$IdUsua','$IdOferta','$IdCiclo','$IdGrupo',NOW(),'$anio','$mes',NOW(),'10','$IdPlan','$cad','$Valor','$Grado')");
  $filename = $dir.$cad.'.png';

  $tamanio = 10;
  $level = 'M';
  $frameSize = 3;

  $contenido = $url . 'validar_constancia.php?tokenId=' . $cad;

  QRCode::png($contenido, $filename, $level, $tamanio, $frameSize);
  if ($insertar) {
    echo $insertar;
  } else {
    echo 0;
  }
  $db->close();
}

if ($tipoGuardar == "emit_acra_parc") {
  $IdAsignacion = $_POST["IdAsignacion"];
  $Fecha = $_POST["Fecha"];
  $Parcial = $_POST["Parcial"];

  $insertar = $db->query("UPDATE tblp_asignacion SET tblp_asignacion.Fec_emi_bim$Parcial = '$Fecha' WHERE tblp_asignacion.IdAsignacion = '$IdAsignacion' ");

  if ($insertar) {
    echo $insertar;
  } else {
    echo 0;
  }
  $db->close();
}

if ($tipoGuardar == "edit_acra_parc") {
  $IdAsignacion = $_POST["IdAsignacion"];
  $Parcial = $_POST["Parcial"];

  $insertar = $db->query("UPDATE tblp_asignacion SET tblp_asignacion.Fec_emi_bim$Parcial = NULL WHERE tblp_asignacion.IdAsignacion = '$IdAsignacion' ");

  if ($insertar) {
    echo $insertar;
  } else {
    echo 0;
  }
  $db->close();
}

if ($tipoGuardar == "registro_alumno") {
  $IdCampus = $_POST["IdCampus"];
  $IdOferta = $_POST["IdOferta"];
  $Email = $_POST["Email"];
  $Nombre = $_POST["Nombre"];
  $Paterno = $_POST["Paterno"];
  $Materno = $_POST["Materno"];
  $Telefono = $_POST["Telefono"];
  $Sexo = $_POST["Sexo"];


  $sql9 = $db->query("SELECT tblc_usuario.IdUsua, tblc_usuario.Folio FROM tblc_usuario WHERE tblc_usuario.Correo = '$Email' AND tblc_usuario.Permisos = '3'");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);
  $IdUsua = $datos91["IdUsua"];
  $Folio = $datos91["Folio"];

  if ($IdUsua) {
    echo '3-' . $Folio;
    exit();
  } else {
    $Folio = time();


    $insertar = $db->query("INSERT INTO tblc_usuario (Nombre, APaterno, AMaterno, Cargo, Correo, Permisos, FecCap, Foto, IdCampus, IdOferta, IdEstatus, SemCua, Telefono, Sexo, Folio)  VALUES ('$Nombre','$Paterno','$Materno','Alumno','$Email','3',NOW(),'nuevo.png','$IdCampus','$IdOferta','12','1','$Telefono','$Sexo','$Folio')");
    $IdUsua = $db->insert_id;
    $idCam = $IdCampus;

    $sql_camp = $db->query("SELECT * FROM tblc_campus WHERE tblc_campus.IdCampus = '$idCam'");
    $db->rows($sql_camp);
    $_camp = $db->recorrer($sql_camp);
    $url = $_camp["Link"];
    $nom_plataforma = $_camp["Texto"];
    $url_logo =  $url . 'assets/images/campus/logo_inicio.png';
    $url_registro =  $url . 'assets/images/registro.jpg';

    $destinatario = $Email;
    $asunto = 'Registro en la ' . $nom_plataforma;
    $nombre = htmlentities($Nombre . ' ' . $Paterno . ' ' . $Materno);
    $codx = time() . $Folio;

    $url_continuar =  $url . 'continuar.php?idToks=' . $codx;


    $cuerpo = "<table id='x_bodyTable' style='border-collapse: collapse; height: 100%; margin: 0px; padding: 0px; width: 100%; transform: scale(0.87); transform-origin: left top 0px;' min-scale='0.87' width='100%' height='100%' cellspacing='0' cellpadding='0' border='0' align='center'><tbody><tr><td id='x_bodyCell' style='height:100%; margin:0; padding:0; width:100%' valign='top' align='center'><table style='border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0'><tbody><tr><td id='x_templateHeader' style='background:#F7F7F7 none no-repeat center/cover; background-color:#F7F7F7; background-image:none; background-repeat:no-repeat; background-position:center; background-size:cover; border-top:0; border-bottom:0; padding-top:0px; padding-bottom:0px' valign='top' align='center'><table class='x_templateContainer' style='border-collapse:collapse; max-width:600px!important' width='100%' cellspacing='0' cellpadding='0' border='0' align='center'><tbody><tr><td class='x_headerContainer' style='background:transparent none no-repeat center/cover; background-color:transparent; background-image:none; background-repeat:no-repeat; background-position:center; background-size:cover; border-top:0; border-bottom:0; padding-top:0; padding-bottom:0' valign='top'></td></tr></tbody></table></td></tr><tr><td id='x_templateBody' style='background:#FFFFFF none no-repeat center/cover; background-color:#FFFFFF; background-image:none; background-repeat:no-repeat; background-position:center; background-size:cover; border-top:0; border-bottom:0; padding-top:27px; padding-bottom:63px' valign='top' align='center'><table class='x_templateContainer' style='border-collapse:collapse; max-width:600px!important' width='100%' cellspacing='0' cellpadding='0' border='0' align='center'><tbody><tr><td class='x_bodyContainer' style='background:transparent none no-repeat center/cover; background-color:transparent; background-image:none; background-repeat:no-repeat; background-position:center; background-size:cover; border-top:0; border-bottom:0; padding-top:0; padding-bottom:0' valign='top'><table class='x_mcnTextBlock' style='min-width:100%; border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0'><tbody class='x_mcnTextBlockOuter'><tr><td class='x_mcnTextBlockInner' style='padding-top:9px' valign='top'><table class='x_mcnTextContentContainer' style='max-width:100%; min-width:100%; border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0' align='left'><tbody><tr><td class='x_mcnTextContent' style='padding:0px 18px 9px; color:#828282; word-break:break-word; font-family:Helvetica; font-size:16px; line-height:150%; text-align:left' valign='top'></td></tr></tbody></table></td></tr></tbody></table><table class='x_mcnImageBlock' style='min-width:100%; border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0'><tbody class='x_mcnImageBlockOuter'><tr><td class='x_mcnImageBlockInner' style='padding:9px' valign='top'><table class='x_mcnImageContentContainer' style='min-width:100%; border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0' align='left'><tbody><tr><td class='x_mcnImageContent' style='padding-right:9px; padding-left:9px; padding-top:0; padding-bottom:0; text-align:center' valign='top'><img data-imagetype='External' src='$url_registro' alt='' class='x_mcnImage' style='max-width:2400px; padding-bottom:0; display:inline!important; vertical-align:bottom; border:0; height:auto; outline:none; text-decoration:none' width='564' align='middle'> </td></tr></tbody></table></td></tr></tbody></table><table class='x_mcnTextBlock' style='min-width:100%; border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0'><tbody class='x_mcnTextBlockOuter'><tr><td class='x_mcnTextBlockInner' style='padding-top:9px' valign='top'><table class='x_mcnTextContentContainer' style='max-width:100%; min-width:100%; border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0' align='left'><tbody><tr><td class='x_mcnTextContent' style='padding:0px 18px 9px; font-family:Lato,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif; word-break:break-word; color:#757575; font-size:16px; line-height:150%; text-align:left' valign='top'><p style='text-align: center;'><strong>Inscripci&oacute;n realizada correctamente</strong></p><br><br>Estimado usuario<strong> $nombre, </strong>su registro ha sido exitoso.<br><br>Ahora el siguiente paso es subir los documentos solicitados, el cual en el siguiente enlace podr&aacute; ingresar y continuar con el proceso.<br><br> De la misma manera se le ha generado un Folio de inscripci&oacute;n que se mostrar&aacute; a continuaci&oacute;n:<br><br><b>Folio:</b> $Folio<br><br>  </td></tr></tbody></table></td></tr></tbody></table><table class='x_mcnButtonBlock' style='min-width:100%; border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0'><tbody class='x_mcnButtonBlockOuter'><tr><td class='x_mcnButtonBlockInner' style='padding-top:0; padding-right:18px; padding-bottom:18px; padding-left:18px' valign='top' align='center'><table class='x_mcnButtonContentContainer' style='border-collapse:separate!important; border-radius:28px; background-color:#0047FF' width='100%' cellspacing='0' cellpadding='0' border='0'><tbody><tr><td class='x_mcnButtonContent' style='font-family:Arial; font-size:16px; padding:18px' valign='middle' align='center'><a href='$url_continuar' target='_blank' rel='noopener noreferrer' data-auth='NotApplicable' class='x_mcnButton' title='Ir a la Plataforma' style='font-weight:bold; letter-spacing:normal; line-height:100%; text-align:center; text-decoration:none; color:#FFFFFF; display:block'>Subir mis documentos a la Plataforma</a> </td></tr></tbody></table></td></tr></tbody></table><table class='x_mcnDividerBlock' style='min-width:100%; border-collapse:collapse; table-layout:fixed!important' width='100%' cellspacing='0' cellpadding='0' border='0'><tbody class='x_mcnDividerBlockOuter'><tr><td class='x_mcnDividerBlockInner' style='min-width:100%; padding:18px'><table class='x_mcnDividerContent' style='min-width:100%; border-top:2px solid #EAEAEA; border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0'><tbody><tr><td style=''><span></span></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table> ";


    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
    $headers .= "From: $nom_plataforma <info@mwcomenius.com.mx>\r\n";
    $headers .= "Bcc: pedroo.goca@gmail.com\r\n";

    mail($destinatario, $asunto, $cuerpo, $headers);

    echo '2-' . $Folio;
    exit();
  }
  $db->close();
}



if ($tipoGuardar == "recupCount") {
  $Email = $_POST["valor"];

  $sql9 = $db->query("SELECT tblc_usuario.IdUsua, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Usuario, tblc_usuario.IdCampus, tblc_usuario.Code, tblc_estatus.Estatus FROM tblc_usuario Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_usuario.IdEstatus WHERE tblc_usuario.Correo = '$Email' ");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);
  $IdUsua = $datos91["IdUsua"];
  $Nombre = $datos91["Nombre"];
  $Paterno = $datos91["APaterno"];
  $Materno = $datos91["AMaterno"];
  $usuario = $datos91["Usuario"];
  $pass = $datos91["Code"];
  $estatus = $datos91["Estatus"];
  $idCam = $datos91["IdCampus"];

  if ($IdUsua) {

    $sql_camp = $db->query("SELECT * FROM tblc_campus WHERE tblc_campus.IdCampus = '$idCam'");
    $db->rows($sql_camp);
    $_camp = $db->recorrer($sql_camp);
    $url = $_camp["Link"];
    $nom_plataforma = $_camp["Texto"];
    $url_recuperar =  $url . 'assets/images/recuperar.jpg';

    $destinatario = $Email;
    $asunto = 'Recuperar datos de acceso en la ' . $nom_plataforma;
    $nombre = htmlentities($Nombre . ' ' . $Paterno . ' ' . $Materno);
    $matricula = $usuario;
    $cuerpo = "<table id='x_bodyTable' style='border-collapse: collapse; height: 100%; margin: 0px; padding: 0px; width: 100%; transform: scale(0.87); transform-origin: left top 0px;' min-scale='0.87' width='100%' height='100%' cellspacing='0' cellpadding='0' border='0' align='center'><tbody><tr><td id='x_bodyCell' style='height:100%; margin:0; padding:0; width:100%' valign='top' align='center'><table style='border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0'><tbody><tr><td id='x_templateHeader' style='background:#F7F7F7 none no-repeat center/cover; background-color:#F7F7F7; background-image:none; background-repeat:no-repeat; background-position:center; background-size:cover; border-top:0; border-bottom:0; padding-top:0px; padding-bottom:0px' valign='top' align='center'><table class='x_templateContainer' style='border-collapse:collapse; max-width:600px!important' width='100%' cellspacing='0' cellpadding='0' border='0' align='center'><tbody><tr><td class='x_headerContainer' style='background:transparent none no-repeat center/cover; background-color:transparent; background-image:none; background-repeat:no-repeat; background-position:center; background-size:cover; border-top:0; border-bottom:0; padding-top:0; padding-bottom:0' valign='top'></td></tr></tbody></table></td></tr><tr><td id='x_templateBody' style='background:#FFFFFF none no-repeat center/cover; background-color:#FFFFFF; background-image:none; background-repeat:no-repeat; background-position:center; background-size:cover; border-top:0; border-bottom:0; padding-top:27px; padding-bottom:63px' valign='top' align='center'><table class='x_templateContainer' style='border-collapse:collapse; max-width:600px!important' width='100%' cellspacing='0' cellpadding='0' border='0' align='center'><tbody><tr><td class='x_bodyContainer' style='background:transparent none no-repeat center/cover; background-color:transparent; background-image:none; background-repeat:no-repeat; background-position:center; background-size:cover; border-top:0; border-bottom:0; padding-top:0; padding-bottom:0' valign='top'><table class='x_mcnTextBlock' style='min-width:100%; border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0'><tbody class='x_mcnTextBlockOuter'><tr><td class='x_mcnTextBlockInner' style='padding-top:9px' valign='top'><table class='x_mcnTextContentContainer' style='max-width:100%; min-width:100%; border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0' align='left'><tbody><tr><td class='x_mcnTextContent' style='padding:0px 18px 9px; color:#828282; word-break:break-word; font-family:Helvetica; font-size:16px; line-height:150%; text-align:left' valign='top'></td></tr></tbody></table></td></tr></tbody></table><table class='x_mcnImageBlock' style='min-width:100%; border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0'><tbody class='x_mcnImageBlockOuter'><tr><td class='x_mcnImageBlockInner' style='padding:9px' valign='top'><table class='x_mcnImageContentContainer' style='min-width:100%; border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0' align='left'><tbody><tr><td class='x_mcnImageContent' style='padding-right:9px; padding-left:9px; padding-top:0; padding-bottom:0; text-align:center' valign='top'><img data-imagetype='External' src='$url_recuperar' alt='' class='x_mcnImage' style='max-width:2400px; padding-bottom:0; display:inline!important; vertical-align:bottom; border:0; height:auto; outline:none; text-decoration:none' width='564' align='middle'> </td></tr></tbody></table></td></tr></tbody></table><table class='x_mcnTextBlock' style='min-width:100%; border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0'><tbody class='x_mcnTextBlockOuter'><tr><td class='x_mcnTextBlockInner' style='padding-top:9px' valign='top'><table class='x_mcnTextContentContainer' style='max-width:100%; min-width:100%; border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0' align='left'><tbody><tr><td class='x_mcnTextContent' style='padding:0px 18px 9px; font-family:Lato,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif; word-break:break-word; color:#757575; font-size:16px; line-height:150%; text-align:left' valign='top'><p style='text-align: center;'><strong>Recuperaci&oacute;n exitosa</strong></p><br><br>Estimado usuario<strong> $nombre. </strong><br><br>Tus datos de acceso los los siguientes:<br><br><b>Usuario:</b> $matricula<br><b>Password</b>: $pass <br><b>Estatus</b>: $estatus <br><br><br>  </td></tr></tbody></table></td></tr></tbody></table><table class='x_mcnButtonBlock' style='min-width:100%; border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0'><tbody class='x_mcnButtonBlockOuter'><tr><td class='x_mcnButtonBlockInner' style='padding-top:0; padding-right:18px; padding-bottom:18px; padding-left:18px' valign='top' align='center'><table class='x_mcnButtonContentContainer' style='border-collapse:separate!important; border-radius:28px; background-color:#0047FF' width='100%' cellspacing='0' cellpadding='0' border='0'><tbody><tr><td class='x_mcnButtonContent' style='font-family:Arial; font-size:16px; padding:18px' valign='middle' align='center'><a href='$url' target='_blank' rel='noopener noreferrer' data-auth='NotApplicable' class='x_mcnButton' title='Ir a la $nom_plataforma' style='font-weight:bold; letter-spacing:normal; line-height:100%; text-align:center; text-decoration:none; color:#FFFFFF; display:block'>Ingresar a la $nom_plataforma</a> </td></tr></tbody></table></td></tr></tbody></table><table class='x_mcnDividerBlock' style='min-width:100%; border-collapse:collapse; table-layout:fixed!important' width='100%' cellspacing='0' cellpadding='0' border='0'><tbody class='x_mcnDividerBlockOuter'><tr><td class='x_mcnDividerBlockInner' style='min-width:100%; padding:18px'><table class='x_mcnDividerContent' style='min-width:100%; border-top:2px solid #EAEAEA; border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0'><tbody><tr><td style=''><span></span></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table> ";


    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
    $headers .= "From: $nom_plataforma <info@mwcomenius.com.mx>\r\n";
    $headers .= "Bcc: pedroo.goca@gmail.com\r\n";

    mail($destinatario, $asunto, $cuerpo, $headers);



    echo 3;
    exit();
  } else {
    echo 1;
    exit();
  }
}

if ($tipoGuardar == "close_class") {
  $IdAsignacion = $_POST["idAsignacion"];

  $insertar = $db->query("UPDATE tblp_asignacion SET tblp_asignacion.Estatus = 'Finalizado', tblp_asignacion.IdEstatus = '26' WHERE tblp_asignacion.IdAsignacion = '$IdAsignacion' ");
  $insertar = $db->query("UPDATE tblp_moduloalumno SET tblp_moduloalumno.Estatus = 'Finalizado' WHERE tblp_moduloalumno.IdAsignacion = '$IdAsignacion' ");

  echo 1;
  exit();
}

if ($tipoGuardar == "open_class") {
  $IdAsignacion = $_POST["idAsignacion"];

  $insertar = $db->query("UPDATE tblp_asignacion SET tblp_asignacion.Estatus = 'Activo', tblp_asignacion.IdEstatus = '8' WHERE tblp_asignacion.IdAsignacion = '$IdAsignacion' ");
  $insertar = $db->query("UPDATE tblp_moduloalumno SET tblp_moduloalumno.Estatus = 'Activo' WHERE tblp_moduloalumno.IdAsignacion = '$IdAsignacion' ");

  echo 1;
  exit();
}

if ($tipoGuardar == "del_cata_clas") {
  $IdAsignacion = $_POST["IdAsignacion"];

  $sql1 = $db->query("SELECT tblp_asignacion.Plantel, tblp_asignacion.Anio FROM tblp_asignacion WHERE tblp_asignacion.IdAsignacion = '$IdAsignacion'");
  $db->rows($sql1);
  $datos11 = $db->recorrer($sql1);
  $Plantel = $datos11["Plantel"];
  $Anio = $datos11["Anio"];


  if ($Plantel) {
    $linkD = "../assets/docs/adjunto/$Anio/$Plantel";
    unlink($linkD);
  }


  $insertar = $db->query("UPDATE tblp_asignacion SET tblp_asignacion.Plantel = NULL WHERE tblp_asignacion.IdAsignacion = '$IdAsignacion' ");


  echo 1;
  exit();
}

if ($tipoGuardar == "validar_code") {
  $IdAsignacion = $_POST["Code"];


  $sql9 = $db->query("SELECT tblp_asignacion.IdAsignacion FROM tblp_asignacion WHERE tblp_asignacion.IdAsignacion = '$IdAsignacion' ");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);
  $_IdAsignacion = $datos91["IdAsignacion"];

  if ($_IdAsignacion) {
    echo 1;
    exit();
  } else {
    echo 2;
    exit();
  }

  $db->close();
}

if ($tipoGuardar == "validar_email") {
  $Email = $_POST["Email"];


  $sql9 = $db->query("SELECT tblc_usuario.IdUsua FROM tblc_usuario WHERE tblc_usuario.Correo = '$Email' AND tblc_usuario.Permisos = '3' AND tblc_usuario.IdEstatus = '8' ");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);
  $IdUsua = $datos91["IdUsua"];

  if ($IdUsua) {
    echo 1;
    exit();
  } else {
    echo 2;
    exit();
  }

  $db->close();
}

if ($tipoGuardar == "registroUserDoc") {
  $IdOferta = $_POST["Tipo"];
  $Email = $_POST["Email"];
  $Nombre = $_POST["Nombre"];
  $Paterno = $_POST["Paterno"];
  $Materno = $_POST["Materno"];
  $Telefono = $_POST["Telefono"];
  $Sexo = $_POST["Sexo"];

  $sql9 = $db->query("SELECT tblc_usuario.IdUsua FROM tblc_usuario WHERE tblc_usuario.Correo = '$Email' AND tblc_usuario.Permisos = '3' AND tblc_usuario.IdEstatus = '8' ");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);
  $_IdUsua = $datos91["IdUsua"];

  $sql8 = $db->query("SELECT tblp_educativa.IdGrado FROM tblp_educativa WHERE tblp_educativa.IdEducativa = '$Tipo' ");
  $db->rows($sql8);
  $datos81 = $db->recorrer($sql8);
  $_IdGrado = $datos81["IdGrado"];

  if ($_IdUsua) {
    echo 1;
    exit();
  } else {

    $caracteres_permitidos = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $longitud = 5;
    $pass =  substr(str_shuffle($caracteres_permitidos), 0, $longitud);

    $code = $pass;

    $pass_php = Password::hash($pass);
    $_acceso = time();
    $insertar = $db->query("INSERT INTO tblc_usuario (Nombre, APaterno, AMaterno, Cargo, Correo, Usuario, Pass_php, Permisos, FecCap, Foto, Code, Folio, IdEstatus, Celular, Sexo, Visto, IdOferta, IdCampus) VALUES ('$Nombre','$Paterno','$Materno','Alumno','$Email','$Email','$pass_php','3',NOW(),'nuevo.png','$code','$_acceso','12','$Telefono','$Sexo','1','$IdOferta','1')");
    $IdUsua = $db->insert_id;

    $sqly = $db->query("SELECT * FROM tblh_tipodocumento WHERE tblh_tipodocumento.Grado = '$_IdGrado' ");
    while ($z = $db->recorrer($sqly)) {
      $sql2 = $db->query("INSERT INTO tblp_documentos (IdUsua, IdTipoDocumento, FecCap) VALUES ('$IdUsua','" . $z["IdTipoDoc"] . "',NOW())");
    }


    $nombre = htmlentities($Nombre . ' ' . $Paterno . ' ' . $Materno);
    $pass = $code;

    $destinatario = $Email;
    $asunto = 'Te damos la bienvenida a la Plataforma ENAPROC';
    $sub_titulo = "Continue con su proceso de registro";
    $nom_plataforma = "Plataforma ENAPROC";
    $link = "https://enaproc.mwcomenius.com.mx/continuar.php";

    $cuerpo = "<table style='border-collapse:collapse;height:100%;margin:0;padding:0;width:100%;background-color:#f2f4fc' width='100%' height='100%' cellspacing='0' cellpadding='0' border='0' align='center'>
          <tbody><tr>
              <td style='height:100%;margin:0;padding:10px;width:100%;border-top:0' valign='top' align='center'>
                  <table style='border-collapse:collapse;border:0;max-width:600px!important' width='100%' cellspacing='0' cellpadding='0' border='0'>
                      <tbody><tr>
                          <td style='background:#000f33; color:#fff; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif; padding:10px' valign='top'>$sub_titulo</td>
                      </tr>
                      <tr>
                          <td style='background:#ffffff;' valign='top'>
                          <table style='min-width:100%;border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0'>
                              <tbody>
                                  <tr>
                                      <td style='padding-top:9px' valign='top'>
                                          <table style='max-width:100%;min-width:100%;border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0' align='left'>
                                              <tbody>
                                                <tr>
                                                    <td style='padding-top:0;padding-right:18px;padding-bottom:9px;padding-left:18px;word-break:break-word;color:black; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif; font-size:12px;line-height:150%;text-align:left;' valign='top'>
                                                        <div>
                                                          <b>NOMBRE: </b> $nombre <br>
                                                          <b>FOLIO DE ACCESO: </b> $_acceso <br>

                                                          </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style='font-size:12px; line-height:17px;font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif; font-weight:600; ' height='80' align='center'>
                                                      <a href='$link' style='color:inherit;text-decoration:none;text-align:center;display:inline-block; background: #525fff; border-radius: 25px; padding: 8px; color: white;' target='_blank'> &nbsp;&nbsp;&nbsp;&nbsp; Ir a la Plataforma &nbsp;&nbsp;&nbsp;&nbsp; </a>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td style='background: #d5d3d0; padding-top:5px; padding-right:18px; padding-bottom:5px;padding-left:18px;word-break:break-word;color:black; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif; font-size:12px;line-height:150%;text-align:center' valign='top'>
                                                        <div>Todos los derechos reservados<br><b>$nom_plataforma</b></div>
                                                    </td>
                                                </tr>

                                          </tbody></table>
                                      </td>
                                  </tr>
                              </tbody>
                          </table></td>
                      </tr>
                  </tbody></table>
              </td>
          </tr>
      </tbody></table>";

    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
    $headers .= "From: MWComenius Docente <info@mwcomenius.com.mx>\r\n";
    $headers .= "Bcc: pedroo.goca@gmail.com\r\n";

    mail($destinatario, $asunto, $cuerpo, $headers);

    echo 2;
    exit();
  }

  $db->close();
}

if ($tipoGuardar == "validar_email_docs") {
  $Email = $_POST["Email"];


  $sql9 = $db->query("SELECT tblc_usuario.IdUsua FROM tblc_usuario WHERE tblc_usuario.Correo = '$Email' AND tblc_usuario.Permisos = '3' AND tblc_usuario.IdEstatus = '8' ");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);
  $IdUsua = $datos91["IdUsua"];

  if ($IdUsua) {
    echo 1;
    exit();
  } else {
    echo 2;
    exit();
  }

  $db->close();
}

if ($tipoGuardar == "aplFondo") {
  $IdAsignacion = $_POST["IdAsignacion"];
  $Fondo = $_POST["Fondo"];

  $insertar = $db->query("UPDATE tblp_asignacion SET tblp_asignacion.Fondo = '$Fondo' WHERE tblp_asignacion.IdAsignacion = '$IdAsignacion' ");

  $db->close();
  echo $insertar;
}



if ($tipoGuardar == "add_actNewTods") {
  $IdActividadDoc = $_POST["IdActividadDoc"];

  $insertar = $db->query("UPDATE tblp_examusuario SET tblp_examusuario.Valor = '1' WHERE tblp_examusuario.IdActividadesDocente = '$IdActividadDoc'");
  $insertar = $db->query("UPDATE tblp_actividadesdocente SET tblp_actividadesdocente.Mostrar = 'SI' WHERE tblp_actividadesdocente.IdActividadesDocente = '$IdActividadDoc'");

  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "add_modEvaTods") {
  $IdActividadDoc = $_POST["IdActividadDoc"];

  $insertar = $db->query("UPDATE tblp_examusuario SET tblp_examusuario.Valor = '0' WHERE tblp_examusuario.IdActividadesDocente = '$IdActividadDoc'");
  $insertar = $db->query("UPDATE tblp_actividadesdocente SET tblp_actividadesdocente.Mostrar = '' WHERE tblp_actividadesdocente.IdActividadesDocente = '$IdActividadDoc'");

  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "del_gasto_id") {
  $IdGasto = $_POST["IdGasto"];

  $insertar = $db->query("DELETE FROM tblp_gastos_detalle WHERE tblp_gastos_detalle.IdGasto = '$IdGasto' ");
  $insertar = $db->query("DELETE FROM tblp_gastos WHERE tblp_gastos.IdGasto = '$IdGasto' ");

  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "upd_reinEcax") {
  $IdActividadDoc = $_POST["IdActividadDoc"];
  $IdAsignacion = $_POST["IdAsignacion"];
  $IdParcial = $_POST["IdParcial"];

  // $insertar = $db->query("DELETE FROM tblp_tareas WHERE tblp_tareas.IdActividadesDocente = '$IdActividadDoc' ");
  $insertar = $db->query("DELETE FROM tblp_examusuario WHERE tblp_examusuario.IdActividadesDocente = '$IdActividadDoc' ");
  $insertar = $db->query("DELETE FROM tblp_examresultado WHERE tblp_examresultado.IdActividadesDocente = '$IdActividadDoc' ");

  $sqly = $db->query("SELECT tblp_moduloalumno.IdUsua FROM tblp_moduloalumno WHERE tblp_moduloalumno.IdAsignacion = '$IdAsignacion'");
  while ($z = $db->recorrer($sqly)) {
    $sql1 = $db->query("INSERT INTO tblp_tareas (IdAsignacion, IdAlumno, IdActividadesDocente, IdParcialDocente) VALUES ('$IdAsignacion','" . $z["IdUsua"] . "','$IdActividadDoc','$IdParcial')");
    $IdT = $db->insert_id;
    $sql2 = $db->query("INSERT INTO tblp_examusuario (IdTarea, IdAsignacion, IdParcialDocente, IdActividadesDocente, IdUsua, IdEstatus)VALUES('$IdT','$IdAsignacion','$IdParcial','$IdActividadDoc','" . $z["IdUsua"] . "','12')");
  }

  $db->close();
  echo 1;
}

if ($tipoGuardar == "del_archivo") {
  $IdArchivo = $_POST["IdArchivo"];
  // echo "SELECT * FROM tblp_archivo WHERE tblp_archivo.IdArchivo = '$IdArchivo'";
  $sql1 = $db->query("SELECT * FROM tblp_archivo WHERE tblp_archivo.IdArchivo = '$IdArchivo'");
  $db->rows($sql1);
  $datos11 = $db->recorrer($sql1);
  $link = $datos11["Link"];


  if ($link) {
    $linkD = "../assets/docs/files/asignatura/$link";
    unlink($linkD);
    // unlink('../assets/docs/files/asignatura/964f01ea0f6b2464d5d53bd4cbaa5d27.pdf');
  }


  $insertar = $db->query("DELETE FROM tblp_archivo WHERE tblp_archivo.IdArchivo = '$IdArchivo' ");

  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "del_archivoDocsXX") {
  $IdLibro = $_POST["IdLibro"];


  $sql1 = $db->query("SELECT * FROM tblp_libro WHERE tblp_libro.IdLibro = '$IdLibro'");
  $db->rows($sql1);
  $datos11 = $db->recorrer($sql1);
  $oferta = $datos11["Oferta"];
  $link = $datos11["Link"];
  if ($link) {
    $linkD = "../assets/docs/libro/$oferta/$link";
    unlink($linkD);
  }

  $insertar = $db->query("DELETE FROM tblp_libro WHERE tblp_libro.IdLibro = '$IdLibro' ");
  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "del_archivoDocs") {
  $IdArchivo = $_POST["IdArchivo"];
  $sql1 = $db->query("SELECT * FROM tblp_docs WHERE tblp_docs.IdDocs = '$IdArchivo'");
  $db->rows($sql1);
  $datos11 = $db->recorrer($sql1);
  $anio = $datos11["Anio"];
  $mes = $datos11["Mes"];
  $link = $datos11["Archivo"];
  if ($link) {
    $linkD = "../assets/docs/files/$anio/$mes/$link";
    unlink($linkD);
  }

  $insertar = $db->query("DELETE FROM tblp_docs WHERE tblp_docs.IdDocs = '$IdArchivo' ");
  $insertar = $db->query("DELETE FROM tblp_docscampus WHERE tblp_docscampus.IdDocs = '$IdArchivo' ");
  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "del_archivoAviso") {
  $IdAviso = $_POST["IdAviso"];

  $sql1 = $db->query("SELECT * FROM tblc_aviso WHERE tblc_aviso.IdAviso = '$IdAviso'");
  $db->rows($sql1);
  $datos11 = $db->recorrer($sql1);
  $link = $datos11["Archivo"];
  if ($link) {
    $linkD = "../assets/images/avisos/$link";
    unlink($linkD);
  }

  $insertar = $db->query("DELETE FROM tblc_aviso WHERE tblc_aviso.IdAviso = '$IdAviso' ");
  $insertar = $db->query("DELETE FROM tblc_avisodetalle WHERE tblc_avisodetalle.IdAviso = '$IdAviso' ");
  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "search_file") {
  $IdActividadDoc = $_POST["IdActividadDoc"];
  $IdAsignacion = $_POST["IdAsignacion"];
  $IdUsua = $_POST["IdUsua"];
  $NoLink = $_POST["NoLink"];

  $sql3 = $db->query("SELECT tblp_asignacion.Anio, tblp_asignacion.Mes FROM tblp_asignacion WHERE tblp_asignacion.IdAsignacion ='$IdAsignacion' AND tblp_asignacion.Tipo = '2'");
  $db->rows($sql3);
  $datos31 = $db->recorrer($sql3);
  $AAnio = $datos31["Anio"];
  $MMes = $datos31["Mes"];



  $sql2 = $db->query("SELECT * FROM tblp_tareas WHERE tblp_tareas.IdAsignacion ='$IdAsignacion' AND tblp_tareas.IdActividadesDocente = '$IdActividadDoc' AND tblp_tareas.IdAlumno= '$IdUsua'");
  $db->rows($sql2);
  $datos21 = $db->recorrer($sql2);
  if ($NoLink == 1) {
    $link = $datos21["Link"];
  } elseif ($NoLink == 2) {
    $link = $datos21["Link2"];
  } elseif ($NoLink == 3) {
    $link = $datos21["Link3"];
  }

  if ($link) {
    $nombre_fichero = "../assets/trabajos/$AAnio/$MMes/$IdAsignacion/tareas/$link";
    if (file_exists($nombre_fichero)) {
      echo 1;
    } else {
      echo 0;
    }
  } else {
    echo 0;
  }
}

if ($tipoGuardar == "cargarCali") {
  $IdParcialDoc = $_POST["IdParcialDoc"];
  $IdAsignacion = $_POST["IdAsignacion"];
  $NoParcial = $_POST["NoParcial"];

  $sql_asig = $db->query("SELECT tblp_asignacion.IdCiclo, tblp_asignacion.IdEducativa FROM tblp_asignacion WHERE tblp_asignacion.IdAsignacion = '$IdAsignacion' LIMIT 1");
  $db->rows($sql_asig);
  $_asig = $db->recorrer($sql_asig);
  $IdCiclo = $_asig["IdCiclo"];
  $IdEducativa = $_asig["IdEducativa"];

  $sql_prome = $db->query("SELECT tblp_educativa.IdEducativa, tblc_grado.Promedio FROM tblp_educativa LEFT JOIN tblc_grado ON tblp_educativa.IdGrado = tblc_grado.IdGrado WHERE tblp_educativa.IdEducativa = '$IdEducativa' ");
  $db->rows($sql_prome);
  $_promedio = $db->recorrer($sql_prome);
  $PromedioMinimo = $_promedio["Promedio"];

  if (($IdEducativa == 33) || ($IdEducativa == 47)) {
    $noParcialEspecial = 3;
  } else {
    $noParcialEspecial = 1;
  }


  $sql = $db->query("SELECT * FROM tblp_moduloalumno WHERE tblp_moduloalumno.IdAsignacion = '$IdAsignacion'");
  while ($x = $db->recorrer($sql)) {
    $IdAlumno = $x["IdUsua"];
    $IdModAlum = $x["IdModuloAlumno"];
    $IdEducativa = $x["IdEducativa"];
    $IdModulo = $x["IdModulo"];
    $IdUsua = $x["IdUsua"];

    $sql9 = $db->query("SELECT tblc_usuario.Grado, tblc_usuario.Usuario, tblc_usuario.IdGrupo FROM tblc_usuario WHERE tblc_usuario.IdUsua = '$IdUsua'");
    $db->rows($sql9);
    $datos91 = $db->recorrer($sql9);
    $user = $datos91["Usuario"];
    $grp_id = $datos91["IdGrupo"];
    $_grado = $datos91["Grado"];

    $sql2 = $db->query("SELECT Sum(tblp_tareas.Calificacion) AS Parcial FROM tblp_tareas WHERE tblp_tareas.IdAsignacion = '$IdAsignacion' AND tblp_tareas.IdParcialDocente = '$IdParcialDoc' AND tblp_tareas.IdAlumno = '$IdAlumno'");
    while ($y = $db->recorrer($sql2)) {
      $cali = $y["Parcial"];
      if ($cali) {
        $cali;
      } else {
        $cali = 0;
      }

      $sql5 = $db->query("SELECT tblp_calificacion.IdCalificacion FROM tblp_calificacion WHERE tblp_calificacion.IdAsignacion = '$IdAsignacion' AND tblp_calificacion.IdUsua = '$IdUsua' ");
      $db->rows($sql5);
      $datos51 = $db->recorrer($sql5);
      $IdCal = $datos51["IdCalificacion"];

      if (!$IdCal) { 
        $insertar = $db->query("INSERT INTO tblp_calificacion (IdUsua, Usuario, IdOferta, IdModulo, IdAsignacion, FecCap, IdCiclo, IdGrupo, IdTipo, IdEstatus) VALUES ('$IdUsua','$user','$IdEducativa','$IdModulo','$IdAsignacion',NOW(),'$IdCiclo','$grp_id','2','8')");
        $IdCal = $db->insert_id;
      }
      if ($cali == 0) {
        $prom = 0;
      } else {
        $prom = ($cali / 10);
      }

      $prom_entero = round($prom);

      if($noParcialEspecial == 1){
        if($prom < $PromedioMinimo){
          $prom_entero = 5;
        }
        $insertar = $db->query("UPDATE tblp_calificacion SET tblp_calificacion.P$NoParcial = '$prom_entero' WHERE tblp_calificacion.IdCalificacion = '$IdCal'");
        $insertar = $db->query("UPDATE tblp_moduloalumno SET tblp_moduloalumno.ParcialF$NoParcial = '$prom_entero', tblp_moduloalumno.Parcial$NoParcial = '$prom' WHERE tblp_moduloalumno.IdModuloAlumno = '$IdModAlum'");
      } else {
        $insertar = $db->query("UPDATE tblp_calificacion SET tblp_calificacion.P$NoParcial = '$prom_entero' WHERE tblp_calificacion.IdCalificacion = '$IdCal'");
        $insertar = $db->query("UPDATE tblp_moduloalumno SET tblp_moduloalumno.ParcialF$NoParcial = '$prom_entero', tblp_moduloalumno.Parcial$NoParcial = '$prom' WHERE tblp_moduloalumno.IdModuloAlumno = '$IdModAlum'");
      }

      


      

      // if ($_grado == 3) {
      //   if ($NoParcial == 3) {

      //     $sql_prom = $db->query("SELECT tblp_moduloalumno.ParcialF1, tblp_moduloalumno.ParcialF2, tblp_moduloalumno.ParcialF3 FROM tblp_moduloalumno WHERE tblp_moduloalumno.IdAsignacion = '$IdAsignacion' AND tblp_moduloalumno.IdUsua = '$IdUsua' AND tblp_moduloalumno.IdModulo = '$IdModulo'");
      //     $db->rows($sql_prom);
      //     $_prom = $db->recorrer($sql_prom);
      //     $p1 = $_prom["ParcialF1"];
      //     $p2 = $_prom["ParcialF2"];
      //     $p3 = $_prom["ParcialF3"];

      //     $px1 = ($p1 + $p2);
      //     $px1 = ($px1 / 2);
      //     $px2 = ($px1 + $p3);
      //     $px = ($px2 / 2);

      //     if ($px == 0) {
      //       $promx = 'NP';
      //       $px = 'NP';
      //     } else {
      //       // $px = ($px / 3);
      //       $promx = round($px, 0, PHP_ROUND_HALF_DOWN);
      //       $px = round($px);
      //     }
      //     if (($promx > 0) && $promx < 5) {
      //       $promx = 5;
      //       $px = 5;
      //     }

      //     // if (($IdEducativa == 6) || ($IdEducativa == 13)) {
      //     //   if ($promx < 9) {
      //     //     $promx = 5;
      //     //   }
      //     // } else {
      //     //   if ($promx < 7) {
      //     //     $promx = 5;
      //     //   }
      //     // }

      //     $insertar = $db->query("UPDATE tblp_calificacion SET tblp_calificacion.Promedio = '$promx' WHERE tblp_calificacion.IdCalificacion = '$IdCal'");
      //     $insertar = $db->query("UPDATE tblp_moduloalumno SET tblp_moduloalumno.Promedio = '$px', tblp_moduloalumno.Promedio_final = '$promx' WHERE tblp_moduloalumno.IdModuloAlumno = '$IdModAlum'");
      //   }
      // } else {
      //   if ($cali == 0) {
      //     $promx = 'NP';
      //     $px = 'NP';
      //   } else {
      //     $promx = round($prom, 0, PHP_ROUND_HALF_DOWN);
      //     $px = round($prom);
      //   }

      //   if (($promx > 0) && $promx < 5) {
      //     $promx = 5;
      //     $px = 5;
      //   }

      //   $insertar = $db->query("UPDATE tblp_calificacion SET tblp_calificacion.Promedio = '$promx' WHERE tblp_calificacion.IdCalificacion = '$IdCal'");
      //   $insertar = $db->query("UPDATE tblp_moduloalumno SET tblp_moduloalumno.Promedio = '$px', tblp_moduloalumno.Promedio_final = '$promx' WHERE tblp_moduloalumno.IdModuloAlumno = '$IdModAlum'");
      // }
    }
  }




  #GENERAR PROMEDIO FINAL
  $IdOferta = $_asig["IdEducativa"];

  if (($IdOferta == 33) || ($IdOferta == 47)) {
    $noParcial = 3;
  } else {
    $noParcial = 1;
  }

  $sql_lista = $db->query("SELECT * FROM tblp_moduloalumno WHERE tblp_moduloalumno.IdAsignacion = '$IdAsignacion'");
  while ($_list = $db->recorrer($sql_lista)) {
    $IdUsua = $_list["IdUsua"];
    $IdModuloAlumno = $_list["IdModuloAlumno"];

    $sql5 = $db->query("SELECT * FROM tblp_calificacion WHERE tblp_calificacion.IdAsignacion = '$IdAsignacion' AND  tblp_calificacion.IdUsua = '$IdUsua' ");
    $db->rows($sql5);
    $datos51 = $db->recorrer($sql5);
    $IdCal = $datos51["IdCalificacion"];

    if ($noParcial == 1) {
      $sql_prom = $db->query("SELECT tblp_moduloalumno.ParcialF1, tblp_moduloalumno.ParcialF2 FROM tblp_moduloalumno WHERE tblp_moduloalumno.IdModuloAlumno = '$IdModuloAlumno' ");
      $db->rows($sql_prom);
      $_prom = $db->recorrer($sql_prom);
      $px = $_prom["ParcialF1"];
      if($px < 6){
        $px = 5;
      }
      if ($px == 0) {
        $promx = '0';
        $px = '0';
      } else {
        $promx = round($px, 0);
        $px = round($px, 2);
      }
      if (($promx > 0) && $promx < $PromedioMinimo) {
        $promx = 5;
        $px = 5;
      }

      $insertar = $db->query("UPDATE tblp_moduloalumno SET tblp_moduloalumno.Promedio = '$px', tblp_moduloalumno.Promedio_final = '$promx' WHERE tblp_moduloalumno.IdModuloAlumno = '$IdModuloAlumno'");
      $insertar = $db->query("UPDATE tblp_calificacion SET tblp_calificacion.Promedio = '$promx' WHERE tblp_calificacion.IdCalificacion = '$IdCal' ");

    }

    if ($noParcial == 3) {
      $sql_prom = $db->query("SELECT tblp_moduloalumno.ParcialF1, tblp_moduloalumno.ParcialF3, tblp_moduloalumno.ParcialF2 FROM tblp_moduloalumno WHERE tblp_moduloalumno.IdModuloAlumno = '$IdModuloAlumno'");
      $db->rows($sql_prom);
      $_prom = $db->recorrer($sql_prom);
      $p1 = $_prom["ParcialF1"];
      $p2 = $_prom["ParcialF2"];
      $p3 = $_prom["ParcialF3"];

      $proPar = ($p1 + $p2);
      $proPar = ($proPar / 2);
      
      $proPar = round($proPar, 1); // Promedio 1 decimal
      $proPar = round($proPar); // Promedio sin decimal

      $promFinal = ($proPar + $p3);
      $px = ($promFinal / 2);

      $promx = round($px, 0);
      $px = round($px, 2);

      if ($px == 0) {
        $promx = '0';
        $px = '0';
      } 
      if (($promx > 0) && $promx < $PromedioMinimo) {
        $promx = 5;
        $px = 5;
      }
      if ($promx == 0) { $promx = 5; $px = 5; }

      $insertar = $db->query("UPDATE tblp_moduloalumno SET tblp_moduloalumno.Promedio = '$px', tblp_moduloalumno.Promedio_final = '$promx' WHERE tblp_moduloalumno.IdModuloAlumno = '$IdModuloAlumno' ");
      $insertar = $db->query("UPDATE tblp_calificacion SET tblp_calificacion.Promedio = '$promx' WHERE tblp_calificacion.IdCalificacion = '$IdCal' ");
    }

}


  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "sac_cal_ini") {
  $IdModA = $_POST["IdModA"];
  $IdAsignacion = $_POST["IdAsignacion"];
  $Calif = $_POST["Calif"];
  $Parcial = $_POST["Parcial"];
  $IdUsua = $_POST["IdUsua"];

  $sql3 = $db->query("SELECT tblp_asignacion.IdEducativa, tblp_asignacion.NoParcial, tblp_asignacion.IdModulo, tblp_asignacion.IdCiclo FROM tblp_asignacion WHERE tblp_asignacion.IdAsignacion ='$IdAsignacion' AND tblp_asignacion.Tipo = '2'");
  $db->rows($sql3);
  $datos31 = $db->recorrer($sql3);
  $IdEducativa = $datos31["IdEducativa"];
  $IdModulo = $datos31["IdModulo"];
  $IdCiclo = $datos31["IdCiclo"];
  $n_par = 2;  //$datos31["NoParcial"];

  $sql5 = $db->query("SELECT * FROM tblp_calificacion WHERE tblp_calificacion.IdUsua = '$IdUsua' AND tblp_calificacion.IdAsignacion = '$IdAsignacion' ");
  $db->rows($sql5);
  $datos51 = $db->recorrer($sql5);
  $IdCal = $datos51["IdCalificacion"];

  if (!$IdCal) {
    $sql9 = $db->query("SELECT tblc_usuario.Usuario, tblc_usuario.IdGrupo FROM tblc_usuario WHERE tblc_usuario.IdUsua = '$IdUsua'");
    $db->rows($sql9);
    $datos91 = $db->recorrer($sql9);
    $user = $datos91["Usuario"];
    $grp_id = $datos91["IdGrupo"];

    $insertar = $db->query("INSERT INTO tblp_calificacion (IdUsua, Usuario, IdOferta, IdModulo, IdAsignacion, FecCap, IdCiclo, IdGrupo, IdTipo, IdEstatus) VALUES ('$IdUsua','$user','$IdEducativa','$IdModulo','$IdAsignacion',NOW(),'$IdCiclo','$grp_id','2','8')");
    $IdCal = $db->insert_id;
  }

  $insertar = $db->query("UPDATE tblp_moduloalumno SET tblp_moduloalumno.ParcialF$Parcial = '$Calif' WHERE tblp_moduloalumno.IdModuloAlumno = '$IdModA' AND tblp_moduloalumno.IdAsignacion = '$IdAsignacion'");
  $insertar = $db->query("UPDATE tblp_calificacion SET tblp_calificacion.P$Parcial = '$Calif' WHERE tblp_calificacion.IdCalificacion = '$IdCal' ");


  // $sql8 = $db->query("SELECT * FROM tblp_moduloalumno WHERE tblp_moduloalumno.IdUsua = '$IdUsua' AND tblp_moduloalumno.IdAsignacion = '$IdAsignacion'");
  // $db->rows($sql8);
  // $datos81 = $db->recorrer($sql8);
  // $par1 = $datos81["ParcialF1"];
  // $par2 = $datos81["ParcialF2"];
  // $par3 = $datos81["ParcialF3"];
  // $par4 = $datos81["ParcialF4"];
  //
  // $prom1 = ($par1 + $par2 + $par3 + $par4);
  // $prom2 = ($prom1 / $n_par);
  // $prom3 = round($prom2);
  //
  // $insertar = $db->query("UPDATE tblp_moduloalumno SET tblp_moduloalumno.Promedio = '$prom3' WHERE tblp_moduloalumno.IdModuloAlumno = '$IdModA' AND tblp_moduloalumno.IdAsignacion = '$IdAsignacion'");
  // $insertar = $db->query("UPDATE tblp_calificacion SET tblp_calificacion.Promedio = '$prom3' WHERE tblp_calificacion.IdCalificacion = '$IdCal' ");

  // }

  $db->close();
  echo $insertar;
}


if ($tipoGuardar == "sav_cal_udech") {
  $IdModA = $_POST["IdModA"];
  $IdAsignacion = $_POST["IdAsignacion"];
  $Calif = $_POST["Calif"];
  $Parcial = $_POST["Parcial"];
  $IdUsua = $_POST["IdUsua"];
  $IdAdmin = $_POST["IdAdmin"];
  $promx = 0;
  
  $IdModuloAlumno = $_POST["IdModuloAlumno"];
  
  $sql9 = $db->query("SELECT tblc_usuario.Grado, tblc_usuario.Usuario, tblc_usuario.IdGrupo, tblp_grupo.IdOferta, tblp_grupo.Modalidad FROM tblc_usuario Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_usuario.IdGrupo WHERE tblc_usuario.IdUsua = '$IdUsua'");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);
  $user = $datos91["Usuario"];
  $grp_id = $datos91["IdGrupo"];
  $_grado = $datos91["Grado"];
  $_mod = $datos91["Modalidad"];
  $IdOferta = $datos91["IdOferta"];
  if (($IdOferta == 33) || ($IdOferta == 47)) {
    $noParcial = 3;
  } else {
    $noParcial = 1;
  }

  $sql3 = $db->query("SELECT tblp_asignacion.IdEducativa, tblp_asignacion.NoParcial, tblp_asignacion.IdModulo, tblp_asignacion.IdCiclo FROM tblp_asignacion WHERE tblp_asignacion.IdAsignacion ='$IdAsignacion' AND tblp_asignacion.Tipo = '2'");
  $db->rows($sql3);
  $datos31 = $db->recorrer($sql3);
  $IdEducativa = $datos31["IdEducativa"];
  $IdModulo = $datos31["IdModulo"];
  $IdCiclo = $datos31["IdCiclo"];
  $n_par = $datos31["NoParcial"];


  $sql_minimo = $db->query("SELECT tblc_grado.Promedio FROM tblp_educativa Left Join tblc_grado ON tblc_grado.IdGrado = tblp_educativa.IdGrado WHERE tblp_educativa.IdEducativa =  '$IdEducativa' ");
  $db->rows($sql_minimo);
  $_minimo = $db->recorrer($sql_minimo);
  $prom_minimo = $_minimo["Promedio"];



  $sql5 = $db->query("SELECT * FROM tblp_calificacion WHERE tblp_calificacion.IdAsignacion = '$IdAsignacion' AND  tblp_calificacion.IdUsua = '$IdUsua' ");
  $db->rows($sql5);
  $datos51 = $db->recorrer($sql5);
  $IdCal = isset( $datos51["IdCalificacion"]);

  if (!$IdCal) {
    $sql9 = $db->query("SELECT tblc_usuario.Usuario, tblc_usuario.IdGrupo FROM tblc_usuario WHERE tblc_usuario.IdUsua = '$IdUsua'");
    $db->rows($sql9);
    $datos91 = $db->recorrer($sql9);
    $user = $datos91["Usuario"];
    $grp_id = $datos91["IdGrupo"];
    

    $insertar = $db->query("INSERT INTO tblp_calificacion (IdUsua, Usuario, IdOferta, IdModulo, IdAsignacion, FecCap, IdCiclo, IdGrupo, IdTipo, IdEstatus, _valor) VALUES ('$IdUsua','$user','$IdEducativa','$IdModulo','$IdAsignacion',NOW(),'$IdCiclo','$grp_id','2','8','Docecnte')");
    $IdCal = $db->insert_id;
  }

  $Comentario = "Se actualiza la calificación parcial a: ".$Calif;
  $Accion = 'Actualizar';
  $Modulo = 'Acta';

  $insertar = $db->query("UPDATE tblp_moduloalumno SET tblp_moduloalumno.Parcial$Parcial = '$Calif', tblp_moduloalumno.ParcialF$Parcial = '$Calif' WHERE tblp_moduloalumno.IdModuloAlumno = '$IdModuloAlumno'");
  $insertar = $db->query("UPDATE tblp_calificacion SET tblp_calificacion.P$Parcial = '$Calif' WHERE tblp_calificacion.IdCalificacion = '$IdCal' ");

  add_registros($IdAdmin,$Comentario,$Accion,$Modulo,$IdAsignacion,$IdUsua,0);

  

  if ($noParcial == 1) {
      
      
    $sql_prom = $db->query("SELECT tblp_moduloalumno.ParcialF1, tblp_moduloalumno.ParcialF2 FROM tblp_moduloalumno WHERE tblp_moduloalumno.IdModuloAlumno = '$IdModuloAlumno' ");
    $db->rows($sql_prom);
    $_prom = $db->recorrer($sql_prom);
    $px = $_prom["ParcialF1"];


    $px = round($px, 2);
    if ($px == 0) {
      $promx = '5';
    } 

    if (($px > 0) && $px < $prom_minimo) {
      $promx = 5;      
    } else {
      $promx = round($px, 0);
    }


    $insertar = $db->query("UPDATE tblp_moduloalumno SET tblp_moduloalumno.Promedio = '$px', tblp_moduloalumno.Promedio_final = '$promx' WHERE tblp_moduloalumno.IdModuloAlumno = '$IdModuloAlumno'");
    $insertar = $db->query("UPDATE tblp_calificacion SET tblp_calificacion.Promedio = '$promx' WHERE tblp_calificacion.IdCalificacion = '$IdCal' ");

    $Comentario = "Se actualiza la calificación del promedio a: ".$promx;
    add_registros($IdAdmin,$Comentario,$Accion,$Modulo,$IdAsignacion,$IdUsua,0);
    
    echo 1;
    exit();
  }

  if ($noParcial == 3) {
    $sql_prom = $db->query("SELECT tblp_moduloalumno.ParcialF1, tblp_moduloalumno.ParcialF3, tblp_moduloalumno.ParcialF2 FROM tblp_moduloalumno WHERE tblp_moduloalumno.IdModuloAlumno = '$IdModuloAlumno'");
    $db->rows($sql_prom);
    $_prom = $db->recorrer($sql_prom);
    $p1 = $_prom["ParcialF1"];
    $p2 = $_prom["ParcialF2"];
    $p3 = $_prom["ParcialF3"];

    $proPar = ($p1 + $p2);
    $proPar = ($proPar / 2);
    $proPar = round($proPar, 1); // Promedio 1 decimal
    $proPar = round($proPar); // Promedio sin decimal

    $promFinal = ($proPar + $p3);
    $px = ($promFinal / 2);

    // $promx = round($px, 0);
     $px = round($px, 2);

    if ($px == 0) {
      $promx = '5';
      
    }

    if (($px > 0) && $px < $prom_minimo) {
      $promx = 5;
    } else {
      $promx = round($px, 0);
    }


    $insertar = $db->query("UPDATE tblp_moduloalumno SET tblp_moduloalumno.Promedio = '$px', tblp_moduloalumno.Promedio_final = '$promx' WHERE tblp_moduloalumno.IdModuloAlumno = '$IdModuloAlumno' ");
    $insertar = $db->query("UPDATE tblp_calificacion SET tblp_calificacion.Promedio = '$promx' WHERE tblp_calificacion.IdCalificacion = '$IdCal' ");

    $Comentario = "Se actualiza la calificación del promedio a: ".$promx;
    add_registros($IdAdmin,$Comentario,$Accion,$Modulo,$IdAsignacion,$IdUsua,0);

    echo 1;
    exit();
  }

  $db->close();
  echo $insertar;
}



if ($tipoGuardar == "validar_calificacion_final") {
  $Parcial = $_POST["NoParcial"];
  echo $IdAsignacion = $_POST["IdAsignacion"];

  $sql3 = $db->query("SELECT tblp_asignacion.IdEducativa, tblp_asignacion.NoParcial, tblp_asignacion.IdModulo, tblp_asignacion.IdCiclo FROM tblp_asignacion WHERE tblp_asignacion.IdAsignacion ='$IdAsignacion' AND tblp_asignacion.Tipo = '2'");
  $db->rows($sql3);
  $datos31 = $db->recorrer($sql3);
  $IdEducativa = $datos31["IdEducativa"];
  $IdModulo = $datos31["IdModulo"];
  $IdCiclo = $datos31["IdCiclo"];
  
  $IdOferta = $datos31["IdEducativa"];
  if (($IdOferta == 33) || ($IdOferta == 47)) {
    $noParcial = 3;
  } else {
    $noParcial = 1;
  }

  $sql = $db->query("SELECT * FROM tblp_moduloalumno WHERE tblp_moduloalumno.IdAsignacion = '$IdAsignacion'");
  while ($x = $db->recorrer($sql)) {
    $IdUsua = $x["IdUsua"];
    $IdModuloAlumno = $x["IdModuloAlumno"];

    $sql5 = $db->query("SELECT * FROM tblp_calificacion WHERE tblp_calificacion.IdAsignacion = '$IdAsignacion' AND  tblp_calificacion.IdUsua = '$IdUsua' ");
    $db->rows($sql5);
    $datos51 = $db->recorrer($sql5);
    $IdCal = $datos51["IdCalificacion"];

    if (!$IdCal) {
      $sql9 = $db->query("SELECT tblc_usuario.Usuario, tblc_usuario.IdGrupo FROM tblc_usuario WHERE tblc_usuario.IdUsua = '$IdUsua'");
      $db->rows($sql9);
      $datos91 = $db->recorrer($sql9);
      $user = $datos91["Usuario"];
      $grp_id = $datos91["IdGrupo"];


      $insertar = $db->query("INSERT INTO tblp_calificacion (IdUsua, Usuario, IdOferta, IdModulo, IdAsignacion, FecCap, IdCiclo, IdGrupo, IdTipo, IdEstatus, _valor) VALUES ('$IdUsua','$user','$IdEducativa','$IdModulo','$IdAsignacion',NOW(),'$IdCiclo','$grp_id','2','8','Docecnte')");
      $IdCal = $db->insert_id;
    }

    if ($noParcial == 1) {
      $sql_prom = $db->query("SELECT tblp_moduloalumno.ParcialF1, tblp_moduloalumno.ParcialF2 FROM tblp_moduloalumno WHERE tblp_moduloalumno.IdModuloAlumno = '$IdModuloAlumno' ");
      $db->rows($sql_prom);
      $_prom = $db->recorrer($sql_prom);
      $px = $_prom["ParcialF1"];
      if($px < 6){
        $px = 5;
      }
      if ($px == 0) {
        $promx = '0';
        $px = '0';
      } else {
        $promx = round($px, 0);
        $px = round($px, 2);
      }
      if (($promx > 0) && $promx < 5) {
        $promx = 5;
        $px = 5;
      }

      $insertar = $db->query("UPDATE tblp_moduloalumno SET tblp_moduloalumno.Promedio = '$px', tblp_moduloalumno.Promedio_final = '$promx' WHERE tblp_moduloalumno.IdModuloAlumno = '$IdModuloAlumno'");
      $insertar = $db->query("UPDATE tblp_calificacion SET tblp_calificacion.Promedio = '$promx' WHERE tblp_calificacion.IdCalificacion = '$IdCal' ");

    }

    if ($noParcial == 3) {
      $sql_prom = $db->query("SELECT tblp_moduloalumno.ParcialF1, tblp_moduloalumno.ParcialF3, tblp_moduloalumno.ParcialF2 FROM tblp_moduloalumno WHERE tblp_moduloalumno.IdModuloAlumno = '$IdModuloAlumno'");
      $db->rows($sql_prom);
      $_prom = $db->recorrer($sql_prom);
      $p1 = $_prom["ParcialF1"];
      $p2 = $_prom["ParcialF2"];
      $p3 = $_prom["ParcialF3"];

      $proPar = ($p1 + $p2);
      $proPar = ($proPar / 2);
      $proPar = round($proPar, 1); // Promedio 1 decimal
      $proPar = round($proPar); // Promedio sin decimal

      $promFinal = ($proPar + $p3);
      $px = ($promFinal / 2);

      $promx = round($px, 0);
      $px = round($px, 2);

      if ($px == 0) {
        $promx = '0';
        $px = '0';
      } 
      if (($promx > 0) && $promx < 5) {
        $promx = 5;
        $px = 5;
      }
      echo "UPDATE tblp_moduloalumno SET tblp_moduloalumno.Promedio = '$px', tblp_moduloalumno.Promedio_final = '$promx' WHERE tblp_moduloalumno.IdModuloAlumno = '$IdModuloAlumno' ";

      $insertar = $db->query("UPDATE tblp_moduloalumno SET tblp_moduloalumno.Promedio = '$px', tblp_moduloalumno.Promedio_final = '$promx' WHERE tblp_moduloalumno.IdModuloAlumno = '$IdModuloAlumno' ");
      $insertar = $db->query("UPDATE tblp_calificacion SET tblp_calificacion.Promedio = '$promx' WHERE tblp_calificacion.IdCalificacion = '$IdCal' ");

      echo 1;
      exit();
    }

}

  

  $db->close();
  echo $insertar;
}


if ($tipoGuardar == "sav_cal_parcial_id") {
  $IdModA = $_POST["IdModuloAlumno"];
  $Parcial = $_POST["Parcial"];
  $NoParcial = $_POST["NoParcial"];
  $IdAsignacion = $_POST["IdAsignacion"];
  $Calif = $_POST["Calif"];
  $IdUsua = $_POST["IdUsua"];


  $sql9 = $db->query("SELECT tblc_usuario.Grado, tblc_usuario.Usuario, tblc_usuario.IdGrupo, tblp_grupo.Modalidad FROM tblc_usuario Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_usuario.IdGrupo WHERE tblc_usuario.IdUsua = '$IdUsua'");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);
  $user = $datos91["Usuario"];
  $grp_id = $datos91["IdGrupo"];
  $_grado = $datos91["Grado"];
  $_mod = $datos91["Modalidad"];

  $sql3 = $db->query("SELECT tblp_asignacion.IdEducativa, tblp_asignacion.NoParcial, tblp_asignacion.IdModulo, tblp_asignacion.IdCiclo FROM tblp_asignacion WHERE tblp_asignacion.IdAsignacion ='$IdAsignacion' AND tblp_asignacion.Tipo = '2'");
  $db->rows($sql3);
  $datos31 = $db->recorrer($sql3);
  $IdEducativa = $datos31["IdEducativa"];
  $IdModulo = $datos31["IdModulo"];
  $IdCiclo = $datos31["IdCiclo"];


  $sql5 = $db->query("SELECT * FROM tblp_calificacion WHERE tblp_calificacion.IdUsua = '$IdUsua' AND tblp_calificacion.IdAsignacion = '$IdAsignacion' ");
  $db->rows($sql5);
  $datos51 = $db->recorrer($sql5);
  $IdCal = $datos51["IdCalificacion"];

  if (!$IdCal) {
    $sql9 = $db->query("SELECT tblc_usuario.Usuario, tblc_usuario.IdGrupo FROM tblc_usuario WHERE tblc_usuario.IdUsua = '$IdUsua'");
    $db->rows($sql9);
    $datos91 = $db->recorrer($sql9);
    $user = $datos91["Usuario"];
    $grp_id = $datos91["IdGrupo"];

    $insertar = $db->query("INSERT INTO tblp_calificacion (IdUsua, Usuario, IdOferta, IdModulo, IdAsignacion, FecCap, IdCiclo, IdGrupo, IdTipo, IdEstatus) VALUES ('$IdUsua','$user','$IdEducativa','$IdModulo','$IdAsignacion',NOW(),'$IdCiclo','$grp_id','2','8')");
    $IdCal = $db->insert_id;
  }

  $insertar = $db->query("UPDATE tblp_moduloalumno SET tblp_moduloalumno.Parcial$Parcial = '$Calif', tblp_moduloalumno.ParcialF$Parcial = '$Calif' WHERE tblp_moduloalumno.IdModuloAlumno = '$IdModA' AND tblp_moduloalumno.IdAsignacion = '$IdAsignacion'");
  $insertar = $db->query("UPDATE tblp_calificacion SET tblp_calificacion.P$Parcial = '$Calif' WHERE tblp_calificacion.IdCalificacion = '$IdCal' ");



  if ($NoParcial == 3) {

    $sql_prom = $db->query("SELECT tblp_moduloalumno.ParcialF1, tblp_moduloalumno.ParcialF2, tblp_moduloalumno.ParcialF3 FROM tblp_moduloalumno WHERE tblp_moduloalumno.IdAsignacion = '$IdAsignacion' AND tblp_moduloalumno.IdUsua = '$IdUsua' AND tblp_moduloalumno.IdModulo = '$IdModulo'");
    $db->rows($sql_prom);
    $_prom = $db->recorrer($sql_prom);
    $p1 = $_prom["ParcialF1"];
    $p2 = $_prom["ParcialF2"];
    $p3 = $_prom["ParcialF3"];
    $px = ($p1 + $p2 + $p3);

    if ($px == 0) {
      $promx = 'NP';
      $px = 'NP';
    } else {
      $px = ($px / 3);
      $promx = round($px, 0, PHP_ROUND_HALF_DOWN);
      $px = round($px, 2);
    }
    if (($promx > 0) && $promx < 5) {
      $promx = 5;
      $px = 5;
    }

    if (($IdEducativa == 6) || ($IdEducativa == 13)) {
      if ($promx < 9) {
        $promx = 5;
      }
    } else {
      if ($promx < 7) {
        $promx = 5;
      }
    }

    $insertar = $db->query("UPDATE tblp_moduloalumno SET tblp_moduloalumno.Promedio = '$px', tblp_moduloalumno.Promedio_final = '$promx' WHERE tblp_moduloalumno.IdModuloAlumno = '$IdModA'");
    $insertar = $db->query("UPDATE tblp_calificacion SET tblp_calificacion.Promedio = '$promx' WHERE tblp_calificacion.IdCalificacion = '$IdCal' ");
  }

  if ($NoParcial == 2) {
    $sql_prom = $db->query("SELECT tblp_moduloalumno.ParcialF1, tblp_moduloalumno.ParcialF2, tblp_moduloalumno.ParcialF3 FROM tblp_moduloalumno WHERE tblp_moduloalumno.IdAsignacion = '$IdAsignacion' AND tblp_moduloalumno.IdUsua = '$IdUsua' AND tblp_moduloalumno.IdModulo = '$IdModulo'");
    $db->rows($sql_prom);
    $_prom = $db->recorrer($sql_prom);
    $p1 = $_prom["ParcialF1"];
    $p2 = $_prom["ParcialF2"];
    $px = ($p1 + $p2);

    if ($px == 0) {
      $promx = 'NP';
      $px = 'NP';
    } else {
      $px = ($px / 2);
      $promx = round($px, 0, PHP_ROUND_HALF_DOWN);
      $px = round($px, 2);
    }
    if (($promx > 0) && $promx < 5) {
      $promx = 5;
      $px = 5;
    }

    if (($IdEducativa == 6) || ($IdEducativa == 13)) {
      if ($promx < 9) {
        $promx = 5;
      }
    } else {
      if ($promx < 7) {
        $promx = 5;
      }
    }

    $insertar = $db->query("UPDATE tblp_moduloalumno SET tblp_moduloalumno.Promedio = '$px', tblp_moduloalumno.Promedio_final = '$promx' WHERE tblp_moduloalumno.IdModuloAlumno = '$IdModA'");
    $insertar = $db->query("UPDATE tblp_calificacion SET tblp_calificacion.Promedio = '$promx' WHERE tblp_calificacion.IdCalificacion = '$IdCal' ");
  }


  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "savPromedio") {
  $IdUsua = $_POST["IdUsua"];
  $IdModA = $_POST["IdModA"];
  $IdAsignacion = $_POST["IdAsignacion"];
  $Calif = $_POST["Calif"];

  $sql3 = $db->query("SELECT tblp_asignacion.IdEducativa, tblp_asignacion.IdModulo, tblp_asignacion.IdGrupo, tblp_asignacion.IdCiclo FROM tblp_asignacion WHERE tblp_asignacion.IdAsignacion ='$IdAsignacion' AND tblp_asignacion.Tipo = '2'");
  $db->rows($sql3);
  $datos31 = $db->recorrer($sql3);
  $IdEducativa = $datos31["IdEducativa"];
  $IdGrupo = $datos31["IdGrupo"];
  $IdModulo = $datos31["IdModulo"];
  $IdCiclo = $datos31["IdCiclo"];

  $sql5 = $db->query("SELECT * FROM tblp_calificacion WHERE tblp_calificacion.IdAsignacion = '$IdAsignacion' AND tblp_calificacion.IdUsua = '$IdUsua'");
  $db->rows($sql5);
  $datos51 = $db->recorrer($sql5);
  $IdCal = $datos51["IdCalificacion"];

  $insertar = $db->query("UPDATE tblp_moduloalumno SET tblp_moduloalumno.Promedio = '$Calif' WHERE tblp_moduloalumno.IdModuloAlumno = '$IdModA'");

  if ($IdCal) {

    $insertar = $db->query("UPDATE tblp_calificacion SET tblp_calificacion.Promedio = '$Calif', tblp_calificacion.IdCiclo = '$IdCiclo' WHERE tblp_calificacion.IdUsua = '$IdUsua' AND tblp_calificacion.IdModulo = '$IdModulo' ");
  } else {
    $sql9 = $db->query("SELECT tblc_usuario.Usuario FROM tblc_usuario WHERE tblc_usuario.IdUsua = '$IdUsua'");
    $db->rows($sql9);
    $datos91 = $db->recorrer($sql9);
    $user = $datos91["Usuario"];

    $insertar = $db->query("INSERT INTO tblp_calificacion (IdUsua, Usuario, IdOferta, IdModulo, FecCap, Promedio, IdAsignacion, IdCiclo, IdGrupo, IdTipo, IdEstatus) VALUES ('$IdUsua','$user','$IdEducativa','$IdModulo',NOW(),'$Calif','$IdAsignacion','$IdCiclo','$IdGrupo','2','8')");
  }

  $db->close();
  echo $insertar;
}


if ($tipoGuardar == "del_asignacion") {
  $IdUsuaX = $_POST["employee_id"];

  $porciones = explode("-", $IdUsuaX);
  $IdUsua = $porciones[0];
  $IdAsig = $porciones[1];
  $IdMod = $porciones[2];
  $IdModAlum = $porciones[3];
  // echo "DELETE FROM tblp_moduloalumno WHERE tblp_moduloalumno.IdUsua = '$IdUsua' AND tblp_moduloalumno.IdModuloAlumno = '$IdModAlum' ";
  $insertar = $db->query("DELETE FROM tblp_tareas WHERE tblp_tareas.IdAlumno = '$IdUsua' AND tblp_tareas.IdAsignacion = '$IdAsig' ");
  $insertar = $db->query("DELETE FROM tblp_editor WHERE tblp_editor.IdUsua = '$IdUsua' AND tblp_editor.IdAsignacion = '$IdAsig' ");
  $insertar = $db->query("DELETE FROM tblp_moduloalumno WHERE tblp_moduloalumno.IdModuloAlumno = '$IdModAlum' ");

  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "del_pago") {
  $IdPago = $_POST["IdPago"];
  $Token = substr($_POST["Token"], 10, 10);

  $insertar = $db->query("DELETE FROM tblp_pagos WHERE tblp_pagos.IdPago = '$IdPago'");
  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "savResulktado") {
  $IdResultado = $_POST["IdResultado"];
  $Valor = $_POST["Valor"];

  $insertar = $db->query("UPDATE tblp_examresultado SET tblp_examresultado.Valor = '$Valor' WHERE tblp_examresultado.IdResultado = '$IdResultado'");

  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "cancel_pago") {
  $Folio = $_POST["Folio"];
  $IdUsua = $_POST["IdUsua"];
  $Motivo = $_POST["Cancelx"] . '_' . $IdUsua;
  $dispo = 0;
  $sql2 = $db->query("SELECT tblp_foliospago.IdFolio, tblp_foliospago.IdPago FROM tblp_foliospago WHERE tblp_foliospago.Folio = '$Folio'");
  while ($y = $db->recorrer($sql2)) {
    $dispo = 0;
    $_idPago = $y["IdPago"];
    $sql_abono = $db->query("SELECT tblp_abono_pago.Monto FROM tblp_abono_pago WHERE tblp_abono_pago.Folio = '$Folio' AND tblp_abono_pago.IdPago = '$_idPago'");
    $db->rows($sql_abono);
    $_abono = $db->recorrer($sql_abono);
    $monto = $_abono["Monto"];

    $sql_pag = $db->query("SELECT tblp_pagos.TotalPagado FROM tblp_pagos WHERE tblp_pagos.IdPago = '$_idPago'");
    $db->rows($sql_pag);
    $_pag = $db->recorrer($sql_pag);
    $totalPag = $_pag["TotalPagado"];
    $dispo = ($totalPag - $monto);
    if ($monto) {
      $dispo = ($totalPag - $monto);
    } else {
      $dispo = 0;
    }

    $insertar = $db->query("UPDATE tblp_pagos SET tblp_pagos.TotalPagado = '$dispo', tblp_pagos.IdEstatus = '1' WHERE tblp_pagos.IdPago = '$_idPago'");
  }
  $insertar = $db->query("UPDATE tblp_foliospago SET tblp_foliospago.IdEstatus = '7', tblp_foliospago.Estatus = '7', tblp_foliospago.FecCancelado = NOW(), tblp_foliospago.Motivo_cancelado = '$Motivo' WHERE tblp_foliospago.Folio = '$Folio'");


  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "calexasulktado") {
  $IdUsua = $_POST["employee_id"];
  $IdAsignacion = $_POST["IdAsignacion"];
  $IdParcial = $_POST["IdParcial"];
  $IdActividadDoc = $_POST["IdActividadDoc"];

  $sql4 = $db->query("SELECT Sum(tblp_examresultado.Valor) AS Puntos FROM tblp_examresultado WHERE tblp_examresultado.IdUsua =  '$IdUsua' AND tblp_examresultado.IdAsignacion ='$IdAsignacion' AND tblp_examresultado.IdParcialDocente =  '$IdParcial' AND tblp_examresultado.IdActividadesDocente =  '$IdActividadDoc'");
  $db->rows($sql4);
  $datos41 = $db->recorrer($sql4);
  $buenas = $datos41["Puntos"];

  $sql5 = $db->query("SELECT * FROM tblp_actividadesdocente WHERE tblp_actividadesdocente.IdActividadesDocente = '$IdActividadDoc'");
  $db->rows($sql5);
  $datos51 = $db->recorrer($sql5);
  $por = $datos51["Porcentaje"];

  $sql6 = $db->query("SELECT Count(tblp_examresultado.IdResultado) AS Preguntas FROM tblp_examresultado WHERE tblp_examresultado.IdUsua = '$IdUsua' AND tblp_examresultado.IdAsignacion = '$IdAsignacion' AND tblp_examresultado.IdActividadesDocente = '$IdActividadDoc' ");
  $db->rows($sql6);
  $datos61 = $db->recorrer($sql6);


  $dato1 = ($por / $datos61["Preguntas"]);
  $dato2 = ($dato1 * $buenas);

  $insertar = $db->query("UPDATE tblp_tareas SET tblp_tareas.Porcentaje = '$dato2', tblp_tareas.Calificacion = '$dato2'  WHERE tblp_tareas.IdAsignacion ='$IdAsignacion' AND tblp_tareas.IdAlumno = '$IdUsua' AND tblp_tareas.IdActividadesDocente = '$IdActividadDoc' AND tblp_tareas.IdParcialDocente = '$IdParcial'");



  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "addTeimpoEx") {
  $IdActividadDoc = $_POST["IdActividadDoc"];
  $Tiempo = $_POST["Tiempo"];
  $insertar = $db->query("UPDATE tblp_actividadesdocente SET tblp_actividadesdocente.Tiempo = '$Tiempo' WHERE tblp_actividadesdocente.IdActividadesDocente = '$IdActividadDoc'");

  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "addHoraEx") {
  $IdActividadDoc = $_POST["IdActividadDoc"];
  $Hora = $_POST["Hora"];
  $Campo = $_POST["Campo"];
  if ($Hora) {
    $sql1 = $db->query("SELECT tblp_actividadesdocente.FecIni, tblp_actividadesdocente.FecFin, tblp_actividadesdocente.Ini, tblp_actividadesdocente.Fin FROM tblp_actividadesdocente WHERE tblp_actividadesdocente.IdActividadesDocente = '$IdActividadDoc'");
    $db->rows($sql1);
    $datos11 = $db->recorrer($sql1);
    $Hini = $datos11["FecIni"];
    $Hfin = $datos11["FecFin"];
    $x_val = 0;
    if ($Hini == $Hfin) {
      $x_val = 1;
    }

    if ($Campo == "Ini") {
      $Fecha = $datos11["FecIni"];
      $_xfin = $datos11["Fin"];

      if (($x_val == 1) && ($_xfin)) {

        $hras = $Fecha . ' ' . $Hora;
        if ($hras >= $_xfin) {
          $insertar = $db->query("UPDATE tblp_actividadesdocente SET tblp_actividadesdocente.Ini = NULL, tblp_actividadesdocente.Fin = NULL WHERE tblp_actividadesdocente.IdActividadesDocente = '$IdActividadDoc'");
          echo 3;
          exit();
        }
      }
    } else {
      $Fecha = $datos11["FecFin"];
      if ($x_val == 1) {
        $_xini = $datos11["Ini"];
        $hras = $Fecha . ' ' . $Hora;
        if ($_xini >= $hras) {
          $insertar = $db->query("UPDATE tblp_actividadesdocente SET tblp_actividadesdocente.$Campo = NULL WHERE tblp_actividadesdocente.IdActividadesDocente = '$IdActividadDoc'");
          echo 2;
          exit();
        }
      }
    }

    $hras = $Fecha . ' ' . $Hora;
    $insertar = $db->query("UPDATE tblp_actividadesdocente SET tblp_actividadesdocente.$Campo = '$hras' WHERE tblp_actividadesdocente.IdActividadesDocente = '$IdActividadDoc'");
  } else {
    $insertar = $db->query("UPDATE tblp_actividadesdocente SET tblp_actividadesdocente.$Campo = NULL WHERE tblp_actividadesdocente.IdActividadesDocente = '$IdActividadDoc'");
  }
  $db->close();
  echo $insertar;
}


if ($tipoGuardar == "addHora_Exi") {
  $IdActividadDoc = $_POST["IdActividadDoc"];
  $Tiempo = $_POST["Tiempo"];
  $Inicio = $_POST["Inicio"];
  $Final = $_POST["Final"];
  $Orden = $_POST["Orden"];

  $sql1 = $db->query("SELECT tblp_actividadesdocente.FecIni, tblp_actividadesdocente.FecFin, tblp_actividadesdocente.Ini, tblp_actividadesdocente.Fin FROM tblp_actividadesdocente WHERE tblp_actividadesdocente.IdActividadesDocente = '$IdActividadDoc'");
  $db->rows($sql1);
  $datos11 = $db->recorrer($sql1);
  $Hini = $datos11["FecIni"];
  $Hfin = $datos11["FecFin"];

  $hrasI = $Hini . ' ' . $Inicio;
  $hrasF = $Hfin . ' ' . $Final;

  $insertar = $db->query("UPDATE tblp_actividadesdocente SET tblp_actividadesdocente.Orden = '$Orden', tblp_actividadesdocente.Tiempo = '$Tiempo', tblp_actividadesdocente.Ini = '$hrasI', tblp_actividadesdocente.Fin = '$hrasF' WHERE tblp_actividadesdocente.IdActividadesDocente = '$IdActividadDoc'");

  $db->close();
  echo $insertar;
}



if ($tipoGuardar == "sav_documentos_entregados") {
  $IdDocumento = $_POST["IdDocumento"];
  $Tipo = $_POST["Tipo"];
  $Valor = $_POST["Valor"];
  $Fecha = $_POST["Fecha"];
  $IdAdmin = $_POST["IdAdmin"];
  
  if($Tipo == "Si"){
    $insertar = $db->query("UPDATE tblp_documentos SET tblp_documentos.IdUsua_original = '$IdAdmin', tblp_documentos.Fecha_original = '$Fecha', tblp_documentos.$Tipo = '$Valor' WHERE tblp_documentos.IdDocumento = '$IdDocumento'");
  } else {
    $insertar = $db->query("UPDATE tblp_documentos SET tblp_documentos.IdUsua_copia = '$IdAdmin', tblp_documentos.Fecha_copia = '$Fecha', tblp_documentos.$Tipo = '$Valor' WHERE tblp_documentos.IdDocumento = '$IdDocumento'");
  }



  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "sav_resp_ex_id") {
  $IdPregunta = $_POST["IdPregunta"];
  $Respuesta = $_POST["Respuesta"];

  $insertar = $db->query("INSERT INTO tblp_examrespuesta (IdPregunta, Respuesta, Valor) VALUES ('$IdPregunta','$Respuesta','0')");


  $db->close();
  echo $insertar;
}




if ($tipoGuardar == "sav_resp_val_id") {
  $IdRespuesta = $_POST["IdRespuesta"];
  $IdPregunta = $_POST["IdPregunta"];

  $Valor = $_POST["Valor"];
  if ($Valor == 1) {
    $insertar = $db->query("UPDATE tblp_examrespuesta SET tblp_examrespuesta.Valor = '0' WHERE tblp_examrespuesta.IdPregunta = '$IdPregunta' ");
    $insertar = $db->query("UPDATE tblp_examrespuesta SET tblp_examrespuesta.Valor = '1' WHERE tblp_examrespuesta.IdRespuesta = '$IdRespuesta' ");
    $insertar = $db->query("UPDATE tblp_exampregunta SET tblp_exampregunta.IdEstatus = '8' WHERE tblp_exampregunta.IdPregunta = '$IdPregunta' ");
  } else {
    $insertar = $db->query("UPDATE tblp_examrespuesta SET tblp_examrespuesta.Valor = '0' WHERE tblp_examrespuesta.IdPregunta = '$IdPregunta' ");
    $insertar = $db->query("UPDATE tblp_exampregunta SET tblp_exampregunta.IdEstatus = '31' WHERE tblp_exampregunta.IdPregunta = '$IdPregunta' ");
  }

  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "del_resp_val_id") {
  $IdRespuesta = $_POST["IdRespuesta"];
  $IdPregunta = $_POST["IdPregunta"];

  $sql1 = $db->query("SELECT * FROM tblp_examrespuesta WHERE tblp_examrespuesta.IdRespuesta = '$IdRespuesta'");
  $db->rows($sql1);
  $datos11 = $db->recorrer($sql1);
  $_valor = $datos11["Valor"];
  if ($_valor == 1) {
    $insertar = $db->query("UPDATE tblp_exampregunta SET tblp_exampregunta.IdEstatus = '31' WHERE tblp_exampregunta.IdPregunta = '$IdPregunta' ");
  }

  $insertar = $db->query("DELETE FROM tblp_examrespuesta WHERE tblp_examrespuesta.IdRespuesta = '$IdRespuesta' ");

  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "savIGSIE") {
  $IdUsua = $_POST["IdUsua"];
  $IdModA = $_POST["IdModA"];
  $IdAsignacion = $_POST["IdAsignacion"];
  $Calif = $_POST["Calif"];
  $Extra = $_POST["Extra"];
  if ($Extra == 1) {
    $extra = "E1";
  } else {
    $extra = "E2";
  }

  $insertar = $db->query("UPDATE tblp_moduloalumno SET tblp_moduloalumno.$extra = '$Calif' WHERE tblp_moduloalumno.IdModuloAlumno = '$IdModA' AND tblp_moduloalumno.IdAsignacion = '$IdAsignacion'");

  $insertar = $db->query("UPDATE tblp_calificacion SET tblp_calificacion.$extra = '$Calif' WHERE tblp_calificacion.IdUsua = '$IdUsua' AND tblp_calificacion.IdAsignacion = '$IdAsignacion' ");
  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "cargarCaliE") {
  $IdParcialDoc = $_POST["IdParcialDoc"];
  $IdAsignacion = $_POST["IdAsignacion"];
  $NoParcial = $_POST["NoParcial"];

  if ($NoParcial == 1) {
    $extra = "Extra1";
  } else {
    $extra = "Extra2";
  }

  $sql = $db->query("SELECT * FROM tblp_moduloalumno WHERE tblp_moduloalumno.IdAsignacion = '$IdAsignacion' AND tblp_moduloalumno.$extra = '1'");
  while ($x = $db->recorrer($sql)) {
    $IdAlumno = $x["IdUsua"];
    $IdModAlum = $x["IdModuloAlumno"];
    $sql2 = $db->query("SELECT Sum(tblp_tareas.Calificacion) AS Parcial FROM tblp_tareas WHERE tblp_tareas.IdAsignacion = '$IdAsignacion' AND tblp_tareas.IdParcialDocente = '$IdParcialDoc' AND tblp_tareas.IdAlumno = '$IdAlumno'");
    while ($y = $db->recorrer($sql2)) {
      $cali = $y["Parcial"];
      $insertar = $db->query("UPDATE tblp_moduloalumno SET tblp_moduloalumno.CalExtra$NoParcial = '$cali' WHERE tblp_moduloalumno.IdModuloAlumno = '$IdModAlum'");
    }
  }

  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "sav_fec_emix") {
  $IdAsignacion = $_POST["IdAsignacion"];
  $Fecha = $_POST["Fecha"];
  $campo = $_POST["Campo"];
  $patx = $campo;
  $insertar = $db->query("UPDATE tblp_calificacion SET tblp_calificacion.IdEstatus = '8' WHERE tblp_calificacion.IdAsignacion = '$IdAsignacion'");
  if ($campo == 5) {
    $insertar = $db->query("UPDATE tblp_calificacion SET tblp_calificacion.IdEstatus = '10' WHERE tblp_calificacion.IdAsignacion = '$IdAsignacion'");

    $_camp = "Fecha_impresion";
    $patx = 1;
    $sql = $db->query("SELECT tblp_moduloalumno.IdUsua, tblp_moduloalumno.Promedio_final FROM tblp_moduloalumno WHERE tblp_moduloalumno.IdAsignacion = '$IdAsignacion'");
    while ($x = $db->recorrer($sql)) {
       $insertar = $db->query("UPDATE tblp_calificacion SET tblp_calificacion.Promedio = '".$x['Promedio_final']."' WHERE tblp_calificacion.IdUsua = '".$x['IdUsua']."' AND tblp_calificacion.IdAsignacion = '$IdAsignacion' "); 
    }

    #obtenemos el dato del coordinador
    $sql_coor = $db->query("SELECT tblp_asignacion.IdUsua FROM tblp_asignacion WHERE tblp_asignacion.IdAsignacion = '$IdAsignacion' AND tblp_asignacion.Tipo = '4'");
    $db->rows($sql_coor);
    $_userCoo = $db->recorrer($sql_coor);

    #SE CARGA LA EVALUACIÓN DOCENTE
    $IdAsignacion = $_POST["IdAsignacion"];
    $Fec1 = date("Y-m-d");
    $Fec2 = date("Y-m-d",strtotime($Fec1."+ 1 days")); ;
    $IdTipoEvaluacion = 1;
  
    #Verificamos que no exista la evaluacion docente
    $sql_evax = $db->query("SELECT tblx_evaluacion.IdEvaluacionX FROM tblx_evaluacion WHERE tblx_evaluacion.IdAsignacion = '$IdAsignacion' AND tblx_evaluacion.Tipo = '2' LIMIT 1");
    $db->rows($sql_evax);
    $_evaxc = $db->recorrer($sql_evax);
    

    if(!isset($_evaxc["IdEvaluacionX"])){
      $sql8 = $db->query("SELECT tblp_asignacion.IdCiclo, tblp_asignacion.IdUsua, tblp_asignacion.IdGrupo, tblp_asignacion.IdModulo, tblp_asignacion.IdEducativa, tblp_asignacion.IdCampus FROM tblp_asignacion WHERE tblp_asignacion.Tipo = '2' AND tblp_asignacion.IdAsignacion = '$IdAsignacion' LIMIT 1");
      $db->rows($sql8);
      $datos81 = $db->recorrer($sql8);
      $IdCampus = $datos81["IdCampus"];
      $IdCiclo = $datos81["IdCiclo"];
      $IdModulo = $datos81["IdModulo"];
      $IdGrupo = $datos81["IdGrupo"];
      $IdEducativa = $datos81["IdEducativa"];
      $IdDocente = $datos81["IdUsua"];
    
      $sqlx = $db->query("SELECT tblp_moduloalumno.IdUsua FROM tblp_moduloalumno WHERE tblp_moduloalumno.IdAsignacion = '$IdAsignacion'");
      while ($x = $db->recorrer($sqlx)) {
        $IdUsua = $x['IdUsua'];
        $insertar = $db->query("INSERT INTO tblx_evaluacion (IdCiclo, IdCampus, IdOferta, IdGrupo, IdUsua, FecCap, IdEstatus, FecIni, FecFin, IdTipo, IdModulo, IdAsignacion, Tipo) VALUES ('$IdCiclo','$IdCampus','$IdEducativa','$IdGrupo','$IdUsua',NOW(),'31','$Fec1','$Fec2','$IdTipoEvaluacion','$IdModulo','$IdAsignacion','2')");
        $Id_eva = $db->insert_id;

        $sql2 = $db->query("SELECT tblx_pregunta.IdPregunta FROM tblx_pregunta WHERE tblx_pregunta.Tipo =  '1' AND tblx_pregunta.Permisos = '2' AND tblx_pregunta.IdEstatus =  '8'");
        while($y = $db->recorrer($sql2)){
          $IdP = $y["IdPregunta"];
            $insertar = $db->query("INSERT INTO tblx_respuesta (IdPregunta,IdDocente,IdEvaluacion,IdGrupo,IdUsua, FecCap,IdOferta,IdCampus,IdAsignacion,IdEstatus,IdModulo, IdCiclo)  VALUES('$IdP','$IdDocente','$Id_eva','$IdGrupo','$IdUsua',NOW(),'$IdEducativa','$IdCampus','$IdAsignacion','8','$IdModulo','$IdCiclo')");
        }
      }
    }

    $insertar = $db->query("UPDATE tblp_calificacion SET tblp_calificacion.IdEstatus = '10' WHERE tblp_calificacion.IdAsignacion = '$IdAsignacion'");
  }


  if ($campo == 1) {
    $_camp = "Fec_emi_bim1";

    // $sql3 = $db->query("SELECT tblp_asignacion.IdEducativa, tblp_asignacion.IdModulo, tblp_asignacion.IdGrupo, tblp_asignacion.IdCiclo FROM tblp_asignacion WHERE tblp_asignacion.IdAsignacion ='$IdAsignacion' AND tblp_asignacion.Tipo = '2'");
    // $db->rows($sql3);
    // $datos31 = $db->recorrer($sql3);
    // $IdEducativa = $datos31["IdEducativa"];
    // $IdGrupo = $datos31["IdGrupo"];
    // $IdModulo = $datos31["IdModulo"];
    // $IdCiclo = $datos31["IdCiclo"];

    // $sql = $db->query("SELECT * FROM tblp_moduloalumno WHERE tblp_moduloalumno.IdAsignacion = '$IdAsignacion'");
    // while ($x = $db->recorrer($sql)) {
    //   $IdUsua = $x["IdUsua"];
    //   $_idModulo = $x["_idModulo"];
    //   if($_idModulo){
    //     $sql_mod = $db->query("SELECT tblp_modulo.IdEducativa FROM tblp_modulo WHERE tblp_modulo.IdModulo = '$_idModulo' ");
    //     $db->rows($sql_mod);
    //     $_mod = $db->recorrer($sql_mod);
    //     $IdEducativa = $_mod["IdEducativa"];
    //     $IdModulo = $_idModulo;
    //   }
      
    //   $sql5 = $db->query("SELECT * FROM tblp_calificacion WHERE tblp_calificacion.IdUsua = '$IdUsua' AND tblp_calificacion.IdOferta = '$IdEducativa' AND tblp_calificacion.IdModulo = '$IdModulo'");
    //   $db->rows($sql5);
    //   $datos51 = $db->recorrer($sql5);
    //   $IdCal = $datos51["IdCalificacion"];

    //   $px = $x["ParcialF1"];
    //   if($px < 6){
    //     $px = 5;
    //   }
    //   if ($px == 0) {
    //     $px_ini = 'NP';
    //     $promx = 'NP';
    //   } else {
    //     $px_ini = round($px, 2);
    //     $promx = round($px, 0, PHP_ROUND_HALF_UP);
    //   }

    //   $insertar = $db->query("UPDATE tblp_moduloalumno SET tblp_moduloalumno.Promedio_final = '$promx', tblp_moduloalumno.Promedio = '$px_ini' WHERE tblp_moduloalumno.IdAsignacion = '$IdAsignacion' AND tblp_moduloalumno.IdUsua = '$IdUsua'");

    //   if ($IdCal) {

    //     $insertar = $db->query("UPDATE tblp_calificacion SET tblp_calificacion.Promedio = '$promx', tblp_calificacion.IdCiclo = '$IdCiclo' WHERE tblp_calificacion.IdUsua = '$IdUsua' AND tblp_calificacion.IdModulo = '$IdModulo' ");
    //   } else {
    //     $sql9 = $db->query("SELECT tblc_usuario.Usuario FROM tblc_usuario WHERE tblc_usuario.IdUsua = '$IdUsua'");
    //     $db->rows($sql9);
    //     $datos91 = $db->recorrer($sql9);
    //     $user = $datos91["Usuario"];
    //     $insertar = $db->query("INSERT INTO tblp_calificacion (IdUsua, Usuario, IdOferta, IdModulo, FecCap, Promedio, IdAsignacion, IdCiclo, IdGrupo, IdTipo, IdEstatus) VALUES ('$IdUsua','$user','$IdEducativa','$IdModulo',NOW(),'$promx','$IdAsignacion','$IdCiclo','$IdGrupo','2','8')");
    //   }
    // }

  }
  if ($campo == 2) {
    $_camp = "Fec_emi_bim2";
  }
  if ($campo == 3) {
    $_camp = "Fec_emi_bim3";
  }
  if ($campo == 4) {
    $insertar = $db->query("UPDATE tblp_calificacion SET tblp_calificacion.IdEstatus = '10' WHERE tblp_calificacion.IdAsignacion = '$IdAsignacion'");
    $_camp = "Fec_extra";
  }

  
  $insertar = $db->query("UPDATE tblp_asignacion SET tblp_asignacion._fecEnvio = NOW(), tblp_asignacion.Salon = '0', tblp_asignacion.$_camp = '$Fecha' WHERE tblp_asignacion.IdAsignacion = '$IdAsignacion'");
  $insertar = $db->query("UPDATE tblp_parcialdocente SET tblp_parcialdocente.IdEstatus = '10' WHERE tblp_parcialdocente.IdAsignacion = '$IdAsignacion' AND tblp_parcialdocente.NoParcial = '$patx' ");

  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "addHoraA") {
  $IdDia = $_POST["IdDia"];
  $IdUsua = $_POST["IdUsua"];
  $Valor = $_POST["Valor"];
  if ($Valor == 1) {
    $insertar = $db->query("INSERT INTO tblk_diasasesor (IdUsua, IdDia, FecCap) VALUES ('$IdUsua','$IdDia',NOW())");
  } else {
    $insertar = $db->query("DELETE FROM tblk_diasasesor WHERE tblk_diasasesor.IdUsua = '$IdUsua' AND tblk_diasasesor.IdDia = '$IdDia' ");
  }

  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "addHoraCi") {
  $IdDia = $_POST["IdDia"];
  $IdCiclo = $_POST["IdCiclo"];
  $IdGrupo = $_POST["IdGrupo"];
  $Valor = $_POST["Valor"];
  if ($Valor == 1) {
    $insertar = $db->query("INSERT INTO tblk_diasciclo (IdCiclo, IdGrupo, IdDia, FecCap) VALUES ('$IdCiclo','$IdGrupo','$IdDia',NOW())");
  } else {
    $insertar = $db->query("DELETE FROM tblk_diasciclo WHERE tblk_diasciclo.IdCiclo = '$IdCiclo' AND tblk_diasciclo.IdDia = '$IdDia' AND tblk_diasciclo.IdGrupo = '$IdGrupo'");
  }

  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "ad_seguimiento_exp") {
  $IdUsua = $_POST["IdUsua"];
  $IdAdmin = $_POST["IdAdmin"];
  $Tipo = $_POST["Tipo"];
  $Seguimiento = $_POST["Seguimiento"];
  $Fecha = $_POST["Fecha"];
  
  $insertar = $db->query("INSERT INTO tblp_expediente_seguimiento (Tipo, Seguimiento, IdUsua, IdAdmin, FecCap, Fecha, Valor) VALUES ('$Tipo','$Seguimiento','$IdUsua','$IdAdmin',NOW(),'$Fecha',0)");

  $db->close();
  echo $insertar;
}


if ($tipoGuardar == "del_docsAlumno") {
  $IdDocs = $_POST["IdDocs"];
  $sql1 = $db->query("SELECT * FROM tblc_docalumnos WHERE tblc_docalumnos.IdDocAlumno = '$IdDocs'");
  $db->rows($sql1);
  $datos11 = $db->recorrer($sql1);
  $anio = $datos11["Anio"];
  $grupo = $datos11["IdGrupo"];
  $archivo = $datos11["Archivo"];

  if ($archivo) {
    $linkD = "../assets/docs/files/$anio/$grupo/$archivo";
    unlink($linkD);
  }
  $insertar = $db->query("DELETE FROM tblc_docalumnos WHERE tblc_docalumnos.IdDocAlumno = '$IdDocs'");


  $db->close();
  echo $insertar;
}


if ($tipoGuardar == "copiar_img_user") {
  $IdDocs = $_POST["IdDocs"];
  if (copy('../assets/docs/files/2022/06/1656081899_acta_nacimiento.pdf', '../assets/nuevo_docs.pdf')) {
    $insertar = 1;
  } else {
    $insertar = 0;
  }
  // $sql1 = $db->query("SELECT * FROM tblc_docalumnos WHERE tblc_docalumnos.IdDocAlumno = '$IdDocs'");
  // $db->rows($sql1);
  // $datos11 = $db->recorrer($sql1);
  // $anio = $datos11["Anio"];
  // $grupo = $datos11["IdGrupo"];
  // $archivo = $datos11["Archivo"];
  //
  // if($archivo) {
  // 	$linkD = "../assets/docs/files/$anio/$grupo/$archivo";
  // 	 unlink($linkD);
  //
  // }
  // $insertar = $db->query("DELETE FROM tblc_docalumnos WHERE tblc_docalumnos.IdDocAlumno = '$IdDocs'");


  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "del_presentacion") {
  $IdSemana = $_POST["IdSemana"];



  $insertar = $db->query("UPDATE tblp_semanadocente SET tblp_semanadocente.Tipo = NULL, tblp_semanadocente.Nombre = NULL, tblp_semanadocente.Code = NULL WHERE tblp_semanadocente.IdSemanaDocente = '$IdSemana' ");


  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "searhOferta") {
  $IdCampus = $_POST['IdCampus'];

  $html = '<option value="">- Seleccione -</option>';
  $sql = $db->query("SELECT tblp_modulo.IdEducativa, tblp_educativa.Nombre FROM tblp_modulo Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_modulo.IdEducativa WHERE tblp_modulo.IdCampus =  '$IdCampus' GROUP BY tblp_modulo.IdEducativa");
  while ($x = $db->recorrer($sql)) {
    $IdOferta = $x["IdEducativa"];
    $Nombre = $x["Nombre"];
    $html .= '<option value="' . $IdOferta . '">' . $Nombre . '</option>';
  }
  if ($html == '<option value="">- Seleccione -</option>') $html = '<option value=""> - Seleccione -</option>';
  echo $html;
}

if ($tipoGuardar == "savExtra") {
  $IdUsua = $_POST["IdUsua"];
  $IdModA = $_POST["IdModA"];
  $IdAsignacion = $_POST["IdAsignacion"];
  $Calif = $_POST["Calif"];
  $Extra = $_POST["Extra"];

  $sql3 = $db->query("SELECT tblp_asignacion.IdEducativa, tblp_asignacion.IdModulo, tblp_asignacion.IdGrupo, tblp_asignacion.IdCiclo FROM tblp_asignacion WHERE tblp_asignacion.IdAsignacion ='$IdAsignacion' AND tblp_asignacion.Tipo = '2'");
  $db->rows($sql3);
  $datos31 = $db->recorrer($sql3);
  $IdEducativa = $datos31["IdEducativa"];
  $IdModulo = $datos31["IdModulo"];
  $IdCiclo = $datos31["IdCiclo"];
  $IdGrupo = $datos31["IdGrupo"];


  $sql5 = $db->query("SELECT * FROM tblp_calificacion WHERE tblp_calificacion.IdUsua = '$IdUsua' AND tblp_calificacion.IdAsignacion = '$IdAsignacion' ");
  $db->rows($sql5);
  $datos51 = $db->recorrer($sql5);
  $IdCal = $datos51["IdCalificacion"];

  $insertar = $db->query("UPDATE tblp_moduloalumno SET tblp_moduloalumno.E$Extra = '$Calif' WHERE tblp_moduloalumno.IdUsua = '$IdUsua' AND tblp_moduloalumno.IdAsignacion = '$IdAsignacion'");

  $insertar = $db->query("UPDATE tblp_calificacion SET tblp_calificacion.E$Extra = '$Calif', tblp_calificacion._obs = 'E', tblp_calificacion.Promedio = '$Calif' WHERE tblp_calificacion.IdUsua = '$IdUsua' AND tblp_calificacion.IdAsignacion = '$IdAsignacion' AND tblp_calificacion.IdModulo = '$IdModulo' ");

  $n = 0;
  $val = 0;
  $_bxa = '';
  $_bxb = '';
  $_bxc = '';
  $sql = $db->query("SELECT tblp_calificacion.IdCalificacion, tblp_calificacion.E1, tblp_modulo.Code FROM tblp_calificacion Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_calificacion.IdModulo WHERE tblp_calificacion.IdUsua = '$IdUsua' AND tblp_calificacion.IdGrupo = '$IdGrupo' AND tblp_calificacion.IdCiclo = '$IdCiclo' AND tblp_calificacion.E1 IS NOT NULL ORDER BY tblp_modulo.CodeModulo ASC ");
  while ($x = $db->recorrer($sql)) {
    $n = ($n + 1);
    $_cod = $x["Code"];
    $_e1 = $x["E1"];
    $val = substr($_cod, -1);
    if ($n == 1) {
      if ($val == 1) {
        $_bxa = "A-" . $_e1;
      }
      if ($val == 2) {
        $_bxa = "B-" . $_e1;
      }
      if ($val == 3) {
        $_bxa = "C-" . $_e1;
      }
      if ($val == 4) {
        $_bxa = "D-" . $_e1;
      }
      if ($val == 5) {
        $_bxa = "E-" . $_e1;
      }
      if ($val == 6) {
        $_bxa = "F-" . $_e1;
      }
      if ($val == 7) {
        $_bxa = "G-" . $_e1;
      }
      if ($val == 8) {
        $_bxa = "H-" . $_e1;
      }
      if ($val == 9) {
        $_bxa = "I-" . $_e1;
      }
    }
    if ($n == 2) {
      if ($val == 1) {
        $_bxb = "A-" . $_e1;
      }
      if ($val == 2) {
        $_bxb = "B-" . $_e1;
      }
      if ($val == 3) {
        $_bxb = "C-" . $_e1;
      }
      if ($val == 4) {
        $_bxb = "D-" . $_e1;
      }
      if ($val == 5) {
        $_bxb = "E-" . $_e1;
      }
      if ($val == 6) {
        $_bxb = "F-" . $_e1;
      }
      if ($val == 7) {
        $_bxb = "G-" . $_e1;
      }
      if ($val == 8) {
        $_bxb = "H-" . $_e1;
      }
      if ($val == 9) {
        $_bxb = "I-" . $_e1;
      }
    }
    if ($n == 3) {
      if ($val == 1) {
        $_bxc = "A-" . $_e1;
      }
      if ($val == 2) {
        $_bxc = "B-" . $_e1;
      }
      if ($val == 3) {
        $_bxc = "C-" . $_e1;
      }
      if ($val == 4) {
        $_bxc = "D-" . $_e1;
      }
      if ($val == 5) {
        $_bxc = "E-" . $_e1;
      }
      if ($val == 6) {
        $_bxc = "F-" . $_e1;
      }
      if ($val == 7) {
        $_bxc = "G-" . $_e1;
      }
      if ($val == 8) {
        $_bxc = "H-" . $_e1;
      }
      if ($val == 9) {
        $_bxc = "I-" . $_e1;
      }
    }
  }

  $insertar = $db->query("UPDATE tblp_calificacion SET tblp_calificacion._A = '$_bxa', tblp_calificacion._B = '$_bxb', tblp_calificacion._C = '$_bxc' WHERE tblp_calificacion.IdUsua = '$IdUsua' AND tblp_calificacion.IdCiclo = '$IdCiclo' ");

  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "configModEsp") {
  $IdMenu = $_POST["IdMenu"];
  $IdUsua = $_POST["IdUsua"];
  $Movimiento = $_POST["Movimiento"];
  if ($Movimiento == 1) {
    $insertar = $db->query("INSERT INTO tblc_modulousuario (IdModulo,IdUsua, FecCap) VALUES('$IdMenu','$IdUsua', NOW())");
  } else {
    $insertar = $db->query("DELETE FROM tblc_modulousuario WHERE tblc_modulousuario.IdModulo = '$IdMenu' AND tblc_modulousuario.IdUsua = '$IdUsua'");
  }
  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "savProsCicl") {
  $IdProspecto = $_POST["IdProspecto"];
  $IdCiclo = $_POST["IdCiclo"];
  $IdAdmin = $_POST["IdAdmin"];

  $sql_ofx = $db->query("SELECT tblc_usuario.IdGrupo, tblp_educativa.IdEducativa, tblp_educativa.IdGrado FROM tblc_usuario Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario.IdOferta WHERE tblc_usuario.IdUsua =  '$IdProspecto'");
  $db->rows($sql_ofx);
  $_fx = $db->recorrer($sql_ofx);
  $_idGra = $_fx['IdGrado'];
  $_idGrupo = $_fx['IdGrupo'];
  $_idEducativa = $_fx['IdEducativa'];

  $insertar = $db->query("UPDATE tblc_docalumnos SET tblc_docalumnos.IdCiclo = '$IdCiclo' WHERE tblc_docalumnos.IdUsua = '$IdProspecto' ");
  $bxP = 0;
  $sql_bex = $db->query("SELECT tblp_beca.IdBeca FROM tblp_beca WHERE tblp_beca.IdUsua =  '$IdProspecto' AND tblp_beca.IdCiclo = '$IdCiclo' ");
  $db->rows($sql_bex);
  $_bex = $db->recorrer($sql_bex);
  $_idBex = $_bex['IdBeca'];
  $porc = 0;
  if (!$_idBex) {
    if ($_idGra == 1) {
      $porc = 60;
      $bxP = 1;
    }
    if ($_idGra == 2) {
      $porc = 75;
      $bxP = 1;
    }
    if ($_idGra == 3) {
      if (($_idEducativa == 6) || ($_idEducativa == 13)) {
        $porc = 50;
        $bxP = 1;
      } else {
        $porc = 0;
        $bxP = 0;
      }
    }
    if ($bxP == 1) {
      $insertar = $db->query("INSERT INTO tblp_beca (IdUsua, IdConcepto, Porcentaje, FecCap, IdUsuaCap, IdEstatus, IdConvenio, IdCiclo) VALUES ('$IdProspecto','2','$porc',NOW(),'$IdAdmin','8','$_idGra','$IdCiclo')");
    }
  }

  $sql_docs = $db->query("SELECT tblc_docalumnos.IdDocAlumno FROM tblc_docalumnos WHERE tblc_docalumnos.IdUsua =  '$IdProspecto' AND tblc_docalumnos.IdCiclo = '$IdCiclo' ");
  $db->rows($sql_docs);
  $_docs = $db->recorrer($sql_docs);
  $_docsx = $_docs['IdDocAlumno'];
  if (!$_docsx) {
    $insertar = $db->query("INSERT INTO tblc_docalumnos (IdUsua, IdTipoDocumento, Estatus, IdGrupo, IdCiclo, Doc) VALUES ('$IdProspecto','103','1','$_idGrupo','$IdCiclo','T') ");
    if ($bxP == 1) {
      $insertar = $db->query("INSERT INTO tblc_docalumnos (IdUsua, IdTipoDocumento, Estatus, IdGrupo, IdCiclo, Doc) VALUES ('$IdProspecto','105','1','$_idGrupo','$IdCiclo','T') ");
    }
  }

  $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.Grado = '$_idGra', tblc_usuario.id_ciclo_ini = '$IdCiclo' WHERE tblc_usuario.IdUsua = '$IdProspecto' ");


  $db->close();
  echo $insertar;
}



if ($tipoGuardar == "savNewUsuario") {
  $IdUsua = $_POST["IdProspecto"];
  $IdGrupo = $_POST["IdGrupo"];
  $Tipo = $_POST["Tipo"];

  $sql8 = $db->query("SELECT * FROM tblc_usuario WHERE  tblc_usuario.IdUsua = '$IdUsua'");
  $db->rows($sql8);
  $datos81 = $db->recorrer($sql8);
  $Nombre = $datos81["Nombre"];
  $destinatario = $datos81["Correo"];
  $Paterno = $datos81["APaterno"];
  $Materno = $datos81["AMaterno"];
  $idCam = $datos81["IdCampus"];
  $IdOferta = $datos81["IdOferta"];
  $IdCiclo = $datos81["id_ciclo_ini"];

  $sql_plan = $db->query("SELECT tblp_educativa.IdGrado FROM tblp_educativa WHERE tblp_educativa.IdEducativa = '$IdOferta'");
  $db->rows($sql_plan);
  $_gradx = $db->recorrer($sql_plan);
  $IdGrado = $_gradx["IdGrado"];

  $sql_cic = $db->query("SELECT * FROM tblc_ciclo WHERE tblc_ciclo.IdCiclo = '$IdCiclo'");
  $db->rows($sql_cic);
  $_cic = $db->recorrer($sql_cic);
  $codeCiclo = $_cic["Valor"];

  $sql_camp = $db->query("SELECT * FROM tblc_campus WHERE tblc_campus.IdCampus = '$idCam'");
  $db->rows($sql_camp);
  $_camp = $db->recorrer($sql_camp);
  $url = $_camp["Link"];
  $codeSede = $_camp["codeSede"];

  $sql_grp = $db->query("SELECT * FROM tblp_grupo WHERE tblp_grupo.IdGrupo = '$IdGrupo'");
  $db->rows($sql_grp);
  $_grp = $db->recorrer($sql_grp);
  $_grpAnio = $_grp["Anio"];

  $sql_mat = $db->query("SELECT * FROM tblc_matricula WHERE tblc_matricula.Anio = '$_grpAnio' ORDER BY tblc_matricula.Numero DESC");
  $db->rows($sql_mat);
  $_mat = $db->recorrer($sql_mat);
  $_num = $_mat["Numero"] + 1;
  $code = str_pad($_num, 4, "0", STR_PAD_LEFT);
  $matricula = $_grpAnio . $codeCiclo . $codeSede . $code;

  $insertar = $db->query("INSERT INTO tblc_matricula (Anio, Numero, Matricula, IdUsua, IdOferta, IdGrupo, FecCap)  VALUES ('$_grpAnio','$_num','$matricula','$IdUsua','$IdOferta','$IdGrupo',NOW())");

  $nombre = htmlentities($Nombre . ' ' . $Paterno . ' ' . $Materno);

  $anio = date("Y");
  $anioo = substr($anio, 2, 2);

  $matCom = '';

  $permisos = 3;
  $tipo = "Alumno";
  $pass = "iudy";
  $code = $pass;
  $pass_php = Password::hash($pass);
  $correoInst = $matricula . "@iudysureste.com";

  $Dia = 'R';

  $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.Correo_institucional = '$correoInst', tblc_usuario.Pass_php = '$pass_php', tblc_usuario.Code = '$pass', tblc_usuario.IdGrupo = '$IdGrupo', tblc_usuario.Usuario = '$matricula', tblc_usuario.Matricula = '$matricula', tblc_usuario.IdEstatus = '8' WHERE tblc_usuario.IdUsua = '$IdUsua' ");
  if($Tipo == "R"){
    $Dia = 'R';
    $sql = $db->query("SELECT tblp_asignacion.IdAsignacion, tblp_asignacion.IdEducativa, tblp_asignacion.IdModulo, tblp_asignacion.Grupo FROM tblp_asignacion WHERE  tblp_asignacion.IdGrupo = '$IdGrupo' AND tblp_asignacion.Tipo = '2'");
    while ($x = $db->recorrer($sql)) {
      $IdOferta = $x["IdEducativa"];
      $IdMod = $x["IdModulo"];
      $IdAsig = $x["IdAsignacion"];
      $Grp = $x["Grupo"];
      $insertar = $db->query("INSERT INTO tblp_moduloalumno (IdEducativa, IdModulo, Grupo, IdUsua, Estatus, FecCap, IdAsignacion, IdGrupo) VALUES ('$IdOferta','$IdMod','$Grp',$IdUsua,'Activo',NOW(),'$IdAsig','$IdGrupo')");
    }

    $sql2 = $db->query("SELECT tblp_asignacion.IdAsignacion, tblp_tareas.IdTarea, tblp_tareas.IdParcialDocente, tblp_tareas.IdActividadesDocente FROM tblp_asignacion Left Join tblp_tareas ON tblp_tareas.IdAsignacion = tblp_asignacion.IdAsignacion WHERE tblp_asignacion.IdGrupo = '$IdGrupo' AND tblp_asignacion.Tipo =  '2' GROUP BY tblp_tareas.IdActividadesDocente");
    while ($x = $db->recorrer($sql2)) {
      $IdAsignacion = $x["IdAsignacion"];
      $IdParcialDocente = $x["IdParcialDocente"];
      $IdActividadesDocente = $x["IdActividadesDocente"];
      $insertar = $db->query("INSERT INTO tblp_tareas (IdAsignacion, IdAlumno, IdActividadesDocente, IdParcialDocente) VALUES ('$IdAsignacion','$IdUsua','$IdActividadesDocente','$IdParcialDocente')");
    }
  } else {
    $Dia = 'P';
    $insertar = $db->query("INSERT INTO tblp_personalizado (IdUsua, IdCiclo, IdOferta, FecCap) VALUES ('$IdUsua','$IdCiclo','$IdOferta',NOW())");
    $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario._horario = 'P' WHERE tblc_usuario.IdUsua = '$IdUsua' ");
  }

  if($Dia == 'P'){
    $_diax1 = ",Horario";
    $_diax2 = ",'P'";

    $sql_alumno = $db->query("SELECT * FROM tblc_alumnos WHERE tblc_alumnos.IdUsua = '$IdUsua' AND tblc_alumnos.IdCiclo = '$IdCiclo' ");
    $db->rows($sql_alumno);
    $_alumno = $db->recorrer($sql_alumno);
    if(!isset($_alumno['IdActivo'])){
        $insertar = $db->query("INSERT INTO tblc_alumnos (IdGrupo, IdCiclo, IdUsua, Grado, Tipo, IdEstatus, FecCap, Valor, Horario) VALUES('$IdGrupo','$IdCiclo','$IdUsua','0','R','8',NOW(),1,'P')"); 
    }

  } else{
    $_diax1 = "";
    $_diax2 = "";
  }

  $sql_mig = $db->query("SELECT * FROM tblc_ciclogrupo WHERE tblc_ciclogrupo.IdEstatus = '8' AND tblc_ciclogrupo.IdCiclo = '$IdCiclo' AND tblc_ciclogrupo.IdGrupo = '$IdGrupo'");
  $db->rows($sql_mig);
  $_migr = $db->recorrer($sql_mig);
  if(!isset($_alumno["IdCicloGrupo"])){
    $insertarx = $db->query("INSERT INTO tblc_alumnos (IdGrupo, IdCiclo, IdUsua, Grado, Tipo, IdEstatus, FecCap, Valor $_diax1)  VALUES ('$IdGrupo','$IdCiclo','$IdUsua',1,'R',8,NOW(),1 $_diax2)");  
  }

  // $sql_mig = $db->query("SELECT * FROM tblc_alumnos WHERE tblc_alumnos.IdCiclo = '$IdCiclo' AND tblc_alumnos.IdGrupo = '$IdGrupo'");
  // $db->rows($sql_mig);
  // $_migr = $db->recorrer($sql_mig);
  // if(isset($_migr["IdActivo"])){
  //   $sql_alum = $db->query("SELECT * FROM tblc_alumnos WHERE tblc_alumnos.IdUsua = '$IdUsua' AND  tblc_alumnos.IdGrupo = '$IdGrupo' AND tblc_alumnos.IdCiclo = '$IdCiclo' ");
  //   $db->rows($sql_alum);
  //   $_alumno = $db->recorrer($sql_alum);
  //   if(!isset($_alumno["IdActivo"])){

  //     $insertarx = $db->query("INSERT INTO tblc_alumnos (IdGrupo, IdCiclo, IdUsua, Grado, Tipo, IdEstatus, FecCap, Valor $_diax1)  VALUES ('$IdGrupo','$IdCiclo','$IdUsua',1,'R',8,NOW(),1 $_diax2)");  
  //   }
  // }


  $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.Grado = '$IdGrado', tblc_usuario.SemCua = '1', tblc_usuario.IdEstatus = '8' WHERE tblc_usuario.IdUsua = '$IdUsua'");
  $insertarx = $db->query("UPDATE tblp_pagos SET tblp_pagos.IdGrupo = '$IdGrupo' WHERE tblp_pagos.IdUsua = '$IdUsua'");

  $asunto = 'Acceso a la Plataforma IUDY';
  $sub_titulo = "Datos para ingresar a la Plataforma IUDY";
  $nom_plataforma = "Plataforma IUDY";



  $cuerpo = "<table style='border-collapse:collapse;height:100%;margin:0;padding:0;width:100%;background-color:#f2f4fc' width='100%' height='100%' cellspacing='0' cellpadding='0' border='0' align='center'>
          <tbody><tr>
              <td style='height:100%;margin:0;padding:10px;width:100%;border-top:0' valign='top' align='center'>
                  <table style='border-collapse:collapse;border:0;max-width:600px!important' width='100%' cellspacing='0' cellpadding='0' border='0'>
                      <tbody><tr>
                          <td style='background:#000f33; color:#fff; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif; padding:10px' valign='top'>$sub_titulo</td>
                      </tr>
                      <tr>
                          <td style='background:#ffffff;' valign='top'>
                          <table style='min-width:100%;border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0'>
                              <tbody>
                                  <tr>
                                      <td style='padding-top:9px' valign='top'>
                                          <table style='max-width:100%;min-width:100%;border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0' align='left'>
                                              <tbody>
                                                <tr>
                                                    <td style='padding-top:0;padding-right:18px;padding-bottom:9px;padding-left:18px;word-break:break-word;color:black; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif; font-size:12px;line-height:150%;text-align:left;' valign='top'>
                                                        <div>
                                                          <b>$nombre</b> <br></br>
                                                          Ahora ya  puede ingresar a la $nom_plataforma, para conocer tu Plataforma Educativa, con los siguientes datos:<br><br>
                                                          <b>Usuario: </b> $destinatario <br>
                                                          <b>Password: </b> iudy <br><br><br>

                                                          <b>Recomendaciones:</b><br>
                                                          - Deber&aacute; dar clic del lado superior derecho sobre tu nombre, despues en el bot&oacute;n de <b>Mi espacio</b>.<br>
                                                          - Revisar el m&oacute;dulo de tr&aacute;mites escolares.<br>
                                                          - Actualizar sus datos personales para generar su c&eacute;dula de inscripci&oacute;n.<br>
                                                          - Subir documentos solicitados por la Instituci&oacute;n. <br>
                                                          - Revisar su estatus financiero, realizar el pago correspondiente y subir su comprobante de pago.<br>

                                                          <br>

                                                          </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style='font-size:12px; line-height:17px;font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif; font-weight:600; ' height='80' align='center'>
                                                      <a href='$url' style='color:inherit;text-decoration:none;text-align:center;display:inline-block; background: #525fff; border-radius: 25px; padding: 8px; color: white;' target='_blank'> &nbsp;&nbsp;&nbsp;&nbsp; Ir a la Plataforma &nbsp;&nbsp;&nbsp;&nbsp; </a>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td style='background: #d5d3d0; padding-top:5px; padding-right:18px; padding-bottom:5px;padding-left:18px;word-break:break-word;color:black; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif; font-size:12px;line-height:150%;text-align:center' valign='top'>
                                                        <div>Todos los derechos reservados.<br><b>$nom_plataforma</b></div>
                                                    </td>
                                                </tr>

                                          </tbody></table>
                                      </td>
                                  </tr>
                              </tbody>
                          </table></td>
                      </tr>
                  </tbody></table>
              </td>
          </tr>
      </tbody></table>";

  $headers = "MIME-Version: 1.0\r\n";
  $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
  $headers .= "From: $nom_plataforma <info@mwcomenius.com.mx>\r\n";
  $headers .= "Bcc: pedroo.goca@gmail.com\r\n";

  mail($destinatario, $asunto, $cuerpo, $headers);


  echo $insertarx;
}

if ($tipoGuardar == "declinar_docs") {
  $IdUsua = $_POST["IdUsua"];
  $IdDocumento = $_POST["IdDocumento"];

  $insertar = $db->query("UPDATE tblp_docs_solicitados SET tblp_docs_solicitados.IdEstatus = '1', tblp_docs_solicitados.IdDeclinar = '$IdUsua' WHERE tblp_docs_solicitados.IdDocumento = '$IdDocumento' ");

  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "close_ventana") {
  $IdUsua = $_POST["IdUsua"];

  $insertar = $db->query("UPDATE tblp_docs_solicitados SET tblp_docs_solicitados.IdVisto = '$IdUsua' WHERE tblp_docs_solicitados.IdEstatus = '3' ");

  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "gePagoNew") {
  $IdGrado = $_POST["IdGrado"];
  $IdConceptoPlan = $_POST["IdConcepto"];
  $IdCiclo = $_POST["IdCiclo"];
  $_Fecha = $_POST["Fecha"];
  $IdUsua = $_POST["IdUsua"];
  $NoPagos = $_POST["NoPagos"];
  $IdCampus = $_POST["IdCampus"];

  $sql8 = $db->query("SELECT tblc_conceptosplanes.Costo FROM tblc_conceptosplanes WHERE  tblc_conceptosplanes.IdConceptoPlanes = '$IdConceptoPlan'");
  $db->rows($sql8);
  $datos81 = $db->recorrer($sql8);
  $Monto = $datos81["Costo"];

  for ($i = 0; $i < $NoPagos; $i++) {
    $Fecha =  date("Y-m-d", strtotime($_Fecha . "+ $i month"));
    $insertar = $db->query("INSERT INTO tblp_calendario (IdGrado, IdConceptosPlanes, FecDescuento, FecBase, FecLimite, Monto, IdUsua, FecCap, IdEstatus, IdCiclo, IdCampus) VALUES ('$IdGrado','$IdConceptoPlan','$Fecha','$Fecha','$Fecha','$Monto','$IdUsua',NOW(),'32','$IdCiclo','$IdCampus') ");
  }
  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "sav_encuesta") {
  $IdAsignacion = $_POST["IdAsignacion"];
  $Fec1 = $_POST["Fec1"];
  $Fec2 = $_POST["Fec2"];
  $IdTipoEvaluacion = $_POST["IdTipoEvaluacion"];


  $sql8 = $db->query("SELECT tblp_asignacion.IdCiclo, tblp_asignacion.IdGrupo, tblp_asignacion.IdModulo, tblp_asignacion.IdEducativa, tblp_asignacion.IdCampus FROM tblp_asignacion WHERE  tblp_asignacion.IdAsignacion = '$IdAsignacion' LIMIT 1");
  $db->rows($sql8);
  $datos81 = $db->recorrer($sql8);
  $IdCampus = $datos81["IdCampus"];
  $IdCiclo = $datos81["IdCiclo"];
  $IdModulo = $datos81["IdModulo"];
  $IdGrupo = $datos81["IdGrupo"];
  $IdEducativa = $datos81["IdEducativa"];

  $sqlx = $db->query("SELECT tblp_moduloalumno.IdUsua FROM tblp_moduloalumno WHERE tblp_moduloalumno.IdAsignacion = '$IdAsignacion'");
  while ($x = $db->recorrer($sqlx)) {
    $IdUsua = $x['IdUsua'];
    $insertar = $db->query("INSERT INTO tblx_evaluacion (IdCiclo, IdCampus, IdOferta, IdGrupo, IdUsua, FecCap, IdEstatus, FecIni, FecFin, IdTipo, IdModulo, IdAsignacion) VALUES ('$IdCiclo','$IdCampus','$IdEducativa','$IdGrupo','$IdUsua',NOW(),'31','$Fec1','$Fec2','$IdTipoEvaluacion','$IdModulo','$IdAsignacion')");
  }

  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "sav_encuesta_modx") {
  $IdCampus = $_POST["IdCampus"];
  $Ini = $_POST["Ini"];
  $Fin = $_POST["Fin"];
  $Tipo = $_POST["Tipo"];
  $IdGrupo = $_POST["IdGrupo"];
  $IdCiclo = $_POST["IdCiclo"];

  $caracteres_permitidos = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $longitud = 10;
  $IdAsig =  substr(str_shuffle($caracteres_permitidos), 0, $longitud);

  $sql9 = $db->query("SELECT tblp_grupo.IdOferta FROM tblp_grupo WHERE tblp_grupo.IdGrupo = '$IdGrupo'");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);
  $IdOferta = $datos91['IdOferta'];

  $sqlx = $db->query("SELECT tblc_usuario.IdUsua FROM tblc_usuario WHERE tblc_usuario.IdGrupo = '$IdGrupo' AND tblc_usuario.IdEstatus = '8'");
  while ($x = $db->recorrer($sqlx)) {
    $IdUsua = $x['IdUsua'];
    $insertar = $db->query("INSERT INTO tblx_evaluacion (IdCiclo, IdCampus, IdOferta, IdGrupo, IdUsua, FecCap, IdEstatus, FecIni, FecFin, IdTipo, IdAsignacion) VALUES ('$IdCiclo','$IdCampus','$IdOferta','$IdGrupo','$IdUsua',NOW(),'31','$Ini','$Fin','$Tipo','$IdAsig')");
  }

  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "sav_gastosy") {
  $IdUsua = $_POST["IdUsua"];
  $IdPermiso = $_POST["IdPermiso"];
  $IdConcepto = $_POST["IdConcepto"];
  $IdConcepto2 = $_POST["IdConcepto2"];
  $Fecha = $_POST["Fecha"];
  $Cheque = $_POST["Cheque"];
  $Factura = $_POST["Factura"];
  $Importe = $_POST["Importe"];
  $Partida = $_POST["Partida"];
  $Beneficiario = $_POST["Beneficiario"];
  $Descripcion = $_POST["Descripcion"];
  $Forma = $_POST["Forma"];
  $IdBanco = 2;
  $IdCampus = 1;
  $anio = substr($Fecha, 0, 4);
  $mes = substr($Fecha, 5, 2);
  $aniomes = $anio . '-' . $mes;

  if ($IdConcepto == '21') {
    $idEstatus = 10;
    $tipo = 2;
  } else {
    $idEstatus = 8;
    $tipo = 1;
  }

  $insertar = $db->query("INSERT INTO tblp_gastos (IdConcepto, IdGasto2, Fecha, IdBanco, Factura, Importe, Beneficiario, FecCap, IdUsuaCap, Anio, AnioMes, IdCampus, Cheque, Partida,Descripcion, Valor, IdEstatus, Forma) VALUES ('$IdConcepto','$IdConcepto2','$Fecha','$IdBanco','$Factura','$Importe','$Beneficiario',NOW(),'$IdUsua','$anio','$aniomes','$IdCampus','$Cheque','$Partida','$Descripcion','$tipo','$idEstatus', '$Forma')");
  $idGasto = $db->insert_id;
  $db->close();
  if ($insertar) {
    echo $idGasto;
  } else {
    echo 0;
  }
}

if ($tipoGuardar == "upd_gastos_id") {
  $IdUsua = $_POST["IdUsua"];
  $IdGasto = $_POST["IdGasto"];
  $Fecha = $_POST["Fecha"];
  $Cheque = $_POST["Cheque"];
  $Factura = $_POST["Factura"];
  $Partida = $_POST["Partida"];
  $Beneficiario = $_POST["Beneficiario"];
  $Descripcion = $_POST["Descripcion"];


  $insertar = $db->query("UPDATE tblp_gastos SET tblp_gastos.Fecha = '$Fecha', tblp_gastos.Factura = '$Factura', tblp_gastos.Beneficiario = '$Beneficiario', tblp_gastos.Cheque = '$Cheque', tblp_gastos.Partida = '$Partida', tblp_gastos.Descripcion = '$Descripcion' WHERE tblp_gastos.IdGasto = '$IdGasto' ");

  $db->close();
  if ($insertar) {
    echo 1;
  } else {
    echo 0;
  }
}

if ($tipoGuardar == "cancel_xgastos_id") {
  $IdGasto = $_POST["IdGasto"];
  $IdCancelar = $_POST["IdCancelar"];

  $insertar = $db->query("UPDATE tblp_gastos_detalle SET tblp_gastos_detalle.Monto = '0' WHERE tblp_gastos_detalle.IdGasto = '$IdGasto' ");
  $insertar = $db->query("UPDATE tblp_gastos SET tblp_gastos.IdMotivo = '$IdCancelar', tblp_gastos.IdEstatus = '10', tblp_gastos.Importe = '0' WHERE tblp_gastos.IdGasto = '$IdGasto' ");

  $db->close();
  if ($insertar) {
    echo 1;
  } else {
    echo 0;
  }
}

if ($tipoGuardar == "aviso_visto") {
  $IdDetalle = $_POST["IdDetalle"];

  $insertar = $db->query("UPDATE tbla_aviso_detalle SET tbla_aviso_detalle.Fec_visto = NOW() WHERE tbla_aviso_detalle.IdDetalle = '$IdDetalle' ");
  $db->close();
}

if ($tipoGuardar == "aviso_visto_check") {
  $IdDetalle = $_POST["IdDetalle"];

  $insertar = $db->query("UPDATE tbla_aviso_detalle SET tbla_aviso_detalle.IdEstatus = '10', tbla_aviso_detalle.Fec_aceptado = NOW() WHERE tbla_aviso_detalle.IdDetalle = '$IdDetalle' ");
  $db->close();
}

if ($tipoGuardar == "generar_consta_idx") {
  $IdDocumento = $_POST["IdDocumento"];
  $IdCiclo = $_POST["IdCiclo"];
  $Grado = $_POST["Grado"];
  $IdVisto = $_POST["IdVisto"];

  $insertar = $db->query("UPDATE tblp_docs_solicitados SET tblp_docs_solicitados.IdVisto = '$IdVisto', tblp_docs_solicitados.IdCiclo = '$IdCiclo', tblp_docs_solicitados.Grado = '$Grado' WHERE tblp_docs_solicitados.IdDocumento =  '$IdDocumento' ");


  // $sql4 = $db->query("SELECT tblp_pagos.IdGrupo, tblp_pagos.IdCiclo, tblp_pagos.IdOferta, tblp_pagos.IdUsua, tblp_pagos.IdCampus FROM tblp_pagos WHERE tblp_pagos.IdPago =  '$IdPago' ");
  // $db->rows($sql4);
  // $datos41 = $db->recorrer($sql4);
  // $IdCampus = $datos41["IdCampus"];
  // $IdOferta = $datos41["IdOferta"];
  // $IdCiclo = $datos41["IdCiclo"];
  // $IdGrupo = $datos41["IdGrupo"];
  // $IdUsua = $datos41["IdUsua"];
  // $fecha_actual = date("Y-m-d");
  // $anio = date("Y");
  // $mes = date("m");

  // $fch_ = date("Y-m-d", strtotime($fecha_actual . "+ 5 days"));

  // $caracteres_permitidos = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  // $longitud = 20;
  // $cad =  substr(str_shuffle($caracteres_permitidos), 0, $longitud);

  // $insertar = $db->query("INSERT INTO tblp_docs_solicitados (IdPago,IdEstatus,IdCampus,IdUsua,IdOferta,IdCiclo,IdGrupo,FecCap,Anio,Mes,Fecha,FecLimite,qrCode) VALUES ('$IdPago','1','$IdCampus','$IdUsua','$IdOferta','$IdCiclo','$IdGrupo',NOW(),'$anio','$mes','$fecha_actual','$fch_','$cad')");

  // require '../assets/qrcode/qrlib.php';
  // $dir = '../assets/images/qr/' . $anio . '/' . $mes . '/';

  // if (!file_exists($dir))
  //   mkdir($dir);

  // $sql_camp = $db->query("SELECT * FROM tblc_campus WHERE tblc_campus.IdCampus = '$IdCampus'");
  // $db->rows($sql_camp);
  // $_camp = $db->recorrer($sql_camp);
  // $url = $_camp["Link"];

  // $filename = $dir . $cad . '.png';
  // $IdToks = $cad;
  // $tamanio = 10;
  // $level = 'M';
  // $frameSize = 3;

  // $contenido = $url . 'validar_constancia.php?idToks=' . $IdToks;

  // QRCode::png($contenido, $filename, $level, $tamanio, $frameSize);
  if ($insertar) {
    echo $insertar;
  } else {
    echo 0;
  }
  $db->close();
}

if ($tipoGuardar == "sav_gasto_docsx") {
  $IdUsua = $_POST["IdUsua"];
  $IdAsignacion = $_POST["IdAsig"];
  $Fecha = $_POST["Fecha"];
  $Cheque = $_POST["Cheque"];
  $Factura = $_POST["Factura"];
  $Importe = $_POST["Importe"];
  $Partida = $_POST["Partida"];
  $Forma = $_POST["Forma"];
  $Descripcion = $_POST["Descripcion"];

  $IdCampus = 1;
  $anio = substr($Fecha, 0, 4);
  $mes = substr($Fecha, 5, 2);
  $aniomes = $anio . '-' . $mes;
  $IdBanco = 2;
  $IdConcepto = 1;
  $IdConcepto2 = 1;

  $sql9 = $db->query("SELECT tblp_asignacion.IdAsignacion, tblp_educativa.IdGrado, tblp_asignacion.IdEducativa, tblp_asignacion.IdUsua, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblp_modulo.CodeModulo, tblp_modulo.NombreMod FROM tblp_asignacion Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_asignacion.IdUsua Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_asignacion.IdEducativa WHERE tblp_asignacion.Id =  '$IdAsignacion'");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);
  $_idAsignacion = $datos91['IdAsignacion'];
  $_idGrado = $datos91['IdGrado'];
  $_idOferta = $datos91['IdEducativa'];
  $_idUsua = $datos91['IdUsua'];
  $_nombre = $datos91['Nombre'] . ' ' . $datos91['APaterno'] . ' ' . $datos91['AMaterno'];
  $_modulo = $datos91['CodeModulo'] . ' ' . $datos91['NombreMod'];

  $anexo = $_nombre . '_' . $_modulo . '_' . $_idUsua . '_' . $_idUsua;
  $Beneficiario = $_nombre;

  $insertar = $db->query("INSERT INTO tblp_gastos (Forma, IdConcepto, IdGasto2, Fecha, IdBanco, Factura, Importe, Beneficiario, FecCap, IdUsuaCap, Anio, AnioMes, IdCampus, Anexo, Valor, Cheque, Partida, Descripcion) VALUES ('$Forma','$IdConcepto','$IdConcepto2','$Fecha','$IdBanco','$Factura','$Importe','$Beneficiario',NOW(),'$IdUsua','$anio','$aniomes','$IdCampus','$anexo',2,'$Cheque','$Partida','$Descripcion')");

  $idGasto = $db->insert_id;
  $insertar = $db->query("INSERT INTO tblp_gastos_detalle (IdGasto, IdOferta, Monto, FecCap, IdGrado) VALUES ('$idGasto','$_idOferta','$Importe',NOW(),'$_idGrado')");
  $insertar = $db->query("UPDATE tblp_asignacion SET tblp_asignacion._idEstatus = '60', tblp_asignacion._fecPago = '$Fecha', tblp_asignacion._monto = '$Importe', tblp_asignacion._fecCap = NOW(), tblp_asignacion._idGasto = '$idGasto' WHERE tblp_asignacion.IdAsignacion = '$_idAsignacion'");

  $db->close();
  if ($insertar) {
    echo $idGasto;
  } else {
    echo 0;
  }
}

if ($tipoGuardar == "gen_pag_plans") {
  $IdGasto = $_POST["IdGasto"];
  $IdGrado = $_POST["IdGrado"];
  $Tipo = $_POST["Tipo"];
  $noM = 0;
  $insertar = $db->query("DELETE FROM tblp_gastos_detalle WHERE tblp_gastos_detalle.IdGasto = '$IdGasto' ");
  $sql9 = $db->query("SELECT tblp_gastos.Importe FROM tblp_gastos WHERE tblp_gastos.IdGasto =  '$IdGasto'");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);
  $Importe = $datos91['Importe'];

  if ($IdGrado == 1) {
    $cond = " tblp_educativa.IdGrado = '$IdGrado'";
  }
  if ($IdGrado == 2) {
    $cond = " tblp_educativa.IdGrado = '$IdGrado'";
  }
  if ($IdGrado == 3) {
    $cond = " tblp_educativa.IdGrado = '$IdGrado'";
  }
  if ($IdGrado == 4) {
    $cond = " tblp_educativa.IdGrado = '$IdGrado'";
  }
  if ($IdGrado == 5) {
    $cond = " tblp_educativa.IdGrado = '$IdGrado'";
  }

  $sqlx = $db->query("SELECT tblp_educativa.IdGrado, tblp_educativa.IdEducativa FROM tblp_educativa WHERE $cond ");
  while ($x = $db->recorrer($sqlx)) {
    $noM = ($noM + 1);
  }

  $div = ($Importe / $noM);

  $sqlx = $db->query("SELECT tblp_educativa.IdGrado, tblp_educativa.IdEducativa FROM tblp_educativa WHERE $cond ");
  while ($x = $db->recorrer($sqlx)) {
    $insertar = $db->query("INSERT INTO tblp_gastos_detalle (IdGasto, IdOferta, Monto, FecCap, IdGrado) VALUES ('$IdGasto','" . $x['IdEducativa'] . "','$div',NOW(),'" . $x['IdGrado'] . "')");
  }

  $db->close();
  if ($insertar) {
    echo $insertar;
  } else {
    echo 0;
  }
}

if ($tipoGuardar == "del_gen_pag_plans") {
  $IdGasto = $_POST["IdGasto"];
  $insertar = $db->query("DELETE FROM tblp_gastos_detalle WHERE tblp_gastos_detalle.IdGasto = '$IdGasto' ");


  $db->close();
  if ($insertar) {
    echo $insertar;
  } else {
    echo 0;
  }
}

if ($tipoGuardar == "cal_pag_plans") {
  $IdGasto = $_POST["IdGasto"];

  $sql8 = $db->query("SELECT tblp_gastos.Importe FROM tblp_gastos WHERE tblp_gastos.IdGasto =  '$IdGasto'");
  $db->rows($sql8);
  $datos81 = $db->recorrer($sql8);
  $Importe = $datos81['Importe'];

  $sql9 = $db->query("SELECT Count(tblp_gastos_detalle.IdDetalle_g) AS Total FROM tblp_gastos_detalle WHERE tblp_gastos_detalle.IdGasto =  '$IdGasto' AND tblp_gastos_detalle.Tipo =  '2'");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);
  $Total = $datos91['Total'];

  $div = ($Importe / $Total);

  $insertar = $db->query("UPDATE tblp_gastos_detalle SET tblp_gastos_detalle.Tipo = '3', tblp_gastos_detalle.Monto = '$div' WHERE tblp_gastos_detalle.IdGasto = '$IdGasto' AND tblp_gastos_detalle.Tipo = '2'");
  $insertar = $db->query("DELETE FROM tblp_gastos_detalle WHERE tblp_gastos_detalle.Tipo = '1' AND tblp_gastos_detalle.IdGasto = '$IdGasto' ");

  $db->close();
  if ($insertar) {
    echo $insertar;
  } else {
    echo 0;
  }
}

if ($tipoGuardar == "ups_sts_gen_pag") {
  $IdDetalle_g = $_POST["IdDetalle_g"];
  $Valor = $_POST["Valor"];
  $insertar = $db->query("UPDATE tblp_gastos_detalle SET tblp_gastos_detalle.Tipo = '$Valor' WHERE tblp_gastos_detalle.IdDetalle_g = '$IdDetalle_g' ");

  $db->close();
  if ($insertar) {
    echo $insertar;
  } else {
    echo 0;
  }
}

if ($tipoGuardar == "load_pag_plans") {
  $IdGasto = $_POST["IdGasto"];
  $sqlx = $db->query("SELECT * FROM tblp_educativa");
  while ($x = $db->recorrer($sqlx)) {
    $insertar = $db->query("INSERT INTO tblp_gastos_detalle (IdGasto, IdOferta, Monto, FecCap, IdGrado, Tipo) VALUES ('$IdGasto','" . $x['IdEducativa'] . "','0',NOW(),'" . $x['IdGrado'] . "','1')");
  }

  $db->close();
  if ($insertar) {
    echo $insertar;
  } else {
    echo 0;
  }
}

if ($tipoGuardar == "aprobar_gen_pag_all") {
  $IdGasto = $_POST["IdGasto"];
  $insertar = $db->query("UPDATE tblp_gastos SET tblp_gastos.Valor = '2' WHERE tblp_gastos.IdGasto = '$IdGasto' ");

  $db->close();
  if ($insertar) {
    echo $insertar;
  } else {
    echo 0;
  }
}

if ($tipoGuardar == "apr_gen_pag_all") {
  $IdGasto = $_POST["IdGasto"];
  $insertar = $db->query("DELETE FROM tblp_gastos_detalle WHERE tblp_gastos_detalle.IdGasto = '$IdGasto' AND tblp_gastos_detalle.Tipo = '1' ");
  $insertar = $db->query("UPDATE tblp_gastos SET tblp_gastos.Valor = '2' WHERE tblp_gastos.IdGasto = '$IdGasto' ");

  $db->close();
  if ($insertar) {
    echo $insertar;
  } else {
    echo 0;
  }
}

if ($tipoGuardar == "reini_gen_pag_all") {
  $IdGasto = $_POST["IdGasto"];
  $insertar = $db->query("DELETE FROM tblp_gastos_detalle WHERE tblp_gastos_detalle.IdGasto = '$IdGasto' ");
  $sqlx = $db->query("SELECT * FROM tblp_educativa");
  while ($x = $db->recorrer($sqlx)) {
    $insertar = $db->query("INSERT INTO tblp_gastos_detalle (IdGasto, IdOferta, Monto, FecCap, IdGrado, Tipo) VALUES ('$IdGasto','" . $x['IdEducativa'] . "','0',NOW(),'" . $x['IdGrado'] . "','1')");
  }

  $db->close();
  if ($insertar) {
    echo $insertar;
  } else {
    echo 0;
  }
}


if ($tipoGuardar == "gen_pag_plans_all") {
  $IdGasto = $_POST["IdGasto"];

  $noM = 13;
  $insertar = $db->query("DELETE FROM tblp_gastos_detalle WHERE tblp_gastos_detalle.IdGasto = '$IdGasto' ");

  $sql9 = $db->query("SELECT tblp_gastos.Importe FROM tblp_gastos WHERE tblp_gastos.IdGasto =  '$IdGasto'");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);
  $Importe = $datos91['Importe'];

  $div = ($Importe / $noM);

  $sqlx = $db->query("SELECT tblp_educativa.IdGrado, tblp_educativa.IdEducativa FROM tblp_educativa");
  while ($x = $db->recorrer($sqlx)) {
    $insertar = $db->query("INSERT INTO tblp_gastos_detalle (IdGasto, IdOferta, Monto, FecCap, IdGrado) VALUES ('$IdGasto','" . $x['IdEducativa'] . "','$div',NOW(),'" . $x['IdGrado'] . "')");
  }

  $db->close();
  if ($insertar) {
    echo $insertar;
  } else {
    echo 0;
  }
}

if ($tipoGuardar == "sav_pago_docx") {
  $IdAsignacion = $_POST["IdAsignacion"];
  $IdEstatus = $_POST["IdEstatus"];

  $sql9 = $db->query("SELECT tblp_asignacion.IdAsignacion FROM tblp_asignacion WHERE tblp_asignacion.Id = '$IdAsignacion'");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);
  $IdAsignacion = $datos91['IdAsignacion'];

  if ($IdEstatus == 12) {
    $insertar = $db->query("UPDATE tblp_asignacion SET tblp_asignacion._idEstatus = '1' WHERE tblp_asignacion._idEstatus <> '60' ");
    $insertar = $db->query("UPDATE tblp_asignacion SET tblp_asignacion._idEstatus = '12' WHERE tblp_asignacion.IdAsignacion = '$IdAsignacion' ");
  }
  if ($IdEstatus == 1) {
    $insertar = $db->query("UPDATE tblp_asignacion SET tblp_asignacion._idEstatus = '1' WHERE tblp_asignacion._idEstatus <> '60' ");
    // $insertar = $db->query("UPDATE tblp_asignacion SET tblp_asignacion._idEstatus = '12' WHERE tblp_asignacion.IdAsignacion = '$IdAsignacion' ");
  }

  $db->close();
  if ($insertar) {
    echo $insertar;
  } else {
    echo 0;
  }
}

if ($tipoGuardar == "sav_envio_mail") {
  $IdUsua = $_POST["IdUsua"];
  $idCam = $_POST["IdCampus"];
  $IdGrupo = $_POST["IdGrupo"];
  $Asunto = $_POST["Asunto"];
  $Mensaje = $_POST["Mensaje"];

  $mensaje = htmlentities($Mensaje); // 'Pago validado correctamente con el folio: '.$cadenaNumero;
  $asunto = utf8_decode($Asunto); // 'Pago validado correctamente con el folio: '.$cadenaNumero;

  $sql_camp = $db->query("SELECT * FROM tblc_campus WHERE tblc_campus.IdCampus = '$idCam'");
  $db->rows($sql_camp);
  $_camp = $db->recorrer($sql_camp);
  $url = $_camp["Link"];
  $nom_plataforma = $_camp["Texto"];
  $url_logo =  $url . 'assets/images/campus/logo_inicio.png';




  $cuerpo = "<table id='x_bodyTable' style='border-collapse: collapse; height: 100%; margin: 0px; padding: 0px; width: 100%; transform: scale(0.87); transform-origin: left top 0px;' min-scale='0.87' width='100%' height='100%' cellspacing='0' cellpadding='0' border='0' align='center'><tbody><tr><td id='x_bodyCell' style='height:100%; margin:0; padding:0; width:100%' valign='top' align='center'><table style='border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0'><tbody><tr><td id='x_templateHeader' style='background:#F7F7F7 none no-repeat center/cover; background-color:#F7F7F7; background-image:none; background-repeat:no-repeat; background-position:center; background-size:cover; border-top:0; border-bottom:0; padding-top:0px; padding-bottom:0px' valign='top' align='center'><table class='x_templateContainer' style='border-collapse:collapse; max-width:600px!important' width='100%' cellspacing='0' cellpadding='0' border='0' align='center'><tbody><tr><td class='x_headerContainer' style='background:transparent none no-repeat center/cover; background-color:transparent; background-image:none; background-repeat:no-repeat; background-position:center; background-size:cover; border-top:0; border-bottom:0; padding-top:0; padding-bottom:0' valign='top'></td></tr></tbody></table></td></tr><tr><td id='x_templateBody' style='background:#FFFFFF none no-repeat center/cover; background-color:#FFFFFF; background-image:none; background-repeat:no-repeat; background-position:center; background-size:cover; border-top:0; border-bottom:0; padding-top:27px; padding-bottom:63px' valign='top' align='center'><table class='x_templateContainer' style='border-collapse:collapse; max-width:600px!important' width='100%' cellspacing='0' cellpadding='0' border='0' align='center'><tbody><tr><td class='x_bodyContainer' style='background:transparent none no-repeat center/cover; background-color:transparent; background-image:none; background-repeat:no-repeat; background-position:center; background-size:cover; border-top:0; border-bottom:0; padding-top:0; padding-bottom:0' valign='top'><table class='x_mcnTextBlock' style='min-width:100%; border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0'><tbody class='x_mcnTextBlockOuter'><tr><td class='x_mcnTextBlockInner' style='padding-top:9px' valign='top'><table class='x_mcnTextContentContainer' style='max-width:100%; min-width:100%; border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0' align='left'><tbody><tr><td class='x_mcnTextContent' style='padding:0px 18px 9px; color:#828282; word-break:break-word; font-family:Helvetica; font-size:16px; line-height:150%; text-align:left' valign='top'></td></tr></tbody></table></td></tr></tbody></table><table class='x_mcnImageBlock' style='min-width:100%; border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0'><tbody class='x_mcnImageBlockOuter'><tr><td class='x_mcnImageBlockInner' style='padding:9px' valign='top'><table class='x_mcnImageContentContainer' style='min-width:100%; border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0' align='left'><tbody><tr><td class='x_mcnImageContent' style='padding-right:9px; padding-left:9px; padding-top:0; padding-bottom:0; text-align:center' valign='top'><img data-imagetype='External' src='$url_logo' width='250px' alt='' class='x_mcnImage' style='max-width:2400px; padding-bottom:0; display:inline!important; vertical-align:bottom; border:0; height:auto; outline:none; text-decoration:none' width='564' align='middle'> </td></tr></tbody></table></td></tr></tbody></table><table class='x_mcnTextBlock' style='min-width:100%; border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0'><tbody class='x_mcnTextBlockOuter'><tr><td class='x_mcnTextBlockInner' style='padding-top:9px' valign='top'><table class='x_mcnTextContentContainer' style='max-width:100%; min-width:100%; border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0' align='left'><tbody><tr><td class='x_mcnTextContent' style='padding:0px 18px 9px; font-family:Lato,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif; word-break:break-word; color:#757575; font-size:16px; line-height:150%; text-align:left' valign='top'>$mensaje<br><br></td></tr></tbody></table></td></tr></tbody></table><table class='x_mcnButtonBlock' style='min-width:100%; border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0'><tbody class='x_mcnButtonBlockOuter'><tr><td class='x_mcnButtonBlockInner' style='padding-top:0; padding-right:18px; padding-bottom:18px; padding-left:18px' valign='top' align='center'><table class='x_mcnButtonContentContainer' style='border-collapse:separate!important; border-radius:28px; background-color:#0047FF' width='100%' cellspacing='0' cellpadding='0' border='0'><tbody><tr><td class='x_mcnButtonContent' style='font-family:Arial; font-size:16px; padding:18px' valign='middle' align='center'><a href='$url' target='_blank' rel='noopener noreferrer' data-auth='NotApplicable' class='x_mcnButton' title='Ir a la Plataforma' style='font-weight:bold; letter-spacing:normal; line-height:100%; text-align:center; text-decoration:none; color:#FFFFFF; display:block'>Ingresar a la $nom_plataforma</a> </td></tr></tbody></table></td></tr></tbody></table><table class='x_mcnDividerBlock' style='min-width:100%; border-collapse:collapse; table-layout:fixed!important' width='100%' cellspacing='0' cellpadding='0' border='0'><tbody class='x_mcnDividerBlockOuter'><tr><td class='x_mcnDividerBlockInner' style='min-width:100%; padding:18px'><table class='x_mcnDividerContent' style='min-width:100%; border-top:2px solid #EAEAEA; border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0'><tbody><tr><td style=''><span></span></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table> ";

  $headers = "MIME-Version: 1.0\r\n";
  $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
  $headers .= "From: $nom_plataforma <info@mwcomenius.com.mx>\r\n";
  $headers .= "Bcc: pedroo.goca@gmail.com\r\n";

  $sql_recursos = $db->query("SELECT tblc_usuario.IdUsua, tblc_usuario.Correo FROM tblc_usuario WHERE tblc_usuario.IdGrupo = '$IdGrupo' AND tblc_usuario.IdEstatus = '8' ");
  while ($_rec = $db->recorrer($sql_recursos)) {
    $destinatario = $_rec['Correo'];
    $insertar4 = $db->query("INSERT INTO tblp_correos_enviados (IdCampus, IdGrupo, IdUsua, Asunto, Contenido, Visto, FecCap, IdUsua_envia) VALUES ('$idCam','$IdGrupo','" . $_rec['IdUsua'] . "','$Asunto','$Mensaje','0',NOW(),'$IdUsua')");
    mail($destinatario, $asunto, $cuerpo, $headers);
  }

  $db->close();
  echo 1; //$insertar;
}

if ($tipoGuardar == "del_gastoxy") {
  $IdGasto = $_POST["IdGasto"];
  $insertar = $db->query("UPDATE tblp_asignacion SET tblp_asignacion._idEstatus = '1', tblp_asignacion._fecPago = NULL, tblp_asignacion._monto = null WHERE tblp_asignacion._idGasto = '$IdGasto'");
  $insertar = $db->query("DELETE FROM tblp_gastos WHERE tblp_gastos.IdGasto = '$IdGasto'");

  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "sav_new_concep") {
  $Concepto = $_POST["Concepto"];

  // $sql9 = $db->query("SELECT tblc_usuario.Permisos, tblc_usuario.IdCampus FROM tblc_usuario WHERE tblc_usuario.IdUsua = '$IdUs'");
  // $db->rows($sql9);
  // $datos91 = $db->recorrer($sql9);
  // $Permisos = $datos91['Permisos'];

  $insertar = $db->query("INSERT INTO tblc_concepto_gasto (Nombre_gasto, FecCap) VALUES ('$Concepto',NOW())");

  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "sav_new_concep_2") {
  $IdGasto = $_POST["IdGasto1"];
  $Gasto2 = $_POST["Gasto2"];


  $insertar = $db->query("INSERT INTO tblc_concepto_gasto2 (IdGasto, Nombre_gasto2) VALUES ('$IdGasto','$Gasto2')");

  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "sav_new_partida") {
  $Partida = $_POST["Partida"];
  $Descripcion = $_POST["Descripcion"];


  $insertar = $db->query("INSERT INTO tblc_partida (Partida, Descripcion) VALUES ('$Partida','$Descripcion')");

  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "upd_partida_id_x") {
  $IdPartida = $_POST["IdPartida"];
  $Partida = $_POST["Partida"];
  $Descripcion = $_POST["Descripcion"];


  $insertar = $db->query("UPDATE tblc_partida SET tblc_partida.Partida = '$Partida', tblc_partida.Descripcion = '$Descripcion' WHERE tblc_partida.IdPartida = '$IdPartida' ");

  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "upd_materia_asigx") {
  $IdAsignacion = $_POST["IdAsignacion"];
  $IdDocente = $_POST["IdDocente"];
  $IdCoordi = $_POST["IdCoordi"];
  $Ini = $_POST["Ini"];
  $Fin = $_POST["Fin"];

  $insertar = $db->query("UPDATE tblp_asignacion SET tblp_asignacion.IdEstatus = '8', tblp_asignacion.Estatus = 'Activo', tblp_asignacion.IdUsua = '$IdDocente', tblp_asignacion.FecIni = '$Ini', tblp_asignacion.FecFin = '$Fin' WHERE tblp_asignacion.IdAsignacion = '$IdAsignacion' AND tblp_asignacion.Tipo = '2' ");
  $insertar = $db->query("UPDATE tblp_asignacion SET tblp_asignacion.IdEstatus = '8', tblp_asignacion.Estatus = 'Activo', tblp_asignacion.IdUsua = '$IdCoordi', tblp_asignacion.FecIni = '$Ini', tblp_asignacion.FecFin = '$Fin' WHERE tblp_asignacion.IdAsignacion = '$IdAsignacion' AND tblp_asignacion.Tipo = '4' ");
  $insertar = $db->query("UPDATE tblx_evaluacion SET tblx_evaluacion.IdUsua = '$IdCoordi' WHERE tblx_evaluacion.IdAsignacion = '$IdAsignacion' ");

  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "sav_mot_suspx") {
  $Fecha = $_POST["Fecha"];
  $Motivo = $_POST["Motivo"];
  $IdUsua = $_POST["IdUsua"];
  $anio = date("Y");

  $sql9 = $db->query("SELECT tblp_suspension.IdSuspension FROM tblp_suspension WHERE tblp_suspension.Fecha = '$Fecha'");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);
  $IdSuspension = $datos91['IdSuspension'];
  if ($IdSuspension) {
    $insertar = 2;
  } else {
    $insertar = $db->query("INSERT INTO tblp_suspension (Fecha, Motivo, FecCap, IdUsua, Anio) VALUES ('$Fecha','$Motivo',NOW(),'$IdUsua','$anio')");
  }

  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "del_mot_suspx") {
  $IdSuspension = $_POST["IdSuspension"];

  $insertar = $db->query("DELETE FROM tblp_suspension WHERE tblp_suspension.IdSuspension = '$IdSuspension'");


  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "copy_planeacion") {
  $_IdAsignacion = $_POST["IdAsignacion"];

  $pieces = explode("_", $_IdAsignacion);
  $IdAsig_copy =  $pieces[0];
  $IdAsignacion =  $pieces[1];

  $sql8 = $db->query("SELECT tblp_asignacion.IdUsua, tblp_asignacion.IdGrupo, tblp_asignacion.IdCiclo FROM tblp_asignacion WHERE tblp_asignacion.IdAsignacion = '$IdAsignacion' AND tblp_asignacion.Tipo = '2'");
  $db->rows($sql8);
  $datos81 = $db->recorrer($sql8);
  $IdUsua = $datos81["IdUsua"];
  $IdCiclo = $datos81["IdCiclo"];
  $IdGrupo = $datos81["IdGrupo"];

  $insertar3 = $db->query("DELETE FROM  tblp_parcialdocente WHERE tblp_parcialdocente.IdAsignacion = '$IdAsignacion'");

  $sql_parcial = $db->query("SELECT * FROM tblp_parcialdocente WHERE tblp_parcialdocente.IdAsignacion = '$IdAsig_copy' AND tblp_parcialdocente.Tipo = 'P' ORDER BY tblp_parcialdocente.NoParcial ASC");
  while ($_parcial = $db->recorrer($sql_parcial)) {
    $insertar1 = $db->query("INSERT INTO tblp_parcialdocente (IdOferta, Titulo, IdModulo, NoParcial, Tema, Objetivo, FecCap, IdUsua, IdEstatus, IdGrupo, IdCiclo, IdAsignacion, Tipo) VALUES ('" . $_parcial['IdOferta'] . "', '" . $_parcial['Titulo'] . "','" . $_parcial['IdModulo'] . "','" . $_parcial['NoParcial'] . "','" . $_parcial['Tema'] . "','" . $_parcial['Objetivo'] . "',NOW(),'$IdUsua','4','$IdGrupo','$IdCiclo','$IdAsignacion','P')");
    $id_par = $db->insert_id;
    $sql_semana = $db->query("SELECT * FROM tblp_semanadocente WHERE tblp_semanadocente.IdParcialDocente = '" . $_parcial['IdParcialDocente'] . "' ORDER BY tblp_semanadocente.NoSemana ASC");
    while ($_semana = $db->recorrer($sql_semana)) {
      $insertar2 = $db->query("INSERT INTO tblp_semanadocente (IdOferta, IdModulo, IdParcialDocente, NoSemana, Temas, FecCap, IdUsua, Tipo, Nombre, Code, Semana, NoLeccion, Avance, Etiqueta_semana, Tematica) VALUES ('" . $_semana['IdOferta'] . "','" . $_semana['IdModulo'] . "','$id_par','" . $_semana['NoSemana'] . "','" . $_semana['Temas'] . "',NOW(),'$IdUsua','" . $_semana['Tipo'] . "','" . $_semana['Nombre'] . "','" . $_semana['Code'] . "','" . $_semana['Semana'] . "','" . $_semana['NoLeccion'] . "','0','" . $_semana['Etiqueta_semana'] . "','" . $_semana['Tematica'] . "')");
      $id_sem = $db->insert_id;

      $sql_actividad = $db->query("SELECT * FROM tblp_actividadesdocente WHERE tblp_actividadesdocente.IdSemanaDocente = '" . $_semana['IdSemanaDocente'] . "' ORDER BY tblp_actividadesdocente.FecIni ASC");
      while ($_actividad = $db->recorrer($sql_actividad)) {
        $insertar3 = $db->query("INSERT INTO tblp_actividadesdocente (IdOferta, IdModulo, IdParcialDocente, IdSemanaDocente, IdTipoActividad, NomActividad, DesActividad, FecCap, IdEstatus, IdUsua, Porcentaje, Modalidad, IdAsignacion, IdTipo, Estrategia, Tecnica, Herramienta) VALUES ('" . $_semana['IdOferta'] . "','" . $_semana['IdModulo'] . "','$id_par','$id_sem','" . $_actividad['IdTipoActividad'] . "','" . $_actividad['NomActividad'] . "','" . $_actividad['DesActividad'] . "',NOW(),'12','$IdUsua','" . $_actividad['Porcentaje'] . "','" . $_actividad['Modalidad'] . "','$IdAsignacion','" . $_actividad['IdTipo'] . "','" . $_actividad['Estrategia'] . "','" . $_actividad['Tecnica'] . "','" . $_actividad['Herramienta'] . "')");
        $id_act = $db->insert_id;

        $sql_recursos = $db->query("SELECT * FROM tblp_biblioteca WHERE tblp_biblioteca.IdAsignacion = '$IdAsig_copy' AND tblp_biblioteca.IdActividadesDocente = '" . $_actividad['IdActividadesDocente'] . "'");
        while ($_rec = $db->recorrer($sql_recursos)) {
          $insertar4 = $db->query("INSERT INTO tblp_biblioteca (IdAsignacion, Nombre, Link, IdTema, IdUsua, FecCap, Anio, Mes, Tipo, IdActividadesDocente) VALUES ('$IdAsignacion','" . $_rec['Nombre'] . "','" . $_rec['Link'] . "','" . $_rec['IdTema'] . "','$IdUsua',NOW(),'" . $_rec['Anio'] . "','" . $_rec['Mes'] . "','" . $_rec['Tipo'] . "','$id_act')");
        }
      }
    }
  }


  $db->close();
  echo $insertar1;
}

if ($tipoGuardar == "del_calendario") {
  $IdCalendario = $_POST["IdCalendario"];

  $sql8 = $db->query("SELECT tblp_pagos.IdPago FROM tblp_pagos WHERE tblp_pagos.IdCalendario = '$IdCalendario' LIMIT 1");
  $db->rows($sql8);
  $datos81 = $db->recorrer($sql8);
  $IdPago = $datos81["IdPago"];
  if ($IdPago) {
    $insertar = 3;
  } else {
    $insertar = $db->query("DELETE FROM tblp_calendario WHERE tblp_calendario.IdCalendario = '$IdCalendario' ");
  }

  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "aprobar_docs") {
  $IdUsua = $_POST["IdUsua"];
  $IdDocumento = $_POST["IdDocumento"];
  $sumarDias = 5;
  $fechaLim = sumasdiasemana(date("Y-m-d"), $sumarDias);
  $insertar = $db->query("UPDATE tblp_docs_solicitados SET tblp_docs_solicitados.FecLimite = '$fechaLim', tblp_docs_solicitados.IdEstatus = '4', tblp_docs_solicitados.FecAprobado = NOW(), tblp_docs_solicitados.IdVisto = '$IdUsua' WHERE tblp_docs_solicitados.IdDocumento = '$IdDocumento' ");

  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "visto_rec_pag") {
  $IdDocumento = $_POST["IdDocumento"];
  $insertar = $db->query("UPDATE tblh_detallepagos SET tblh_detallepagos.Visto = 0 WHERE tblh_detallepagos.IdDetallePagos = '$IdDocumento' ");

  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "add_actPago") {
  $IdPago = $_POST["IdPago"];
  $IdUsua = $_POST["IdUsua"];
  $Valor = $_POST["Valor"];

  $insertar = $db->query("UPDATE tblp_pagos SET tblp_pagos.Valor = '$Valor' WHERE tblp_pagos.IdPago = '$IdPago'");

  $db->close();
  echo $insertar;
}
if ($tipoGuardar == "no_pag_pend") {

  $sql8 = $db->query("SELECT Count(tblh_detallepagos.IdDetallePagos) AS Total FROM tblh_detallepagos Left Join tblc_usuario ON tblc_usuario.IdUsua = tblh_detallepagos.IdUsua WHERE tblc_usuario.Permisos = '3' AND tblh_detallepagos.Estatus =  '2' ORDER BY tblh_detallepagos.FecCap DESC ");
  //$sql8 = $db->query("SELECT Count(tblh_detallepagos.IdDetallePagos) AS Total FROM tblh_detallepagos WHERE tblh_detallepagos.Estatus =  '2' ");
  $db->rows($sql8);
  $datos81 = $db->recorrer($sql8);
  $Total = $datos81["Total"];

  $db->close();
  if ($Total) {
    echo $Total;
  } else {
    echo 0;
  }
}

if ($tipoGuardar == "set_asignacion") {
  $idAsig = $_POST["Id"];
  $sql8 = $db->query("SELECT tblp_asignacion.IdAsignacion, tblc_usuario.id_paquete FROM tblp_asignacion Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_asignacion.IdUsua WHERE tblp_asignacion.Id =  '$idAsig' ");
  $fsx = "";
  $db->rows($sql8);
  $datos81 = $db->recorrer($sql8);
  $IdAsignacion = $datos81["IdAsignacion"];
  $firma = $datos81["id_paquete"];
  if ($firma) {
    $fsx = "&f=1";
  } else {
    $fsx = "";
  }
  $insertar = $db->query("UPDATE tblp_asignacion SET tblp_asignacion.Salon = '1' WHERE tblp_asignacion.IdAsignacion = '$IdAsignacion' ");

  $db->close();
  echo $IdAsignacion . $fsx;
}

if ($tipoGuardar == "notificion_all") {
  $IdUsua = $_POST['IdUsua'];

  $sql8 = $db->query("SELECT Count(tblp_tareascomentarios.IdComentario) AS Total FROM tblp_tareascomentarios WHERE tblp_tareascomentarios.IdUsua_recibe =  '$IdUsua' AND tblp_tareascomentarios.Visto =  '1' GROUP BY tblp_tareascomentarios.IdUsua ");
  $db->rows($sql8);
  $datos81 = $db->recorrer($sql8);
  $Total = isset($datos81["Total"]);

  $db->close();
  if ($Total) {
    echo $Total;
  } else {
    echo 0;
  }
}

if ($tipoGuardar == "acta_all") {
  //  echo "SELECT Count(tblp_asignacion.IdUsua) AS Total FROM tblp_asignacion WHERE tblp_asignacion.Tipo =  '2' AND tblp_asignacion.Fecha_impresion IS NOT NULL  AND tblp_asignacion.Salon =  '0' GROUP BY tblp_asignacion.Salon";

  $sql8 = $db->query("SELECT Count(tblp_asignacion.IdUsua) AS Total FROM tblp_asignacion WHERE tblp_asignacion.Tipo =  '2' AND tblp_asignacion.Fecha_impresion IS NOT NULL  AND tblp_asignacion.Salon =  '0' GROUP BY tblp_asignacion.Salon");
  $db->rows($sql8);
  $datos81 = $db->recorrer($sql8);
  $Total = $datos81["Total"];

  $db->close();
  if ($Total) {
    echo $Total;
  } else {
    echo 0;
  }
}

if ($tipoGuardar == "sel_Abono") {
  $IdUsua = $_POST["IdUsua"];
  $IdPago = $_POST["IdPago"];
  $Valor = $_POST["Valor"];
  if ($Valor == 0) {
    $insertar = $db->query("UPDATE tblp_pagos SET tblp_pagos.Indicador = '0' WHERE tblp_pagos.IdPago = '$IdPago' ");
  } else {

    $sqlx = $db->query("SELECT tblp_pagos.IdPago FROM tblp_pagos WHERE tblp_pagos.IdUsua =  '$IdUsua' AND tblp_pagos.IdEstatus <> 4 AND tblp_pagos.Valor = '1'");
    while ($x = $db->recorrer($sqlx)) {
      $idP = $x['IdPago'];
      $insertar = $db->query("UPDATE tblp_pagos SET tblp_pagos.Indicador = '0' WHERE tblp_pagos.IdPago = '$idP' ");
    }

    $insertar = $db->query("UPDATE tblp_pagos SET tblp_pagos.Indicador = '1' WHERE tblp_pagos.IdPago = '$IdPago' ");
  }

  echo 1;
  exit();
}

if ($tipoGuardar == "del_recargo_id") {
  $IdPago = $_POST["IdPago"];

  $sql8 = $db->query("SELECT * FROM tblp_pagos WHERE tblp_pagos.IdPago = '$IdPago'");
  $db->rows($sql8);
  $datos81 = $db->recorrer($sql8);
  $recar = $datos81["Recargos"];

  $suma = ($datos81["Monto"] + $datos81["Recargos"] - $datos81["Descuento"] - $datos81["TotalPagado"]);

  if($suma <= $recar){
    $idEsta = '4';
  } else {
    $idEsta = '1';
  }

  $insertar = $db->query("UPDATE tblp_pagos SET tblp_pagos.IdEstatus = '$idEsta',  tblp_pagos.Recargos = '0' WHERE tblp_pagos.IdPago = '$IdPago'");

  echo 1;
  exit();
}

if ($tipoGuardar == "del_desc_espx") {
  $IdPago = $_POST["IdPago"];

  $insertar = $db->query("UPDATE tblp_pagos SET tblp_pagos.Descuento2 = NULL, tblp_pagos.FechaDesc = NULL, tblp_pagos._motivo = '' WHERE tblp_pagos.IdPago = '$IdPago'");

  echo $insertar;
  exit();
}

if ($tipoGuardar == "savPag_Ini_Pros") {
  $IdUsua = $_POST["IdProspecto"];
  $IdCiclo = $_POST["IdCiclo"];
  $IdOferta = $_POST["IdOferta"];
  $IdCampus = $_POST["IdCampus"];
  $idCam = $_POST["IdCampus"];
  $IdPaq = $_POST["IdPaq"];

  $anio = date("Y");
  $IdActividad = 0;
  $sql8 = $db->query("SELECT tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Folio, tblc_usuario.Correo, tblc_usuario.id_actividad FROM tblc_usuario WHERE  tblc_usuario.IdUsua = '$IdUsua'");
  $db->rows($sql8);
  $datos81 = $db->recorrer($sql8);
  $Nombre = $datos81["Nombre"];
  $Paterno = $datos81["APaterno"];
  $Materno = $datos81["AMaterno"];
  $destinatario = $datos81["Correo"];
  $Folio = $datos81["Folio"];
  $IdActividad = $datos81["id_actividad"];

  // AND tblp_calendario.IdCampus = '$IdCampus'
  

  $_x = 0;
  $sql_g_pag = $db->query("SELECT tblp_calendario.IdCalendario, tblp_calendario.FecDescuento, tblp_calendario.Monto, tblc_conceptosdetalle.IdConceptoPlan, tblc_conceptosplanes.IdConcepto, tblc_conceptosplanes.Costo FROM tblp_calendario Left Join tblc_conceptosdetalle ON tblc_conceptosdetalle.IdConceptoPlan = tblp_calendario.IdConceptosPlanes Left Join tblc_conceptosplanes ON tblc_conceptosplanes.IdConceptoPlanes = tblc_conceptosdetalle.IdConceptoPlan WHERE tblp_calendario.IdCiclo =  '$IdCiclo' AND tblc_conceptosdetalle.IdOferta =  '$IdOferta' AND ((tblc_conceptosplanes.IdConcepto =  '1') || (tblc_conceptosplanes.IdConcepto =  '2')) ORDER BY tblp_calendario.FecDescuento ASC");
  while ($x = $db->recorrer($sql_g_pag)) {
    $_x = ($_x + 1);
    if ($_x <= 2) {
      $IdActividad = $datos81["id_actividad"];
    } else {
      $IdActividad = 0;
    }
    $IdCal = $x['IdCalendario'];
    $IdConcepto = $x['IdConcepto'];
    $Monto = $x['Monto'];
    $Fec = $x['FecDescuento'];
    $IdPlan = $x['IdConceptoPlan'];
    $insertar = $db->query("INSERT INTO tblp_pagos (IdCalendario,IdUsua,Monto,IdEstatus,IdOferta,FecCap,Fecha,FecDesc, FecBase,FecLim, FecLimPago,IdCiclo,Anio,IdConceptoPlan,IdCampus, Facturar,TipoSolicitud, Capturado, Tipo, IdActividad, _idEstatus, IdConcepto, TotalPagado, Recargos, Descuento) VALUES('$IdCal','$IdUsua','$Monto','1','$IdOferta',NOW(),'$Fec','$Fec','$Fec','$Fec','$Fec','$IdCiclo','$anio','$IdPlan','$IdCampus','NO-F20','2','1','$IdPaq','$IdActividad','32','$IdConcepto',0,0,0)");
  }

  $inserta_r = $db->query("UPDATE tblc_usuario SET tblc_usuario.GPago = '1' WHERE tblc_usuario.IdUsua = '$IdUsua' ");



  $Xp = 0;
  $sqlx = $db->query("SELECT tblp_pagos.IdPago, tblp_pagos.Monto, tblp_pagos.IdConceptoPlan, tblc_conceptosplanes.NomPlan, tblp_pagos.FecBase FROM tblp_pagos Left Join tblc_conceptosplanes ON tblc_conceptosplanes.IdConceptoPlanes = tblp_pagos.IdConceptoPlan WHERE tblp_pagos.IdUsua =  '$IdUsua' ");
  while ($x = $db->recorrer($sqlx)) {
    $descP = 0;
    $IdPago = $x["IdPago"];
    $IdPlan = $x["IdConceptoPlan"];
    $Monto = $x["Monto"];
    $sqlx9 = $db->query("SELECT * FROM tblp_beca WHERE tblp_beca.IdConceptoPlan = '$IdPlan' AND tblp_beca.IdUsua = '$IdUsua' AND tblp_beca.IdEstatus = '8' ");
    $db->rows($sqlx9);
    $datosx91 = $db->recorrer($sqlx9);
    $IdBeca = $datosx91['IdBeca'];
    $Porcentaje = $datosx91['Porcentaje'];

    if ($Porcentaje) {
      $deta = ($Monto / 100);
      $descP = ($deta * $Porcentaje);
      $Monto = ($Monto - $descP);
      $insertar = $db->query("UPDATE tblp_pagos SET tblp_pagos.Descuento = '$descP', tblp_pagos.IdBeca = '$IdBeca' WHERE tblp_pagos.IdPago= '$IdPago' ");
    }

    $Xp = ($Xp + 1);
    if ($Xp == 1) {
      $pag1 = '(CLIC) - ' . $x["NomPlan"];
      $pag_1 = time() . $x["IdPago"];
    }
    if ($Xp == 2) {
      $pag2 = '(CLIC) - ' . $x["NomPlan"];
      $pag_2 = time() . $x["IdPago"];
    }
  }

  $sql_plan = $db->query("SELECT * FROM tblp_educativa WHERE tblp_educativa.IdEducativa = '$IdOferta'");
  $db->rows($sql_plan);
  $_educ = $db->recorrer($sql_plan);
  $Modulo = $_educ["Nombre"];



  $sql_camp = $db->query("SELECT * FROM tblc_campus WHERE tblc_campus.IdCampus = '$IdCampus'");
  $db->rows($sql_camp);
  $_camp = $db->recorrer($sql_camp);
  $url = $_camp["Link"];
  $_campus = $_camp["Campus"];
  $nom_plataforma = $_camp["Texto"];
  $asunto = 'Proceso de inscripcion en la ' . $nom_plataforma;

  $url_pag1 = $url . "repositorio/pdf/boucherId.php?tokenId=" . $pag_1;
  $url_im = $url . "assets/images/campus/logo_inicio.png";

  $cuerpo = "
        <div style='width: 99%; height: 350px; font-family:Helvetica; font-size:16px; padding: 5px; color: #10004a;'>
            <p style='text-align: center;'>
            <img src='$url_im' style='width: 200px;'>
            </p>
            <p style='text-align: center; background: #1d3462; padding: 15px; color: #fff;'><b>BIENVENIDO(A)</b></p>
            <p style='text-align: center; background: #dbe9ff; padding: 10px; color: #000;'>
            <b>En este momento te encuentras en el proceso de inscripci&oacute;n, el cual se le ha generado el pago
            correspondiente para que pueda realizar tu pago de inscripci&oacute;n.</b></p>
            <p style='text-align: left;'>Estos son tus datos, el cual deber&aacute; descargar tu ficha de pago y realizar el pago correspondiente. </p><br>

                <b>CAMPUS: </b> $_campus <br>
                <b>PLAN DE ESTUDIOS: </b> $Modulo <br><br><br>

            </p>
            <p>
            <a href='$url_pag1' title='Ir a la Plataforma' style='font-weight:bold;text-align:center;text-decoration:none;color:#000;display:block; background: red; padding: 10px; border-radius: 50px;' target='_blank'>Descargar mi ficha de pago</a>
            </p>
        </div>
    ";

  $headers = "MIME-Version: 1.0\r\n";
  $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
  $headers .= "From: $nom_plataforma <info@mwcomenius.com.mx>\r\n";
  $headers .= "Bcc: pedroo.goca@gmail.com\r\n";

  mail($destinatario, $asunto, $cuerpo, $headers);

  $db->close();
  echo $insertar;
}


if ($tipoGuardar == "sav_pago_ini_posgrado") {
  $IdPlan1 = $_POST["IdPlan1"];
  $IdPlan2 = $_POST["IdPlan2"];
  $Fecha1 = $_POST["Fecha1"];
  $Fecha2 = $_POST["Fecha2"];
  $IdModulo = $_POST["IdModulo"];
  $IdUsua = $_POST["IdProspecto"];
  $Ciclo = $_POST["IdCiclo"];
  $IdOferta = $_POST["IdOferta"];
  $IdCampus = $_POST["IdCampus"];
  $idCam = $_POST["IdCampus"];
  $IdPaq = $_POST["IdPaq"];

  $anio = date("Y");
  $IdActividad = 0;

  $sql8 = $db->query("SELECT tblc_usuario.Nombre, tblc_usuario.IdGrupo, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Folio, tblc_usuario.Correo, tblc_usuario.id_actividad FROM tblc_usuario WHERE  tblc_usuario.IdUsua = '$IdUsua'");
  $db->rows($sql8);
  $datos81 = $db->recorrer($sql8);
  $IdGrupo = $datos81["IdGrupo"];
  $Nombre = $datos81["Nombre"];
  $Paterno = $datos81["APaterno"];
  $Materno = $datos81["AMaterno"];
  $destinatario = $datos81["Correo"];
  $Folio = $datos81["Folio"];
  if (isset($datos81["id_actividad"])) {
    $IdActividad = $datos81["id_actividad"];
  } else {
    $IdActividad = 0;
  }


  #INSCRIPCI脫N

  $sqle2 = $db->query("SELECT tblc_conceptosplanes.IdConcepto, tblc_conceptosplanes.Costo, tblc_conceptosplanes.IdGrado FROM tblc_conceptosplanes WHERE tblc_conceptosplanes.IdConceptoPlanes = '$IdPlan1'");
  $db->rows($sqle2);
  $datose21 = $db->recorrer($sqle2);
  $IdConcepto1 = $datose21['IdConcepto'];
  $Monto1 = $datose21['Costo'];
  $IdGrado = $datose21['IdGrado'];

  $sql7 = $db->query("SELECT tblp_calendario.IdCalendario FROM tblp_calendario WHERE tblp_calendario.IdConceptosPlanes =  '$IdPlan1'");
  $db->rows($sql7);
  $datos71 = $db->recorrer($sql7);
  $IdCalendario1 = $datos71["IdCalendario"];

  if (!$IdCalendario1) {
    $insertar = $db->query("INSERT INTO tblp_calendario (IdGrado, IdConceptosPlanes, FecDescuento, FecBase, FecLimite, Monto, IdUsua, FecCap, IdEstatus, IdCiclo, IdCampus, IdCicloPago) VALUES ('$IdGrado','$IdPlan1','$Fecha1','$Fecha1','$Fecha1','$Monto1','1',NOW(),'32','$Ciclo','1','$Ciclo') ");
    $IdCalendario1 = $db->insert_id;
  }



  #COLEGIATURA

  $sqle2 = $db->query("SELECT tblc_conceptosplanes.IdConcepto, tblc_conceptosplanes.Costo, tblc_conceptosplanes.IdGrado FROM tblc_conceptosplanes WHERE tblc_conceptosplanes.IdConceptoPlanes = '$IdPlan2'");
  $db->rows($sqle2);
  $datose21 = $db->recorrer($sqle2);
  $IdConcepto2 = $datose21['IdConcepto'];
  $Monto2 = $datose21['Costo'];
  $IdGrado = $datose21['IdGrado'];

  $sql7 = $db->query("SELECT tblp_calendario.IdCalendario FROM tblp_calendario WHERE tblp_calendario.IdConceptosPlanes =  '$IdPlan2' AND tblp_calendario.IdModulo =  '$IdModulo'");
  $db->rows($sql7);
  $datos71 = $db->recorrer($sql7);
  $IdCalendario2 = $datos71["IdCalendario"];

  if (!$IdCalendario2) {

    $insertar = $db->query("INSERT INTO tblp_calendario (IdGrado, IdConceptosPlanes, FecDescuento, FecBase, FecLimite, Monto, IdUsua, FecCap, IdEstatus, IdCiclo, IdCampus, IdCicloPago, IdModulo) VALUES ('$IdGrado','$IdPlan2','$Fecha2','$Fecha2','$Fecha2','$Monto2','1',NOW(),'32','$Ciclo','1','$Ciclo','$IdModulo') ");
    $IdCalendario2 = $db->insert_id;
  }


  $insertar = $db->query("INSERT INTO tblp_pagos (IdCalendario,IdUsua,Monto,IdEstatus,IdOferta,FecCap,FecDesc, FecBase,FecLim, FecLimPago,IdCiclo,Anio,IdConceptoPlan,IdCampus, Facturar,TipoSolicitud, Capturado, Tipo, IdActividad, _idEstatus, IdConcepto, TotalPagado, Recargos, Descuento) VALUES('$IdCalendario1','$IdUsua','$Monto1','1','$IdOferta',NOW(),'$Fecha1','$Fecha1','$Fecha1','$Fecha1','$Ciclo','$anio','$IdPlan1','$IdCampus','NO','2','1','$IdPaq','$IdActividad','32','$IdConcepto1',0,0,0)");

  $insertar = $db->query("INSERT INTO tblp_pagos (IdCalendario,IdUsua,Monto,IdEstatus,IdOferta,FecCap,FecDesc, FecBase,FecLim, FecLimPago,IdCiclo,Anio,IdConceptoPlan,IdCampus, Facturar,TipoSolicitud, Capturado, Tipo, IdActividad, _idEstatus, IdConcepto, TotalPagado, Recargos, Descuento, IdModulo) VALUES('$IdCalendario2','$IdUsua','$Monto2','1','$IdOferta',NOW(),'$Fecha2','$Fecha2','$Fecha2','$Fecha2','$Ciclo','$anio','$IdPlan2','$IdCampus','NO','2','1','$IdPaq','$IdActividad','32','$IdConcepto2',0,0,0,'$IdModulo')");


  $inserta_r = $db->query("UPDATE tblc_usuario SET tblc_usuario.GPago = '1' WHERE tblc_usuario.IdUsua = '$IdUsua' ");


  $nombre = htmlentities($Nombre . ' ' . $Paterno . ' ' . $Materno);
  $pass = 'enaproc';

  $asunto = 'Plataforma ENAPROC pagos iniciales';
  $sub_titulo = "Deber&aacute; realizar los siguientes pagos";
  $nom_plataforma = "Plataforma ENAPROC";
  $link = "https://enaproc.escuelanacionalpcchiapas.mx";

  $cuerpo = "<table style='border-collapse:collapse;height:100%;margin:0;padding:0;width:100%;background-color:#f2f4fc' width='100%' height='100%' cellspacing='0' cellpadding='0' border='0' align='center'>
          <tbody><tr>
              <td style='height:100%;margin:0;padding:10px;width:100%;border-top:0' valign='top' align='center'>
                  <table style='border-collapse:collapse;border:0;max-width:600px!important' width='100%' cellspacing='0' cellpadding='0' border='0'>
                      <tbody><tr>
                          <td style='background:#000f33; color:#fff; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif; padding:10px' valign='top'>$sub_titulo</td>
                      </tr>
                      <tr>
                          <td style='background:#ffffff;' valign='top'>
                          <table style='min-width:100%;border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0'>
                              <tbody>
                                  <tr>
                                      <td style='padding-top:9px' valign='top'>
                                          <table style='max-width:100%;min-width:100%;border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0' align='left'>
                                              <tbody>
                                                <tr>
                                                    <td style='padding-top:0;padding-right:18px;padding-bottom:9px;padding-left:18px;word-break:break-word;color:black; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif; font-size:12px;line-height:150%;text-align:left;' valign='top'>
                                                        <div>
                                                          <b>NOMBRE: </b> $nombre <br></br>
                                                          Estimado alumno, en la $nom_plataforma se le ha generado el pago de Inscripci&oacute;n y el Pago de la Primera materia.<br><br>
                                                          Deber&aacute; ingresar con los siguientes datos <b>Descargar su ficha de pago</b> que se encuentra en mi <b>Espacio</b> en el lado superior derecho, luego en el apartado de Estatus Financiero.

                                                          <b>Usuario: </b> $destinatario <br>
                                                          <b>Password: </b> enaproc <br>

                                                          </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style='font-size:12px; line-height:17px;font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif; font-weight:600; ' height='80' align='center'>
                                                      <a href='$link' style='color:inherit;text-decoration:none;text-align:center;display:inline-block; background: #525fff; border-radius: 25px; padding: 8px; color: white;' target='_blank'> &nbsp;&nbsp;&nbsp;&nbsp; Ir a la Plataforma &nbsp;&nbsp;&nbsp;&nbsp; </a>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td style='background: #d5d3d0; padding-top:5px; padding-right:18px; padding-bottom:5px;padding-left:18px;word-break:break-word;color:black; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif; font-size:12px;line-height:150%;text-align:center' valign='top'>
                                                        <div>Todos los derechos reservados<br><b>$nom_plataforma</b></div>
                                                    </td>
                                                </tr>

                                          </tbody></table>
                                      </td>
                                  </tr>
                              </tbody>
                          </table></td>
                      </tr>
                  </tbody></table>
              </td>
          </tr>
      </tbody></table>";

  $headers = "MIME-Version: 1.0\r\n";
  $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
  $headers .= "From: $nom_plataforma <info@mwcomenius.com.mx>\r\n";
  $headers .= "Bcc: pedroo.goca@gmail.com\r\n";

  mail($destinatario, $asunto, $cuerpo, $headers);


  // $Xp = 0;
  // $sqlx = $db->query("SELECT tblp_pagos.IdPago, tblp_pagos.Monto, tblp_pagos.IdConceptoPlan, tblc_conceptosplanes.NomPlan, tblp_pagos.FecBase FROM tblp_pagos Left Join tblc_conceptosplanes ON tblc_conceptosplanes.IdConceptoPlanes = tblp_pagos.IdConceptoPlan WHERE tblp_pagos.IdUsua =  '$IdUsua' ");
  //  while($x = $db->recorrer($sqlx)){
  // $descP = 0;
  //    $IdPago = $x["IdPago"];
  //    $IdPlan = $x["IdConceptoPlan"];
  //    $Monto = $x["Monto"];
  //    $sqlx9 = $db->query("SELECT * FROM tblp_beca WHERE tblp_beca.IdConceptoPlan = '$IdPlan' AND tblp_beca.IdUsua = '$IdUsua' AND tblp_beca.IdEstatus = '8' ");
  //    $db->rows($sqlx9);
  //    $datosx91 = $db->recorrer($sqlx9);
  //    $IdBeca = $datosx91['IdBeca'];
  //    $Porcentaje = $datosx91['Porcentaje'];
  //
  //    if($Porcentaje){
  //      $deta = ($Monto / 100);
  //      $descP = ($deta * $Porcentaje);
  //      $Monto = ($Monto - $descP);
  //      $insertar = $db->query("UPDATE tblp_pagos SET tblp_pagos.Descuento = '$descP', tblp_pagos.IdBeca = '$IdBeca' WHERE tblp_pagos.IdPago= '$IdPago' ");
  //    }
  //
  //    // $Xp = ($Xp + 1);
  //    // if($Xp == 1){ $pag1 = '(CLIC) - '.$x["NomPlan"]; $pag_1 = time().$x["IdPago"]; }
  //    // if($Xp == 2){ $pag2 = '(CLIC) - '.$x["NomPlan"]; $pag_2 = time().$x["IdPago"]; }
  //
  //  }

  // $sql_camp = $db->query("SELECT * FROM tblc_campus WHERE tblc_campus.IdCampus = '$idCam'");
  // $db->rows($sql_camp);
  // $_camp = $db->recorrer($sql_camp);
  // $url = $_camp["Link"];
  // $nom_plataforma = $_camp["Texto"];
  // $url_logo =  $url.'assets/images/campus/logo_inicio.png';
  //
  // $url_pag1 = $url."repositorio/pdf/boucherId.php?tokenId=".$pag_1;
  // $url_pag2 = $url."repositorio/pdf/boucherId.php?tokenId=".$pag_2;
  // $url_continuar = $url."continuar.php?x=1";

  // $asunto = 'Pagos solicitados en la '.$nom_plataforma;
  // $nombre = htmlentities($Nombre.' '.$Paterno.' '.$Materno);



  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "aprob_docs_alum") {
  $IdDocs = $_POST["IdDocs"];
  $IdEstatus = $_POST["IdEstatus"];



  $insertar = $db->query("UPDATE tblc_docalumnos SET tblc_docalumnos.Estatus = '$IdEstatus' WHERE tblc_docalumnos.IdDocAlumno = '$IdDocs'");
  if ($IdEstatus == 4) {
    $sql8 = $db->query("SELECT tblc_docalumnos.IdUsua, tblc_docalumnos.IdTipoDocumento FROM tblc_docalumnos WHERE  tblc_docalumnos.IdDocAlumno = '$IdDocs'");
    $db->rows($sql8);
    $datos81 = $db->recorrer($sql8);
    $IdUsua = $datos81["IdUsua"];
    $IdTipoDocumento = $datos81["IdTipoDocumento"];

    $insertar = $db->query("UPDATE tblp_documentos SET tblp_documentos.Si = '1' WHERE tblp_documentos.IdUsua = '$IdUsua' AND tblp_documentos.IdTipoDocumento = '$IdTipoDocumento'");
  }

  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "upd_concepto_user") {
  $IdPlan = $_POST["IdPlan"];
  $Nombre = $_POST["Nombre"];
  $Oferta = $_POST["Oferta"];
  $Concepto = $_POST["Concepto"];
  $Costo = $_POST["Costo"];
  $Recargo = $_POST["Recargo"];
  $Producto = $_POST["Producto"];
  $Unidad = $_POST["Unidad"];

  $insertar = $db->query("UPDATE tblc_conceptosplanes SET tblc_conceptosplanes.ClaveProdServ = '$Producto', tblc_conceptosplanes.ClaveUnidad = '$Unidad', tblc_conceptosplanes.Costo = '$Costo', tblc_conceptosplanes.Recargo = '$Recargo', tblc_conceptosplanes.NomPlan = '$Nombre',  tblc_conceptosplanes.IdGrado = '$Oferta', tblc_conceptosplanes.IdConcepto = '$Concepto'  WHERE tblc_conceptosplanes.IdConceptoPlanes = '$IdPlan' ");

  if ($insertar) {
    echo $insertar;
  } else {
    echo 0;
  }
}

if ($tipoGuardar == "sav_costo_planx") {
  $IdPlan = $_POST["IdPlan"];
  $IdCiclo = $_POST["IdCiclo"];
  $Costo = $_POST["Costo"];
  $Recargo = $_POST["Recargo"];
  $_Fecha = $_POST["Fecha"];
  $Numero = $_POST["Numero"];
  $IdUsua = $_POST["IdUsua"];

  $sql8 = $db->query("SELECT tblc_costos_ciclo.IdCosto FROM tblc_costos_ciclo WHERE tblc_costos_ciclo.IdCiclo = '$IdCiclo' AND tblc_costos_ciclo.IdPlan = '$IdPlan'");
  $db->rows($sql8);
  $datos81 = $db->recorrer($sql8);
  $_idCosto = $datos81["IdCosto"];
  if ($_idCosto) {
    echo 2;
    exit();
  }

  $insertar = $db->query("INSERT INTO tblc_costos_ciclo (IdPlan, IdCiclo, Monto, Recargo, FecCap, Fecha, Numero) VALUES ('$IdPlan','$IdCiclo','$Costo','$Recargo', NOW(),'$_Fecha','$Numero') ");
  $IdCost = $db->insert_id;
  $sql8 = $db->query("SELECT * FROM tblc_conceptosplanes WHERE tblc_conceptosplanes.IdConceptoPlanes = '$IdPlan'");
  $db->rows($sql8);
  $datos81 = $db->recorrer($sql8);
  $IdGrado = $datos81['IdGrado'];
  $IdCampus = $datos81['IdCampus'];


  for ($i = 0; $i < $Numero; $i++) {
    $Fecha =  date("Y-m-d", strtotime($_Fecha . "+ $i month"));

    $insertar = $db->query("INSERT INTO tblp_calendario (IdGrado, IdConceptosPlanes, FecDescuento, FecBase, FecLimite, Monto, IdUsua, FecCap, IdEstatus, IdCiclo, IdCampus, IdCicloPago) VALUES ('$IdGrado','$IdPlan','$Fecha','$Fecha','$Fecha','$Costo','$IdUsua',NOW(),'32','$IdCiclo','$IdCampus','$IdCost') ");
  }

  if ($insertar) {
    echo 1;
  } else {
    echo 0;
  }
}

if ($tipoGuardar == "updx_costo_planx") {
  $IdPlan = $_POST["IdPlan"];
  $IdCosto = $_POST["IdCosto"];
  $Costo = $_POST["Costo"];
  $Recargo = $_POST["Recargo"];
  $_Fecha = $_POST["Fecha"];
  $IdUsua = $_POST["IdUsua"];


  $sql8 = $db->query("SELECT * FROM tblc_conceptosplanes WHERE tblc_conceptosplanes.IdConceptoPlanes = '$IdPlan'");
  $db->rows($sql8);
  $datos81 = $db->recorrer($sql8);
  $IdGrado = $datos81['IdGrado'];
  $IdCampus = $datos81['IdCampus'];
  $i = 0;
  $sql_g_pag = $db->query("SELECT * FROM tblp_calendario WHERE tblp_calendario.IdCicloPago = '$IdCosto' ORDER BY tblp_calendario.FecDescuento ASC");
  while ($x = $db->recorrer($sql_g_pag)) {
    $Fecha =  date("Y-m-d", strtotime($_Fecha . "+ $i month"));
    $insertar = $db->query("UPDATE tblp_calendario SET tblp_calendario.FecDescuento = '$Fecha', tblp_calendario.FecBase = '$Fecha', tblp_calendario.FecLimite = '$Fecha', tblp_calendario.Monto = '$Costo' WHERE tblp_calendario.IdCalendario = '" . $x['IdCalendario'] . "' ");
    $i = ($i + 1);
  }

  $sql_gz = $db->query("SELECT * FROM tblp_calendario WHERE tblp_calendario.IdCicloPago = '$IdCosto' ORDER BY tblp_calendario.FecDescuento ASC");
  while ($xy = $db->recorrer($sql_gz)) {

    //$insertar = $db->query("UPDATE tblp_pagos SET tblp_pagos.Monto = '" . $xy['Monto'] . "', tblp_pagos.FecDesc = '" . $xy['FecDescuento'] . "', tblp_pagos.FecBase = '" . $xy['FecDescuento'] . "', tblp_pagos.FecLim = '" . $xy['FecDescuento'] . "', tblp_pagos.FecLimPago = NULL, tblp_pagos.MesRecargo = NULL WHERE tblp_pagos.IdCalendario = '" . $xy['IdCalendario'] . "' ");
  }

  $insertar = $db->query("UPDATE tblc_costos_ciclo SET tblc_costos_ciclo.Monto = '$Costo', tblc_costos_ciclo.Recargo = '$Recargo', tblc_costos_ciclo.Fecha = '$_Fecha' WHERE tblc_costos_ciclo.IdCosto = '$IdCosto' ");


  if ($insertar) {
    echo 1;
  } else {
    echo 0;
  }
}


if ($tipoGuardar == "sav_not_mensaje") {
  $IdUsua = $_POST["IdUsua"];
  $IdAdmin = $_POST["IdAdmin"];
  $Chat = $_POST["Chat"];

  $insertar = $db->query("INSERT INTO tblh_chat_notificacion (IdUsua, Chat, IdAdmin, FecCap) VALUES ('$IdUsua','$Chat','$IdAdmin',NOW())");

  $sql8 = $db->query("SELECT tblc_usuario.Nombre, tblc_usuario.IdCampus, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Folio, tblc_usuario.Correo FROM tblc_usuario WHERE  tblc_usuario.IdUsua = '$IdUsua'");
  $db->rows($sql8);
  $datos81 = $db->recorrer($sql8);
  $Nombre = $datos81["Nombre"];
  $Paterno = $datos81["APaterno"];
  $Materno = $datos81["AMaterno"];
  $destinatario = $datos81["Correo"];
  $Folio = $datos81["Folio"];
  $idCam = $datos81["IdCampus"];


  $nombre = htmlentities($Nombre . ' ' . $Paterno . ' ' . $Materno);
  $chat = htmlentities($Chat);


  $asunto = 'Seguimiento de documentos en la Plataforma ENAPROC';
  $sub_titulo = "Notificaci&oacute;n de seguimiento de documentos";
  $nom_plataforma = "Plataforma ENAPROC";
  $link = "https://escuelanacionalpcchiapas.mx/";

  $cuerpo = "<table style='border-collapse:collapse;height:100%;margin:0;padding:0;width:100%;background-color:#f2f4fc' width='100%' height='100%' cellspacing='0' cellpadding='0' border='0' align='center'>
          <tbody><tr>
              <td style='height:100%;margin:0;padding:10px;width:100%;border-top:0' valign='top' align='center'>
                  <table style='border-collapse:collapse;border:0;max-width:600px!important' width='100%' cellspacing='0' cellpadding='0' border='0'>
                      <tbody><tr>
                          <td style='background:#000f33; color:#fff; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif; padding:10px' valign='top'>$sub_titulo</td>
                      </tr>
                      <tr>
                          <td style='background:#ffffff;' valign='top'>
                          <table style='min-width:100%;border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0'>
                              <tbody>
                                  <tr>
                                      <td style='padding-top:9px' valign='top'>
                                          <table style='max-width:100%;min-width:100%;border-collapse:collapse' width='100%' cellspacing='0' cellpadding='0' border='0' align='left'>
                                              <tbody>
                                                <tr>
                                                    <td style='padding-top:0;padding-right:18px;padding-bottom:9px;padding-left:18px;word-break:break-word;color:black; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif; font-size:12px;line-height:150%;text-align:left;' valign='top'>
                                                        <div>
                                                          <b>Mensaje de notificaci&oacute;n: </b> <br>
                                                          $chat
                                                          </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style='font-size:12px; line-height:17px;font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif; font-weight:600; ' height='80' align='center'>
                                                      <a href='$link' style='color:inherit;text-decoration:none;text-align:center;display:inline-block; background: #525fff; border-radius: 25px; padding: 8px; color: white;' target='_blank'> &nbsp;&nbsp;&nbsp;&nbsp; Ir a la Plataforma &nbsp;&nbsp;&nbsp;&nbsp; </a>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td style='background: #d5d3d0; padding-top:5px; padding-right:18px; padding-bottom:5px;padding-left:18px;word-break:break-word;color:black; font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif; font-size:12px;line-height:150%;text-align:center' valign='top'>
                                                        <div>Todos los derechos reservados<br><b>$nom_plataforma</b></div>
                                                    </td>
                                                </tr>

                                          </tbody></table>
                                      </td>
                                  </tr>
                              </tbody>
                          </table></td>
                      </tr>
                  </tbody></table>
              </td>
          </tr>
      </tbody></table>";

  $headers = "MIME-Version: 1.0\r\n";
  $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
  $headers .= "From: $nom_plataforma <info@mwcomenius.com.mx>\r\n";
  $headers .= "Bcc: pedroo.goca@gmail.com\r\n";

  mail($destinatario, $asunto, $cuerpo, $headers);

  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "sav_seg_alumno") {
  $IdUsua = $_POST["IdUsua"];
  $IdAlumno = $_POST["IdAlumno"];
  $Alumno = $_POST["Alumno"];
  $Asesor = $_POST["Asesor"];
  $IdCiclo = $_POST["IdCiclo"];
  $IdSeguimiento = $_POST["IdSeguimiento"];
  $fech = date("Y-m-d");

  $insertar = $db->query("INSERT INTO tblp_seguimiento (IdUsua, IdCiclo, Fecha, FecCap, Comentario_control, Comentario_usuario, IdTipoSeguimiento, IdUsua_admin) VALUES ('$IdAlumno','$IdCiclo','$fech',NOW(),'$Asesor','$Alumno','$IdSeguimiento','$IdUsua')");


  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "sav_seg_docente") {
  $IdUsua = $_POST["IdUsua"];
  $IdDocente = $_POST["IdDocente"];
  $Alumno = $_POST["Alumno"];
  $Asesor = $_POST["Asesor"];
  $IdSeguimiento = $_POST["IdSeguimiento"];
  $fech = date("Y-m-d");

  $insertar = $db->query("INSERT INTO tblp_seguimiento_docente (IdUsua, Fecha, FecCap, Comentario_control, Comentario_usuario, IdTipoSeguimiento, IdUsua_admin) VALUES ('$IdDocente','$fech',NOW(),'$Asesor','$Alumno','$IdSeguimiento','$IdUsua')");


  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "sav_new_deptox") {
  $Depto = $_POST["Depto"];

  $insertar = $db->query("INSERT INTO tblc_permiso (Permiso, _Permiso, Tipo) VALUES ('$Depto','$Depto',1)");

  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "add_beca_user") {
  $IdUsua = $_POST["IdUsua"];
  $IdUsuaCap = $_POST["IdUsua_c"];
  $IdPlan = $_POST["IdPlan"];
  $Beca = $_POST["Porcentaje"];


  $sql9 = $db->query("SELECT * FROM tblp_beca WHERE tblp_beca.IdUsua = '$IdUsua' AND tblp_beca.IdConcepto = '$IdPlan' AND tblp_beca.IdEstatus = '8' ");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);
  $IdBeca = $datos91['IdBeca'];

  if ($IdBeca) {
    echo 2;
    exit();
  }

  $insertar = $db->query("INSERT INTO tblp_beca (IdUsua, IdConcepto, Porcentaje, FecCap, IdUsuaCap, IdEstatus)VALUES('$IdUsua','$IdPlan','$Beca',NOW(),'$IdUsuaCap','8')");

  if ($insertar) {
    echo $insertar;
  } else {
    echo 0;
  }
}

if ($tipoGuardar == "del_beca_user") {
  $IdUsua = $_POST["IdUsua"];
  $IdBeca = $_POST["IdBeca"];
  #/29/09/2024
  //$insertar = $db->query("DELETE FROM tblp_beca WHERE tblp_beca.IdBeca = '$IdBeca' ");

  if ($insertar) {
    echo $insertar;
  } else {
    echo 0;
  }
}

if ($tipoGuardar == "gn_constancias") {
  $IdCiclo = $_POST["IdCiclo"];
  $Fecha = $_POST["Fecha"];

  $sql_lst = $db->query("SELECT tblp_asignacion.IdEducativa FROM tblp_asignacion WHERE tblp_asignacion.IdCiclo = '$IdCiclo' AND tblp_asignacion.Tipo =  '2' GROUP BY tblp_asignacion.IdEducativa ");
  while ($xy = $db->recorrer($sql_lst)) {
    $insertar = $db->query("INSERT INTO tblp_constancia (IdCiclo, IdOferta, IdEstatus, Fecha, FecCap) VALUES ('$IdCiclo','" . $xy['IdEducativa'] . "','1','$Fecha',NOW()) ");
  }

  if ($insertar) {
    echo $insertar;
  } else {
    echo 0;
  }
}

if ($tipoGuardar == "gn_const_lista") {
  $IdCiclo = $_POST["IdCiclo"];
  $IdConst = $_POST["IdConst"];
  $IdOferta = $_POST["IdOferta"];
  $sql9 = $db->query("SELECT tblp_constancia.Fecha FROM tblp_constancia WHERE tblp_constancia.IdConst = '$IdConst' ");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);
  $Fecha = $datos91['Fecha'];

  $sql_lst = $db->query("SELECT Count(tblp_asignacion.IdGrupo) AS Total,tblp_grupo.IdGrupo, tblp_grupo.CveGrupo FROM tblp_asignacion Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblp_asignacion.IdGrupo WHERE tblp_asignacion.IdCiclo =  '$IdCiclo' AND tblp_asignacion.IdEducativa =  '$IdOferta' AND tblp_asignacion.Tipo =  '2' GROUP BY tblp_asignacion.IdGrupo ORDER BY tblp_grupo.IdGrado ASC, tblp_grupo.IdOferta ASC");
  while ($xy = $db->recorrer($sql_lst)) {
    $no = 0;
    $prom = 0;
    $id_es = 1;
    $sql_pro = $db->query("SELECT tblp_calificacion.IdCalificacion, Sum(tblp_calificacion.Promedio) AS Suma, tblp_calificacion.Usuario, tblc_usuario.IdCampus, tblp_modulo.Grado FROM tblp_calificacion Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_calificacion.IdUsua Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_calificacion.IdModulo WHERE tblc_usuario.IdGrupo =  '" . $xy['IdGrupo'] . "' AND tblp_calificacion.IdCiclo =  '$IdCiclo' GROUP BY tblp_calificacion.Usuario ORDER BY Suma DESC, tblc_usuario.APaterno ASC LIMIT 3");
    while ($xp = $db->recorrer($sql_pro)) {
      $no = ($no + 1);
      $prom = 0;
      $prom = ($xp['Suma'] / $xy['Total']);
      if ($prom < 8) {
        $id_es = 1;
      } else {
        $id_es = 3;
      }
      $insertar = $db->query("INSERT INTO tblp_constancia_lista (IdConst, IdOferta, IdCiclo, IdGrupo, Materias, Lugar, Fecha, FecCap, Usuario, Suma, Promedio, Grado, IdEstatus, IdCampus) VALUES ('$IdConst','$IdOferta','$IdCiclo','" . $xy['IdGrupo'] . "','" . $xy['Total'] . "','$no','$Fecha',NOW(),'" . $xp['Usuario'] . "','" . $xp['Suma'] . "','$prom','" . $xp['Grado'] . "','$id_es','" . $xp['IdCampus'] . "') ");
    }
  }
  $insertar = $db->query("UPDATE tblp_constancia SET tblp_constancia.IdEstatus = '4' WHERE tblp_constancia.IdConst = '$IdConst' ");

  if ($insertar) {
    echo $insertar;
  } else {
    echo 0;
  }
}

if ($tipoGuardar == "del_const_lista") {
  $IdCiclo = $_POST["IdCiclo"];

  $insertar = $db->query("DELETE FROM tblp_constancia_lista WHERE tblp_constancia_lista.IdCiclo = '$IdCiclo' ");
  $insertar = $db->query("DELETE FROM tblp_constancia WHERE tblp_constancia.IdCiclo = '$IdCiclo' ");

  if ($insertar) {
    echo $insertar;
  } else {
    echo 0;
  }
}

if ($tipoGuardar == "habi_constas_us") {
  $IdCiclo = $_POST["IdCiclo"];
  $IdCampus = $_POST["IdCampus"];
  $IdOferta = $_POST["IdOferta"];

  $insertar = $db->query("UPDATE tblp_constancia_lista SET tblp_constancia_lista.IdEstatus = '4' WHERE tblp_constancia_lista.IdCiclo = '$IdCiclo' AND tblp_constancia_lista.IdCampus = '$IdCampus' AND tblp_constancia_lista.IdOferta = '$IdOferta' AND tblp_constancia_lista.IdEstatus = '3' ");

  if ($insertar) {
    echo $insertar;
  } else {
    echo 0;
  }
}

if ($tipoGuardar == "sav_banco_setting") {
  $Valor = $_POST["Valor"];
  $IdBanco = $_POST["IdBanco"];
  $IdCampus = $_POST["IdCampus"];
  $IdOferta = $_POST["IdOferta"];
  if ($Valor == 1) {
    $insertar = $db->query("INSERT INTO tblc_bancos_setting (IdBanco, IdCampus, IdOferta, FecCap) VALUES ('$IdBanco','$IdCampus','$IdOferta',NOW())");
  } else {
    $insertar = $db->query("DELETE FROM tblc_bancos_setting WHERE tblc_bancos_setting.IdBanco = '$IdBanco' AND tblc_bancos_setting.IdCampus = '$IdCampus' AND tblc_bancos_setting.IdOferta = '$IdOferta' ");
  }
  echo $insertar;
}

if ($tipoGuardar == "sav_pcursox") {
  $IdGrupo = $_POST["IdGrupo"];
  $IdPlanx = $_POST["IdPlan"];
  $Descuento = $_POST["Descuento"];
  $IdUsua = $_POST["IdUsua"];

  $sql5 = $db->query("SELECT * FROM tblp_grupo WHERE tblp_grupo.IdGrupo = '$IdGrupo'");
  $db->rows($sql5);
  $datos51 = $db->recorrer($sql5);

  $IdCampus = $datos51["IdCampus"];
  $IdOferta = $datos51["IdOferta"];

  $sql9 = $db->query("SELECT * FROM tblp_calendario WHERE tblp_calendario.IdCalendario = '$IdPlanx' ");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);
  $Monto = $datos91["Monto"];
  $Fec = $datos91["FecDescuento"];
  $IdCiclo = $datos91["IdCiclo"];
  $IdPlan = $datos91["IdConceptosPlanes"];
  $anio = date("Y");

  $sql8 = $db->query("SELECT tblc_conceptosplanes.IdConcepto FROM tblc_conceptosplanes WHERE tblc_conceptosplanes.IdConceptoPlanes = '$IdPlan' ");
  $db->rows($sql8);
  $datos81 = $db->recorrer($sql8);
  $IdConcepto = $datos81["IdConcepto"];

  $insertar = $db->query("INSERT INTO tblp_pagos (IdCalendario,IdUsua,Monto,IdEstatus,IdOferta,FecCap,FecDesc, FecBase,FecLim, FecLimPago,IdCiclo,Anio,IdConceptoPlan,IdCampus, Facturar,TipoSolicitud, Capturado, _idEstatus, IdConcepto, TotalPagado, Recargos, Descuento, IdGrupo)
      VALUES('$IdPlanx','$IdUsua','$Monto','1','$IdOferta',NOW(),'$Fec','$Fec','$Fec','$Fec','$IdCiclo','$anio','$IdPlan','1','NO-F21','2','1','32','$IdConcepto',0,0,'$Descuento','$IdGrupo')");

  echo $insertar;
}

if ($tipoGuardar == "del_pagocuxx") {
  $IdPago = $_POST["IdPago"];

  $insertar = $db->query("DELETE FROM tblp_pagos WHERE tblp_pagos.IdPago = '$IdPago' ");

  echo $insertar;
}


if ($tipoGuardar == "sav_eva_setting") {
  $Valor = $_POST["Valor"];
  $IdTipoEvaluacion = $_POST["IdTipoEvaluacion"];
  $IdCampus = $_POST["IdCampus"];
  $IdOferta = $_POST["IdOferta"];
  if ($Valor == 1) {
    $insertar = $db->query("INSERT INTO tblc_tipoevaluacion_setting (IdTipoEvaluacion, IdCampus, IdOferta, FecCap) VALUES ('$IdTipoEvaluacion','$IdCampus','$IdOferta',NOW())");
  } else {
    $insertar = $db->query("DELETE FROM tblc_tipoevaluacion_setting WHERE tblc_tipoevaluacion_setting.IdTipoEvaluacion = '$IdTipoEvaluacion' AND tblc_tipoevaluacion_setting.IdCampus = '$IdCampus' AND tblc_tipoevaluacion_setting.IdOferta = '$IdOferta' ");
  }
  echo $insertar;
}

if ($tipoGuardar == "sav_curp_id") {
  $IdUsua = $_POST["IdUsua"];
  $Curp = $_POST["Curp"];
  
  $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.Curp = '$Curp' WHERE tblc_usuario.IdUsua = '$IdUsua' ");

  $datos = validar_curp($Curp);
  if ($datos) {
    $rfc = substr($Curp, 0, 10); 
    $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.Curp = '$Curp', tblc_usuario._nacionalidad = 'mexicana', tblc_usuario._rfc = '$rfc', tblc_usuario.FecNac = '" . $datos['fecha_nacimiento'] . "', tblc_usuario.Sexo = '" . $datos['sexo'] . "', tblc_usuario._nacimiento = '" . $datos['estado'] . "' WHERE tblc_usuario.IdUsua = '$IdUsua'");
  } 
  echo $insertar;
}


if ($tipoGuardar == "sav_datos_docente_id") {
  $IdUsua = $_POST["IdUsua"];
  $Nacionalidad = $_POST["Nacionalidad"];
  $Nacimiento = $_POST["Nacimiento"];
  $Escolaridad = $_POST["Escolaridad"];
  $Elector = $_POST["Elector"];
  $Rfc = $_POST["Rfc"];
  $Banco = $_POST["Banco"];
  $Cuenta = $_POST["Cuenta"];
  $Prefijo = $_POST["Prefijo"];
  $Domicilio = $_POST["Domicilio"];
  

  $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario._domicilio = '$Domicilio', tblc_usuario._prefijo = '$Prefijo', tblc_usuario._elector = '$Elector', tblc_usuario._cuenta = '$Cuenta', tblc_usuario._banco = '$Banco', tblc_usuario._escolaridad = '$Escolaridad', tblc_usuario._rfc = '$Rfc', tblc_usuario._nacimiento = '$Nacimiento', tblc_usuario._nacionalidad = '$Nacionalidad' WHERE tblc_usuario.IdUsua = '$IdUsua' ");

  echo $insertar;
}

if ($tipoGuardar == "aceptar_contrato") {
  $IdAsignacion = $_POST["IdAsignacion"];
  
  $insertar = $db->query("UPDATE tblp_asignacion SET tblp_asignacion.aceptado = '1', tblp_asignacion.fec_aceptado = NOW() WHERE tblp_asignacion.IdAsignacion = '$IdAsignacion' ");

  echo $insertar;
}


if ($tipoGuardar == "generar_contrato_id") {
  $IdAsignacion = $_POST["IdAsignacion"];
  $Monto = $_POST["Monto"];
  $Texto = $_POST["Texto"];
  $IdEstatus = $_POST["IdEstatus"];
  $Fecha = $_POST["Fecha"];

  if($IdEstatus == 8){
    $insertar = $db->query("UPDATE tblp_asignacion SET tblp_asignacion.contrato = '1' WHERE tblp_asignacion.IdAsignacion = '$IdAsignacion'");
  } else {
    $insertar = $db->query("UPDATE tblp_asignacion SET tblp_asignacion.contrato = '0' WHERE tblp_asignacion.IdAsignacion = '$IdAsignacion'");
  }

  $insertar = $db->query("UPDATE tblp_contrato SET tblp_contrato.Monto = '$Monto', tblp_contrato.Texto = '$Texto', tblp_contrato.IdEstatus = '$IdEstatus', tblp_contrato.FecCap = NOW() WHERE tblp_contrato.IdAsignacion = '$IdAsignacion'");
  $insertar = $db->query("UPDATE tblp_asignacion SET tblp_asignacion._fec_contrato = '$Fecha' WHERE tblp_asignacion.IdAsignacion = '$IdAsignacion'");


  $db->close();
  echo $insertar;
}


function sumasdiasemana($fecha, $dias)
{
  $datestart = strtotime($fecha);
  $datesuma = 15 * 86400;
  $diasemana = date('N', $datestart);
  $totaldias = $diasemana + $dias;
  $findesemana = intval($totaldias / 5) * 2;
  $diasabado = $totaldias % 5;
  if ($diasabado == 6) $findesemana++;
  if ($diasabado == 0) $findesemana = $findesemana - 2;
  $total = (($dias + $findesemana) * 86400) + $datestart;
  return $fechafinal = date('Y-m-d', $total);
}

class Password
{
  const SALT = 'MwC%6gA6w1W#8s';
  public static function hash($password)
  {
    return hash('sha512', self::SALT . $password);
  }
  public static function verify($password, $hash)
  {
    return ($hash == self::hash($password));
  }
}

function dias_semana($fecha)
{
  $dias = array('7', '1', '2', '3', '4', '5', '6');
  $dia = $dias[date('w', strtotime($fecha))];
  return $dia;
}


function add_registros($IdAdmin,$Comentario,$Accion,$Modulo,$Valor,$IdUsua,$IdMod)
{
  $db = new Conexion();
  if ($IdUsua <> 1) {
    $insertar = $db->query("INSERT INTO tblh_ingresos (IdUsua, Pagina, FecCap, _accion, _modulo, _valor, _idUsua, _idActividad) VALUES ('$IdAdmin', '$Comentario',NOW(),'$Accion','$Modulo','$Valor','$IdUsua','$IdMod')");
    $db->close();
  }
}

function validar_curp($curp)
{
  // Convertimos a mayúsculas por si la ingresaron en minúsculas
  $curp = strtoupper($curp);

  // Expresión regular para validar la CURP y extraer datos
  $regexCurp = '/^([A-Z]{1})([AEIOU]{1})([A-Z]{2})' . // Iniciales del apellido y nombre
    '([0-9]{2})([0-9]{2})([0-9]{2})' .     // Fecha de nacimiento: AA MM DD
    '([HM]{1})' .                          // Sexo: H (Hombre) o M (Mujer)
    '([A-Z]{2})' .                         // Estado de nacimiento
    '([B-DF-HJ-NP-TV-Z]{3})' .            // Consonantes internas de apellidos/nombre
    '([0-9A-Z]{1})' .                     // Homoclave
    '([0-9]{1})$/';                       // Dígito verificador

  if (preg_match($regexCurp, $curp, $matches)) {
    // Convertir fecha de nacimiento a formato completo
    $year = (intval($matches[4]) >= 0 && intval($matches[4]) <= 24) ? '20' . $matches[4] : '19' . $matches[4];
    $fechaNacimiento = $year . '-' . $matches[5] . '-' . $matches[6];

    // Estados de nacimiento según clave de CURP
    $estados = [
      'AS' => 'Aguascalientes',
      'BC' => 'Baja California',
      'BS' => 'Baja California Sur',
      'CC' => 'Campeche',
      'CL' => 'Coahuila de Zaragoza',
      'CM' => 'Colima',
      'CS' => 'Chiapas',
      'CH' => 'Chihuahua',
      'DF' => 'Ciudad de México',
      'DG' => 'Durango',
      'GT' => 'Guanajuato',
      'GR' => 'Guerrero',
      'HG' => 'Hidalgo',
      'JC' => 'Jalisco',
      'MC' => 'Mexico',
      'MN' => 'Michoacán de Ocampo',
      'MS' => 'Morelos',
      'NT' => 'Nayarit',
      'NL' => 'Nuevo León',
      'OC' => 'Oaxaca',
      'PL' => 'Puebla',
      'QT' => 'Querétaro',
      'QR' => 'Quintana Roo',
      'SP' => 'San Luis Potosí',
      'SL' => 'Sinaloa',
      'SR' => 'Sonora',
      'TC' => 'Tabasco',
      'TS' => 'Tamaulipas',
      'TL' => 'Tlaxcala',
      'VZ' => 'Veracruz de Ignacio de la Llave',
      'YN' => 'Yucatán',
      'ZS' => 'Zacatecas',
      'NE' => 'Extranjero'
    ];

    return [
      'apellido_paterno' => $matches[1] . $matches[2] . $matches[3],
      'fecha_nacimiento' => $fechaNacimiento,
      'sexo' => ($matches[7] == 'H') ? 'H' : 'M',
      'estado' => $estados[$matches[8]] ?? 'Extranjero',
      'consonantes' => $matches[9],
      'homoclave' => $matches[10],
      'digito_verificador' => $matches[11]
    ];
  } else {
    return false; // CURP inválida
  }
}