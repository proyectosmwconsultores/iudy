<?php
require('../../php/clases/class.System.php');
$db = new Conexion();
$tipoGuardar = $_POST["TipoGuardar"];


if ($tipoGuardar == "add_reincorpora") {
  $IdUsua = $_POST["IdUsua"];
  $IdCiclo = $_POST["IdCiclo"];
  $IdGrupo = $_POST["IdGrupo"];
  $Nota = $_POST["Nota"];
  $IdAdmin = $_POST["IdAdmin"];
  $IdCampus = $_POST["IdCampus"];
  $Fecha = date("Y-m-d");

  if($IdCampus == 6){
    $sql_grp = $db->query("SELECT * FROM tblp_grupo WHERE tblp_grupo.IdGrupo = '$IdGrupo'");
    $db->rows($sql_grp);
    $datos_grp = $db->recorrer($sql_grp);
    $IdOferta = $datos_grp["IdOferta"];

    $insertar = $db->query("INSERT INTO tblp_reincorporacion (IdUsua, IdGrupo, IdCiclo, Nota, FecCap, _idUsua, IdEstatus, Grado) VALUES ('$IdUsua','$IdGrupo','$IdCiclo','$Nota',NOW(),'$IdAdmin','3','1')");
    $insertar = $db->query("INSERT INTO tblp_seguimiento (IdUsua, IdCiclo, Fecha, FecCap, Comentario_control, IdTipoSeguimiento, IdUsua_admin) VALUES ('$IdUsua','$IdCiclo','$Fecha',NOW(),'$Nota','5','$IdAdmin')");
    $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.IdEstatus = '8', tblc_usuario.IdOferta = '$IdOferta', tblc_usuario.IdCampus = '$IdCampus', tblc_usuario.IdGrupo = '$IdGrupo' WHERE tblc_usuario.IdUsua = '$IdUsua'");
    $insertar = $db->query("UPDATE tblp_pagos SET tblp_pagos.IdEstatus = '1' WHERE tblp_pagos.IdUsua = '$IdUsua'");

      $db->close();
      echo $insertar;
  } else {
    $sql9 = $db->query("SELECT * FROM tblp_reincorporacion WHERE tblp_reincorporacion.IdCiclo = '$IdCiclo' AND  tblp_reincorporacion.IdUsua =  '$IdUsua'");
      $db->rows($sql9);
      $datos91 = $db->recorrer($sql9);
      $IdReincorporacion = $datos91["IdReincorporacion"];

      $sql_gr = $db->query("SELECT * FROM tblc_ciclogrupo WHERE tblc_ciclogrupo.IdCiclo = '$IdCiclo' AND  tblc_ciclogrupo.IdGrupo =  '$IdGrupo'");
      $db->rows($sql_gr);
      $_grp = $db->recorrer($sql_gr);
      $Grado = $_grp["Grado"];

      if(!$Grado){
        $Grado = 1;
      }
      if ($IdReincorporacion) {
        echo 2;
        exit();
      }

      //$insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario._tipoReincorporacion = '$Tipo' WHERE tblc_usuario.IdUsua = '$IdUsua' ");
      $insertar = $db->query("INSERT INTO tblp_reincorporacion (IdUsua, IdGrupo, IdCiclo, Nota, FecCap, _idUsua, IdEstatus, Grado) VALUES ('$IdUsua','$IdGrupo','$IdCiclo','$Nota',NOW(),'$IdAdmin','3','$Grado')");

      $db->close();
      echo $insertar;
  }

  
}

