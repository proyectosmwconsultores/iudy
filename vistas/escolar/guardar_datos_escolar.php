<?php
require('../../php/clases/class.System.php');
$db = new Conexion();
$tipoGuardar = $_POST["TipoGuardar"];

if ($tipoGuardar == "sav_cve_grupo_new") {
  $IdRvoe = $_POST["IdRvoe"];
  $IdCampus = $_POST["IdCampus"];
  $IdOferta = $_POST["IdOferta"];
  $Modalidad = $_POST["Modalidad"];
  $Turno = $_POST["Turno"];
  $IdCiclo = $_POST["Ciclo"];
  $Dia = $_POST["Dia"];
  $Ingles = $_POST["Ingles"];

  $Inicio = $_POST["Inicio"];
  $Final = $_POST["Final"];

  if ($Ingles == 'SI') {
    $idEsta = 8;
    $Grupo = $_POST["Grupo"] . '_INGLES';
    $Ingles == 'SI';
  } else {
    $idEsta = 12;
    $Grupo = $_POST["Grupo"];
    $Ingles == 'NO';
  }

  $sql1 = $db->query("SELECT tblp_educativa.Clave FROM tblp_educativa WHERE tblp_educativa.IdEducativa =  '$IdOferta' ");
  $db->rows($sql1);
  $datos11 = $db->recorrer($sql1);
  $oferta = $datos11["Clave"];

  $sql_rv = $db->query("SELECT * FROM tblc_rvoe WHERE tblc_rvoe.IdRvoe =  '$IdRvoe' ");
  $db->rows($sql_rv);
  $_rvx = $db->recorrer($sql_rv);
  $id_campus = $_rvx["IdCampus"];

  $sql2 = $db->query("SELECT tblc_ciclo.IdCiclo, tblc_ciclo.FInicio, tblc_ciclo.Tipo FROM tblc_ciclo WHERE tblc_ciclo.IdCiclo =  '$IdCiclo' ");
  $db->rows($sql2);
  $datos21 = $db->recorrer($sql2);
  $Ciclo = substr($datos21["Tipo"], 0, 1);
  $Fecha = $datos21["FInicio"];
  $Anio = substr($Fecha, 2, 2);

  $_cve = $oferta . $Modalidad . $Dia . $Ciclo . $Turno . $Anio . $Grupo;

  $sql2 = $db->query("SELECT tblp_grupo.IdGrupo FROM tblp_grupo WHERE tblp_grupo.CveGrupo =  '$_cve' AND tblp_grupo.IdCampus = '$IdCampus' AND tblp_grupo.IdOferta = '$IdOferta' AND tblp_grupo.IdCicloIni = '$IdCiclo'");
  $db->rows($sql2);
  $datos21 = $db->recorrer($sql2);
  $IdGrupo = $datos21["IdGrupo"];
  if ($IdGrupo) {
    echo 2;
    exit();
  } else {


    $insertar = $db->query("INSERT INTO tblp_grupo (CveGrupo, Estatus, Turno, Oferta, Grupo, Modalidad, IdOferta,IdCampus, Anio, TipoCiclo, Dia, FecCap, IdEstatus,IdCicloIni, Disponible, FechaIni, FechaFin, Grado, id_rvoe, id_campus, Ingles) VALUES ('$_cve','Abierto', '$Turno','$oferta','$Grupo','$Modalidad','$IdOferta','$IdCampus','$Anio','$Ciclo','$Dia', NOW(),'$idEsta','$IdCiclo','SI','$Inicio','$Final','1','$IdRvoe','$id_campus','$Ingles')");
    $IdGrupo = $db->insert_id;
    $insertar = $db->query("INSERT INTO tblp_grupo_detalle (IdGrupo, CveGrupo, IdOferta, IdCampus) VALUES ('$IdGrupo','$_cve','$IdOferta','$IdCampus')");
    $insertar = $db->query("INSERT INTO tblc_ciclogrupo (IdCiclo, IdGrupo, FecCap, Grado) VALUES ('$IdCiclo','$IdGrupo',NOW(),'1')");
    $insertar = $db->query("INSERT INTO tblp_evaluacion (IdCiclo, IdGrupo, Valor) VALUES ('$IdCiclo','$IdGrupo','1')");

    $db->close();

    echo $insertar;
  }
}

