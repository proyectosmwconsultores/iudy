<?php
require('../../php/clases/class.System.php');
$db = new Conexion();
$tipoGuardar = $_POST["TipoGuardar"];

if ($tipoGuardar == "sav_new_alumno_id") {
  $IdCampus = $_POST["IdCampus"];
  $IdTipo = $_POST["IdTipo"];
  $Nombre = $_POST["Nombre"];
  $Paterno = $_POST["Paterno"];
  $Materno = $_POST["Materno"];
  $Correo = $_POST["Correo"];
  $IdGrado = $_POST["IdGrado"];
  $IdOferta = $_POST["IdOferta"];
  

  #Verificamos que la matricula no exista el el sistema
  $sql_mat = $db->query("SELECT tblc_usuario.IdUsua FROM tblc_usuario WHERE tblc_usuario.Correo =  '$Correo' AND tblc_usuario.Permisos = '$IdTipo'");
  $db->rows($sql_mat);
  $_matr = $db->recorrer($sql_mat);
  $_IdUsua = $_matr["IdUsua"];

  if($_IdUsua){
    echo 5;
    exit();
  }

  $a1 = '';
  $a2 = '';
  if($IdTipo == 13){ $_tipo = "EXALUMNO"; $a1 = 'E'; }
  if($IdTipo == 14){ $_tipo = "DOCENTE"; $a1 = 'D'; }
  if($IdTipo == 15){ $_tipo = "PUBLICO EN GENERAL"; $a1 = 'P'; }
  
  if($IdGrado == 8){ $IdGrupo = 407; $a2 = 'C';}
  if($IdGrado == 7){ $IdGrupo = 406; $a2 = 'D'; }
  
  $sql_sum = $db->query("SELECT Count(tblc_usuario.IdUsua) AS Total FROM tblc_usuario WHERE tblc_usuario.IdGrupo = '$IdGrupo'");
  $db->rows($sql_sum);
  $_sum = $db->recorrer($sql_sum);
  $_total = $_sum["Total"] + 1;

  $_usuario = str_pad($_total, 5, "0", STR_PAD_LEFT);
  $_usuario = $a2.$a1.$_usuario;


  $pass = 'iudy';
  $pass_php = Password::hash($pass);


  $insertar = $db->query("INSERT INTO tblc_usuario (Nombre, APaterno, AMaterno, Cargo, Correo, Pass_php, Permisos, FecCap, Foto, Code,IdCampus, IdEstatus, _tipo, IdGrupo, Usuario, IdOferta)  VALUES ('$Nombre','$Paterno','$Materno','$_tipo','$Correo','$pass_php','3',NOW(),'nuevo.png','$pass','$IdCampus','8','$IdTipo','$IdGrupo','$_usuario','$IdOferta')");
  $IdUsua = $db->insert_id;

  $db->close();

  echo $insertar;
}

if ($tipoGuardar == "add_materia_especial") {
  $IdUsua = $_POST["IdUsua"];
  $IdGrupo = $_POST["idGrupo"];
  $IdCiclo = $_POST["idCiclo"];
  $rwIdCiclo = $_POST["idCiclo"];
  $IdModulo = $_POST["IdModulo"];
  $idGrado = $_POST["idGrado"];
  $Tipo = $_POST["Tipo"];

  if($idGrado == 7){ $_vc = 'D'; }
  if($idGrado == 8){ $_vc = 'C'; }
  if($idGrado == 9){ $_vc = 'T'; }

  $porciones = explode("_", $IdModulo);
  $IdModulo = $porciones[0];
  $IdAsignacion =  $porciones[1];


  $sql9 = $db->query("SELECT * FROM tblp_asignacion WHERE tblp_asignacion.IdAsignacion =  '$IdAsignacion' LIMIT 1");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);
  $IdOferta = $datos91["IdEducativa"];
  $grupo = $datos91["Grupo"];
  $estatus = $datos91["Estatus"];





  $sql_cicx = $db->query("SELECT * FROM tblp_personalizado WHERE tblp_personalizado.IdUsua =  '$IdUsua' AND tblp_personalizado.IdCiclo = '$IdCiclo' ");
  $db->rows($sql_cicx);
  $_cic = $db->recorrer($sql_cicx);
  $IdHorario = $_cic["IdHorario"];
  if(!$IdHorario){
    $insertar = $db->query("INSERT INTO tblc_docalumnos (IdUsua, IdTipoDocumento, Estatus, IdCiclo, Doc, IdGrupo) VALUES ('$IdUsua','103','1','$rwIdCiclo','$_vc','$IdGrupo')");
    $insertar = $db->query("INSERT INTO tblp_personalizado (IdUsua, IdCiclo, IdOferta, FecCap, Tipo)  VALUES('$IdUsua','$IdCiclo','$IdOferta',NOW(),'$_vc')");


  } 


  $insertar = $db->query("INSERT INTO tblp_moduloalumno (IdEducativa, IdModulo, Grupo, IdUsua, Estatus, FecCap, IdAsignacion, IdGrupo, Activo, IdCiclo, Especial) VALUES ('$IdOferta','$IdModulo','$grupo','$IdUsua','$estatus',NOW(),'$IdAsignacion','$IdGrupo', 1, '$IdCiclo', '$_vc')");

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