if ($tipoGuardar == "sav_reincorpora_alumno") {
  $IdUsua = $_POST["IdUsua"];
  $IdReincorporacion = $_POST["IdReincorporacion"];
  $Nota = $_POST["Nota"];
  $IdAdmin = $_POST["IdAdmin"];
  $Fecha = $_POST["Fecha"];
  $IdRvoe = $_POST["IdRvoe"];
  
  $sql_rvoe = $db->query("SELECT * FROM tblc_rvoe WHERE tblc_rvoe.IdRvoe = '$IdRvoe' ");
  $db->rows($sql_rvoe);
  $_rvoe = $db->recorrer($sql_rvoe);
  


  $sql9 = $db->query("SELECT * FROM tblp_reincorporacion WHERE tblp_reincorporacion.IdReincorporacion = '$IdReincorporacion' ");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);
  $IdCiclo = $datos91["IdCiclo"];
  $IdGrupo = $datos91["IdGrupo"];
  $Grado = $datos91["Grado"];

  $sql6 = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.IdUsua = '$IdUsua'");
  $db->rows($sql6);
  $datos61 = $db->recorrer($sql6);
  $IdOferta = $datos61["IdOferta"];
  $IdCampus = $datos61["IdCampus"];
  $idEstatus = $datos61["IdEstatus"];
  $_idGrupo = $datos61["IdGrupo"];

 $_diaEspe = '';
  $sql_gpa = $db->query("SELECT tblp_grupo.Dia FROM tblp_grupo WHERE tblp_grupo.IdGrupo =  '$IdGrupo'");
  $db->rows($sql_gpa);
  $_gpx = $db->recorrer($sql_gpa);
  $_dia = $_gpx["Dia"];

  if($_dia == 'P'){
    $_diaEspe = 'P';
    $insertar = $db->query("INSERT INTO tblp_personalizado (IdUsua, IdCiclo, IdOferta, FecCap) VALUES ('$IdUsua','$IdCiclo','$IdOferta',NOW())");
  } else {
    $sql_vAsi = $db->query("SELECT tblp_asignacion.IdAsignacion FROM tblp_asignacion WHERE tblp_asignacion.IdGrupo =  '$_idGrupo' AND tblp_asignacion.IdCiclo =  '$IdCiclo' AND tblp_asignacion.Tipo =  '2' ");
    while ($_vAsig = $db->recorrer($sql_vAsi)) {
      $sqlx = $db->query("DELETE FROM tblp_moduloalumno WHERE tblp_moduloalumno.IdUsua = '$IdUsua' AND tblp_moduloalumno.IdAsignacion = '" . $_vAsig['IdAsignacion'] . "' ");
      $sqly = $db->query("DELETE FROM tblp_asistencia WHERE tblp_asistencia.IdUsua = '$IdUsua' AND tblp_asistencia.IdAsignacion = '" . $_vAsig['IdAsignacion'] . "' ");
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
  }
  $Fecha = date("Y-m-d");
  $insertar = $db->query("INSERT INTO tblp_seguimiento (IdUsua, IdCiclo, Fecha, FecCap, Comentario_control, IdTipoSeguimiento, IdUsua_admin)  VALUES ('$IdUsua','$IdCiclo','$Fecha',NOW(),'$Nota','5','$IdAdmin')");

  $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario._idRvoe = '".$_rvoe["IdRvoe"]."', tblc_usuario._idCampus = '".$_rvoe["IdCampus"]."', tblc_usuario._idOferta = '".$_rvoe["IdEducativa"]."', tblc_usuario.SemCua = '$Grado', tblc_usuario.id_ciclo_reincorporacion = '$IdCiclo', tblc_usuario.IdOferta = '$IdOferta', tblc_usuario.IdEstatus = '8', tblc_usuario.IdCampus = '$IdCampus', tblc_usuario.IdGrupo = '$IdGrupo' WHERE tblc_usuario.IdUsua = '$IdUsua'");
  $insertar = $db->query("UPDATE tblp_reincorporacion SET tblp_reincorporacion.IdGestion = '$IdAdmin', tblp_reincorporacion.Nota = '$Nota', tblp_reincorporacion.IdEstatus = '4' WHERE tblp_reincorporacion.IdReincorporacion = '$IdReincorporacion'");

  if ($idEstatus == 3) {
    $sql_cic = $db->query("SELECT * FROM tblc_ciclo WHERE tblc_ciclo.IdCiclo = '$IdCiclo'");
    $db->rows($sql_cic);
    $_cic = $db->recorrer($sql_cic);
    $codeCiclo = $_cic["Valor"];

    $sql_camp = $db->query("SELECT * FROM tblc_campus WHERE tblc_campus.IdCampus = '$IdCampus'");
    $db->rows($sql_camp);
    $_camp = $db->recorrer($sql_camp);
    $url = $_camp["Link"];
    $codeSede = $_camp["codeSede"];

    if($_dia == 'P'){
      $anio = date("Y");
      $_grpAnio = substr($anio, 2, 2);
    } else {
      $sql_grp = $db->query("SELECT * FROM tblp_grupo WHERE tblp_grupo.IdGrupo = '$IdGrupo'");
      $db->rows($sql_grp);
      $_grp = $db->recorrer($sql_grp);
      $_grpAnio = $_grp["Anio"];
    }
    
    $sql_mat = $db->query("SELECT * FROM tblc_matricula WHERE tblc_matricula.Anio = '$_grpAnio' ORDER BY tblc_matricula.Numero DESC");
    $db->rows($sql_mat);
    $_mat = $db->recorrer($sql_mat);
    $_num = $_mat["Numero"] + 1;
    $code = str_pad($_num, 4, "0", STR_PAD_LEFT);
    $matricula = $_grpAnio . $codeCiclo . $codeSede . $code;


    $insertar = $db->query("INSERT INTO tblc_matricula (Anio, Numero, Matricula, IdUsua, IdOferta, IdGrupo, FecCap)  VALUES ('$_grpAnio','$_num','$matricula','$IdUsua','$IdOferta','$IdGrupo',NOW())");

    $correoInst = $matricula . "@iudysureste.com";
    $pass = "iudy";
    $code = $pass;
    $pass_php = Password::hash($pass);

    $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario.Correo_institucional = '$correoInst', tblc_usuario.Pass_php = '$pass_php', tblc_usuario.Code = '$pass', tblc_usuario.Usuario = '$matricula', tblc_usuario.Matricula = '$matricula', tblc_usuario.IdEstatus = '8' WHERE tblc_usuario.IdUsua = '$IdUsua' ");

  }

  $insertar = $db->query("INSERT INTO tblc_alumnos (IdGrupo, IdCiclo, IdUsua, Grado, Tipo, IdEstatus, FecCap, Valor, Horario) VALUES('$_idGrupo','$IdCiclo','$IdUsua','0','I','8',NOW(),1,'$_diaEspe')"); 
  
  $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario._fecReincorporacion = '$Fecha' WHERE tblc_usuario.IdUsua = '$IdUsua' ");

  $db->close();
  echo $insertar;
}