if ($tipoGuardar == "ini_horario_personalizado") {
  $rwIdCiclo = $_POST["idPeriodo"];
  $IdUsua = $_POST["IdUsua"];

  #Verificamos si ya existe el pago para no generarlo nuevamente e inscribirlo en caso de que haga falta
  $sql_pags = $db->query("SELECT tblp_pagos.IdPago FROM tblp_pagos WHERE tblp_pagos.IdConcepto = '3' AND tblp_pagos.IdUsua =  '$IdUsua' AND tblp_pagos.IdCiclo =  '$rwIdCiclo'");
  $db->rows($sql_pags);
  $_pags = $db->recorrer($sql_pags);


  $sql8 = $db->query("SELECT tblc_usuario.IdGrupo, tblc_usuario.IdCampus, tblc_usuario.IdOferta, tblc_usuario.IdGrupo FROM tblc_usuario WHERE tblc_usuario.IdUsua = '$IdUsua'");
  $db->rows($sql8);
  $datos81 = $db->recorrer($sql8);
  $IdOferta = $datos81['IdOferta'];
  $IdGrupo = $datos81['IdGrupo'];
  $IdCampus = $datos81['IdCampus'];

  // if(!isset($_pags["IdPago"])){
    #Verificamos que exista el pago reinscripcion
    
    $sql_cicl = $db->query("SELECT tblp_pagos.IdPago FROM tblp_pagos WHERE tblp_pagos.IdConcepto = '3' AND tblp_pagos.IdUsua =  '$IdUsua' AND tblp_pagos.IdCiclo =  '$rwIdCiclo'");
    $db->rows($sql_cicl);
    $_ciclo = $db->recorrer($sql_cicl);
    if (!isset($_ciclo["IdPago"])) { 
      #Generamos los pagos de reinscripcion
      
      $sql_reins = $db->query("SELECT tblc_conceptosdetalle.IdConceptoDetalle, tblc_costos_ciclo.IdCosto, tblc_costos_ciclo.Monto, tblc_costos_ciclo.Fecha, tblc_costos_ciclo.Numero, tblc_conceptosdetalle.IdConceptoPlan FROM tblc_conceptosdetalle Left Join tblc_costos_ciclo ON tblc_costos_ciclo.IdPlan = tblc_conceptosdetalle.IdConceptoPlan WHERE tblc_conceptosdetalle.IdOferta =  '$IdOferta' AND tblc_conceptosdetalle.IdConcepto =  '3' AND tblc_costos_ciclo.IdCiclo =  '$rwIdCiclo'");
      while ($_reins = $db->recorrer($sql_reins)) {
        $anio = substr($_reins['Fecha'], 0, 4);
        $insertar = $db->query("INSERT INTO tblp_pagos (IdUsua,Monto,IdEstatus,IdOferta,FecCap,Fecha,IdCiclo,Anio,IdConceptoPlan,IdCampus, Facturar,TipoSolicitud, Capturado, _idEstatus, IdConcepto, TotalPagado, Recargos, Descuento, IdGrupo) VALUES('$IdUsua','" . $_reins['Monto'] . "','1','$IdOferta',NOW(),'" . $_reins['Fecha'] . "','$rwIdCiclo','$anio','" . $_reins['IdConceptoPlan'] . "','$IdCampus','NO-F40','2','1','32','3',0,0,0,'$IdGrupo')");
        $insertar = $db->query("INSERT INTO tblc_docalumnos (IdUsua, IdTipoDocumento, Estatus, IdCiclo, Doc, IdGrupo) VALUES ('$IdUsua','103','1','$rwIdCiclo','T','$IdGrupo')");
        $insertar = $db->query("INSERT INTO tblc_docalumnos (IdUsua, IdTipoDocumento, Estatus, IdCiclo, Doc, IdGrupo) VALUES ('$IdUsua','105','1','$rwIdCiclo','T','$IdGrupo')");
        $insertar = $db->query("INSERT INTO tblp_beca (IdUsua, IdConcepto, Porcentaje, FecCap, IdUsuaCap, IdEstatus, IdConvenio, IdCiclo, Promedio, Importe, Descuento, Total)  VALUES ('$IdUsua','3','0',NOW(),'1','8','1000','$rwIdCiclo','0','" . $_reins['Monto'] . "',0,'" . $_reins['Monto'] . "')");
      }
     }

    $sql_cicl = $db->query("SELECT tblc_conceptosdetalle.IdConceptoDetalle, tblc_conceptosdetalle.IdConceptoPlan, tblc_costos_ciclo.Monto, tblc_costos_ciclo.Fecha, tblc_costos_ciclo.Numero, tblc_costos_ciclo.IdCosto FROM tblc_conceptosdetalle Left Join tblc_costos_ciclo ON tblc_costos_ciclo.IdPlan = tblc_conceptosdetalle.IdConceptoPlan WHERE tblc_conceptosdetalle.IdOferta =  '$IdOferta' AND tblc_conceptosdetalle.IdConcepto =  '2' AND tblc_costos_ciclo.IdCiclo =  '$rwIdCiclo'");
    $db->rows($sql_cicl);
    $_ciclo = $db->recorrer($sql_cicl);
    $rwIdConceptoCol = $_ciclo["IdConceptoDetalle"];
    $rwMonto = $_ciclo["Monto"];
    $rwNumero = $_ciclo["Numero"];
    $rwFecha = $_ciclo["Fecha"];
    $rwIdConceptoPlan = $_ciclo["IdConceptoPlan"];


    #Verificamos que exista el pago mensualidad
    $sql_mens = $db->query("SELECT tblp_pagos.IdPago FROM tblp_pagos WHERE tblp_pagos.IdConcepto = '2' AND tblp_pagos.IdUsua =  '$IdUsua' AND tblp_pagos.IdCiclo =  '$rwIdCiclo'");
    $db->rows($sql_mens);
    $_mensu = $db->recorrer($sql_mens);
    if (!isset($_mensu["IdPago"])) {
      $fecha_actual = $rwFecha;
      for ($i = 1; $i <= $rwNumero; $i++) {
        $anio = substr($fecha_actual, 0, 4);

        $insertar = $db->query("INSERT INTO tblp_pagos (IdUsua,Monto,IdEstatus,IdOferta,FecCap,Fecha,IdCiclo,Anio,IdConceptoPlan,IdCampus, Facturar,TipoSolicitud, Capturado, _idEstatus, IdConcepto, TotalPagado, Recargos, Descuento, IdGrupo) VALUES('$IdUsua','$rwMonto','1','$IdOferta',NOW(),'$fecha_actual','$rwIdCiclo','$anio','$rwIdConceptoPlan','$IdCampus','NO-F1','2','1','32','2',0,0,0,'$IdGrupo')");

        $fecha_actual = date("Y-m-d", strtotime($fecha_actual . "+ 1 month"));
      }
      $insertar = $db->query("INSERT INTO tblp_beca (IdUsua, IdConcepto, Porcentaje, FecCap, IdUsuaCap, IdEstatus, IdConvenio, IdCiclo, Promedio, Importe, Descuento, Total)  VALUES ('$IdUsua','2','0',NOW(),'1','8','1000','$rwIdCiclo','0','$rwMonto', 0, '$rwMonto')");
    }
  // }

  

  #Verificamos que no exista el horario personalizado en el periodo escolar seleccionado
  $sql_pers = $db->query("SELECT tblp_personalizado.IdHorario FROM tblp_personalizado WHERE tblp_personalizado.IdUsua =  '$IdUsua' AND tblp_personalizado.IdCiclo =  '$rwIdCiclo'");
  $db->rows($sql_pers);
  $_ciclo = $db->recorrer($sql_pers);
  if(!isset($_ciclo['IdHorario'])){
     $insertar = $db->query("INSERT INTO tblp_personalizado (IdUsua, IdCiclo, IdOferta, FecCap)  VALUES('$IdUsua','$rwIdCiclo','$IdOferta',NOW())");
  }
  $sql_us = $db->query("SELECT tblp_grupo.Dia FROM tblc_usuario Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_usuario.IdGrupo WHERE tblc_usuario.IdUsua = '$IdUsua' ");
  $db->rows($sql_us);
  $datos_us = $db->recorrer($sql_us);
  $Dia = $datos_us['Dia'];
  
  
  $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario._horario = 'P' WHERE tblc_usuario.IdUsua = '$IdUsua'");
  

  $sql_alumno = $db->query("SELECT * FROM tblc_alumnos WHERE tblc_alumnos.IdUsua = '$IdUsua' AND tblc_alumnos.IdCiclo = '$rwIdCiclo' ");
    $db->rows($sql_alumno);
    $_alumno = $db->recorrer($sql_alumno);
    if(!isset($_alumno['IdActivo'])){
      $insertar = $db->query("INSERT INTO tblc_alumnos (IdGrupo, IdCiclo, IdUsua, Grado, Tipo, IdEstatus, FecCap, Valor, Horario) VALUES('$IdGrupo','$rwIdCiclo','$IdUsua','0','R','8',NOW(),1,'P')"); 
  }

  $db->close();

  echo 1;


}


