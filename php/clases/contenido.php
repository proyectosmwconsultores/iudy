<?php
ob_start();
class Contenido {
  public function get_lst_contenido($IdAsignacion) {
    $db = new Conexion();
    $get_lst_contenido = [];

    $sql = $db->query("SELECT tblp_parcialdocente.IdParcialDocente, tblp_parcialdocente.Titulo, tblp_parcialdocente.NoParcial, tblp_parcialdocente.Tema, tblp_parcialdocente.Objetivo, tblp_semanadocente.IdSemanaDocente, tblp_semanadocente.Etiqueta_semana, tblp_semanadocente.NoSemana, tblp_semanadocente.Avance, tblp_semanadocente.NoLeccion, tblp_semanadocente.Semana, tblp_parcialdocente.FecIni, tblp_parcialdocente.FecFin FROM tblp_parcialdocente Left Join tblp_semanadocente ON tblp_semanadocente.IdParcialDocente = tblp_parcialdocente.IdParcialDocente WHERE tblp_parcialdocente.IdAsignacion =  '$IdAsignacion' ORDER BY tblp_parcialdocente.NoParcial ASC, tblp_semanadocente.NoSemana ASC ");
    while($x = $db->recorrer($sql)){
      $get_lst_contenido[] = $x;
    }
    return $get_lst_contenido;
  }