if ($tipoGuardar == "sav_pagos_reincorpora_alumno") {
  $IdUsua = $_POST["IdUsua"];
  $IdReincorporacion = $_POST["IdReincorporacion"];
  $IdAdmin = $_POST["IdAdmin"];
    

  $sql9 = $db->query("SELECT * FROM tblp_reincorporacion WHERE tblp_reincorporacion.IdReincorporacion = '$IdReincorporacion' ");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);
  $IdCiclo = $datos91["IdCiclo"];
  $IdGrupo = $datos91["IdGrupo"];
  $Grado = $datos91["Grado"];

  $sql6 = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.IdUsua = '$IdUsua'");
  $db->rows($sql6);
  $datos61 = $db->recorrer($sql6);
  $IdOferta = $datos61["IdOferta"];
  $IdCampus = $datos61["IdCampus"];
  $idEstatus = $datos61["IdEstatus"];


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

  #Generamos los pagos de reinscripción
  
  $sql_reins = $db->query("SELECT tblc_conceptosdetalle.IdConceptoDetalle, tblc_costos_ciclo.IdCosto, tblc_costos_ciclo.Monto, tblc_costos_ciclo.Fecha, tblc_costos_ciclo.Numero, tblc_conceptosdetalle.IdConceptoPlan FROM tblc_conceptosdetalle Left Join tblc_costos_ciclo ON tblc_costos_ciclo.IdPlan = tblc_conceptosdetalle.IdConceptoPlan WHERE tblc_conceptosdetalle.IdOferta =  '$IdOferta' AND tblc_conceptosdetalle.IdConcepto =  '3' AND tblc_costos_ciclo.IdCiclo =  '$IdCiclo'");
  while ($_reins = $db->recorrer($sql_reins)) {
    $anio = substr($_reins['Fecha'], 0, 4);
      $insertar = $db->query("INSERT INTO tblp_pagos (IdUsua,Monto,IdEstatus,IdOferta,FecCap,Fecha,IdCiclo,Anio,IdConceptoPlan,IdCampus, Facturar,TipoSolicitud, Capturado, _idEstatus, IdConcepto, TotalPagado, Recargos, Descuento, IdGrupo) VALUES('$IdUsua','" . $_reins['Monto'] . "','1','$IdOferta',NOW(),'" . $_reins['Fecha'] . "','$IdCiclo','$anio','" . $_reins['IdConceptoPlan'] . "','$IdCampus','NO-F38','2','1','32','3',0,0,0,'$IdGrupo')");
      $insertar = $db->query("INSERT INTO tblc_docalumnos (IdUsua, IdTipoDocumento, Estatus, IdCiclo, Doc, IdGrupo) VALUES ('$IdUsua','103','1','$IdCiclo','T','$IdGrupo')");
      $insertar = $db->query("INSERT INTO tblc_docalumnos (IdUsua, IdTipoDocumento, Estatus, IdCiclo, Doc, IdGrupo) VALUES ('$IdUsua','105','1','$IdCiclo','T','$IdGrupo')");
      $insertar = $db->query("INSERT INTO tblp_beca (IdUsua, IdConcepto, Porcentaje, FecCap, IdUsuaCap, IdEstatus, IdConvenio, IdCiclo, Promedio, Importe, Descuento, Total)  VALUES ('$IdUsua','3','0',NOW(),'8','1','1000','$IdCiclo','0','" . $_reins['Monto'] . "',0,'" . $_reins['Monto'] . "')");
      $insertar = $db->query("INSERT INTO tblp_beca (IdUsua, IdConcepto, Porcentaje, FecCap, IdUsuaCap, IdEstatus, IdConvenio, IdCiclo, Promedio, Importe, Descuento, Total)  VALUES ('$IdUsua','2','0',NOW(),'8','1','1000','$IdCiclo','0','$rwMonto',0,'$rwMonto')");
  }


  $fecha_actual = $rwFecha;
  for ($i = 1; $i <= $rwNumero; $i++) {
    $anio = substr($fecha_actual, 0, 4);
    $insertar = $db->query("INSERT INTO tblp_pagos (IdUsua,Monto,IdEstatus,IdOferta,FecCap,Fecha,IdCiclo,Anio,IdConceptoPlan,IdCampus, Facturar,TipoSolicitud, Capturado, _idEstatus, IdConcepto, TotalPagado, Recargos, Descuento, IdGrupo) VALUES('$IdUsua','$rwMonto','1','$IdOferta',NOW(),'$fecha_actual','$IdCiclo','$anio','$rwIdConceptoPlan','$IdCampus','NO-F39','2','1','32','2',0,0,0,'$IdGrupo')");
    
    $fecha_actual = date("Y-m-d", strtotime($fecha_actual . "+ 1 month"));
  }

  $insertar = $db->query("UPDATE tblc_usuario SET tblc_usuario._tipoReincorporacion = 'SI' WHERE tblc_usuario.IdUsua = '$IdUsua' ");

  $db->close();
  echo $insertar;
}