if ($tipoGuardar == "sav_new_alumno_id") {
  $IdCampus = $_POST["IdCampus"];
  $rwIdCiclo = $_POST["IdCiclo"];
  $Tipo = $_POST["Tipo"];
  $IdGrupo = $_POST["IdGrupo"];
  $Matricula = $_POST["Matricula"];
  $Nombre = $_POST["Nombre"];
  $Paterno = $_POST["Paterno"];
  $Materno = $_POST["Materno"];
  $Correo = $_POST["Correo"];


  #Verificamos que la matricula no exista el el sistema
  $sql_mat = $db->query("SELECT tblc_usuario.IdUsua FROM tblc_usuario WHERE tblc_usuario.Usuario =  '$Matricula'");
  $db->rows($sql_mat);
  $_matr = $db->recorrer($sql_mat);
  $_IdUsua = $_matr["IdUsua"];

  if ($_IdUsua) {
    echo 5;
    exit();
  }

  $sql8 = $db->query("SELECT tblp_grupo.IdGrupo, tblp_grupo.IdOferta, tblp_educativa.IdGrado FROM tblp_grupo Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_grupo.IdOferta WHERE tblp_grupo.IdGrupo = '$IdGrupo'");
  $db->rows($sql8);
  $datos81 = $db->recorrer($sql8);
  $IdOferta = $datos81['IdOferta'];
  $_Grado = $datos81['IdGrado'];


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

  if (!$_IdUsua) {
    $pass = 'iudy';
    $pass_php = Password::hash($pass);
    $insertar = $db->query("INSERT INTO tblc_usuario (Nombre, APaterno, AMaterno, Cargo, Correo_institucional, Pass_php, Permisos, FecCap, Foto, Code,IdCampus, IdEstatus, IdOferta, IdGrupo, Usuario, Matricula, Grado)  VALUES ('$Nombre','$Paterno','$Materno','Alumno','$Correo','$pass_php','3',NOW(),'nuevo.png','$pass','$IdCampus','8','$IdOferta','$IdGrupo','$Matricula','$Matricula','$_Grado')");
    $IdUsua = $db->insert_id;
  }



  $insertar = $db->query("DELETE FROM tblc_docalumnos WHERE tblc_docalumnos.IdUsua = '$IdUsua' AND tblc_docalumnos.IdCiclo = '$rwIdCiclo'");
  //$insertar = $db->query("DELETE FROM tblp_beca WHERE tblp_beca.IdUsua = '$IdUsua' AND tblp_beca.IdCiclo = '$rwIdCiclo'");

  #Generamos los pagos de reinscripci贸n
  $sql_reins = $db->query("SELECT tblc_conceptosdetalle.IdConceptoDetalle, tblc_costos_ciclo.IdCosto, tblc_costos_ciclo.Monto, tblc_costos_ciclo.Fecha, tblc_costos_ciclo.Numero, tblc_conceptosdetalle.IdConceptoPlan FROM tblc_conceptosdetalle Left Join tblc_costos_ciclo ON tblc_costos_ciclo.IdPlan = tblc_conceptosdetalle.IdConceptoPlan WHERE tblc_conceptosdetalle.IdOferta =  '$IdOferta' AND tblc_conceptosdetalle.IdConcepto =  '3' AND tblc_costos_ciclo.IdCiclo =  '$rwIdCiclo'");
  while ($_reins = $db->recorrer($sql_reins)) {
    $sql_user1 = $db->query("SELECT tblc_usuario.IdUsua FROM tblc_usuario WHERE tblc_usuario.IdUsua = '$IdUsua'");
    while ($_user1 = $db->recorrer($sql_user1)) {
      $anio = substr($_reins['Fecha'], 0, 4);
      $insertar = $db->query("INSERT INTO tblp_pagos (IdUsua,Monto,IdEstatus,IdOferta,FecCap,Fecha,IdCiclo,Anio,IdConceptoPlan,IdCampus, Facturar,TipoSolicitud, Capturado, _idEstatus, IdConcepto, TotalPagado, Recargos, Descuento, IdGrupo) VALUES('$IdUsua','" . $_reins['Monto'] . "','1','$IdOferta',NOW(),'" . $_reins['Fecha'] . "','$rwIdCiclo','$anio','" . $_reins['IdConceptoPlan'] . "','$IdCampus','NO-F44','2','1','32','3',0,0,0,'$IdGrupo')");
      $insertar = $db->query("INSERT INTO tblc_docalumnos (IdUsua, IdTipoDocumento, Estatus, IdCiclo, Doc, IdGrupo) VALUES ('$IdUsua','103','1','$rwIdCiclo','T','$IdGrupo')");
      $insertar = $db->query("INSERT INTO tblc_docalumnos (IdUsua, IdTipoDocumento, Estatus, IdCiclo, Doc, IdGrupo) VALUES ('$IdUsua','105','1','$rwIdCiclo','T','$IdGrupo')");
      $insertar = $db->query("INSERT INTO tblp_beca (IdUsua, IdConcepto, Porcentaje, FecCap, IdUsuaCap, IdEstatus, IdConvenio, IdCiclo, Promedio)  VALUES ('$IdUsua','3','0',NOW(),'1','1','1000','$rwIdCiclo','0')");
      $insertar = $db->query("INSERT INTO tblp_beca (IdUsua, IdConcepto, Porcentaje, FecCap, IdUsuaCap, IdEstatus, IdConvenio, IdCiclo, Promedio)  VALUES ('$IdUsua','2','0',NOW(),'1','1','1000','$rwIdCiclo','0')");
    }
  }
  $fecha_actual = $rwFecha;
  for ($i = 1; $i <= $rwNumero; $i++) {
    $anio = substr($fecha_actual, 0, 4);

    $sql_user2 = $db->query("SELECT tblc_usuario.IdUsua FROM tblc_usuario WHERE tblc_usuario.IdUsua = '$IdUsua'");
    while ($_user2 = $db->recorrer($sql_user2)) {

      $insertar = $db->query("INSERT INTO tblp_pagos (IdUsua,Monto,IdEstatus,IdOferta,FecCap,Fecha,IdCiclo,Anio,IdConceptoPlan,IdCampus, Facturar,TipoSolicitud, Capturado, _idEstatus, IdConcepto, TotalPagado, Recargos, Descuento, IdGrupo) VALUES('$IdUsua','$rwMonto','1','$IdOferta',NOW(),'$fecha_actual','$rwIdCiclo','$anio','$rwIdConceptoPlan','$IdCampus','NO-F45','2','1','32','2',0,0,0,'$IdGrupo')");
    }
    $fecha_actual = date("Y-m-d", strtotime($fecha_actual . "+ 1 month"));
  }

  if ($Tipo == 'P') {
    $insertar = $db->query("INSERT INTO tblp_personalizado (IdUsua, IdCiclo, IdOferta, FecCap)  VALUES('$IdUsua','$rwIdCiclo','$IdOferta',NOW())");
    $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario._horario = 'P' WHERE tblc_usuario.IdUsua = '$IdUsua'");
  }


  $db->close();

  echo $insertar;
}