  public function get_lst_asistencia($IdAsignacion,$IdUsua) {
    $db = new Conexion();
    $get_lst_asistencia = [];

    $sql = $db->query("SELECT
tblp_asistencia.IdAsistencia,
tblp_asistencia.Fecha,
tblp_asistencia.Valor,
tblc_tipo_asistencia.Letra,
tblc_tipo_asistencia.Asistencia,
tblc_tipo_asistencia.Icono,
tblc_tipo_asistencia.IdTipo
FROM
tblp_asistencia
Left Join tblc_tipo_asistencia ON tblc_tipo_asistencia.IdTipo = tblp_asistencia.IdTipo
WHERE
tblp_asistencia.IdAsignacion =  '$IdAsignacion' AND
tblp_asistencia.IdUsua =  '$IdUsua'
ORDER BY
tblp_asistencia.Fecha ASC
");
    while($x = $db->recorrer($sql)){
      $get_lst_asistencia[] = $x;
    }
    return $get_lst_asistencia;
  }

  public function get_lst_info1($IdAsignacion) {
    $db = new Conexion();
    $get_lst_info1 = [];
    $sql = $db->query("SELECT tblp_asignacion.IdAsignacion, tblc_campus.Campus, tblp_educativa.Nombre, tblp_modulo.NombreMod, tblp_modulo.Objetivo, tblp_asignacion.FecIni, tblp_asignacion.FecFin, tblp_asignacion.Fondo FROM tblp_asignacion Left Join tblc_campus ON tblc_campus.IdCampus = tblp_asignacion.IdCampus Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_asignacion.IdEducativa Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo WHERE tblp_asignacion.IdAsignacion =  '$IdAsignacion' AND tblp_asignacion.Tipo = '2'");
    while($x = $db->recorrer($sql)){
      $get_lst_info1[] = $x;
    }
    return $get_lst_info1;
  }

  public function get_lst_info2($IdAsignacion) {
    $db = new Conexion();
    $get_lst_info2 = [];
    $sql = $db->query("SELECT tblp_asignacion.IdAsignacion, tblp_asignacion.IdUsua, tblc_usuario.Nombre, tblc_usuario.AMaterno, tblc_usuario.APaterno, tblc_usuario.Semblanza, tblc_usuario.Foto FROM tblp_asignacion Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_asignacion.IdUsua WHERE tblp_asignacion.IdAsignacion =  '$IdAsignacion' AND tblp_asignacion.Tipo =  '2'");
    while($x = $db->recorrer($sql)){
      $get_lst_info2[] = $x;
    }
    return $get_lst_info2;
  }

  public function get_lst_grupo($IdAsignacion) {
    $db = new Conexion();
    $get_lst_grupo = [];
    $sql = $db->query("SELECT tblp_moduloalumno.IdUsua, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Foto FROM tblp_moduloalumno Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_moduloalumno.IdUsua WHERE tblp_moduloalumno.IdAsignacion =  '$IdAsignacion'");
    while($x = $db->recorrer($sql)){
      $get_lst_grupo[] = $x;
    }
    return $get_lst_grupo;
  }

  public function get_lst_tareas($IdAsignacion) {
    $db = new Conexion();
    $get_lst_tareas = [];
    $sql = $db->query("SELECT tblp_actividadesdocente.IdActividadesDocente, tblp_actividadesdocente.IdParcialDocente, tblp_actividadesdocente.IdSemanaDocente, tblp_actividadesdocente.IdTipoActividad, tblp_actividadesdocente.NomActividad, tblp_actividadesdocente.IdEstatus, tblp_actividadesdocente.FecIni, tblp_actividadesdocente.FecFin, tblp_actividadesdocente.Modalidad, tblp_actividadesdocente.Porcentaje, tblc_estatus.Estatus, tblp_semanadocente.Etiqueta_semana, tblp_semanadocente.NoSemana, tblp_parcialdocente.Titulo, tblp_parcialdocente.NoParcial, tblc_tipoactividad.TipoActividad FROM tblp_actividadesdocente Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblp_actividadesdocente.IdEstatus Left Join tblp_semanadocente ON tblp_semanadocente.IdSemanaDocente = tblp_actividadesdocente.IdSemanaDocente Left Join tblp_parcialdocente ON tblp_parcialdocente.IdParcialDocente = tblp_actividadesdocente.IdParcialDocente Left Join tblc_tipoactividad ON tblc_tipoactividad.IdTipoActividad = tblp_actividadesdocente.IdTipoActividad WHERE tblp_actividadesdocente.IdAsignacion = '$IdAsignacion' AND tblp_actividadesdocente.IdEstatus <> '12' ORDER BY tblp_parcialdocente.NoParcial ASC, tblp_semanadocente.NoSemana ASC, tblp_actividadesdocente.FecIni ASC");
    while($x = $db->recorrer($sql)){
      $get_lst_tareas[] = $x;
    }
    return $get_lst_tareas;
  }

  public function get_lst_prom_id($IdAsignacion,$IdUsua) {
    $db = new Conexion();
    $get_lst_prom_id = [];

    $sql = $db->query("SELECT tblp_calificacion.Promedio FROM tblp_calificacion WHERE tblp_calificacion.IdAsignacion = '$IdAsignacion' AND tblp_calificacion.IdUsua = '$IdUsua'");
    while($x = $db->recorrer($sql)){
      $get_lst_prom_id[] = $x;
    }
    return $get_lst_prom_id;
  }


  public function get_lst_material($idAsignacion) {
    $db = new Conexion();
    $get_recursosApoyo = [];
    $sql = $db->query("SELECT
tblp_biblioteca.IdBiblioteca,
tblp_biblioteca.Nombre,
tblp_biblioteca.Tipo,
tblp_biblioteca.IdTema,
tblp_parcialdocente.Titulo,
tblp_parcialdocente.NoParcial,
tblp_semanadocente.Etiqueta_semana,
tblp_semanadocente.NoSemana,
tblp_actividadesdocente.NomActividad,
tblp_actividadesdocente.IdTipoActividad,
tblp_temas.Descripcion
FROM
tblp_biblioteca
Left Join tblp_actividadesdocente ON tblp_actividadesdocente.IdActividadesDocente = tblp_biblioteca.IdActividadesDocente
Left Join tblp_parcialdocente ON tblp_parcialdocente.IdParcialDocente = tblp_actividadesdocente.IdParcialDocente
Left Join tblp_semanadocente ON tblp_semanadocente.IdSemanaDocente = tblp_actividadesdocente.IdSemanaDocente
Left Join tblp_temas ON tblp_temas.IdTema = tblp_biblioteca.IdTema
WHERE
tblp_biblioteca.IdAsignacion =  '$idAsignacion'
ORDER BY
tblp_parcialdocente.NoParcial ASC,
tblp_semanadocente.NoSemana ASC
");
    while($x = $db->recorrer($sql)){
      $get_recursosApoyo[] = $x;
    }
    return $get_recursosApoyo;
  }

  public function get_lst_cal_id($IdAsignacion,$IdActividad,$IdUsua) {
    $db = new Conexion();
    $get_lst_cal_id = [];
    $sql = $db->query("SELECT tblp_tareas.Calificacion FROM tblp_tareas WHERE tblp_tareas.IdAsignacion = '$IdAsignacion' AND tblp_tareas.IdActividadesDocente = '$IdActividad' AND tblp_tareas.IdAlumno= '$IdUsua'");
    while($x = $db->recorrer($sql)){
      $get_lst_cal_id[] = $x;
    }
    return $get_lst_cal_id;
  }

  public function get_lst_actividades($IdParcial,$IdSemana) {
    $db = new Conexion();
    $get_lst_actividades = [];
    $sql = $db->query("SELECT tblp_actividadesdocente.IdActividadesDocente, tblp_actividadesdocente.IdTipoActividad, tblp_actividadesdocente.NomActividad, tblp_actividadesdocente.IdSemanaDocente, tblc_tipoactividad.TipoActividad FROM tblp_actividadesdocente Left Join tblc_tipoactividad ON tblc_tipoactividad.IdTipoActividad = tblp_actividadesdocente.IdTipoActividad WHERE tblp_actividadesdocente.IdParcialDocente =  '$IdParcial' AND tblp_actividadesdocente.IdSemanaDocente =  '$IdSemana' AND tblp_actividadesdocente.IdEstatus <> 12 ORDER BY tblp_actividadesdocente.FecIni ASC ");
    while($x = $db->recorrer($sql)){
      $get_lst_actividades[] = $x;
    }
    return $get_lst_actividades;
  }

  public function get_lst_docs($IdActividad) {
    $db = new Conexion();
    $get_lst_docs = [];
    $sql = $db->query("SELECT tblp_biblioteca.IdBiblioteca, tblp_biblioteca.Nombre, tblp_biblioteca.Tipo, tblp_biblioteca.IdTema FROM tblp_biblioteca WHERE tblp_biblioteca.IdActividadesDocente =  '$IdActividad' ");
    while($x = $db->recorrer($sql)){
      $get_lst_docs[] = $x;
    }
    return $get_lst_docs;
  }

  public function get_lst_tema($IdSemana) {
    $db = new Conexion();
    $get_lst_tema = [];

    $sql = $db->query("SELECT tblp_semanadocente.NoSemana, tblp_semanadocente.Semana, tblp_semanadocente.Temas, tblp_semanadocente.Nombre, tblp_semanadocente.Code FROM tblp_semanadocente WHERE tblp_semanadocente.IdSemanaDocente =  '$IdSemana'");
    while($x = $db->recorrer($sql)){
      $get_lst_tema[] = $x;
    }
    return $get_lst_tema;
  }

  public function get_lst_tema_id($IdSemana) {
    $db = new Conexion();
    $get_lst_tema_id = [];

    $sql = $db->query("SELECT tblp_semanadocente.NoSemana, tblp_semanadocente.Etiqueta_semana, tblp_semanadocente.Tematica, tblp_semanadocente.Semana, tblp_semanadocente.Temas, tblp_semanadocente.Nombre, tblp_semanadocente.Code FROM tblp_semanadocente WHERE tblp_semanadocente.IdSemanaDocente =  '$IdSemana'");
    while($x = $db->recorrer($sql)){
      $get_lst_tema_id[] = $x;
    }
    return $get_lst_tema_id;
  }

  public function get_lst_equipo($IdUsua,$IdAsignacion) {
    $db = new Conexion();
    $get_lst_equipo = [];
    $sql9 = $db->query("SELECT tblp_moduloalumno.Equipo FROM tblp_moduloalumno WHERE tblp_moduloalumno.IdUsua =  '$IdUsua' AND tblp_moduloalumno.IdAsignacion = '$IdAsignacion'");
    $db->rows($sql9);
    $datos91 = $db->recorrer($sql9);
    $Equipo = $datos91['Equipo'];

    $sql = $db->query("SELECT
tblp_moduloalumno.IdUsua,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.Correo,
tblc_usuario.Foto
FROM
tblp_moduloalumno
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_moduloalumno.IdUsua
WHERE
tblp_moduloalumno.IdAsignacion =  '$IdAsignacion' AND
tblp_moduloalumno.Equipo =  '$Equipo'
");
    while($x = $db->recorrer($sql)){
      $get_lst_equipo[] = $x;
    }
    return $get_lst_equipo;
  }

  public function get_id_tarea($IdActividad,$IdParcial,$IdUsua) {
    $db = new Conexion();
    $get_id_tarea = [];
    $sql = $db->query("SELECT tblp_tareas.FecFinal, tblp_tareas.IdTarea FROM tblp_tareas WHERE tblp_tareas.IdAlumno = '$IdUsua' AND tblp_tareas.IdActividadesDocente = '$IdActividad' AND tblp_tareas.IdParcialDocente = '$IdParcial' LIMIT 1");
    while($x = $db->recorrer($sql)){
      $get_id_tarea[] = $x;
    }
    return $get_id_tarea;
  }

  public function get_lst_actividad($IdActividad) {
    $db = new Conexion();
    $get_lst_actividad = [];

    $sql = $db->query("SELECT tblp_actividadesdocente.IdActividadesDocente, tblp_actividadesdocente.IdRubrica, tblp_actividadesdocente.Estrategia, tblp_actividadesdocente.Tecnica, tblp_actividadesdocente.Herramienta, tblp_actividadesdocente.IdTipoActividad, tblp_actividadesdocente.NomActividad, tblp_actividadesdocente.DesActividad, tblp_actividadesdocente.Porcentaje, tblp_actividadesdocente.FecIni, tblp_actividadesdocente.FecFin, tblp_actividadesdocente.Modalidad, tblp_actividadesdocente.IdEstatus, tblp_actividadesdocente.Ini, tblp_actividadesdocente.IdSemanaDocente, tblp_actividadesdocente.Fin, tblp_actividadesdocente.Tiempo, tblc_tipoactividad.TipoActividad, tblc_estatus.Estatus FROM tblp_actividadesdocente Left Join tblc_tipoactividad ON tblc_tipoactividad.IdTipoActividad = tblp_actividadesdocente.IdTipoActividad Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblp_actividadesdocente.IdEstatus WHERE tblp_actividadesdocente.IdActividadesDocente =  '$IdActividad' ORDER BY tblp_actividadesdocente.FecIni ASC ");
    while($x = $db->recorrer($sql)){
      $get_lst_actividad[] = $x;
    }
    return $get_lst_actividad;
  }

  public function get_examIni($IdAsig,$IdParcialDoc,$IdActividadDoc,$IdUsua,$IdTarea) {
    $db = new Conexion();
    $gdaExInic = [];
    $sql = $db->query("SELECT * FROM tblp_examusuario WHERE tblp_examusuario.IdAsignacion = '$IdAsig' AND tblp_examusuario.IdParcialDocente = '$IdParcialDoc' AND tblp_examusuario.IdActividadesDocente = '$IdActividadDoc' AND tblp_examusuario.IdUsua = '$IdUsua' AND tblp_examusuario.IdTarea = '$IdTarea' LIMIT 1");
    while($x = $db->recorrer($sql)){
      $gdaExInic[] = $x;
    }
    return $gdaExInic;
  }

  public function get_pregunExa($IdExamU,$IdAsig,$IdActividadDoc) {
    $db = new Conexion();
    $get_pregunExa = [];
    $sql = $db->query("SELECT tblp_examresultado.IdResultado, tblp_examresultado.IdPregunta, tblp_exampregunta.Pregunta, tblp_exampregunta.Tipo, tblp_exampregunta.Anio, tblp_exampregunta.Mes, tblp_exampregunta.Imagen  FROM tblp_examresultado Left Join tblp_exampregunta ON tblp_exampregunta.IdPregunta = tblp_examresultado.IdPregunta WHERE tblp_examresultado.IdExamenUsuario = '$IdExamU' AND tblp_examresultado.IdAsignacion = '$IdAsig' AND tblp_examresultado.IdActividadesDocente = '$IdActividadDoc' AND tblp_examresultado.Valor IS NULL LIMIT 1 ");
    // $sql = $db->query("SELECT tblp_examresultado.IdResultado, tblp_examresultado.IdPregunta, tblp_exampregunta.Pregunta, tblp_exampregunta.Tipo, tblp_exampregunta.Imagen  FROM tblp_examresultado Left Join tblp_exampregunta ON tblp_exampregunta.IdPregunta = tblp_examresultado.IdPregunta WHERE tblp_examresultado.IdExamenUsuario = '$IdExamU' AND tblp_examresultado.IdAsignacion = '$IdAsig' AND tblp_examresultado.IdActividadesDocente = '$IdActividadDoc' AND tblp_examresultado.Valor IS NULL order BY RAND() LIMIT 1 ");
    while($x = $db->recorrer($sql)){
      $get_pregunExa[] = $x;
    }
    return $get_pregunExa;
  }

  public function get_RespLusa($IdExamU,$IdAsig,$IdActividadDoc) {
    $db = new Conexion();
    $sql = $db->query("SELECT Count(tblp_examresultado.IdResultado) AS Contestadas FROM tblp_examresultado WHERE tblp_examresultado.IdExamenUsuario =  '$IdExamU' AND tblp_examresultado.IdAsignacion =  '$IdAsig' AND tblp_examresultado.IdActividadesDocente =  '$IdActividadDoc' AND tblp_examresultado.Valor IS NOT NULL");
    while($x = $db->recorrer($sql)){
      $gdalConstc[] = $x;
    }
    return $gdalConstc;
  }

  public function get_respuestaE($IdPregunta) {
    $db = new Conexion();
    $get_respuestaE = [];
    $sql = $db->query("SELECT * FROM tblp_examrespuesta WHERE tblp_examrespuesta.IdPregunta ='$IdPregunta' ");
    while($x = $db->recorrer($sql)){
      $get_respuestaE[] = $x;
    }
    return $get_respuestaE;
  }

  public function get_validar_mat($IdAsignacion, $IdUsua) {
    $db = new Conexion();

    $sql1 = $db->query("SELECT tblp_moduloalumno.IdModuloAlumno FROM tblp_moduloalumno WHERE tblp_moduloalumno.IdAsignacion =  '$IdAsignacion' AND tblp_moduloalumno.IdUsua =  '$IdUsua' ");
    $db->rows($sql1);
    $datos2 = $db->recorrer($sql1);
    $IdMod = $datos2["IdModuloAlumno"];
    if(!$IdMod){
      header("Location:clase.php?toks=9");
    }
  }


  public function get_addPregunEx($IdAsig,$IdParcialDoc,$IdActividadDoc,$IdExamU,$IdUsua,$IdTarea,$idLeccion) {
    $db = new Conexion();
    $sql9 = $db->query("SELECT tblp_actividadesdocente.Tiempo FROM tblp_actividadesdocente WHERE tblp_actividadesdocente.IdActividadesDocente =  '$IdActividadDoc'");
    $db->rows($sql9);
    $datos91 = $db->recorrer($sql9);
    $Tiempo = $datos91['Tiempo'];
    if($Tiempo){
    $noP = 0;

    $sql7 = $db->query("SELECT tblp_exampregunta.IdPregunta FROM tblp_exampregunta WHERE tblp_exampregunta.IdAsignacion = '$IdAsig' AND tblp_exampregunta.IdActividadesDocente = '$IdActividadDoc' AND tblp_exampregunta.IdParcialDocente = '$IdParcialDoc'");
    while($x = $db->recorrer($sql7)){ $noP = ($noP + 1);
      $IdPreg = $x["IdPregunta"];
      $insertar = $db->query("INSERT INTO tblp_examresultado (IdUsua, IdAsignacion, IdExamenUsuario, IdParcialDocente, IdActividadesDocente, IdPregunta)VALUES('$IdUsua','$IdAsig','$IdExamU','$IdParcialDoc','$IdActividadDoc','$IdPreg')");
    }
     $min =date("i-s");
     $anio = date("Y");
     $mes = date("m");
     $dia = date("d");
     $hora = date("G") + $Tiempo;
     if($hora > 24){ $dia = $dia + 1; $hora =  ($hora - 24);  }

     $ini =date("Y-m-d G-i-s");
     $fin =date("Y-m-$dia $hora-i-s");

     $insertar = $db->query("UPDATE tblp_examusuario SET tblp_examusuario.IdEstatus = '8',  tblp_examusuario.FecIni = '$ini', tblp_examusuario.FecFin = '$fin', tblp_examusuario.NoPregunta = '$noP' WHERE tblp_examusuario.IdExamenUsua = '$IdExamU'");
     echo "<script type='text/javascript'>window.location='mi_examen.php?idAsignacion=$IdAsig&idLeccion=$idLeccion';</script>";
     exit();
   } else {
     echo "<script type='text/javascript'>window.location='mis_clases.php';</script>";
     exit();
   }
  }

}
?>