if ($tipoGuardar == "new_reincorpora_user") {
  $IdCiclo = $_POST["IdCiclo"];
  $IdGrupo = $_POST["IdGrupo"];
  $Nota = $_POST["Nota"];
  $IdAdmin = $_POST["IdAdmin"];
  $Nombre = $_POST["Nombre"];
  $Paterno = $_POST["Paterno"];
  $Materno = $_POST["Materno"];
  $Celular = $_POST["Celular"];
  $Correo = $_POST["Correo"];
  $Tipo = $_POST["Tipo"];
  if($Tipo == 'R'){
    $_ini = '';
    $_fin = '';
  $sql_gr = $db->query("SELECT * FROM tblc_ciclogrupo WHERE tblc_ciclogrupo.IdCiclo = '$IdCiclo' AND  tblc_ciclogrupo.IdGrupo =  '$IdGrupo'");
  $db->rows($sql_gr);
  $_grp = $db->recorrer($sql_gr);
  $Grado = $_grp["Grado"];
  } else {
    $Grado = 1;
    $_ini = ", _horario";
    $_fin = ", 'P'";
  }

  $sql_us = $db->query("SELECT * FROM tblp_grupo WHERE tblp_grupo.IdGrupo = '$IdGrupo'");
  $db->rows($sql_us);
  $_user = $db->recorrer($sql_us);
  $IdCampus = $_user["IdCampus"];
  $IdOferta = $_user["IdOferta"];


  $insertar = $db->query("INSERT INTO tblc_usuario (Nombre, APaterno, AMaterno, Cargo, Correo, Permisos, FecCap, Foto, IdCampus, IdEstatus, IdOferta, IdGrupo, id_ciclo_ini $_ini)  VALUES ('$Nombre','$Paterno','$Materno','Alumno','$Correo','3',NOW(),'nuevo.png','$IdCampus','3','$IdOferta','$IdCiclo', '$IdGrupo' $_fin)");
  $IdUsua = $db->insert_id;

  $insertar = $db->query("INSERT INTO tblp_reincorporacion (IdUsua, IdGrupo, IdCiclo, Nota, FecCap, _idUsua, IdEstatus, Grado) VALUES ('$IdUsua','$IdGrupo','$IdCiclo','$Nota',NOW(),'$IdAdmin','3','$Grado')");

  $db->close();
  echo $insertar;
}