if ($tipoGuardar == "sav_prom_alumno_id") {
  $IdUsua = $_POST["IdUsua"];
  $IdAdmin = $_POST["IdAdmin"];

  $sql_us = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.IdUsua = '$IdUsua' ");
  $db->rows($sql_us);
  $_user = $db->recorrer($sql_us);
  $IdOferta = $_user['_idOferta'];
  $IdGrupo = $_user['IdGrupo'];
  $usuario = $_user['Usuario'];

  $sql_mat = $db->query("SELECT * FROM tblh_promedio WHERE tblh_promedio.IdUsua = '$IdUsua' ORDER BY tblh_promedio.CodeModulo ASC ");
  while ($x = $db->recorrer($sql_mat)) {
    $Modulo = $x['IdModulo'];
    $IdCiclo = $x['IdPeriodo'];
    $pro = $x['Promedio'];

    $sql_cal = $db->query("SELECT * FROM tblp_calificacion WHERE tblp_calificacion.IdUsua = '$IdUsua' AND tblp_calificacion.IdModulo = '$Modulo' AND tblp_calificacion.IdOferta = '$IdOferta'");
    $db->rows($sql_cal);
    $_calx = $db->recorrer($sql_cal);
    $IdCal = $_calx['IdCalificacion'];
    //
    if (!$IdCal) {
      $insertar = $db->query("INSERT INTO tblp_calificacion (IdUsua, Usuario, IdOferta, IdModulo, FecCap, Promedio, IdCiclo, IdGrupo, IdTipo, IdEstatus, _idUsuaCap) VALUES('$IdUsua','$usuario','$IdOferta','$Modulo',NOW(),'$pro','$IdCiclo','$IdGrupo','2','10','$IdAdmin')");
    } else {
      $insertar = $db->query("UPDATE tblp_calificacion SET tblp_calificacion.IdEstatus = '10', tblp_calificacion.Promedio = '$pro', tblp_calificacion._idUsuaCap = '$IdAdmin' WHERE tblp_calificacion.IdCalificacion = '$IdCal'");
    }
  }

  $insertar = $db->query("DELETE FROM tblh_promedio WHERE tblh_promedio.IdUsua = '$IdUsua' ");

  if ($insertar) {
    echo 1;
  } else {
    echo 0;
  }
}