if ($tipoGuardar == "generar_pagos_diplomado") {
  $IdUsua = $_POST["IdUsua"];
  $rwIdCiclo = $_POST["idPeriodo"];
  
  $sql_pagos = $db->query("SELECT * FROM tblp_pagos WHERE tblp_pagos.IdUsua =  '$IdUsua'  ");
  $db->rows($sql_pagos);
  $_pagos = $db->recorrer($sql_pagos);
  if(isset($_pagos["IdPago"])){
      echo 55;
      exit();
  }
  

  $sql9 = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.IdUsua =  '$IdUsua' ");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);
  $IdOferta = $datos91["IdOferta"];
  

  #Verificamos que exista el pago reinscripcion
  
  $sql_cicl = $db->query("SELECT tblc_conceptosdetalle.IdConceptoDetalle, tblc_costos_ciclo.IdCosto FROM tblc_conceptosdetalle Left Join tblc_costos_ciclo ON tblc_costos_ciclo.IdPlan = tblc_conceptosdetalle.IdConceptoPlan WHERE tblc_conceptosdetalle.IdOferta =  '$IdOferta' AND tblc_conceptosdetalle.IdConcepto =  '1' AND tblc_costos_ciclo.IdCiclo =  '$rwIdCiclo'");
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

    #Generamos los pagos de reinscripción
    $sql_reins = $db->query("SELECT tblc_conceptosdetalle.IdConceptoDetalle, tblc_costos_ciclo.IdCosto, tblc_costos_ciclo.Monto, tblc_costos_ciclo.Fecha, tblc_costos_ciclo.Numero, tblc_conceptosdetalle.IdConceptoPlan FROM tblc_conceptosdetalle Left Join tblc_costos_ciclo ON tblc_costos_ciclo.IdPlan = tblc_conceptosdetalle.IdConceptoPlan WHERE tblc_conceptosdetalle.IdOferta =  '$IdOferta' AND tblc_conceptosdetalle.IdConcepto =  '1' AND tblc_costos_ciclo.IdCiclo =  '$rwIdCiclo'");
    while ($_reins = $db->recorrer($sql_reins)) {
      $sql_user1 = $db->query("SELECT tblc_usuario.IdUsua FROM tblc_usuario WHERE tblc_usuario.IdUsua = '$IdUsua'");
      while ($_user1 = $db->recorrer($sql_user1)) {
        $anio = substr($_reins['Fecha'], 0, 4);
        $insertar = $db->query("INSERT INTO tblp_pagos (IdUsua,Monto,IdEstatus,IdOferta,FecCap,Fecha,IdCiclo,Anio,IdConceptoPlan,IdCampus, Facturar,TipoSolicitud, Capturado, _idEstatus, IdConcepto, TotalPagado, Recargos, Descuento, IdGrupo) VALUES('$IdUsua','" . $_reins['Monto'] . "','1','$IdOferta',NOW(),'" . $_reins['Fecha'] . "','$rwIdCiclo','$anio','" . $_reins['IdConceptoPlan'] . "','$IdCampus','NO-F56','2','1','32','1',0,0,0,'$IdGrupo')");
      }
    }
    
    $fecha_actual = $rwFecha;
    for ($i = 1; $i <= $rwNumero; $i++) {
      $anio = substr($fecha_actual, 0, 4);
      $sql_user2 = $db->query("SELECT tblc_usuario.IdUsua FROM tblc_usuario WHERE tblc_usuario.IdUsua = '$IdUsua'");
      while ($_user2 = $db->recorrer($sql_user2)) {
        $insertar = $db->query("INSERT INTO tblp_pagos (IdUsua,Monto,IdEstatus,IdOferta,FecCap,Fecha,IdCiclo,Anio,IdConceptoPlan,IdCampus, Facturar,TipoSolicitud, Capturado, _idEstatus, IdConcepto, TotalPagado, Recargos, Descuento, IdGrupo) VALUES('$IdUsua','$rwMonto','1','$IdOferta',NOW(),'$fecha_actual','$rwIdCiclo','$anio','$rwIdConceptoPlan','$IdCampus','NO-F57','2','1','32','2',0,0,0,'$IdGrupo')");
      }
      $fecha_actual = date("Y-m-d", strtotime($fecha_actual . "+ 1 month"));
    }


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