if ($tipoGuardar == "add_materia_personalizda_grupo") {
  $IdAsignacion = $_POST["IdAsignacion"];
  $IdCiclo = $_POST["IdCiclo"];
  $IdCampus = $_POST["IdCampus"];
  $IdGrupo = $_POST["IdGrupo"];
  $id_modulo = $_POST["IdMateria"];

  // $sql_verificar = $db->query("SELECT tblp_moduloalumno.IdModuloAlumno FROM tblp_moduloalumno WHERE tblp_moduloalumno._idModulo = '$id_modulo' AND  tblp_moduloalumno.IdAsignacion =  '$IdAsignacion' AND tblp_moduloalumno.IdGrupo = '$IdGrupo' LIMIT 1");
  // $db->rows($sql_verificar);
  // $verificar = $db->recorrer($sql_verificar);
  // if(isset($verificar["IdModuloAlumno"])){
  //   echo 2;
  //   exit();
  // }
  
  $sql9 = $db->query("SELECT * FROM tblp_asignacion WHERE tblp_asignacion.IdAsignacion =  '$IdAsignacion' LIMIT 1");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);
  $IdOferta = $datos91["IdEducativa"];
  $IdModulo = $datos91["IdModulo"];
  $grupo = $datos91["Grupo"];
  $estatus = $datos91["Estatus"];

  $sql_asig = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.IdGrupo = '$IdGrupo' AND tblc_usuario.IdEstatus = '8' ");
  while ($asig = $db->recorrer($sql_asig)) {
    $IdUsua = $asig["IdUsua"];

    $sql_verificar = $db->query("SELECT tblp_moduloalumno.IdModuloAlumno FROM tblp_moduloalumno WHERE tblp_moduloalumno.IdUsua ='$IdUsua' AND tblp_moduloalumno._idModulo = '$id_modulo' AND  tblp_moduloalumno.IdAsignacion =  '$IdAsignacion' ");
    $db->rows($sql_verificar);
    $verificar = $db->recorrer($sql_verificar);
    if(!isset($verificar["IdModuloAlumno"])){

    $insertar = $db->query("INSERT INTO tblp_moduloalumno (IdEducativa, IdModulo, Grupo, IdUsua, Estatus, FecCap, IdAsignacion, IdGrupo, Activo, IdCiclo, Especial, _idModulo) VALUES ('$IdOferta','$IdModulo','$grupo','$IdUsua','$estatus',NOW(),'$IdAsignacion','$IdGrupo', 1, '$IdCiclo', 'E', '$id_modulo')");
  
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


  $db->close();
  echo 1;
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