if ($tipoGuardar == "del_prom_alumno_id") {
  $IdUsua = $_POST["IdUsua"];

  $insertar = $db->query("DELETE FROM tblh_promedio WHERE tblh_promedio.IdUsua = '$IdUsua' ");

  if ($insertar) {
    echo 1;
  } else {
    echo 0;
  }
}

if ($tipoGuardar == "verificar_clases_user") {
  $IdUsua = $_POST["IdUsua"];
  $IdCiclo = $_POST["IdCiclo"];

  $sql_us = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.IdUsua = '$IdUsua' ");
  $db->rows($sql_us);
  $_user = $db->recorrer($sql_us);
  $IdGrupo = $_user['IdGrupo'];


  $sql_asig = $db->query("SELECT * FROM tblp_asignacion WHERE tblp_asignacion.IdCiclo =  '$IdCiclo' AND tblp_asignacion.IdGrupo = '$IdGrupo' AND tblp_asignacion.Tipo = '2' ");
  while ($_asig = $db->recorrer($sql_asig)) {
    $IdAsignacion = $_asig["IdAsignacion"];
    $IdOferta = $_asig["IdEducativa"];
    $IdModulo = $_asig["IdModulo"];
    $grupo = $_asig["Grupo"];
    $estatus = $_asig["Estatus"];

    $sql_mod = $db->query("SELECT * FROM tblp_moduloalumno WHERE tblp_moduloalumno.IdAsignacion = '$IdAsignacion' AND tblp_moduloalumno.IdUsua = '$IdUsua' ");
    $db->rows($sql_mod);
    $_modx = $db->recorrer($sql_mod);
    if (!$_modx['IdModuloAlumno']) {
      $insertar = $db->query("INSERT INTO tblp_moduloalumno (IdEducativa, IdModulo, Grupo, IdUsua, Estatus, FecCap, IdAsignacion, IdGrupo, Activo, IdCiclo) VALUES ('$IdOferta','$IdModulo','$grupo','$IdUsua','$estatus',NOW(),'$IdAsignacion','$IdGrupo', 1, '$IdCiclo')");

      $anio = date("Y");
      $mes = date("m");
      $sqly = $db->query("SELECT tblp_tareas.IdTarea, tblp_tareas.IdAsignacion, tblp_tareas.IdAlumno, tblp_tareas.IdActividadesDocente, tblp_tareas.IdParcialDocente, tblp_actividadesdocente.IdTipoActividad FROM tblp_tareas Left Join tblp_actividadesdocente ON tblp_actividadesdocente.IdActividadesDocente = tblp_tareas.IdActividadesDocente WHERE tblp_tareas.IdAsignacion =  '$IdAsignacion' GROUP BY tblp_tareas.IdActividadesDocente");
      while ($z = $db->recorrer($sqly)) {
        $IdTipoA = $z["IdTipoActividad"];
        $IdActividad = $z["IdActividadesDocente"];
        $IdParcial = $z["IdParcialDocente"];
        $sql1e = $db->query("INSERT INTO tblp_tareas (IdAsignacion, IdAlumno, IdActividadesDocente, IdParcialDocente)  VALUES ('$IdAsignacion','$IdUsua','$IdActividad','$IdParcial')");
      }
    }
  }


  if (isset($insertar)) {
    echo 1;
  } else {
    echo 0;
  }
}


if ($tipoGuardar == "mov_materia_periodo") {
  $IdProm = $_POST["IdProm"];
  $IdCiclo = $_POST["IdCiclo"];
  $IdUsua = $_POST["IdUsua"];
  $Valor = $_POST["Valor"];



  $sql_us = $db->query("SELECT * FROM tblc_ciclo WHERE tblc_ciclo.IdCiclo = '$IdCiclo' ");
  $db->rows($sql_us);
  $_user = $db->recorrer($sql_us);
  $Tipo = $_user['Tipo'];

  if ($Valor == 1) {
    $numero = ($_user['Numero'] + 1);
  } else {
    $numero = ($_user['Numero'] - 1);
  }



  $sql_cal = $db->query("SELECT * FROM tblc_ciclo WHERE tblc_ciclo.Tipo = '$Tipo' AND tblc_ciclo.Numero = '$numero'");
  $db->rows($sql_cal);
  $_calx = $db->recorrer($sql_cal);
  $IdCic = $_calx['IdCiclo'];

  if ($IdCiclo == 0) {
    $sql_cal = $db->query("SELECT tblh_promedio.IdPeriodo FROM tblh_promedio WHERE tblh_promedio.IdUsua =  '$IdUsua' AND tblh_promedio.IdPeriodo <>  '0' ORDER BY tblh_promedio.CodeModulo ASC LIMIT 1");
    $db->rows($sql_cal);
    $_calx = $db->recorrer($sql_cal);
    $IdCic = $_calx['IdPeriodo'];
  }

  $insertar = $db->query("UPDATE tblh_promedio SET tblh_promedio.IdPeriodo = '$IdCic' WHERE tblh_promedio.IdProm = '$IdProm'");

  if ($insertar) {
    echo 1;
  } else {
    echo 0;
  }
}

