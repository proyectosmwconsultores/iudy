<?php
require_once('class.System.php');
class Aula
{
    public function get_contenido_parcial($IdAsignacion, $IdParcial)
  {
    $db = new Conexion();
    $semanas = [];

    $IdAsignacion = intval($IdAsignacion);
    $IdParcial    = intval($IdParcial);

    $sql = $db->query("
        SELECT
            ps.IdSemanaDocente,
            ps.Etiqueta_semana,
            ps.NoSemana,

            pa.IdActividadesDocente,
            pa.IdEstatus,
            pa.NomActividad,
            pa.FecIni,
            pa.FecFin,

            ta.TipoActividad,
            p.NoParcial

        FROM tblp_parcialdocente p

        LEFT JOIN tblp_semanadocente ps
            ON p.IdParcialDocente = ps.IdParcialDocente

        LEFT JOIN tblp_actividadesdocente pa
            ON ps.IdSemanaDocente = pa.IdSemanaDocente
            AND ps.IdParcialDocente = pa.IdParcialDocente

        LEFT JOIN tblc_tipoactividad ta
            ON pa.IdTipoActividad = ta.IdTipoActividad

        WHERE
            p.IdAsignacion = $IdAsignacion
            AND p.IdParcialDocente = $IdParcial

        ORDER BY
            ps.NoSemana ASC,
            pa.FecIni ASC
    ");

    while ($row = mysqli_fetch_assoc($sql)) {
      $idSemana = $row['IdSemanaDocente'];

      if (!isset($semanas[$idSemana])) {
        $semanas[$idSemana] = [
          'IdSemanaDocente' => $row['IdSemanaDocente'],
          'Etiqueta_semana' => $row['Etiqueta_semana'],
          'NoParcial' => $row['NoParcial'],
          'NoSemana'        => $row['NoSemana'],
          'actividades'     => []
        ];
      }

      if (!empty($row['IdActividadesDocente'])) {
        $semanas[$idSemana]['actividades'][] = [
          'IdActividadesDocente' => $row['IdActividadesDocente'],
          'IdEstatus'         => $row['IdEstatus'],
          'NomActividad'         => $row['NomActividad'],
          'TipoActividad'        => $row['TipoActividad'],
          'FecIni'               => $row['FecIni'],
          'FecFin'               => $row['FecFin']
        ];
      }
    }

    return $semanas;
  }

  public function get_actividad($IdActividad) {
    $db = new Conexion();
    $get_actividad = [];
    $sql = $db->query("SELECT
	tblp_actividadesdocente.IdActividadesDocente, 
	tblp_actividadesdocente.NomActividad, 
	tblp_actividadesdocente.DesActividad, 
	tblp_actividadesdocente.IdParcialDocente, 
	tblp_actividadesdocente.IdEstatus, 
	tblp_actividadesdocente.Porcentaje, 
	tblp_actividadesdocente.IdAsignacion, 
	tblp_actividadesdocente.FecIni, 
	tblp_actividadesdocente.FecFin, 
	tblp_actividadesdocente.Modalidad, 
	tblp_actividadesdocente.IdSemanaDocente, 
	tblp_actividadesdocente.Tiempo, 
	tblp_actividadesdocente.Ini, 
	tblp_actividadesdocente.Estrategia, 
	tblp_actividadesdocente.Tecnica, 
	tblp_actividadesdocente.Herramienta, 
	tblp_actividadesdocente.Fin, 
	tblp_actividadesdocente.IdRubrica, 
	tblc_tipoactividad.TipoActividad, 
	tblc_estatus.Estatus, 
	tblp_actividadesdocente.IdTipoActividad
FROM
	tblp_actividadesdocente
	LEFT JOIN
	tblc_tipoactividad
	ON 
		tblp_actividadesdocente.IdTipoActividad = tblc_tipoactividad.IdTipoActividad
	LEFT JOIN
	tblc_estatus
	ON 
		tblp_actividadesdocente.IdEstatus = tblc_estatus.IdEstatus
WHERE
	tblp_actividadesdocente.IdActividadesDocente = '$IdActividad' ");
    while($x = $db->recorrer($sql)){
      $get_actividad[] = $x;
    }
    return $get_actividad;
  }

  public function get_tarea_alumno_id($IdUsua, $IdActividad, $IdAsignacion, $IdParcialDocente) {
    $db = new Conexion();

    $sql_parcial = $db->query("SELECT Tipo FROM tblp_parcialdocente WHERE IdParcialDocente = '$IdParcialDocente' ");
    $datos_parcial = $db->recorrer($sql_parcial);
    $sql_act = $db->query("SELECT IdEstatus FROM tblp_actividadesdocente WHERE IdActividadesDocente = '$IdActividad'");
    $datos_act = $db->recorrer($sql_act);

    if (isset($datos_parcial['Tipo'], $datos_act['IdEstatus']) && $datos_parcial['Tipo'] == 'P' && $datos_act['IdEstatus'] == 8 ) {
        $sql_tarea = $db->query("SELECT COUNT(*) AS total FROM tblp_tareas WHERE IdAlumno = '$IdUsua' AND IdAsignacion = '$IdAsignacion' AND IdActividadesDocente = '$IdActividad' AND IdParcialDocente = '$IdParcialDocente' ");
        $datos_tarea = $db->recorrer($sql_tarea);
        if ((int)$datos_tarea['total'] === 0) {
            $insertar = $db->query("INSERT INTO tblp_tareas (IdAsignacion, IdAlumno, IdActividadesDocente, IdParcialDocente) VALUES ('$IdAsignacion','$IdUsua','$IdActividad','$IdParcialDocente')");
        }
    }

    $get_tarea_alumno_id = [];
    $sql = $db->query("SELECT *  FROM tblp_tareas WHERE IdAlumno = '$IdUsua' AND IdAsignacion = '$IdAsignacion' AND IdActividadesDocente = '$IdActividad' AND IdParcialDocente = '$IdParcialDocente' ORDER BY IdTarea ASC ");

    while ($x = $db->recorrer($sql)) {
        $get_tarea_alumno_id[] = $x;
    }

    return $get_tarea_alumno_id;
}

  public function get_docente_id($IdAsignacion) {
    $db = new Conexion();
    $get_docente_id = [];
    $sql = $db->query("SELECT tblp_asignacion.IdUsua, tblp_asignacion.IdModulo FROM tblp_asignacion WHERE tblp_asignacion.IdAsignacion = '$IdAsignacion' AND tblp_asignacion.Tipo = '2' LIMIT 1 ");
    while($x = $db->recorrer($sql)){
      $get_docente_id[] = $x;
    }
    return $get_docente_id;
  }

  public function get_material_id($IdActividad) {
    $db = new Conexion();
    $get_material_id = [];
    $sql = $db->query("SELECT tblp_biblioteca.IdBiblioteca, tblp_biblioteca.Nombre, tblp_biblioteca.Tipo, tblp_biblioteca.IdTema FROM tblp_biblioteca WHERE tblp_biblioteca.IdActividadesDocente =  '$IdActividad' ");
    while($x = $db->recorrer($sql)){
      $get_material_id[] = $x;
    }
    return $get_material_id;
  }

  public function get_parcialdocente_id($IdParcialDocente) {
    $db = new Conexion();
    $get_parcial_id = [];
    $sql = $db->query("SELECT tblp_parcialdocente.Tipo FROM tblp_parcialdocente WHERE tblp_parcialdocente.IdParcialDocente =  '$IdParcialDocente' ");
    while($x = $db->recorrer($sql)){
      $get_parcial_id[] = $x;
    }
    return $get_parcial_id;
  }

  public function get_pagos_id($IdModulo,$IdUsua,$extra) {
    $db = new Conexion();
    $get_pagos_id = [];
    
    $sql = $db->query("SELECT tblp_pagos.IdEstatus FROM tblp_pagos WHERE tblp_pagos.IdUsua = '$IdUsua' AND tblp_pagos.IdModulo = '$IdModulo' AND tblp_pagos.extra = '$extra' ");
    while($x = $db->recorrer($sql)){
      $get_pagos_id[] = $x;
    }
    return $get_pagos_id;
  }

  public function companeros_trabajo($IdAsignacion,$IdUsua) {
    $db = new Conexion();
    $quipo = 0;
    
    $sql_tarea = $db->query("SELECT tblp_moduloalumno.Equipo FROM tblp_moduloalumno WHERE tblp_moduloalumno.IdUsua = '$IdUsua' AND tblp_moduloalumno.IdAsignacion = '$IdAsignacion' ");
    $db->rows($sql_tarea);
    $datos_equipo = $db->recorrer($sql_tarea);
    if(isset($datos_equipo['Equipo'])){
      $quipo = $datos_equipo['Equipo'];
    }
    $companeros = [];
    $sql = $db->query("SELECT tblp_moduloalumno.IdUsua, tblp_moduloalumno.IdAsignacion, tblp_moduloalumno.Equipo, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno FROM tblp_moduloalumno LEFT JOIN tblc_usuario ON tblp_moduloalumno.IdUsua = tblc_usuario.IdUsua WHERE tblp_moduloalumno.IdAsignacion = '$IdAsignacion' AND tblp_moduloalumno.Equipo = '$quipo' ");
    while($x = $db->recorrer($sql)){
      $companeros[] = $x;
    }
    return $companeros;
  }

  public function get_semana_id($IdSemana) {
    $db = new Conexion();
    $get_semana_id = [];
    $sql = $db->query("SELECT * FROM tblp_semanadocente WHERE tblp_semanadocente.IdSemanaDocente = '$IdSemana' ");
    while($x = $db->recorrer($sql)){
      $get_semana_id[] = $x;
    }
    return $get_semana_id;
  }

  public function get_parcial_id($IdAsignacion) {
    $db = new Conexion();
    $get_parcial_id = [];
    $sql = $db->query("SELECT tblp_parcialdocente.IdParcialDocente, tblp_parcialdocente.NoParcial FROM tblp_parcialdocente WHERE tblp_parcialdocente.IdAsignacion = '$IdAsignacion' ORDER BY tblp_parcialdocente.NoParcial ASC");
    while($x = $db->recorrer($sql)){
      $get_parcial_id[] = $x;
    }
    return $get_parcial_id;
  }


  public function get_foro_comentarios($IdActividad)
{
    $db = new Conexion();
    $IdActividad = intval($IdActividad);
    $datos = [];

    $sql = $db->query("
        SELECT fc.*, u.Nombre, u.APaterno, u.AMaterno
        FROM tblp_foro_comentarios fc
        LEFT JOIN tblc_usuario u ON fc.IdAlumno = u.IdUsua
        WHERE fc.IdActividadesDocente = $IdActividad
        AND fc.IdComentarioPadre IS NULL
        AND fc.Estatus = 'Activo'
        ORDER BY fc.FecCap ASC
    ");

    while ($row = mysqli_fetch_assoc($sql)) {
        $datos[] = $row;
    }

    return $datos;
}

public function get_foro_respuestas($IdComentarioPadre)
{
    $db = new Conexion();
    $IdComentarioPadre = intval($IdComentarioPadre);
    $datos = [];

    $sql = $db->query("
        SELECT fc.*, u.Nombre, u.APaterno, u.AMaterno
        FROM tblp_foro_comentarios fc
        LEFT JOIN tblc_usuario u ON fc.IdAlumno = u.IdUsua
        WHERE fc.IdComentarioPadre = $IdComentarioPadre
        AND fc.Estatus = 'Activo'
        ORDER BY fc.FecCap ASC
    ");

    while ($row = mysqli_fetch_assoc($sql)) {
        $datos[] = $row;
    }

    return $datos;
}


}