if ($tipoGuardar == "add_materia_personalizada") {
  $IdUsua = $_POST["IdUsua"];
  $IdGrupo = $_POST["idGrupo"];
  $IdCiclo = $_POST["idCiclo"];
  $IdModulo = $_POST["IdModulo"];

  $porciones = explode("_", $IdModulo);
  $IdModulo = $porciones[0];
  $IdAsignacion =  $porciones[1];


  $sql9 = $db->query("SELECT * FROM tblp_asignacion WHERE tblp_asignacion.IdAsignacion =  '$IdAsignacion' LIMIT 1");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);
  $IdOferta = $datos91["IdEducativa"];
  $grupo = $datos91["Grupo"];
  $estatus = $datos91["Estatus"];

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
  $db->close();
  echo $insertar;
}


if ($tipoGuardar == "add_materia_personalizda_especial") {
  $IdUsua = $_POST["IdUsua"];
  $IdGrupo = $_POST["idGrupo"];
  $IdCiclo = $_POST["idCiclo"];
  $IdModulo = $_POST["IdModulo"];
  $id_modulo = $_POST["id_modulo"];
  $IdAdmin = $_POST["IdAdmin"];


  $porciones = explode("_", $IdModulo);
  $IdModulo = $porciones[0];
  $IdAsignacion =  $porciones[1];

  $sql_asig = $db->query("SELECT tblp_calificacion.IdCalificacion FROM tblp_calificacion WHERE tblp_calificacion.IdUsua = '$IdUsua' AND tblp_calificacion.IdModulo = '$id_modulo' AND tblp_calificacion.Promedio > 5 ");
  $db->rows($sql_asig);
  $_asigb = $db->recorrer($sql_asig);

  if (isset($_asigb["IdCalificacion"])) {
    echo 4;
    die();
  }

  $sql_matx = $db->query("SELECT Count(tblp_moduloalumno.IdModuloAlumno) AS Total FROM tblp_moduloalumno Left Join tblp_asignacion ON tblp_asignacion.IdAsignacion = tblp_moduloalumno.IdAsignacion WHERE tblp_moduloalumno.IdUsua =  '$IdUsua' AND tblp_asignacion.Tipo =  '2' AND tblp_asignacion.IdCiclo =  '$IdCiclo' ");
  $db->rows($sql_matx);
  $_materx = $db->recorrer($sql_matx);
  $_toxx = $_materx["Total"];


  $sql_84 = $db->query("SELECT tblc_modulousuario.IdModUsua FROM tblc_modulousuario WHERE tblc_modulousuario.IdUsua = '$IdAdmin' AND tblc_modulousuario.IdModulo = '84' ");
  $db->rows($sql_84);
  $_84 = $db->recorrer($sql_84);

  if (isset($_84["0"])) {
    $_toxx = 5;
  }


  if ($_toxx >= 7) {
    echo 3;
    die();
  }

  $sql9 = $db->query("SELECT * FROM tblp_asignacion WHERE tblp_asignacion.IdAsignacion =  '$IdAsignacion' LIMIT 1");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);
  $IdOferta = $datos91["IdEducativa"];
  $grupo = $datos91["Grupo"];
  $estatus = $datos91["Estatus"];

  $insertar = $db->query("INSERT INTO tblp_moduloalumno (IdEducativa, IdModulo, Grupo, IdUsua, Estatus, FecCap, IdAsignacion, IdGrupo, Activo, IdCiclo, Especial, _idModulo) VALUES ('$IdOferta','$IdModulo','$grupo','$IdUsua','$estatus',NOW(),'$IdAsignacion','$IdGrupo', 1, '$IdCiclo', 'E', '$id_modulo')");

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

if ($tipoGuardar == "add_sav_rvoe_alumno_id") {
  $IdUsua = $_POST["IdUsua"];
  $IdRvoe = $_POST["IdRvoe"];

  $sql9 = $db->query("SELECT * FROM tblc_rvoe WHERE tblc_rvoe.IdRvoe =  '$IdRvoe'");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);
  $IdOferta = $datos91["IdEducativa"];
  $IdCampus = $datos91["IdCampus"];


  $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario._idRvoe = '$IdRvoe', tblc_usuario._idCampus = '$IdCampus', tblc_usuario._idOferta = '$IdOferta' WHERE tblc_usuario.IdUsua = '$IdUsua' ");

  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "sav_calificacion_rub") {
  $IdDesglose = $_POST["IdDesglose"];
  $Calificacion = $_POST["Calificacion"];

  $sql9 = $db->query("UPDATE tblc_rubrica_detalle_cal SET tblc_rubrica_detalle_cal.Cal = '$Calificacion' WHERE tblc_rubrica_detalle_cal.IdDesglose = '$IdDesglose'");

  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "add_materia_individual") {
  $IdUsua = $_POST["IdUsua"];
  $IdGrupo = $_POST["IdGrupo"];
  $IdCiclo = $_POST["IdCiclo"];
  $IdModulo = $_POST["IdModulo"];

  $porciones = explode("_", $IdModulo);
  $IdModulo = $porciones[0];
  $IdAsignacion =  $porciones[1];


  $sql9 = $db->query("SELECT * FROM tblp_asignacion WHERE tblp_asignacion.IdAsignacion =  '$IdAsignacion' LIMIT 1");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);
  $IdOferta = $datos91["IdEducativa"];
  $grupo = $datos91["Grupo"];
  $estatus = $datos91["Estatus"];

  $insertar = $db->query("INSERT INTO tblp_moduloalumno (IdEducativa, IdModulo, Grupo, IdUsua, Estatus, FecCap, IdAsignacion, IdGrupo, Activo, IdCiclo) VALUES ('$IdOferta','$IdModulo','$grupo','$IdUsua','$estatus',NOW(),'$IdAsignacion','$IdGrupo', 2, '$IdCiclo')");

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

if ($tipoGuardar == "recuperar_cuenta_id") {
  $IdUsua = $_POST["IdUsua"];
  $Institucional = $_POST["Institucional"];
  $Correo = $_POST["Correo"];
  $Password = $_POST["Password"];

  $Password = trim($Password);
  $pass_php = Password::hash($Password);

  $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.Correo = '$Correo', tblc_usuario.Correo_institucional = '$Institucional', tblc_usuario.Pass_php = '$pass_php', tblc_usuario.Code = '$Password' WHERE tblc_usuario.IdUsua = '$IdUsua'");

  $db->close();
  echo $insertar;
}


if ($tipoGuardar == "sav_datos_certificado") {
  $IdUsua = $_POST["IdUsua"];
  $Fecha = $_POST["Fecha"];
  $Folio = $_POST["Folio"];
  $Estudios = $_POST["Estudios"];
  $Entidad = $_POST["Entidad"];
  $Institucion = $_POST["Institucion"];
  $Gestion = $_POST["Gestion"];
  $Escolar = $_POST["Escolar"];
  $Inicio = $_POST["Inicio"];
  $Final = $_POST["Final"];
  $Cct = $_POST["Cct"];

  $insertar = $db->query("UPDATE tblp_certificado SET tblp_certificado.CCT = '$Cct', tblp_certificado.Cer_inicio = '$Inicio', tblp_certificado.Cer_final = '$Final', tblp_certificado.Folio = '$Folio', tblp_certificado.Fecha = '$Fecha', tblp_certificado.Estudios = '$Estudios', tblp_certificado.Entidad = '$Entidad', tblp_certificado.Institucion = '$Institucion', tblp_certificado.Gestion = '$Gestion',tblp_certificado.Escolar = '$Escolar' WHERE tblp_certificado.IdUsua = '$IdUsua'");
  $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario._certificado = '1' WHERE tblc_usuario.IdUsua = '$IdUsua'");

  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "sav_datos_titulo") {
  $IdUsua = $_POST["IdUsua"];
  $Inicio = $_POST["Inicio"];
  $Final = $_POST["Final"];
  $IdTipo = $_POST["IdTipo"];
  $Examen = $_POST["Examen"];
  $Impresion = $_POST["Impresion"];
  $No = $_POST["No"];
  $Foja = $_POST["Foja"];
  $Gestion = $_POST["Gestion"];
  $Escolar = $_POST["Escolar"];

  $insertar = $db->query("UPDATE tblp_certificado SET tblp_certificado.t_inicio = '$Inicio', tblp_certificado.t_final = '$Final', tblp_certificado.t_idTipo = '$IdTipo', tblp_certificado.t_fecha_examen = '$Examen', tblp_certificado.t_impresion = '$Impresion',  tblp_certificado.t_no = '$No',  tblp_certificado.t_foja = '$Foja', tblp_certificado.t_gestion = '$Gestion', tblp_certificado.t_control = '$Escolar' WHERE tblp_certificado.IdUsua = '$IdUsua'");
  $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario._titulo = '1' WHERE tblc_usuario.IdUsua = '$IdUsua'");

  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "sav_datos_acta_titulo") {
  $IdUsua = $_POST["IdUsua"];
  $Hora = $_POST["Hora"];
  $Fecha = $_POST["Fecha"];
  $Aprobo = $_POST["Aprobo"];
  
  $insertar = $db->query("UPDATE tblp_certificado SET tblp_certificado.acta_hora = '$Hora', tblp_certificado.acta_fecha = '$Fecha', tblp_certificado.acta_aprobo = '$Aprobo' WHERE tblp_certificado.IdUsua = '$IdUsua'");


  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "sav_datos_cert_impr") {
  $IdUsua = $_POST["IdUsua"];
  $IdCiclo = $_POST["IdCiclo"];

  $insertar = $db->query("UPDATE tblp_certificado SET tblp_certificado.IdCiclo = '$IdCiclo' WHERE tblp_certificado.IdUsua = '$IdUsua'");


  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "agregar_materias_quivalencia") {
  $IdUsua = $_POST["IdUsua"];
  $IdCiclo = $_POST["IdCiclo"];
  $Grado = $_POST["Grado"];

  $sql9 = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.IdUsua =  '$IdUsua' ");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);
  $IdOferta = $datos91["IdOferta"];
  $IdGrupo = $datos91["IdGrupo"];
  $IdCampus = $datos91["_idCampus"];

  $sql = $db->query("SELECT * FROM tblp_modulo WHERE tblp_modulo.IdEducativa =  '$IdOferta' AND tblp_modulo.IdCampus =  '$IdCampus' AND tblp_modulo.Grado = '$Grado' ");
  while ($x = $db->recorrer($sql)) {
    $insertar = $db->query("INSERT INTO tblh_equivalencia (IdUsua, IdOferta, IdModulo, IdCiclo, FecCap, Tipo) VALUES ('$IdUsua','$IdOferta','" . $x['IdModulo'] . "','$IdCiclo',NOW(),'E')");
  }

  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "agregar_materias_convalidacion") {
  $IdUsua = $_POST["IdUsua"];
  $IdCiclo = $_POST["IdCiclo"];
  $Grado = $_POST["Grado"];

  $sql9 = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.IdUsua =  '$IdUsua' ");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);
  $IdOferta = $datos91["IdOferta"];
  $IdGrupo = $datos91["IdGrupo"];
  $IdCampus = $datos91["_idCampus"];

  $sql = $db->query("SELECT * FROM tblp_modulo WHERE tblp_modulo.IdEducativa =  '$IdOferta' AND tblp_modulo.IdCampus =  '$IdCampus' AND tblp_modulo.Grado = '$Grado' ");
  while ($x = $db->recorrer($sql)) {
    $insertar = $db->query("INSERT INTO tblh_equivalencia (IdUsua, IdOferta, IdModulo, IdCiclo, FecCap, Tipo) VALUES ('$IdUsua','$IdOferta','" . $x['IdModulo'] . "','$IdCiclo',NOW(),'C')");
  }

  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "sav_materias_equiv") {
  $IdUsua = $_POST["IdUsua"];
  $Comentario = $_POST["Comentario"];
  $Fecha = $_POST["Fecha"];
  $IdAdmin = $_POST["IdAdmin"];

  $sql9 = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.IdUsua =  '$IdUsua' ");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);
  $IdOferta = $datos91["IdOferta"];
  $IdGrupo = $datos91["IdGrupo"];
  $IdCampus = $datos91["IdCampus"];
  $Usuario = $datos91["Usuario"];

  $sql = $db->query("SELECT * FROM tblh_equivalencia WHERE tblh_equivalencia.IdUsua =  '$IdUsua' AND tblh_equivalencia.Tipo = 'E'");
  while ($x = $db->recorrer($sql)) {
    $insertar = $db->query("INSERT INTO tblp_calificacion (IdUsua, Usuario, IdOferta, IdModulo, FecCap, Promedio, IdCiclo, IdGrupo, IdTipo, IdEstatus, _obs) VALUES ('$IdUsua','$Usuario','$IdOferta','" . $x['IdModulo'] . "',NOW(),'" . $x['Promedio'] . "','" . $x['IdCiclo'] . "','$IdGrupo','2','10','EQ')");
  }

  $fech = date("Y-m-d");

  $insertar = $db->query("DELETE FROM tblh_equivalencia WHERE tblh_equivalencia.IdUsua = '$IdUsua'");
  $insertar = $db->query("INSERT INTO tblp_seguimiento (IdUsua, Fecha, FecCap, Comentario_control, IdTipoSeguimiento, IdUsua_admin)  VALUES ('$IdUsua','$fech',NOW(),'$Comentario','8','$IdAdmin')");


  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "sav_materias_conva") {
  $IdUsua = $_POST["IdUsua"];
  $Comentario = $_POST["Comentario"];
  $Fecha = $_POST["Fecha"];
  $IdAdmin = $_POST["IdAdmin"];

  $sql9 = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.IdUsua =  '$IdUsua' ");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);
  $IdOferta = $datos91["IdOferta"];
  $IdGrupo = $datos91["IdGrupo"];
  $IdCampus = $datos91["IdCampus"];
  $Usuario = $datos91["Usuario"];

  $sql = $db->query("SELECT * FROM tblh_equivalencia WHERE tblh_equivalencia.IdUsua =  '$IdUsua' AND tblh_equivalencia.Tipo = 'C'");
  while ($x = $db->recorrer($sql)) {
    $insertar = $db->query("INSERT INTO tblp_calificacion (IdUsua, Usuario, IdOferta, IdModulo, FecCap, Promedio, IdCiclo, IdGrupo, IdTipo, IdEstatus, _obs) VALUES ('$IdUsua','$Usuario','$IdOferta','" . $x['IdModulo'] . "',NOW(),'" . $x['Promedio'] . "','" . $x['IdCiclo'] . "','$IdGrupo','2','10','CONV')");
  }

  $fech = date("Y-m-d");

  $insertar = $db->query("DELETE FROM tblh_equivalencia WHERE tblh_equivalencia.IdUsua = '$IdUsua'");
  $insertar = $db->query("INSERT INTO tblp_seguimiento (IdUsua, Fecha, FecCap, Comentario_control, IdTipoSeguimiento, IdUsua_admin)  VALUES ('$IdUsua','$fech',NOW(),'$Comentario','8','$IdAdmin')");


  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "sav_prom_equiva") {
  $IdEquivalencia = $_POST["IdEquivalencia"];
  $Promedio = $_POST["Promedio"];

  $insertar = $db->query("UPDATE tblh_equivalencia SET tblh_equivalencia.Promedio = '$Promedio' WHERE tblh_equivalencia.IdEquivalencia = '$IdEquivalencia'");

  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "del_materia_id") {
  $IdEquivalencia = $_POST["IdEquivalencia"];

  $insertar = $db->query("DELETE FROM tblh_equivalencia WHERE tblh_equivalencia.IdEquivalencia = '$IdEquivalencia'");

  $db->close();
  echo $insertar;
}


if ($tipoGuardar == "del_promedio_materia_id") {
  $IdCalificacion = $_POST["IdCalificacion"];

  $insertar = $db->query("UPDATE tblp_calificacion SET tblp_calificacion.IdEstatus = '24' WHERE tblp_calificacion.IdCalificacion = '$IdCalificacion'");

  $db->close();
  echo $insertar;
}


if ($tipoGuardar == "upd_datos_mater_asignada") {
  $IdMod = $_POST["IdMod"];
  $IdModulo = $_POST["IdModulo"];


  $insertar = $db->query("UPDATE tblp_moduloalumno SET tblp_moduloalumno._idModulo = '$IdModulo' WHERE tblp_moduloalumno.IdModuloAlumno = '$IdMod'");


  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "upd_modalidad_alumno") {
  $IdUsua = $_POST["IdUsua"];
  $Termino = $_POST["Termino"];


  $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.Termino = '$Termino' WHERE tblc_usuario.IdUsua = '$IdUsua'");


  $db->close();
  echo $insertar;
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
